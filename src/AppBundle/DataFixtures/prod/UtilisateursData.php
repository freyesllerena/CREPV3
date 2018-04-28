<?php

namespace AppBundle\DataFixtures\prod;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Utilisateur;
use AppBundle\EnumTypes\EnumCivilite;
use AppBundle\Entity\PerimetreRlc;
use AppBundle\Entity\Rlc;

class UtilisateursData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    protected $nb = 15;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $utilisateur = new Utilisateur();
        $utilisateur->setUsername('karim.ben-daali@finances.gouv.fr')
            ->setEmail('karim.ben-daali@finances.gouv.fr')
            ->setCivilite(EnumCivilite::MONSIEUR)
            ->setNom('BEN DAALI')
            ->setPrenom('Karim')
            ->setRoles(array('ROLE_ADMIN'))
            ->setMinistere($this->getReference('ministere8'))
            ->setEnabled(1)
            ->setPlainPassword('Crep123$');
        $manager->persist($utilisateur);

        $utilisateur = new Utilisateur();
        $utilisateur->setUsername('naim.cheref@finances.gouv.fr')
        ->setEmail('naim.cheref@finances.gouv.fr')
        ->setCivilite(EnumCivilite::MONSIEUR)
        ->setNom('cheref')
        ->setPrenom('naim')
        ->setRoles(array('ROLE_ADMIN'))
        ->setMinistere($this->getReference('ministere8'))
        ->setEnabled(1)
        ->setPlainPassword('Crep123$');
        $manager->persist($utilisateur);

        $utilisateur = new Utilisateur();
        $utilisateur->setUsername('mouhoub.medjahed@prestataire.finances.gouv.fr')
        ->setEmail('mouhoub.medjahed@prestataire.finances.gouv.fr')
        ->setCivilite(EnumCivilite::MONSIEUR)
        ->setNom('Medjahed')
        ->setPrenom('Mouhoub')
        ->setRoles(array('ROLE_ADMIN'))
        ->setMinistere($this->getReference('ministere8'))
        ->setEnabled(1)
        ->setPlainPassword('Crep123$');
        $manager->persist($utilisateur);

        $utilisateur = new Utilisateur();
        $utilisateur->setUsername('innovation.cisirh@finances.gouv.fr')
        ->setEmail('innovation.cisirh@finances.gouv.fr')
        ->setCivilite(EnumCivilite::MONSIEUR)
        ->setNom('Innovation')
        ->setPrenom('Service')
        ->setRoles(array('ROLE_ADMIN'))
        ->setMinistere($this->getReference('ministere8'))
        ->setEnabled(1)
        ->setPlainPassword('Innovation123$');
        $manager->persist($utilisateur);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }

    private function initBaseDeDonnees($manager)
    {
        $nbPerimetreRlc = $this->nb;

        for ($i = 1; $i <= $nbPerimetreRlc; ++$i) {
            $ministere = $this->getReference('ministere'.$i);

            $perimetreRlc = new PerimetreRlc();
            $perimetreRlc->setLibelle('Finances')
            ->setMinistere($ministere);

            $manager->persist($perimetreRlc);
            $this->addReference('perimetreRlc'.$i, $perimetreRlc);
        }

        $manager->flush();

        $nbRlc = $this->nb;

        for ($i = 1; $i <= $nbRlc; ++$i) {
            $ministere = $this->getReference('ministere'.$i);
            $perimetreRlc = $this->getReference('perimetreRlc'.$i);
            $utilisateur = $this->getReference('pnc'.$i);

            $rlc = new Rlc();
            $rlc->setCivilite(EnumCivilite::MONSIEUR)
                ->setEmail('pnc'.$i.'@yopmail.com')
                ->setMinistere($ministere)
                ->setNom('Rlc')
                ->setPrenom('Rlc')
                ->addPerimetresRlc($perimetreRlc)
                ->setUtilisateur($utilisateur);

            $manager->persist($rlc);
            $this->addReference('rlc'.$i, $rlc);
        }

        $manager->flush();
    }
}
