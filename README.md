# @wordpress/scripts

https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/

### Adding multipal input file

Now are using the https://github.com/x3p0-dev/x3p0-ideas/tree/block-example exmaple to setup out plugins

1.  Run `npm install` command and it will generate folder and files
2.  Now run `npm run build` command and it will generate plugin build
3.  Now run `npm run start` command and it will generate plugin on every file update

### Create blocks

1. Now run `composer require wpboilerplate/wpb-register-blocks`
2. Now run `composer update`
3. Run `npm install @wordpress/scripts --save-dev` inside plugin folder terminal
4. Once everything install goto `src/` folder create directory `blocks` and run `npx @wordpress/create-block@latest wordpress-plugin-boilerplate-block --variant=dynamic --no-plugin`
5. Once that is install run `npm run build`

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
