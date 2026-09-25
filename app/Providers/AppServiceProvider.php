<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 遅延読み込み・未定義の属性へのアクセス・fillable 外の属性の代入を、本番以外では例外にする
        Model::shouldBeStrict(! $this->app->isProduction());
    }
}
