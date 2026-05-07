# Structure: folder layout & namespace map

## Directory tree

```
plugin-root/
├── wordpress-plugin-boilerplate.php   # bootstrap (Plugin Name header + PLUGIN_FILE constant)
├── includes/
│   ├── Main.php         # core class: constants, autoloader, loader, hooks
│   ├── Loader.php       # singleton: collects add_action/add_filter calls, fires on run()
│   ├── Autoloader.php   # custom spl_autoload_register (namespace → directory)
│   ├── Activator.php    # static activate() stub
│   ├── Deactivator.php  # static deactivate() stub
│   └── I18n.php         # do_load_textdomain() hooked on init
├── admin/
│   ├── Main.php         # Admin\Main: enqueue backend CSS/JS
│   └── Partials/
│       └── Menu.php     # Admin\Partials\Menu: add_menu_page + plugin_action_links
├── public/
│   ├── Main.php         # Public\Main: enqueue frontend CSS/JS
│   └── partials/        # frontend template partials (placeholder)
├── src/
│   ├── js/
│   │   ├── backend.js
│   │   └── frontend.js
│   ├── scss/
│   │   ├── backend.scss
│   │   ├── frontend.scss
│   │   └── blocks/core/   # per-core-block stylesheets (globbed by webpack)
│   ├── blocks/            # custom Gutenberg blocks (auto-discovered via block.json)
│   ├── media/             # static media → build/media/ (CopyPlugin)
│   └── fonts/             # static fonts → build/fonts/ (CopyPlugin)
├── build/                 # compiled output — never edit directly
├── languages/             # .pot / .po / .mo files
├── composer.json
├── package.json
└── uninstall.php
```

## PSR-4 namespace map

| Namespace prefix | Directory |
|---|---|
| `WordPress_Plugin_Boilerplate\Includes\` | `includes/` |
| `WordPress_Plugin_Boilerplate\Admin\` | `admin/` |
| `WordPress_Plugin_Boilerplate\Public\` | `public/` |

The root prefix changes to your plugin's namespace after running `init-plugin.sh`.
`Public` is used as a reserved-word-safe alias — it is not the PHP keyword.

## Autoloader strategy

Two autoloaders are registered:

1. **Custom `Autoloader.php`** — loaded manually before Composer in `Main::__construct()`.
   Uses the namespace→directory map above; falls back to `includes/` for any sub-namespace
   not in the map.
2. **Composer PSR-4** — `vendor/autoload.php` loaded in `load_composer_dependencies()`.

After adding a new class file, always run:

```
composer dump-autoload
```

- Upstream reference: `https://github.com/WPBoilerplate/wordpress-plugin-boilerplate/blob/main/includes/Autoloader.php`
