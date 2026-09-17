import path from 'node:path';

export default {
    // Pint はファイルを直接指定すると pint.json の exclude を無視するため、ここで除外する
    '*.php': (files) => {
        const targets = files.filter((file) => {
            const relative = path.relative(process.cwd(), file);

            return (
                !relative.endsWith('.blade.php') &&
                !relative.startsWith('lang/')
            );
        });

        return targets.length > 0
            ? [`vendor/bin/pint ${targets.join(' ')}`]
            : [];
    },
    '*': 'prettier --write --ignore-unknown',
};
