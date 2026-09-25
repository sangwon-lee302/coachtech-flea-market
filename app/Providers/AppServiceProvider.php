<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
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

        // 日時の計算で元の値を書き換えてしまわないよう、変更不可の CarbonImmutable を使う
        Date::use(CarbonImmutable::class);

        // 本番では migrate:fresh・migrate:reset・db:wipe などの破壊的なコマンドを禁止する
        DB::prohibitDestructiveCommands($this->app->isProduction());
    }
}
