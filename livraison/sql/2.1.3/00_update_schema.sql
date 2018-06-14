ALTER TABLE CREP_SCL_COMP_TRANS DROP CONSTRAINT FK_EA2CEAA585ECD9A8;
DROP INDEX idx_ea2ceaa585ecd9a8;
DROP INDEX uniq_ea2ceaa584e0fe3e85ecd9a8;
ALTER TABLE CREP_SCL_COMP_TRANS ADD (cree_par_id NUMBER(10) DEFAULT NULL NULL, modifie_par_id NUMBER(10) DEFAULT NULL NULL, libelle CLOB NOT NULL, type_competence VARCHAR2(255) DEFAULT NULL NULL, date_creation TIMESTAMP(0) NOT NULL, date_modification TIMESTAMP(0) NOT NULL);
ALTER TABLE CREP_SCL_COMP_TRANS DROP (COMPETENCE_TRANSVERSE_ID);
ALTER TABLE CREP_SCL_COMP_TRANS ADD CONSTRAINT FK_EA2CEAA5FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE CREP_SCL_COMP_TRANS ADD CONSTRAINT FK_EA2CEAA5553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
CREATE INDEX IDX_EA2CEAA5FC29C013 ON CREP_SCL_COMP_TRANS (cree_par_id);
CREATE INDEX IDX_EA2CEAA5553B2554 ON CREP_SCL_COMP_TRANS (modifie_par_id);
CREATE UNIQUE INDEX UNIQ_EA2CEAA584E0FE3EBF396750 ON CREP_SCL_COMP_TRANS (crep_scl_id, id);

commit;
exit;