// import { v4wp } from '@kucrut/vite-for-wp';

// export default {
// 	plugins: [
// 		v4wp( {
// 			input: 'src/app/index.js',
// 			outDir: 'dist/app',
// 		} ),
// 	],
// };

import { v4wp } from '@kucrut/vite-for-wp';

export default {
	plugins: [
		v4wp( {
			input: 'src/app/index.js', // Optional, defaults to 'src/main.js'.
			outDir: 'dist/app', // Optional, defaults to 'dist'.
		} ),
	],
	server: {
		// https: true,
		port: 3001,
		// open: true,
		proxy: {
			'/': {
				target: 'https://wp.1fo.au',
				changeOrigin: true
			}
		}
	}
};