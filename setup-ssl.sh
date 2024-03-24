#!/bin/bash

domains=("miseenscreen.com"  "api.miseenscreen.com")

for domain in ${domains[@]}
do	
	export DOMAIN=$domain
	docker compose -f docker-compose.ssl-setup.yaml up nginx-ssl -d
	docker compose -f docker-compose.ssl-setup.yaml run --rm certbot certonly --webroot --webroot-path /var/www/certbot/ -n -d $domain -m whtspoint@gmail.com --agree-tos
	docker compose -f docker-compose.ssl-setup.yaml down nginx-ssl
done

