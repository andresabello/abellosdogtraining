const path = require('path')
const VueLoaderPlugin = require('vue-loader-plugin')
const {CleanWebpackPlugin} = require('clean-webpack-plugin')
const CompressionPlugin = require('compression-webpack-plugin')
const {WebpackManifestPlugin} = require('webpack-manifest-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')


let watchOptions = {
	aggregateTimeout: 300,
	poll: 1000,
	ignored: ['node_modules'],
}

let rules = [
	{
		test: /\.txt$/,
		use: 'raw-loader',
	},
	{
		test: /\.vue$/,
		use: 'vue-loader',
	},
	{
		test: /\.js$/,
		exclude: /(node_modules)/,
		use: {
			loader: 'babel-loader',
			options: {
				presets: [
					[
						'@babel/preset-env',
						{
							'debug': true,
							corejs: 3,
							'useBuiltIns': 'entry',
							'targets': {
								'browsers': [
									'defaults',
								],
							},
						},
					],
				],
				plugins: [
					[
						'@babel/transform-runtime',
					],
				],
			},
		},
	},
	{
		test: /\.(sa|sc|c)ss$/,
		use: [
			'style-loader',
			{
				loader: MiniCssExtractPlugin.loader,
				options: {
					esModule: false,
				},
			},
			'css-loader',
			'sass-loader'
		],
	},
	{
		test: /\.(woff|woff2|ttf|otf|eot)$/,
		use: [
			{
				loader: 'file-loader',
				options: {
					outputPath: 'webfonts'
				}
			}
		]
	},
]

let plugins = [
	new VueLoaderPlugin(),
	new MiniCssExtractPlugin({
		filename: '[name].[chunkhash].css',
		chunkFilename: '[id].[chunkhash].css',
		insert: function (linkTag) {
			var preloadLinkTag = document.createElement('link')
			preloadLinkTag.rel = 'preload'
			preloadLinkTag.as = 'style'
			preloadLinkTag.href = linkTag.href
			document.head.appendChild(preloadLinkTag)
			document.head.appendChild(linkTag)
		}
	}),
	new CleanWebpackPlugin(),
	new CompressionPlugin(),
	new WebpackManifestPlugin({}),
]


module.exports = {
	watchOptions: watchOptions,
	entry: {
		front: './assets/js/pi-business.js',
		admin: './assets/js/admin.js',
	},
	output: {
		publicPath: '/wp-content/themes/pibusiness/assets/dist/',
		path: path.resolve(__dirname, 'assets/dist'),
		filename: '[name].[chunkhash].js',
		chunkFilename: '[name].[chunkhash].bundle.js'
	},
	optimization: {
		runtimeChunk: 'single',
		chunkIds: 'size',
		moduleIds: 'size',
		splitChunks: {
			chunks: 'all',
			cacheGroups: {
				vendor: {
					test: /[\\/]node_modules[\\/]/,
					name: 'vendors',
					chunks: 'all',
				},
			},
		},
	},
	resolve: {
		alias: {
			'vue$': 'vue/dist/vue.esm.js',
		},
		extensions: ['*', '.js', '.vue', '.json'],
	},
	module: {
		rules: rules,
	},
	plugins: plugins,
}