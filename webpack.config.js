const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
// const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

module.exports = {
	...defaultConfig,
	stats: 'normal',
	// plugins: [
	// 	new BundleAnalyzerPlugin()
	// ],
	module: {
		...defaultConfig.module,
		rules: [
			...defaultConfig.module.rules,
			{
				test: /\.tsx?$/,
				use: 'ts-loader',
				exclude: /node_modules/,
			},
			{
				test: /\.m?js$/,
				exclude: /(node_modules|bower_components)/,
				use: {
				  loader: 'babel-loader',
				  options: {
					presets: ['@babel/preset-env'],
					plugins: [
						'@babel/plugin-proposal-object-rest-spread',
						'babel-plugin-transform-typescript-metadata',
					]
				  }
				}
			},
		],
	},
	resolve: {
		...defaultConfig.resolve,
		extensions: ['.tsx', '.ts', '.js', '.scss' ],
	},
}
