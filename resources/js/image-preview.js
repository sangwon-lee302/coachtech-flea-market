// data-preview 属性を持つファイルの入力欄で画像を選ぶと、その値を id に持つ要素の中に、選んだ画像を表示する
for (const input of document.querySelectorAll(
    'input[type="file"][data-preview]',
)) {
    const preview = document.getElementById(input.dataset.preview);
    const original = [...preview.children];

    input.addEventListener('change', () => {
        const [file] = input.files;

        // 選択を取り消したときと、画像以外を選んだときは、元の表示に戻す
        if (!file?.type.startsWith('image/')) {
            preview.replaceChildren(...original);

            return;
        }

        const image = document.createElement('img');
        image.src = URL.createObjectURL(file);
        image.alt = '選択した画像';
        // 表示に使った URL は画像を読み込んだ後は不要なので、解放する
        image.addEventListener('load', () => URL.revokeObjectURL(image.src));

        preview.replaceChildren(image);
    });
}
