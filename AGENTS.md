# AGENTS.md - Auto-Save System

All AI assistants (Claude Code, GitHub Copilot, Cursor) follow these rules.

## Core Rule
EVERY feature request → Gets saved to files immediately
NOTHING stays in chat only

## File Structure

When you request a feature, Claude/Copilot MUST create:

### 1. Feature Plan
@create /plans/feature-{number}-{name}.md

### 2. Feature Documentation
@create /docs/features/{number}-{name}/README.md
@create /docs/features/{number}-{name}/architecture.md
@create /docs/features/{number}-{name}/subfeatures.md

### 3. Sub-feature Tasks & Docs
For EACH sub-feature:
@create /tasks/task-{number}-{name}.md
@create /docs/features/{number}-{name}/sub-features/{number}-{name}/implementation.md

### 4. Implementation Files
@create /integrations/{FeatureName}.php
@create /tests/Features/{FeatureName}Test.php

### 5. Master Tracking (AUTO-UPDATE)
@create /docs/FEATURES.md (update status)
@create CHANGELOG.md (add entry)

## Rules (NON-NEGOTIABLE)

1. **Every request must become files**
   - NO suggestions that stay in chat
   - EVERY feature gets a /plans/ file
   - EVERY sub-feature gets a /tasks/ file

2. **Documentation is mandatory**
   - Feature has README.md
   - Sub-feature has implementation.md
   - Status tracked in /docs/FEATURES.md

3. **Tests are mandatory**
   - Each sub-feature gets a Test.php file
   - Tests run and report to /logs/

4. **Status is tracked**
   - /docs/FEATURES.md updated after EVERY request
   - /docs/features/xxx/subfeatures.md updated after EVERY sub-feature
   - CHANGELOG.md updated after implementation

5. **Nothing in chat only**
   - If it's not in a file, it wasn't created
   - Every file path must be explicit with @create
   - Every status update must be saved

## Example: Feature Request

### You Request:
"Add WooCommerce Integration with 3 sub-features:
1. Settings Page
2. Product Sync
3. Order Tracking"

### Claude/Copilot MUST Create:
