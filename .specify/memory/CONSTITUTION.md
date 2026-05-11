# Constitution

All standards, rules, and requirements are defined in AGENTS.md (source of truth).

Claude Code and team members should read AGENTS.md for the complete specification.

## Quick Reference (See AGENTS.md for details)

### Environment
- PHP: 7.4+
- WordPress: 6.9+
- Node: 18.0+
- npm: 9.0+
- Composer: 2.0+

### Standards
- Naming prefix: `agency_`
- Coding: WPCS strict
- Analysis: PHPStan level 8
- Linting: ESLint

### Security (Non-negotiable)
- Nonces on all forms/AJAX
- Capability checks on admin actions
- Sanitize input at entry
- Escape output at display
- Use $wpdb->prepare() for SQL
- File upload validation required
- No deprecated WordPress functions

### Code Quality
- PHPCS must pass
- PHPStan level 8 must pass
- ESLint must pass
- Unit tests required

### Workflow
1. Read AGENTS.md
2. Read feature spec
3. Plan → Execute → Validate → Test
4. Update memory with learnings
5. Mark complete

### Package Strategy
- Use @wordpress/* packages first
- Then npm packages
- Never duplicate React/Vue
- Run: npm run validate-packages

### WordPress Rules
- Escape output
- Sanitize input
- Nonce validation
- Capability checks
- Use wp_remote_get() / wp_remote_post()
- Prefer Action Scheduler
- Avoid direct SQL

### WooCommerce Rules (if applicable)
- HPOS compatible
- Use CRUD objects
- Use wc_get_orders()

### Testing Rules
Feature complete only with:
- PHPCS validation
- Security review
- Unit tests

### Submodule Rules
Never modify `.agents/tools/` (external dependencies)

---

**IMPORTANT**: If you need to update standards (PHP version, rules, etc.):
- Edit AGENTS.md (single source of truth)
- Then update this file to match
- One commit: `git commit -m "chore: update standards"`
