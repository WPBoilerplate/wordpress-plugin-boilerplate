# Project Memory

This folder contains institutional knowledge for the plugin.

## Files

### CONSTITUTION.md
Quick reference for team standards and rules.
- Read this first when starting work
- Updated to match AGENTS.md
- Source of truth: AGENTS.md

### DECISIONS.md
Record of major architectural decisions and why we made them.
- Add when making significant choices
- Explains rationale for past decisions
- Prevents repeated debate

### GOTCHAS.md
Lessons learned from problems encountered.
- Add when you discover an issue
- Helps new developers avoid mistakes
- Shows what we tried and failed

## How to Use

### When Starting Work
1. Read CONSTITUTION.md (2 minutes)
2. Read DECISIONS.md (5 minutes)
3. Skim GOTCHAS.md (3 minutes)

### When You Discover Something
1. Did it hurt us? → Add to GOTCHAS.md
2. Major decision made? → Add to DECISIONS.md
3. Standards changed? → Update AGENTS.md + CONSTITUTION.md

### When Onboarding New Developer
1. Have them read CONSTITUTION.md
2. Have them read DECISIONS.md
3. Have them reference GOTCHAS.md while coding

## Single Source of Truth

**AGENTS.md is the source of truth for all standards.**

These files REFERENCE and EXPLAIN AGENTS.md, they don't duplicate it.

If you change a standard (PHP version, rules, etc.):
- Edit AGENTS.md (only place)
- Then update CONSTITUTION.md to match
- One commit: `git commit -m "chore: update standards"`

## Claude Code Integration

Claude reads these files automatically before working on your plugin.
It will know:
- Your team's standards
- Decisions you've made
- Mistakes to avoid
- How to suggest code that fits your practices
