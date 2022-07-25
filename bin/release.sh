npm run build
cd ..
rm -f -r ./release
mkdir release
rsync \
	--exclude=node_modules \
	--exclude=release \
	--exclude=bin \
	--exclude=tests \
	--exclude=resources/ts \
	--exclude=resources/scss \
	--exclude=resources/fonts \
	-a "$PWD" ./release/
cd ./release
rsync --recursive \
	./tokenly-wp-plugin/libs/ ./tokenly-wp-plugin/vendor
zip -r tokenly-wp-plugin.zip ./tokenly-wp-plugin/
rm -f -r ./tokenly-wp-plugin
