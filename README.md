# git - a handy git wrapper

[![Latest Stable Version](https://poser.pugx.org/sebastianfeldmann/git/v/stable.svg)](https://packagist.org/packages/sebastianfeldmann/git)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/sebastianfeldmann/git.svg?v1)](https://packagist.org/packages/sebastianfeldmann/git)
[![License](https://poser.pugx.org/sebastianfeldmann/git/license.svg)](https://packagist.org/packages/sebastianfeldmann/git)
[![Build Status](https://travis-ci.org/sebastianfeldmann/git.svg?branch=master)](https://travis-ci.org/sebastianfeldmann/git)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sebastianfeldmann/git/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sebastianfeldmann/git/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/sebastianfeldmann/git/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/sebastianfeldmann/git/?branch=master)

This lib is used to execute `git` commands via an easy PHP api. 
All you have to do is setup a `Repository` object, retrieve a command `Operator`
and fire away. Each git command like git _config_ or git _log_ is handled
by an `Operator`. Follow the next steps to give it a try.


## Installation

The git package is installable via composer. Just run the following command.

```bash
$ composer require sebastianfeldmann/git
```

Setup the `Repository`
```php
$repoRootPath  = '/var/www/my-project';
$gitRepository = new Git\Repository($repoRootPath);
```

Retrieve the needed `Operator`
```php
$log = $repo->getLogOperator();
```

Get files and commits since some tag
```php
$files   = $log->getChangedFilesSince('1.0.0');
$commits = $log->getCommitsSince('1.0.0');
```
## Copy Paste Example

```php
use SebastianFeldmann\Git;

require __DIR__ . '/../vendor/autoload.php';

// path to repository without .git
$repoRootPath  = '/path/to/repo';
$gitRepository = new Git\Repository($repoRootPath);

// get files and commits since hash or tag
$log     = $repo->getLogOperator();
$files   = $log->getChangedFilesSince('1.0.0');
$commits = $log->getCommitsSince('1.0.0');

// check the index status
$index = $repo->getIndexOperator();
$files = $index->getStagedFiles();
```

## Example commands

Get the current tag:

    $infoOperator->getCurrentTag(); // git describe --tag
    
Get a list of staged files:

    $indexOperator->getStagedFiles(); // git diff-index --cached --name-status HEAD
    
Get all current git settings:

    $configOperator->getSettings(); // git config --list
    
Get all changed files since a given commit or tag:

    $logOperator->changedFilesSince('1.0.0'); // git log --format='' --name-only $HASH

Get differences between two versions

    $diffOperator->compare('1.0.0', '1.1.0'); // git diff '1.0.0' '1.1.0'
