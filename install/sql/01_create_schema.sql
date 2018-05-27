CREATE TABLE crep (id NUMBER(10) NOT NULL,
 shd_signataire_id NUMBER(10) DEFAULT NULL NULL,
 ah_signataire_id NUMBER(10) DEFAULT NULL NULL,
 agent_id NUMBER(10) NOT NULL,
 crep_pdf_id NUMBER(10) DEFAULT NULL NULL,
 crep_papier_id NUMBER(10) DEFAULT NULL NULL,
 mobilite_fonctionnelle_id NUMBER(10) DEFAULT NULL NULL,
 mobilite_geographique_id NUMBER(10) DEFAULT NULL NULL,
 mobilite_externe_id NUMBER(10) DEFAULT NULL NULL,
 motivations_mobilite_id NUMBER(10) DEFAULT NULL NULL,
 modele_crep_id NUMBER(10) DEFAULT NULL NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 demande_form_prof_id NUMBER(10) DEFAULT NULL NULL,
 date_visa_shd TIMESTAMP(0) DEFAULT NULL NULL,
 date_visa_agent TIMESTAMP(0) DEFAULT NULL NULL,
 date_refus_visa TIMESTAMP(0) DEFAULT NULL NULL,
 observations_visa_agent CLOB DEFAULT NULL NULL,
 date_visa_ah TIMESTAMP(0) DEFAULT NULL NULL,
 date_refus_notification TIMESTAMP(0) DEFAULT NULL NULL,
 observations_ah CLOB DEFAULT NULL NULL,
 date_notification TIMESTAMP(0) DEFAULT NULL NULL,
 statut VARCHAR2(255) NOT NULL,
 date_entretien DATE DEFAULT NULL NULL,
 refus_entretien_professionnel NUMBER(1) DEFAULT '0' NOT NULL,
 date_renvoi_agent TIMESTAMP(0) DEFAULT NULL NULL,
 date_renvoi_ah TIMESTAMP(0) DEFAULT NULL NULL,
 motif_renvoi_agent CLOB DEFAULT NULL NULL,
 motif_renvoi_ah CLOB DEFAULT NULL NULL,
 statut_crep_avant_import VARCHAR2(255) DEFAULT NULL NULL,
 notif_absence_visa_agent NUMBER(1) DEFAULT '0' NOT NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 dtype VARCHAR2(255) NOT NULL,
 nom_usage VARCHAR2(255) DEFAULT NULL NULL,
 prenom VARCHAR2(255) DEFAULT NULL NULL,
 date_naissance DATE DEFAULT NULL NULL,
 grade VARCHAR2(255) DEFAULT NULL NULL,
 echelon VARCHAR2(30) DEFAULT NULL NULL,
 corps VARCHAR2(255) DEFAULT NULL NULL,
 cadre_emploi VARCHAR2(255) DEFAULT NULL NULL,
 grade_emploi VARCHAR2(255) DEFAULT NULL NULL,
 emploi_fonctionnel NUMBER(1) DEFAULT NULL NULL,
 affectation_sigle VARCHAR2(255) DEFAULT NULL NULL,
 nom_usage_shd VARCHAR2(255) DEFAULT NULL NULL,
 prenom_shd VARCHAR2(255) DEFAULT NULL NULL,
 corps_shd VARCHAR2(255) DEFAULT NULL NULL,
 grade_shd VARCHAR2(255) DEFAULT NULL NULL,
 poste_occupe_shd VARCHAR2(255) DEFAULT NULL NULL,
 date_entree_poste_occupe_shd DATE DEFAULT NULL NULL,
 description_fonctions CLOB DEFAULT NULL NULL,
 date_prise_fonctions DATE DEFAULT NULL NULL,
 groupe_fonctions VARCHAR2(255) DEFAULT NULL NULL,
 nb_bureaux_direction NUMBER(10) DEFAULT NULL NULL,
 nb_cadres_encadres_a NUMBER(10) DEFAULT NULL NULL,
 nb_total_agents_encadres NUMBER(10) DEFAULT NULL NULL,
 presence_adjoints NUMBER(1) DEFAULT NULL NULL,
 observations_effectifs CLOB DEFAULT NULL NULL,
 commentaire_agent_fonction CLOB DEFAULT NULL NULL,
 doc_annexe_bilan NUMBER(1) DEFAULT NULL NULL,
 contexte_objectifs_passes CLOB DEFAULT NULL NULL,
 autres_dossiers CLOB DEFAULT NULL NULL,
 doc_annexe_objectifs_avenir NUMBER(1) DEFAULT NULL NULL,
 contexte_objectifs_avenir CLOB DEFAULT NULL NULL,
 poste_occupe VARCHAR2(255) DEFAULT NULL NULL,
 date_entree_poste_occupe DATE DEFAULT NULL NULL,
 souhait_evolution_carriere NUMBER(1) DEFAULT NULL NULL,
 type_evolution_carriere CLOB DEFAULT NULL NULL,
 souhait_mobilite NUMBER(1) DEFAULT NULL NULL,
 type_mobilite CLOB DEFAULT NULL NULL,
 souhait_entretien_carriere NUMBER(1) DEFAULT NULL NULL,
 apptitude_niveau_sup NUMBER(1) DEFAULT NULL NULL,
 observation_shd_evolution CLOB DEFAULT NULL NULL,
 comm_agent_evolution CLOB DEFAULT NULL NULL,
 doc_annexe_besoins_formation NUMBER(1) DEFAULT NULL NULL,
 appreciation_generale CLOB DEFAULT NULL NULL,
 evolution_indemnitaire NUMBER(10) DEFAULT NULL NULL,
 proposition_avancement NUMBER(10) DEFAULT NULL NULL,
 matricule_alliance VARCHAR2(255) DEFAULT NULL NULL,
 nom_naissance VARCHAR2(255) DEFAULT NULL NULL,
 date_entree_corps DATE DEFAULT NULL NULL,
 date_entree_grade DATE DEFAULT NULL NULL,
 date_entree_echelon DATE DEFAULT NULL NULL,
 code_poste_alliance VARCHAR2(255) DEFAULT NULL NULL,
 nom_naissance_shd VARCHAR2(255) DEFAULT NULL NULL,
 affectation_sigle_agent VARCHAR2(255) DEFAULT NULL NULL,
 affectation_clair_agent VARCHAR2(255) DEFAULT NULL NULL,
 poste_occupe_agent VARCHAR2(255) DEFAULT NULL NULL,
 date_ent_post_occupe_agent DATE DEFAULT NULL NULL,
 fiche_pose_ajour NUMBER(1) DEFAULT NULL NULL,
 points_actualises_fiche_poste CLOB DEFAULT NULL NULL,
 autres_activites CLOB DEFAULT NULL NULL,
 resultat_autres_activites CLOB DEFAULT NULL NULL,
 obs_agent_objectifs_passes CLOB DEFAULT NULL NULL,
 nb_agents_encadres_a NUMBER(10) DEFAULT NULL NULL,
 nb_agents_encadres_b NUMBER(10) DEFAULT NULL NULL,
 nb_agents_encadres_c NUMBER(10) DEFAULT NULL NULL,
 ctx_obj_annee_en_cours CLOB DEFAULT NULL NULL,
 souhait_ent_carriere_mindef NUMBER(1) DEFAULT NULL NULL,
 souhait_evol_pro_mindef NUMBER(1) DEFAULT NULL NULL,
 capital_dif NUMBER(10) DEFAULT NULL NULL,
 capital_dif_mobilisable NUMBER(10) DEFAULT NULL NULL,
 capital_dif_estimation NUMBER(10) DEFAULT NULL NULL,
 evaluation_globale NUMBER(10) DEFAULT NULL NULL,
 aptitudes_exercer_fonct_supp CLOB DEFAULT NULL NULL,
 appreciation_litterale_shd CLOB DEFAULT NULL NULL,
 categorie_agent VARCHAR2(255) DEFAULT NULL NULL,
 categorie_shd VARCHAR2(255) DEFAULT NULL NULL,
 mobilite_organisme1 CLOB DEFAULT NULL NULL,
 mobilite_organisme2 CLOB DEFAULT NULL NULL,
 mobilite_organisme3 CLOB DEFAULT NULL NULL,
 mobilite_organisme4 CLOB DEFAULT NULL NULL,
 mobilite_poste1 CLOB DEFAULT NULL NULL,
 mobilite_poste2 CLOB DEFAULT NULL NULL,
 mobilite_poste3 CLOB DEFAULT NULL NULL,
 mobilite_poste4 CLOB DEFAULT NULL NULL,
 mobilite_zone_geo1 CLOB DEFAULT NULL NULL,
 mobilite_zone_geo2 CLOB DEFAULT NULL NULL,
 mobilite_zone_geo3 CLOB DEFAULT NULL NULL,
 mobilite_zone_geo4 CLOB DEFAULT NULL NULL,
 affectation_agent VARCHAR2(255) DEFAULT NULL NULL,
 cadre_mise_en_oeuvre_obj CLOB DEFAULT NULL NULL,
 obs_shd_objectifs_evalues CLOB DEFAULT NULL NULL,
 obs_shd_obj_futurs CLOB DEFAULT NULL NULL,
 obs_shd_projet_pro CLOB DEFAULT NULL NULL,
 evol_pro_envisagee CLOB DEFAULT NULL NULL,
 mobilite_fonct_ou_geo CLOB DEFAULT NULL NULL,
 mobilite_interne_ou_externe CLOB DEFAULT NULL NULL,
 souhaitEntretienCarriere_meem CLOB DEFAULT NULL NULL,
 souhait_bilan_carriere CLOB DEFAULT NULL NULL,
 autre_souhait CLOB DEFAULT NULL NULL,
 date_entree_grade_emploi DATE DEFAULT NULL NULL,
 etablissement VARCHAR2(255) DEFAULT NULL NULL,
 departement VARCHAR2(255) DEFAULT NULL NULL,
 code_poste_credo VARCHAR2(255) DEFAULT NULL NULL,
 etablissement_shd VARCHAR2(255) DEFAULT NULL NULL,
 affectation_shd VARCHAR2(255) DEFAULT NULL NULL,
 autres_fonctions_manageriales CLOB DEFAULT NULL NULL,
 obs_agent_objectifs_futurs CLOB DEFAULT NULL NULL,
 obs_agent_projet_pro CLOB DEFAULT NULL NULL,
 matricule VARCHAR2(255) DEFAULT NULL NULL,
 direction_affectation VARCHAR2(255) DEFAULT NULL NULL,
 motif_refus_entretien CLOB DEFAULT NULL NULL,
 acquis_experience_pro CLOB DEFAULT NULL NULL,
 capacite_organiser_animer CLOB DEFAULT NULL NULL,
 capacite_definir_objectifs CLOB DEFAULT NULL NULL,
 type_entretien_carriere NUMBER(10) DEFAULT NULL NULL,
 comm_agent_evolution_pro CLOB DEFAULT NULL NULL,
 autres_besoins_formation CLOB DEFAULT NULL NULL,
 commentaire_agent_formation CLOB DEFAULT NULL NULL,
 autres_points_abordes_shd CLOB DEFAULT NULL NULL,
 autres_points_abordes_agent CLOB DEFAULT NULL NULL,
 precisions_fonctions_agent NUMBER(1) DEFAULT NULL NULL,
 commentaire_fonction_agent CLOB DEFAULT NULL NULL,
 fonction_lien_aptitude_agent NUMBER(1) DEFAULT NULL NULL,
 comm_aptitudes_agent CLOB DEFAULT NULL NULL,
 appreciation_resultats_agent NUMBER(1) DEFAULT NULL NULL,
 commentaire_resultats_agent CLOB DEFAULT NULL NULL,
 alaise_dans_service_agent NUMBER(1) DEFAULT NULL NULL,
 comm_service_agent CLOB DEFAULT NULL NULL,
 souhait_autre_fonction_agent NUMBER(1) DEFAULT NULL NULL,
 comm_souhait_fonction_agent CLOB DEFAULT NULL NULL,
 autres_observations_agent CLOB DEFAULT NULL NULL,
 observations_notif_agent CLOB DEFAULT NULL NULL,
 coordonnees_entretien CLOB DEFAULT NULL NULL,
 qualite_shd VARCHAR2(255) DEFAULT NULL NULL,
 qualite_ah VARCHAR2(255) DEFAULT NULL NULL,
 type_cadence_avancement NUMBER(10) DEFAULT NULL NULL,
 revision_gracieuse NUMBER(1) DEFAULT NULL NULL,
 date_communication_reponse DATE DEFAULT NULL NULL,
 nom_patronymique VARCHAR2(255) DEFAULT NULL NULL,
 affectation VARCHAR2(255) DEFAULT NULL NULL,
 direction VARCHAR2(255) DEFAULT NULL NULL,
 service VARCHAR2(255) DEFAULT NULL NULL,
 bureau VARCHAR2(255) DEFAULT NULL NULL,
 titulaire NUMBER(1) DEFAULT NULL NULL,
 date_entree_ministere TIMESTAMP(0) DEFAULT NULL NULL,
 contrat VARCHAR2(255) DEFAULT NULL NULL,
 date_debut_contrat TIMESTAMP(0) DEFAULT NULL NULL,
 intitule_poste VARCHAR2(255) DEFAULT NULL NULL,
 groupe_rifseep VARCHAR2(255) DEFAULT NULL NULL,
 description_poste_mission CLOB DEFAULT NULL NULL,
 date_entree_poste TIMESTAMP(0) DEFAULT NULL NULL,
 obs_objectifs_passes CLOB DEFAULT NULL NULL,
 nb_agents_encadres NUMBER(10) DEFAULT NULL NULL,
 nb_agents_aevaluer NUMBER(10) DEFAULT NULL NULL,
 NB_AGENTS_EVALUES_AN_PREC NUMBER(10) DEFAULT NULL NULL,
 avis_criteres_appreciations CLOB DEFAULT NULL NULL,
 appreciations_maniere_servir CLOB DEFAULT NULL NULL,
 actions_formation_formateur CLOB DEFAULT NULL NULL,
 objectifs_collectifs_service CLOB DEFAULT NULL NULL,
 contexte_previsible_annee CLOB DEFAULT NULL NULL,
 evolution_poste_actuel CLOB DEFAULT NULL NULL,
 mobilite CLOB DEFAULT NULL NULL,
 comm_agent_sur_entretien CLOB DEFAULT NULL NULL,
 com_agent_carriere_mobilite CLOB DEFAULT NULL NULL,
 duree_entretien VARCHAR2(30) DEFAULT NULL NULL,
 attribution_part_variable NUMBER(10) DEFAULT NULL NULL,
 avis_attr_part_variable CLOB DEFAULT NULL NULL,
 avancement NUMBER(1) DEFAULT NULL NULL,
 explication_avancement CLOB DEFAULT NULL NULL,
 attribution_cia NUMBER(1) DEFAULT NULL NULL,
 explication_attr_cia CLOB DEFAULT NULL NULL,
 avancement_grade NUMBER(1) DEFAULT NULL NULL,
 grade_concerne VARCHAR2(100) DEFAULT NULL NULL,
 avis_sur_avancement_grade NUMBER(10) DEFAULT NULL NULL,
 explication_avance_grade CLOB DEFAULT NULL NULL,
 avancement_corps NUMBER(1) DEFAULT NULL NULL,
 corps_concerne VARCHAR2(100) DEFAULT NULL NULL,
 avis_sur_avancement_corps NUMBER(10) DEFAULT NULL NULL,
 explication_avance_corps CLOB DEFAULT NULL NULL,
 observations_agent_notif CLOB DEFAULT NULL NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_172DD5117E986330 ON crep (shd_signataire_id);
CREATE INDEX IDX_172DD511F46CEB15 ON crep (ah_signataire_id);
CREATE INDEX IDX_172DD5113414710B ON crep (agent_id);
CREATE INDEX IDX_172DD511DFE9B0E4 ON crep (crep_pdf_id);
CREATE INDEX IDX_172DD511DBF6EF95 ON crep (crep_papier_id);
CREATE INDEX IDX_172DD511AA179C35 ON crep (mobilite_fonctionnelle_id);
CREATE INDEX IDX_172DD5117ADBBEC1 ON crep (mobilite_geographique_id);
CREATE INDEX IDX_172DD511A8737F66 ON crep (mobilite_externe_id);
CREATE INDEX IDX_172DD511672877A0 ON crep (motivations_mobilite_id);
CREATE INDEX IDX_172DD511C7B89B9D ON crep (modele_crep_id);
CREATE INDEX IDX_172DD511FC29C013 ON crep (cree_par_id);
CREATE INDEX IDX_172DD511553B2554 ON crep (modifie_par_id);
CREATE INDEX IDX_172DD511CD6405BF ON crep (demande_form_prof_id);
CREATE TABLE objectif_evalue (id NUMBER(10) NOT NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 crep_id NUMBER(10) DEFAULT NULL NULL,
 resultat_obtenu NUMBER(10) DEFAULT NULL NULL,
 libelle CLOB NOT NULL,
 resultat CLOB DEFAULT NULL NULL,
 indicateurs CLOB DEFAULT NULL NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 dtype VARCHAR2(255) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_AEAA8AFBFC29C013 ON objectif_evalue (cree_par_id);
CREATE INDEX IDX_AEAA8AFB553B2554 ON objectif_evalue (modifie_par_id);
CREATE INDEX IDX_AEAA8AFBC235614F ON objectif_evalue (crep_id);
CREATE TABLE agent (id NUMBER(10) NOT NULL,
 utilisateur_id NUMBER(10) DEFAULT NULL NULL,
 crep_id NUMBER(10) DEFAULT NULL NULL,
 campagne_brhp_id NUMBER(10) DEFAULT NULL NULL,
 campagne_rlc_id NUMBER(10) DEFAULT NULL NULL,
 campagne_pnc_id NUMBER(10) DEFAULT NULL NULL,
 shd_id NUMBER(10) DEFAULT NULL NULL,
 ah_id NUMBER(10) DEFAULT NULL NULL,
 perimetre_brhp_id NUMBER(10) DEFAULT NULL NULL,
 perimetre_rlc_id NUMBER(10) DEFAULT NULL NULL,
 unite_organisationnelle_id NUMBER(10) DEFAULT NULL NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 matricule VARCHAR2(255) DEFAULT NULL NULL,
 nom_naissance VARCHAR2(255) DEFAULT NULL NULL,
 nom_marital VARCHAR2(255) DEFAULT NULL NULL,
 date_naissance DATE DEFAULT NULL NULL,
 corps VARCHAR2(255) DEFAULT NULL NULL,
 date_entree_corps DATE DEFAULT NULL NULL,
 grade VARCHAR2(255) DEFAULT NULL NULL,
 date_entree_grade DATE DEFAULT NULL NULL,
 echelon VARCHAR2(30) DEFAULT NULL NULL,
 date_entree_echelon DATE DEFAULT NULL NULL,
 grade_emploi VARCHAR2(255) DEFAULT NULL NULL,
 date_entree_grade_emploi DATE DEFAULT NULL NULL,
 etablissement VARCHAR2(255) DEFAULT NULL NULL,
 departement VARCHAR2(255) DEFAULT NULL NULL,
 affectation VARCHAR2(255) DEFAULT NULL NULL,
 affectation_clair_agent VARCHAR2(255) DEFAULT NULL NULL,
 poste_occupe VARCHAR2(255) DEFAULT NULL NULL,
 date_entree_poste_occupe DATE DEFAULT NULL NULL,
 code_sirh1 VARCHAR2(255) DEFAULT NULL NULL,
 code_sirh2 VARCHAR2(255) DEFAULT NULL NULL,
 capital_dif NUMBER(10) DEFAULT NULL NULL,
 capital_dif_mobilisable NUMBER(10) DEFAULT NULL NULL,
 evaluable NUMBER(1) NOT NULL,
 sans_ah NUMBER(1) DEFAULT '0' NOT NULL,
 motif_non_evaluation CLOB DEFAULT NULL NULL,
 categorie_agent VARCHAR2(255) DEFAULT NULL NULL,
 statut_validation VARCHAR2(255) DEFAULT NULL NULL,
 validation_shd NUMBER(1) DEFAULT NULL NULL,
 erreur_signalee VARCHAR2(255) DEFAULT NULL NULL,
 commentaire_validation CLOB DEFAULT NULL NULL,
 code_uo VARCHAR2(255) DEFAULT NULL NULL,
 ajoute_manuellement NUMBER(1) NOT NULL,
 titulaire NUMBER(1) DEFAULT NULL NULL,
 date_entree_ministere DATE DEFAULT NULL NULL,
 contrat VARCHAR2(255) DEFAULT NULL NULL,
 date_debut_contrat DATE DEFAULT NULL NULL,
 civilite VARCHAR2(255) DEFAULT NULL NULL,
 nom VARCHAR2(255) DEFAULT NULL NULL,
 prenom VARCHAR2(255) DEFAULT NULL NULL,
 email VARCHAR2(255) NOT NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 dtype VARCHAR2(255) NOT NULL,
 email_shd VARCHAR2(255) DEFAULT NULL NULL,
 email_ah VARCHAR2(255) DEFAULT NULL NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_268B9C9DFB88E14F ON agent (utilisateur_id);
CREATE INDEX IDX_268B9C9DC235614F ON agent (crep_id);
CREATE INDEX IDX_268B9C9D185EAC77 ON agent (campagne_brhp_id);
CREATE INDEX IDX_268B9C9D293A30F9 ON agent (campagne_rlc_id);
CREATE INDEX IDX_268B9C9D1E32C292 ON agent (campagne_pnc_id);
CREATE INDEX IDX_268B9C9DB8729E36 ON agent (shd_id);
CREATE INDEX IDX_268B9C9D5E26A2E ON agent (ah_id);
CREATE INDEX IDX_268B9C9DBC37F552 ON agent (perimetre_brhp_id);
CREATE INDEX IDX_268B9C9D91A7789F ON agent (perimetre_rlc_id);
CREATE INDEX IDX_268B9C9D6F589C5C ON agent (unite_organisationnelle_id);
CREATE INDEX IDX_268B9C9DFC29C013 ON agent (cree_par_id);
CREATE INDEX IDX_268B9C9D553B2554 ON agent (modifie_par_id);
CREATE INDEX IDX_268B9C9DE7927C74 ON agent (email);
CREATE TABLE crep_ac_comp_trans (id NUMBER(10) NOT NULL,
 crep_ac_id NUMBER(10) NOT NULL,
 libelle CLOB DEFAULT NULL NULL,
 niveauAcquis NUMBER(10) DEFAULT NULL NULL,
 observations CLOB DEFAULT NULL NULL,
 dtype VARCHAR2(255) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_DCBD22999A75E2B2 ON crep_ac_comp_trans (crep_ac_id);
CREATE TABLE formation_demandee_agent (id NUMBER(10) NOT NULL,
 crep_id NUMBER(10) DEFAULT NULL NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 dif NUMBER(1) NOT NULL,
 libelle VARCHAR2(255) NOT NULL,
 typologie CLOB DEFAULT NULL NULL,
 code VARCHAR2(255) DEFAULT NULL NULL,
 niveau_same NUMBER(10) DEFAULT NULL NULL,
 priorite NUMBER(10) NOT NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_35B0BC7FC235614F ON formation_demandee_agent (crep_id);
CREATE INDEX IDX_35B0BC7FFC29C013 ON formation_demandee_agent (cree_par_id);
CREATE INDEX IDX_35B0BC7F553B2554 ON formation_demandee_agent (modifie_par_id);
CREATE TABLE crep_mcc_comp_trans (id NUMBER(10) NOT NULL,
 competence_transverse_id NUMBER(10) NOT NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 crep_mcc_id NUMBER(10) NOT NULL,
 niveauAcquis NUMBER(10) DEFAULT NULL NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 dtype VARCHAR2(255) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_35911C3885ECD9A8 ON crep_mcc_comp_trans (competence_transverse_id);
CREATE INDEX IDX_35911C38FC29C013 ON crep_mcc_comp_trans (cree_par_id);
CREATE INDEX IDX_35911C38553B2554 ON crep_mcc_comp_trans (modifie_par_id);
CREATE INDEX IDX_35911C38E55F8D83 ON crep_mcc_comp_trans (crep_mcc_id);
CREATE UNIQUE INDEX UNIQ_35911C38E55F8D8385ECD9A8 ON crep_mcc_comp_trans (crep_mcc_id,
 competence_transverse_id);
CREATE TABLE mobilite_geographique (id NUMBER(10) NOT NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 region VARCHAR2(255) DEFAULT NULL NULL,
 departement VARCHAR2(255) DEFAULT NULL NULL,
 ville VARCHAR2(255) DEFAULT NULL NULL,
 priorite NUMBER(10) DEFAULT NULL NULL,
 description CLOB DEFAULT NULL NULL,
 annee_depart VARCHAR2(255) DEFAULT NULL NULL,
 choix NUMBER(1) DEFAULT NULL NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_90AA162FC29C013 ON mobilite_geographique (cree_par_id);
CREATE INDEX IDX_90AA162553B2554 ON mobilite_geographique (modifie_par_id);
CREATE TABLE motivations_mobilite (id NUMBER(10) NOT NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 projet_professionnel NUMBER(1) DEFAULT NULL NULL,
 choix NUMBER(1) DEFAULT NULL NULL,
 reorganisation NUMBER(1) DEFAULT NULL NULL,
 rapprochement_familial NUMBER(1) DEFAULT NULL NULL,
 autre CLOB DEFAULT NULL NULL,
 echeance VARCHAR2(255) DEFAULT NULL NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_2C15040DFC29C013 ON motivations_mobilite (cree_par_id);
CREATE INDEX IDX_2C15040D553B2554 ON motivations_mobilite (modifie_par_id);
CREATE TABLE competence_manageriale (id NUMBER(10) NOT NULL,
 libelle CLOB NOT NULL,
 modele_crep VARCHAR2(255) NOT NULL,
 PRIMARY KEY(id));
CREATE TABLE campagne_pnc (id NUMBER(10) NOT NULL,
 ministere_id NUMBER(10) NOT NULL,
 doc_population_id NUMBER(10) DEFAULT NULL NULL,
 ouverte_par_id NUMBER(10) DEFAULT NULL NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 libelle VARCHAR2(255) NOT NULL,
 date_debut_entretien TIMESTAMP(0) DEFAULT NULL NULL,
 dateCloture TIMESTAMP(0) DEFAULT NULL NULL,
 dateDebut TIMESTAMP(0) NOT NULL,
 date_fermeture TIMESTAMP(0) DEFAULT NULL NULL,
 annee_evaluee NUMBER(10) NOT NULL,
 diffusee NUMBER(1) NOT NULL,
 statut VARCHAR2(255) NOT NULL,
 date_ouverture TIMESTAMP(0) DEFAULT NULL NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_B8DF384CAD745416 ON campagne_pnc (ministere_id);
CREATE UNIQUE INDEX UNIQ_B8DF384C9A54AC53 ON campagne_pnc (doc_population_id);
CREATE INDEX IDX_B8DF384CA3FE4415 ON campagne_pnc (ouverte_par_id);
CREATE INDEX IDX_B8DF384CFC29C013 ON campagne_pnc (cree_par_id);
CREATE INDEX IDX_B8DF384C553B2554 ON campagne_pnc (modifie_par_id);
CREATE TABLE campagne_pnc_perimetres_rlc (campagne_pnc_id NUMBER(10) NOT NULL,
 perimetre_rlc_id NUMBER(10) NOT NULL,
 PRIMARY KEY(campagne_pnc_id,
 perimetre_rlc_id));
CREATE INDEX IDX_A2C98FF21E32C292 ON campagne_pnc_perimetres_rlc (campagne_pnc_id);
CREATE INDEX IDX_A2C98FF291A7789F ON campagne_pnc_perimetres_rlc (perimetre_rlc_id);
CREATE TABLE campagne_pnc_document (campagne_pnc_id NUMBER(10) NOT NULL,
 document_id NUMBER(10) NOT NULL,
 PRIMARY KEY(campagne_pnc_id,
 document_id));
CREATE INDEX IDX_333595791E32C292 ON campagne_pnc_document (campagne_pnc_id);
CREATE INDEX IDX_33359579C33F7837 ON campagne_pnc_document (document_id);
CREATE TABLE formation_suivie (id NUMBER(10) NOT NULL,
 crep_id NUMBER(10) DEFAULT NULL NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 date_debut DATE DEFAULT NULL NULL,
 type VARCHAR2(255) DEFAULT NULL NULL,
 libelle VARCHAR2(255) NOT NULL,
 commentaires VARCHAR2(255) DEFAULT NULL NULL,
 annee VARCHAR2(255) DEFAULT NULL NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_B2EA560CC235614F ON formation_suivie (crep_id);
CREATE INDEX IDX_B2EA560CFC29C013 ON formation_suivie (cree_par_id);
CREATE INDEX IDX_B2EA560C553B2554 ON formation_suivie (modifie_par_id);
CREATE TABLE document (id NUMBER(10) NOT NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 nom VARCHAR2(512) NOT NULL,
 path VARCHAR2(1024) NOT NULL,
 brouillon NUMBER(1) NOT NULL,
 checksum CLOB NOT NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 discr VARCHAR2(255) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_D8698A76FC29C013 ON document (cree_par_id);
CREATE INDEX IDX_D8698A76553B2554 ON document (modifie_par_id);
CREATE TABLE formation (id NUMBER(10) NOT NULL,
 ministere_id NUMBER(10) NOT NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 libelle VARCHAR2(255) NOT NULL,
 code VARCHAR2(255) NOT NULL,
 duree DOUBLE PRECISION DEFAULT NULL NULL,
 date_fin_validite TIMESTAMP(0) NOT NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_404021BFAD745416 ON formation (ministere_id);
CREATE INDEX IDX_404021BFFC29C013 ON formation (cree_par_id);
CREATE INDEX IDX_404021BF553B2554 ON formation (modifie_par_id);
CREATE TABLE utilisateur (id NUMBER(10) NOT NULL,
 ministere_id NUMBER(10) NOT NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 username VARCHAR2(180) NOT NULL,
 username_canonical VARCHAR2(180) NOT NULL,
 email VARCHAR2(180) NOT NULL,
 email_canonical VARCHAR2(180) NOT NULL,
 enabled NUMBER(1) NOT NULL,
 salt VARCHAR2(255) DEFAULT NULL NULL,
 last_login TIMESTAMP(0) DEFAULT NULL NULL,
 confirmation_token VARCHAR2(180) DEFAULT NULL NULL,
 password_requested_at TIMESTAMP(0) DEFAULT NULL NULL,
 roles CLOB NOT NULL,
 nom VARCHAR2(255) DEFAULT NULL NULL,
 prenom VARCHAR2(255) DEFAULT NULL NULL,
 civilite VARCHAR2(255) DEFAULT NULL NULL,
 nb_connexion_ko NUMBER(10) DEFAULT NULL NULL,
 locked NUMBER(1) DEFAULT NULL NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 password VARCHAR2(255) DEFAULT NULL NULL,
 PRIMARY KEY(id));
CREATE UNIQUE INDEX UNIQ_1D1C63B392FC23A8 ON utilisateur (username_canonical);
CREATE UNIQUE INDEX UNIQ_1D1C63B3A0D96FBF ON utilisateur (email_canonical);
CREATE UNIQUE INDEX UNIQ_1D1C63B3C05FB297 ON utilisateur (confirmation_token);
CREATE INDEX IDX_1D1C63B3AD745416 ON utilisateur (ministere_id);
CREATE INDEX IDX_1D1C63B3FC29C013 ON utilisateur (cree_par_id);
CREATE INDEX IDX_1D1C63B3553B2554 ON utilisateur (modifie_par_id);
CREATE INDEX IDX_1D1C63B3E7927C74 ON utilisateur (email);
COMMENT ON COLUMN utilisateur.roles IS '(DC2Type:array)';
CREATE TABLE crep_ac_comp_manager (id NUMBER(10) NOT NULL,
 crep_ac_id NUMBER(10) NOT NULL,
 libelle CLOB DEFAULT NULL NULL,
 niveauAcquis NUMBER(10) DEFAULT NULL NULL,
 observations CLOB DEFAULT NULL NULL,
 dtype VARCHAR2(255) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_24A314049A75E2B2 ON crep_ac_comp_manager (crep_ac_id);
CREATE TABLE contrainte_poste (id NUMBER(10) NOT NULL,
 crep_id NUMBER(10) DEFAULT NULL NULL,
 libelle CLOB NOT NULL,
 niveau_difficulte NUMBER(10) DEFAULT NULL NULL,
 observations CLOB DEFAULT NULL NULL,
 dtype VARCHAR2(255) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_8110A546C235614F ON contrainte_poste (crep_id);
CREATE TABLE autre_domaine (id NUMBER(10) NOT NULL,
 crep_mindef01_id NUMBER(10) DEFAULT NULL NULL,
 niveauAcquis NUMBER(10) DEFAULT NULL NULL,
 libelle CLOB DEFAULT NULL NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_A38E375AAFAAF537 ON autre_domaine (crep_mindef01_id);
CREATE TABLE perimetre_brhp (id NUMBER(10) NOT NULL,
 perimetre_rlc_id NUMBER(10) NOT NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 libelle VARCHAR2(255) NOT NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_73E1D48C91A7789F ON perimetre_brhp (perimetre_rlc_id);
CREATE INDEX IDX_73E1D48CFC29C013 ON perimetre_brhp (cree_par_id);
CREATE INDEX IDX_73E1D48C553B2554 ON perimetre_brhp (modifie_par_id);
CREATE TABLE technique (id NUMBER(10) NOT NULL,
 crep_mindef01_id NUMBER(10) DEFAULT NULL NULL,
 niveauAcquis NUMBER(10) DEFAULT NULL NULL,
 libelle CLOB DEFAULT NULL NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_D73B9841AFAAF537 ON technique (crep_mindef01_id);
CREATE TABLE crep_mindef01_comp_manager (id NUMBER(10) NOT NULL,
 crep_mindef01_id NUMBER(10) NOT NULL,
 competence_manageriale_id NUMBER(10) NOT NULL,
 niveauAcquis NUMBER(10) DEFAULT NULL NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_C94817BCAFAAF537 ON crep_mindef01_comp_manager (crep_mindef01_id);
CREATE INDEX IDX_C94817BC816F7E2B ON crep_mindef01_comp_manager (competence_manageriale_id);
CREATE UNIQUE INDEX UNIQ_C94817BCAFAAF537816F7E2B ON crep_mindef01_comp_manager (crep_mindef01_id,
 competence_manageriale_id);
CREATE TABLE ministere (id NUMBER(10) NOT NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 libelle_court VARCHAR2(255) NOT NULL,
 libelle_long CLOB NOT NULL,
 libelle_officiel CLOB NOT NULL,
 supprime NUMBER(1) DEFAULT '0' NOT NULL,
 delai_visa NUMBER(10) DEFAULT 2 NOT NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_44118A5BFC29C013 ON ministere (cree_par_id);
CREATE INDEX IDX_44118A5B553B2554 ON ministere (modifie_par_id);
CREATE TABLE formation_dispensee (id NUMBER(10) NOT NULL,
 formation_id NUMBER(10) NOT NULL,
 crep_id NUMBER(10) DEFAULT NULL NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 date_debut DATE DEFAULT NULL NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_CD334C0D5200282E ON formation_dispensee (formation_id);
CREATE INDEX IDX_CD334C0DC235614F ON formation_dispensee (crep_id);
CREATE INDEX IDX_CD334C0DFC29C013 ON formation_dispensee (cree_par_id);
CREATE INDEX IDX_CD334C0D553B2554 ON formation_dispensee (modifie_par_id);
CREATE TABLE crep_mindef01_comp_trans (id NUMBER(10) NOT NULL,
 crep_mindef01_id NUMBER(10) NOT NULL,
 competence_transverse_id NUMBER(10) NOT NULL,
 niveauAcquis NUMBER(10) DEFAULT NULL NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_EFB6926BAFAAF537 ON crep_mindef01_comp_trans (crep_mindef01_id);
CREATE INDEX IDX_EFB6926B85ECD9A8 ON crep_mindef01_comp_trans (competence_transverse_id);
CREATE UNIQUE INDEX UNIQ_EFB6926BAFAAF53785ECD9A8 ON crep_mindef01_comp_trans (crep_mindef01_id,
 competence_transverse_id);
CREATE TABLE crep_meem_comp_manageriale (id NUMBER(10) NOT NULL,
 crep_meem_id NUMBER(10) NOT NULL,
 competence_manageriale_id NUMBER(10) NOT NULL,
 niveauAcquis NUMBER(10) DEFAULT NULL NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_D40314EF7AFA0623 ON crep_meem_comp_manageriale (crep_meem_id);
CREATE INDEX IDX_D40314EF816F7E2B ON crep_meem_comp_manageriale (competence_manageriale_id);
CREATE UNIQUE INDEX UNIQ_D40314EF7AFA0623816F7E2B ON crep_meem_comp_manageriale (crep_meem_id,
 competence_manageriale_id);
CREATE TABLE unite_organisationnelle (id NUMBER(10) NOT NULL,
 ministere_id NUMBER(10) NOT NULL,
 perimetre_brhp_id NUMBER(10) DEFAULT NULL NULL,
 uo_mere_id NUMBER(10) DEFAULT NULL NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 libelle VARCHAR2(255) NOT NULL,
 code VARCHAR2(255) NOT NULL,
 supprime NUMBER(1) NOT NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_86C3C7D3AD745416 ON unite_organisationnelle (ministere_id);
CREATE INDEX IDX_86C3C7D3BC37F552 ON unite_organisationnelle (perimetre_brhp_id);
CREATE INDEX IDX_86C3C7D3588492C5 ON unite_organisationnelle (uo_mere_id);
CREATE INDEX IDX_86C3C7D3FC29C013 ON unite_organisationnelle (cree_par_id);
CREATE INDEX IDX_86C3C7D3553B2554 ON unite_organisationnelle (modifie_par_id);
CREATE TABLE perimetre_rlc (id NUMBER(10) NOT NULL,
 ministere_id NUMBER(10) NOT NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 libelle VARCHAR2(255) NOT NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_6D1D3AF6AD745416 ON perimetre_rlc (ministere_id);
CREATE INDEX IDX_6D1D3AF6FC29C013 ON perimetre_rlc (cree_par_id);
CREATE INDEX IDX_6D1D3AF6553B2554 ON perimetre_rlc (modifie_par_id);
CREATE TABLE mobilite_externe (id NUMBER(10) NOT NULL,
 ministere_id NUMBER(10) DEFAULT NULL NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 hors_ministere VARCHAR2(255) DEFAULT NULL NULL,
 priorite NUMBER(10) DEFAULT NULL NULL,
 annee_depart VARCHAR2(255) DEFAULT NULL NULL,
 choix NUMBER(1) DEFAULT NULL NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_E2C4D280AD745416 ON mobilite_externe (ministere_id);
CREATE INDEX IDX_E2C4D280FC29C013 ON mobilite_externe (cree_par_id);
CREATE INDEX IDX_E2C4D280553B2554 ON mobilite_externe (modifie_par_id);
CREATE TABLE formation_demandee_agent_2016 (id NUMBER(10) NOT NULL,
 email VARCHAR2(255) NOT NULL,
 libelle CLOB NOT NULL,
 PRIMARY KEY(id));
CREATE TABLE objectif_futur_2016 (id NUMBER(10) NOT NULL,
 email VARCHAR2(255) NOT NULL,
 libelle CLOB NOT NULL,
 PRIMARY KEY(id));
CREATE TABLE formation_a_venir_2016 (id NUMBER(10) NOT NULL,
 email VARCHAR2(255) NOT NULL,
 libelle CLOB NOT NULL,
 PRIMARY KEY(id));
CREATE TABLE formation_reglementaire_2016 (id NUMBER(10) NOT NULL,
 email VARCHAR2(255) NOT NULL,
 libelle CLOB NOT NULL,
 PRIMARY KEY(id));
CREATE TABLE formation_demandee_admin_2016 (id NUMBER(10) NOT NULL,
 email VARCHAR2(255) NOT NULL,
 libelle CLOB NOT NULL,
 PRIMARY KEY(id));
CREATE TABLE crep_mcc_formation_a_venir (id NUMBER(10) NOT NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 crep_id NUMBER(10) DEFAULT NULL NULL,
 besoin_avere NUMBER(1) NOT NULL,
 libelle VARCHAR2(255) NOT NULL,
 besoin_toujours_avere NUMBER(1) DEFAULT NULL NULL,
 origine NUMBER(10) DEFAULT NULL NULL,
 cpf NUMBER(1) DEFAULT NULL NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 dtype VARCHAR2(255) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_4E3D20B2FC29C013 ON crep_mcc_formation_a_venir (cree_par_id);
CREATE INDEX IDX_4E3D20B2553B2554 ON crep_mcc_formation_a_venir (modifie_par_id);
CREATE INDEX IDX_4E3D20B2C235614F ON crep_mcc_formation_a_venir (crep_id);
CREATE TABLE crep_meem_comp_transverse (id NUMBER(10) NOT NULL,
 crep_meem_id NUMBER(10) NOT NULL,
 competence_transverse_id NUMBER(10) NOT NULL,
 niveauAcquis NUMBER(10) DEFAULT NULL NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_B5428DEC7AFA0623 ON crep_meem_comp_transverse (crep_meem_id);
CREATE INDEX IDX_B5428DEC85ECD9A8 ON crep_meem_comp_transverse (competence_transverse_id);
CREATE UNIQUE INDEX UNIQ_B5428DEC7AFA062385ECD9A8 ON crep_meem_comp_transverse (crep_meem_id,
 competence_transverse_id);
CREATE TABLE competence_declaree (id NUMBER(10) NOT NULL,
 crep_id NUMBER(10) DEFAULT NULL NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 libelle CLOB NOT NULL,
 niveauAcquis NUMBER(10) NOT NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_10BD52D6C235614F ON competence_declaree (crep_id);
CREATE INDEX IDX_10BD52D6FC29C013 ON competence_declaree (cree_par_id);
CREATE INDEX IDX_10BD52D6553B2554 ON competence_declaree (modifie_par_id);
CREATE TABLE connexion (id NUMBER(10) NOT NULL,
 utilisateur_id NUMBER(10) DEFAULT NULL NULL,
 date_connexion TIMESTAMP(0) NOT NULL,
 navigateur VARCHAR2(255) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_936BF99CFB88E14F ON connexion (utilisateur_id);
CREATE TABLE utilisateur_tmp (id NUMBER(10) NOT NULL,
 agent_id NUMBER(10) NOT NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 role VARCHAR2(255) NOT NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_A1A3C13B3414710B ON utilisateur_tmp (agent_id);
CREATE INDEX IDX_A1A3C13BFC29C013 ON utilisateur_tmp (cree_par_id);
CREATE INDEX IDX_A1A3C13B553B2554 ON utilisateur_tmp (modifie_par_id);
CREATE TABLE formation_ac_suivie (id NUMBER(10) NOT NULL,
 crep_id NUMBER(10) DEFAULT NULL NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 annee NUMBER(10) DEFAULT NULL NULL,
 libelle VARCHAR2(255) NOT NULL,
 duree VARCHAR2(255) DEFAULT NULL NULL,
 commentaires CLOB DEFAULT NULL NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_CFA41610C235614F ON formation_ac_suivie (crep_id);
CREATE INDEX IDX_CFA41610FC29C013 ON formation_ac_suivie (cree_par_id);
CREATE INDEX IDX_CFA41610553B2554 ON formation_ac_suivie (modifie_par_id);
CREATE TABLE message (id NUMBER(10) NOT NULL,
 destinataire NUMBER(10) NOT NULL,
 expediteur NUMBER(10) DEFAULT NULL NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 objet VARCHAR2(255) NOT NULL,
 contenu CLOB NOT NULL,
 favoris NUMBER(1) NOT NULL,
 lu NUMBER(1) NOT NULL,
 date_lecture TIMESTAMP(0) DEFAULT NULL NULL,
 date_envoi TIMESTAMP(0) NOT NULL,
 supprime NUMBER(1) NOT NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_B6BD307FFEA9FF92 ON message (destinataire);
CREATE INDEX IDX_B6BD307FABA4CF8E ON message (expediteur);
CREATE INDEX IDX_B6BD307FFC29C013 ON message (cree_par_id);
CREATE INDEX IDX_B6BD307F553B2554 ON message (modifie_par_id);
CREATE TABLE message_document (message_id NUMBER(10) NOT NULL,
 document_id NUMBER(10) NOT NULL,
 PRIMARY KEY(message_id,
 document_id));
CREATE INDEX IDX_D14F4E67537A1329 ON message_document (message_id);
CREATE INDEX IDX_D14F4E67C33F7837 ON message_document (document_id);
CREATE TABLE formation_a_venir (id NUMBER(10) NOT NULL,
 crep_id NUMBER(10) DEFAULT NULL NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 besoin_avere NUMBER(1) NOT NULL,
 libelle VARCHAR2(255) NOT NULL,
 besoin_toujours_avere NUMBER(1) DEFAULT NULL NULL,
 origine NUMBER(10) DEFAULT NULL NULL,
 cpf NUMBER(1) DEFAULT NULL NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 dtype VARCHAR2(255) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_3A9D53FCC235614F ON formation_a_venir (crep_id);
CREATE INDEX IDX_3A9D53FCFC29C013 ON formation_a_venir (cree_par_id);
CREATE INDEX IDX_3A9D53FC553B2554 ON formation_a_venir (modifie_par_id);
CREATE TABLE mobilite_fonctionnelle (id NUMBER(10) NOT NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 famille_professionnelle VARCHAR2(255) DEFAULT NULL NULL,
 filiere VARCHAR2(255) DEFAULT NULL NULL,
 priorite NUMBER(10) DEFAULT NULL NULL,
 annee_depart VARCHAR2(255) DEFAULT NULL NULL,
 choix NUMBER(1) DEFAULT NULL NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_FBF56CBAFC29C013 ON mobilite_fonctionnelle (cree_par_id);
CREATE INDEX IDX_FBF56CBA553B2554 ON mobilite_fonctionnelle (modifie_par_id);
CREATE TABLE crep_mindef_comp_manage (id NUMBER(10) NOT NULL,
 crep_mindef_id NUMBER(10) NOT NULL,
 competence_manageriale_id NUMBER(10) NOT NULL,
 niveauAcquis NUMBER(10) DEFAULT NULL NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_6DBFABA21986583 ON crep_mindef_comp_manage (crep_mindef_id);
CREATE INDEX IDX_6DBFABA2816F7E2B ON crep_mindef_comp_manage (competence_manageriale_id);
CREATE UNIQUE INDEX UNIQ_6DBFABA21986583816F7E2B ON crep_mindef_comp_manage (crep_mindef_id,
 competence_manageriale_id);
CREATE TABLE emploi (id NUMBER(10) NOT NULL,
 crep_id NUMBER(10) DEFAULT NULL NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 affectation VARCHAR2(255) DEFAULT NULL NULL,
 poste VARCHAR2(255) DEFAULT NULL NULL,
 date_debut DATE DEFAULT NULL NULL,
 date_fin DATE DEFAULT NULL NULL,
 famille_morgane VARCHAR2(255) DEFAULT NULL NULL,
 nombre_annees_domaine VARCHAR2(255) DEFAULT NULL NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_74A0B0FAC235614F ON emploi (crep_id);
CREATE INDEX IDX_74A0B0FAFC29C013 ON emploi (cree_par_id);
CREATE INDEX IDX_74A0B0FA553B2554 ON emploi (modifie_par_id);
CREATE TABLE objectif_futur (id NUMBER(10) NOT NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 crep_id NUMBER(10) DEFAULT NULL NULL,
 echeance VARCHAR2(255) DEFAULT NULL NULL,
 observations_eventuelles CLOB DEFAULT NULL NULL,
 libelle CLOB NOT NULL,
 resultat CLOB DEFAULT NULL NULL,
 indicateurs CLOB DEFAULT NULL NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 dtype VARCHAR2(255) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_3E1649B5FC29C013 ON objectif_futur (cree_par_id);
CREATE INDEX IDX_3E1649B5553B2554 ON objectif_futur (modifie_par_id);
CREATE INDEX IDX_3E1649B5C235614F ON objectif_futur (crep_id);
CREATE TABLE formation_demandee_employeur (id NUMBER(10) NOT NULL,
 crep_id NUMBER(10) DEFAULT NULL NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 lien_avec_objectifs NUMBER(1) NOT NULL,
 libelle VARCHAR2(255) NOT NULL,
 hors_dif NUMBER(1) NOT NULL,
 priorite NUMBER(10) NOT NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_7B708072C235614F ON formation_demandee_employeur (crep_id);
CREATE INDEX IDX_7B708072FC29C013 ON formation_demandee_employeur (cree_par_id);
CREATE INDEX IDX_7B708072553B2554 ON formation_demandee_employeur (modifie_par_id);
CREATE TABLE modele_crep (id NUMBER(10) NOT NULL,
 ministere_id NUMBER(10) NOT NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 libelle VARCHAR2(255) NOT NULL,
 type_entity VARCHAR2(255) NOT NULL,
 actif NUMBER(1) NOT NULL,
 path_vers_modele_pdf VARCHAR2(255) DEFAULT NULL NULL,
 template_pdf VARCHAR2(255) DEFAULT NULL NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_D1AAA136AD745416 ON modele_crep (ministere_id);
CREATE INDEX IDX_D1AAA136FC29C013 ON modele_crep (cree_par_id);
CREATE INDEX IDX_D1AAA136553B2554 ON modele_crep (modifie_par_id);
CREATE TABLE campagne_rlc (id NUMBER(10) NOT NULL,
 perimetre_rlc_id NUMBER(10) NOT NULL,
 campagne_pnc_id NUMBER(10) NOT NULL,
 ouverte_par_id NUMBER(10) DEFAULT NULL NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 statut VARCHAR2(255) NOT NULL,
 date_ouverture TIMESTAMP(0) DEFAULT NULL NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_896D8EA091A7789F ON campagne_rlc (perimetre_rlc_id);
CREATE INDEX IDX_896D8EA01E32C292 ON campagne_rlc (campagne_pnc_id);
CREATE INDEX IDX_896D8EA0A3FE4415 ON campagne_rlc (ouverte_par_id);
CREATE INDEX IDX_896D8EA0FC29C013 ON campagne_rlc (cree_par_id);
CREATE INDEX IDX_896D8EA0553B2554 ON campagne_rlc (modifie_par_id);
CREATE TABLE campagne_rlc_perimetres_brhp (campagne_rlc_id NUMBER(10) NOT NULL,
 perimetre_brhp_id NUMBER(10) NOT NULL,
 PRIMARY KEY(campagne_rlc_id,
 perimetre_brhp_id));
CREATE INDEX IDX_523A952293A30F9 ON campagne_rlc_perimetres_brhp (campagne_rlc_id);
CREATE INDEX IDX_523A952BC37F552 ON campagne_rlc_perimetres_brhp (perimetre_brhp_id);
CREATE TABLE campagne_rlc_document (campagne_rlc_id NUMBER(10) NOT NULL,
 document_id NUMBER(10) NOT NULL,
 PRIMARY KEY(campagne_rlc_id,
 document_id));
CREATE INDEX IDX_8762B227293A30F9 ON campagne_rlc_document (campagne_rlc_id);
CREATE INDEX IDX_8762B227C33F7837 ON campagne_rlc_document (document_id);
CREATE TABLE demande_formation_pro (id NUMBER(10) NOT NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 type_formation VARCHAR2(255) DEFAULT NULL NULL,
 choix NUMBER(1) DEFAULT NULL NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_6C63E23BFC29C013 ON demande_formation_pro (cree_par_id);
CREATE INDEX IDX_6C63E23B553B2554 ON demande_formation_pro (modifie_par_id);
CREATE TABLE crep_mindef_comp_trans (id NUMBER(10) NOT NULL,
 crep_mindef_id NUMBER(10) NOT NULL,
 competence_transverse_id NUMBER(10) NOT NULL,
 niveauAcquis NUMBER(10) DEFAULT NULL NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_D467BB5B1986583 ON crep_mindef_comp_trans (crep_mindef_id);
CREATE INDEX IDX_D467BB5B85ECD9A8 ON crep_mindef_comp_trans (competence_transverse_id);
CREATE UNIQUE INDEX UNIQ_D467BB5B198658385ECD9A8 ON crep_mindef_comp_trans (crep_mindef_id,
 competence_transverse_id);
CREATE TABLE stat_campagne_rlc (id NUMBER(10) NOT NULL,
 campagne_rlc_id NUMBER(10) DEFAULT NULL NULL,
 date_stat DATE NOT NULL,
 nb_crep NUMBER(10) NOT NULL,
 nb_crep_non_renseignes NUMBER(10) NOT NULL,
 nb_crep_modifies_shd NUMBER(10) NOT NULL,
 nb_crep_signes_shd NUMBER(10) NOT NULL,
 nb_crep_vises_agent NUMBER(10) NOT NULL,
 nb_crep_refus_visa_agent NUMBER(10) NOT NULL,
 nb_crep_signes_ah NUMBER(10) NOT NULL,
 nb_crep_notifies_agent NUMBER(10) NOT NULL,
 nb_crep_refus_notif_agent NUMBER(10) NOT NULL,
 nb_crep_cas_absence NUMBER(10) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_21D2930A293A30F9 ON stat_campagne_rlc (campagne_rlc_id);
CREATE TABLE stat_campagne_brhp (id NUMBER(10) NOT NULL,
 campagne_brhp_id NUMBER(10) DEFAULT NULL NULL,
 date_stat DATE NOT NULL,
 nb_crep NUMBER(10) NOT NULL,
 nb_crep_non_renseignes NUMBER(10) NOT NULL,
 nb_crep_modifies_shd NUMBER(10) NOT NULL,
 nb_crep_signes_shd NUMBER(10) NOT NULL,
 nb_crep_vises_agent NUMBER(10) NOT NULL,
 nb_crep_refus_visa_agent NUMBER(10) NOT NULL,
 nb_crep_signes_ah NUMBER(10) NOT NULL,
 nb_crep_notifies_agent NUMBER(10) NOT NULL,
 nb_crep_refus_notif_agent NUMBER(10) NOT NULL,
 nb_crep_cas_absence NUMBER(10) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_C7A6A512185EAC77 ON stat_campagne_brhp (campagne_brhp_id);
CREATE TABLE stat_campagne_pnc (id NUMBER(10) NOT NULL,
 campagne_pnc_id NUMBER(10) DEFAULT NULL NULL,
 date_stat DATE NOT NULL,
 nb_crep NUMBER(10) NOT NULL,
 nb_crep_non_renseignes NUMBER(10) NOT NULL,
 nb_crep_modifies_shd NUMBER(10) NOT NULL,
 nb_crep_signes_shd NUMBER(10) NOT NULL,
 nb_crep_vises_agent NUMBER(10) NOT NULL,
 nb_crep_refus_visa_agent NUMBER(10) NOT NULL,
 nb_crep_signes_ah NUMBER(10) NOT NULL,
 nb_crep_notifies_agent NUMBER(10) NOT NULL,
 nb_crep_refus_notif_agent NUMBER(10) NOT NULL,
 nb_crep_cas_absence NUMBER(10) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_106025E61E32C292 ON stat_campagne_pnc (campagne_pnc_id);
CREATE TABLE formation_reglementaire (id NUMBER(10) NOT NULL,
 crep_id NUMBER(10) DEFAULT NULL NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 libelle VARCHAR2(255) NOT NULL,
 niveau_same NUMBER(10) NOT NULL,
 priorite NUMBER(10) NOT NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_D0CE447DC235614F ON formation_reglementaire (crep_id);
CREATE INDEX IDX_D0CE447DFC29C013 ON formation_reglementaire (cree_par_id);
CREATE INDEX IDX_D0CE447D553B2554 ON formation_reglementaire (modifie_par_id);
CREATE TABLE crep_minefAbc_comp_trans (id NUMBER(10) NOT NULL,
 crep_minef_abc_id NUMBER(10) NOT NULL,
 competence_transverse_id NUMBER(10) NOT NULL,
 niveauAcquis NUMBER(10) DEFAULT NULL NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_419CFD3213147828 ON crep_minefAbc_comp_trans (crep_minef_abc_id);
CREATE INDEX IDX_419CFD3285ECD9A8 ON crep_minefAbc_comp_trans (competence_transverse_id);
CREATE UNIQUE INDEX UNIQ_419CFD321314782885ECD9A8 ON crep_minefAbc_comp_trans (crep_minef_abc_id,
 competence_transverse_id);
CREATE TABLE brhp (id NUMBER(10) NOT NULL,
 utilisateur_id NUMBER(10) DEFAULT NULL NULL,
 ministere_id NUMBER(10) NOT NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 civilite VARCHAR2(255) DEFAULT NULL NULL,
 nom VARCHAR2(255) DEFAULT NULL NULL,
 prenom VARCHAR2(255) DEFAULT NULL NULL,
 email VARCHAR2(255) NOT NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE UNIQUE INDEX UNIQ_1A3FCC39FB88E14F ON brhp (utilisateur_id);
CREATE INDEX IDX_1A3FCC39AD745416 ON brhp (ministere_id);
CREATE INDEX IDX_1A3FCC39FC29C013 ON brhp (cree_par_id);
CREATE INDEX IDX_1A3FCC39553B2554 ON brhp (modifie_par_id);
CREATE TABLE brhp_perimetres_brhp (brhp_id NUMBER(10) NOT NULL,
 perimetre_brhp_id NUMBER(10) NOT NULL,
 PRIMARY KEY(brhp_id,
 perimetre_brhp_id));
CREATE INDEX IDX_6F3D5E399CD2AE4A ON brhp_perimetres_brhp (brhp_id);
CREATE INDEX IDX_6F3D5E39BC37F552 ON brhp_perimetres_brhp (perimetre_brhp_id);
CREATE TABLE rlc (id NUMBER(10) NOT NULL,
 utilisateur_id NUMBER(10) DEFAULT NULL NULL,
 ministere_id NUMBER(10) NOT NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 civilite VARCHAR2(255) DEFAULT NULL NULL,
 nom VARCHAR2(255) DEFAULT NULL NULL,
 prenom VARCHAR2(255) DEFAULT NULL NULL,
 email VARCHAR2(255) NOT NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE UNIQUE INDEX UNIQ_B5C77165FB88E14F ON rlc (utilisateur_id);
CREATE INDEX IDX_B5C77165AD745416 ON rlc (ministere_id);
CREATE INDEX IDX_B5C77165FC29C013 ON rlc (cree_par_id);
CREATE INDEX IDX_B5C77165553B2554 ON rlc (modifie_par_id);
CREATE TABLE rlc_perimetres_rlc (rlc_id NUMBER(10) NOT NULL,
 perimetre_rlc_id NUMBER(10) NOT NULL,
 PRIMARY KEY(rlc_id,
 perimetre_rlc_id));
CREATE INDEX IDX_C33ADAEB1B79D3EA ON rlc_perimetres_rlc (rlc_id);
CREATE INDEX IDX_C33ADAEB91A7789F ON rlc_perimetres_rlc (perimetre_rlc_id);
CREATE TABLE campagne_brhp (id NUMBER(10) NOT NULL,
 perimetre_brhp_id NUMBER(10) NOT NULL,
 campagne_rlc_id NUMBER(10) NOT NULL,
 ouverte_par_id NUMBER(10) DEFAULT NULL NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 statut VARCHAR2(255) NOT NULL,
 date_ouverture TIMESTAMP(0) DEFAULT NULL NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_F10D50F9BC37F552 ON campagne_brhp (perimetre_brhp_id);
CREATE INDEX IDX_F10D50F9293A30F9 ON campagne_brhp (campagne_rlc_id);
CREATE INDEX IDX_F10D50F9A3FE4415 ON campagne_brhp (ouverte_par_id);
CREATE INDEX IDX_F10D50F9FC29C013 ON campagne_brhp (cree_par_id);
CREATE INDEX IDX_F10D50F9553B2554 ON campagne_brhp (modifie_par_id);
CREATE TABLE campagne_brhp_document (campagne_brhp_id NUMBER(10) NOT NULL,
 document_id NUMBER(10) NOT NULL,
 PRIMARY KEY(campagne_brhp_id,
 document_id));
CREATE INDEX IDX_26C3E26D185EAC77 ON campagne_brhp_document (campagne_brhp_id);
CREATE INDEX IDX_26C3E26DC33F7837 ON campagne_brhp_document (document_id);
CREATE TABLE formation_demandee_admin (id NUMBER(10) NOT NULL,
 crep_id NUMBER(10) DEFAULT NULL NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 lien_avec_objectifs NUMBER(1) NOT NULL,
 libelle VARCHAR2(255) NOT NULL,
 typologie CLOB DEFAULT NULL NULL,
 code VARCHAR2(255) DEFAULT NULL NULL,
 niveau_same NUMBER(10) DEFAULT NULL NULL,
 priorite NUMBER(10) NOT NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_9B352D94C235614F ON formation_demandee_admin (crep_id);
CREATE INDEX IDX_9B352D94FC29C013 ON formation_demandee_admin (cree_par_id);
CREATE INDEX IDX_9B352D94553B2554 ON formation_demandee_admin (modifie_par_id);
CREATE TABLE competence_transverse (id NUMBER(10) NOT NULL,
 libelle CLOB NOT NULL,
 modele_crep VARCHAR2(255) NOT NULL,
 type_competence VARCHAR2(255) DEFAULT NULL NULL,
 PRIMARY KEY(id));
CREATE TABLE competence_poste (id NUMBER(10) NOT NULL,
 crep_id NUMBER(10) DEFAULT NULL NULL,
 cree_par_id NUMBER(10) DEFAULT NULL NULL,
 modifie_par_id NUMBER(10) DEFAULT NULL NULL,
 niveauRequis NUMBER(10) DEFAULT NULL NULL,
 libelle CLOB NOT NULL,
 niveauAcquis NUMBER(10) NOT NULL,
 date_creation TIMESTAMP(0) NOT NULL,
 date_modification TIMESTAMP(0) NOT NULL,
 PRIMARY KEY(id));
CREATE INDEX IDX_F6AB5E4DC235614F ON competence_poste (crep_id);
CREATE INDEX IDX_F6AB5E4DFC29C013 ON competence_poste (cree_par_id);
CREATE INDEX IDX_F6AB5E4D553B2554 ON competence_poste (modifie_par_id);
CREATE SEQUENCE crep_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE objectif_evalue_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE agent_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE crep_ac_comp_trans_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE formation_demandee_agent_id_se START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE crep_mcc_comp_trans_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE mobilite_geographique_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE motivations_mobilite_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE competence_manageriale_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE campagne_pnc_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE formation_suivie_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE document_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE formation_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE utilisateur_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE crep_ac_comp_manager_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE contrainte_poste_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE autre_domaine_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE perimetre_brhp_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE technique_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE crep_mindef01_comp_manager_id_ START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE ministere_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE formation_dispensee_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE crep_mindef01_comp_trans_id_se START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE crep_meem_comp_manageriale_id_ START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE unite_organisationnelle_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE perimetre_rlc_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE mobilite_externe_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE formation_demandee_agent_2016_ START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE objectif_futur_2016_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE formation_a_venir_2016_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE formation_reglementaire_2016_i START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE formation_demandee_admin_2016_ START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE crep_mcc_formation_a_venir_id_ START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE crep_meem_comp_transverse_id_s START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE competence_declaree_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE connexion_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE utilisateur_tmp_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE formation_ac_suivie_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE message_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE formation_a_venir_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE mobilite_fonctionnelle_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE crep_mindef_comp_manage_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE emploi_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE objectif_futur_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE formation_demandee_employeur_i START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE modele_crep_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE campagne_rlc_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE demande_formation_pro_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE crep_mindef_comp_trans_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE stat_campagne_rlc_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE stat_campagne_brhp_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE stat_campagne_pnc_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE formation_reglementaire_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE crep_minefAbc_comp_trans_id_se START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE brhp_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE rlc_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE campagne_brhp_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE formation_demandee_admin_id_se START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE competence_transverse_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE competence_poste_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
ALTER TABLE crep ADD CONSTRAINT FK_172DD5117E986330 FOREIGN KEY (shd_signataire_id) REFERENCES agent (id);
ALTER TABLE crep ADD CONSTRAINT FK_172DD511F46CEB15 FOREIGN KEY (ah_signataire_id) REFERENCES agent (id);
ALTER TABLE crep ADD CONSTRAINT FK_172DD5113414710B FOREIGN KEY (agent_id) REFERENCES agent (id);
ALTER TABLE crep ADD CONSTRAINT FK_172DD511DFE9B0E4 FOREIGN KEY (crep_pdf_id) REFERENCES document (id);
ALTER TABLE crep ADD CONSTRAINT FK_172DD511DBF6EF95 FOREIGN KEY (crep_papier_id) REFERENCES document (id);
ALTER TABLE crep ADD CONSTRAINT FK_172DD511AA179C35 FOREIGN KEY (mobilite_fonctionnelle_id) REFERENCES mobilite_fonctionnelle (id);
ALTER TABLE crep ADD CONSTRAINT FK_172DD5117ADBBEC1 FOREIGN KEY (mobilite_geographique_id) REFERENCES mobilite_geographique (id);
ALTER TABLE crep ADD CONSTRAINT FK_172DD511A8737F66 FOREIGN KEY (mobilite_externe_id) REFERENCES mobilite_externe (id);
ALTER TABLE crep ADD CONSTRAINT FK_172DD511672877A0 FOREIGN KEY (motivations_mobilite_id) REFERENCES motivations_mobilite (id);
ALTER TABLE crep ADD CONSTRAINT FK_172DD511C7B89B9D FOREIGN KEY (modele_crep_id) REFERENCES modele_crep (id);
ALTER TABLE crep ADD CONSTRAINT FK_172DD511FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep ADD CONSTRAINT FK_172DD511553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep ADD CONSTRAINT FK_172DD511CD6405BF FOREIGN KEY (demande_form_prof_id) REFERENCES demande_formation_pro (id);
ALTER TABLE objectif_evalue ADD CONSTRAINT FK_AEAA8AFBFC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE objectif_evalue ADD CONSTRAINT FK_AEAA8AFB553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE objectif_evalue ADD CONSTRAINT FK_AEAA8AFBC235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id);
ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DC235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D185EAC77 FOREIGN KEY (campagne_brhp_id) REFERENCES campagne_brhp (id);
ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D293A30F9 FOREIGN KEY (campagne_rlc_id) REFERENCES campagne_rlc (id);
ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D1E32C292 FOREIGN KEY (campagne_pnc_id) REFERENCES campagne_pnc (id);
ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DB8729E36 FOREIGN KEY (shd_id) REFERENCES agent (id);
ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D5E26A2E FOREIGN KEY (ah_id) REFERENCES agent (id);
ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DBC37F552 FOREIGN KEY (perimetre_brhp_id) REFERENCES perimetre_brhp (id);
ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D91A7789F FOREIGN KEY (perimetre_rlc_id) REFERENCES perimetre_rlc (id);
ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D6F589C5C FOREIGN KEY (unite_organisationnelle_id) REFERENCES unite_organisationnelle (id);
ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DFC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_ac_comp_trans ADD CONSTRAINT FK_DCBD22999A75E2B2 FOREIGN KEY (crep_ac_id) REFERENCES crep (id);
ALTER TABLE formation_demandee_agent ADD CONSTRAINT FK_35B0BC7FC235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE formation_demandee_agent ADD CONSTRAINT FK_35B0BC7FFC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE formation_demandee_agent ADD CONSTRAINT FK_35B0BC7F553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_mcc_comp_trans ADD CONSTRAINT FK_35911C3885ECD9A8 FOREIGN KEY (competence_transverse_id) REFERENCES competence_transverse (id);
ALTER TABLE crep_mcc_comp_trans ADD CONSTRAINT FK_35911C38FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_mcc_comp_trans ADD CONSTRAINT FK_35911C38553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_mcc_comp_trans ADD CONSTRAINT FK_35911C38E55F8D83 FOREIGN KEY (crep_mcc_id) REFERENCES crep (id);
ALTER TABLE mobilite_geographique ADD CONSTRAINT FK_90AA162FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE mobilite_geographique ADD CONSTRAINT FK_90AA162553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE motivations_mobilite ADD CONSTRAINT FK_2C15040DFC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE motivations_mobilite ADD CONSTRAINT FK_2C15040D553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE campagne_pnc ADD CONSTRAINT FK_B8DF384CAD745416 FOREIGN KEY (ministere_id) REFERENCES ministere (id);
ALTER TABLE campagne_pnc ADD CONSTRAINT FK_B8DF384C9A54AC53 FOREIGN KEY (doc_population_id) REFERENCES document (id);
ALTER TABLE campagne_pnc ADD CONSTRAINT FK_B8DF384CA3FE4415 FOREIGN KEY (ouverte_par_id) REFERENCES utilisateur (id);
ALTER TABLE campagne_pnc ADD CONSTRAINT FK_B8DF384CFC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE campagne_pnc ADD CONSTRAINT FK_B8DF384C553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE campagne_pnc_perimetres_rlc ADD CONSTRAINT FK_A2C98FF21E32C292 FOREIGN KEY (campagne_pnc_id) REFERENCES campagne_pnc (id) ON DELETE CASCADE;
ALTER TABLE campagne_pnc_perimetres_rlc ADD CONSTRAINT FK_A2C98FF291A7789F FOREIGN KEY (perimetre_rlc_id) REFERENCES perimetre_rlc (id) ON DELETE CASCADE;
ALTER TABLE campagne_pnc_document ADD CONSTRAINT FK_333595791E32C292 FOREIGN KEY (campagne_pnc_id) REFERENCES campagne_pnc (id) ON DELETE CASCADE;
ALTER TABLE campagne_pnc_document ADD CONSTRAINT FK_33359579C33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE;
ALTER TABLE formation_suivie ADD CONSTRAINT FK_B2EA560CC235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE formation_suivie ADD CONSTRAINT FK_B2EA560CFC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE formation_suivie ADD CONSTRAINT FK_B2EA560C553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE document ADD CONSTRAINT FK_D8698A76FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE document ADD CONSTRAINT FK_D8698A76553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE formation ADD CONSTRAINT FK_404021BFAD745416 FOREIGN KEY (ministere_id) REFERENCES ministere (id);
ALTER TABLE formation ADD CONSTRAINT FK_404021BFFC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE formation ADD CONSTRAINT FK_404021BF553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3AD745416 FOREIGN KEY (ministere_id) REFERENCES ministere (id);
ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_ac_comp_manager ADD CONSTRAINT FK_24A314049A75E2B2 FOREIGN KEY (crep_ac_id) REFERENCES crep (id);
ALTER TABLE contrainte_poste ADD CONSTRAINT FK_8110A546C235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE autre_domaine ADD CONSTRAINT FK_A38E375AAFAAF537 FOREIGN KEY (crep_mindef01_id) REFERENCES crep (id);
ALTER TABLE perimetre_brhp ADD CONSTRAINT FK_73E1D48C91A7789F FOREIGN KEY (perimetre_rlc_id) REFERENCES perimetre_rlc (id);
ALTER TABLE perimetre_brhp ADD CONSTRAINT FK_73E1D48CFC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE perimetre_brhp ADD CONSTRAINT FK_73E1D48C553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE technique ADD CONSTRAINT FK_D73B9841AFAAF537 FOREIGN KEY (crep_mindef01_id) REFERENCES crep (id);
ALTER TABLE crep_mindef01_comp_manager ADD CONSTRAINT FK_C94817BCAFAAF537 FOREIGN KEY (crep_mindef01_id) REFERENCES crep (id);
ALTER TABLE crep_mindef01_comp_manager ADD CONSTRAINT FK_C94817BC816F7E2B FOREIGN KEY (competence_manageriale_id) REFERENCES competence_manageriale (id);
ALTER TABLE ministere ADD CONSTRAINT FK_44118A5BFC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE ministere ADD CONSTRAINT FK_44118A5B553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE formation_dispensee ADD CONSTRAINT FK_CD334C0D5200282E FOREIGN KEY (formation_id) REFERENCES formation (id);
ALTER TABLE formation_dispensee ADD CONSTRAINT FK_CD334C0DC235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE formation_dispensee ADD CONSTRAINT FK_CD334C0DFC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE formation_dispensee ADD CONSTRAINT FK_CD334C0D553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_mindef01_comp_trans ADD CONSTRAINT FK_EFB6926BAFAAF537 FOREIGN KEY (crep_mindef01_id) REFERENCES crep (id);
ALTER TABLE crep_mindef01_comp_trans ADD CONSTRAINT FK_EFB6926B85ECD9A8 FOREIGN KEY (competence_transverse_id) REFERENCES competence_transverse (id);
ALTER TABLE crep_meem_comp_manageriale ADD CONSTRAINT FK_D40314EF7AFA0623 FOREIGN KEY (crep_meem_id) REFERENCES crep (id);
ALTER TABLE crep_meem_comp_manageriale ADD CONSTRAINT FK_D40314EF816F7E2B FOREIGN KEY (competence_manageriale_id) REFERENCES competence_manageriale (id);
ALTER TABLE unite_organisationnelle ADD CONSTRAINT FK_86C3C7D3AD745416 FOREIGN KEY (ministere_id) REFERENCES ministere (id);
ALTER TABLE unite_organisationnelle ADD CONSTRAINT FK_86C3C7D3BC37F552 FOREIGN KEY (perimetre_brhp_id) REFERENCES perimetre_brhp (id);
ALTER TABLE unite_organisationnelle ADD CONSTRAINT FK_86C3C7D3588492C5 FOREIGN KEY (uo_mere_id) REFERENCES unite_organisationnelle (id);
ALTER TABLE unite_organisationnelle ADD CONSTRAINT FK_86C3C7D3FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE unite_organisationnelle ADD CONSTRAINT FK_86C3C7D3553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE perimetre_rlc ADD CONSTRAINT FK_6D1D3AF6AD745416 FOREIGN KEY (ministere_id) REFERENCES ministere (id);
ALTER TABLE perimetre_rlc ADD CONSTRAINT FK_6D1D3AF6FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE perimetre_rlc ADD CONSTRAINT FK_6D1D3AF6553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE mobilite_externe ADD CONSTRAINT FK_E2C4D280AD745416 FOREIGN KEY (ministere_id) REFERENCES ministere (id);
ALTER TABLE mobilite_externe ADD CONSTRAINT FK_E2C4D280FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE mobilite_externe ADD CONSTRAINT FK_E2C4D280553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_mcc_formation_a_venir ADD CONSTRAINT FK_4E3D20B2FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_mcc_formation_a_venir ADD CONSTRAINT FK_4E3D20B2553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_mcc_formation_a_venir ADD CONSTRAINT FK_4E3D20B2C235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE crep_meem_comp_transverse ADD CONSTRAINT FK_B5428DEC7AFA0623 FOREIGN KEY (crep_meem_id) REFERENCES crep (id);
ALTER TABLE crep_meem_comp_transverse ADD CONSTRAINT FK_B5428DEC85ECD9A8 FOREIGN KEY (competence_transverse_id) REFERENCES competence_transverse (id);
ALTER TABLE competence_declaree ADD CONSTRAINT FK_10BD52D6C235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE competence_declaree ADD CONSTRAINT FK_10BD52D6FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE competence_declaree ADD CONSTRAINT FK_10BD52D6553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE connexion ADD CONSTRAINT FK_936BF99CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id);
ALTER TABLE utilisateur_tmp ADD CONSTRAINT FK_A1A3C13B3414710B FOREIGN KEY (agent_id) REFERENCES agent (id);
ALTER TABLE utilisateur_tmp ADD CONSTRAINT FK_A1A3C13BFC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE utilisateur_tmp ADD CONSTRAINT FK_A1A3C13B553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE formation_ac_suivie ADD CONSTRAINT FK_CFA41610C235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE formation_ac_suivie ADD CONSTRAINT FK_CFA41610FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE formation_ac_suivie ADD CONSTRAINT FK_CFA41610553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE message ADD CONSTRAINT FK_B6BD307FFEA9FF92 FOREIGN KEY (destinataire) REFERENCES utilisateur (id);
ALTER TABLE message ADD CONSTRAINT FK_B6BD307FABA4CF8E FOREIGN KEY (expediteur) REFERENCES utilisateur (id);
ALTER TABLE message ADD CONSTRAINT FK_B6BD307FFC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE message ADD CONSTRAINT FK_B6BD307F553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE message_document ADD CONSTRAINT FK_D14F4E67537A1329 FOREIGN KEY (message_id) REFERENCES message (id) ON DELETE CASCADE;
ALTER TABLE message_document ADD CONSTRAINT FK_D14F4E67C33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE;
ALTER TABLE formation_a_venir ADD CONSTRAINT FK_3A9D53FCC235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE formation_a_venir ADD CONSTRAINT FK_3A9D53FCFC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE formation_a_venir ADD CONSTRAINT FK_3A9D53FC553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE mobilite_fonctionnelle ADD CONSTRAINT FK_FBF56CBAFC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE mobilite_fonctionnelle ADD CONSTRAINT FK_FBF56CBA553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_mindef_comp_manage ADD CONSTRAINT FK_6DBFABA21986583 FOREIGN KEY (crep_mindef_id) REFERENCES crep (id);
ALTER TABLE crep_mindef_comp_manage ADD CONSTRAINT FK_6DBFABA2816F7E2B FOREIGN KEY (competence_manageriale_id) REFERENCES competence_manageriale (id);
ALTER TABLE emploi ADD CONSTRAINT FK_74A0B0FAC235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE emploi ADD CONSTRAINT FK_74A0B0FAFC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE emploi ADD CONSTRAINT FK_74A0B0FA553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE objectif_futur ADD CONSTRAINT FK_3E1649B5FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE objectif_futur ADD CONSTRAINT FK_3E1649B5553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE objectif_futur ADD CONSTRAINT FK_3E1649B5C235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE formation_demandee_employeur ADD CONSTRAINT FK_7B708072C235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE formation_demandee_employeur ADD CONSTRAINT FK_7B708072FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE formation_demandee_employeur ADD CONSTRAINT FK_7B708072553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE modele_crep ADD CONSTRAINT FK_D1AAA136AD745416 FOREIGN KEY (ministere_id) REFERENCES ministere (id) ON DELETE CASCADE;
ALTER TABLE modele_crep ADD CONSTRAINT FK_D1AAA136FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE modele_crep ADD CONSTRAINT FK_D1AAA136553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE campagne_rlc ADD CONSTRAINT FK_896D8EA091A7789F FOREIGN KEY (perimetre_rlc_id) REFERENCES perimetre_rlc (id);
ALTER TABLE campagne_rlc ADD CONSTRAINT FK_896D8EA01E32C292 FOREIGN KEY (campagne_pnc_id) REFERENCES campagne_pnc (id);
ALTER TABLE campagne_rlc ADD CONSTRAINT FK_896D8EA0A3FE4415 FOREIGN KEY (ouverte_par_id) REFERENCES utilisateur (id);
ALTER TABLE campagne_rlc ADD CONSTRAINT FK_896D8EA0FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE campagne_rlc ADD CONSTRAINT FK_896D8EA0553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE campagne_rlc_perimetres_brhp ADD CONSTRAINT FK_523A952293A30F9 FOREIGN KEY (campagne_rlc_id) REFERENCES campagne_rlc (id) ON DELETE CASCADE;
ALTER TABLE campagne_rlc_perimetres_brhp ADD CONSTRAINT FK_523A952BC37F552 FOREIGN KEY (perimetre_brhp_id) REFERENCES perimetre_brhp (id) ON DELETE CASCADE;
ALTER TABLE campagne_rlc_document ADD CONSTRAINT FK_8762B227293A30F9 FOREIGN KEY (campagne_rlc_id) REFERENCES campagne_rlc (id) ON DELETE CASCADE;
ALTER TABLE campagne_rlc_document ADD CONSTRAINT FK_8762B227C33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE;
ALTER TABLE demande_formation_pro ADD CONSTRAINT FK_6C63E23BFC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE demande_formation_pro ADD CONSTRAINT FK_6C63E23B553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_mindef_comp_trans ADD CONSTRAINT FK_D467BB5B1986583 FOREIGN KEY (crep_mindef_id) REFERENCES crep (id);
ALTER TABLE crep_mindef_comp_trans ADD CONSTRAINT FK_D467BB5B85ECD9A8 FOREIGN KEY (competence_transverse_id) REFERENCES competence_transverse (id);
ALTER TABLE stat_campagne_rlc ADD CONSTRAINT FK_21D2930A293A30F9 FOREIGN KEY (campagne_rlc_id) REFERENCES campagne_rlc (id);
ALTER TABLE stat_campagne_brhp ADD CONSTRAINT FK_C7A6A512185EAC77 FOREIGN KEY (campagne_brhp_id) REFERENCES campagne_brhp (id);
ALTER TABLE stat_campagne_pnc ADD CONSTRAINT FK_106025E61E32C292 FOREIGN KEY (campagne_pnc_id) REFERENCES campagne_pnc (id);
ALTER TABLE formation_reglementaire ADD CONSTRAINT FK_D0CE447DC235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE formation_reglementaire ADD CONSTRAINT FK_D0CE447DFC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE formation_reglementaire ADD CONSTRAINT FK_D0CE447D553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_minefAbc_comp_trans ADD CONSTRAINT FK_419CFD3213147828 FOREIGN KEY (crep_minef_abc_id) REFERENCES crep (id);
ALTER TABLE crep_minefAbc_comp_trans ADD CONSTRAINT FK_419CFD3285ECD9A8 FOREIGN KEY (competence_transverse_id) REFERENCES competence_transverse (id);
ALTER TABLE brhp ADD CONSTRAINT FK_1A3FCC39FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id);
ALTER TABLE brhp ADD CONSTRAINT FK_1A3FCC39AD745416 FOREIGN KEY (ministere_id) REFERENCES ministere (id);
ALTER TABLE brhp ADD CONSTRAINT FK_1A3FCC39FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE brhp ADD CONSTRAINT FK_1A3FCC39553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE brhp_perimetres_brhp ADD CONSTRAINT FK_6F3D5E399CD2AE4A FOREIGN KEY (brhp_id) REFERENCES brhp (id) ON DELETE CASCADE;
ALTER TABLE brhp_perimetres_brhp ADD CONSTRAINT FK_6F3D5E39BC37F552 FOREIGN KEY (perimetre_brhp_id) REFERENCES perimetre_brhp (id) ON DELETE CASCADE;
ALTER TABLE rlc ADD CONSTRAINT FK_B5C77165FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id);
ALTER TABLE rlc ADD CONSTRAINT FK_B5C77165AD745416 FOREIGN KEY (ministere_id) REFERENCES ministere (id);
ALTER TABLE rlc ADD CONSTRAINT FK_B5C77165FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE rlc ADD CONSTRAINT FK_B5C77165553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE rlc_perimetres_rlc ADD CONSTRAINT FK_C33ADAEB1B79D3EA FOREIGN KEY (rlc_id) REFERENCES rlc (id) ON DELETE CASCADE;
ALTER TABLE rlc_perimetres_rlc ADD CONSTRAINT FK_C33ADAEB91A7789F FOREIGN KEY (perimetre_rlc_id) REFERENCES perimetre_rlc (id) ON DELETE CASCADE;
ALTER TABLE campagne_brhp ADD CONSTRAINT FK_F10D50F9BC37F552 FOREIGN KEY (perimetre_brhp_id) REFERENCES perimetre_brhp (id);
ALTER TABLE campagne_brhp ADD CONSTRAINT FK_F10D50F9293A30F9 FOREIGN KEY (campagne_rlc_id) REFERENCES campagne_rlc (id);
ALTER TABLE campagne_brhp ADD CONSTRAINT FK_F10D50F9A3FE4415 FOREIGN KEY (ouverte_par_id) REFERENCES utilisateur (id);
ALTER TABLE campagne_brhp ADD CONSTRAINT FK_F10D50F9FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE campagne_brhp ADD CONSTRAINT FK_F10D50F9553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE campagne_brhp_document ADD CONSTRAINT FK_26C3E26D185EAC77 FOREIGN KEY (campagne_brhp_id) REFERENCES campagne_brhp (id) ON DELETE CASCADE;
ALTER TABLE campagne_brhp_document ADD CONSTRAINT FK_26C3E26DC33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE;
ALTER TABLE formation_demandee_admin ADD CONSTRAINT FK_9B352D94C235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE formation_demandee_admin ADD CONSTRAINT FK_9B352D94FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE formation_demandee_admin ADD CONSTRAINT FK_9B352D94553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE competence_poste ADD CONSTRAINT FK_F6AB5E4DC235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE competence_poste ADD CONSTRAINT FK_F6AB5E4DFC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE competence_poste ADD CONSTRAINT FK_F6AB5E4D553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
commit;
exit;
