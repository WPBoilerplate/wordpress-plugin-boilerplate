# Plugin Architecture

## Overview

This plugin is scaffolded from [WPBoilerplate/wordpress-plugin-boilerplate](https://github.com/WPBoilerplate/wordpress-plugin-boilerplate) (main branch).

## Directory Layout

```
plugin-root/
├── admin/               # Admin-area classes (Admin\*)
│   └── Partials/        # Admin screen partials
├── includes/            # Core classes (Includes\*)
│   ├── Main.php         # Bootstrap — constants, hooks, loader init
│   ├── Loader.php       # Centralised add_action / add_filter
│   ├── Activator.php
│   ├── Deactivator.php
│   ├── I18n.php
│   └── Autoloader.php   # PSR-4 custom autoloader
├── public/              # Frontend classes (Public\*)
│   └── partials/
├── src/                 # Source assets (never edit build/ directly)
│   ├── js/
│   ├── scss/
│   └── media/
├── build/               # @wordpress/scripts output (gitignored)
├── languages/
└── .ai/                 # AI context (skills, plans, tasks, memory)
```

## Namespace Map (PSR-4)

| Namespace prefix                          | Directory    |
|-------------------------------------------|--------------|
| `WordPress_Plugin_Boilerplate\Includes\`  | `includes/`  |
| `WordPress_Plugin_Boilerplate\Admin\`     | `admin/`     |
| `WordPress_Plugin_Boilerplate\Public\`    | `public/`    |

## Boot Flow

1. Main plugin file defines `WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_FILE`.
2. `Includes\Main::run()` calls `define_constants()` → `load_dependencies()` → `set_locale()` → `define_admin_hooks()` → `define_public_hooks()` → `loader->run()`.
3. All hooks are registered via `$this->loader->add_action()` / `add_filter()` — never directly.

## Asset Pipeline

- Source: `src/js/`, `src/scss/`
- Build: `npm run build` → `build/js/*.js`, `build/css/*.css` + `*.asset.php` manifests
- Enqueue via `build/*.asset.php` for auto-versioning and dependency management.

## Integrations

See `.ai/skills/` for domain-specific guidance:

- `wordpress-core/` — hooks, options, CPTs, REST API
- `woo/` — WooCommerce integration patterns
- `givewp/` — GiveWP donation plugin integration
- `buddyboss/` — BuddyBoss Platform integration
