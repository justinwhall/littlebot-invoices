const host = 'localhost';
const webpack = require('webpack');

// const isProduction = process.env.NODE_ENV === 'production';
const isProduction = false;
const path = require('path');

const port = 8080;
const packageJson = require('./package.json');

const postfix = process.env.POSTFIX_ENV || 'build';

module.exports = {
  devtool: 'eval-source-map',
  //   mode: isProduction ? 'production' : 'development',
  mode: isProduction ? 'production' : 'development',
  target: 'web',
  entry: {
    app: path.resolve('./assets/js/index.js'),
  },
  output: {
    path: path.resolve(__dirname, 'assets/dist'),
    filename: `block.${postfix}.js`,
  },
  module: {
    rules: [
      {
        test: /\.js?$/,
        exclude: /node_modules/,
        loader: 'babel-loader',
      },
    ],
  },
  externals: {
    react: 'React',
    'react-dom': 'ReactDOM',
  },
  resolve: {
    alias: {
      'react-dom': '@hot-loader/react-dom',
    },
  },
};

if (!isProduction) {
  module.exports.output.publicPath = `http://${host}:${port}/${packageJson.name}/`;
  module.exports.devServer = {
    headers: { 'Access-Control-Allow-Origin': '*' },
    disableHostCheck: true,
    host,
    port,
    publicPath: `/${packageJson.name}/`,
    watchOptions: {
      ignored: /node_modules/,
    },
  };
}
