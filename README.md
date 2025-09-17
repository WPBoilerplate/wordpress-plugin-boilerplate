# @wordpress/scripts

https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/

### Adding multipal input file

Now are using the https://github.com/x3p0-dev/x3p0-ideas/tree/block-example exmaple to setup out plugins

1.  Run `npm install` command and it will generate folder and files
2.  Now run `npm run build` command and it will generate plugin build
3.  Now run `npm run start` command and it will generate plugin on every file update

### Create blocks

1. Once everything install goto `src/` folder and run `npx @wordpress/create-block wordpress-plugin-boilerplate-block --no-plugin`

2. Add the `wpb-register-blocks` dependency to your plugin:
   ```bash
   composer require wpboilerplate/wpb-register-blocks
   ```

3. Open `includes/main.php` and locate the `load_composer_dependencies()` method (around line 234)

4. Add the following code at the end of the `load_composer_dependencies()` method, after the `require_once` line:

```php
/**
 * Check if class exists or not
 */
if ( class_exists( 'WPBoilerplate\\RegisterBlocks\\RegisterBlocks' ) ) {
	new \WPBoilerplate\RegisterBlocks\RegisterBlocks( $this->plugin_dir );
}
```

**Complete `load_composer_dependencies()` method should look like this:**
```php
private function load_composer_dependencies() {
	/**
	 * Add composer file
	 */
	$plugin_path = WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH;

	if ( file_exists( $plugin_path . 'vendor/autoload.php' ) ) {
		require_once $plugin_path . 'vendor/autoload.php';
	}

	/**
	 * Check if class exists or not
	 */
	if ( class_exists( 'WPBoilerplate\\RegisterBlocks\\RegisterBlocks' ) ) {
		new \WPBoilerplate\RegisterBlocks\RegisterBlocks( $this->plugin_dir );
	}
}
```

5. Run composer update to install the dependency:
   ```bash
   composer update
   ```

6. Build your blocks:
   ```bash
   npm run build
   ```

#### How it works

The `wpb-register-blocks` package uses PSR-4 autoloading and will automatically:
- Scan your plugin's `build/blocks/` directory
- Register all block types found in subdirectories
- Hook into WordPress `init` action to register blocks

#### PSR-4 Autoloading Structure

- **Package**: `wpboilerplate/wpb-register-blocks`
- **Namespace**: `WPBoilerplate\RegisterBlocks\`
- **Main Class**: `WPBoilerplate\RegisterBlocks\RegisterBlocks`
- **Auto-loads**: Via Composer's PSR-4 autoloading system

This provides better organization, follows modern PHP standards, and integrates seamlessly with Composer's autoloading system.

### Update your code via Github

1. run `composer require wpboilerplate/wpb-updater-checker-github`

2. Now run `composer update`

3. Now add
```
/**
 * Check if class exists or not
 */
/**
 * For Plugin Update via Github
 */
if ( class_exists( 'WPBoilerplate_Updater_Checker_Github' ) ) {

	$package = array(
		'repo' 		        => 'https://github.com/WPBoilerplate/wordpress-plugin-boilerplate',
		'file_path' 		=> WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_FILE,
		'plugin_name_slug'	=> WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_NAME_SLUG,
		'release_branch' 	=> 'main'
	);

	new WPBoilerplate_Updater_Checker_Github( $package );
}
```
inside the `load_composer_dependencies` method at the end


# Composer

### Adding dependency for Custom Plugins

1. Adding BuddyBoss Platform and Platform Pro dependency
   `composer require wpboilerplate/wpb-buddypress-or-buddyboss-dependency`
   and then add the below code in function load_dependencies after vendor autoload file included `require_once( WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH . 'vendor/autoload.php' );`

```
/**
 * Add the dependency for the call
 */
    if ( class_exists( 'WPBoilerplate_BuddyPress_BuddyBoss_Platform_Dependency' ) ) {
        new WPBoilerplate_BuddyPress_BuddyBoss_Platform_Dependency( $this->get_plugin_name(), WORDPRESS_PLUGIN_BOILERPLATE_FILES );
    }
```

2. Adding BuddyBoss Platform dependency
   `composer require wpboilerplate/wpb-buddyboss-dependency`

3. Adding WooCommerce dependency
   `composer require wpboilerplate/wpb-woocommerce-dependency`

4. Adding ACF Pro dependency
   `composer require wpboilerplate/acrossswp-acf-pro-dependency`

5. Adding View Analytics dependency
   `composer require wpboilerplate/wpb-view-analytics-dependency`


# Credits

1. https://github.com/xwp/wp-foo-bar

2. https://github.com/acrosswp/

3. https://github.com/10up/action-wordpress-plugin-build-zip

4. https://github.com/10up/action-wordpress-plugin-deploy

5. https://docs.google.com/document/d/1GMKxjxdFqwCg3ESC337eNvA6FmaokW9Zlkjm-mhSroU/edit?tab=t.0#heading=h.d22cu7925a4z
