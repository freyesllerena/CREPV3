ALTER TABLE UTILISATEUR_TMP ADD (locked NUMBER(1) DEFAULT NULL NULL);
ALTER TABLE MODELE_CREP MODIFY (path_vers_modele_pdf VARCHAR2(255) NOT NULL, template_pdf VARCHAR2(255) NOT NULL);
commit;
exit;