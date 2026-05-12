---
name: "AcrossAI Abilities Manager"
description: "Agency standards for professional AcrossAI Abilities Manager"
version: "1.0.0"
---

# Agency Standards

## Environment

```yaml
php_min_version: "7.4"
wordpress_min_version: "6.9"
node_version: "18.0"
npm_version: "9.0"
composer_version: "2.0"
```

## Plugin Configuration

```yaml
naming_prefix: "acrossai_"
coding_standard: "wpcs-strict"
multisite_support: true
```

## Security Requirements

```yaml
enforce_nonces: true
enforce_capabilities: true
sanitize_input: true
escape_output: true
sql_prepared_statements: true
file_upload_validation: true
```

## Code Quality

```yaml
phpcs_enabled: true
phpstan_level: 8
eslint_enabled: true
```

## Plugin Boilerplate Reference

All plugin development MUST follow the `wp-plugin-development` skill: `.agents/skills/wp-plugin-development/SKILL.md`

## Package Strategy

```yaml
prefer_wordpress_packages: true
validation_script: "npm run validate-packages"
package_hierarchy:
  tier_1: "@wordpress/* packages (official, always first)"
  tier_2: "npm packages (lodash, date-fns, etc.)"
  tier_3: "external frameworks (avoid duplicating React, Vue, etc.)"
```

## Before Commit Checklist

- [ ] PHPCS pass
- [ ] PHPStan pass
- [ ] All functions prefixed with "acrossai_"
- [ ] Nonces on all forms/AJAX
- [ ] Capabilities checked
- [ ] Input sanitized, output escaped
- [ ] No deprecated functions
- [ ] Package validation pass (npm run validate-packages)

---

# AI Engineering Rules

## Core Rules

- Follow WordPress Coding Standards
- Never perform broad refactors
- Never modify unrelated systems
- Execute one task at a time
- Read specs before implementation
- Update reports after implementation
- Update memory when new learnings are discovered
- Always run validation before completion

---

# Workflow

1. Read `.specify/memory/CONSTITUTION.md`
2. Read current feature spec
3. Read related memory
4. Read current task
5. Plan implementation
6. Execute scoped changes only
7. Run PHPCS
8. Run security validation
9. Run unit tests
10. Generate feature report
11. Update memory
12. Mark task complete

---

# WordPress Rules

- Escape output
- Sanitize input
- Use nonce validation
- Use capability checks
- Use wp_remote_get()
- Use wp_remote_post()
- Prefer Action Scheduler
- Avoid direct SQL unless required

---

# Testing Rules

Feature is NOT complete without:
- PHPCS validation
- Security review
- Unit tests

---

# Submodule Rules

Never modify files inside:

`.agents/tools/`

unless explicitly requested.

These repositories are external dependencies and must remain isolated from plugin implementation.

---

# Code Organization & Module Structure

Architecture and module structure are governed by the Constitution.
Read `.specify/memory/CONSTITUTION.md` for the canonical rules on:
- Directory layout (`admin/Partials/`, `includes/Base/`, `includes/Utilities/`, `includes/Modules/`)
- Admin Partials Rule (admin enqueue/render classes must live in `admin/Partials/`)
- Boot Flow Rule (`register_hooks(Loader $loader)` pattern; no hooks from `load_dependencies()`)
- Module Contract (extend base class, expose `register_hooks()`, no sibling-module dependencies)
- UI Contract (`@wordpress/dataforms` for forms, `@wordpress/dataviews` for tables)
- DRY / reusability requirements
