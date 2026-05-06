#!/usr/bin/env bash
# Interactive WordPress Agent Skills Manager.
# Reads skills.config.json for sources, shows installed/not-installed skills,
# and lets you add skills from any configured source.
#
# Usage:
#   npm run skills
#   bash scripts/skills-manager.sh

set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
REPO_ROOT="$(dirname "$SCRIPT_DIR")"
SKILLS_DIR="$REPO_ROOT/.github/skills"
CONFIG_FILE="$REPO_ROOT/skills.config.json"

# ─── Helpers ──────────────────────────────────────────────────────────────────

need_command() {
    if ! command -v "$1" &>/dev/null; then
        echo "❌  Required command not found: $1"
        exit 1
    fi
}

need_command curl
need_command node

# ─── Read skills.config.json ──────────────────────────────────────────────────

if [ ! -f "$CONFIG_FILE" ]; then
    echo "⚠️  skills.config.json not found at $CONFIG_FILE"
    echo "    Using default: WordPress/agent-skills"
    SOURCES_JSON='[{"name":"WordPress Agent Skills","repo":"WordPress/agent-skills","skillsPath":"skills","installer":"skillpack"}]'
else
    SOURCES_JSON=$(node -e "const c=require('$CONFIG_FILE'); process.stdout.write(JSON.stringify(c.sources||[]))")
fi

SOURCE_COUNT=$(node -e "process.stdout.write(String(JSON.parse(process.argv[1]).length))" "$SOURCES_JSON")

if [ "$SOURCE_COUNT" -eq 0 ]; then
    echo "⚠️  No sources defined in skills.config.json"
    exit 0
fi

# ─── Display header ───────────────────────────────────────────────────────────

echo
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🎓 WordPress Agent Skills Manager"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo

mkdir -p "$SKILLS_DIR"

# ─── Fetch available skills per source and build selection menu ───────────────

ALL_SKILLS=()  # Format: "display_index|skill_name|source_index|installer|repo|skillsPath"

_fetch_script=$(mktemp /tmp/wpb_skills_fetch_XXXXXX.js)
cat > "$_fetch_script" << 'FETCH_EOF'
const https = require('https');
const [,, repo, skillsPath] = process.argv;

function get(url) {
    return new Promise((resolve, reject) => {
        const req = https.get(url, {
            headers: { 'User-Agent': 'wpboilerplate-skills-manager', 'Accept': 'application/vnd.github.v3+json' }
        }, (res) => {
            if (res.statusCode >= 300 && res.statusCode < 400 && res.headers.location) {
                resolve(get(res.headers.location));
                return;
            }
            let d = '';
            res.on('data', c => d += c);
            res.on('end', () => {
                try { resolve(JSON.parse(d)); }
                catch(e) { reject(new Error('Invalid JSON: ' + d.slice(0, 200))); }
            });
        });
        req.on('error', reject);
        req.setTimeout(15000, () => { req.destroy(); reject(new Error('timeout')); });
    });
}

async function main() {
    const url = `https://api.github.com/repos/${repo}/contents/${skillsPath}`;
    const items = await get(url);
    if (!Array.isArray(items)) { process.stderr.write('Unexpected response\n'); process.exit(1); }
    const dirs = items.filter(i => i.type === 'dir');
    dirs.forEach(d => console.log(d.name));
}

main().catch(e => { process.stderr.write(e.message + '\n'); process.exit(1); });
FETCH_EOF

_copy_script=$(mktemp /tmp/wpb_skills_copy_XXXXXX.js)
cat > "$_copy_script" << 'COPY_EOF'
const https = require('https');
const fs = require('fs');
const path = require('path');
const [,, repo, skillsPath, skillName, destBase] = process.argv;

function get(url) {
    return new Promise((resolve, reject) => {
        const req = https.get(url, {
            headers: { 'User-Agent': 'wpboilerplate-skills-manager', 'Accept': 'application/vnd.github.v3+json' }
        }, (res) => {
            if (res.statusCode >= 300 && res.statusCode < 400 && res.headers.location) {
                resolve(get(res.headers.location));
                return;
            }
            let d = '';
            res.on('data', c => d += c);
            res.on('end', () => resolve({ status: res.statusCode, body: d }));
        });
        req.on('error', reject);
        req.setTimeout(15000, () => { req.destroy(); reject(new Error('timeout')); });
    });
}

async function getTree(repo, skillsPath, skillName) {
    const listUrl = `https://api.github.com/repos/${repo}/contents/${skillsPath}/${skillName}`;
    const { body } = await get(listUrl);
    const items = JSON.parse(body);
    const files = [];
    for (const item of items) {
        if (item.type === 'file') {
            files.push({ path: item.name, download_url: item.download_url });
        } else if (item.type === 'dir') {
            const sub = await getTree(repo, `${skillsPath}/${skillName}`, item.name);
            sub.forEach(f => files.push({ path: item.name + '/' + f.path, download_url: f.download_url }));
        }
    }
    return files;
}

async function main() {
    const files = await getTree(repo, skillsPath, skillName);
    for (const file of files) {
        const destPath = path.join(destBase, skillName, file.path);
        fs.mkdirSync(path.dirname(destPath), { recursive: true });
        const { body } = await get(file.download_url);
        fs.writeFileSync(destPath, body);
    }
    process.stdout.write('  ✅ Installed: ' + skillName + ' (' + files.length + ' files)\n');
}

main().catch(e => { process.stderr.write('  ❌ Failed: ' + skillName + ' — ' + e.message + '\n'); process.exit(1); });
COPY_EOF

SOURCE_IDX=0
while [ "$SOURCE_IDX" -lt "$SOURCE_COUNT" ]; do
    SOURCE_NAME=$(node -e "const s=JSON.parse(process.argv[1])[$SOURCE_IDX]; process.stdout.write(s.name)" "$SOURCES_JSON")
    SOURCE_REPO=$(node -e "const s=JSON.parse(process.argv[1])[$SOURCE_IDX]; process.stdout.write(s.repo)" "$SOURCES_JSON")
    SOURCE_PATH=$(node -e "const s=JSON.parse(process.argv[1])[$SOURCE_IDX]; process.stdout.write(s.skillsPath||'skills')" "$SOURCES_JSON")
    SOURCE_INSTALLER=$(node -e "const s=JSON.parse(process.argv[1])[$SOURCE_IDX]; process.stdout.write(s.installer||'copy')" "$SOURCES_JSON")

    echo "📦 Source: $SOURCE_NAME (github: $SOURCE_REPO)"
    echo "   Fetching available skills..."

    available_raw=$(node "$_fetch_script" "$SOURCE_REPO" "$SOURCE_PATH" 2>/dev/null || true)

    if [ -z "$available_raw" ]; then
        echo "   ⚠️  Could not fetch skill list (check internet connection or repo access)"
        SOURCE_IDX=$((SOURCE_IDX + 1))
        continue
    fi

    # Read available skills into array
    available=()
    while IFS= read -r line; do
        [ -n "$line" ] && available+=("$line")
    done <<< "$available_raw"

    # Separate into installed / not-installed
    installed=()
    not_installed=()
    for skill in "${available[@]}"; do
        if [ -d "$SKILLS_DIR/$skill" ]; then
            installed+=("$skill")
        else
            not_installed+=("$skill")
        fi
    done

    echo
    if [ ${#installed[@]} -gt 0 ]; then
        echo "   ✅ Installed (${#installed[@]}):"
        for s in "${installed[@]}"; do
            printf "      ✅ %s\n" "$s"
        done
    fi

    if [ ${#not_installed[@]} -eq 0 ]; then
        echo "   🎉 All skills from this source are already installed!"
        SOURCE_IDX=$((SOURCE_IDX + 1))
        continue
    fi

    echo
    echo "   ❌ Not installed (${#not_installed[@]}):"
    for i in "${!not_installed[@]}"; do
        printf "      [%2d] %s\n" "$((i+1))" "${not_installed[$i]}"
    done
    echo

    # Store for selection
    for i in "${!not_installed[@]}"; do
        ALL_SKILLS+=("${#ALL_SKILLS[@]}|${not_installed[$i]}|$SOURCE_IDX|$SOURCE_INSTALLER|$SOURCE_REPO|$SOURCE_PATH")
    done

    SOURCE_IDX=$((SOURCE_IDX + 1))
done

# ─── Selection prompt ─────────────────────────────────────────────────────────

if [ ${#ALL_SKILLS[@]} -eq 0 ]; then
    echo "🎉 All skills from all sources are already installed!"
    rm -f "$_fetch_script" "$_copy_script"
    exit 0
fi

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📋 Skills available to install:"
echo
for entry in "${ALL_SKILLS[@]}"; do
    IFS='|' read -ra INFO <<< "$entry"
    idx="${INFO[0]}"
    skill_name="${INFO[1]}"
    src_idx="${INFO[2]}"
    src_name=$(node -e "const s=JSON.parse(process.argv[1])[$src_idx]; process.stdout.write(s.name)" "$SOURCES_JSON")
    printf "  [%2d] %-42s  (%s)\n" "$((idx+1))" "$skill_name" "$src_name"
done

echo
echo "Enter numbers separated by spaces, 'all' to install everything, or press Enter to exit."
echo -n "Your selection: "
read -r selection

if [ -z "$selection" ]; then
    echo "No skills selected. Exiting."
    rm -f "$_fetch_script" "$_copy_script"
    exit 0
fi

# ─── Determine selected skills ────────────────────────────────────────────────

TO_INSTALL=()
total="${#ALL_SKILLS[@]}"

if [ "$selection" = "all" ]; then
    TO_INSTALL=("${ALL_SKILLS[@]}")
    echo "✅ Selected all $total available skills"
else
    for num in $selection; do
        if [[ "$num" =~ ^[0-9]+$ ]] && [ "$num" -ge 1 ] && [ "$num" -le "$total" ]; then
            TO_INSTALL+=("${ALL_SKILLS[$((num-1))]}")
            IFS='|' read -ra INFO <<< "${ALL_SKILLS[$((num-1))]}"
            echo "✅ Selected: ${INFO[1]}"
        else
            echo "⚠️  Invalid selection: $num (skipped)"
        fi
    done
fi

if [ ${#TO_INSTALL[@]} -eq 0 ]; then
    echo "No valid skills selected. Exiting."
    rm -f "$_fetch_script" "$_copy_script"
    exit 0
fi

# ─── Install selected skills ─────────────────────────────────────────────────

echo
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📥 Installing selected skills..."
echo

# Group by installer type to optimize skillpack installs
SKILLPACK_SKILLS=()
COPY_SKILLS=()

for entry in "${TO_INSTALL[@]}"; do
    IFS='|' read -ra INFO <<< "$entry"
    installer="${INFO[3]}"
    if [ "$installer" = "skillpack" ]; then
        SKILLPACK_SKILLS+=("$entry")
    else
        COPY_SKILLS+=("$entry")
    fi
done

# Install skillpack-based skills (one clone/build per unique repo)
if [ ${#SKILLPACK_SKILLS[@]} -gt 0 ]; then
    # Group by repo
    declare -A SKILLPACK_BY_REPO
    for entry in "${SKILLPACK_SKILLS[@]}"; do
        IFS='|' read -ra INFO <<< "$entry"
        skill_name="${INFO[1]}"
        repo="${INFO[4]}"
        SKILLPACK_BY_REPO["$repo"]+="$skill_name "
    done

    for repo in "${!SKILLPACK_BY_REPO[@]}"; do
        skills_str="${SKILLPACK_BY_REPO[$repo]}"
        skills_arr=($skills_str)
        echo "🔧 Using skillpack installer for: ${skills_arr[*]}"
        echo "   (from github: $repo)"
        echo
        SKILLS_DEST="$REPO_ROOT" bash "$SCRIPT_DIR/install-agent-skills.sh" "${skills_arr[@]}"
    done
fi

# Install copy-based skills
if [ ${#COPY_SKILLS[@]} -gt 0 ]; then
    echo "📥 Downloading copy-installer skills..."
    mkdir -p "$SKILLS_DIR"
    for entry in "${COPY_SKILLS[@]}"; do
        IFS='|' read -ra INFO <<< "$entry"
        skill_name="${INFO[1]}"
        repo="${INFO[4]}"
        skills_path="${INFO[5]}"
        echo "  📥 Downloading: $skill_name (from github: $repo)"
        node "$_copy_script" "$repo" "$skills_path" "$skill_name" "$SKILLS_DIR"
    done
fi

rm -f "$_fetch_script" "$_copy_script"

echo
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🎉 Done! Installed ${#TO_INSTALL[@]} skill(s) to .github/skills/"
echo
echo "💡 Run 'npm run skills' anytime to add more skills."
echo "💡 Run 'npm run skills:install' to install/update ALL skills from all sources."
