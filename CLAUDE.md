# CLAUDE.md

## 前提

開発環境は Sail で Docker 上に構築する。`php` や `composer` はホストで直接実行せず、Sail 経由で実行する。

## コマンド

```bash
./vendor/bin/sail up -d               # 起動（アプリは http://localhost、Mailpit は http://localhost:8025）
./vendor/bin/sail down                # 停止
./vendor/bin/sail artisan <cmd>       # Artisan
./vendor/bin/sail composer <cmd>      # Composer
./vendor/bin/sail test                # テスト
./vendor/bin/sail pint                # 書式を整える
./vendor/bin/sail pint --test         # 書式を検査（ファイルは変更しない）
./vendor/bin/sail bin phpstan analyse # 静的解析
```

`vendor/` がないとき（clone 直後など）は、Sail のイメージで依存関係をインストールする。

```bash
docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html \
    laravelsail/php84-composer:latest composer install --ignore-platform-reqs
```

## 言語

コメント・ドキュメント・コミットメッセージ・issue・pull request は日本語で書く。識別子は英語。

## Git の運用

- 変更ごとにブランチを作り、`main` に直接コミットしない。ブランチ名は `<type>/<英語のケバブケース>`（例: `docs/add-claude-md-and-templates`）。
- 1 つのコミットには 1 つの論理的な変更だけを入れ、各コミットの時点で検査が通る状態を保つ。
- 作業は 1 コミットずつ進める。次のコミットに入る分だけを書いてコミットし、それから次に進む。まとめて作ってから後で分割しない。
- **コミットする前に、コミットメッセージと変更の要約を提示して承認を待つ。** ファイルの内容を下書きとして先に見せる必要はない。
- **push する前に止まり、ユーザーが差分と pull request の本文を確認できるようにする。** 承認を得てから push し、pull request を作成する。
- **pull request をマージしない。** 作成したら URL を報告して止まる。マージはユーザーがマージコミットで行う。
- マージ前の修正は `git commit --fixup` と `git rebase --autosquash` で元のコミットにまとめ、`git push --force-with-lease` で反映する。修正用のコミットを積まない。
- ツールやパッケージは、それを最初に必要とする変更と同じ pull request で導入する。

### コミットメッセージ

- 件名は Conventional Commits の type に続けて日本語で書き、「README を作成」のように体言止めにする。句点は付けない。
- 本文は「〜する。」の現在形で書く。変更が複数あれば `-` の箇条書きにする。

## issue と pull request

- 本文は `.github/ISSUE_TEMPLATE/task.md` と `.github/pull_request_template.md` に従う。書き方の指針はテンプレート内のコメントにある。
- テンプレートを読んで埋め、コメントとフロントマターを取り除いた本文を、クォートしたヒアドキュメント経由で `--body-file -` に渡す。テンプレート自体は編集しない。
- ラベルは Conventional Commits の type と同じ名前のものを 1 つ付ける。マイルストーンは作業が属するものを付ける。
- pull request は、対応する issue を `Closes #N` で参照する。

## ロードマップ

- 作業はマイルストーン（`M0 開発基盤` 〜 `M9 仕上げ`）の順に進め、issue は進行中のマイルストーンの分だけ作る。マイルストーンはタイトルで参照する（番号は順序と一致しない）。
- 進行中のマイルストーンにない作業は、始める前にユーザーに確認する。
- ラベル・マイルストーン・issue・ルールセットなど GitHub 上で直接行う変更は、差分としてレビューできないため、先に案を提示して承認を得る。
