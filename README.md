# @wordpress/scripts

### Adding multipal input file

1.  Replace package.json file build-frontend line

    OLD: `"build-frontend": "wp-scripts build --webpack-src-dir=src/frontend/ --output-path=build/frontend/"`,

    New: `"build-frontend": "wp-scripts build src/frontend/index.js src/frontend/index-2.js --output-path=build/frontend/"`,

2.  Create new file inside the src/frontend/index-2.js
3.  Now run `npm run build` command and it will generate new file

# Composer
