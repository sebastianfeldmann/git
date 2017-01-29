# git - a handy git wrapper

[![Latest Stable Version](https://poser.pugx.org/sebastianfeldmann/git/v/stable.svg)](https://packagist.org/packages/sebastianfeldmann/git)
[![Downloads](https://img.shields.io/packagist/dt/sebastianfeldmann/git.svg?v1)](https://packagist.org/packages/sebastianfeldmann/git)
[![License](https://poser.pugx.org/sebastianfeldmann/git/license.svg)](https://packagist.org/packages/sebastianfeldmann/git)
[![Build Status](https://travis-ci.org/sebastianfeldmann/git.svg?branch=master)](https://travis-ci.org/sebastianfeldmann/git)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sebastianfeldmann/git/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sebastianfeldmann/git/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/sebastianfeldmann/git/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/sebastianfeldmann/git/?branch=master)

## Usage Example

Access some basic logs.
```php
use SebastianFeldmann\Git\Repository;

$pathToRepo = '/path/to/repo';
$repository = new Respository($pathToRepo);
$log        = $repo->getLogOperator();
$files      = $log->getChangedFilesSince('1.0.0');
$commits    = $log->getCommitsSince('1.0.0');
```

To get some info about the current index state.
```php
use SebastianFeldmann\Git\Repository;

$pathToRepo = '/path/to/repo';
$repository = new Respository($pathToRepo);
$index      = $repo->getIndexOperator();
$files      = $index->getStagedFiles();
```
