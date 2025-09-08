# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Communication Language

**ユーザーとの対話は日本語で行ってください。** 
All communication with users should be conducted in Japanese.

## Project Overview

STEPJAM is a WordPress-based website for a dance competition/event platform. The project uses a custom WordPress theme with Advanced Custom Fields (ACF) for content management and custom post types for different content sections.

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
- **Development Environment**: Local by Flywheel (localhost:10004)

## Common Development Commands

### Local Development
```bash
# The project is configured to run in Local by Flywheel
# Access URLs:
# Frontend: http://localhost:10004/
# WordPress admin: http://localhost:10004/wp-admin/
```

### File Locations
```
/app/public/                      # WordPress root
/app/public/wp-content/themes/stepjam-theme/  # Theme directory
/app/public/wp-content/uploads/   # Media uploads
```

### Theme Structure
```
stepjam-theme/
├── assets/
│   ├── css/          # Compiled CSS (future use)
│   ├── js/
│   │   └── main.js   # Main JavaScript application
│   └── lib-osaka.svg # Logo assets
├── inc/
│   ├── acf-fields.php         # ACF field configurations
│   ├── custom-post-types.php  # Custom post type definitions
│   └── enqueue-scripts.php    # Script/style loading
├── template-parts/             # Reusable template components
├── functions.php               # Theme setup and configuration
├── header.php                  # Site header
├── footer.php                  # Site footer
├── front-page.php             # Homepage template
├── single-*.php               # Single post templates
└── archive-*.php              # Archive templates
```

## High-Level Architecture

### Frontend Architecture
- **JavaScript**: Single main application class (`STEPJAMreApp`) in `main.js` handles all interactive functionality
- **Component System**: 
  - Navigation overlay with dropdown menus
  - Tokyo/Osaka tab switching for library sections
  - Swiper-based sliders for sponsors and media
  - YouTube auto-sliding functionality for dancer profiles
- **Responsive Design**: 768px breakpoint (desktop/mobile)
- **State Management**: Class-based state handling, no external state libraries

### WordPress Integration
- **Custom Post Types**: Registered via `inc/custom-post-types.php`
- **ACF Fields**: Complex field groups for flexible content management
- **Template Hierarchy**: Custom templates for each post type
- **Dynamic Content**: ACF fields populate all dynamic content areas

### Key Features
1. **Multi-location Support**: Tokyo/Osaka dancer listings with tab switching
2. **Sponsor System**: Video sliders and logo carousels
3. **News/Info System**: Categorized posts with custom taxonomies
4. **Dancer Profiles**: Detailed profiles with performance videos
5. **Responsive Navigation**: Full-screen overlay navigation for mobile


## WordPress開発時のバックアップルール

### 必須バックアップ要件
WordPressに関する編集・改修・新規構築を行う際は、**必ず作業前にバックアップを作成すること**。

### バックアップ保存先
```
/Users/hayashikenjirou/Local Sites/stepjam/バックアップ/
```

### バックアップ作成ルール

#### 1. ファイル単体の編集時
編集対象ファイルと同じカテゴリのフォルダに保存：
- **フロントページ**: `/バックアップ/font-page/`
- **functions.php**: `/バックアップ/function/`
- **INFO・NEWS関連**: `/バックアップ/info-news/`
- **登録ダンサー関連**: `/バックアップ/登録ダンサー-single/`
- **その他のファイル**: 適切なカテゴリフォルダを作成

命名規則：
```
{元ファイル名}_backup_{YYYYMMDD}_{HHMMSS}.{拡張子}
```

#### 2. 大規模改修・複数ファイル編集時
`/バックアップ/complete-backup/` に完全バックアップを作成：
```
complete-backup-{YYYYMMDD}_{HHMMSS}/
├── BACKUP_INFO.md  # バックアップ情報
├── 全ての編集対象ファイル
└── database-backup-*.sql  # 必要に応じてDB
```

#### 3. バックアップ実行例
```bash
# 単一ファイル
cp front-page.php /Users/hayashikenjirou/Local Sites/stepjam/バックアップ/font-page/front-page_backup_20250831_120000.php

# 複数ファイル
mkdir -p /Users/hayashikenjirou/Local Sites/stepjam/バックアップ/complete-backup/complete-backup-20250831_120000/
cp -r . /Users/hayashikenjirou/Local Sites/stepjam/バックアップ/complete-backup/complete-backup-20250831_120000/
```

### バックアップ時の注意事項
- 作業の規模に応じて適切なバックアップ方法を選択
- 重要な変更時はBACKUP_INFO.mdに変更内容を記録
- データベース変更を伴う場合はSQLダンプも取得
- バックアップ作成後、必ず作成確認を行う

## Development Guidelines

### Code Style
- Follow WordPress Coding Standards for PHP
- Use ES6 JavaScript features (classes, arrow functions)
- BEM-style CSS class naming when not using Tailwind utilities
- Maintain consistent indentation (4 spaces for PHP, 2 spaces for JS)

### JavaScript Registration Policy
新規スクリプト登録時は以下の基準を満たす必要があります：
- **汎用性**: 複数ページ・機能での再利用可能性
- **保守性**: クラスベース・モジュール化された構造
- **競合回避**: 名前空間管理と他ライブラリとの干渉防止

基準を満たさない場合はユーザー承認が必要です。

### Testing Approach
- Use Playwright MCP for frontend testing (see `/playwright-check/` directory)
- Test responsive behavior at key breakpoints (375px, 768px, 1920px)
- Verify ACF field outputs in all templates

### Common Tasks

#### Adding a New Custom Post Type
1. Define in `inc/custom-post-types.php`
2. Create single template: `single-{post-type}.php`
3. Add ACF field groups via WordPress admin
4. Update navigation if needed

#### Modifying JavaScript Behavior
1. All JS logic is in `assets/js/main.js`
2. Main app class: `STEPJAMreApp`
3. Test responsive behavior after changes
4. Verify Swiper slider functionality

#### Working with ACF Fields
1. Field definitions in `inc/acf-fields.php`
2. Use `get_field()` for single values
3. Use `have_rows()` / `get_sub_field()` for repeaters
4. Always check if fields exist before outputting

## Important Considerations

### Performance
- Tailwind CSS is currently loaded via CDN (plan to build locally)
- Images should be optimized before upload
- Use WordPress lazy loading for images

### Backup Strategy
- Always backup before major changes: `_backup_YYYYMMDD_HHMMSS` format
- Database backups stored in `/database-backup-*.sql`
- Theme backups in `/ユーザーarea/バックアップ/`

### Japanese Language Support
- Site is primarily in Japanese
- Use appropriate fonts (Noto Sans JP)
- Maintain UTF-8 encoding throughout

### Migration Notes
- Project was migrated from static HTML to WordPress
- Original HTML files preserved in backups
- ACF data attributes (`data-acf`) preserved from original design

## Debugging

### Common Issues
1. **ACF Fields Not Showing**: Check if ACF Pro is activated and fields are assigned to correct post types
2. **JavaScript Errors**: Check browser console, ensure Swiper.js is loaded before main.js
3. **Responsive Issues**: Verify breakpoint at 768px, check Tailwind classes
4. **Custom Post Types 404**: Flush permalinks in Settings > Permalinks

### Debug Mode
When `WP_DEBUG` is true, the theme logs ACF debugging info in HTML comments on the front page.

## Project-Specific Documentation

Additional documentation available in:
- `/ユーザーarea/wordpress移行ガイド/` - WordPress migration guides
- `/ユーザーarea/レスポンシブガイド/` - Responsive design guidelines
- `/ユーザーarea/logs/` - Development logs and completed work reports

## Contact & Support

For design-related questions, refer to Figma designs and style guides in the documentation folders.

## Technical Issue Resolution History

技術的問題の修正記録と今後の保守情報を記載。Claude Codeが過去の修正を参照し、同様の問題を予防するためのリファレンス情報。

### 2025-08-31: スポンサーロゴスライダー ACF フィールド名不一致修正

#### 問題概要
- **発生場所**: フロントページのスポンサーロゴエリア（swiper-wrapper）
- **根本原因**: テンプレートコードとACF定義間のフィールド名不一致
- **影響範囲**: スポンサーロゴスライダーがデータ取得不可、表示不能

#### 修正対象ファイル
```
/app/public/wp-content/themes/stepjam-theme/template-parts/sponsor-content.php (22行目)
/app/public/wp-content/themes/stepjam-theme/template-parts/sponsor-logo-slider.php (17行目)
```

#### バックアップ先
```
/Users/hayashikenjirou/Local Sites/stepjam/バックアップ/sponsor-field-mapping/
```

#### 修正内容詳細

**主要フィールド名修正**
```php
// 修正前
if (have_rows('sponsor_logos', 'options')) {
    // サブフィールド参照
    $logo_image = get_sub_field('sponsor_logo_image');
    $logo_alt = get_sub_field('sponsor_logo_alt');
    $logo_url = get_sub_field('sponsor_logo_url');
    $logo_target = get_sub_field('sponsor_logo_target'); // 未定義

// 修正後
if (have_rows('sponsors_slides', 'options')) {
    // サブフィールド参照
    $logo_image = get_sub_field('sponsor_logo');
    $logo_alt = get_sub_field('sponsor_name');
    $logo_url = get_sub_field('sponsor_url');
    $logo_target = get_sub_field('sponsor_logo_target') ?: '_blank'; // デフォルト値設定
```

**フィールドマッピング**
| テンプレート参照名 | ACF定義名 | 用途 |
|-------------------|-----------|------|
| `sponsor_logos` | `sponsors_slides` | リピーターフィールド |
| `sponsor_logo_image` | `sponsor_logo` | ロゴ画像 |
| `sponsor_logo_alt` | `sponsor_name` | ALTテキスト |
| `sponsor_logo_url` | `sponsor_url` | リンクURL |
| `sponsor_logo_target` | (デフォルト'_blank') | リンクターゲット |

#### WordPress管理画面での設定場所
```
WordPress管理画面 > スポンサー設定 > ロゴスライド > スポンサースライド（リピーターフィールド）
```

#### 今後の保守ガイドライン
1. **ACF設定変更時の必須確認事項**
   - 対応テンプレートコードとのフィールド名整合性
   - サブフィールド参照の一致性
   - デフォルト値設定の妥当性

2. **類似問題の予防策**
   - 新しいリピーターフィールド追加時は命名規則統一
   - テンプレートコード修正前のACF構造確認
   - フィールド名変更時の影響範囲調査

3. **デバッグ方法**
   ```php
   // ACFフィールド存在確認
   if (function_exists('get_field')) {
       var_dump(get_field('sponsors_slides', 'options'));
   }
   
   // リピーターフィールド内容確認
   if (have_rows('sponsors_slides', 'options')) {
       while (have_rows('sponsors_slides', 'options')) {
           the_row();
           var_dump(get_sub_field('sponsor_logo'));
       }
   }
   ```

4. **関連ファイルとの依存関係**
   - `/inc/acf-fields.php` - フィールド定義
   - `/assets/js/main.js` - Swiperスライダー制御
   - Tailwind CSS クラス - スタイリング

#### 学習ポイント
- ACFリピーターフィールドの命名は一貫性を保つ
- テンプレート修正前に必ずACF構造を確認
- サブフィールド名の変更は影響範囲が広いため慎重に実施
- デフォルト値設定でnullエラーを予防

### 2025-09-01: dancers-section__swiper-wrapper高さフィット問題修正

#### 問題概要
- **発生場所**: 出演ダンサーセクションのswiper-wrapper要素
- **根本原因**: SwiperJS自動レイアウトとCSS高さ設定の競合
- **影響範囲**: ダンサースライダーの高さが親コンテナにフィットしない

#### 修正対象ファイル
```
/app/public/wp-content/themes/stepjam-theme/template-parts/dancers-section.php
/app/public/wp-content/themes/stepjam-theme/assets/js/main.js
```

#### バックアップ先
```
/Users/hayashikenjirou/Local Sites/stepjam/バックアップ/dancers-section-height-fix/
```

#### 修正内容詳細

**B案採用: Swiper機能完全削除による固定高さ運用**
```php
// HTML修正
// 修正前: class="dancers-section__swiper-wrapper swiper-wrapper"
// 修正後: class="dancers-section__swiper-wrapper"

// CSS修正
.dancers-section__swiper-wrapper {
    display: flex;
    align-items: flex-start;
    // B案採用: height: 100% + min-height: 274.5px 組み合わせ
    height: 100%;
    min-height: 274.5px;
    gap: 10px;
}
```

**JavaScript修正**
```javascript
// 削除前: this.initDancersSectionSliders();
// 削除前: initDancersSectionSliders()メソッド全体（171行）
// 修正後: 完全削除
```

#### 技術的詳細
- **解決方式**: SwiperJS依存を削除し、固定高さ(274.5px)でレイアウト
- **高さ設定**: `height: 100%` + `min-height: 274.5px` 組み合わせ
- **安全性確認**: 他セクション（スポンサー、パフォーマンス動画）への影響なし
- **レイアウト維持**: flexboxベースの水平スクロール表示継続

#### 今後の保守ガイドライン
1. **dancers-section専用Swiper機能は完全削除済み**
   - 自動再生、ループ、レスポンシブ設定等すべて無効
   - 固定サイズ(278px × 274.5px)スライド表示のみ継続

2. **高さ調整時の注意点**
   - `min-height: 274.5px`はFigmaデザイン準拠の固定値
   - `height: 100%`で親コンテナへのフィット保証
   - この組み合わせを変更する場合は慎重に検証

3. **関連ファイルとの依存関係**
   - HTML: `swiper-wrapper`クラス削除済み
   - CSS: B案組み合わせ適用済み
   - JS: dancers-section専用Swiper初期化コード完全削除

#### 学習ポイント
- SwiperJSとCSS高さ設定の競合回避にはライブラリ依存削除が効果的
- 固定サイズデザインでは複雑な動的制御より単純な実装を優先
- バックアップとドキュメント化による安全な改修実施の重要性

### 2025-09-01: dancers-section左側見切れ問題（分析記録）

#### 問題概要
- **対象**: dancers-section__day--day1内コンテナの左側見切れ
- **視覚的影響**: DAY1タイトル画像の「D」文字左端切り取り
- **ブランドインパクト**: STEPJAMロゴの視認性低下とプロフェッショナル印象の悪化

#### 根本原因構造分析

**1. Padding不均衡問題 (255行目)**
```css
.dancers-section__title-container {
    padding: clamp(1.25rem, 2.5vw, 1.25rem) clamp(1.25rem, 3.125vw, 3.125rem) clamp(6.25rem, 10vw, 6.25rem) clamp(1.25rem, 2.5vw, 1.25rem);
    /* 分析結果: 上20px 右50px 下100px 左20px の非対称構造 */
}
```

**2. Max-width計算誤差 (266・283行目)**  
```css
.dancers-section__title-vector {
    max-width: calc(50vw - 4rem); /* 4rem=64px想定 vs 実際padding70px の不整合 */
}
```

**3. Overflow制御の強制切り取り (258行目)**
```css
.dancers-section__title-container {
    overflow: hidden; /* 計算誤差による溢れを強制的に隠蔽 */
}
```

#### 技術的影響範囲
- **環境**: デスクトップ表示（1920px確認済み）
- **制約条件**: 50vw制約下での左右非対称padding設計
- **計算問題**: Container内のタイトルベクター制約計算ミス
- **モバイル影響**: 768px以下は100vw使用のため問題なし

#### 修正方向性提案

**A案（推奨）: Padding対称化 + Max-width再計算**
```css
/* 左右padding対称化による根本解決 */
padding: clamp(1.25rem, 2.5vw, 1.25rem) clamp(1.25rem, 3.125vw, 3.125rem) clamp(6.25rem, 10vw, 6.25rem) clamp(1.25rem, 3.125vw, 3.125rem);
max-width: calc(50vw - 6rem); /* padding総合計に基づく正確な計算 */
```

**B案（将来）: Container Query活用根本設計見直し**
```css
/* Container Queryによるレスポンシブ制約管理 */
@container dancers-section (min-width: 768px) {
    .dancers-section__title-vector {
        max-width: calc(100cqw - var(--padding-total));
    }
}
```

#### 関連ファイル依存関係
- **主要ファイル**: `/template-parts/dancers-section.php`
  - 255行目: padding不均衡の起点
  - 266行目・283行目: max-width計算誤差
  - 258行目: overflow hidden強制制御
- **影響範囲**: デスクトップ表示のみ、モバイル(768px以下)への影響なし
- **デザイン制約**: Figma準拠50vw制約維持必須

#### 今後の保守指針
1. **50vw制約設計での左右対称性確保の重要性**
   - Padding値は必ず左右対称に設定
   - Max-width計算時はpadding総計を正確に反映

2. **タイトル画像制約計算の正確性維持**
   - Container padding変更時は必ずmax-width再計算
   - Overflow hiddenに依存しない適切なサイズ設定

3. **視覚的検証の定期実施**
   - 1920px環境でのDAY1「D」文字左端切り取り確認
   - ブランドロゴの視認性・プロフェッショナル印象のテスト

4. **Container Query移行準備**
   - 将来的なCSS Container Query活用による根本設計改善
   - レスポンシブ制約管理の現代的アプローチ導入

#### 学習ポイント
- 50vw制約下でのpadding非対称設計は視覚的問題を引き起こしやすい
- Max-width計算はcontainer paddingとの正確な整合性が必須
- Overflow hiddenによる隠蔽ではなく根本的なサイズ制御を優先
- ブランドロゴの視認性は技術実装よりも優先される品質要件

### 2025-09-05: smooth-fade-animations.js 重複アニメーション実行問題修正

#### 問題概要
- **発生場所**: キャンセルポリシーページ（http://localhost:10004/cancellation-policy/）
- **根本原因**: JavaScript重複初期化による二重フェードインアニメーション実行
- **影響範囲**: data-fade-in要素のアニメーションが2回繰り返される視覚的問題

#### 修正対象ファイル
```
/app/public/wp-content/themes/stepjam-theme/assets/js/smooth-fade-animations.js (44-48行目削除)
```

#### バックアップ先
```
/Users/hayashikenjirou/Local Sites/stepjam/バックアップ/javascript-animations/smooth-fade-animations_backup_20250905_175325.js
```

#### 修正内容詳細

**重複初期化の根本原因**
```javascript
// 修正前: 重複初期化パターン
init() {
    // ... 他の初期化処理
    
    // 問題箇所：条件分岐による追加初期化
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => this.observeElements(), 100);
        });
    }
}

// 自動初期化（241行目）
document.addEventListener('DOMContentLoaded', () => {
    // new SmoothFadeAnimations(config) でインスタンス作成
    window.smoothFadeAnimations = new SmoothFadeAnimations(config);
});

// 修正後: 単一初期化統一
init() {
    // ... 他の初期化処理
    
    // 修正: 重複初期化防止のため条件分岐を削除
    // DOMContentLoaded時の自動初期化(241行目)で十分に対応可能
}
```

**初期化フローの問題構造**
1. **DOMContentLoaded発生**: 自動初期化実行 → `new SmoothFadeAnimations()` インスタンス生成
2. **同時実行**: `init()` → `observeElements()` で全data-fade-in要素監視開始
3. **重複条件分岐**: `document.readyState === 'loading'` で追加DOMContentLoadedリスナー設定
4. **100ms後重複実行**: `setTimeout(() => this.observeElements(), 100)` で同一要素再監視

#### 検証結果

**修正後のPlaywright検証**
- ✅ **キャンセルポリシーページ**: 単一アニメーション実行確認（6個のdata-fade-in要素正常動作）
- ✅ **フロントページ**: data-fade-in要素なし、JavaScriptエラーなし
- ✅ **INFO-NEWSページ**: data-fade-in要素なし、JavaScriptエラーなし
- ✅ **SmoothFadeAnimationsインスタンス**: 全ページで正常作成・動作

**技術的検証項目**
```javascript
// 検証結果
{
    instanceExists: true,           // インスタンス正常作成
    fadeElementsCount: 6,          // キャンセルポリシーページで6要素認識
    animatedElementsCount: 4,      // ビューポート内4要素アニメーション済み
    observerExists: true,          // IntersectionObserver正常動作
    noJSErrors: true              // JavaScriptエラーなし
}
```

#### 今後の保守ガイドライン

1. **JavaScript初期化パターンの統一**
   - DOMContentLoadedイベントでの単一初期化を基本とする
   - 条件分岐による複数初期化パターンを避ける
   - グローバルインスタンス管理の重複防止チェック強化

2. **アニメーションライブラリ設計指針**
   ```javascript
   // 推奨パターン: 単一初期化
   document.addEventListener('DOMContentLoaded', () => {
       if (!window.smoothFadeAnimations) {
           window.smoothFadeAnimations = new SmoothFadeAnimations(config);
       }
   });
   
   // 非推奨パターン: 重複初期化リスク
   if (document.readyState === 'loading') {
       document.addEventListener('DOMContentLoaded', callback);
   }
   ```

3. **同様問題の予防策**
   - 新規JavaScriptライブラリ作成時の初期化パターン統一
   - IntersectionObserver使用時の重複監視防止
   - アニメーション実行回数の検証テスト実装

#### 学習ポイント
- JavaScript初期化の重複は視覚的な品質問題を引き起こす
- DOMContentLoadedイベント使用時は単一リスナーパターンを優先
- IntersectionObserver重複監視は予期しないアニメーション繰り返しの原因
- 段階的検証（対象ページ → 他ページ影響確認）による安全な修正実施の重要性

#### 続報：根本的解決の実施（2025-09-05 18:50）

前回修正（44-48行目削除）では問題が継続したため、より根本的な修正を実施。

**バックアップ先**
```
/Users/hayashikenjirou/Local Sites/stepjam/バックアップ/complete-backup/animation-double-issue-20250905_185000/
```

**最終修正内容**

**1. 二重初期化の厳格な防止（237-242行目）**
```javascript
// 修正前
if (!window.smoothFadeAnimations) {
    window.smoothFadeAnimations = new SmoothFadeAnimations(config);
}

// 修正後
if (window.smoothFadeAnimations && window.smoothFadeAnimations.observer) {
    console.warn('SmoothFadeAnimations: Already initialized, skipping duplicate initialization');
    return;
}
if (!window.smoothFadeAnimations) {
    window.smoothFadeAnimations = new SmoothFadeAnimations(config);
    console.log('SmoothFadeAnimations: Initialized successfully');
}
```

**2. IntersectionObserver重複登録防止（127-132行目）**
```javascript
// 修正前
if (this.animatedElements.has(element)) {
    return;
}

// 修正後  
if (this.animatedElements.has(element) || element.hasAttribute('data-fade-observing')) {
    return;
}
element.setAttribute('data-fade-observing', 'true');
```

**3. アニメーション重複実行防止（150-153行目）**
```javascript
// 修正後：既にアニメーション済みの場合は即座にスキップ
if (element.classList.contains('fade-in-animated')) {
    return;
}
// ... アニメーション実行後
element.removeAttribute('data-fade-observing');
```

#### 修正結果検証（Playwright）

**検証環境**: http://localhost:10004/cancellation-policy/

**成功指標**:
- ✅ コンソール: `SmoothFadeAnimations: Initialized successfully` （1回のみ）
- ✅ 全6要素: `isAnimated: true` & `isObserving: false` （正常終了状態）
- ✅ 視覚的確認: フェードアニメーション1回のみ実行
- ✅ 重複初期化警告なし

#### 今後の保守指針（アニメーション系）

1. **初期化競合状態の予防**
   - グローバルインスタンス存在チェックは `instance.observer` まで確認
   - 初期化ログで実行状況を可視化

2. **Observer重複登録の防止**
   - 要素への `data-fade-observing` マーク付与による状態管理
   - アニメーション完了時の適切なクリーンアップ

3. **デバッグ時の確認ポイント**
   - ブラウザ開発者ツールでの初期化ログ確認
   - data-fade-in要素の `isAnimated` と `isObserving` 状態確認
   - コンソール警告・エラーの有無確認

#### 最終学習ポイント
- JavaScript初期化の競合状態は複数レイヤーでの防御が必要
- DOMContentLoaded時の複雑な処理では厳格な重複防止機構が必須
- IntersectionObserver重複登録は視覚的問題に直結するため要注意
- data属性を活用した状態管理で重複処理を確実に防止

### 2025-09-05: localhost:10004 開発環境移行

#### 移行概要
- **実施日時**: 2025-09-05 23:59:00
- **移行内容**: Local by Flywheelのサイトドメインからlocalhost:10004ポートへの変更
- **目的**: 開発作業でのポート指定アクセス要望対応

#### 移行作業内容

**1. wp-config.php 設定追加**
```php
// localhost:10004 URL設定強制（2025-09-05追加）
define('WP_HOME', 'http://localhost:10004');
define('WP_SITEURL', 'http://localhost:10004');
```

**2. データベースURL設定更新**
```sql
UPDATE wp_options SET option_value = 'http://localhost:10004' WHERE option_name = 'home';
UPDATE wp_options SET option_value = 'http://localhost:10004' WHERE option_name = 'siteurl';
```

**3. パーマリンク再設定**
- WordPress管理画面 > 設定 > パーマリンク で「変更を保存」実行

#### 新しいアクセスURL
- **フロントページ**: `http://localhost:10004/`
- **WordPress管理画面**: `http://localhost:10004/wp-admin/`
- **キャンセルポリシー**: `http://localhost:10004/cancellation-policy/`
- **INFO・NEWS**: `http://localhost:10004/info-news/`
- **FAQ**: `http://localhost:10004/faq/`
- **お問い合わせ**: `http://localhost:10004/contact/`

#### バックアップ・復旧情報
- **バックアップ場所**: `/バックアップ/localhost-conversion-20250905_235900/`
- **復旧手順**: `復旧手順.md` に詳細記載
- **緊急復旧**: Local by Flywheelルーターモード変更で即座復旧可能

#### 移行後検証結果
- ✅ サーバー動作: HTTP 200 OK確認
- ✅ WordPress動作: 正常なHTML生成確認  
- ✅ URL変換: 全内部リンクがlocalhost:10004に自動変換
- ✅ 管理画面: 正常アクセス・ログイン機能確認
- ✅ リソース読み込み: CSS/JavaScriptファイル正常読み込み
- ✅ パーマリンク: URL書き換え機能正常動作

#### 注意事項・トラブルシューティング
- **ブラウザキャッシュ**: 旧URLキャッシュがある場合は強制更新（Ctrl+Shift+R）
- **ブックマーク**: 旧stepjam.localブックマークは更新が必要
- **開発者ツール**: JavaScriptエラーがある場合はF12で確認

#### 今後の開発作業
- **基本URL**: `http://localhost:10004` を使用
- **Playwright検証**: 新URLでテスト実行
- **ACF設定**: WordPress管理画面は `http://localhost:10004/wp-admin/` でアクセス

## 現在の開発状況（2025年9月7日更新）

### 最近の完了作業
- **FAQページ実装**: FAQ表示機能とアコーディオンアニメーション実装完了（9月3日）
- **キャンセルポリシーページ作成**: 新規ページ作成とナビゲーション統合完了（9月5日）
- **スクロールバー問題修正**: ヘッダー固定時のスクロールバー表示問題解決（9月5日）
- **StageWise MCP削除**: 次回インストール時の競合防止のため完全削除（9月7日）

### StageWise関連情報
- **履歴管理**: `/STAGEWISE_HISTORY.md` にて管理
- **バックアップ**: `/バックアップ/stagewise-complete-deletion-20250907_001326/`
- **現在状態**: 削除済み（必要時は履歴管理ファイル参照で復元可能）

### 既知の課題
- **Dancers Section スライダー**: 自動再生機能が動作していない（8月31日品質評価で報告）
  - 詳細: `/ユーザーarea/logs/quality-assessment-20250831.md`
  - スライダー0,2,3で自動再生が停止、手動操作のみ可能

### 開発環境
- **MCP設定**: ファイルシステムMCP設定済み（.mcp.json）
- **アクセスURL**: http://localhost:10004
- **バックアップポリシー**: 作業前に必ずバックアップ作成

