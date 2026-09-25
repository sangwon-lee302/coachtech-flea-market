<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class TranslationTest extends TestCase
{
    /**
     * @return array<string, array{string}>
     */
    public static function files(): array
    {
        return [
            'auth' => ['auth.php'],
            'validation' => ['validation.php'],
        ];
    }

    #[DataProvider('files')]
    public function test_japanese_file_has_all_framework_keys(string $file): void
    {
        $root = dirname(__DIR__, 2);

        $framework = $this->keys($this->load($root.'/vendor/laravel/framework/src/Illuminate/Translation/lang/en/'.$file));
        $japanese = $this->keys($this->load($root.'/lang/ja/'.$file));

        $this->assertSame([], array_values(array_diff($framework, $japanese)));
    }

    /**
     * @return array<mixed>
     */
    private function load(string $path): array
    {
        $lines = require $path;

        if (! is_array($lines)) {
            $this->fail($path.' が配列を返していません。');
        }

        return $lines;
    }

    /**
     * 入れ子の配列を「min.string」のようなドット区切りのキーの一覧にする。
     *
     * @param  array<mixed>  $lines
     * @return list<string>
     */
    private function keys(array $lines, string $prefix = ''): array
    {
        $keys = [];

        foreach ($lines as $key => $line) {
            if (is_array($line) && ! in_array($prefix.$key, ['custom', 'attributes'], true)) {
                $keys = [...$keys, ...$this->keys($line, $prefix.$key.'.')];
            } else {
                $keys[] = $prefix.$key;
            }
        }

        return $keys;
    }
}
