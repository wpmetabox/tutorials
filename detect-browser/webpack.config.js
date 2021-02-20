const path = require( 'path' );

const config = {
	mode: 'development',
	entry: './js/script.js',
	output: {
		filename: 'main.js',
		path: path.resolve( __dirname, 'dist' )
	}
}

module.exports = config;