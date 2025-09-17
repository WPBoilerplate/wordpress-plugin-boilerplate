#!/bin/bash
# Usage: ./wordpress-plugin-boilerplate/init-plugin.sh

# Check for valid plugin name.
function valid_name () {
	valid="^[A-Z][A-Za-z0-9]*( [A-Z][A-Za-z0-9]*)*$"

	if [[ ! "$1" =~ $valid ]]; then
		return 1
	fi

	return 0
}

echo
echo "Hello, "$USER"."
echo
echo "This script will automatically generate a new plugin based on the scaffolding."
echo "The way it works is you enter a plugin name like 'Hello World' and the script "
echo "will create a directory 'hello-world' in the current working directory, or one "
echo "directory up if called from the plugin root, all while performing substitutions "
echo "on the 'wordpress-plugin-boilerplate' scaffolding plugin."
echo

echo -n "Enter your plugin name and press [ENTER]: "
read name

# Validate plugin name.
if ! valid_name "$name"; then
	echo "Malformed name '$name'. Please use title case words separated by spaces. No hyphens. For example, 'Hello World'."
	echo
	echo -n "Enter a valid plugin name and press [ENTER]: "
	read name

	if ! valid_name "$name"; then
		echo
		echo "The name you entered is invalid, rage quitting."
		exit 1
	fi
fi

slug="$( echo "$name" | tr '[:upper:]' '[:lower:]' | sed 's/ /-/g' )"
prefix="$( echo "$name" | tr '[:upper:]' '[:lower:]' | sed 's/ /_/g' )"
define="$( echo "$name" | tr '[:lower:]' '[:upper:]' | sed 's/ /_/g' )"
namespace="$( echo "$name" | sed 's/ //g' )"
class="$( echo "$name" | sed 's/ /_/g' )"
repo="$slug"

echo
echo "The Organization name will be converted to lowercase for use in the repository "
echo "path (i.e. WPBoilerplate becomes wpboilerplate)."
echo -n "Enter your GitHub organization name, and press [ENTER]: "
read org

org_lower="$( echo "$org" | tr '[:upper:]' '[:lower:]' )"

echo
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🚀 WPBoilerplate Dependencies Setup"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo
echo "Would you like to add WPBoilerplate dependencies to your plugin?"
echo "This includes packages for blocks, updates, plugin integrations, etc."
echo
echo "💡 Hint: You can always add these dependencies later using composer."
echo
while true; do
    echo -n "Add WPBoilerplate dependencies now? [y/N]: "
    read add_deps
    case $add_deps in
        [Yy]* )
            add_wpboilerplate_deps=true
            break;;
        [Nn]* | "" )
            add_wpboilerplate_deps=false
            echo "Skipping WPBoilerplate dependencies. You can add them later."
            break;;
        * ) echo "Please answer yes (y) or no (n).";;
    esac
done

# Array of available WPBoilerplate packages
# Using indexed arrays for better compatibility
wpb_packages=(
    "wpboilerplate/wpb-register-blocks|Automatic Gutenberg block registration|Recommended for block development"
    "wpboilerplate/wpb-updater-checker-github|GitHub-based plugin auto-updates|Enables updates from GitHub releases"
    "wpboilerplate/wpb-buddypress-dependency|BuddyPress integration|For BuddyPress compatibility"
    "wpboilerplate/wpb-buddyboss-dependency|BuddyBoss Platform specific|For BuddyBoss Platform only"
    "wpboilerplate/wpb-woocommerce-dependency|WooCommerce integration|For WooCommerce compatibility"
    "wpboilerplate/acrossswp-acf-pro-dependency|Advanced Custom Fields Pro|For ACF Pro integration"
    "wpboilerplate/wpb-view-analytics-dependency|View analytics tracking|For usage analytics"
)

selected_packages=()

if [ "$add_wpboilerplate_deps" = true ]; then
    echo
    echo "📦 Available WPBoilerplate Packages:"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

    for i in {0..6}; do
        IFS='|' read -ra PACKAGE_INFO <<< "${wpb_packages[$i]}"
        printf "  [%d] %-45s - %s\n" "$((i+1))" "${PACKAGE_INFO[0]}" "${PACKAGE_INFO[1]}"
        printf "      %s\n" "${PACKAGE_INFO[2]}"
        echo
    done

    echo "Select packages to install (enter numbers separated by spaces, or 'all' for all packages):"
    echo "Example: 1 2 5  (for blocks, updates, and WooCommerce)"
    echo -n "Your selection: "
    read package_selection

    if [ "$package_selection" = "all" ]; then
        for i in {0..6}; do
            IFS='|' read -ra PACKAGE_INFO <<< "${wpb_packages[$i]}"
            selected_packages+=("${PACKAGE_INFO[0]}")
        done
        echo "✅ Selected all packages"
    else
        for num in $package_selection; do
            if [[ $num =~ ^[1-7]$ ]]; then
                array_index=$((num-1))
                IFS='|' read -ra PACKAGE_INFO <<< "${wpb_packages[$array_index]}"
                selected_packages+=("${PACKAGE_INFO[0]}")
                echo "✅ Selected: ${PACKAGE_INFO[0]}"
            else
                echo "⚠️  Invalid selection: $num (skipped)"
            fi
        done
    fi

    echo
    echo "📋 Selected packages (${#selected_packages[@]} total):"
    for package in "${selected_packages[@]}"; do
        echo "  - $package"
    done
fi

echo
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🔧 Creating Plugin Files..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

cwd="$(pwd)"
cd "$(dirname "$0")"
src_repo_path="$(pwd)"
cd "$cwd"

if [[ -e $( basename "$0" ) ]]; then
    echo
	echo "Moving up one directory outside of 'wordpress-plugin-boilerplate'"
	cd ..
fi

if [[ -e "$slug" ]]; then
    echo
	echo "The $slug directory already exists"
	exit 1
fi

echo

git clone "$src_repo_path" "$repo"

cd "$repo"

git mv wordpress-plugin-boilerplate.php "$slug.php"

git mv languages/wordpress-plugin-boilerplate.pot languages/"$slug.pot"

git grep -lz "raftaar1191%2Fwordpress-plugin-boilerplate" | xargs -0 sed -i '' -e "s|raftaar1191%2Fwordpress-plugin-boilerplate|$org_lower%2F$repo|g"
git grep -lz "raftaar1191/wordpress-plugin-boilerplate" | xargs -0 sed -i '' -e "s|raftaar1191/wordpress-plugin-boilerplate|$org_lower/$repo|g"
git grep -lz "wordpress-plugin-boilerplate" | xargs -0 sed -i '' -e "s/wordpress-plugin-boilerplate/$repo/g"
git grep -lz "WordPress Plugin Boilerplate" | xargs -0 sed -i '' -e "s/WordPress Plugin Boilerplate/$name/g"
git grep -lz "wordpress-plugin-boilerplate" | xargs -0 sed -i '' -e "s/wordpress-plugin-boilerplate/$slug/g"
git grep -lz "wordpress_plugin_boilerplate" | xargs -0 sed -i '' -e "s/wordpress_plugin_boilerplate/$prefix/g"
git grep -lz "WORDPRESS_PLUGIN_BOILERPLATE" | xargs -0 sed -i '' -e "s/WORDPRESS_PLUGIN_BOILERPLATE/$define/g"
git grep -lz "WordPress_Plugin_Boilerplate" | xargs -0 sed -i '' -e "s/WordPress_Plugin_Boilerplate/$class/g"

# Clean slate.
rm -rf .git
rm -rf node_modules
rm -rf init-plugin.sh
rm -rf composer.lock
rm -rf vendor
rm -rf package-lock.json

# Add WPBoilerplate packages to composer.json if selected
if [ "$add_wpboilerplate_deps" = true ] && [ ${#selected_packages[@]} -gt 0 ]; then
    echo
    echo "📦 Adding selected packages to composer.json..."

    # Add packages to composer.json with error handling
    for package in "${selected_packages[@]}"; do
        echo "  Adding: $package"
        if ! composer require "$package" --no-install; then
            echo "  ⚠️  Warning: Could not add $package - package may not exist or be available"
            echo "      You can add it manually later if needed"
        fi
    done

    echo "✅ Packages added to composer.json"
fi

# Setup Git.
echo
echo "🔧 Initializing Git repository..."
git init
git add .
git remote add origin "git@github.com:$org_lower/$repo.git"

# Install dependencies.
echo
echo "📥 Installing dependencies..."
echo 'Installing composer dependencies..'
composer install

# Add integration code for selected packages
if [ "$add_wpboilerplate_deps" = true ] && [ ${#selected_packages[@]} -gt 0 ]; then
    echo
    echo "🔧 Adding integration code to includes/main.php..."

    # Define integration patterns for each package
    integration_code=""

    for package in "${selected_packages[@]}"; do
        case $package in
            "wpboilerplate/wpb-register-blocks")
                integration_code+="\n\t\t/**\n\t\t * Auto-register blocks from build/blocks directory\n\t\t */\n\t\tif ( class_exists( 'WPBoilerplate\\\\RegisterBlocks\\\\RegisterBlocks' ) ) {\n\t\t\tnew \\WPBoilerplate\\RegisterBlocks\\RegisterBlocks( \$this->plugin_dir );\n\t\t}\n"
                ;;
            "wpboilerplate/wpb-updater-checker-github")
                integration_code+="\n\t\t/**\n\t\t * GitHub auto-updater\n\t\t */\n\t\tif ( class_exists( 'WPBoilerplate_Updater_Checker_Github' ) ) {\n\t\t\t\$package = array(\n\t\t\t\t'repo' => 'https://github.com/$org_lower/$repo',\n\t\t\t\t'file_path' => ${define}_PLUGIN_FILE,\n\t\t\t\t'plugin_name_slug' => '${slug}',\n\t\t\t\t'release_branch' => 'main'\n\t\t\t);\n\t\t\tnew WPBoilerplate_Updater_Checker_Github( \$package );\n\t\t}\n"
                ;;
            "wpboilerplate/wpb-buddypress-dependency")
                integration_code+="\n\t\t/**\n\t\t * BuddyPress dependency check\n\t\t */\n\t\tif ( class_exists( 'WPBoilerplate_BuddyPress_Dependency' ) ) {\n\t\t\tnew WPBoilerplate_BuddyPress_Dependency( \$this->get_plugin_name(), ${define}_PLUGIN_FILE );\n\t\t}\n"
                ;;
            "wpboilerplate/wpb-buddyboss-dependency")
                integration_code+="\n\t\t/**\n\t\t * BuddyBoss Platform dependency check\n\t\t */\n\t\tif ( class_exists( 'WPBoilerplate_BuddyBoss_Dependency' ) ) {\n\t\t\tnew WPBoilerplate_BuddyBoss_Dependency( \$this->get_plugin_name(), ${define}_PLUGIN_FILE );\n\t\t}\n"
                ;;
            "wpboilerplate/wpb-woocommerce-dependency")
                integration_code+="\n\t\t/**\n\t\t * WooCommerce dependency check\n\t\t */\n\t\tif ( class_exists( 'WPBoilerplate_WooCommerce_Dependency' ) ) {\n\t\t\tnew WPBoilerplate_WooCommerce_Dependency( \$this->get_plugin_name(), ${define}_PLUGIN_FILE );\n\t\t}\n"
                ;;
            "wpboilerplate/acrossswp-acf-pro-dependency")
                integration_code+="\n\t\t/**\n\t\t * Advanced Custom Fields Pro dependency check\n\t\t */\n\t\tif ( class_exists( 'AcrossWP_ACF_Pro_Dependency' ) ) {\n\t\t\tnew AcrossWP_ACF_Pro_Dependency( \$this->get_plugin_name(), ${define}_PLUGIN_FILE );\n\t\t}\n"
                ;;
            "wpboilerplate/wpb-view-analytics-dependency")
                integration_code+="\n\t\t/**\n\t\t * View analytics tracking\n\t\t */\n\t\tif ( class_exists( 'WPBoilerplate_View_Analytics_Dependency' ) ) {\n\t\t\tnew WPBoilerplate_View_Analytics_Dependency( \$this->get_plugin_name(), ${define}_PLUGIN_FILE );\n\t\t}\n"
                ;;
        esac
    done

    # Add the integration code to includes/main.php
    if [ ! -z "$integration_code" ]; then
        # Find the line with "Check if class exists or not" and add after the existing wpb-register-blocks check
        sed -i '' "/Check if class exists or not/,/}$/c\\
\\t\\t/**\\
\\t\\t * Check if class exists or not\\
\\t\\t */$integration_code" includes/main.php

        echo "✅ Integration code added to includes/main.php"
    fi
fi

echo 'Installing npm dependencies...'
npm install

echo
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🎉 Plugin Setup Complete!"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo
echo "📍 Plugin Location: $(pwd)"
echo "🔗 GitHub Repository: git@github.com:$org_lower/$repo.git"
echo
if [ "$add_wpboilerplate_deps" = true ] && [ ${#selected_packages[@]} -gt 0 ]; then
    echo "📦 Installed WPBoilerplate Packages:"
    for package in "${selected_packages[@]}"; do
        echo "  ✅ $package"
    done
    echo
fi
echo "🚀 Next Steps:"
echo "  1. cd $(basename $(pwd))"
echo "  2. npm run start     # Start development mode"
echo "  3. npm run build     # Build for production"
echo
echo "📚 Documentation:"
echo "  • README.md - Complete setup guide"
echo "  • agents.md - AI development instructions"
