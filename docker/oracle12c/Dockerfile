FROM sath89/oracle-12c

RUN apt-get update && apt-get install -y rlwrap

## Copy the dump file and put it into database_dumps created earlier
RUN chown -R oracle /u01/app/oracle/admin/xe/dpdump
COPY CREP.DMP /u01/app/oracle/admin/xe/dpdump/


## Add env variables for oracle_home and related
##ENV ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe \
##ORACLE_SID=XE

##Export oracle_home and related
#RUN echo 'export ORACLE_HOME=/u01/app/oracle/product/12.1.0/xe' >> etc/bash.bashrc
#RUN echo 'export PATH=$ORACLE_HOME/bin:$PATH' >> /etc/bash.bashrc
#RUN echo 'export ORACLE_SID=XE' >> /etc/bash.bashrc

#CMD /usr/sbin/startup.sh && /u01/app/oracle/product/12.1.0/xe/bin/impdp system/oracle DUMPFILE=CREP.DMP SCHEMAS=crep TABLE_EXISTS_ACTION=REPLACE  && /usr/sbin/sshd -D
