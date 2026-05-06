#!/usr/bin/env node
/**
 * Fetches the latest WordPress agent skills and installs them into .github/skills/
 * so that VS Code and GitHub Copilot can discover them automatically.
 *
 * Usage:
 *   node scripts/install-agent-skills.mjs                    # install/update all skills
 *   node scripts/install-agent-skills.mjs skill1 skill2 ...  # install specific skills only
 *
 * To override the destination directory, set the SKILLS_DEST env variable:
 *   SKILLS_DEST=/path/to/plugin node scripts/install-agent-skills.mjs
 */

import fs from 'fs';
import path from 'path';
import { spawnSync } from 'child_process';

const __dirname = path.dirname( new URL( import.meta.url ).pathname );
const REPO_ROOT = path.dirname( __dirname );
const DEST = process.env.SKILLS_DEST ?? REPO_ROOT;
const WORK_DIR = '/tmp/agent-skills';
const SELECTED_SKILLS = process.argv.slice( 2 );

function run( cmd, args, options = {} ) {
	const result = spawnSync( cmd, args, {
		stdio: 'inherit',
		...options,
	} );
	if ( result.error ) {
		throw result.error;
	}
	if ( result.status !== 0 ) {
		process.exit( result.status ?? 1 );
	}
}

// ─── Clean previous clone ─────────────────────────────────────────────────────

console.log( '==> Cleaning up previous agent-skills clone (if any)...' );
fs.rmSync( WORK_DIR, { recursive: true, force: true } );

// ─── Clone the repository ─────────────────────────────────────────────────────

console.log( '==> Cloning latest WordPress agent skills...' );
run( 'git', [
	'clone',
	'--depth=1',
	'https://github.com/WordPress/agent-skills.git',
	WORK_DIR,
] );

// ─── Build skills with skillpack ──────────────────────────────────────────────

console.log( '==> Building skillpack for VS Code / GitHub Copilot...' );
run(
	'node',
	[
		path.join( WORK_DIR, 'shared', 'scripts', 'skillpack-build.mjs' ),
		`--out=${ path.join( WORK_DIR, 'dist' ) }`,
		'--clean',
		'--targets=vscode',
	],
	{ cwd: WORK_DIR }
);

// ─── Install skills ───────────────────────────────────────────────────────────

if ( SELECTED_SKILLS.length === 0 ) {
	console.log( `==> Installing all skills into ${ DEST }/.github/skills/ ...` );
	run(
		'node',
		[
			path.join( WORK_DIR, 'shared', 'scripts', 'skillpack-install.mjs' ),
			`--from=${ path.join( WORK_DIR, 'dist' ) }`,
			`--dest=${ DEST }`,
			'--targets=vscode',
		],
		{ cwd: WORK_DIR }
	);
} else {
	console.log(
		`==> Installing selected skills into ${ DEST }/.github/skills/ ...`
	);
	const TEMP_DEST = path.join( WORK_DIR, 'temp-dest' );

	run(
		'node',
		[
			path.join( WORK_DIR, 'shared', 'scripts', 'skillpack-install.mjs' ),
			`--from=${ path.join( WORK_DIR, 'dist' ) }`,
			`--dest=${ TEMP_DEST }`,
			'--targets=vscode',
		],
		{ cwd: WORK_DIR }
	);

	const finalSkillsDir = path.join( DEST, '.github', 'skills' );
	fs.mkdirSync( finalSkillsDir, { recursive: true } );

	for ( const skill of SELECTED_SKILLS ) {
		const src = path.join( TEMP_DEST, '.github', 'skills', skill );
		if ( fs.existsSync( src ) ) {
			fs.cpSync( src, path.join( finalSkillsDir, skill ), {
				recursive: true,
			} );
			console.log( `  ✅ Installed: ${ skill }` );
		} else {
			console.log( `  ⚠️  Skill not found in build output: ${ skill }` );
		}
	}
}

console.log( `==> Done. Skills are available in ${ DEST }/.github/skills/` );
