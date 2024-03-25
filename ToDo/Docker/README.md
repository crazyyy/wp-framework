# WP Docker

## How to use

### Build

1. copy `docker/env/.env_template` file and paste it in the same folder under the name of `.env`;
2. set (if it needs) the DB and WP settings in env file `docker/env/.env`;
3. run shell script `bash project_build.sh` this script will:
   - install docker docker-composer and other required application
   - unzip JAVA APP files in the project folder;
   - build the docker WP instance with DB;

```sh
bash project_build.sh
```

### Editing styles

> **! Note:** change the styles in `wp-content/themes/pente/assets/scss` directory only.
> They will be automatically compiled to css, compressed and placed in `wp-content/themes/wpbase/assets/css`
>
> This process is managed by Gulp and "gulp_watch" Docker container

Whenever you want to change the Gulp configuration you can easily do it in `Gulp/gulpfile.js`

If you need to install some new npm dependency use the following command:

```sh
docker-compose -f docker-compose.dev.yml exec gulp_watch npm install <package_name> --save
```

In the same fashion you can of course use any other npm command (`npm install <package_name> --save` in the example above)
