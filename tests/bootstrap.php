<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

define('SF_GIT_PATH_ROOT', realpath(__DIR__ . '/..'));
define('SF_GIT_PATH_FILES', realpath(__DIR__ . '/files'));

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/Git/DummyRepo.php';

