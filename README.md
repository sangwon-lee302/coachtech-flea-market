# COACHTECH フリマ

商品の出品と購入ができるフリマアプリ。

## 使用技術

- PHP 8.5
- Laravel 13.33.0
- MySQL 8.4.11
- Laravel Sail 1.68.0（Docker による開発環境）
- Mailpit 1.31.2（開発用のメールサーバー）

## 環境構築

Docker と Git が必要。

1. リポジトリを clone する。

    ```bash
    git clone git@github.com:sangwon-lee302/coachtech-flea-market.git
    cd coachtech-flea-market
    ```

2. 環境変数のファイルを作る。

    ```bash
    cp .env.example .env
    ```

3. 依存関係をインストールする。PHP と Composer はホストに不要で、Sail のイメージで実行する。

    ```bash
    docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html \
        laravelsail/php84-composer:latest composer install --ignore-platform-reqs
    ```

4. コンテナを起動する。`--wait` で MySQL が接続を受け付けるまで待つ。初回はイメージのビルドに時間がかかる。

    ```bash
    ./vendor/bin/sail up --wait
    ```

5. アプリケーションキーを生成し、マイグレーションを実行する。

    ```bash
    ./vendor/bin/sail artisan key:generate
    ./vendor/bin/sail artisan migrate
    ```

起動後は次の URL で開ける。

| 対象 | URL |
| --- | --- |
| アプリ | http://localhost |
| Mailpit | http://localhost:8025 |

停止するときは `./vendor/bin/sail down` を実行する。
