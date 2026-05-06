#!/usr/bin/env node
/**
 * WordPress Plugin Boilerplate — Agent Skills Manager
 *
 * Fetches the latest skills from GitHub on every run and installs them
 * via the official skillpack build/install system.
 *
 * Sources
 *   • WPBoilerplate/agent-skills  (WPBoilerplate-specific skills)
 *   • WordPress/agent-skills      (WordPress core skills)
 */

import fs from 'node:fs';
import path from 'node:path';
import os from 'node:os';
import readline from 'node:readline';
import { spawnSync } from 'node:child_process';

const PLUGIN_ROOT = process.cwd();

const SOURCES = [
	{ repo: 'WPBoilerplate/agent-skills', label: 'WPBoilerplate' },
	{ repo: 'WordPress/agent-skills',     label: 'WordPress'     },
];

// ── helpers ──────────────────────────────────────────────────────────────────

const HR = '━'.repeat( 67 );
function banner( text ) { console.log( `\n${ HR }\n${ text }\n${ HR }\n` ); }

function cloneRepo( repo, dest ) {
	console.log( `==> Cloning ${ repo }...` );
	if ( fs.existsSync( dest ) ) fs.rmSync( dest, { recursive: true, force: true } );

	const result = spawnSync(
		'git',
		[ 'clone', '--depth=1', `https://github.com/${ repo }.git`, dest ],
		{ stdio: 'inherit' }
	);

	if ( result.status !== 0 ) {
		console.error( `❌  Failed to clone ${ repo }` );
		process.exit( 1 );
	}
}

function listSkills( repoDir ) {
	const skillsDir = path.join( repoDir, 'skills' );
	if ( ! fs.existsSync( skillsDir ) ) return [];

	return fs.readdirSync( skillsDir, { withFileTypes: true } )
		.filter( d => d.isDirectory() && fs.existsSync( path.join( skillsDir, d.name, 'SKILL.md' ) ) )
		.map( d => d.name );
}

function readDesc( repoDir, skill ) {
	const md = path.join( repoDir, 'skills', skill, 'SKILL.md' );
	for ( const line of fs.readFileSync( md, 'utf8' ).split( '\n' ) ) {
		const t = line.trim();
		if ( t && ! t.startsWith( '#' ) && ! t.startsWith( '<!--' ) ) return t.slice( 0, 80 );
	}
	return '';
}

function ask( question ) {
	return new Promise( resolve => {
		const rl = readline.createInterface( { input: process.stdin, output: process.stdout } );
		rl.question( question, answer => { rl.close(); resolve( answer.trim() ); } );
	} );
}

// ── main ─────────────────────────────────────────────────────────────────────

async function main() {
	banner( '🎓  WordPress Agent Skills Manager' );

	const WORK_DIR = fs.mkdtempSync( path.join( os.tmpdir(), 'wpb-skills-' ) );

	try {
		// 1. Clone every source and collect available skills
		const allSkills = [];
		for ( const src of SOURCES ) {
			const repoDir = path.join( WORK_DIR, src.repo.replace( '/', '__' ) );
			cloneRepo( src.repo, repoDir );

			for ( const skill of listSkills( repoDir ) ) {
				allSkills.push( {
					name: skill,
					label: src.label,
					repoDir,
					desc: readDesc( repoDir, skill ),
				} );
			}
			console.log();
		}

		if ( allSkills.length === 0 ) {
			console.error( '❌  No skills found in any source.' );
			process.exit( 1 );
		}

		// 2. Display menu
		console.log( `Found ${ allSkills.length } skill(s):\n` );
		allSkills.forEach( ( { name, label, desc }, i ) => {
			const num = String( i + 1 ).padStart( 3 );
			console.log( `${ num }. [${ label }] ${ name }` );
			if ( desc ) console.log( `       ${ desc }` );
		} );
		console.log();

		const answer = await ask(
			"Enter numbers separated by spaces, 'all' to install everything, or press Enter to exit.\nYour selection: "
		);

		if ( ! answer ) {
			console.log( '\nNo selection — exiting.' );
			process.exit( 0 );
		}

		// 3. Resolve selection
		let selected;
		if ( answer.toLowerCase() === 'all' ) {
			selected = [ ...allSkills ];
		} else {
			selected = [];
			for ( const token of answer.split( /\s+/ ) ) {
				const idx = parseInt( token, 10 ) - 1;
				if ( idx >= 0 && idx < allSkills.length ) {
					console.log( `✅  Selected: ${ allSkills[ idx ].name }` );
					selected.push( allSkills[ idx ] );
				} else {
					console.warn( `⚠️   Unknown index: ${ token }` );
				}
			}
		}

		if ( selected.length === 0 ) {
			console.log( '\nNo valid skills selected — exiting.' );
			process.exit( 0 );
		}

		banner( '📥  Installing selected skills...' );

		// 4. Group by source repo, then run skillpack build → install
		const byRepo = new Map();
		for ( const s of selected ) {
			if ( ! byRepo.has( s.repoDir ) ) {
				byRepo.set( s.repoDir, { label: s.label, skills: [] } );
			}
			byRepo.get( s.repoDir ).skills.push( s.name );
		}

		for ( const [ repoDir, { label, skills } ] of byRepo ) {
			console.log( `\n🔧  Building from ${ label }: ${ skills.join( ', ' ) }` );

			// Build
			const build = spawnSync( 'node', [
				'shared/scripts/skillpack-build.mjs',
				`--skills=${ skills.join( ',' ) }`,
				'--targets=vscode,codex,claude,cursor',
				'--clean',
			], { cwd: repoDir, stdio: 'inherit' } );

			if ( build.status !== 0 ) {
				console.error( `❌  Skillpack build failed for ${ label }` );
				continue;
			}

			// Install
			const install = spawnSync( 'node', [
				'shared/scripts/skillpack-install.mjs',
				`--dest=${ PLUGIN_ROOT }`,
				'--targets=vscode,codex,claude,cursor',
				`--skills=${ skills.join( ',' ) }`,
			], { cwd: repoDir, stdio: 'inherit' } );

			if ( install.status !== 0 ) {
				console.error( `❌  Skillpack install failed for ${ label }` );
				continue;
			}
		}

		console.log( '\n✅  Skills installed to:' );
		console.log( '   •  .github/skills/  (GitHub Copilot / VS Code)' );
		console.log( '   •  .codex/skills/   (GitHub Copilot coding agent)' );
		console.log( '   •  .claude/skills/  (Claude)' );
		console.log( '   •  .cursor/skills/  (Cursor)\n' );

	} finally {
		fs.rmSync( WORK_DIR, { recursive: true, force: true } );
	}
}

main().catch( err => { console.error( 'Error:', err.message ); process.exit( 1 ); } );
