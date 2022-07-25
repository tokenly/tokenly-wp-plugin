npm run build
rm tokenly-wp-plugin.zip
zip \
	-x .git/\* \
	-x bin/\* \
	-x tests/\* \
	-x node_modules/\* \
	-x resources/ts/\* \
	-x resources/scss/\* \
	-x resources/fonts/\* \
	-x .gitignore \
	-x .editorconfig \
	-x .distignore \
	-x .travis.yml \
	-x .phpcs.xml.dist \
	-x webpack.config.js \
	-x tsconfig.json \
	-x README.md \
	-x phpunit.xml.dist \
	-x phpdoc.dist.xml \
	-x package.json \
	-x package-lock.json \
	-r tokenly-wp-plugin.zip .