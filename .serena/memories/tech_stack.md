# STEPJAM Technology Stack

## Core Technologies
- **CMS**: WordPress 6.8+
- **Language**: PHP 8.0+
- **Database**: MySQL (managed by Local Sites)
- **Web Server**: nginx (Local Sites default)

## WordPress Components
- **Theme Framework**: Custom theme (stepjam-theme)
- **Custom Fields**: Advanced Custom Fields (ACF) Pro
- **Form Plugin**: WPForms

## Frontend Technologies
- **CSS**: Custom stylesheets in `assets/css/`
- **JavaScript**: Vanilla JS or jQuery (WordPress included)
- **Responsive Framework**: Custom responsive design

## Development Environment
- **Local Development**: Local Sites (Flywheel)
- **Version Control**: Git (assumed)
- **Code Intelligence**: Serena MCP for semantic code analysis

## Key WordPress Hooks Used
- `after_setup_theme` - Theme setup
- `init` - Custom post type registration
- `wp_enqueue_scripts` - Asset loading
- `customize_register` - Theme customizer

## File Structure Standards
- Modular PHP includes in `inc/` directory
- Template parts in `template-parts/`
- Assets organized in `assets/` subdirectories
- Backup files with timestamp suffixes