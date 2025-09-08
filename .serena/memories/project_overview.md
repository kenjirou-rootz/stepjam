# STEPJAM Project Overview

## Project Information
- **Project Name**: stepjam
- **Type**: WordPress Website
- **Environment**: Local Sites (Flywheel)
- **URL**: http://stepjam.local/
- **Language**: PHP
- **WordPress Theme**: stepjam-theme (Custom theme)

## Project Structure
```
stepjam/
├── app/
│   └── public/              # WordPress root directory
│       ├── wp-admin/        # WordPress admin (excluded)
│       ├── wp-includes/     # WordPress core (excluded)
│       └── wp-content/
│           ├── themes/
│           │   └── stepjam-theme/    # Custom theme
│           │       ├── assets/       # CSS, JS, images
│           │       ├── inc/          # PHP includes
│           │       ├── template-parts/
│           │       └── *.php files
│           ├── plugins/
│           └── uploads/     # Media uploads (excluded)
├── ユーザーarea/            # User documentation and materials
└── playwright-check/        # Testing files
```

## Theme Details
- **Theme Name**: STEPJAM Theme
- **Version**: 1.0.0
- **Description**: STEPJAMre公式サイト専用WordPressテーマ。レスポンシブデザイン対応、カスタムフィールド統合。
- **PHP Required**: 8.0+
- **WordPress Required**: 6.0+

## Key Features
- Custom post types (toroku-dancer)
- Advanced Custom Fields (ACF) integration
- Responsive design
- Custom templates for dancer registration