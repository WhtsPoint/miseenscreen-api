![img.png](logo.png)
## Start Usage

### Dev environment

- Install [Symfony CLI](https://symfony.com/download)
- Install dependencies

   ```sh 
  composer i
    ````

- [Make Migrations](#migrations)
- [Generate JWT Keys](#migrations)

- Run dev server
  ```sh
  symfony server:start
  ```

### Prod environment

- Run [Miseenscreen UI](https://github.com/WhtsPoint/miseenscreen-ui) prod build

- Run docker containers

    ```sh 
  docker compose up -d 
    ```
- Change docker volumes owner
   ```sh 
  docker exec 
  -u root
  -it <fpm_container>
  chown www-data:www-data /var/www/html/config/jwt
    ```

- Exec fpm container via
   ```sh 
  docker exec -it <fpm_container>
    ```
  and make [migrations](#migrations), [generate JWT keys](#jwt-keys)

## Migrations

- Make Migrations
  ```sh
  php bin/console doctrine:migrations:diff 
  php bin/console doctrine:migrations:migrate
  ``` 

## JWT Keys

- Generate JWT keys
  ```sh
  php bin/console lexik:jwt:generate-keypair
  ```

## Generate admin user

- Generate password via
  ```sh
  php bin/console security:hash-password
  ```
Put `ADMIN_LOGIN` and `ADMIN_PASSWORD` to `.env.local`

## Environment setup


|        Variable        |                Description                |                       Default Value                        |
|:----------------------:|:-----------------------------------------:|:----------------------------------------------------------:|
|     `ADMIN_LOGIN`      |           Login for admin panel           |                             -                              |
|    `ADMIN_PASSWORD`    | Password for admin panel (must be hashed) |                             -                              |
| `RECAPTCHA_SECRET_KEY` |        Secret key for ReCaptcha v2        | 6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe (Key for testing) |