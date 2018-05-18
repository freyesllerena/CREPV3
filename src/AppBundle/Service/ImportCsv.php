<?php

namespace AppBundle\Service;

use AppBundle\Entity\Agent;
use AppBundle\Entity\CampagneBrhp;
use AppBundle\Exception\FormatCsvException;
use AppBundle\Entity\CampagnePnc;
use AppBundle\Entity\Ministere;
use AppBundle\Entity\UniteOrganisationnelle;
use AppBundle\Repository\UniteOrganisationnelleRepository;
use Symfony\Component\Validator\ConstraintViolationList;
use AppBundle\Repository\CampagneBrhpRepository;
use AppBundle\Entity\AgentImport;
use AppBundle\Repository\CampagneRlcRepository;
use AppBundle\Entity\Formation;

class ImportCsv extends BaseManager
{
    private $entete = [
        'matricule',
        'civilite',
        'nom de famille',
        'nom usuel',
        'nom marital',
        'prenom',
        'adresse mail',
        'date de naissance',
        'categorie',
        'corps',
        'date entree dans le corps',
        'grade',
        'date entree dans le grade',
        'echelon',
        'date entree dans echelon',
        'grade emploi',
        'date entree dans le grade emploi',
        'etablissement',
        'departement',
        'affectation sigle',
        'affectation clair',
        'poste occupe',
        'date entree dans le poste occupe',
        'code poste 1',
        'code poste 1',
        'capital dif',
        'capital dif mobilisable',
        'adresse mail shd',
        'adresse mail ah',
        'agent evaluable',
        'motif non evaluation',
        'code UO',
    ];

    private $enteteOrganisation = [
        'code uo',
        'libellé uo',
//         'Code UO mère',
    ];

    private $enteteFormation = [
            'code',
            'libellé',
            'durée',
    ];

    private $repScripts;

    public function init($repScripts)
    {
        $this->repScripts = $repScripts;
    }

    private function convert($filename, $delimiter = ';')
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = null;
        $data = array();
        $ligne = 1;

        if (false !== ($handle = fopen($filename, 'r'))) {
            try {
                // On lit les lignes du fichier tant qu'il y a des lignes non vides
                while (false !== ($row = fgetcsv($handle, null, $delimiter)) && !(1 == count($row) && null === $row[0])) {
                    /** Convertir les données en UTF-8 ***/
                    $row = array_map('utf8_encode', $row);

                    /** Supression des espaces ***/
                    $row = array_map('trim', $row);

                    /** Remplacement des chaines vides par null ***/
                    $row = array_map(['AppBundle\Service\ImportCsv', 'remplaceChainesVidesParNull'], $row);

                    if (!$header) {
                        /** Convertir les entêtes en minuscules **/
                        $row = array_map('mb_strtolower', $row, array_fill(0, count($row), 'UTF-8'));

                        $header = $row;
                    } else {
                        $data[] = array_combine($header, $row);
                    }
                    ++$ligne;
                }
            } catch (\Exception $e) {
                throw new FormatCsvException($ligne);
            } finally {
                fclose($handle);
            }
        }

        return $data;
    }

    /**
     * Importer un fichier d'agents csv.
     *
     * @param CampagnePnc $campagnePnc
     * @param bool        $appeleViaCommande : égale à true si la fonction est appelée à partir d'une commande lancée par un script en asynchrone
     */
    public function importerPopulation(CampagnePnc $campagnePnc, $appeleViaCommande = false)
    {
        // TODO : voir comment gérer la variable entête après l'évolution : maquette par ministère
        if (3 == $campagnePnc->getMinistere()->getId()) { // si c'est le MCC
            $this->entete = array_merge($this->entete, ['Date entree au ministere', 'Type du contrat', 'Date debut du contrat']);
        }

        $uosIndexees = $this->em->getRepository('AppBundle:UniteOrganisationnelle')->getOrganisation($campagnePnc->getMinistere());

        /* @var $campagneRlcRepository CampagneRlcRepository */
        $campagneRlcRepository = $this->em->getRepository('AppBundle:CampagneRlc');

        $filePath = $campagnePnc->getDocPopulation()->getAbsolutePath();

        $contientErreurs = false;
        $nbErreurs = 0;
        $nbErreursMax = 50;

        // Charge le fichier CSV dans $data
        $data = $this->convert($filePath, ';');

        $erreursFormat = $this->validerFormatFichier($data);

        if (!empty($erreursFormat)) {
            $contientErreurs = true;
            $resultatLecture = [
                'erreursFormat' => $erreursFormat,
                'erreursValidation' => null,
                'erreursRattachement' => null,
                'erreursUos' => null,
            ];
            // Si on a des erreurs, on retourne resultatLecture, sinon true
            return $resultatLecture;
        }

        $perimetresRlc = $campagnePnc->getPerimetresRlc();

        $campagnesRlc = array();

        // Tous les périmètres BRHP de la campagne Pnc
        $perimetresBrhp = array();

        foreach ($perimetresRlc as $perimetreRlc) {
            $campagnesRlc[$perimetreRlc->getId()] = $campagneRlcRepository->getCampagneRlc($campagnePnc, $perimetreRlc);

            if (isset($campagnesRlc[$perimetreRlc->getId()])) {
                foreach ($campagnesRlc[$perimetreRlc->getId()]->getPerimetresBrhp() as $perimetreBrhp) {
                    $perimetresBrhp[$perimetreBrhp->getId()] = $perimetreBrhp;
                }
            }
        }

        // Numéro de ligne dans le fichier csv
        $ligne = 2;

        // Ce tableau est utilisé pour traiter les doublons: indexé par les emails des agents
        $agents = array();

        $shds = array();

        // Ce tableau est utilisé pour faire un compte rendu des erreurs
        $erreurs = array();

        $erreursValidation = array();

        $erreursUos = array();

        // On lit ligne par ligne
        foreach ($data as $row) {
            //Si on rencontre une ligne vide, on arrête la lecture
            if (empty($row)) {
                break;
            }
            if (empty($row['adresse mail'])) {
                if (empty(implode('', $row))) {
                    break;
                }
            }

            $agent = new AgentImport();
            $agent
            ->setMatricule($row['matricule'])
            ->setCivilite($row['civilite'])
            ->setNomNaissance($row['nom de famille'])
            ->setNom($row['nom usuel'])
            ->setNomMarital($row['nom marital'])
            ->setPrenom($row['prenom'])
            ->setEmail($row['adresse mail'])
            ->setDateNaissance($row['date de naissance'])
            ->setCategorieAgent($row['categorie'])
            ->setCorps($row['corps'])
            ->setDateEntreeCorps($row['date entree dans le corps'])
            ->setGrade($row['grade'])
            ->setDateEntreeGrade($row['date entree dans le grade'])
            ->setEchelon($row['echelon'])
            ->setDateEntreeEchelon($row['date entree dans echelon'])
             ->setGradeEmploi($row['grade emploi'])
             ->setDateEntreeGradeEmploi($row['date entree dans le grade emploi'])
             ->setEtablissement($row['etablissement'])
             ->setDepartement($row['departement'])
            ->setAffectation($row['affectation sigle'])
            ->setAffectationClairAgent($row['affectation clair'])
            ->setPosteOccupe($row['poste occupe'])
            ->setDateEntreePosteOccupe($row['date entree dans le poste occupe'])
            ->setCodeSirh1($row['code poste 1'])
             ->setCodeSirh2($row['code poste 2'])
            ->setCapitalDif($row['capital dif'])
            ->setCapitalDifMobilisable($row['capital dif mobilisable'])
            ->setEmailShd($row['adresse mail shd'])
            ->setEmailAh($row['adresse mail ah'])
            ->setEvaluable('non' != strtolower($row['agent evaluable']))
            ->setMotifNonEvaluation($row['motif non evaluation'])
            ->setCodeUo($row['code uo'])
            ->setCampagnePnc($campagnePnc);

            // TODO: à déplacer après l'évolution: maquette par ministère
            if (3 == $campagnePnc->getMinistere()->getId()) {
                $agent->setDateDebutContrat($row['date debut du contrat']);
                $agent->setContrat($row['type du contrat']);
                $agent->setDateEntreeMinistere($row['date entree au ministere']);
            }

            $agent->setLigne($ligne);

            if ($row['code uo']) {
                if (isset($uosIndexees[$row['code uo']])) {
                    /* @var $uo UniteOrganisationnelle */
                    $uo = $uosIndexees[$row['code uo']];

                    $agent->setUniteOrganisationnelle($uo);

                    if ($uo->getPerimetreBrhp()) {
                        if (isset($perimetresBrhp[$uo->getPerimetreBrhp()->getId()])) {
                            $agent->setPerimetreBrhp($uo->getPerimetreBrhp());
                            $agent->setPerimetreRlc($uo->getPerimetreBrhp()->getPerimetreRlc());
                            /* @var $campagneBrhpRepository CampagneBrhpRepository */
                            $campagneBrhpRepository = $this->em->getRepository('AppBundle:CampagneBrhp');
                            $campagneBrhp = $campagneBrhpRepository->getCampagneBrhp($campagnePnc, $uo->getPerimetreBrhp());
                            $agent->setCampagneBrhp($campagneBrhp);
                            $agent->setCampagneRlc($campagnesRlc[$agent->getPerimetreRlc()->getId()]);
                        }
                    }
                } else {
                    $contientErreurs = true;
                    $erreursUos[$ligne] = ['agent' => $agent, 'message' => 'UO '.$row['code uo'].' non connue'];
                    ++$nbErreurs;
                }
            }

            // Validation de l'agent, et récupération des erreurs
            /* @var $erreurs ConstraintViolationList */
            $erreurs = $this->validator->validate($agent, null, ['importCSV']);

            //Si le tableau des erreurs n'est pas vide
            if ($erreurs->has(0)) {
                $contientErreurs = true;
                $erreursValidation[$ligne] = [$agent, $erreurs, false];
                ++$nbErreurs;

                // On arrête la lecture si le $nbErreursMax est atteint
                if ($nbErreurs > $nbErreursMax) {
                    break;
                }
            }

            // Controle de doublons
            // Si l'agent est en doublon
            if (isset($agents[trim($row['adresse mail'])])) {
                $contientErreurs = true;

                // Soit l'agent est déjà dans le tableau $resultatLecture (Contient des erreurs de validation)
                if (isset($erreursValidation[$ligne])) {
                    $erreursValidation[$ligne][2] = true;
                } else { // Soit l'agent passe la validation, mais il est en doublon
                    $erreursValidation[$ligne] = [$agent, [], true];
                }

                ++$nbErreurs;
                // On arrête la lecture si le $nbErreursMax est atteint
                if ($nbErreurs > $nbErreursMax) {
                    break;
                }
            }

            // le tableau agents est utilisé pour trouver les doublons:
            // il est indexé avec les emails des agents : si on a plusieurs agents avec une adresse nulle, ils sont considérés comme des doublons
            // donc on n'insère dans ce tableau que les agents qui ont une adresse mail
            if ($agent->getEmail()) {
                $agents[$agent->getEmail()] = $agent;
            }

            if (!$contientErreurs && $agent->getEmailShd()) {
                if (isset($shds[$agent->getEmailShd()])) {
                    $shds[$agent->getEmailShd()][] = $agent;
                } else {
                    $shds[$agent->getEmailShd()] = [$agent];
                }
            }

            ++$ligne;
        }

        $resultatLecture = [
            'erreursFormat' => null,
            'erreursValidation' => $erreursValidation,
            'erreursRattachement' => null,
            'erreursUos' => $erreursUos,
        ];

        // Si aucun agent n'est trouvé
        if (!$contientErreurs && empty($agents)) {
            $contientErreurs = true;
            $resultatLecture = [
                'erreursFormat' => ['Aucun agent ne figure dans le fichier.'],
                'erreursValidation' => null,
                'erreursRattachement' => null,
                'erreursUos' => $erreursUos,
            ];

            return $resultatLecture;
        }

        // Si aucune erreur n'est trouvée, on rattache les N+1 et N+2 et on flush
        if (!$contientErreurs) {
            // Si c'est un environnement windows (local) ou si la fonction est appelé par le script qui lance la commande en arrière plan, on rattache et on insère les agents en synchrone
            if ('WIN' === strtoupper(substr(PHP_OS, 0, 3)) || $appeleViaCommande) {
                $this->rattacherShdAhAgent($agents);
                $this->insererAgents($agents);
            } else { // Si c'est un environnement linux, on lance un script en arrière plan qui traite le fichier de population et qui envoie des notifications.
                $commande = 'nohup '.$this->repScripts.'/traiter_fichier_agents.sh '.$campagnePnc->getId().' >/dev/null 2>&1  &';
                exec($commande);
            }
        }

        // Si on a des erreurs, on retourne resultatLecture, sinon true
        return $contientErreurs ? $resultatLecture : true;
    }

    /**
     * Insérer en base le tableau d'agents passé en paramètre.
     *
     * @param array $agents
     *
     * @return array
     */
    private function insererAgents($agents)
    {
        $lotFlushAgent = 5000;
        $i = 1;

        foreach ($agents as $agent) {
            $this->em->persist($agent);

            if (0 == ($i % $lotFlushAgent)) {
                $this->em->flush();
            }
            ++$i;
        }

        $this->em->flush();
    }

    private function rattacherShdAhAgent(&$agents)
    {
        /* @var $agent Agent */
        foreach ($agents as $agent) {
            if ($agent && $agent->getEmailShd()) {
                if (isset($agents[$agent->getEmailShd()])) {
                    $shd = $agents[$agent->getEmailShd()];
                    $agent->setShd($shd);
                } else {
                    $nouvelAgent = new AgentImport();
                    $nouvelAgent->setEmail($agent->getEmailShd())
                ->setCampagnePnc($agent->getCampagnePnc())
                ->setEvaluable(false);
                    $agents[$nouvelAgent->getEmail()] = $nouvelAgent;
                    $agent->setShd($nouvelAgent);
                }
            }

            if ($agent->getEmailAh()) {
                if (isset($agents[$agent->getEmailAh()])) {
                    $ah = $agents[$agent->getEmailAh()];
                    $agent->setAh($ah);
                } else {
                    $nouvelAgent = new AgentImport();
                    $nouvelAgent->setEmail($agent->getEmailAh())
                    ->setCampagnePnc($agent->getCampagnePnc())
                    ->setEvaluable(false);
                    $agents[$nouvelAgent->getEmail()] = $nouvelAgent;
                    $agent->setAh($nouvelAgent);
                }
            }
        }
    }

    private function validerFormatFichier($data)
    {
        $erreurFormatFichier = [];

        // Vérification de la présence de la ligne d'entête
        if (!isset($data[0])) {
            $erreurFormatFichier[] = 'La ligne d\'entête doit être la première ligne du fichier. Elle doit être suivie des lignes données agents.';

            return $erreurFormatFichier;
        }

        $premiereLigne = $data[0];

        $this->entete = array_map('mb_strtolower', $this->entete, array_fill(0, count($this->entete), 'UTF-8'));

        // Vérification de la présence des colonnes attendues
        foreach ($this->entete as $colonne) {
            if (!array_key_exists($colonne, $premiereLigne)) {
                $erreurFormatFichier[] = 'Colonne "'.$colonne.'" manquante.';
            }
        }

        return $erreurFormatFichier;
    }

    public static function remplaceChainesVidesParNull($chaine)
    {
        if ('' == $chaine) {
            return null;
        }

        return $chaine;
    }

    // TODO : à factoriser avec validerFormatFichier
    private function validerFormatFichierOrganisation($data)
    {
        $erreurFormatFichier = [];
        // Vérification de la présence de la ligne d'entête
        if (!isset($data[0])) {
            $erreurFormatFichier[] = 'La ligne d\'entête doit être la première ligne du fichier. Elle doit être suivie des lignes données des unités organisationnelles.';

            return $erreurFormatFichier;
        }

        $premiereLigne = $data[0];

        //$this->entete = array_map("mb_strtolower", $this->entete, array_fill(0, count($this->entete), 'UTF-8'));

        // Vérification de la présence des colonnes attendues
        foreach ($this->enteteOrganisation as $colonne) {
            if (!array_key_exists($colonne, $premiereLigne)) {
                $erreurFormatFichier[] = 'Colonne "'.$colonne.'" manquante.';
            }
        }

        return $erreurFormatFichier;
    }

    public function importerOrganisation($filePath, Ministere $ministere)
    {
        $contientErreurs = false;
        $nbErreurs = 0;
        $nbErreursMax = 50;

        // Charge le fichier CSV dans $data
        $data = $this->convert($filePath, ';');

        $erreursFormat = $this->validerFormatFichierOrganisation($data);

        if (!empty($erreursFormat)) {
            $contientErreurs = true;
            $resultatLecture = [
               'erreursFormat' => $erreursFormat,
               'erreursValidation' => null,
               'erreursRattachement' => null,
           ];
            // Si on a des erreurs, on retourne resultatLecture, sinon true
            return $resultatLecture;
        }

        // Numéro de ligne dans le fichier csv
        $ligne = 2;

        // Ce tableau est utilisé pour traiter les doublons: indexé par les codes des UO
        $uos = array();

//        $codesUosMeres = array ();

        // Ce tableau est utilisé pour faire un compte rendu des erreurs
        $erreurs = array();

        $erreursValidation = array();

        // On lit ligne par ligne
        foreach ($data as $row) {
            //Si on rencontre une ligne vide, on arrête la lecture
            if (empty($row)) {
                break;
            }

            if (empty($row['code uo'])) {
                if (empty(implode('', $row))) {
                    break;
                }
            }

            $uo = new UniteOrganisationnelle();
            $uo->setCode($row['code uo'])
               ->setLibelle($row['libellé uo'])
//                ->setCodeUniteOrganisationnelleMere($row['Code UO mère'])
               ->setMinistere($ministere)
               ->setLigne($ligne);

            // Controle des doublons
            if (isset($uos[$uo->getCode()])) {
                $contientErreurs = true;
                $erreursValidation[$ligne] = [$uo, [], true];

                ++$nbErreurs;
                // On arrête la lecture si le $nbErreursMax est atteint
                if ($nbErreurs > $nbErreursMax) {
                    break;
                }
            }

            $uos[$uo->getCode()] = $uo;

            // Validation de l'agent, et récupération des erreurs
            $erreurs = $this->validator->validate($uo);

            //Si le tableau des erreurs n'est pas vide
            if ($erreurs->has(0)) {
                $contientErreurs = true;
                $erreursValidation[$ligne] = [$uo, $erreurs, false];
                ++$nbErreurs;

                // On arrête la lecture si le $nbErreursMax est atteint
                if ($nbErreurs > $nbErreursMax) {
                    break;
                }
            }

            ++$ligne;
        }

        $resultatLecture = [
           'erreursFormat' => null,
           'erreursValidation' => $erreursValidation,
           'erreursRattachement' => null,
       ];

        // Si aucune UO n'est trouvée
        if (!$contientErreurs && empty($uos)) {
            $contientErreurs = true;
            $resultatLecture = [
               'erreursFormat' => ['Aucune UO ne figure dans le fichier.'],
               'erreursValidation' => null,
               'erreursRattachement' => null,
           ];

            return $resultatLecture;
        }

        // Si aucune erreur n'est trouvée, on rattache les UO mère / fille
        if (!$contientErreurs) {
            $erreursRattachement = $this->rattacherUosMeres($uos);

            if (empty($erreursRattachement)) {
                $this->mettreAJourUo($ministere, $uos);
            } else {
                $contientErreurs = true;
                $resultatLecture = [
                   'erreursFormat' => null,
                   'erreursValidation' => $erreursValidation,
                   'erreursRattachement' => $erreursRattachement,
               ];
            }
        }

        // Si on a des erreurs, on retourne resultatLecture, sinon true

        return $contientErreurs ? $resultatLecture : true;
    }

    private function rattacherUosMeres(&$uos)
    {
        $erreursRattachement = array();

        /* @var $uo UniteOrganisationnelle */
        foreach ($uos as $uo) {
            if ($uo && $uo->getCodeUniteOrganisationnelleMere()) {
                if (isset($uos[$uo->getCodeUniteOrganisationnelleMere()])) {
                    $uoMere = $uos[$uo->getCodeUniteOrganisationnelleMere()];
                    $uo->setUniteOrganisationnelleMere($uoMere);

                    if ($this->detecterReferencesCirculairesOrganisation($uo)) {
                        $erreursRattachement[] = [$uo, "L'UO ayant pour code ".$uo->getCode().' présente une référence circulaire.'];
                    }
                } else {
                    $erreursRattachement[] = [$uo, "L'UO ayant pour code ".$uo->getCodeUniteOrganisationnelleMere()." doit figurer en tant qu'UO."];
                }
            }
        }

        return $erreursRattachement;
    }

    private function detecterReferencesCirculairesOrganisation(UniteOrganisationnelle $uo)
    {
        if (!$uo->getUniteOrganisationnelleMere()) {
            return false;
        }

        $uoMere = $uo->getUniteOrganisationnelleMere();

        while ($uoMere && $uo->getCode() != $uoMere->getCode()) {
            $uoMere = $uoMere->getUniteOrganisationnelleMere();
        }

        return null !== $uoMere;
    }

    private function mettreAJourUo(Ministere $ministere, $nouvelles_uos)
    {
        /* @var $uoRepository UniteOrganisationnelleRepository */
        $uoRepository = $this->em->getRepository('AppBundle:UniteOrganisationnelle');

        $uoRepository->supprimerReferentiel($ministere);

        $uos = $uoRepository->getOrganisation($ministere, true);

        $anciennes_uos = array();

        // constitution d'un tableau indexé des anciennes uos
        /* @var $ancienne_uo UniteOrganisationnelle */
        foreach ($uos as $ancienne_uo) {
            $anciennes_uos[$ancienne_uo->getCode()] = $ancienne_uo;
        }

        /* @var $nouvelle_uo UniteOrganisationnelle */
        foreach ($nouvelles_uos as $nouvelle_uo) {
            // Si la nouvelle uo existait => on met à jour son libellé, son uo mère, et le flag supprime
            if (isset($anciennes_uos[$nouvelle_uo->getCode()])) {
                $ancienne_uo = $anciennes_uos[$nouvelle_uo->getCode()];
                $ancienne_uo->setLibelle($nouvelle_uo->getLibelle());

                // Ce code présente un bug qd une UO change d'UO mère
//                if($nouvelle_uo->getUniteOrganisationnelleMere()){
//                    $ancienne_uo->setUniteOrganisationnelleMere($nouvelles_uos[$nouvelle_uo->getUniteOrganisationnelleMere()->getCode()]);
//                }

                $ancienne_uo->setSupprime(false);

                $nouvelle_uo = $ancienne_uo;
            }

            //dump($nouvelle_uo);
            $this->em->persist($nouvelle_uo);
        }

        $this->em->flush();
    }

    public function importerReferentielFormation($filePath, Ministere $ministere)
    {
        $contientErreurs = false;
        $nbErreurs = 0;
        $nbErreursMax = 50;

        // Charge le fichier CSV dans $data
        $data = $this->convert($filePath, ';');

        $erreursFormat = $this->validerFormatFichierCsv($data, $this->enteteFormation);

        if (!empty($erreursFormat)) {
            $contientErreurs = true;
            $resultatLecture = [
                'erreursFormat' => $erreursFormat,
                'erreursValidation' => null,
        ];
            // Si on a des erreurs, on retourne resultatLecture, sinon true
            return $resultatLecture;
        }

        // Numéro de ligne dans le fichier csv
        $ligne = 2;

        // Ce tableau est utilisé pour traiter les doublons: indexé par les codes des formations
        $formations = array();

        // Ce tableau est utilisé pour faire un compte rendu des erreurs
        $erreurs = array();

        $erreursValidation = array();

        // On lit ligne par ligne
        foreach ($data as $row) {
            //Si on rencontre une ligne vide, on arrête la lecture
            if (empty($row)) {
                break;
            }

            if (empty($row['code'])) {
                if (empty(implode('', $row))) {
                    break;
                }
            }

            $formation = new Formation();
            $formation->setCode($row['code'])
            ->setLibelle($row['libellé'])
            ->setDuree($row['durée'])
            ->setMinistere($ministere);

            // Controle des doublons
            if (isset($formations[$formation->getCode()])) {
                $contientErreurs = true;
                $erreursValidation[$ligne] = [$formation, [], true];

                ++$nbErreurs;
                // On arrête la lecture si le $nbErreursMax est atteint
                if ($nbErreurs > $nbErreursMax) {
                    break;
                }
            }

            $formations[$formation->getCode()] = $formation;

            // Validation de l'entité, et récupération des erreurs
            $erreurs = $this->validator->validate($formation);

            //Si le tableau des erreurs n'est pas vide
            if ($erreurs->has(0)) {
                $contientErreurs = true;
                $erreursValidation[$ligne] = [$formation, $erreurs, false];
                ++$nbErreurs;

                // On arrête la lecture si le $nbErreursMax est atteint
                if ($nbErreurs > $nbErreursMax) {
                    break;
                }
            }

            ++$ligne;
        }

        $resultatLecture = [
            'erreursFormat' => null,
            'erreursValidation' => $erreursValidation,
    ];

        // Si aucune donnée n'est trouvée
        if (!$contientErreurs && empty($formations)) {
            $contientErreurs = true;
            $resultatLecture = [
                'erreursFormat' => ['Aucune formation ne figure dans le fichier.'],
                'erreursValidation' => null,
        ];

            return $resultatLecture;
        }

        // enregistrement des données en base
        if (!$contientErreurs) {
            /* @var $formationRepository FormationRepository */
            $formationRepository = $this->em->getRepository('AppBundle:Formation');

            $formationRepository->supprimerReferentielFormation($ministere);

            /* @var $formation Formation */
            foreach ($formations as $formation) {
                $this->em->persist($formation);
            }
            $this->em->flush();
        }

        // Si on a des erreurs, on retourne resultatLecture, sinon true

        return $contientErreurs ? $resultatLecture : true;
    }

    private function validerFormatFichierCsv($data, $entete)
    {
        $erreurFormatFichier = [];
        // Vérification de la présence de la ligne d'entête
        if (!isset($data[0])) {
            $erreurFormatFichier[] = 'La ligne d\'entête doit être la première ligne du fichier. Elle doit être suivie des lignes données des unités organisationnelles.';

            return $erreurFormatFichier;
        }

        $premiereLigne = $data[0];

        // Vérification de la présence des colonnes attendues
        foreach ($entete as $colonne) {
            if (!array_key_exists($colonne, $premiereLigne)) {
                $erreurFormatFichier[] = 'Colonne "'.$colonne.'" manquante.';
            }
        }

        return $erreurFormatFichier;
    }
}
