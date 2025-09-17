// WordPress Plugin Boilerplate Prettier config
// Uses official WordPress Prettier standards and recommended overrides
import wpConfig from '@wordpress/prettier-config';

/**
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-prettier-config/
 * @type {import("prettier").Config}
 */
const config = {
	...wpConfig,
	// Override only where WordPress config conflicts with .editorconfig or project needs
	overrides: [
		...wpConfig.overrides,
		{
			files: '*.md',
			options: {
				tabWidth: 2,
				useTabs: false,
			},
		},
		{
			files: ['*.yml', '*.yaml'],
			options: {
				tabWidth: 2,
				useTabs: false,
				singleQuote: true,
			},
		},
	],
};

export default config;
