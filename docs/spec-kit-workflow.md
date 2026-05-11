# Using Spec Kit Workflow

## Basic Workflow

### 1. Create a Feature Specification

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

### 2. Create an Implementation Plan

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

### 3. Generate Implementation Tasks

```
/speckit.tasks

Generate a task breakdown from the plan.
```

Creates:
```
.specify/specs/001-your-feature/
└── tasks.md         # Step-by-step implementation tasks
```

### 4. Implement the Feature

```
/speckit.implement

Implement the tasks from the task list.
```

### 5. Archive the Feature

Once the feature is merged to main:

```
/speckit.archive.run
```

This consolidates the feature specification into project memory.

---

## Workflow Example: Building a Payment Feature

### Step 1: Specification

```
/speckit.specify

Create a specification for integrating WooCommerce payments with our plugin.
Users should be able to process payments through Stripe.
Include failure handling and refund management.
```

**Output**: `.specify/specs/001-woocommerce-payments/spec.md`

### Step 2: Planning

```
/speckit.plan

Create an implementation plan.
Use WooCommerce HPOS for order management.
Integrate Stripe API for payments.
Follow our security standards from AGENTS.md.
```

**Output**: `.specify/specs/001-woocommerce-payments/plan.md`

### Step 3: Task Breakdown

```
/speckit.tasks

Generate task breakdown from the plan.
```

**Output**: `.specify/specs/001-woocommerce-payments/tasks.md`

### Step 4: Implementation

```
/speckit.implement

Implement the payment feature following the task list.
```

Claude Code:
- Uses WooCommerce CRUD objects (from DECISIONS.md)
- Adds nonce verification (from CONSTITUTION.md)
- Avoids the Elementor conflict (from GOTCHAS.md)
- Follows WPCS standards (from AGENTS.md)

### Step 5: Record Learnings

Add to `.specify/memory/GOTCHAS.md`:

```markdown
### Gotcha: Stripe Webhook Signature Verification

**Problem**: Webhooks kept failing silently

**Solution**: Used wp_remote_post() with proper timeout

**Prevention**: Always test webhook flow in staging
```

### Step 6: Archive

```
/speckit.archive.run

Archive the payment feature into project memory.
```
