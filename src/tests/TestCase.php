<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware; 
use App\Http\Middleware\VerifyCsrfToken;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use WithoutMiddleware;                                          // ← 追加

    protected function setUp(): void
    {
        parent::setUp();
        // 明示的に CSRF ミドルウェアだけ外す場合：
        $this->withoutMiddleware(VerifyCsrfToken::class);
    }
}
