#!/usr/bin/env bash
# Fetches the latest WordPress agent skills and installs them into .github/skills/
# so that VS Code and GitHub Copilot can discover them automatically.
#
# Usage:
#   bash scripts/install-agent-skills.sh [dest]
#
# dest  Path to the repository root (defaults to the directory containing this
#       script's parent, i.e. the repo root when run from any location).

set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
DEST="${1:-"$(dirname "$SCRIPT_DIR")"}"
WORK_DIR="/tmp/agent-skills"

echo "==> Cleaning up previous agent-skills clone (if any)..."
rm -rf "$WORK_DIR"

echo "==> Cloning latest WordPress agent skills..."
git clone --depth=1 https://github.com/WordPress/agent-skills.git "$WORK_DIR"

echo "==> Building skillpack for VS Code / GitHub Copilot..."
node "$WORK_DIR/shared/scripts/skillpack-build.mjs" \
    --out="$WORK_DIR/dist" \
    --clean \
    --targets=vscode

echo "==> Installing skills into ${DEST}/.github/skills/ ..."
node "$WORK_DIR/shared/scripts/skillpack-install.mjs" \
    --from="$WORK_DIR/dist" \
    --dest="$DEST" \
    --targets=vscode

echo "==> Done. Skills are available in ${DEST}/.github/skills/"
