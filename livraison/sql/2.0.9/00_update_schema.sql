CREATE SEQUENCE recours_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE TABLE recours (id NUMBER(10) NOT NULL, crep_id NUMBER(10) NOT NULL, cree_par_id NUMBER(10) DEFAULT NULL NULL, modifie_par_id NUMBER(10) DEFAULT NULL NULL, type NUMBER(10) NOT NULL, date_demande DATE NOT NULL, decision NUMBER(10) DEFAULT NULL NULL, decision_prise_en_compte NUMBER(10) DEFAULT NULL NULL, date_decision DATE DEFAULT NULL NULL, date_creation TIMESTAMP(0) NOT NULL, date_modification TIMESTAMP(0) NOT NULL, PRIMARY KEY(id));
CREATE INDEX IDX_854AFB14C235614F ON recours (crep_id);
CREATE INDEX IDX_854AFB14FC29C013 ON recours (cree_par_id);
CREATE INDEX IDX_854AFB14553B2554 ON recours (modifie_par_id);
ALTER TABLE recours ADD CONSTRAINT FK_854AFB14C235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE recours ADD CONSTRAINT FK_854AFB14FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE recours ADD CONSTRAINT FK_854AFB14553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);

commit;
exit;