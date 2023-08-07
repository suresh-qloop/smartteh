# SmartTEH

Made using [CakePHP](https://cakephp.org/) 2.9.

## Server requirements

- PHP 8.1
- MySQL >= 5.7.8
- [wkhtmltopdf](https://wkhtmltopdf.org/) v0.12.6 (with patched qt)
- [composer](https://getcomposer.org/)
- [npm](https://www.npmjs.com/)

## Installation

1. Clone repository: `git clone git@bitbucket.org:migbaltic/smartteh.git`
2. Install dependencies `composer install && yarn install` (add `--production` and `--no-dev` options for production server);
3. Copy `.env.example` to `.env` and configure it.
4. Create empty database and run `npm run migrate`.
5. Setup Cron (see below).
6. Install githooks: `npm run githooks`;
7. Make these files writable:
 * `Locales`
 * `tmp`
 * `webroot/uploads`


# Code quality and testing

You should adhere to our code style. Currently we only support PHPStorm codestyle file (located at `_infrastructure/codestyle.xml`).

All tests are run automatically during deployment. To run manually:

```
composer run tests
```


### PHP_CodeSniffer

It is run on each commit. To run manually:

```
./Vendor/bin/phpcs --standard=ruleset.xml app tests
```

## Git hooks

You can temporarily disable git hooks by passing `--no-verify` argument to git command during commit.
This can be useful when you change file and it fails code style check for existing code but you can not fix it right away.


## CSS/JS compilation

Project uses [LESS](http://lesscss.org/) for CSS. In `APP_DEBUG=1` mode assets are generated on the fly when page is reloaded.
Before pushing to production server, run `npm run build`.


## Cron

Test that cron script is executable by running `cd /full/path/to/app && Console/cake cron`. You should see general project info and `Where do you want to go today?` message.

Add these commands to cron:

```
* * * * * /path/to/app/Console/cake cron everyMinute > /dev/null 2>&1
*/10 * * * * /path/to/app/Console/cake cron every10Minutes > /dev/null 2>&1
20 * * * * /path/to/app/Console/cake cron hourly > /dev/null 2>&1
5 0 * * * /path/to/app/Console/cake cron daily > /dev/null 2>&1
10 0 * * 1 /path/to/app/Console/cake cron weekly > /dev/null 2>&1
15 0 1 * * /path/to/app/Console/cake cron monthly > /dev/null 2>&1
```


## Changing database schema

All schema changes must be done via [migrations](https://github.com/CakeDC/migrations). After changing database schema, run `npm run migrate:generate` to generate new migration. Overwrite existing schema.php file when asked. To apply pending changes, run `npm run migrate`. To revert last migration, run `npm run migrate:rollback`. You can update `schema.php` file by running `Console/cake schema generate` (always use "overwrite" option).


## MySQL: Disable ONLY_FULL_GROUP_BY

```
SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY', ''));
```

## Deployment to production

Pushing `staging` branch to BitBucket will deploy to test.smartteh.eu automatically.

Production code must be pushed straight to production server.

**IMPORTANT!** Refactor production deployment.

## Set up Bitbucket's deployment pipeline

Every push to `master` and `staging` branches will trigger Bitbucket's pipelines to run tests then ssh into server and execute `update.sh` script.

1. [Enable pipelines](https://bitbucket.org/migbaltic/smartteh/admin/addon/admin/pipelines/settings)
2. Add `PRODUCTION_SERVER_IP`, `STAGING_SERVER_IP`, `DB_DATABASE=testing`, `DB_USERNAME=testing`, `DB_PASSWORD=testing` to [Repository variables](https://bitbucket.org/migbaltic/smartteh/admin/addon/admin/pipelines/repository-variables). These values are available in `bitbucket-pipelines.yml` during deployment.
3. Generate new [SSH key](https://bitbucket.org/migbaltic/smartteh/admin/addon/admin/pipelines/ssh-keys) in Bitbucket and add it to server's `~/.ssh/authorized_keys`.
4. Add server to [Known Hosts](https://bitbucket.org/migbaltic/smartteh/admin/addon/admin/pipelines/ssh-keys). Note: MIG server uses port `722`. Use `smartteh.eu:722` as _Host address_.
5. Add server's [SSH key to Bitbucket](https://bitbucket.org/migbaltic/smartteh/admin/access-keys/). Key can be generated using `ssh-keygen -t ed25519 -f /var/www/clients/client1/web4/home/migbalticsmartteh/.ssh/id_ed25519`. Note: MIG server tries to save new key  in `/var/www/clients/client1/web{X}/.ssh/`, when it should be explicitly told to save in `/var/www/clients/client1/web{X}/home/{SITE}/.ssh/`

