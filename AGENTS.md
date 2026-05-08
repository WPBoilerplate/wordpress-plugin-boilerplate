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

1. Read architecture.md
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

# WooCommerce Rules

- HPOS compatible
- Use CRUD objects
- Use wc_get_orders()

---

# Testing Rules

Feature is NOT complete without:
- PHPCS validation
- Security review
- Unit tests

# Submodule Rules

Never modify files inside:

.ai/tools/

unless explicitly requested.

These repositories are external dependencies and must remain isolated from plugin implementation.
