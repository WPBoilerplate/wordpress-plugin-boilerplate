# Spec-Driven Development with Spec Kit

This section explains how to set up and use Spec Kit for specification-driven development and project memory management in your plugin.

## 📋 What is Spec Kit?

Spec Kit is a toolkit that helps you build WordPress plugins using **Specification-Driven Development (SDD)**. Instead of writing code and documentation later, you write clear specifications first, and then use AI agents (like Claude Code) to implement from those specifications.

**Key Benefits:**
- 📝 Clear specifications before coding
- 🤖 AI-assisted implementation
- 💾 Project memory and institutional knowledge
- 👥 Better team collaboration
- 🎯 Reduced scope creep
- 📚 Living documentation

## 🚀 Quick Start

### Prerequisites

- **uv** package manager (or pipx)
- **Claude Code** (or other AI coding agent)
- Python 3.7+

### Installation

#### 1. Install Spec Kit CLI

```bash
# Using uv (recommended)
uv tool install specify-cli --from git+https://github.com/github/spec-kit.git@v0.8.7

# Or using pipx
pip install pipx
pipx install specify-cli --from git+https://github.com/github/spec-kit.git@v0.8.7
```

#### 2. Initialize Spec Kit in Your Plugin

Navigate to your plugin root directory:

```bash
cd your-plugin-directory

# Initialize Spec Kit
specify init --here --integration claude-code
```

When prompted:
- **Which agent?** → Select `claude-code`
- **Continue with setup?** → Select `yes`

#### 3. Verify Installation

```bash
# Check that .specify folder was created
ls -la .specify/

# You should see:
# .specify/
# ├── memory/
# │   └── constitution.md
# ├── scripts/
# ├── templates/
# ├── .specifyrc.json
# └── ...
```

#### 4. Commit to Git

```bash
git add .specify/
git commit -m "chore: add spec kit v0.8.7 infrastructure"
git push
```

---

## 📁 Project Memory Setup

Project memory stores team standards, decisions, and lessons learned. This helps:
- New developers understand your practices
- Claude Code suggest code aligned with your standards
- Team remember why decisions were made
- Prevent repeating mistakes

### Adding Memory Files

Ask Claude Code to create memory files:

**Prompt for Claude Code:**
```
Please create project memory files in .specify/memory/ with:
1. CONSTITUTION.md - Quick reference for team standards
2. DECISIONS.md - Record of architectural decisions
3. GOTCHAS.md - Lessons learned
4. README.md - Explanation of memory files

The content should reference AGENTS.md as source of truth.
Commit all files with message "chore: setup project memory infrastructure"
```

Or manually create the files:

#### `.specify/memory/CONSTITUTION.md`

```markdown
# Constitution

All standards, rules, and requirements are defined in AGENTS.md (source of truth).

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

### Code Quality
- PHPCS must pass
- PHPStan level 8 must pass
- ESLint must pass
- Unit tests required

See AGENTS.md for complete specification.
```

#### `.specify/memory/DECISIONS.md`

```markdown
# Decisions Record

This document records all major decisions made during plugin development.

## Decision 001: PHP 7.4 Minimum

**Date**: 2026-05-10
**Status**: ✅ Locked
**Decision**: Use PHP 7.4 as minimum version

**Rationale**: Broader hosting compatibility, modern features available

**Impact**: Cannot use PHP 8.0+ syntax

---

[Add new decisions as you make them]
```

#### `.specify/memory/GOTCHAS.md`

```markdown
# Gotchas & Lessons Learned

This document captures problems encountered so we can prevent them in the future.

## Template

### Gotcha: [Short Name]

**Discovered**: Date
**Severity**: Critical/High/Medium/Low
**Status**: Resolved/Monitoring

**The Problem**: What broke?

**The Solution**: How we fixed it?

**Prevention**: How to avoid next time?

---

[Add gotchas as you work]
```

#### `.specify/memory/README.md`

```markdown
# Project Memory

This folder contains institutional knowledge for the plugin.

## Files

- **CONSTITUTION.md** - Quick reference for team standards
- **DECISIONS.md** - Record of architectural decisions
- **GOTCHAS.md** - Lessons learned from problems

## How to Use

### When Starting Work
1. Read CONSTITUTION.md (2 minutes)
2. Read DECISIONS.md (5 minutes)
3. Skim GOTCHAS.md (3 minutes)

### When You Discover Something
1. Found a problem? → Add to GOTCHAS.md
2. Made a decision? → Add to DECISIONS.md
3. Changed standards? → Update AGENTS.md + CONSTITUTION.md

### When Onboarding New Developer
1. Have them read CONSTITUTION.md
2. Have them read DECISIONS.md
3. Reference GOTCHAS.md while coding

## Single Source of Truth

**AGENTS.md is the source of truth for all standards.**

Update standards only in AGENTS.md, then sync CONSTITUTION.md.
```

---

## 🎯 Using Spec Kit Workflow

### Basic Workflow

#### 1. Create a Feature Specification

In Claude Code chat:

```
/speckit.specify

Create a feature specification for: [Your feature description]
```

This creates:
```
.specify/specs/001-your-feature/
├── spec.md          # What should it do?
├── plan.md          # How should it work?
└── tasks.md         # What are the steps?
```

#### 2. Create an Implementation Plan

```
/speckit.plan

Create a technical implementation plan for: [Your feature description]
Include data models, architecture decisions, and API contracts.
```

Updates:
```
.specify/specs/001-your-feature/
├── plan.md          # Updated with technical details
├── research.md      # Tech stack research
└── contracts/       # API specifications
```

#### 3. Generate Implementation Tasks

```
/speckit.tasks

Generate a task breakdown from the plan.
```

Creates:
```
.specify/specs/001-your-feature/
└── tasks.md         # Step-by-step implementation tasks
```

#### 4. Implement the Feature

```
/speckit.implement

Implement the tasks from the task list.
```

#### 5. Archive the Feature

Once the feature is merged to main:

```
/speckit.archive.run
```

This consolidates the feature specification into project memory.

---

## 📊 Project Structure with Spec Kit

After setup, your plugin structure includes:

```
your-plugin/
├── AGENTS.md                          # Agency standards (source of truth)
├── README.md                          # This file + instructions
│
├── .specify/                          # Spec Kit root
│   ├── memory/
│   │   ├── constitution.md            # Auto-generated by Spec Kit
│   │   ├── CONSTITUTION.md            # Your standards reference
│   │   ├── DECISIONS.md               # Your decisions
│   │   ├── GOTCHAS.md                 # Your lessons learned
│   │   └── README.md                  # Memory explanation
│   │
│   ├── specs/                         # Feature specifications
│   │   ├── 001-feature-name/
│   │   │   ├── spec.md
│   │   │   ├── plan.md
│   │   │   ├── tasks.md
│   │   │   └── research.md
│   │   └── 002-another-feature/
│   │
│   ├── scripts/                       # Spec Kit scripts
│   ├── templates/                     # Spec templates
│   └── .specifyrc.json               # Spec Kit config
│
├── .agents/
│   ├── skills/
│   │   ├── wp-plugin-development/
│   │   └── wp-packages-strategy/
│   └── tools/
│
├── src/                               # Your plugin code
├── admin/
├── includes/
├── public/
├── build/                             # Compiled assets
└── ... (other plugin files)
```

---

## 🤖 Claude Code Integration

### Slash Commands Available

Once Spec Kit is set up, Claude Code has these commands:

```
/speckit.specify          Create feature specification
/speckit.clarify          Clarify and refine specs
/speckit.analyze          Analyze specs for gaps
/speckit.plan             Create implementation plan
/speckit.tasks            Generate task breakdown
/speckit.implement        Execute tasks
/speckit.review           Review implementation
/speckit.archive.run      Archive merged features
```

### How Claude Code Uses Memory

Claude Code automatically:
1. Reads `.specify/memory/CONSTITUTION.md` before working
2. Knows your standards without you explaining them
3. Suggests code aligned with your DECISIONS.md
4. Avoids issues documented in GOTCHAS.md
5. References AGENTS.md for complete specifications

**Result:** Claude Code code suggestions match your exact standards.

---

## 📚 Best Practices

### For Specifications

- ✅ **Be explicit** - Describe what you're building and why
- ✅ **Include acceptance criteria** - How do we know it's done?
- ✅ **Consider edge cases** - What could go wrong?
- ✅ **Reference decisions** - Link to DECISIONS.md
- ❌ **Don't focus on tech stack** - Let Claude suggest tools
- ❌ **Don't be vague** - "Make it work" is too vague

### For Memory Files

- ✅ **Update CONSTITUTION.md** - Keep it in sync with AGENTS.md
- ✅ **Add DECISIONS.md** - Record why you chose something
- ✅ **Document GOTCHAS.md** - Capture what hurt you
- ✅ **Commit regularly** - Memory is version controlled
- ❌ **Don't duplicate AGENTS.md** - Reference it instead
- ❌ **Don't ignore patterns** - If something repeats, escalate it

### For Team Collaboration

- ✅ **New devs read memory first** - 15 minutes saves hours
- ✅ **Review memory before coding** - Refresh your context
- ✅ **Update after learning** - Add to GOTCHAS.md immediately
- ✅ **Share decisions** - Record in DECISIONS.md
- ❌ **Don't keep secrets** - Document everything
- ❌ **Don't repeat debates** - Check DECISIONS.md first

---

## 🔄 Workflow Example

### Scenario: Building a Payment Feature

**Step 1: Specification**

```
/speckit.specify

Create a specification for integrating WooCommerce payments with our plugin.
Users should be able to process payments through Stripe.
Include failure handling and refund management.
```

**Output**: `.specify/specs/001-woocommerce-payments/spec.md`

**Step 2: Planning**

```
/speckit.plan

Create an implementation plan.
Use WooCommerce HPOS for order management.
Integrate Stripe API for payments.
Follow our security standards from AGENTS.md.
```

**Output**: `.specify/specs/001-woocommerce-payments/plan.md`

**Step 3: Task Breakdown**

```
/speckit.tasks

Generate task breakdown from the plan.
```

**Output**: `.specify/specs/001-woocommerce-payments/tasks.md`

**Step 4: Implementation**

```
/speckit.implement

Implement the payment feature following the task list.
```

Claude Code:
- ✅ Uses WooCommerce CRUD objects (from DECISIONS.md)
- ✅ Adds nonce verification (from CONSTITUTION.md)
- ✅ Avoids the Elementor conflict (from GOTCHAS.md)
- ✅ Follows WPCS standards (from AGENTS.md)

**Step 5: Record Learnings**

Add to `.specify/memory/GOTCHAS.md`:

```markdown
### Gotcha: Stripe Webhook Signature Verification

**Problem**: Webhooks kept failing silently

**Solution**: Used wp_remote_post() with proper timeout

**Prevention**: Always test webhook flow in staging
```

**Step 6: Archive**

```
/speckit.archive.run

Archive the payment feature into project memory.
```

---

## 🔧 Maintenance

### Updating Spec Kit

```bash
# Check for updates
uv tool upgrade specify-cli

# Or reinstall latest
uv tool install --force specify-cli --from git+https://github.com/github/spec-kit.git@v0.8.7
```

### Updating AGENTS.md and Memory

When you change standards in AGENTS.md:

```bash
# 1. Edit AGENTS.md
nano AGENTS.md

# 2. Update CONSTITUTION.md to match
nano .specify/memory/CONSTITUTION.md

# 3. Commit together
git add AGENTS.md .specify/memory/CONSTITUTION.md
git commit -m "chore: update standards (PHP 8.0)"
git push
```

### Reviewing Memory Files

Monthly, review memory files:

```bash
# Check if DECISIONS need updates
cat .specify/memory/DECISIONS.md

# Review common GOTCHAS
cat .specify/memory/GOTCHAS.md

# See if patterns need escalation to CONSTITUTION.md
```

---

## 📖 Learn More

- **Spec Kit Docs**: https://github.com/github/spec-kit
- **Specification-Driven Development**: https://github.com/github/spec-kit/blob/main/spec-driven.md
- **WPBoilerplate Docs**: See AGENTS.md in this repository

---

## ✅ Checklist: Getting Started

- [ ] Install Spec Kit CLI: `uv tool install specify-cli --from git+https://github.com/github/spec-kit.git@v0.8.7`
- [ ] Initialize in plugin: `specify init --here --integration claude-code`
- [ ] Create memory files: CONSTITUTION.md, DECISIONS.md, GOTCHAS.md
- [ ] Commit: `git add .specify/ && git commit -m "chore: add spec kit"`
- [ ] Read this guide once more
- [ ] Try first spec: `/speckit.specify` in Claude Code
- [ ] Ask Claude Code to implement: `/speckit.implement`

---

**Happy Spec-Driven Development! 🚀**
