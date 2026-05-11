# WordPress Plugin Boilerplate

A comprehensive, modern WordPress plugin boilerplate that follows WordPress coding standards and incorporates the latest development tools and best practices.

[![WordPress](https://img.shields.io/badge/WordPress-6.9%2B-blue.svg)](https://wordpress.org)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-GPL%20v2%2B-red.svg)](http://www.gnu.org/licenses/gpl-2.0.html)

## 🚀 Features

- **Modern PHP Development**: PHP 7.4+ autoloading, namespace organization
- **WordPress Standards**: Follows WordPress Coding Standards (WPCS)
- **Build System**: @wordpress/scripts with Webpack, Babel, and SCSS support
- **Local Environment**: @wordpress/env for instant local WordPress environments
- **Block Development**: Integrated Gutenberg block creation and registration
- **Automated Deployment**: GitHub Actions for WordPress.org deployment
- **Internationalization**: Built-in i18n support
- **Composer Integration**: Dependency management with custom WPBoilerplate packages
- **Security**: Built-in security best practices and sanitization

## 📋 Requirements

> Check current WordPress version adoption and usage statistics: [wordpress.org/about/stats](https://wordpress.org/about/stats/)

- **WordPress**: 6.9 or higher
- **PHP**: 7.4 or higher (8.0+ recommended)
  - ⚠️ **Critical**: PHP 7.4 is the **minimum required version** enforced by `composer.json`
  - 🚀 **Recommended**: PHP 8.0+ for better performance and modern language features
  - 🔒 **Enforcement**: Composer will prevent installation on older PHP versions
- **Node.js**: 18.0 or higher
- **Composer**: 2.0 or higher

### 🔍 PHP Version Verification

```bash
php -v
# Should show PHP 7.4.0 or higher
```

**Why PHP 7.4+?**
- ✅ Arrow functions, typed properties, null coalescing assignment
- ✅ Significant performance improvements over PHP 7.3
- ✅ Required by modern WordPress development tools and packages

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
   - Optionally select WPBoilerplate Composer packages
   - The script will install dependencies, generate integration code, and offer to install agent skills

### Method 2: Manual Setup

```bash
git clone https://github.com/WPBoilerplate/wordpress-plugin-boilerplate.git my-plugin-name
cd my-plugin-name
composer install
npm install
npm run build
```

## 🏗️ Build System (@wordpress/scripts)

The plugin uses WordPress's official build tools for modern development workflows.

### Build & Assets

```bash
# Development build with hot reloading
npm run start

# Production build (optimized & minified)
npm run build

# Create a distributable plugin ZIP
npm run plugin-zip
```

### Code Quality

```bash
# Format code (Prettier via @wordpress/prettier-config)
npm run format

# Lint JavaScript
npm run lint:js

# Lint CSS/SCSS
npm run lint:css

# Check for outdated @wordpress/* packages
npm run packages-update

# Validate npm package usage against WordPress strategy
npm run validate-packages
```

### Local Environment (@wordpress/env)

```bash
# Start the local WordPress environment
npm run env:start

# Stop the environment
npm run env:stop

# Restart (stop + start)
npm run env:restart

# Clean all environment data (posts, settings, etc.)
npm run env:clean

# Destroy and rebuild from scratch
npm run env:reset
```

### Agent Skills

```bash
# Install or update WordPress agent skills interactively
npm run skillpack

# Push skills to the remote agent-skills repository
npm run skillpack:push
```

### Asset Pipeline

- **SCSS → CSS**: Automatic compilation with autoprefixing and minification
- **Modern JavaScript**: Babel transpilation for browser compatibility
- **Hot Reload**: Live reloading during development with `npm run start`
- **Source Maps**: Available in development mode for debugging

## 🏗️ Project Structure

```
wordpress-plugin-boilerplate/
├── 📁 .github/                    # GitHub Actions, agents & prompts
│   ├── workflows/
│   │   ├── build-zip.yml         # Automated ZIP creation
│   │   └── wordpress-plugin-deploy.yml  # WP.org deployment
│   ├── agents/                   # Speckit agent files
│   └── copilot-instructions.md   # Copilot integration
├── 📁 .specify/                   # Specify project memory & workflows
│   └── memory/                   # CONSTITUTION, DECISIONS, GOTCHAS
├── 📁 .agents/skills/             # Agent skill files
├── 📁 .wordpress-org/            # WordPress.org assets (banners, icons)
├── 📁 admin/                     # Admin functionality
│   ├── Main.php                 # Admin main class
│   └── partials/               # Admin templates
├── 📁 build/                     # Compiled assets (auto-generated)
├── 📁 includes/                  # Core classes
│   ├── main.php               # Main plugin class
│   ├── loader.php             # Hook management
│   ├── activator.php          # Activation logic
│   ├── deactivator.php        # Deactivation logic
│   ├── i18n.php               # Internationalization
│   └── Autoloader.php         # PSR-4 autoloader
├── 📁 languages/                 # Translation files
├── 📁 public/                    # Public-facing code
├── 📁 src/                       # Source assets (js, scss, media)
├── 📁 vendor/                    # Composer dependencies
├── 📄 AGENTS.md                  # Agency standards (source of truth)
├── 📄 composer.json              # Composer configuration
├── 📄 package.json               # npm configuration
├── 📄 webpack.config.js          # Build configuration
├── 📄 init-plugin.sh             # Initialization script
└── 📄 your-plugin.php            # Main plugin file
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
$clean_text  = sanitize_text_field( $_POST['user_input'] );
$clean_email = sanitize_email( $_POST['email'] );
$clean_url   = esc_url_raw( $_POST['url'] );

echo esc_html( $user_content );
echo esc_attr( $attribute_value );
echo esc_url( $link_url );
```

### Nonce Security
```php
wp_nonce_field( 'my_action', 'my_nonce' );

if ( ! wp_verify_nonce( $_POST['my_nonce'], 'my_action' ) ) {
    wp_die( 'Security check failed' );
}
```

### Capability Checks
```php
if ( ! current_user_can( 'manage_options' ) ) {
    wp_die( 'Insufficient permissions' );
}
```

## 🧱 Block Development

### Creating a Block

1. **Scaffold a new block**:
   ```bash
   mkdir -p src/blocks
   cd src/blocks
   npx @wordpress/create-block my-block-name --no-plugin
   ```

2. **Add the block registration package**:
   ```bash
   composer require wpboilerplate/wpb-register-blocks
   ```

3. **Integration is automatic** — configured in `includes/main.php`:
   ```php
   if ( class_exists( 'WPBoilerplate\\RegisterBlocks\\RegisterBlocks' ) ) {
       new \WPBoilerplate\RegisterBlocks\RegisterBlocks( $this->plugin_dir );
   }
   ```

4. **Build**:
   ```bash
   composer update
   npm run build
   ```

### Multiple Input File Architecture

Based on the [x3p0-ideas block example](https://github.com/x3p0-dev/x3p0-ideas/tree/block-example), each block can use separate files for clean separation of concerns:

```
src/blocks/example-block/
├── block.json       # Block metadata
├── index.js         # Main registration
├── edit.js          # Editor component
├── save.js          # Save component
├── view.js          # Frontend interactivity
├── style.scss        # Frontend styles
├── editor.scss       # Editor-only styles
└── variations.js    # Block variations
```

**block.json** — declare all assets:
```json
{
  "name": "my-plugin/example-block",
  "editorScript": "file:./index.js",
  "viewScript": "file:./view.js",
  "style": "file:./style.css",
  "editorStyle": "file:./editor.css"
}
```

**index.js** — main registration:
```javascript
import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit';
import Save from './save';
import metadata from './block.json';

registerBlockType( metadata.name, { ...metadata, edit: Edit, save: Save } );
```

**view.js** — frontend interactivity:
```javascript
import domReady from '@wordpress/dom-ready';

domReady( () => {
    // Frontend JavaScript for block interactions
} );
```

The build system automatically handles all entry points — `npm run build` outputs to `build/blocks/example-block/`.

### How Block Registration Works

`wpb-register-blocks` automatically:
- Scans your plugin's `build/blocks/` directory
- Registers all block types found in subdirectories
- Hooks into WordPress `init` to register blocks
- Uses PSR-4 autoloading for optimal performance

## 📦 Composer Packages

### PHP Version Requirement

All WPBoilerplate packages require **PHP 7.4+**, enforced in `composer.json`:

```json
{ "require": { "php": ">=7.4" } }
```

### Available Packages

| Package | Purpose |
|---|---|
| `wpboilerplate/wpb-register-blocks` | Auto-register Gutenberg blocks from `build/blocks/` |
| `wpboilerplate/wpb-updater-checker-github` | GitHub-based plugin auto-updates |
| `wpboilerplate/wpb-buddypress-or-buddyboss-dependency` | BuddyPress/BuddyBoss compatibility checker |
| `wpboilerplate/wpb-buddyboss-dependency` | BuddyBoss Platform dependency |
| `wpboilerplate/wpb-woocommerce-dependency` | WooCommerce integration support |
| `wpboilerplate/acrossswp-acf-pro-dependency` | Advanced Custom Fields Pro dependency |
| `coenjacobs/mozart` | PHP dependency scoping (pre-installed) |

### Install Packages

```bash
# Core
composer require wpboilerplate/wpb-register-blocks
composer require wpboilerplate/wpb-updater-checker-github

# Plugin dependencies
composer require wpboilerplate/wpb-buddypress-or-buddyboss-dependency
composer require wpboilerplate/wpb-buddyboss-dependency
composer require wpboilerplate/wpb-woocommerce-dependency
composer require wpboilerplate/acrossswp-acf-pro-dependency
```

### Mozart (PHP Dependency Scoping)

Mozart is pre-installed and prevents plugin conflicts by scoping third-party PHP dependencies.

```json
{
  "extra": {
    "mozart": {
      "dep_namespace": "WordPress_Plugin_Boilerplate\\Vendor\\",
      "dep_directory": "/src/dependencies/",
      "packages": [ "vendor/package-name" ]
    }
  }
}
```

```bash
vendor/bin/mozart compose
```

### Integration Examples

#### GitHub Auto-Updates
```php
if ( class_exists( 'WPBoilerplate_Updater_Checker_Github' ) ) {
    new WPBoilerplate_Updater_Checker_Github( array(
        'repo'             => 'https://github.com/YourOrg/your-plugin',
        'file_path'        => YOUR_PLUGIN_FILE,
        'plugin_name_slug' => 'your-plugin-slug',
        'release_branch'   => 'main',
    ) );
}
```

#### Plugin Dependency Check
```php
if ( class_exists( 'WPBoilerplate_BuddyPress_BuddyBoss_Platform_Dependency' ) ) {
    new WPBoilerplate_BuddyPress_BuddyBoss_Platform_Dependency(
        $this->get_plugin_name(),
        YOUR_PLUGIN_FILES
    );
}
```

### Installation via Script

When using `./init-plugin.sh`, packages can be selected interactively. The script adds them to `composer.json`, runs `composer install`, and auto-generates integration code in `includes/main.php`.

## 🌐 Internationalization (i18n)

```php
// Text domain registration
load_plugin_textdomain( 'your-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

// Translation functions
__( 'Text to translate', 'your-plugin' );
_e( 'Text to echo', 'your-plugin' );
_n( 'Singular', 'Plural', $count, 'your-plugin' );
```

## 🚀 Deployment & CI/CD

### GitHub Actions

| Workflow | Trigger | What it does |
|---|---|---|
| `build-zip.yml` | Release creation | Builds assets, creates and uploads a ZIP |
| `wordpress-plugin-deploy.yml` | Release creation | Deploys to WordPress.org SVN |

### Manual Release

```bash
# 1. Update version in plugin file header and package.json
# 2. Build production assets
npm run build

# 3. Tag and push
git tag v1.2.3
git push origin v1.2.3
```

## 🔧 Advanced Development

### Custom Post Types
```php
add_action( 'init', array( $this, 'register_post_types' ) );

public function register_post_types() {
    register_post_type( 'custom_type', array(
        'labels'       => array( 'name' => __( 'Custom Types', 'textdomain' ) ),
        'public'       => true,
        'supports'     => array( 'title', 'editor', 'thumbnail' ),
        'show_in_rest' => true,
    ) );
}
```

### REST API Endpoints
```php
add_action( 'rest_api_init', array( $this, 'register_api_routes' ) );

public function register_api_routes() {
    register_rest_route( 'my-plugin/v1', '/data', array(
        'methods'             => 'GET',
        'callback'            => array( $this, 'api_get_data' ),
        'permission_callback' => array( $this, 'api_permissions' ),
    ) );
}
```

### Database Integration
```php
public static function create_tables() {
    global $wpdb;
    $table_name      = $wpdb->prefix . 'my_plugin_data';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        data longtext,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
}
```

## 🎯 Performance Optimization

### Conditional Asset Loading
```php
public function enqueue_scripts() {
    if ( is_admin() && get_current_screen()->id === 'my-plugin-page' ) {
        wp_enqueue_script( 'my-plugin-admin', $this->plugin_url . 'build/js/admin.js' );
    }
}
```

### Transient Caching
```php
$data = get_transient( 'my_plugin_expensive_data' );
if ( false === $data ) {
    $data = $this->expensive_operation();
    set_transient( 'my_plugin_expensive_data', $data, HOUR_IN_SECONDS );
}
```

## 🎓 WordPress Agent Skills

[WordPress Agent Skills](https://github.com/WordPress/agent-skills) are portable instruction bundles that teach AI coding assistants (Claude, Copilot, Cursor, Codex, etc.) how to build WordPress the right way.

Skills are installed to all AI tool locations at once:

| Directory | Used by |
|---|---|
| `.github/skills/` | GitHub Copilot, VS Code |
| `.codex/skills/` | GitHub Copilot coding agent |
| `.claude/skills/` | Claude / Claude Code |
| `.cursor/skills/` | Cursor |

### Running the interactive manager

```bash
npm run skillpack
```

The script clones both [`WPBoilerplate/agent-skills`](https://github.com/WPBoilerplate/agent-skills) and [`WordPress/agent-skills`](https://github.com/WordPress/agent-skills), lists every available skill, and lets you pick what to install.

### Available Skills

| Skill | What it teaches |
|---|---|
| `wpboilerplate-plugin-boilerplate` | Architecture, hooks, asset pipeline, conventions for this boilerplate |
| `wp-plugin-development` | Plugin architecture, hooks, settings API, security |
| `wp-block-development` | Gutenberg blocks: `block.json`, attributes, rendering, deprecations |
| `wp-block-themes` | Block themes: `theme.json`, templates, patterns, style variations |
| `wp-rest-api` | REST API routes, schema, auth, and response shaping |
| `wp-interactivity-api` | Frontend interactivity with `data-wp-*` directives and stores |
| `wp-performance` | Profiling, caching, database optimization |
| `wp-phpstan` | PHPStan static analysis for WordPress projects |
| `wp-playground` | WordPress Playground for instant local environments |
| `wp-wpcli-and-ops` | WP-CLI commands, automation, multisite |
| `blueprint` | WordPress Playground Blueprints |
| `wordpress-router` | Classifies WordPress repos and routes to the correct workflow |
| `wp-project-triage` | Detects project type, tooling, and versions automatically |
| `wp-abilities-api` | WordPress Abilities API |
| `wp-plugin-directory-guidelines` | WordPress.org plugin directory guidelines |
| `wpds` | WordPress Design System components and tokens |

### During plugin init

When you run `./init-plugin.sh`, the skills manager is offered automatically after `npm install`. Answer `Y` to install, or run `npm run skillpack` at any time later.

## 🧠 Specify — Spec-Driven Development & Project Memory

[Specify (spec-kit)](https://github.com/github/spec-kit) is a CLI tool that brings **spec-driven development** to AI coding agents. It manages your project memory, generates feature specs, plans, and tasks, and runs full development workflows across any AI agent (Claude, Copilot, Cursor, Codex, Gemini, and more).

### Installation (one time, global)

```bash
uv tool install specify-cli --from git+https://github.com/github/spec-kit.git@v0.8.7
```

Verify the install:

```bash
specify --version
```

### What Specify Adds to This Boilerplate

```
.specify/
├── memory/                  # Project memory (see below)
│   ├── CONSTITUTION.md      # Quick-reference for all team standards
│   ├── DECISIONS.md         # Architectural decisions + rationale
│   ├── GOTCHAS.md           # Lessons learned, mistakes to avoid
│   └── README.md            # How to use the memory system
├── templates/               # Spec, plan, tasks, checklist templates
├── extensions/              # Git automation commands
├── integrations/            # AI agent integration configs
├── scripts/                 # Setup and automation scripts
└── workflows/               # Full SDD automation workflows

.agents/skills/              # Agent skills installed per integration
```

### Project Memory System

The `.specify/memory/` folder is the **institutional knowledge base** for the plugin. AI agents read these files automatically before writing code.

| File | Purpose | When to Update |
|---|---|---|
| `CONSTITUTION.md` | Quick-reference for all standards (mirrors AGENTS.md) | When standards change |
| `DECISIONS.md` | Why we made major architectural choices | After any significant decision |
| `GOTCHAS.md` | Problems we hit and how to fix them | After discovering an issue |

**How memory flows to AI agents:**

```
AGENTS.md  ──→  CONSTITUTION.md  ──→  AI agent reads before coding
                DECISIONS.md     ──→  AI avoids repeating past debates
                GOTCHAS.md       ──→  AI avoids known pitfalls
```

> AGENTS.md is always the **single source of truth**. Memory files reference it — never replace it.

### Commands

```bash
# Show all available commands
specify --help

# Check that all required tools are installed
specify check

# Show version and system info
specify version
```

#### Integration Management

```bash
specify integration list                   # List all integrations + install status
specify integration install claude         # Install Claude Code integration
specify integration use claude             # Set default integration
specify integration switch claude          # Switch from current to another
specify integration upgrade claude         # Upgrade to latest version
```

#### Workflow Commands

```bash
specify workflow list                      # List installed workflows
specify workflow run speckit               # Run full SDD cycle
specify workflow status                    # Check running workflow status
specify workflow resume                    # Resume paused/failed workflow
```

#### Extension Commands

```bash
specify extension list
specify extension install git
```

### Full SDD Workflow

```
specify workflow run speckit
        │
        ▼
  1. specify     ← AI generates a feature spec from your description
        │
  [Review gate] ← You approve or reject the spec
        │
        ▼
  2. plan        ← AI creates an implementation plan
        │
  [Review gate] ← You approve or reject the plan
        │
        ▼
  3. tasks       ← AI breaks the plan into discrete tasks
        │
        ▼
  4. implement   ← AI implements each task
```

### Supported AI Agent Integrations

| Integration | Type | Multi-install |
|---|---|---|
| `claude` | Claude Code (CLI) | Yes |
| `copilot` | GitHub Copilot (IDE) | No |
| `cursor-agent` | Cursor (IDE) | Yes |
| `codex` | Codex CLI | Yes |
| `gemini` | Gemini CLI | Yes |
| `windsurf` | Windsurf (IDE) | Yes |

Install multiple integrations for teams that use different tools:

```bash
specify integration install claude
specify integration install cursor-agent
specify integration use claude
```

---

## ✅ Standards & AI Agent Configuration

This boilerplate ships with two companion files that define quality standards and teach AI coding assistants how to build WordPress plugins professionally.

### AGENTS.md — What Standards to Follow

`AGENTS.md` is an agency-customizable configuration file that defines the rules every developer (human or AI) must follow in this project.

| Requirement | Status |
|---|---|
| PHP 7.4 minimum | ✅ |
| WordPress 6.9 minimum | ✅ |
| Agency naming prefix | ✅ |
| Coding standards (WPCS-strict, PHPStan level 8) | ✅ |
| Security (nonces, capabilities, sanitization, escaping, SQL safety, file uploads) | ✅ |
| AI Engineering Rules | ✅ |
| 12-step workflow process | ✅ |
| WordPress Rules | ✅ |
| WooCommerce Rules | ✅ |
| Testing Rules | ✅ |
| Submodule Rules | ✅ |
| Before Commit Checklist | ✅ |

**How to customize for your agency**: Edit `AGENTS.md` to set your own PHP/WordPress minimum versions, naming prefix, PHPStan level, security rules, and workflow steps. AI agents (Claude, Cursor, Copilot, etc.) read this file automatically and enforce your standards on every code generation request.

### SKILL.md — How to Implement Those Standards

The `wp-plugin-development` agent skill (installed via `npm run skillpack`) provides a complete step-by-step procedure for AI agents to build plugins that conform to `AGENTS.md`.

| Skill Section | Status |
|---|---|
| Clear when-to-use section | ✅ |
| Required inputs | ✅ |
| Complete 12-step procedure | ✅ |
| Pre-ship checklist | ✅ |
| Verification steps | ✅ |
| Failure modes & debugging | ✅ |
| Escalation paths | ✅ |
| References to architecture & best practices | ✅ |

### Alignment Between Files

```
AGENTS.md                    SKILL.md (wp-plugin-development)
─────────────────────        ──────────────────────────────────
Defines WHAT standards  →    Shows HOW to implement them
Agency-customizable     →    Step-by-step procedure for AI agents
Rules & constraints     →    Workflow & verification steps
```

### What This Enables

| Stakeholder | Benefit |
|---|---|
| **Agencies** | Customize `AGENTS.md` once — all AI tools inherit your standards |
| **Developers** | Follow `SKILL.md` for a proven, repeatable build process |
| **AI agents** | Claude, Cursor, Copilot read both files to enforce quality automatically |
| **CI/CD** | Validate against `AGENTS.md` rules in every pipeline run |
| **New team members** | Clear documentation from day one |

> Run `npm run skillpack` to install or update the `wp-plugin-development` skill and all other WordPress agent skills.

---

## 🔗 Plugin Ecosystem

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

For detailed AI agent instructions, see [AGENTS.md](AGENTS.md)
