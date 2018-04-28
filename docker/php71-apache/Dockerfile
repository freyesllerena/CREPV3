FROM adrianharabula/php7-with-oci8


RUN a2enmod proxy_fcgi

ADD app.conf /etc/apache2/sites-available/

RUN ln -s /etc/apache2/sites-available/app.conf /etc/apache2/sites-enabled/app.conf
RUN rm /etc/apache2/sites-enabled/000-default.conf

RUN a2ensite app

RUN service apache2 stop
RUN service apache2 start

EXPOSE 80

WORKDIR /var/www/CREP3

CMD /usr/sbin/apache2ctl -D FOREGROUND
