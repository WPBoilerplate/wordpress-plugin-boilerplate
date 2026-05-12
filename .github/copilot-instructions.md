<!-- SPECKIT START -->
For additional context about technologies to be used, project structure,
shell commands, and other important information, read the current plan
<!-- SPECKIT END -->

<!-- COPILOT ACCESS POLICY START -->
## File Access Policy

### Hard Ignore — never read these paths
The following are generated, compiled, binary, or dev-only. Do not read or
include them in context under any circumstances:

- `.git/`
- `node_modules/`
- `build/`
- `coverage/`
- `tests/_output/`
- `.github/skills/`
- `vendor/wp-coding-standards/`
- `vendor/dealerdirect/`
- `vendor/phpunit/`
- `vendor/composer/`
- `vendor/bin/`
- `vendor/autoload.php`, `vendor/autoload_packages.php`
- `package-lock.json`, `composer.lock`
- `languages/`
- `tmp/`, `logs/`, `**/*.log`

### Requires Permission — ask before reading
These are production/runtime dependencies that ship with the plugin.
Before reading them, ask the user: "May I read <path> to help with this task?"

- `vendor/automattic/` — jetpack-autoloader (composer.json › require)
<!-- COPILOT ACCESS POLICY END -->
