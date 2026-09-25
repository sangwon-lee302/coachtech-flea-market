<?php

return [

    /*
    |--------------------------------------------------------------------------
    | バリデーションのメッセージ
    |--------------------------------------------------------------------------
    |
    | バリデーションのルールごとのエラーメッセージ。サイズのように、値の型に
    | よってメッセージが変わるルールもある。
    |
    */

    'accepted' => ':attributeを承認してください。',
    'accepted_if' => ':otherが:valueの場合、:attributeを承認してください。',
    'active_url' => ':attributeには有効なURLを入力してください。',
    'after' => ':attributeには:dateより後の日付を入力してください。',
    'after_or_equal' => ':attributeには:date以降の日付を入力してください。',
    'alpha' => ':attributeには英字のみを入力してください。',
    'alpha_dash' => ':attributeには英数字・ハイフン・アンダースコアのみを入力してください。',
    'alpha_num' => ':attributeには英数字のみを入力してください。',
    'any_of' => ':attributeが正しくありません。',
    'array' => ':attributeは配列で指定してください。',
    'array_keys' => ':attributeには次のキーのみを含めてください: :values',
    'ascii' => ':attributeには半角の英数字と記号のみを入力してください。',
    'base64' => ':attributeには有効なBase64の文字列を入力してください。',
    'before' => ':attributeには:dateより前の日付を入力してください。',
    'before_or_equal' => ':attributeには:date以前の日付を入力してください。',
    'between' => [
        'array' => ':attributeは:min個から:max個の間で指定してください。',
        'file' => ':attributeには:minKBから:maxKBの間のファイルを指定してください。',
        'numeric' => ':attributeには:minから:maxの間の数値を入力してください。',
        'string' => ':attributeは:min文字から:max文字の間で入力してください。',
    ],
    'boolean' => ':attributeにはtrueかfalseを指定してください。',
    'can' => ':attributeに許可されていない値が含まれています。',
    'confirmed' => ':attributeと確認用の入力が一致しません。',
    'contains' => ':attributeに必要な値が含まれていません。',
    'current_password' => 'パスワードが正しくありません。',
    'date' => ':attributeには有効な日付を入力してください。',
    'date_equals' => ':attributeには:dateと同じ日付を入力してください。',
    'date_format' => ':attributeは:formatの形式で入力してください。',
    'decimal' => ':attributeは小数点以下:decimal桁で入力してください。',
    'declined' => ':attributeを拒否してください。',
    'declined_if' => ':otherが:valueの場合、:attributeを拒否してください。',
    'different' => ':attributeと:otherには異なる値を入力してください。',
    'digits' => ':attributeは:digits桁で入力してください。',
    'digits_between' => ':attributeは:min桁から:max桁の間で入力してください。',
    'dimensions' => ':attributeの画像サイズが正しくありません。',
    'distinct' => ':attributeの値が重複しています。',
    'doesnt_contain' => ':attributeには次の値を含めないでください: :values',
    'doesnt_end_with' => ':attributeは次のいずれかで終わらないようにしてください: :values',
    'doesnt_start_with' => ':attributeは次のいずれかで始まらないようにしてください: :values',
    'email' => ':attributeには有効なメールアドレスを入力してください。',
    'encoding' => ':attributeは:encodingでエンコードしてください。',
    'ends_with' => ':attributeは次のいずれかで終わるようにしてください: :values',
    'enum' => '選択された:attributeは正しくありません。',
    'exists' => '選択された:attributeは正しくありません。',
    'extensions' => ':attributeには次のいずれかの拡張子のファイルを指定してください: :values',
    'file' => ':attributeにはファイルを指定してください。',
    'filled' => ':attributeに値を入力してください。',
    'gt' => [
        'array' => ':attributeは:value個より多く指定してください。',
        'file' => ':attributeには:valueKBより大きいファイルを指定してください。',
        'numeric' => ':attributeには:valueより大きい数値を入力してください。',
        'string' => ':attributeは:value文字より多く入力してください。',
    ],
    'gte' => [
        'array' => ':attributeは:value個以上指定してください。',
        'file' => ':attributeには:valueKB以上のファイルを指定してください。',
        'numeric' => ':attributeには:value以上の数値を入力してください。',
        'string' => ':attributeは:value文字以上で入力してください。',
    ],
    'hex_color' => ':attributeには有効な16進数のカラーコードを入力してください。',
    'image' => ':attributeには画像を指定してください。',
    'in' => '選択された:attributeは正しくありません。',
    'in_array' => ':attributeは:otherに含まれる値を指定してください。',
    'in_array_keys' => ':attributeには次のキーを少なくとも1つ含めてください: :values',
    'integer' => ':attributeには整数を入力してください。',
    'ip' => ':attributeには有効なIPアドレスを入力してください。',
    'ipv4' => ':attributeには有効なIPv4アドレスを入力してください。',
    'ipv6' => ':attributeには有効なIPv6アドレスを入力してください。',
    'json' => ':attributeには有効なJSONの文字列を入力してください。',
    'list' => ':attributeはリストで指定してください。',
    'lowercase' => ':attributeは小文字で入力してください。',
    'lt' => [
        'array' => ':attributeは:value個より少なく指定してください。',
        'file' => ':attributeには:valueKBより小さいファイルを指定してください。',
        'numeric' => ':attributeには:valueより小さい数値を入力してください。',
        'string' => ':attributeは:value文字より少なく入力してください。',
    ],
    'lte' => [
        'array' => ':attributeは:value個以下で指定してください。',
        'file' => ':attributeには:valueKB以下のファイルを指定してください。',
        'numeric' => ':attributeには:value以下の数値を入力してください。',
        'string' => ':attributeは:value文字以下で入力してください。',
    ],
    'mac_address' => ':attributeには有効なMACアドレスを入力してください。',
    'max' => [
        'array' => ':attributeは:max個以下で指定してください。',
        'file' => ':attributeには:maxKB以下のファイルを指定してください。',
        'numeric' => ':attributeには:max以下の数値を入力してください。',
        'string' => ':attributeは:max文字以下で入力してください。',
    ],
    'max_digits' => ':attributeは:max桁以下で入力してください。',
    'mimes' => ':attributeには次のいずれかの形式のファイルを指定してください: :values',
    'mimetypes' => ':attributeには次のいずれかの形式のファイルを指定してください: :values',
    'min' => [
        'array' => ':attributeは:min個以上指定してください。',
        'file' => ':attributeには:minKB以上のファイルを指定してください。',
        'numeric' => ':attributeには:min以上の数値を入力してください。',
        'string' => ':attributeは:min文字以上で入力してください。',
    ],
    'min_digits' => ':attributeは:min桁以上で入力してください。',
    'missing' => ':attributeは指定しないでください。',
    'missing_if' => ':otherが:valueの場合、:attributeは指定しないでください。',
    'missing_unless' => ':otherが:valueでない場合、:attributeは指定しないでください。',
    'missing_with' => ':valuesを指定する場合、:attributeは指定しないでください。',
    'missing_with_all' => ':valuesをすべて指定する場合、:attributeは指定しないでください。',
    'multiple_of' => ':attributeには:valueの倍数を入力してください。',
    'not_in' => '選択された:attributeは正しくありません。',
    'not_regex' => ':attributeの形式が正しくありません。',
    'numeric' => ':attributeには数値を入力してください。',
    'password' => [
        'letters' => ':attributeには英字を1文字以上含めてください。',
        'mixed' => ':attributeには大文字と小文字をそれぞれ1文字以上含めてください。',
        'numbers' => ':attributeには数字を1文字以上含めてください。',
        'symbols' => ':attributeには記号を1文字以上含めてください。',
        'uncompromised' => 'この:attributeは過去に漏えいしたことがあります。別の:attributeを入力してください。',
    ],
    'present' => ':attributeを指定してください。',
    'present_if' => ':otherが:valueの場合、:attributeを指定してください。',
    'present_unless' => ':otherが:valueでない場合、:attributeを指定してください。',
    'present_with' => ':valuesを指定する場合、:attributeも指定してください。',
    'present_with_all' => ':valuesをすべて指定する場合、:attributeも指定してください。',
    'prohibited' => ':attributeは入力できません。',
    'prohibited_if' => ':otherが:valueの場合、:attributeは入力できません。',
    'prohibited_if_accepted' => ':otherを承認した場合、:attributeは入力できません。',
    'prohibited_if_declined' => ':otherを拒否した場合、:attributeは入力できません。',
    'prohibited_unless' => ':otherが:valuesのいずれでもない場合、:attributeは入力できません。',
    'prohibits' => ':attributeを入力する場合、:otherは入力できません。',
    'regex' => ':attributeの形式が正しくありません。',
    'required' => ':attributeを入力してください。',
    'required_array_keys' => ':attributeには次の項目を含めてください: :values',
    'required_if' => ':otherが:valueの場合、:attributeを入力してください。',
    'required_if_accepted' => ':otherを承認した場合、:attributeを入力してください。',
    'required_if_declined' => ':otherを拒否した場合、:attributeを入力してください。',
    'required_unless' => ':otherが:valuesのいずれでもない場合、:attributeを入力してください。',
    'required_with' => ':valuesを入力する場合、:attributeも入力してください。',
    'required_with_all' => ':valuesをすべて入力する場合、:attributeも入力してください。',
    'required_without' => ':valuesを入力しない場合、:attributeを入力してください。',
    'required_without_all' => ':valuesをいずれも入力しない場合、:attributeを入力してください。',
    'same' => ':attributeと:otherが一致しません。',
    'size' => [
        'array' => ':attributeは:size個で指定してください。',
        'file' => ':attributeには:sizeKBのファイルを指定してください。',
        'numeric' => ':attributeには:sizeを入力してください。',
        'string' => ':attributeは:size文字で入力してください。',
    ],
    'starts_with' => ':attributeは次のいずれかで始まるようにしてください: :values',
    'string' => ':attributeには文字列を入力してください。',
    'timezone' => ':attributeには有効なタイムゾーンを入力してください。',
    'unique' => 'この:attributeはすでに使われています。',
    'uploaded' => ':attributeのアップロードに失敗しました。',
    'uppercase' => ':attributeは大文字で入力してください。',
    'url' => ':attributeには有効なURLを入力してください。',
    'ulid' => ':attributeには有効なULIDを入力してください。',
    'uuid' => ':attributeには有効なUUIDを入力してください。',

    /*
    |--------------------------------------------------------------------------
    | 項目とルールごとのメッセージ
    |--------------------------------------------------------------------------
    |
    | 特定の項目とルールの組み合わせにだけ使うメッセージ。「項目名.ルール名」
    | の形でキーを書く。
    |
    */

    'custom' => [],

    /*
    |--------------------------------------------------------------------------
    | 項目名
    |--------------------------------------------------------------------------
    |
    | メッセージの :attribute に入る項目名。
    |
    */

    'attributes' => [
        'name' => 'ユーザー名',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'password_confirmation' => '確認用パスワード',
    ],

];
