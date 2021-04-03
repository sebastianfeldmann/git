<?php

declare(strict_types=1);

namespace SebastianFeldmann\Git\Status;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;

class PathTest extends TestCase
{
    public function testGetPath(): void
    {
        $path = new Path('M ', 'file.ext');

        $this->assertSame('file.ext', $path->getPath());
    }

    public function testGetOriginalPathReturnsNull(): void
    {
        $path = new Path('M ', 'file.ext');

        $this->assertNull($path->getOriginalPath());
    }

    public function testGetOriginalPath(): void
    {
        $path = new Path('R ', 'file.ext', 'originalFile.ext');

        $this->assertSame('originalFile.ext', $path->getOriginalPath());
    }

    /**
     * @dataProvider statusConditionsProvider
     */
    public function testStatusConditions(string $status, array $methodsExpectedTrue): void
    {
        $path = new Path($status, 'file.ext');

        $this->assertSame($status, $path->getRawStatusCode());
        $this->assertSame([$status[0], $status[1]], $path->getStatusCode());

        foreach ($this->getBooleanMethods() as $method) {
            $this->assertSame(in_array($method, $methodsExpectedTrue), $path->{$method}());
        }
    }

    public function statusConditionsProvider(): array
    {
        return [
            '_A' => [
                'status' => ' A',
                'methodsExpectedTrue' => ['isNotUpdated', 'isAddedInWorkingTree'],
            ],
            '_M' => [
                'status' => ' M',
                'methodsExpectedTrue' => ['isNotUpdated', 'hasWorkingTreeChangedSinceIndex'],
            ],
            '_D' => [
                'status' => ' D',
                'methodsExpectedTrue' => ['isNotUpdated', 'isDeletedInWorkingTree'],
            ],
            'M_' => [
                'status' => 'M ',
                'methodsExpectedTrue' => ['isUpdatedInIndex', 'doesIndexMatchWorkingTree'],
            ],
            'MM' => [
                'status' => 'MM',
                'methodsExpectedTrue' => ['isUpdatedInIndex', 'hasWorkingTreeChangedSinceIndex'],
            ],
            'MD' => [
                'status' => 'MD',
                'methodsExpectedTrue' => ['isUpdatedInIndex', 'isDeletedInWorkingTree'],
            ],
            'A_' => [
                'status' => 'A ',
                'methodsExpectedTrue' => ['isAddedToIndex', 'doesIndexMatchWorkingTree'],
            ],
            'AM' => [
                'status' => 'AM',
                'methodsExpectedTrue' => ['isAddedToIndex', 'hasWorkingTreeChangedSinceIndex'],
            ],
            'AD' => [
                'status' => 'AD',
                'methodsExpectedTrue' => ['isAddedToIndex', 'isDeletedInWorkingTree'],
            ],
            'D_' => [
                'status' => 'D ',
                'methodsExpectedTrue' => ['isDeletedFromIndex', 'doesIndexMatchWorkingTree'],
            ],
            'R_' => [
                'status' => 'R ',
                'methodsExpectedTrue' => ['isRenamedInIndex', 'doesIndexMatchWorkingTree'],
            ],
            'RM' => [
                'status' => 'RM',
                'methodsExpectedTrue' => ['isRenamedInIndex', 'hasWorkingTreeChangedSinceIndex'],
            ],
            'RD' => [
                'status' => 'RD',
                'methodsExpectedTrue' => ['isRenamedInIndex', 'isDeletedInWorkingTree'],
            ],
            'C_' => [
                'status' => 'C ',
                'methodsExpectedTrue' => ['isCopiedInIndex', 'doesIndexMatchWorkingTree'],
            ],
            'CM' => [
                'status' => 'CM',
                'methodsExpectedTrue' => ['isCopiedInIndex', 'hasWorkingTreeChangedSinceIndex'],
            ],
            'CD' => [
                'status' => 'CD',
                'methodsExpectedTrue' => ['isCopiedInIndex', 'isDeletedInWorkingTree'],
            ],
            '_R' => [
                'status' => ' R',
                'methodsExpectedTrue' => ['isNotUpdated', 'isRenamedInWorkingTree'],
            ],
            'DR' => [
                'status' => 'DR',
                'methodsExpectedTrue' => ['isDeletedFromIndex', 'isRenamedInWorkingTree'],
            ],
            '_C' => [
                'status' => ' C',
                'methodsExpectedTrue' => ['isNotUpdated', 'isCopiedInWorkingTree'],
            ],
            'DC' => [
                'status' => 'DC',
                'methodsExpectedTrue' => ['isDeletedFromIndex', 'isCopiedInWorkingTree'],
            ],
            'DD' => [
                'status' => 'DD',
                'methodsExpectedTrue' => ['isUnmerged', 'areBothDeleted'],
            ],
            'AA' => [
                'status' => 'AA',
                'methodsExpectedTrue' => ['isUnmerged', 'areBothAdded'],
            ],
            'UU' => [
                'status' => 'UU',
                'methodsExpectedTrue' => ['isUnmerged', 'areBothModified'],
            ],
            'AU' => [
                'status' => 'AU',
                'methodsExpectedTrue' => ['isUnmerged', 'isAddedByUs'],
            ],
            'DU' => [
                'status' => 'DU',
                'methodsExpectedTrue' => ['isUnmerged', 'isDeletedByUs'],
            ],
            'UA' => [
                'status' => 'UA',
                'methodsExpectedTrue' => ['isUnmerged', 'isAddedByThem'],
            ],
            'UD' => [
                'status' => 'UD',
                'methodsExpectedTrue' => ['isUnmerged', 'isDeletedByThem'],
            ],
            '??' => [
                'status' => '??',
                'methodsExpectedTrue' => ['isUntracked'],
            ],
            '!!' => [
                'status' => '!!',
                'methodsExpectedTrue' => ['isIgnored'],
            ],
        ];
    }

    private function getBooleanMethods(): array
    {
        $booleanMethods = [];

        $pathReflected = new ReflectionClass(Path::class);
        $pathMethods = $pathReflected->getMethods(ReflectionMethod::IS_PUBLIC);

        foreach ($pathMethods as $method) {
            if ($this->isBooleanMethod($method->getName())) {
                $booleanMethods[] = $method->getName();
            }
        }

        return $booleanMethods;
    }

    private function isBooleanMethod(string $name): bool
    {
        $prefixes = ['is', 'does', 'has', 'are'];

        foreach ($prefixes as $prefix) {
            if (strpos($name, $prefix) === 0) {
                return true;
            }
        }

        return false;
    }
}
