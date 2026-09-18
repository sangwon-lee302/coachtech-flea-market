import { describe, expect, it } from 'vitest';

// サンプルのテスト。実際のテストを追加する際に削除する
describe('テスト環境', () => {
    it('jsdom の DOM API が使える', () => {
        document.body.innerHTML = '<p id="greeting">こんにちは</p>';

        expect(document.getElementById('greeting').textContent).toBe(
            'こんにちは',
        );
    });
});
