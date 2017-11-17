# diffchecker

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Style CI][ico-styleci]][link-styleci]
[![Code Coverage][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

An object oriented class for the DiffChecker tool.

## Structure

```
bin/
src/
tests/
vendor/
```

## Install

Via Composer

``` bash
$ composer require pxgamer/diffchecker-php
```

## Usage

```bash
diffchecker list
```

These classes utilise the DiffChecker API. In order to use this, you will require an account ([Sign up here](https://www.diffchecker.com/signup)).

`pxgamer\DiffChecker\Config`  
- `::BASE_URL` (The main website URL for DiffChecker, this is used when returning links to the created Diff.)
- `::API_URL` (The API URL for DiffChecker, this is used in the API calls.)

`pxgamer\DiffChecker\Command\Authorise`  
- `configure()` (This is used by Symfony console)
- `execute()` (This is used by Symfony console)
- `::authorise($email, $password)` (This is the static authorisation function used to retrieve an access token.)

`pxgamer\DiffChecker\Command\DiffChecker`  
- `configure()` (This is used by Symfony console)
- `execute()` (This is used by Symfony console)
- `::diff($file_1, $file_2, $expires = 'forever')` (This is the static diff function used to create a new Diff between 2 files.)

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email owzie123@gmail.com instead of using the issue tracker.

## Credits

- [pxgamer][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/pxgamer/diffchecker.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/pxgamer/diffchecker-php/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/90740779/shield
[ico-code-quality]: https://img.shields.io/codecov/c/github/pxgamer/diffchecker-php.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/pxgamer/diffchecker.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/pxgamer/diffchecker
[link-travis]: https://travis-ci.org/pxgamer/diffchecker-php
[link-styleci]: https://styleci.io/repos/90740779
[link-code-quality]: https://codecov.io/gh/pxgamer/diffchecker-php
[link-downloads]: https://packagist.org/packages/pxgamer/diffchecker
[link-author]: https://github.com/pxgamer
[link-contributors]: ../../contributors
