# laravel-edm

[![Latest Version on Packagist](https://img.shields.io/packagist/v/atakanatici/laravel-edm.svg?style=flat-square)](https://packagist.org/packages/atakanatici/laravel-edm)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/atakanatici/laravel-edm/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/atakanatici/laravel-edm/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/atakanatici/laravel-edm/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/atakanatici/laravel-edm/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/atakanatici/laravel-edm.svg?style=flat-square)](https://packagist.org/packages/atakanatici/laravel-edm)

Laravel EDM provide integration of e-fatura

## Installation

You can install the package via composer:

```bash
composer require atakanatici/laravel-edm
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-edm-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-edm-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-edm-views"
```

## Usage

```php
$eDM = new AtakanAtici\EDM();
echo $eDM->echoPhrase('Hello, AtakanAtici!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [ATAKAN ATICI](https://github.com/AtakanAtici)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
