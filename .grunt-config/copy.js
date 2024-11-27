/**
 * Grunt copy task config
 * @package MRM
 */
const getBuildFiles = [
    '**',
    '!.git/**',
    '!.github/**',
    '!.gitignore',
    '!.gitmodules',
    '!.jscsrc',
    '!karma.conf.js',
    '!.jshintignore',
    '!.jshintrc',
    '!.travis.yml',
    '!assets/**/*.map',
    '!node_modules/**',
    '!bin/**',
    'vendor/bin/jp.php',
    '!packages/**',
    '!src/**',
    '!tests',
    '!tmp',
    '!npm-debug.log',
    '!package-lock.json',
    '!phpunit.xml',
    '!CHANGELOG.md',
    '!README.md',
    '!phpcs.xml',
    '!tests/**',
    '!test-results/',
    '!tmp/**',
    '!yarn.lock',
    '!yarn-error.log',
    '!composer.lock',
    '!docker-compose.yml',
    '!Dockerfile',
    '!Gruntfile.js',
    '!Gruntfile.js',
    '!phpunit.xml.dist',
    '!tsconfig.json',
    '!webpack.common.js',
    '!webpack.config.js',
    '!webpack.dev.js',
    '!webpack.prod.js',
    '!output.txt',
    '!*~',
    '!output.csv',
    '!admin/assets/sass/**',
    '!admin/assets/**/*.map',
    '!vendor/**/composer.json',
    '!vendor/**/*.lock',
    '!vendor/**/*.dist',
    '!vendor/**/*.md',
    '!vendor/composer/tmp**',
    '!vendor/bin/**',
    '!code_coverage/**',
    '!test-results/**',
    '!artifacts/**',
];
/**
 * @type {{main: {src: string[], expand: boolean, dest: string}, secondary: {src: string[], expand: boolean, dest: string}}}
 */
const copy = {
    main: {
        src: getBuildFiles,
        expand: true,
        dest: 'build/'
    }
};

module.exports = copy;