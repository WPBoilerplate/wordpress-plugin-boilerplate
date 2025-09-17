# WordPress Plugin Boilerplate - AI Agent Instructions

## Overview
This is a comprehensive WordPress plugin boilerplate that follows modern PHP development standards, WordPress coding guidelines, and includes advanced tooling for professional plugin development. It's designed to be a starting point for creating robust, scalable WordPress plugins.

## Project Structure & Architecture

### Core Framework
- **Framework**: Modern WordPress plugin boilerplate with PSR-4 autoloading
- **PHP Version**: Minimum PHP 7.4+ (recommended 8.0+)
- **WordPress Version**: Minimum 4.9.1+ (tested up to 6.2.2+)
- **Coding Standards**: WordPress Coding Standards (WPCS)
- **Build System**: @wordpress/scripts (Webpack-based)
- **Package Manager**: Composer + npm
- **Namespace**: `WordPress_Plugin_Boilerplate\`

### Directory Structure
```
wordpress-plugin-boilerplate/
├── .github/                     # GitHub workflows and templates
│   ├── workflows/
│   │   ├── build-zip.yml       # Automated plugin zip creation
│   │   └── wordpress-plugin-deploy.yml  # WordPress.org deployment
│   └── copilot-instructions.md # AI agent instructions
├── .wordpress-org/             # WordPress.org assets
│   ├── banner-1544x500.jpg    # Plugin banner (large)
│   ├── banner-772x250.jpg     # Plugin banner (small)
│   ├── icon-128x128.jpg       # Plugin icon (small)
│   └── icon-256x256.jpg       # Plugin icon (large)
├── admin/                      # Admin area functionality
│   ├── Main.php               # Admin main class
│   └── partials/              # Admin templates
│       ├── menu.php           # Admin menu template
│       └── index.php          # Security file
├── build/                      # Compiled assets (auto-generated)
│   ├── css/                   # Compiled CSS files
│   ├── js/                    # Compiled JavaScript files
│   └── media/                 # Processed media files
├── includes/                   # Core plugin classes
│   ├── main.php               # Main plugin class
│   ├── loader.php             # Hook loader class
│   ├── activator.php          # Plugin activation logic
│   ├── deactivator.php        # Plugin deactivation logic
│   ├── i18n.php               # Internationalization
│   └── Autoloader.php         # PSR-4 autoloader
├── languages/                  # Translation files
│   └── wordpress-plugin-boilerplate.pot
├── public/                     # Public-facing functionality
│   ├── Main.php               # Public main class
│   └── partials/              # Public templates
├── src/                        # Source assets (development)
│   ├── js/                    # JavaScript source files
│   ├── scss/                  # SCSS source files
│   └── media/                 # Media source files
├── vendor/                     # Composer dependencies
├── composer.json              # Composer configuration
├── package.json               # npm configuration
├── webpack.config.js          # Webpack build configuration
├── init-plugin.sh            # Plugin initialization script
└── wordpress-plugin-boilerplate.php  # Main plugin file
```

## Plugin Initialization Process

### Using init-plugin.sh Script
The `init-plugin.sh` script automates the creation of a new plugin from the boilerplate:

#### Interactive Setup Process:
1. **Plugin Name Input**:
   - Format: Title Case (e.g., "My Awesome Plugin")
   - Validation: Must start with capital letter, spaces allowed
   - Creates: Slug (`my-awesome-plugin`), prefix (`my_awesome_plugin`), namespace (`MyAwesomePlugin`)

2. **GitHub Organization**:
   - Input: Organization name (e.g., "MyCompany")
   - Creates: Lowercase repository path (`mycompany/my-awesome-plugin`)

3. **Automated Transformations**:
   - Renames main plugin file: `my-awesome-plugin.php`
   - Updates language files: `languages/my-awesome-plugin.pot`
   - Performs global find/replace:
     - `wordpress-plugin-boilerplate` → `my-awesome-plugin`
     - `WordPress Plugin Boilerplate` → `My Awesome Plugin`
     - `wordpress_plugin_boilerplate` → `my_awesome_plugin`
     - `WORDPRESS_PLUGIN_BOILERPLATE` → `MY_AWESOME_PLUGIN`
     - `WordPress_Plugin_Boilerplate` → `My_Awesome_Plugin`

4. **Project Setup**:
   - Initializes new git repository
   - Sets up GitHub remote origin
   - Installs Composer dependencies
   - Installs npm dependencies

### Manual Setup (Alternative)
```bash
# Clone the repository
git clone https://github.com/WPBoilerplate/wordpress-plugin-boilerplate.git my-plugin-name

# Navigate to directory
cd my-plugin-name

# Run initialization script
./init-plugin.sh

# Or install dependencies manually
composer install
npm install
```

## Development Workflow

### Build System (@wordpress/scripts)
The plugin uses WordPress's official build tools for modern development:

#### Available npm Commands:
```bash
# Development build (with source maps)
npm run start

# Production build (optimized)
npm run build

# Check for JavaScript errors
npm run lint:js

# Fix JavaScript formatting
npm run lint:js:fix

# Check for CSS errors
npm run lint:css

# Generate translation files
npm run makepot
```

#### Asset Compilation:
- **SCSS → CSS**: Automatic compilation with autoprefixing
- **Modern JS → Compatible JS**: Babel transpilation
- **Asset Optimization**: Minification, source maps in development
- **Hot Reload**: Live reloading during development

### Composer Dependencies & Packages

#### Core Dependencies:
```json
{
  "require": {
    "wpboilerplate/wpb-register-blocks": "^1.0"
  }
}
```

#### Available WPBoilerplate Packages:
1. **wpboilerplate/wpb-register-blocks** - Automatic block registration
2. **wpboilerplate/wpb-updater-checker-github** - GitHub-based plugin updates
3. **wpboilerplate/wpb-buddypress-or-buddyboss-dependency** - BuddyPress/BuddyBoss dependency checker
4. **wpboilerplate/wpb-buddyboss-dependency** - BuddyBoss Platform dependency
5. **wpboilerplate/wpb-woocommerce-dependency** - WooCommerce dependency checker
6. **wpboilerplate/acrossswp-acf-pro-dependency** - Advanced Custom Fields Pro dependency
7. **wpboilerplate/wpb-view-analytics-dependency** - View analytics tracking

#### Interactive Package Selection:
The `init-plugin.sh` script provides an interactive interface for selecting WPBoilerplate packages during setup:
- Displays package descriptions and purposes
- Allows multiple package selection via comma-separated input
- Automatically adds packages to `composer.json`
- **Auto-generates integration code** in `includes/main.php`
- Handles proper class instantiation and dependency checks

**CRITICAL**: When modifying or enhancing `init-plugin.sh`, always maintain:
1. Package description accuracy and clarity
2. Proper composer integration workflow
3. Auto-generated integration code patterns
4. Error handling for invalid selections
5. Clear user feedback and status messages

### PSR-4 Autoloading Configuration
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

## Block Development Integration

### Creating Gutenberg Blocks
1. **Initialize Block Creation**:
   ```bash
   cd src/
   npx @wordpress/create-block my-plugin-name-block --no-plugin
   ```

2. **Add Block Registration Package**:
   ```bash
   composer require wpboilerplate/wpb-register-blocks
   ```

3. **Integration Code** (automatically added in `includes/main.php`):
   ```php
   /**
    * Auto-register blocks from build/blocks directory
    */
   if ( class_exists( 'WPBoilerplate\\RegisterBlocks\\RegisterBlocks' ) ) {
       new \WPBoilerplate\RegisterBlocks\RegisterBlocks( $this->plugin_dir );
   }
   ```

4. **Build Blocks**:
   ```bash
   npm run build
   ```

### Block Structure:
- Blocks are automatically detected in `build/blocks/` directory
- Each block should have its own subdirectory
- Standard WordPress block.json configuration

## Plugin Architecture Patterns

### Hook Management System
The plugin uses a centralized loader system for managing WordPress hooks:

```php
// Add action hook
$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );

// Add filter hook
$this->loader->add_filter( 'the_content', $plugin_public, 'filter_content' );
```

### Dependency Injection
The main class follows dependency injection patterns:
- Autoloader registration
- Composer dependency loading
- Service container pattern for major components

### Namespace Organization
- `WordPress_Plugin_Boilerplate\Includes\` - Core functionality
- `WordPress_Plugin_Boilerplate\Admin\` - Admin area features
- `WordPress_Plugin_Boilerplate\Public\` - Public-facing features

## WordPress Coding Standards Compliance

### PHPCS Configuration
The project follows WordPress Coding Standards with custom ruleset:

```xml
<!-- phpcs.xml.dist -->
<?xml version="1.0"?>
<ruleset name="WordPress Plugin Boilerplate">
    <description>WordPress Coding Standards for Plugin</description>

    <file>.</file>

    <exclude-pattern>*/vendor/*</exclude-pattern>
    <exclude-pattern>*/build/*</exclude-pattern>
    <exclude-pattern>*/node_modules/*</exclude-pattern>

    <rule ref="WordPress">
        <exclude name="WordPress.Files.FileName"/>
    </rule>
</ruleset>
```

### Code Quality Standards:
- **PHP**: WordPress PHP Coding Standards
- **JavaScript**: WordPress JavaScript Coding Standards
- **CSS**: WordPress CSS Coding Standards
- **Documentation**: WordPress Inline Documentation Standards

## API Endpoints & REST API Integration

### Creating Custom Endpoints
The boilerplate supports easy REST API endpoint creation:

```php
// In your main class or dedicated API class
add_action( 'rest_api_init', array( $this, 'register_api_endpoints' ) );

public function register_api_endpoints() {
    register_rest_route( 'my-plugin/v1', '/endpoint', array(
        'methods' => 'GET',
        'callback' => array( $this, 'api_callback' ),
        'permission_callback' => array( $this, 'api_permissions' ),
    ) );
}
```

### Endpoint Structure Recommendations:
- **Namespace**: `your-plugin/v1`
- **Authentication**: WordPress nonces or JWT tokens
- **Data Validation**: Use WordPress sanitization functions
- **Response Format**: JSON with standardized structure

## Database Integration

### Custom Tables
For plugins requiring custom database tables:

```php
// In activator.php
public static function create_tables() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'my_plugin_table';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}
```

### WordPress Options API
For configuration storage:
- Use `get_option()` and `update_option()`
- Prefix all option names: `my_plugin_option_name`
- Group related options in arrays

## Security Best Practices

### Data Sanitization & Validation
```php
// Sanitize text input
$clean_text = sanitize_text_field( $_POST['user_input'] );

// Sanitize email
$clean_email = sanitize_email( $_POST['email'] );

// Validate and sanitize URLs
$clean_url = esc_url_raw( $_POST['url'] );
```

### Nonce Verification
```php
// Generate nonce
wp_nonce_field( 'my_plugin_action', 'my_plugin_nonce' );

// Verify nonce
if ( ! wp_verify_nonce( $_POST['my_plugin_nonce'], 'my_plugin_action' ) ) {
    wp_die( 'Security check failed' );
}
```

### Capability Checks
```php
// Check user capabilities
if ( ! current_user_can( 'manage_options' ) ) {
    wp_die( 'Insufficient permissions' );
}
```

## Performance Optimization

### Asset Loading Strategy
- **Conditional Loading**: Only load assets where needed
- **Minification**: Production builds are automatically minified
- **Caching**: Implement proper caching strategies
- **Lazy Loading**: Use WordPress lazy loading features

### Database Query Optimization
- Use WordPress query functions (`WP_Query`, `get_posts()`)
- Implement proper caching for expensive queries
- Use transients for temporary data storage

## Testing Framework Integration

### Recommended Testing Stack
```json
{
  "devDependencies": {
    "@wordpress/jest-preset-default": "^latest",
    "phpunit/phpunit": "^9.0"
  }
}
```

### Test Structure:
- **PHP Tests**: `tests/php/` directory
- **JavaScript Tests**: `tests/js/` directory
- **E2E Tests**: `tests/e2e/` directory

## Internationalization (i18n)

### Translation Setup
1. **Text Domain**: Use plugin slug as text domain
2. **Translation Functions**:
   ```php
   __( 'Text to translate', 'my-plugin-textdomain' );
   _e( 'Text to echo', 'my-plugin-textdomain' );
   _n( 'Singular', 'Plural', $count, 'my-plugin-textdomain' );
   ```

3. **Generate POT File**:
   ```bash
   npm run makepot
   ```

## Deployment & Distribution

### WordPress.org Repository
The boilerplate includes GitHub Actions for automated deployment:

#### Features:
- **Automated ZIP Creation**: Creates distributable plugin ZIP
- **SVN Deployment**: Pushes to WordPress.org repository
- **Version Management**: Handles version tagging
- **Asset Management**: Manages plugin assets (banners, icons)

### GitHub Actions Workflows
1. **build-zip.yml**: Creates plugin ZIP on releases
2. **wordpress-plugin-deploy.yml**: Deploys to WordPress.org

## Environment Configuration

### Development Environment
```bash
# Local development with WordPress
wp-env start

# Or use Docker
docker-compose up -d

# Or use Local by Flywheel, XAMPP, etc.
```

### Environment Constants
```php
// wp-config.php additions for development
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
define( 'SCRIPT_DEBUG', true );
```

## Advanced Features Integration

### Custom Post Types & Taxonomies
```php
// Register custom post type
add_action( 'init', array( $this, 'register_custom_post_types' ) );

public function register_custom_post_types() {
    register_post_type( 'my_custom_type', array(
        'labels' => array(
            'name' => __( 'Custom Types', 'textdomain' ),
        ),
        'public' => true,
        'supports' => array( 'title', 'editor' ),
    ) );
}
```

### Widget Integration
```php
// Register widgets
add_action( 'widgets_init', array( $this, 'register_widgets' ) );

public function register_widgets() {
    register_widget( 'My_Custom_Widget' );
}
```

### Shortcode Implementation
```php
// Register shortcodes
add_shortcode( 'my_shortcode', array( $this, 'shortcode_callback' ) );

public function shortcode_callback( $atts ) {
    $atts = shortcode_atts( array(
        'attribute' => 'default_value',
    ), $atts );

    return '<div class="my-shortcode">' . esc_html( $atts['attribute'] ) . '</div>';
}
```

## Plugin Dependencies & Integrations

### Supported Plugin Integrations
The boilerplate includes dedicated packages for popular plugin integrations:

1. **WooCommerce Integration**
   - Order hooks and filters
   - Product management
   - Payment gateway integration

2. **BuddyPress/BuddyBoss Integration**
   - Activity stream integration
   - Profile extensions
   - Group functionality

3. **Advanced Custom Fields Pro**
   - Field group management
   - Custom field integration
   - Template integration

## Maintenance & Updates

### Version Management
- Follow semantic versioning (x.y.z)
- Update version in main plugin file header
- Update version in package.json
- Create git tags for releases

### README.md Maintenance Protocol

**CRITICAL**: Always update the `README.md` file when making changes to the project. This is essential for documentation accuracy and developer experience.

#### When to Update README.md:

1. **Adding New Composer Packages**:
   ```bash
   # After running composer require
   composer require new/package

   # IMMEDIATELY update README.md with:
   # - Package name and purpose
   # - Installation command
   # - Integration code example
   # - Usage instructions
   ```

2. **npm Package Updates**:
   ```bash
   # After adding new npm dependencies
   npm install new-package

   # Update README.md sections:
   # - Build system dependencies
   # - Available npm commands
   # - Development workflow changes
   ```

3. **Project Structure Changes**:
   - New directories or file organization
   - Updated file paths or locations
   - Modified build output locations

4. **Feature Additions**:
   - New functionality or capabilities
   - API endpoints or hooks
   - Configuration options

#### README.md Update Checklist:

**For Composer Packages:**
```markdown
## 📦 Composer Packages

### [Package Category] (if new category)

```bash
# [Package description]
composer require vendor/package-name
```

#### Integration Example:
```php
// Add to load_composer_dependencies() method
if ( class_exists( 'Vendor\\Package\\ClassName' ) ) {
    new Vendor\Package\ClassName( $this->plugin_dir );
}
```

#### Usage:
- Explain what the package does
- How it integrates with the plugin
- Configuration options if any
```

**For npm Packages:**
```markdown
## 🛠️ Build System

### Updated Dependencies
```json
{
  "devDependencies": {
    "new-package": "^1.0.0"
  }
}
```

### New Commands (if applicable)
```bash
# New command description
npm run new-command
```
```

#### Standard README.md Sections to Maintain:

1. **Features List** - Keep current with new capabilities
2. **Requirements** - Update version requirements
3. **Installation Instructions** - Reflect current setup process
4. **Build Commands** - Keep npm scripts current
5. **Package Lists** - Maintain accurate dependency lists
6. **Code Examples** - Update integration examples
7. **Project Structure** - Reflect current directory organization
8. **Usage Examples** - Keep code samples current

#### Documentation Standards:

1. **Code Examples**: Always include working, tested code
2. **Version Numbers**: Keep package versions current
3. **Links**: Ensure all repository links are valid
4. **Structure**: Maintain consistent formatting
5. **Clarity**: Write for developers of all skill levels

#### Automated Documentation Workflow:

```bash
# Suggested workflow after changes
1. Make code changes
2. Update README.md immediately
3. Test all code examples in README.md
4. Commit both code and documentation changes
5. Create descriptive commit messages mentioning docs updates
```

#### README.md Quality Checks:

- [ ] All composer packages are documented
- [ ] All npm commands are listed and explained
- [ ] Code examples are tested and working
- [ ] Version numbers are current
- [ ] Links to repositories are valid
- [ ] Installation instructions are complete
- [ ] Examples match current file structure

### Backward Compatibility
- Maintain compatibility with supported WordPress versions
- Provide migration functions for database changes
- Deprecate features gradually with proper notices
- Update documentation to reflect compatibility changes

## Common Development Patterns

### Plugin Activation/Deactivation
```php
// Activation hook
register_activation_hook( __FILE__, array( 'Activator', 'activate' ) );

// Deactivation hook
register_deactivation_hook( __FILE__, array( 'Deactivator', 'deactivate' ) );
```

### Admin Menu Integration
```php
add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );

public function add_admin_menu() {
    add_menu_page(
        __( 'My Plugin', 'textdomain' ),
        __( 'My Plugin', 'textdomain' ),
        'manage_options',
        'my-plugin-slug',
        array( $this, 'admin_page_callback' )
    );
}
```

### Settings API Integration
```php
add_action( 'admin_init', array( $this, 'settings_init' ) );

public function settings_init() {
    register_setting( 'my_plugin_settings', 'my_plugin_options' );

    add_settings_section(
        'my_plugin_section',
        __( 'Settings Section', 'textdomain' ),
        null,
        'my_plugin_settings'
    );
}
```

## Documentation Maintenance Protocol for AI Agents

### MANDATORY: README.md Synchronization

**CRITICAL RULE**: Every time you add a package, modify configuration, or change project structure, you MUST update the README.md file immediately. This is not optional.

#### Trigger Events for README.md Updates:

1. **Composer Package Addition**:
   ```bash
   composer require vendor/package-name
   ```
   **Action Required**: Add package to README.md with installation command, integration code, and usage examples.

2. **npm Package Changes**:
   ```bash
   npm install package-name
   ```
   **Action Required**: Update build system documentation and available commands.

3. **File Structure Modifications**:
   - New directories created
   - Files moved or renamed
   - Build output changes
   **Action Required**: Update project structure diagram in README.md

4. **Configuration Changes**:
   - webpack.config.js modifications
   - composer.json updates
   - package.json script changes
   **Action Required**: Update relevant configuration sections

#### README.md Update Template:

**For New Composer Packages:**
```markdown
#### [Package Name] - [Brief Description]
```bash
composer require vendor/package-name
```

**Integration** (add to `load_composer_dependencies()` method):
```php
if ( class_exists( 'Vendor\\Package\\MainClass' ) ) {
    new Vendor\Package\MainClass( $this->plugin_dir );
}
```

**Purpose**: Explain what this package does and why it's included.
```

**For npm Dependencies:**
```markdown
#### [Package Name]
```bash
npm install package-name
```

**Usage**: Explain how this affects the build process or development workflow.
```

#### Quality Assurance Checklist:

- [ ] All new packages documented with installation commands
- [ ] Integration code examples provided and tested
- [ ] Project structure diagram reflects current state
- [ ] All links are functional and up-to-date
- [ ] Code examples use current file paths and class names
- [ ] Version requirements are accurate
- [ ] Build commands list is complete and current

#### Documentation Workflow:

1. **Before Making Changes**: Note current README.md state
2. **During Development**: Track what needs documentation updates
3. **After Changes**: Immediately update README.md
4. **Verification**: Test all documented commands and code examples
5. **Commit**: Include README.md changes in the same commit as code changes

#### Common Documentation Patterns:

**Package Documentation Pattern:**
1. Brief description of package purpose
2. Installation command
3. Integration code (where to add in the codebase)
4. Configuration options (if any)
5. Usage examples or notes

**Build System Updates:**
1. New npm commands with descriptions
2. Updated dependencies list
3. Modified workflow instructions
4. Changed file output locations

**Architecture Changes:**
1. Updated directory structure
2. New file locations
3. Modified class namespaces
4. Changed integration patterns

This comprehensive guide provides LLMs with detailed information about the WordPress Plugin Boilerplate structure, development workflows, best practices for creating professional WordPress plugins, and mandatory documentation maintenance protocols.
