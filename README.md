# Starter Plugin

This plugin includes an embedded copy of ACF and provides a settings page with local ACF field registration.

## SCSS Workflow

The plugin includes a frontend build setup that compiles SCSS to CSS and reloads the browser automatically.

### Install dependencies

From the plugin root directory:

```bash
npm install
```

### Build once

```bash
npm run build:sass
```

### Watch for changes + live reload

```bash
npm run watch
```

If your local site uses a different development URL than `http://localhost:8888`, run:

```bash
BROWSER_SYNC_PROXY="http://your-local-site.test" npm run watch
```

## Files

- `assets/scss/starter-plugin.scss` — source SCSS file
- `assets/css/starter-plugin.css` — compiled CSS loaded by the plugin
- `package.json` — build scripts and dependencies
- `.vscode/tasks.json` — VS Code tasks for build and watch commands

## Plugin settings page

The plugin adds a settings page under **Settings > Starter Plugin** using ACF options page support, with fields registered via `acf_add_local_field_group()`.
