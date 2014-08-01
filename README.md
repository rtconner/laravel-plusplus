Laravel++ (Laravel-PlusPlus)
================

I really have this project here for myself only. But you are free to use it if you like it. It's just a collection of functionality and additions that I want to have in all of my Laravel projects. It assumes full use of twitter bootstrap and jquery.

Laravel makes development very fast. This packages is meant to make it just a little bit faster.

```php
'providers' => array(
	'Conner\PlusPlus\PlusPlusServiceProvider',
),
'aliases' => array(
	'Form'            => 'Conner\PlusPlus\BootstrapFormFacade',
),
```

Added consants: SECOND, MINUTE, HOUR, DAY, WEEK, MONTH, YEAR, DS
Some copy and paste templates in the copypasta folder.

Collection of functions that are very useful
```php
array_make('New', 'Used'); // build array with key=values (great for selects)
cacert_path(); // full path to cacert.pem
csve($str, $quote=false); // escape for csv files
jse($str); // escape for inline javascript
money($amount, $fmt = 'USD'); // quick money format
strip_nl($str); // strip new lines from a string
ordinal(4); // 4th 3rd 2nd, etc
queries(); // array of query log
query_interpolate($query, $bindings); // manually create query from PDO bindings
valordash($val); // dash if str is empty
```

Use a UUID as a primary ID for any model with this trait.
```php
$table->string('id', 36)->primary(); // put this into a migration on the table

use Conner\PlusPlus\UuidableTrait;
```

Extra added console commands
```bash
php artisan db:expunge # delete all tables from your database
php artisan code:perms # 660 files and 770 the folders
php artisan code:migrate # pull, clear caches, migrate, optimize
```

View helpers
```php
Form::check('is_checked'); // same as checkbox, but with hidden field
HTML::gravatar('email@email.com');
HTML::pageHeader($title, $small=''); // create bootstrap page-header div
```

```html
<!-- some view partials that I like to use -->
@include('plusplus::show')
@include('plusplus::delete-btn')
```

Copyright 2014 Robert Conner, You may use this code under The MIT License (MIT)