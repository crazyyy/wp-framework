FROM wordpress:6.4.1-php8.3-apache

RUN apt-get update && \
	apt-get install -y nano git mc && \
	apt-get install -y  --no-install-recommends ssl-cert cron default-mysql-client && \
	rm -r /var/lib/apt/lists/* && \
	a2enmod ssl && \
	a2ensite default-ssl

ENV TZ=America/Vancouver
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY ./certs/default-ssl.conf /etc/apache2/sites-enabled/default-ssl.conf
COPY ./certs/site_com.crt /etc/ssl/certs/ssl-cert-snakeoil.crt
COPY ./certs/site_com.key /etc/ssl/private/ssl-cert-snakeoil.key

EXPOSE 80
EXPOSE 443
