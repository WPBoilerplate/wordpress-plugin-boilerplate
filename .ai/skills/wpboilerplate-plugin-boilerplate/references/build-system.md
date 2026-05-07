# Build system: @wordpress/scripts + webpack

## Entry points

| Source | Output | Consumed by |
|---|---|---|
| `src/js/backend.js` | `build/js/backend.js` + `build/js/backend.asset.php` | `Admin\Main` |
| `src/scss/backend.scss` | `build/css/backend.css` + `build/css/backend.asset.php` | `Admin\Main` |
| `src/js/frontend.js` | `build/js/frontend.js` + `build/js/frontend.asset.php` | `Public\Main` |
| `src/scss/frontend.scss` | `build/css/frontend.css` + `build/css/frontend.asset.php` | `Public\Main` |
| `src/scss/blocks/core/*.scss` | `build/css/blocks/core/*.css` (globbed) | block editor |
| `src/blocks/**/block.json` | `build/blocks/**/index.js` + `view.js` (auto-discovered) | block registration |
| `src/media/**` | `build/media/**` (CopyPlugin) | static assets |
| `src/fonts/**` | `build/fonts/**` (CopyPlugin) | static assets |

`RemoveEmptyScriptsPlugin` removes orphaned `.js` stubs created from SCSS-only entries.

## *.asset.php manifests

Every JS and CSS output has a sibling `*.asset.php` that returns:

```php
return [ 'dependencies' => [...], 'version' => 'abc123' ];
```

Always read from the manifest — never hardcode a version string or dependency list:

```php
$asset = include WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH . 'build/js/backend.asset.php';
wp_enqueue_script( $handle, $url, $asset['dependencies'], $asset['version'] );
```

## Adding a new entry point (non-block)

1. Add the entry to `webpack.config.js` `entry:` object.
2. Run `npm run build`.
3. Enqueue the output in the relevant `Admin\Main` or `Public\Main` method, reading from the
   new `*.asset.php` manifest.

## Adding a new Gutenberg block

1. Create `src/blocks/<block-name>/block.json` + `index.js` (and optionally `view.js`).
2. Run `npm run build` — webpack discovers the block via `block.json` automatically.
3. No manual `webpack.config.js` edit needed for standard blocks.

## Composer / Mozart

`composer.json` includes `coenjacobs/mozart` to namespace-scope vendor libraries, preventing
conflicts with other plugins. After any `composer install` or vendor change:

```
composer dump-autoload
```

## npm scripts

| Script | Purpose |
|---|---|
| `npm run build` | Production build |
| `npm run start` | Watch mode |
| `npm run lint:js` | ESLint |
| `npm run lint:css` | Stylelint |
| `npm run format` | Prettier |
| `npm run packages-update` | Update @wordpress packages |
| `npm run plugin-zip` | Create distributable ZIP |
| `npm run env:start` | Start wp-env |
| `npm run env:stop` | Stop wp-env |
| `npm run env:reset` | Destroy and restart wp-env |
| `npm run skills:install` | Install agent skills (`scripts/install-agent-skills.sh`) |

- Upstream reference: `https://github.com/WPBoilerplate/wordpress-plugin-boilerplate/blob/main/webpack.config.js`
