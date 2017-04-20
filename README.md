# laravel-upload
[![Latest Version](https://img.shields.io/github/release/leadthread/laravel-upload.svg?style=flat-square)](https://github.com/leadthread/laravel-upload/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://travis-ci.org/leadthread/laravel-upload.svg?branch=master)](https://travis-ci.org/leadthread/laravel-upload)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/leadthread/laravel-upload/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/leadthread/laravel-upload/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/leadthread/laravel-upload/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/leadthread/laravel-upload/?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/56f3252c35630e0029db0187/badge.svg?style=flat)](https://www.versioneye.com/user/projects/56f3252c35630e0029db0187)
[![Total Downloads](https://img.shields.io/packagist/dt/leadthread/laravel-upload.svg?style=flat-square)](https://packagist.org/packages/leadthread/laravel-upload)

## Installation

Install via [composer](https://getcomposer.org/) - In the terminal:
```bash
composer require leadthread/laravel-upload
```

Now add the following to the `providers` array in your `config/app.php`
```php
LeadThread\Upload\Providers\Upload::class
```

and this to the `aliases` array in `config/app.php`
```php
"Upload" => "LeadThread\Upload\Facades\Upload",
```

Then you will need to run these commands in the terminal in order to copy the config and migration files
```bash
php artisan vendor:publish --provider="LeadThread\Upload\Providers\Upload"
```

Before you run the migration you may want to take a look at `config/upload.php` and change the `table` property to a table name that you would like to use. After that run the migration 
```bash
php artisan migrate
```

## Usage

To save the file to the disk and database:
```php
function upload(Request $request)
{
	$file = $request->file('file');

	//Returns an Eloquent Model for the file
	$model = Upload::create($file);
}
```

## Contributing
Contributions are always welcome!
