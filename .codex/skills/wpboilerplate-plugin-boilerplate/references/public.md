# Public / frontend: adding classes and assets

## Namespace & directory

All frontend code belongs under `public/` with namespace `WordPress_Plugin_Boilerplate\Public`.
Frontend template partials go in `public/partials/`.

## Existing class

### `Public\Main` (`public/Main.php`)

- Receives `$plugin_name` and `$version` in its constructor.
- Reads `*.asset.php` manifests in the constructor:
  ```php
  $this->js_asset_file  = include WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH . 'build/js/frontend.asset.php';
  $this->css_asset_file = include WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH . 'build/css/frontend.asset.php';
  ```
- `enqueue_styles()` — hooked on `wp_enqueue_scripts`, enqueues `build/css/frontend.css`.
- `enqueue_scripts()` — hooked on `wp_enqueue_scripts`, enqueues `build/js/frontend.js`.

Source files: `src/js/frontend.js` (stub) and `src/scss/frontend.scss`.

## How to add a new frontend feature

1. Create `public/MyFeature.php`:
   ```php
   namespace WordPress_Plugin_Boilerplate\Public;
   class MyFeature {
       public function render_shortcode( $atts ) { /* output */ }
   }
   ```
2. In `includes/Main.php::define_public_hooks()`, instantiate and register:
   ```php
   $feature = new \WordPress_Plugin_Boilerplate\Public\MyFeature();
   $this->loader->add_action( 'init', $feature, 'register_shortcode' );
   ```
3. Run `composer dump-autoload`.

## Asset guidelines

- Source JS → `src/js/`, source SCSS → `src/scss/`.
- Never write to or read from `build/` directly in PHP.
- Always read `['version']` and `['dependencies']` from the `*.asset.php` manifest when
  calling `wp_enqueue_style()` / `wp_enqueue_script()`.
- To conditionally enqueue (e.g., only on a specific post type), wrap `wp_enqueue_*` calls
  inside an `is_*()` check inside the hooked method — do not change the hook itself.

## Frontend templates

Place PHP template partials in `public/partials/`. Load them with `include` or `get_template_part()`
equivalent patterns inside your feature class methods.

- Upstream reference: `https://github.com/WPBoilerplate/wordpress-plugin-boilerplate/blob/main/public/Main.php`
