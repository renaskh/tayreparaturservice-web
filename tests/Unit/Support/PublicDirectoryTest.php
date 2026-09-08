<?php

namespace Tests\Unit\Support;

use App\Support\PublicDirectory;
use PHPUnit\Framework\TestCase;

class PublicDirectoryTest extends TestCase
{
    public function test_falls_back_to_the_laravel_public_directory(): void
    {
        $base = sys_get_temp_dir().DIRECTORY_SEPARATOR.'trs-public-'.uniqid();
        mkdir($base.DIRECTORY_SEPARATOR.'public', 0777, true);

        try {
            $this->assertSame(
                $base.DIRECTORY_SEPARATOR.'public',
                PublicDirectory::resolve($base)
            );
        } finally {
            $this->removeDirectory($base);
        }
    }

    public function test_uses_a_sibling_public_html_directory_when_present(): void
    {
        $domain = sys_get_temp_dir().DIRECTORY_SEPARATOR.'trs-domain-'.uniqid();
        $base = $domain.DIRECTORY_SEPARATOR.'tayreparaturservice';
        mkdir($base, 0777, true);
        mkdir($domain.DIRECTORY_SEPARATOR.'public_html', 0777, true);

        try {
            $this->assertSame(
                $domain.DIRECTORY_SEPARATOR.'public_html',
                PublicDirectory::resolve($base)
            );
        } finally {
            $this->removeDirectory($domain);
        }
    }

    private function removeDirectory(string $path): void
    {
        if (! is_dir($path)) {
            return;
        }

        $items = scandir($path) ?: [];

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $target = $path.DIRECTORY_SEPARATOR.$item;

            if (is_dir($target)) {
                $this->removeDirectory($target);

                continue;
            }

            unlink($target);
        }

        rmdir($path);
    }
}
