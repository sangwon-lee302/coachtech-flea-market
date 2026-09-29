<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // アセットをビルドしていない環境（CI など）でもテストを実行できるよう、Vite のマニフェストを読まない
        $this->withoutVite();
    }
}
