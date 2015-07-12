Laravel++ Copy & Paste Templates
================

This folder has templates that are meant to be copy-paste-modify into your laravel project.

##Install Crons 

edit app/start/artisan.php
```php
Artisan::add(new Conner\Command\CronHour());
Artisan::add(new Conner\Command\CronDay());
Artisan::add(new Conner\Command\CronWeek());
Artisan::add(new Conner\Command\CronMonth());
Artisan::add(new Conner\Command\RebuildDatabase());
```
  
```bash
crontab -e
  
@hourly /var/www/staging/artisan cron:hour
@daily /var/www/staging/artisan cron:day
@weekly /var/www/staging/artisan cron:week
@monthly /var/www/staging/artisan cron:month
```