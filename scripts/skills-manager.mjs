#!/usr/bin/env node
/**
 * WordPress Agent Skills Manager
 *
 * Interactive CLI to fetch, list, and install WordPress Agent Skills.
 * Reads sources from skills.config.json in the repo root.
 *
 * Usage:
 *   npm run skills
 *   node scripts/skills-manager.mjs
 */

import https from 'https';
import fs from 'fs';
import path from 'path';
import readline from 'readline';
import { spawnSync } from 'child_process';
import { createRequire } from 'module';

const require = createRequire( import.meta.url );
const __dirname = path.dirname( new URL( import.meta.url ).pathname );
const REPO_ROOT = path.dirname( __dirname );
const SKILLS_DIR = path.join( REPO_ROOT, '.github', 'skills' );
const CONFIG_FILE = path.join( REPO_ROOT, 'skills.config.json' );

const DIVIDER =
	'━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━';

// ─── HTTP helper ─────────────────────────────────────────────────────────────

function get( url ) {
	return new Promise( ( resolve, reject ) => {
		const req = https.get(
			url,
			{
				headers: {
					'User-Agent': 'wpboilerplate-skills-manager',
					Accept: 'application/vnd.github.v3+json',
				},
			},
			( res ) => {
				if (
					res.statusCode >= 300 &&
					res.statusCode < 400 &&
					res.headers.location
				) {
					resolve( get( res.headers.location ) );
					return;
				}
				let data = '';
				res.on( 'data', ( chunk ) => ( data += chunk ) );
				res.on( 'end', () =>
					resolve( { status: res.statusCode, body: data } )
				);
			}
		);
		req.on( 'error', reject );
		req.setTimeout( 15000, () => {
			req.destroy();
			reject( new Error( 'Request timed out' ) );
		} );
	} );
}

async function getJSON( url ) {
	const { status, body } = await get( url );
	if ( status !== 200 ) {
		throw new Error( `HTTP ${ status } from ${ url }` );
	}
	return JSON.parse( body );
}

// ─── Fetch skills list from a source ─────────────────────────────────────────

async function fetchAvailableSkills( repo, skillsPath ) {
	const url = `https://api.github.com/repos/${ repo }/contents/${ skillsPath }`;
	const items = await getJSON( url );
	if ( ! Array.isArray( items ) ) {
		throw new Error( 'Unexpected API response' );
	}
	return items.filter( ( i ) => i.type === 'dir' ).map( ( i ) => i.name );
}

// ─── Copy installer: download a skill directory recursively ──────────────────

async function fetchTree( repo, dirPath ) {
	const url = `https://api.github.com/repos/${ repo }/contents/${ dirPath }`;
	const items = await getJSON( url );
	const files = [];
	for ( const item of items ) {
		if ( item.type === 'file' ) {
			files.push( { relPath: item.name, downloadUrl: item.download_url } );
		} else if ( item.type === 'dir' ) {
			const sub = await fetchTree( repo, item.path );
			sub.forEach( ( f ) =>
				files.push( {
					relPath: item.name + '/' + f.relPath,
					downloadUrl: f.downloadUrl,
				} )
			);
		}
	}
	return files;
}

async function copyInstallSkill( repo, skillsPath, skillName, destBase ) {
	const files = await fetchTree(
		repo,
		`${ skillsPath }/${ skillName }`
	);
	for ( const file of files ) {
		const destPath = path.join( destBase, skillName, file.relPath );
		fs.mkdirSync( path.dirname( destPath ), { recursive: true } );
		const { body } = await get( file.downloadUrl );
		fs.writeFileSync( destPath, body );
	}
	console.log(
		`  ✅ Installed: ${ skillName } (${ files.length } file${ files.length !== 1 ? 's' : '' })`
	);
}

// ─── Readline prompt helper ───────────────────────────────────────────────────

function prompt( rl, question ) {
	return new Promise( ( resolve ) => rl.question( question, resolve ) );
}

// ─── Main ─────────────────────────────────────────────────────────────────────

async function main() {
	console.log();
	console.log( DIVIDER );
	console.log( '🎓 WordPress Agent Skills Manager' );
	console.log( DIVIDER );
	console.log();

	// Load sources from config
	let sources;
	if ( fs.existsSync( CONFIG_FILE ) ) {
		const config = require( CONFIG_FILE );
		sources = config.sources || [];
	} else {
		console.log(
			'⚠️  skills.config.json not found — using default source.'
		);
		sources = [
			{
				name: 'WordPress Agent Skills',
				repo: 'WordPress/agent-skills',
				skillsPath: 'skills',
				installer: 'skillpack',
			},
		];
	}

	if ( sources.length === 0 ) {
		console.log( '⚠️  No sources defined in skills.config.json' );
		process.exit( 0 );
	}

	fs.mkdirSync( SKILLS_DIR, { recursive: true } );

	// ── Collect skills from all sources ──────────────────────────────────────

	// Each entry: { displayIdx, name, sourceIdx, installer, repo, skillsPath }
	const allSkills = [];

	for ( let srcIdx = 0; srcIdx < sources.length; srcIdx++ ) {
		const src = sources[ srcIdx ];
		const repo = src.repo;
		const skillsPath = src.skillsPath || 'skills';
		const installer = src.installer || 'copy';

		console.log( `📦 Source: ${ src.name } (github: ${ repo })` );
		console.log( '   Fetching available skills...' );

		let available;
		try {
			available = await fetchAvailableSkills( repo, skillsPath );
		} catch ( err ) {
			console.log(
				`   ⚠️  Could not fetch skill list: ${ err.message }`
			);
			console.log();
			continue;
		}

		if ( available.length === 0 ) {
			console.log( '   ⚠️  No skills found in this source.' );
			console.log();
			continue;
		}

		const installed = available.filter( ( s ) =>
			fs.existsSync( path.join( SKILLS_DIR, s ) )
		);
		const notInstalled = available.filter(
			( s ) => ! fs.existsSync( path.join( SKILLS_DIR, s ) )
		);

		console.log();

		if ( installed.length > 0 ) {
			console.log( `   ✅ Installed (${ installed.length }):` );
			installed.forEach( ( s ) => console.log( `      ✅ ${ s }` ) );
		}

		if ( notInstalled.length === 0 ) {
			console.log(
				'   🎉 All skills from this source are already installed!'
			);
			console.log();
			continue;
		}

		console.log( `\n   ❌ Not installed (${ notInstalled.length }):` );
		notInstalled.forEach( ( s, i ) =>
			console.log(
				`      [${ String( allSkills.length + i + 1 ).padStart( 2 ) }] ${ s }`
			)
		);
		console.log();

		notInstalled.forEach( ( name ) => {
			allSkills.push( {
				displayIdx: allSkills.length,
				name,
				sourceIdx: srcIdx,
				sourceName: src.name,
				installer,
				repo,
				skillsPath,
			} );
		} );
	}

	// ── Nothing left to install ───────────────────────────────────────────────

	if ( allSkills.length === 0 ) {
		console.log(
			'🎉 All skills from all sources are already installed!'
		);
		process.exit( 0 );
	}

	// ── Selection prompt ──────────────────────────────────────────────────────

	console.log( DIVIDER );
	console.log( '📋 Skills available to install:' );
	console.log();
	allSkills.forEach( ( sk ) => {
		const num = String( sk.displayIdx + 1 ).padStart( 2 );
		const name = sk.name.padEnd( 42 );
		console.log( `  [${ num }] ${ name }  (${ sk.sourceName })` );
	} );
	console.log();

	const rl = readline.createInterface( {
		input: process.stdin,
		output: process.stdout,
	} );

	console.log(
		"Enter numbers separated by spaces, 'all' to install everything, or press Enter to exit."
	);
	const selection = await prompt( rl, 'Your selection: ' );
	rl.close();

	if ( ! selection.trim() ) {
		console.log( 'No skills selected. Exiting.' );
		process.exit( 0 );
	}

	// ── Resolve selection ─────────────────────────────────────────────────────

	let toInstall = [];

	if ( selection.trim() === 'all' ) {
		toInstall = [ ...allSkills ];
		console.log(
			`✅ Selected all ${ allSkills.length } available skills`
		);
	} else {
		for ( const token of selection.trim().split( /\s+/ ) ) {
			const num = parseInt( token, 10 );
			if (
				! isNaN( num ) &&
				num >= 1 &&
				num <= allSkills.length
			) {
				toInstall.push( allSkills[ num - 1 ] );
				console.log(
					`✅ Selected: ${ allSkills[ num - 1 ].name }`
				);
			} else {
				console.log( `⚠️  Invalid selection: ${ token } (skipped)` );
			}
		}
	}

	if ( toInstall.length === 0 ) {
		console.log( 'No valid skills selected. Exiting.' );
		process.exit( 0 );
	}

	// ── Install ───────────────────────────────────────────────────────────────

	console.log();
	console.log( DIVIDER );
	console.log( '📥 Installing selected skills...' );
	console.log();

	// Group by installer + repo
	const skillpackGroups = new Map(); // repo → skill names[]
	const copySkills = [];

	for ( const sk of toInstall ) {
		if ( sk.installer === 'skillpack' ) {
			if ( ! skillpackGroups.has( sk.repo ) ) {
				skillpackGroups.set( sk.repo, [] );
			}
			skillpackGroups.get( sk.repo ).push( sk.name );
		} else {
			copySkills.push( sk );
		}
	}

	// Skillpack installs (one clone+build per unique repo)
	for ( const [ repo, skillNames ] of skillpackGroups ) {
		console.log(
			`🔧 Using skillpack installer for: ${ skillNames.join( ', ' ) }`
		);
		console.log( `   (from github: ${ repo })` );
		console.log();

		const result = spawnSync(
			'bash',
			[
				path.join( __dirname, 'install-agent-skills.sh' ),
				...skillNames,
			],
			{
				stdio: 'inherit',
				env: { ...process.env, SKILLS_DEST: REPO_ROOT },
			}
		);

		if ( result.status !== 0 ) {
			console.error(
				`❌ skillpack installer failed (exit ${ result.status })`
			);
			process.exit( result.status || 1 );
		}
	}

	// Copy installs
	if ( copySkills.length > 0 ) {
		console.log( '📥 Downloading copy-installer skills...' );
		fs.mkdirSync( SKILLS_DIR, { recursive: true } );

		for ( const sk of copySkills ) {
			console.log(
				`  📥 Downloading: ${ sk.name } (from github: ${ sk.repo })`
			);
			try {
				await copyInstallSkill(
					sk.repo,
					sk.skillsPath,
					sk.name,
					SKILLS_DIR
				);
			} catch ( err ) {
				console.error(
					`  ❌ Failed: ${ sk.name } — ${ err.message }`
				);
			}
		}
	}

	console.log();
	console.log( DIVIDER );
	console.log(
		`🎉 Done! Installed ${ toInstall.length } skill${ toInstall.length !== 1 ? 's' : '' } to .github/skills/`
	);
	console.log();
	console.log(
		"💡 Run 'npm run skills' anytime to add more skills."
	);
	console.log(
		"💡 Run 'npm run skills:install' to install/update ALL skills from all sources."
	);
}

main().catch( ( err ) => {
	console.error( `\n❌ Unexpected error: ${ err.message }` );
	process.exit( 1 );
} );
