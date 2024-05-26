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
echo "path (i.e. AcrossWP becomes acrosswp)."
echo -n "Enter your GitHub organization name, and press [ENTER]: "
read org

org_lower="$( echo "$org" | tr '[:upper:]' '[:lower:]' )"

echo
echo -n "Do you want to make the initial commit? [Y/N]: "
read commit

if [[ "$commit" == Y ]] || [[ "$commit" == y ]]; then
	echo
	echo -n "Do you want to push the plugin to your GitHub repository? [Y/N]: "
	read push
fi

echo
echo -n "Do you want to install the dependencies in the new plugin? [Y/N]: "
read deps

echo

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

git mv includes/class-wordpress-plugin-boilerplate-activator.php includes/"class-$slug-activator.php"
git mv includes/class-wordpress-plugin-boilerplate-deactivator.php includes/"class-$slug-deactivator.php"
git mv includes/class-wordpress-plugin-boilerplate-i18n.php includes/"class-$slug-i18n.php"
git mv includes/class-wordpress-plugin-boilerplate.php includes/"class-$slug.php"
git mv includes/class-wordpress-plugin-boilerplate-loader.php includes/"class-$slug-loader.php"

git mv admin/class-wordpress-plugin-boilerplate-admin.php admin/"class-$slug-admin.php"
git mv admin/partials/wordpress-plugin-boilerplate-admin-display.php admin/partials/"$slug-admin-display.php"
git mv admin/update/wordpress-plugin-boilerplate-update.php admin/update/"$slug-update.php"

git mv public/class-wordpress-plugin-boilerplate-public.php public/"class-$slug-public.php"
git mv public/partials/wordpress-plugin-boilerplate-public-display.php public/partials/"$slug-public-display.php"

git mv languages/wordpress-plugin-boilerplate.pot languages/"$slug.pot"

git grep -lz "raftaar1191%2Fwordpress-plugin-boilerplate" | xargs -0 sed -i '' -e "s|raftaar1191%2Fwordpress-plugin-boilerplate|$org_lower%2F$repo|g"
git grep -lz "raftaar1191/wordpress-plugin-boilerplate" | xargs -0 sed -i '' -e "s|raftaar1191/wordpress-plugin-boilerplate|$org_lower/$repo|g"
git grep -lz "wordpress-plugin-boilerplate" | xargs -0 sed -i '' -e "s/wordpress-plugin-boilerplate/$repo/g"
git grep -lz "WordPress Plugin Boilerplate" | xargs -0 sed -i '' -e "s/WordPress Plugin Boilerplate/$name/g"
# git grep -lz "since BuddyBoss" | xargs -0 sed -i '' -e "s/since BuddyBoss/since $class /g"
git grep -lz "wordpress-plugin-boilerplate" | xargs -0 sed -i '' -e "s/wordpress-plugin-boilerplate/$slug/g"
git grep -lz "wordpress_plugin_boilerplate" | xargs -0 sed -i '' -e "s/wordpress_plugin_boilerplate/$prefix/g"
git grep -lz "WORDPRESS_PLUGIN_BOILERPLATE" | xargs -0 sed -i '' -e "s/WORDPRESS_PLUGIN_BOILERPLATE/$define/g"
git grep -lz "Wordpress_Plugin_Boilerplate" | xargs -0 sed -i '' -e "s/Wordpress_Plugin_Boilerplate/$class/g"

# Clean slate.
rm -rf .git
rm -rf node_modules
rm -f init-plugin.sh
rm -f composer.lock
rm -f package-lock.json

# Setup Git.
git init
git add .
git remote add origin "git@github.com:$org_lower/$repo.git"

# Install dependencies.
if [[ "$deps" == Y ]] || [[ "$deps" == y ]]; then
	npm install
fi

# Commit and push change.
if [[ "$commit" == Y ]] || [[ "$commit" == y ]]; then
	git commit -m "Initial commit"

	if [[ "$push" == Y ]] || [[ "$push" == y ]]; then
    	git push -u origin master
    else
    	echo
    	echo "Push changes to GitHub with the following command:"
    	echo "cd $(pwd) && git push -u origin master"
    fi
else
    echo
    echo "Commit and push changes to GitHub with the following command:"
    echo "cd $(pwd) && git commit -m \"Initial commit\" && git push -u origin master"
fi

echo
echo "Plugin is located at:"
pwd
