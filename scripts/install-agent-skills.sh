#!/usr/bin/env bash
# Fetches the latest WordPress agent skills and installs them into .github/skills/
# so that VS Code and GitHub Copilot can discover them automatically.
#
# Usage:
#   bash scripts/install-agent-skills.sh                       # install/update all skills
#   bash scripts/install-agent-skills.sh skill1 skill2 ...    # install specific skills only
#
# The first argument is treated as a skill name if it doesn't look like a path.
# To override the destination directory, set SKILLS_DEST env variable:
#   SKILLS_DEST=/path/to/plugin bash scripts/install-agent-skills.sh

set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
DEST="${SKILLS_DEST:-"$(dirname "$SCRIPT_DIR")"}"
WORK_DIR="/tmp/agent-skills"

SELECTED_SKILLS=("$@")

echo "==> Cleaning up previous agent-skills clone (if any)..."
rm -rf "$WORK_DIR"

echo "==> Cloning latest WordPress agent skills..."
git clone --depth=1 https://github.com/WordPress/agent-skills.git "$WORK_DIR"

echo "==> Building skillpack for VS Code / GitHub Copilot..."
node "$WORK_DIR/shared/scripts/skillpack-build.mjs" \
    --out="$WORK_DIR/dist" \
    --clean \
    --targets=vscode

if [ ${#SELECTED_SKILLS[@]} -eq 0 ]; then
    echo "==> Installing all skills into ${DEST}/.github/skills/ ..."
    node "$WORK_DIR/shared/scripts/skillpack-install.mjs" \
        --from="$WORK_DIR/dist" \
        --dest="$DEST" \
        --targets=vscode
else
    echo "==> Installing selected skills into ${DEST}/.github/skills/ ..."
    TEMP_DEST="$WORK_DIR/temp-dest"
    node "$WORK_DIR/shared/scripts/skillpack-install.mjs" \
        --from="$WORK_DIR/dist" \
        --dest="$TEMP_DEST" \
        --targets=vscode

    mkdir -p "$DEST/.github/skills"

    for skill in "${SELECTED_SKILLS[@]}"; do
        # Try to find the skill directory anywhere under temp-dest/.github/skills/
        skill_src="$TEMP_DEST/.github/skills/$skill"
        if [ -d "$skill_src" ]; then
            cp -r "$skill_src" "$DEST/.github/skills/$skill"
            echo "  ✅ Installed: $skill"
        else
            echo "  ⚠️  Skill not found in build output: $skill"
        fi
    done
fi

echo "==> Done. Skills are available in ${DEST}/.github/skills/"
