<?php

/**
 * This file is part ofBranch SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\MergeBase;

use PHPUnit\Framework\TestCase;

/**
 * Class ListRemoteTest
 *
 * @package SebastianFeldmann\Git
 * @author  David Eckhaus
 */
class MergeBaseTest extends TestCase
{
    public function testMergeBaseOfFeatureRelativeToMain(): void
    {
        $command = (new MergeBase())->ofBranch('f1')->relativeTo('main');

        $this->assertSame('git merge-base \'main\' \'f1\'', $command->getCommand());
    }

    public function testMergeBaseDefaultHEAD(): void
    {
        $command = (new MergeBase())->relativeTo('main');

        $this->assertSame('git merge-base \'main\' \'HEAD\'', $command->getCommand());
    }
}
