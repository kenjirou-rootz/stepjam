# Coding Style and Conventions for STEPJAM

## PHP Coding Standards
- Follow WordPress PHP Coding Standards
- Use meaningful function prefixes: `stepjam_` for theme functions
- Proper indentation with tabs (WordPress standard)
- Opening braces on the same line for functions

## Function Naming
- Use snake_case for function names: `stepjam_theme_setup()`
- Action/filter hooks: `add_action('init', 'stepjam_function_name')`
- Custom post types: Use singular names

## File Organization
```
inc/
├── custom-post-types.php    # Custom post type definitions
├── acf-fields.php          # ACF field configurations
└── enqueue-scripts.php     # Script and style enqueueing
```

## WordPress Best Practices
- Always escape output: `esc_html()`, `esc_attr()`, `esc_url()`
- Use WordPress functions for URLs: `home_url()`, `get_template_directory_uri()`
- Proper text domain usage: `stepjam-theme`
- Use `wp_enqueue_style()` and `wp_enqueue_script()` for assets

## Comments and Documentation
- Use PHPDoc style comments for functions
- Include description, parameters, and return values
- Example:
```php
/**
 * Description of function
 *
 * @param string $param Description
 * @return void
 */
```

## Security Practices
- Sanitize all inputs
- Validate data before processing
- Use nonces for forms
- Check capabilities for admin functions

## Version Control
- Create backups with timestamp: `.backup.YYYYMMDD_HHMMSS`
- Do not commit sensitive data
- Keep development and production configs separate