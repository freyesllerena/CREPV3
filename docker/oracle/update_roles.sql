UPDATE SYSTEM.UTILISATEUR set ROLES='a:5:{i:0;s:10:"ROLE_ADMIN";i:1;s:14:"ROLE_ADMIN_MIN";i:2;s:8:"ROLE_PNC";i:3;s:8:"ROLE_RLsC";i:4;s:9:"ROLE_BRHP";}' where email_canonical like '%pnc@yopmail.com%';
UPDATE SYSTEM.UTILISATEUR set ROLES='a:2:{i:0;s:8:"ROLE_SHD";i:1;s:7:"ROLE_AH";}' where email_canonical like '%diane.bouriveau@ministere1.com%';
UPDATE SYSTEM.UTILISATEUR set ROLES='a:1:{i:0;s:10:"ROLE_AGENT";}' where email_canonical like '%lucie.valard@ministere1.com%';
UPDATE SYSTEM.UTILISATEUR set ROLES='a:1:{i:0;s:10:"ROLE_ADMIN";}' where email_canonical like '%admin@free.fr%';
UPDATE SYSTEM.UTILISATEUR set ROLES='a:1:{i:0;s:14:"ROLE_ADMIN_MIN";}' where email_canonical like '%admin.min15@yopmail.com%';