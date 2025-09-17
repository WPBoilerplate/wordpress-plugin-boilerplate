# WordPress Plugin Boilerplate

A comprehensive, modern WordPress plugin boilerplate that follows WordPress coding standards and incorporates the latest development tools and best practices.

[![WordPress](https://img.shields.io/badge/WordPress-4.9.1%2B-blue.svg)](https://wordpress.org)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-GPL%20v2%2B-red.svg)](http://www.gnu.org/licenses/gpl-2.0.html)

## 🚀 Features

- **Modern PHP Development**: PSR-4 autoloading, namespace organization
- **WordPress Standards**: Follows WordPress Coding Standards (WPCS)
- **Build System**: @wordpress/scripts with Webpack, Babel, and SCSS support
- **Block Development**: Integrated Gutenberg block creation and registration
- **Automated Deployment**: GitHub Actions for WordPress.org deployment
- **Internationalization**: Built-in i18n support with POT file generation
- **Composer Integration**: Dependency management with custom WPBoilerplate packages
- **Security**: Built-in security best practices and sanitization

## 📋 Requirements

- **WordPress**: 4.9.1 or higher
- **PHP**: 7.4 or higher (8.0+ recommended)
  - ⚠️ **Critical**: PHP 7.4 is the **minimum required version** enforced by `composer.json`
  - 🚀 **Recommended**: PHP 8.0+ for better performance and modern language features
  - 🔒 **Enforcement**: Composer will prevent installation on older PHP versions
- **Node.js**: 14.0 or higher
- **Composer**: 2.0 or higher

### 🔍 PHP Version Verification

Before installation, verify your PHP version meets the requirements:

```bash
# Check PHP version
php -v

# Should show PHP 7.4.0 or higher
# Example: PHP 8.0.30 (cli) (built: Aug  5 2023 10:50:05)
```

**Why PHP 7.4+?**
- ✅ **Modern Features**: Arrow functions, typed properties, null coalescing assignment
- ✅ **Performance**: Significant performance improvements over PHP 7.3 and earlier
- ✅ **Security**: Better security features and ongoing support
- ✅ **WordPress Compatibility**: Full compatibility with modern WordPress features
- ✅ **Ecosystem**: Required by modern WordPress development tools and packages

## 🛠️ Quick Start

### Method 1: Using the Initialization Script (Recommended)

1. **Clone the boilerplate**:
   ```bash
   git clone https://github.com/WPBoilerplate/wordpress-plugin-boilerplate.git
   cd wordpress-plugin-boilerplate
   ```

2. **Run the initialization script**:
   ```bash
   ./init-plugin.sh
   ```

3. **Follow the interactive prompts**:
   - Enter your plugin name (e.g., "My Awesome Plugin")
   - Enter your GitHub organization name (e.g., "MyCompany")
   - **Optional**: Select WPBoilerplate packages for WordPress integrations:
     - `wpb-register-blocks` - Auto-register Gutenberg blocks
     - `wpb-updater-checker-github` - GitHub-based auto-updates
     - `wpb-buddypress-or-buddyboss-dependency` - BuddyPress/BuddyBoss compatibility
     - `wpb-woocommerce-dependency` - WooCommerce integration support
     - And more specialized packages for common WordPress needs
   - The script will automatically:
     - Create a new plugin with your details
     - Install selected packages via Composer
     - Add integration code to `includes/main.php`
     - Set up the complete development environment

### Method 2: Manual Setup

1. **Clone and rename**:
   ```bash
   git clone https://github.com/WPBoilerplate/wordpress-plugin-boilerplate.git my-plugin-name
   cd my-plugin-name
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Build assets**:
   ```bash
   npm run build
   ```

## 🏗️ Build System (@wordpress/scripts)

The plugin uses WordPress's official build tools for modern development workflows:

### Available Commands

```bash
# Development build with hot reloading
npm run start

# Production build (optimized & minified)
npm run build

# Lint JavaScript files
npm run lint:js

# Fix JavaScript formatting issues
npm run lint:js:fix

# Lint CSS/SCSS files
npm run lint:css

# Generate translation files
npm run makepot

# Development dependencies check
npm run packages-update
```

### Asset Pipeline

- **SCSS → CSS**: Automatic compilation with autoprefixing and minification
- **Modern JavaScript**: Babel transpilation for browser compatibility
- **Hot Reload**: Live reloading during development with `npm run start`
- **Source Maps**: Available in development mode for debugging
- **Asset Optimization**: Image compression and optimization

## 📦 WPBoilerplate Ecosystem

The boilerplate integrates with a comprehensive ecosystem of WordPress-specific Composer packages to accelerate development:

### Core Integration Packages

| Package | Purpose | Auto-Integration |
|---------|---------|------------------|
| `wpboilerplate/wpb-register-blocks` | Auto-register Gutenberg blocks from `build/blocks/` | ✅ |
| `wpboilerplate/wpb-updater-checker-github` | GitHub-based plugin auto-updates | ✅ |

### Dependency Management Packages

| Package | Purpose | Auto-Integration |
|---------|---------|------------------|
| `wpboilerplate/wpb-buddypress-or-buddyboss-dependency` | BuddyPress/BuddyBoss compatibility checker | ✅ |
| `wpboilerplate/wpb-buddyboss-dependency` | BuddyBoss Platform dependency | ✅ |
| `wpboilerplate/wpb-woocommerce-dependency` | WooCommerce integration support | ✅ |
| `wpboilerplate/acrossswp-acf-pro-dependency` | Advanced Custom Fields Pro dependency | ✅ |

### Analytics & Tracking

| Package | Purpose | Auto-Integration |
|---------|---------|------------------|
| `wpboilerplate/wpb-view-analytics-dependency` | View analytics and tracking | ✅ |

### Installation via Script

When using `./init-plugin.sh`, you can interactively select packages during setup. The script will:
- Add packages to `composer.json`
- Install via `composer install`
- **Automatically generate integration code** in `includes/main.php`
- Configure proper class instantiation and dependency checks

### Manual Installation

You can also add packages manually after setup:

```bash
# Install a specific package
composer require wpboilerplate/wpb-register-blocks

# Add integration code to includes/main.php
# (See the package documentation for specific integration patterns)
```

## 🧱 Block Development

The boilerplate includes seamless integration for creating and managing Gutenberg blocks.

### Creating Blocks

1. **Create a block folder inside the `src/blocks` directory and scaffold a block**:
   ```bash
   mkdir -p src/blocks
   cd src/blocks
   npx @wordpress/create-block my-plugin-name-block --no-plugin
   ```
   This will scaffold a new block inside `src/blocks/my-plugin-name-block`.

2. **Add the block registration package**:
   ```bash
   composer require wpboilerplate/wpb-register-blocks
   ```

3. **Integration is automatic** - The block registration is already configured in `includes/main.php`:

```php
/**
 * Auto-register blocks from build/blocks directory
 */
if ( class_exists( 'WPBoilerplate\\RegisterBlocks\\RegisterBlocks' ) ) {
    new \\WPBoilerplate\RegisterBlocks\RegisterBlocks( $this->plugin_dir );
}
```

4. **Install dependencies and build**:
   ```bash
   composer update
   npm run build
   ```

### How Block Registration Works

The `wpb-register-blocks` package automatically:
- 🔍 Scans your plugin's `build/blocks/` directory
- 📝 Registers all block types found in subdirectories
- ⚡ Hooks into WordPress `init` action to register blocks
- 🎯 Uses PSR-4 autoloading for optimal performance

### Block Structure
```
build/blocks/
├── my-block/
│   ├── block.json          # Block configuration
│   ├── index.js           # Block JavaScript
│   ├── style.css         # Block styles
│   └── editor.css        # Editor-only styles
└── another-block/
    └── ...
```

## 🎯 Advanced Block Development: Multiple Input Files

### Using x3p0-ideas Block Example

We now use the comprehensive [x3p0-ideas block example](https://github.com/x3p0-dev/x3p0-ideas/tree/block-example) as our reference for advanced block development patterns. This example demonstrates best practices for:

#### **Multiple Input File Architecture**
```
src/blocks/
├── example-block/
│   ├── block.json          # Block metadata and configuration
│   ├── index.js           # Main block registration
│   ├── edit.js            # Editor component (separate file)
│   ├── save.js            # Save component (separate file)
│   ├── view.js            # Frontend interactivity (separate file)
│   ├── style.scss         # Frontend styles
│   ├── editor.scss        # Editor-specific styles
│   └── variations.js      # Block variations (separate file)
```

#### **Key Benefits of Multiple Input Files:**

1. **🔧 Modular Architecture**:
   - Separate concerns for edit, save, and view functionality
   - Easier maintenance and code organization
   - Better team collaboration with clear file responsibilities

2. **⚡ Optimized Loading**:
   - Frontend scripts only loaded when needed
   - Smaller bundle sizes through code splitting
   - Better performance with conditional loading

3. **🎨 Advanced Styling**:
   - Separate SCSS files for editor and frontend
   - CSS custom properties for dynamic styling
   - Theme integration capabilities

4. **🛠️ Enhanced Functionality**:
   - Block variations in dedicated files
   - Custom block controls and settings
   - Advanced interactivity patterns

#### **Implementation with @wordpress/scripts**

The build system automatically handles multiple input files:

```javascript
// webpack.config.js automatically processes:
const entries = {
    // Main block files
    'blocks/example-block/index': './src/blocks/example-block/index.js',
    'blocks/example-block/view': './src/blocks/example-block/view.js',

    // Style files
    'blocks/example-block/style': './src/blocks/example-block/style.scss',
    'blocks/example-block/editor': './src/blocks/example-block/editor.scss',
};
```

#### **x3p0-ideas Integration Patterns**

Based on the [x3p0-ideas block example](https://github.com/x3p0-dev/x3p0-ideas/tree/block-example), implement these patterns:

1. **Block Registration with Multiple Assets**:
   ```json
   {
     "name": "my-plugin/example-block",
     "editorScript": "file:./index.js",
     "viewScript": "file:./view.js",
     "style": "file:./style.css",
     "editorStyle": "file:./editor.css"
   }
   ```

2. **Modular Component Structure**:
   ```javascript
   // index.js - Main registration
   import { registerBlockType } from '@wordpress/blocks';
   import Edit from './edit';
   import Save from './save';
   import metadata from './block.json';

   registerBlockType( metadata.name, {
       ...metadata,
       edit: Edit,
       save: Save,
   } );
   ```

3. **Separate Edit Component**:
   ```javascript
   // edit.js - Editor interface
   import { useBlockProps } from '@wordpress/block-editor';
   import { PanelBody, TextControl } from '@wordpress/components';

   export default function Edit( { attributes, setAttributes } ) {
       // Complex editor logic here
   }
   ```

4. **Frontend Interactivity**:
   ```javascript
   // view.js - Frontend behavior
   import domReady from '@wordpress/dom-ready';

   domReady( () => {
       // Frontend JavaScript for block interactions
   } );
   ```

#### **Setup Instructions for x3p0-ideas Pattern**

1. **Clone the example structure**:
   ```bash
   # Reference the x3p0-ideas block structure
   mkdir -p src/blocks/your-block
   # Copy patterns from https://github.com/x3p0-dev/x3p0-ideas/tree/block-example
   ```

2. **Configure multiple entry points**:
   ```bash
   # The build system automatically detects:
   npm run build
   # Creates: build/blocks/your-block/{index.js, view.js, style.css, editor.css}
   ```

3. **Automatic registration**:
   ```php
   // wpb-register-blocks automatically handles multiple assets
   // No additional configuration needed!
   ```

### **Advanced Features from x3p0-ideas**

- **🎛️ Dynamic Block Variations**: Runtime block variations based on content
- **🎨 CSS Custom Properties**: Dynamic styling with CSS variables
- **⚡ Conditional Asset Loading**: Scripts/styles loaded only when blocks are present
- **🔧 Custom Inspector Controls**: Advanced sidebar panels and settings
- **📱 Responsive Design Patterns**: Mobile-first block development
- **♿ Accessibility Best Practices**: WCAG compliant block interfaces

## 📦 Composer Packages

### 🔒 PHP Version Requirement

**IMPORTANT**: All WPBoilerplate packages require **PHP 7.4+**. This is enforced in `composer.json`:

```json
{
    "require": {
        "php": ">=7.4"
    }
}
```

**Installation Protection**:
- ❌ Composer will **refuse to install** on PHP < 7.4
- ✅ Ensures compatibility across all environments
- 🛡️ Prevents runtime errors from version incompatibilities

### WPBoilerplate Package Ecosystem

The boilerplate integrates with a comprehensive ecosystem of WordPress-specific Composer packages:

#### Core Packages

```bash
# Block registration and management
composer require wpboilerplate/wpb-register-blocks

# GitHub-based plugin updates
composer require wpboilerplate/wpb-updater-checker-github
```

#### Plugin Dependencies

```bash
# BuddyPress/BuddyBoss Platform integration
composer require wpboilerplate/wpb-buddypress-or-buddyboss-dependency

# BuddyBoss Platform specific
composer require wpboilerplate/wpb-buddyboss-dependency

# WooCommerce integration
composer require wpboilerplate/wpb-woocommerce-dependency

# Advanced Custom Fields Pro
composer require wpboilerplate/acrossswp-acf-pro-dependency

# Analytics and tracking
composer require wpboilerplate/wpb-view-analytics-dependency
```

### Package Integration Examples

#### GitHub Auto-Updates
```php
// Add to load_composer_dependencies() method
if ( class_exists( 'WPBoilerplate_Updater_Checker_Github' ) ) {
    $package = array(
        'repo'              => 'https://github.com/YourOrg/your-plugin',
        'file_path'         => YOUR_PLUGIN_FILE,
        'plugin_name_slug'  => 'your-plugin-slug',
        'release_branch'    => 'main'
    );
    new WPBoilerplate_Updater_Checker_Github( $package );
}
```

#### Plugin Dependencies
```php
// BuddyPress/BuddyBoss dependency check
if ( class_exists( 'WPBoilerplate_BuddyPress_BuddyBoss_Platform_Dependency' ) ) {
    new WPBoilerplate_BuddyPress_BuddyBoss_Platform_Dependency(
        $this->get_plugin_name(),
        YOUR_PLUGIN_FILES
    );
}
```

## 🏗️ Project Structure

```
wordpress-plugin-boilerplate/
├── 📁 .github/                    # GitHub Actions & templates
│   ├── workflows/
│   │   ├── build-zip.yml         # Automated ZIP creation
│   │   └── wordpress-plugin-deploy.yml  # WP.org deployment
│   └── copilot-instructions.md   # AI development guidelines
├── 📁 .wordpress-org/            # WordPress.org assets
│   ├── banner-1544x500.jpg      # Large banner
│   ├── banner-772x250.jpg       # Small banner
│   ├── icon-128x128.jpg         # Small icon
│   └── icon-256x256.jpg         # Large icon
├── 📁 admin/                     # Admin functionality
│   ├── Main.php                 # Admin main class
│   └── partials/               # Admin templates
├── 📁 build/                     # Compiled assets (auto-generated)
│   ├── css/                    # Compiled stylesheets
│   ├── js/                     # Compiled JavaScript
│   └── media/                  # Processed images
├── 📁 includes/                  # Core classes
│   ├── main.php               # Main plugin class
│   ├── loader.php             # Hook management
│   ├── activator.php          # Activation logic
│   ├── deactivator.php        # Deactivation logic
│   ├── i18n.php               # Internationalization
│   └── Autoloader.php         # PSR-4 autoloader
├── 📁 languages/                 # Translation files
├── 📁 public/                    # Public-facing code
├── 📁 src/                       # Source assets
│   ├── js/                     # JavaScript source
│   ├── scss/                   # SCSS source
│   └── media/                  # Source images
├── 📁 vendor/                    # Composer dependencies
├── 📄 composer.json             # Composer configuration
├── 📄 package.json              # npm configuration
├── 📄 webpack.config.js         # Build configuration
├── 📄 init-plugin.sh           # Initialization script
└── 📄 your-plugin.php          # Main plugin file
```

## 🔧 Architecture & Patterns

### PSR-4 Autoloading
```json
{
  "autoload": {
    "psr-4": {
      "WordPress_Plugin_Boilerplate\\Includes\\": "includes/",
      "WordPress_Plugin_Boilerplate\\Admin\\": "admin/",
      "WordPress_Plugin_Boilerplate\\Public\\": "public/"
    }
  }
}
```

### Hook Management System
```php
// Centralized hook management
$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
$this->loader->add_filter( 'the_content', $plugin_public, 'filter_content' );
```

### Dependency Injection
- Automatic class loading via PSR-4
- Service container pattern for components
- Composer dependency management
- Plugin dependency verification

## 🔒 Security Best Practices

### Data Sanitization & Validation
```php
// Input sanitization
$clean_text = sanitize_text_field( $_POST['user_input'] );
$clean_email = sanitize_email( $_POST['email'] );
$clean_url = esc_url_raw( $_POST['url'] );

// Output escaping
echo esc_html( $user_content );
echo esc_attr( $attribute_value );
echo esc_url( $link_url );
```

### Nonce Security
```php
// Generate nonce in forms
wp_nonce_field( 'my_action', 'my_nonce' );

// Verify nonce in processing
if ( ! wp_verify_nonce( $_POST['my_nonce'], 'my_action' ) ) {
    wp_die( 'Security check failed' );
}
```

### Capability Checks
```php
// Always verify user permissions
if ( ! current_user_can( 'manage_options' ) ) {
    wp_die( 'Insufficient permissions' );
}
```

## 🌐 Internationalization (i18n)

### Translation Setup
```php
// Text domain registration
load_plugin_textdomain( 'your-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

// Translation functions
__( 'Text to translate', 'your-plugin' );
_e( 'Text to echo', 'your-plugin' );
_n( 'Singular', 'Plural', $count, 'your-plugin' );
```

### Generate Translation Files
```bash
# Generate POT file for translators
npm run makepot

# The file will be created at: languages/your-plugin.pot
```

## 🚀 Deployment & CI/CD

### GitHub Actions Integration

The boilerplate includes automated workflows for:

#### 1. Automated ZIP Creation (`build-zip.yml`)
- Triggers on release creation
- Builds production assets
- Creates distributable ZIP file
- Uploads as release asset

#### 2. WordPress.org Deployment (`wordpress-plugin-deploy.yml`)
- Automatically deploys to WordPress.org SVN
- Handles version management
- Manages plugin assets (banners, icons)
- Supports both trunk and tagged releases

### Manual Deployment Process

1. **Update version numbers**:
   ```php
   // In main plugin file header
   Version: 1.2.3

   // In package.json
   "version": "1.2.3"
   ```

2. **Build production assets**:
   ```bash
   npm run build
   ```

3. **Create release**:
   ```bash
   git tag v1.2.3
   git push origin v1.2.3
   ```

## 🔧 Advanced Development

### Custom Post Types & Taxonomies
```php
// Register custom post type
add_action( 'init', array( $this, 'register_post_types' ) );

public function register_post_types() {
    register_post_type( 'custom_type', array(
        'labels' => array(
            'name' => __( 'Custom Types', 'textdomain' ),
        ),
        'public' => true,
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'show_in_rest' => true, // Gutenberg support
    ) );
}
```

### REST API Endpoints
```php
// Register custom API endpoints
add_action( 'rest_api_init', array( $this, 'register_api_routes' ) );

public function register_api_routes() {
    register_rest_route( 'my-plugin/v1', '/data', array(
        'methods' => 'GET',
        'callback' => array( $this, 'api_get_data' ),
        'permission_callback' => array( $this, 'api_permissions' ),
    ) );
}
```

### Database Integration
```php
// Custom table creation in activator.php
public static function create_tables() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'my_plugin_data';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        data longtext,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}
```

## 🎯 Performance Optimization

### Asset Loading Strategy
```php
// Conditional asset loading
public function enqueue_scripts() {
    // Only load on specific pages
    if ( is_admin() && get_current_screen()->id === 'my-plugin-page' ) {
        wp_enqueue_script( 'my-plugin-admin', $this->plugin_url . 'build/js/admin.js' );
    }
}
```

### Caching Implementation
```php
// Use transients for expensive operations
$data = get_transient( 'my_plugin_expensive_data' );
if ( false === $data ) {
    $data = $this->expensive_operation();
    set_transient( 'my_plugin_expensive_data', $data, HOUR_IN_SECONDS );
}
```

## 🔗 Plugin Ecosystem

### WPBoilerplate Organization

Explore the complete ecosystem:
- 🏠 **Main Repository**: [WPBoilerplate/wordpress-plugin-boilerplate](https://github.com/WPBoilerplate/wordpress-plugin-boilerplate)
- 🧱 **Block Registration**: [WPBoilerplate/wpb-register-blocks](https://github.com/WPBoilerplate/wpb-register-blocks)
- 🔄 **GitHub Updater**: [WPBoilerplate/wpb-updater-checker-github](https://github.com/WPBoilerplate/wpb-updater-checker-github)
- 👥 **BuddyPress Integration**: [WPBoilerplate/wpb-buddypress-or-buddyboss-dependency](https://github.com/WPBoilerplate/wpb-buddypress-or-buddyboss-dependency)
- 🛒 **WooCommerce Integration**: [WPBoilerplate/wpb-woocommerce-dependency](https://github.com/WPBoilerplate/wpb-woocommerce-dependency)

## 🤝 Contributing

1. **Fork the repository**
2. **Create a feature branch**: `git checkout -b feature/amazing-feature`
3. **Commit changes**: `git commit -m 'Add amazing feature'`
4. **Push to branch**: `git push origin feature/amazing-feature`
5. **Open a Pull Request**

### Development Guidelines

- Follow WordPress Coding Standards (WPCS)
- Write comprehensive documentation
- Update README.md for significant changes
- Use semantic versioning for releases

## 📄 License

This project is licensed under the GPL v2 or later - see the [LICENSE.txt](LICENSE.txt) file for details.

## 🙏 Credits & Acknowledgments

- **WordPress Community**: For the coding standards and best practices
- **@wordpress/scripts**: Official WordPress build tools
- **XWP**: [wp-foo-bar](https://github.com/xwp/wp-foo-bar) - Inspiration for plugin structure
- **AcrossWP**: [Development tools and packages](https://github.com/acrosswp/)
- **10up**: [GitHub Actions](https://github.com/10up/action-wordpress-plugin-build-zip) for deployment automation

---

**Made with ❤️ by the [WPBoilerplate Team](https://github.com/WPBoilerplate)**

For detailed AI agent instructions, see [agents.md](agents.md)
