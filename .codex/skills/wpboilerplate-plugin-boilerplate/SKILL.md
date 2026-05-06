---
name: wpboilerplate-plugin-boilerplate
description: "Use when working in plugins scaffolded from WPBoilerplate/wordpress-plugin-boilerplate (main branch): adding hooks via the Loader singleton, defining constants in Includes\\Main, adding admin pages under Admin\\Partials, enqueuing assets from build/*.asset.php manifests, and respecting the PSR-4 namespace map (Includes/Admin/Public)."
compatibility: "Targets WordPress 6.9+ (PHP 7.4+ per composer.json). Assumes @wordpress/scripts build pipeline and the namespaced PSR-4 layout from the main branch (not the legacy master branch)."
---

# WPBoilerplate Plugin Boilerplate

## When to use

Use this skill when working in a plugin scaffolded from
[WPBoilerplate/wordpress-plugin-boilerplate](https://github.com/WPBoilerplate/wordpress-plugin-boilerplate)
(`main` branch), for tasks such as:

- adding or moving WordPress hooks/actions/filters
- registering admin pages, menus, or submenu pages
- enqueuing admin or frontend assets (CSS/JS)
- defining new plugin constants
- adding activation, deactivation, or uninstall logic
- adding or modifying i18n / text-domain loading
- refactoring existing code into the namespaced PSR-4 layout
- adding new Gutenberg blocks or block styles
- scaffolding a renamed copy via `init-plugin.sh`

## Inputs required

- Plugin root path and slug (post-`init-plugin.sh` rename if applicable).
- Whether `init-plugin.sh` has been run (affects namespace prefix and text domain).
- Target WordPress + PHP versions (boilerplate requires PHP 7.4+).
- Whether `build/` artifacts are present (`npm run build` has been run).

## Procedure

### 0) Detect the boilerplate

Run the detector from the plugin root:

```
node skills/wpboilerplate-plugin-boilerplate/scripts/detect_wpboilerplate.mjs
```

Confirms `isWPBoilerplate: true`, reads the active namespace prefix, and reports whether
`build/` artifacts exist. If the skill is not installed, fall back to:

```
node skills/wp-plugin-development/scripts/detect_plugins.mjs
```

See: `references/structure.md`

### 1) Respect the namespace + folder layout

- `Admin\*` classes → `admin/`
- `Includes\*` classes → `includes/`
- `Public\*` classes → `public/`
- New classes must match the PSR-4 map in `composer.json` (and the custom `Autoloader.php`).
- Run `composer dump-autoload` after adding a new class file.

See: `references/structure.md`

### 2) Follow the boot flow; put constants in the right file

- Only `WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_FILE` is defined in the bootstrap.
- All other constants belong in `includes/Main.php::define_constants()` using the private
  `define($name, $value)` guard. Never define constants elsewhere.
- Hook registration happens in `define_admin_hooks()` / `define_public_hooks()` via the Loader,
  never with direct `add_action`/`add_filter` calls inside class constructors.
- The `apply_filters('wordpress-plugin-boilerplate-load', true)` gate in `load_hooks()` is the
  supported kill switch for third-party integrations.

See: `references/boot-flow.md`

### 3) Add admin pages and enqueues correctly

- Create new screen classes under `admin/Partials/` with namespace `...\Admin\Partials`.
- Instantiate the class in `includes/Main.php::define_admin_hooks()`.
- Register every hook through `$this->loader->add_action(...)` — never directly.
- To add new admin assets, add entry points to `webpack.config.js` and enqueue via
  `Admin\Main` methods using the `*.asset.php` manifest.

See: `references/admin.md`

### 4) Add frontend code under public/

- All frontend classes go under `public/` with namespace `...\Public`.
- Instantiate in `includes/Main.php::define_public_hooks()` and register via the Loader.
- Source JS → `src/js/`, source SCSS → `src/scss/`. Never edit `build/` directly.
- Read asset versions and dependencies from `build/*.asset.php` — never hardcode.

See: `references/public.md`

### 5) Lifecycle: Activator, Deactivator, uninstall, i18n

- Activation setup (tables, options, roles) → `Includes\Activator::activate()`.
- Deactivation lightweight cleanup (cron, transients) → `Includes\Deactivator::deactivate()`.
- Data removal (delete_option, drop tables) → `uninstall.php` only.
- i18n is loaded on `init`, not `plugins_loaded` — do not move it.

See: `references/lifecycle.md`

### 6) Build assets through @wordpress/scripts

- Run `npm run build` (production) or `npm run start` (watch) before testing.
- Standard JS/SCSS entries, custom blocks (`src/blocks/**/block.json`), and block stylesheets
  (`src/scss/blocks/core/`) are all picked up automatically by `webpack.config.js`.
- To add a brand-new entry point that is not block-based, add it to `webpack.config.js`.
- Static assets (`src/media/`, `src/fonts/`) are copied to `build/` by CopyPlugin.

See: `references/build-system.md`

## Verification

- `composer dump-autoload` completes with no errors.
- `npm run build` produces `*.asset.php` for every enqueued entry.
- Admin menu item appears at `/wp-admin/admin.php?page=<plugin-slug>`.
- Frontend assets enqueue on the correct pages (check with Query Monitor or browser devtools).
- `WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_URL` holds a URL, not a version string (known source bug —
  the guard prevents a fatal; the first definition wins).
- PHPCS passes: `./vendor/bin/phpcs` (or `composer run phpcs` if configured).

## Failure modes / debugging

- **Class not found** — namespace mismatch in file path, or `composer dump-autoload` not run after adding the file.
- **Constants double-defined PHP notice** — constant defined outside `define_constants()` without the guard; move it inside and use the private `define()` pattern.
- **Hooks not firing** — hook registered with direct `add_action` instead of through the Loader, or `apply_filters('wordpress-plugin-boilerplate-load', true)` was filtered to `false`.
- **Asset 404** — `build/` artifacts missing; run `npm run build`. Also check that the constant `WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_URL` is correct (see known bug in `boot-flow.md`).
- **Text-domain not loading** — `do_load_textdomain()` moved to `plugins_loaded`; it must stay on `init`.
- **Vendor conflict / class not found in vendor** — run `composer install` then `composer dump-autoload`; Mozart may need to re-scope namespaces.

## Escalation

- Boilerplate `agents.md`: `https://github.com/WPBoilerplate/wordpress-plugin-boilerplate/blob/main/agents.md`
- Boilerplate README: `https://github.com/WPBoilerplate/wordpress-plugin-boilerplate/blob/main/README.md`
- WordPress Plugin Handbook: `https://developer.wordpress.org/plugins/`
