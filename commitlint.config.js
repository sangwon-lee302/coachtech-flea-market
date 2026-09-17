export default {
    extends: ['@commitlint/config-conventional'],
    rules: {
        // 件名は日本語で書き、Laravel などの固有名詞から始まることもあるため、大文字・小文字を問わない
        'subject-case': [0],
    },
};
