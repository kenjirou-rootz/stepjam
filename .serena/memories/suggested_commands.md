# Suggested Commands for STEPJAM Development

## System Commands (macOS/Darwin)
- `ls -la` - List files with details
- `cd` - Change directory
- `pwd` - Print working directory
- `grep -r "pattern" .` - Search for pattern in files
- `find . -name "*.php"` - Find PHP files

## WordPress Development
Since this is a Local Sites project, most WordPress operations are handled through the Local app GUI.

### File Operations
- Edit theme files in: `app/public/wp-content/themes/stepjam-theme/`
- Main theme files:
  - `functions.php` - Theme setup and hooks
  - `style.css` - Theme information header
  - `front-page.php` - Homepage template
  - `single-toroku-dancer.php` - Dancer registration template

### PHP Development
- No specific PHP linting command configured
- Follow WordPress coding standards
- Use proper escaping functions: `esc_html()`, `esc_attr()`, `esc_url()`

### CSS/JavaScript
- CSS files located in `assets/css/`
- JavaScript files in `assets/js/`
- Scripts enqueued via `inc/enqueue-scripts.php`

## Backup Operations
- Backup files are stored in `ユーザーarea/バックアップ/`
- Use timestamp format: `filename.backup.YYYYMMDD_HHMMSS`

## Testing
- Playwright tests in `playwright-check/` directory

## Important Notes
- Always work within the theme directory
- Respect the excluded paths in .serena/project.yml
- Do not modify WordPress core files (wp-admin, wp-includes)