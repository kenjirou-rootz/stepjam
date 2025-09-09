# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Communication Language

**ユーザーとの対話は日本語で行ってください。** 
All communication with users should be conducted in Japanese.

## Project Overview

STEPJAM is a WordPress-based dance competition/event platform showcasing performances, schedules, and event details. The project uses a custom WordPress theme with Advanced Custom Fields (ACF) for content management.

## Technology Stack

- **CMS**: WordPress 6.8
- **Theme**: stepjam-theme (custom theme)
- **PHP**: 8.0+
- **JavaScript**: Vanilla JS (ES6 classes) + Swiper.js for sliders
- **CSS**: Tailwind CSS (CDN) + custom styles
- **Custom Post Types**: 
  - `toroku-dancer` - Registered dancers
  - `info-news` - Information and news posts
  - `nx-tokyo` - NX TOKYO events
- **Plugins**: 
  - Advanced Custom Fields Pro (ACF)
  - Custom Post Type UI
  - WPForms
- **Development Environment**: Local by Flywheel
- **Version Control**: Git with GitHub repository
- **Testing**: Playwright for E2E testing

## Common Development Commands

### Local Development
```bash
# Access URLs:
# Frontend: http://localhost:10004/
# WordPress admin: http://localhost:10004/wp-admin/

# The project runs in Local by Flywheel - start via GUI
```

### Testing Commands
```bash
# Install dependencies
npm install

# Run Playwright tests
npx playwright test

# Run specific test file
npx playwright test [test-file.js]

# Debug tests with UI
npx playwright test --ui

# Generate test report
npx playwright show-report
```

### Deployment Commands
```bash
# Deploy to production server
./deploy/deploy-production.sh

# Rollback deployment if needed
./deploy/rollback.sh

# Sync media files only
./deploy/sync-media.sh

# Setup GitHub SSH (one-time)
./deploy/setup-github-ssh.sh
```

### Git Workflow
```bash
# Always check status first
git status
git branch

# Create feature branch for all work
git checkout -b feature/[feature-name]

# Commit and push changes
git add .
git commit -m "Descriptive message"
git push origin feature/[feature-name]
```

## High-Level Architecture

### Project Structure
```
stepjam/
├── .gitignore                 # Git exclusions
├── README.md                  # Project overview
├── deploy/                    # Deployment scripts
├── app/public/               # WordPress root
│   └── wp-content/
│       └── themes/
│           └── stepjam-theme/ # Custom theme (Git managed)
├── バックアップ/              # Backup directory
└── ssh/                       # SSH configurations
```

### Theme Structure
```
stepjam-theme/
├── assets/
│   ├── js/
│   │   ├── main.js                    # Main JS application (STEPJAMreApp class)
│   │   └── smooth-fade-animations.js  # Fade animation library
│   └── [svg files]                    # Logo and vector assets
├── inc/
│   ├── acf-fields.php         # ACF field definitions
│   ├── custom-post-types.php  # CPT registrations
│   └── enqueue-scripts.php    # Script/style loading
├── template-parts/            # Reusable components
│   ├── dancers-section.php    # Dancers display
│   ├── sponsor-content.php    # Sponsor video slider
│   └── sponsor-logo-slider.php # Sponsor logo carousel
├── acf-json/                  # ACF JSON sync directory
├── functions.php              # Theme setup
├── front-page.php            # Homepage template
├── single-*.php              # Single post templates
├── archive-*.php             # Archive templates
└── page-*.php                # Page templates
```

### Frontend Architecture
- **JavaScript**: Single main application class (`STEPJAMreApp`) handles all interactive functionality
- **State Management**: Class-based state handling, no external state libraries
- **Responsive Design**: 768px breakpoint (desktop/mobile)
- **Component System**: 
  - Navigation overlay with dropdown menus
  - Tokyo/Osaka tab switching for library sections
  - Swiper-based sliders for sponsors and media
  - YouTube auto-sliding for dancer profiles

### WordPress Integration
- **Custom Post Types**: Registered via `inc/custom-post-types.php`
- **ACF Fields**: Complex field groups for flexible content management
- **Template Hierarchy**: Custom templates for each post type
- **Dynamic Content**: ACF fields populate all dynamic content areas

## WordPress Development Backup Rules

### 必須バックアップ要件
**WordPress関連の編集を行う際は、必ず作業前にバックアップを作成すること。**

### バックアップ保存先
```
/Users/hayashikenjirou/Local Sites/stepjam/バックアップ/
```

### バックアップ作成ルール

#### 単一ファイル編集時
```bash
# カテゴリフォルダに保存
cp [file] /Users/hayashikenjirou/Local Sites/stepjam/バックアップ/[category]/[filename]_backup_[YYYYMMDD]_[HHMMSS].[ext]
```

カテゴリ例:
- `font-page/` - フロントページ関連
- `function/` - functions.php関連
- `info-news/` - INFO・NEWS関連
- `登録ダンサー-single/` - ダンサー関連

#### 大規模改修時
```bash
# 完全バックアップを作成
mkdir -p /Users/hayashikenjirou/Local Sites/stepjam/バックアップ/complete-backup/complete-backup-[YYYYMMDD]_[HHMMSS]/
cp -r . /Users/hayashikenjirou/Local Sites/stepjam/バックアップ/complete-backup/complete-backup-[YYYYMMDD]_[HHMMSS]/
```

## Development Guidelines

### Code Style
- WordPress Coding Standards for PHP
- ES6 JavaScript features (classes, arrow functions)
- BEM-style CSS class naming when not using Tailwind
- Consistent indentation: 4 spaces (PHP), 2 spaces (JS)

### JavaScript Development Pattern
```javascript
// DOM操作後の処理は適切な遅延を設ける
this.closeNavigation();
setTimeout(() => {
    window.scrollTo(/* ... */);
}, 100);

// 要素存在確認必須
const element = document.getElementById('target');
if (element) {
    element.style.display = 'block';
}

// レスポンシブ判定
const isDesktop = window.innerWidth >= 768;
```

### ACF Field Pattern
```php
// フィールド存在確認
<?php if ($field = get_field('field_name')) : ?>
    <?php echo esc_html($field); ?>
<?php endif; ?>

// リピーターフィールド
<?php if (have_rows('repeater_field')) : ?>
    <?php while (have_rows('repeater_field')) : the_row(); ?>
        <?php $sub = get_sub_field('sub_field'); ?>
    <?php endwhile; ?>
<?php endif; ?>
```

### JavaScript Registration Policy
新規スクリプト登録時は以下の基準を満たす必要があります：
- **汎用性**: 複数ページ・機能での再利用可能性
- **保守性**: クラスベース・モジュール化された構造
- **競合回避**: 名前空間管理と他ライブラリとの干渉防止

基準を満たさない場合はユーザー承認が必要です。

## Common Tasks

### Adding a New Custom Post Type
1. Define in `inc/custom-post-types.php`
2. Create single template: `single-{post-type}.php`
3. Add ACF field groups via WordPress admin
4. Update navigation if needed

### Modifying JavaScript Behavior
1. All JS logic is in `assets/js/main.js`
2. Main app class: `STEPJAMreApp`
3. Test responsive behavior after changes
4. Verify Swiper slider functionality

### Working with ACF Fields
1. Field definitions in `inc/acf-fields.php`
2. Use `get_field()` for single values
3. Use `have_rows()` / `get_sub_field()` for repeaters
4. Always check if fields exist before outputting

### ACF Local JSON Sync
- ACF設定はJSON形式でテーマ内 `acf-json/` ディレクトリに自動保存
- Git管理により開発環境間で同期
- 管理画面で「同期可能」と表示された場合は同期を実行

## Testing Approach
- Use Playwright for frontend testing
- Test responsive behavior at key breakpoints: 375px, 768px, 1920px
- Verify ACF field outputs in all templates
- Check JavaScript functionality across browsers

## Important Considerations

### Performance
- Tailwind CSS loaded via CDN (future: local build planned)
- Optimize images before upload
- Use WordPress lazy loading for images

### Security
- SSH keys and sensitive files are gitignored
- `wp-config.php` excluded from version control
- Always escape output: `esc_html()`, `esc_attr()`
- Validate and sanitize all user inputs

### Japanese Language Support
- Site primarily in Japanese
- UTF-8 encoding throughout
- Appropriate fonts (Noto Sans JP)

### Debugging
- When `WP_DEBUG` is true, theme logs ACF debugging info in HTML comments
- Check browser console for JavaScript errors
- Use `error_log()` for PHP debugging
- Flush permalinks for 404 errors: Settings > Permalinks > Save

## Project-Specific Documentation

### 開発ガイド体系
**メインガイド**: `/wp-git_guide/STEPJAM統合開発ガイド.md` - **完全統合版開発ガイド（最新）**
- 開発環境セットアップ・日常ワークフロー・Git運用・ACF管理・デプロイ・エラー対処の全体系

**関連ドキュメント**:
- `/docs/secure-workflow-guide.md` - セキュリティワークフロー詳細仕様
- `/wp-git_guide/archive-old-guides/` - 旧ガイドファイル（参考・履歴用）

**プロジェクト固有情報**:
- `/user-resources/wordpress移行ガイド/` - WordPress migration guides  
- `/user-resources/レスポンシブガイド/` - Responsive design guidelines
- `/user-resources/logs/` - Development logs and completed work reports

## Technical Issue Resolution History

技術的問題の修正記録。過去の修正を参照し、同様の問題を予防するためのリファレンス。

### Key Resolved Issues
1. **スポンサーロゴスライダー ACF フィールド名不一致** (2025-08-31)
   - テンプレートとACF定義間のフィールド名不一致を修正
   - 詳細: `/バックアップ/sponsor-field-mapping/`

2. **smooth-fade-animations.js 重複アニメーション** (2025-09-05)
   - JavaScript重複初期化による二重フェードイン問題を解決
   - IntersectionObserver重複登録防止機構を実装

3. **localhost:10004 開発環境移行** (2025-09-05)
   - Local by Flywheelからポート指定アクセスへ変更
   - wp-config.phpでURL設定を強制

### Current Development Status

#### 最近の完了作業
- FAQページ実装完了（アコーディオン機能含む）
- キャンセルポリシーページ作成
- スクロールバー問題修正（ヘッダー固定時）
- ACF Local JSON同期システム実装

#### 既知の課題
- Dancers Section スライダー自動再生機能が動作していない
  - 詳細: `/user-resources/logs/quality-assessment-20250831.md`

#### 環境情報
- **開発URL**: http://localhost:10004
- **本番URL**: https://rootzexport.info
- **GitHub**: https://github.com/kenjirou-rootz/stepjam
- **サーバー**: Xserver (sv3020)