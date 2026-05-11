# Decisions Record

This document records all major decisions made during plugin development.

When you make a significant decision, add it here with the rationale.

---

## Decision 001: PHP 7.4 Minimum

**Date**: [When adopted]
**Status**: ✅ Locked
**Decision**: Use PHP 7.4 as minimum version

**Rationale**:
- Broader hosting compatibility
- Modern PHP features available
- Performance improvements
- End of Life: Nov 2022 (acceptable)

**Impact**:
- Cannot use PHP 8.0+ syntax (typed properties, match, named arguments)
- Code is more verbose in some areas
- Better compatibility across shared hosting

---

## Decision 002: WordPress 6.9 Minimum

**Date**: [When adopted]
**Status**: ✅ Locked
**Decision**: Require WordPress 6.9+

**Rationale**:
- Full Block Editor maturity
- REST API stable with permissions
- Settings API fully featured
- Modern JavaScript support

**Impact**:
- Can use latest WordPress APIs
- Block development fully supported
- No legacy WP support needed

---

## Decision 003: Use @wordpress/element Instead of React

**Date**: [When adopted]
**Status**: ✅ Locked
**Decision**: Always import from @wordpress/element, never import React directly

**Rationale**:
- Avoid bundle duplication
- Use official WordPress packages
- Better WordPress ecosystem integration
- Smaller final bundle

**Impact**:
- Cannot use React-specific features
- Team must learn @wordpress/element API
- Validation script checks for violations

---

## Decision 004: Multisite Support from Day 1

**Date**: [When adopted]
**Status**: ✅ Locked
**Decision**: Plugin must be multisite-compatible from the beginning

**Rationale**:
- Retrofitting later is expensive
- Better code architecture overall
- WordPress community expectation
- Easy to disable if not used

**Impact**:
- More testing required
- Use get_blog_option() where needed
- Network activation handling required

---

## Decision 005: WPCS-Strict Coding Standard

**Date**: [When adopted]
**Status**: ✅ Locked
**Decision**: Zero violations for WordPress Coding Standards

**Rationale**:
- Consistency across team
- Security hardened
- Code quality guaranteed
- CI/CD enforces strictly

**Impact**:
- Code review focused on logic, not style
- PHPStan level 8 required
- ESLint rules enforced

---

## [Add New Decisions Below]

### Decision Template

**Date**: YYYY-MM-DD
**Status**: ✅ Locked / 🔄 Pending / ❌ Rejected
**Decision**: One sentence describing the decision

**Rationale**: Why we chose this approach

**Impact**: What this means for development

---

**Note**: Decisions are locked once approved. Change decisions only with team consensus.
