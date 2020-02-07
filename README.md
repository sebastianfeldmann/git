# git - a handy git wrapper

[![Latest Stable Version](https://poser.pugx.org/sebastianfeldmann/git/v/stable.svg)](https://packagist.org/packages/sebastianfeldmann/git)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/sebastianfeldmann/git.svg?v1)](https://packagist.org/packages/sebastianfeldmann/git)
[![License](https://poser.pugx.org/sebastianfeldmann/git/license.svg)](https://packagist.org/packages/sebastianfeldmann/git)
[![Build Status](https://github.com/sebastianfeldmann/git/workflows/CI-Build/badge.svg)](https://github.com/sebastianfeldmann/git/actions)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sebastianfeldmann/git/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sebastianfeldmann/git/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/sebastianfeldmann/git/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/sebastianfeldmann/git/?branch=master)

This lib is used to execute `git` commands directly from PHP via a defined api. 
All you have to do is setup a `Repository` object, retrieve a command `Operator`
and fire away. Each git command like git _config_ or git _log_ is handled
by a separate `Operator`. Follow the next steps to give it a try.


## Installation

The git package is installable via composer. Just run the following command.

```bash
$ composer require sebastianfeldmann/git
```

## Usage

Setup the `Repository`
```php
$repoRootPath  = '/var/www/my-project';
$gitRepository = new Git\Repository($repoRootPath);
```

Retrieve the needed `Operator`
```php
$log = $gitRepository->getLogOperator();
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
$log     = $gitRepository->getLogOperator();
$files   = $log->getChangedFilesSince('1.0.0');
$commits = $log->getCommitsSince('1.0.0');

// check the index status
$index = $gitRepository->getIndexOperator();
$files = $index->getStagedFiles();
```

## Available operators

- Config - Access all git settings e.g. line break settings. 
- Diff - Compare two versions.
- Index - Check the staging area.
- Info - Access the current state like branch name or commit hash.  
- Log - Returns list of changed files and other git log information.

## Example commands

Get the current tag:

    // git describe --tag
    $tag = $infoOperator->getCurrentTag(); 

Get tags for a given commit:

    // git tag --points-at HEAD
    $tags = $infoOperator->getTagsPointingTo('HEAD'); 

Get the current branch:

    // git rev-parse --abbrev-ref HEAD
    $branch = $infoOperator->getCurrentBranch(); 
    
Get a list of staged files:

    // git diff-index --cached --name-status HEAD
    $files = $indexOperator->getStagedFiles();
    
Get all current git settings:

    // git config --list
    $config = $configOperator->getSettings();
    
Get all changed files since a given commit or tag:

    // git log --format='' --name-only $HASH
    $files = $logOperator->changedFilesSince('1.0.0');

Get differences between two versions

    // git diff '1.0.0' '1.1.0'
    $changes = $diffOperator->compare('1.0.0', '1.1.0');
