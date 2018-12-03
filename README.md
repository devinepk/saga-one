# SagaOne

SagaOne is a turn-based shared journal application. You can create a journal, invite friends to join it, and take turns writing in it. The journal automatically passes from person to person after a set period of time. For example, you can create a journal that rotates to the next user every day, every week, or every month.

Only the person who has the journal can read it. When it's your turn with a journal, you can write new entries, read previous entries, and even add comments to previous entries.

SagaOne leverages the power of the Internet to create community regardless of distance, while fostering a small but fosters a small, intimate environment. It's a great way to share your life and build a sense of connection with others!

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

1. Run `npm run prod` to prepare assets for production.
1. Run `composer install --no-dev` to remove dev-only composer packages.
1. Commit all changes and push.
1. Add a git tag to assist with version tracking. (`git tag XXX`, then `git push origin XXX`)
1. Check that the proper environment settings for Elastic Beanstalk are set in the `/.ebextensions` directory. (They may be overridden by setting different environment settings within the EB console.)
1. Run `eb deploy [ENVIRONMENT] -l [GIT-TAG] -m [DESCRIPTION]`, where:
    - `[ENVIRONMENT]` is the name of the Elastic Beanstalk environment to which you are deploying (usually a staging environment)
    - `[GIT-TAG]` is the tag you assigned this version of the application in step #1
    - `[DESCRIPTION]` is a short description of this version (perhaps the latest commit message)

If you do not have the Elastic Beanstalk CLI installed, [install it](https://docs.aws.amazon.com/elasticbeanstalk/latest/dg/eb-cli3-install.html?icmpid=docs_elasticbeanstalk_console).

## Production and Staging Environments

SagaOne uses a [blue/green deployment strategy](https://octopus.com/docs/deployment-patterns/blue-green-deployments). At any given time, one environment (perhaps the "blue" one) is _live_ and public-facing. The other (the "green" one) is _idle_ and not public-facing.

There is also a "staging" environment that is **not** connected to the production database.

Follow this procedure to deploy a new version of SagaOne to the live, public-facing site:

1. Deploy from your local environment to the AWS staging environment as described above.
1. Test the version in the staging environment.
1. If all is well, deploy this version to the _idle_ production environment.
1. Test the version in the idle production environment.
1. If all is well, switch the URLs so that the _idle_ environment is now _live_. (The _live_ in environment gets the old _idle_ URL.)

## Task Scheduling, the Queue, and the Worker Environment

Locally, set up a crontab job to run tasks. `crontab -l` lists any tasks registered for you, and `crontab -e` creates a new one. Cf. [Laravel Task Schedules docs](https://laravel.com/docs/5.7/scheduling#scheduling-artisan-commands).

But AWS doesn't support crontab. Instead, setup a "worker" environment in AWS and set the environment variable `REGISTER_WORKER_ROUTES` to `true` for this environment. The `cron.yaml` file in the root instructs AWS to post to the route `/worker/schedule`, which runs the tasks.

In production, SagaOne uses an Amazon Simple Queue Service (SQS) queue, and the `QUEUE_CONNECTION` environment setting should be set to `sqs`. (Locally and in staging, this setting should be set to `sync`.) SQS will post queue items to `/worker/queue` on the worker environment. Make sure the version deployed to the worker environment matches the one deployed to production.

The worker environment connects to the same database as the production environment.

## Filesystem Considerations

SagaOne uses an AWS S3 bucket as its default filesystem. Ensure that you have set the bucket credentials in the environment settings of each environment.
