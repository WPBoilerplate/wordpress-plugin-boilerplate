# Testing Documentation

This WordPress Plugin Boilerplate includes comprehensive testing infrastructure to ensure code quality and reliability.

## Testing Stack

### PHP Testing Tools

- **PHPUnit 9.6+**: Unit testing framework with WordPress integration
- **PHP CodeSniffer 3.7+**: WordPress Coding Standards enforcement with WPCS 3.0
- **PHPStan 1.10+**: Static analysis with WordPress-specific extensions
- **PHPCompatibility**: PHP version compatibility checking

### JavaScript Testing Tools

- **@wordpress/scripts**: WordPress-optimized build system
- **@wordpress/env**: Dockerized WordPress development environment

### Development Environment

- **wp-env**: Local WordPress development environment via Docker
- **Composer**: PHP dependency management
- **NPM**: JavaScript package management

## Available Commands

### PHP Testing Commands

```bash
# Run all PHP unit tests
npm run test:php

# Run PHP CodeSniffer (coding standards check)
npm run lint:php

# Auto-fix PHP coding standards issues
npm run lint:php:fix

# Run PHPStan static analysis
npm run analyze:php

# Run PHP compatibility check
npm run compat:php
```

### WordPress Environment Commands

```bash
# Start WordPress development environment
npm run env:start

# Stop WordPress development environment
npm run env:stop

# Restart WordPress development environment
npm run env:restart

# Clean WordPress environment
npm run env:clean

# Reset WordPress environment
npm run env:reset
```

### Combined Commands

```bash
# Run all tests and checks
npm run test

# Run all linting and analysis
npm run lint

# Fix all auto-fixable issues
npm run fix
```

## Test Structure

```
tests/
├── bootstrap.php              # WordPress test bootstrap (for full WP integration)
├── bootstrap-simple.php       # Simplified bootstrap (for unit tests)
├── phpunit-composer-install.php # Composer autoloader for tests
├── wordpress-constants.php     # WordPress constants for PHPStan
├── mu-plugins/
│   └── load-plugin.php        # Auto-activate plugin for tests
└── *.php                      # Individual test files
```

## Writing Tests

### Unit Test Example

```php
<?php
use PHPUnit\Framework\TestCase;
use WordPress_Plugin_Boilerplate\Includes\Main;

class MyTest extends TestCase {

    protected function setUp(): void {
        parent::setUp();
        // Test setup
    }

    public function test_something() {
        $instance = Main::instance();
        $this->assertInstanceOf(Main::class, $instance);
    }
}
```

### WordPress Integration Test Example

```php
<?php
use WP_UnitTestCase;

class MyWordPressTest extends WP_UnitTestCase {

    public function test_wordpress_functionality() {
        // Tests that require full WordPress environment
        $post_id = $this->factory->post->create();
        $this->assertGreaterThan(0, $post_id);
    }
}
```

## Configuration Files

### PHPUnit Configuration (`phpunit.xml.dist`)

- Configures test suites
- Sets up code coverage reporting
- Defines bootstrap file
- Excludes vendor and node_modules

### PHP CodeSniffer Configuration (`phpcs.xml.dist`)

- WordPress Coding Standards (WPCS 3.0)
- PHP Compatibility rules
- Custom exclusion patterns
- Severity levels

### PHPStan Configuration (`phpstan.neon.dist`)

- Analysis level 5 (strict)
- WordPress-specific extensions
- Custom ignores for WP functions
- Bootstrap files configuration

### WordPress Environment Configuration (`.wp-env.json`)

- WordPress version settings
- PHP version configuration
- Plugin and theme mounting
- Database configuration

## Continuous Integration

The testing setup is designed to work with CI/CD pipelines:

### GitHub Actions Example

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest

    steps:
    - uses: actions/checkout@v2

    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.0'

    - name: Install dependencies
      run: |
        composer install
        npm install

    - name: Run tests
      run: |
        npm run test:php
        npm run lint:php
        npm run analyze:php
```

## Code Quality Metrics

### Code Coverage

- HTML reports generated in `tests/coverage/`
- Clover XML format for CI integration
- Minimum coverage thresholds configurable

### Coding Standards

- WordPress Coding Standards enforcement
- PSR-12 compatibility where applicable
- Custom rules for plugin development

### Static Analysis

- Level 5 PHPStan analysis (strict)
- WordPress-specific type checking
- Dead code detection
- Performance issue identification

## Testing Best Practices

### Unit Tests

1. **Test one thing at a time**: Each test should verify a single behavior
2. **Use descriptive names**: Test method names should describe what they test
3. **Arrange, Act, Assert**: Structure tests with clear setup, execution, and verification
4. **Mock dependencies**: Use mocks for external dependencies like WordPress functions

### Integration Tests

1. **Test real scenarios**: Verify actual WordPress integration
2. **Use WordPress factories**: Leverage WP test factories for data creation
3. **Clean up after tests**: Reset state between tests
4. **Test user capabilities**: Verify permission checking

### Performance Testing

1. **Profile slow operations**: Use profiling tools for performance bottlenecks
2. **Test with realistic data**: Use production-like data volumes
3. **Monitor memory usage**: Check for memory leaks in long-running processes
4. **Database query analysis**: Verify efficient database operations

## Troubleshooting

### Common Issues

**Tests not found**: Check that test files follow naming conventions (`*Test.php`)

**WordPress functions not found**: Ensure proper bootstrap is loaded or functions are mocked

**Coding standards failures**: Run `npm run lint:php:fix` to auto-fix issues

**PHPStan errors**: Update type annotations and add ignores for WordPress-specific issues

### Debug Mode

Enable debug mode for more detailed output:

```bash
# Verbose PHPUnit output
./vendor/bin/phpunit --verbose

# PHPStan debug mode
./vendor/bin/phpstan analyse --debug

# PHPCS with detailed reporting
./vendor/bin/phpcs --report=full
```

## Contributing

When contributing to this plugin:

1. **Write tests first**: Follow TDD principles where possible
2. **Maintain coverage**: Ensure new code is tested
3. **Follow standards**: Use provided linting tools
4. **Update documentation**: Keep testing docs current

All pull requests must pass the full test suite and maintain code quality standards.
