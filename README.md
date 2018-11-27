# SagaOne

SagaOne is a turn-based online journal application. You can create a journal, invite friends to join it, and take turns writing in it. The journal automatically passes from person to person after a period of time of your choosing. For example, you can create a journal that rotates to the next user every day, every week, or every month.

Only the person who has the journal can read it. When it's your turn with a journal, you can write new entries, read previous entries, and even add comments to previous entries.

SagaOne leverages the power of the Internet to create community, while fostering a small, intimate environment that avoids the pitfalls of other social networks. It's a great way to share your life and build a sense of connectedness with others!

## Local installation

1. Clone or download this repository.
1. Run these commands to set up your local environment:

```
$ composer install           # installs PHP dependencies
$ npm install                # installs JS dependencies
$ cp .env.example .env       # creates local environment file
$ php artisan key:generate   # creates local app key
```

### Serving locally

Run `php artisan serve` to serve the site to http://localhost:8000.

### Compiling assets in development

Run `npm run dev` to compile all assets once. To automatically compile when a file change is detected, run `npm run watch`.

## Deployment

SagaOne is hosted on AWS Elastic Beanstalk at https://www.saga-one.com. Follow these steps to deploy:

1. Ensure that all changes are committed. Add a git tag to assist with version tracking. (`git tag XXX`, then `git push origin XXX`)
1. Run `npm run prod` to prepare assets for production.
1. Run `composer install --no-dev` to remove dev-only composer packages.
1. Check that the proper environment settings for Elastic Beanstalk are set in the `/.ebextensions` directory. (They may be overrided by loading a saved configuration on EB, or simply by setting different environment settings within the EB console.)
1. Run `eb deploy [ENVIRONMENT] -l [GIT-TAG] -m [DESCRIPTION]`, where:
    - `[ENVIRONMENT]` is the name of the Elastic Beanstalk environemnt to which you are deploying
    - `[GIT-TAG]` is the tag you assigned this version of the application in step #1
    - `[DESCRIPTION]` is a short description of this version (perhaps the latest commit message)

If you do not have the Elastic Beanstalk CLI installed, [install it](https://docs.aws.amazon.com/elasticbeanstalk/latest/dg/eb-cli3-install.html?icmpid=docs_elasticbeanstalk_console).

