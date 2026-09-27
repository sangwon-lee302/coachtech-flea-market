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
- pull request では CI（`.github/workflows/ci.yml`）が Pint の検査・Larastan・テストを実行する。push する前に、同じ検査を手元でも通しておく。
- 作業は 1 コミットずつ進める。次のコミットに入る分だけを書いてコミットし、それから次に進む。まとめて作ってから後で分割しない。
- **コミットする前に、コミットメッセージと変更の要約を提示して承認を待つ。** ファイルの内容を下書きとして先に見せる必要はない。
- **push する前に止まり、ユーザーが差分と pull request の本文を確認できるようにする。** 承認を得てから push し、pull request を作成する。
    - 止まるときは、まずブランチの目的と、それを達成するために何をどう変えたか、作業の途中で決めたことを、見出しや箇条書きを使わずに数文でまとめる。コミットを 1 つずつ並べるのではなく、変更と目的とのつながりが分かるように書く。
    - そのうえで、pull request のタイトル・本文・ラベル・マイルストーンを示し、issue の完了条件ごとに、それを確かめる根拠（テスト・動作確認の項目など）を挙げ、根拠のない項目があれば伝える。
- **pull request をマージしない。** 作成したら URL を報告して止まる。マージはユーザーがマージコミットで行う。
- マージ前の修正は `git commit --fixup` と `git rebase --autosquash` で元のコミットにまとめ、`git push --force-with-lease` で反映する。修正用のコミットを積まない。
- ツールやパッケージは、それを最初に必要とする変更と同じ pull request で導入する。使うコマンドがあれば、同じ pull request で CLAUDE.md に追記する。

### コミットメッセージ

- 件名は Conventional Commits の type に続けて日本語で書き、「README を作成」のように体言止めにする。句点は付けない。
- 本文は「〜する。」の現在形で書く。変更が複数あれば `-` の箇条書きにする。
- 箇条書きは、各項目がそれより前の項目にだけ依存する順に並べ、変更の元になる決定を先頭に置く。関連する複数の変更をまとめたコミットでは、箇条書きの前に中心となる変更を述べる段落を置く。
- GitHub はコミットメッセージを Markdown として表示しないため、コマンドや識別子もバッククォートで囲まずに書く。

## issue と pull request

- 本文は `.github/ISSUE_TEMPLATE/task.md` と `.github/pull_request_template.md` に従う。書き方の指針はテンプレート内のコメントにある。
- テンプレートを読んで埋め、コメントとフロントマターを取り除いた本文を、クォートしたヒアドキュメント経由で `--body-file -` に渡す。テンプレート自体は編集しない。
- ラベルは Conventional Commits の type と同じ名前のものを 1 つ付ける。マイルストーンは作業が属するものを付ける。
- issue の完了条件には、その issue で達成する成果だけを並べ、サンプルのファイルの削除のような片付けは含めない。各項目は、その issue の pull request をマージする時点で判定できるものにする。
- pull request は、対応する issue を `Closes #N` で参照する。
- `Closes #N` は issue を閉じるが、完了条件にチェックは付けない。pull request を作成するときに、`gh` で issue の完了条件にチェックを付ける。

## ロードマップ

- 作業はマイルストーン（`M0 開発基盤` 〜 `M9 仕上げ`）の順に進め、issue は進行中のマイルストーンの分だけ作る。マイルストーンはタイトルで参照する（番号は順序と一致しない）。
- 進行中のマイルストーンにない作業は、始める前にユーザーに確認する。
- ラベル・マイルストーン・issue・ルールセットなど GitHub 上で直接行う変更は、差分としてレビューできないため、先に案を提示して承認を得る。

## CLAUDE.md の管理

- 一般的な作法ではなく、書かなければ守られない規約だけを書く。
- 改善はどのマイルストーンにも属さず、必要に気付いた時点で行う。
