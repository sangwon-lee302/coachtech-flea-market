<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        // @phpstan-ignore method.alreadyNarrowedType (スケルトンのサンプルテスト。実際のテストを追加するときに削除する)
        $this->assertTrue(true);
    }
}
