const defaultConfig = require("@wordpress/scripts/config/webpack.config");
const path = require('path');

module.exports = {
    ...defaultConfig,
    entry: {
        'custom-users-block': './src/index.js'
    },
    output: {
        path: path.join(__dirname, './assets/js'),
        filename: '[name].js'
    },
}
