# STEPJAMナビゲーション問題・解決パターン集

## 概要
WordPressテーマstepjam-themeにおけるナビゲーション関連問題の分析・解決パターンとメンテナンス指針

## 解決済み問題一覧

### 1. SPONSORボタンID不一致問題（2025-09-02解決）

#### 問題症状
- front-page.phpでSPONSORボタンをクリックしてもスクロールしない
- JavaScript scrollToSection()が要素を検出できない

#### 根本原因
```
ID参照不一致：
- front-page.php: id="sponsor-section" (単数形)
- nav-overlay.php: data-scroll-target="sponsors-section" (複数形)
```

#### 解決方法
```html
<!-- nav-overlay.php 105行目 修正 -->
<!-- 修正前 -->
data-scroll-target="sponsors-section"

<!-- 修正後 -->
data-scroll-target="sponsor-section"
```

#### 予防策
- ID設定時は必ず単数形・複数形の一貫性を保つ
- data-scroll-target新規追加時は対象section IDとの完全一致確認
- 命名規則：`{機能名}-section` (単数形統一)

### 2. クロスページナビゲーション問題（2025-09-02解決）

#### 問題症状
- front-page.php以外のページ（archive-info-news.php等）から
- ナビゲーションメニューのSPONSORS/ABOUT/LIBRARYボタンクリック
- 何も起こらない（遷移しない、ナビゲーションも閉じない）

#### 根本原因
```javascript
// scrollToSection()の限界
const targetElement = document.getElementById(targetId);
if (targetElement) {
    // 要素が存在する場合のみ動作
} 
// else節なし = 要素が見つからない場合は何もしない
```

#### 解決方法

**A. main.js scrollToSection()拡張（146-181行目）**
```javascript
scrollToSection(targetId) {
    const targetElement = document.getElementById(targetId);
    
    if (targetElement) {
        // 同一ページナビゲーション（既存処理）
        this.closeNavigation();
        setTimeout(() => { /* スクロール処理 */ }, 100);
    } else {
        // 【新規追加】クロスページナビゲーション
        this.closeNavigation();
        
        // ページ判定
        const currentPath = window.location.pathname;
        const isHomePage = currentPath === '/' || currentPath === '/index.php' || currentPath === '';
        
        if (!isHomePage) {
            // front-page.phpにハッシュ付きで遷移
            const homeUrl = window.location.origin + '/#' + targetId;
            window.location.href = homeUrl;
        }
    }
}
```

**B. front-page.php URLハッシュ処理追加（885-913行目）**
```javascript
document.addEventListener('DOMContentLoaded', function() {
    // URLハッシュ検出とスクロール処理
    if (window.location.hash) {
        const targetId = window.location.hash.substring(1);
        const targetElement = document.getElementById(targetId);
        
        if (targetElement) {
            setTimeout(() => {
                const headerHeight = 97.36;
                const elementPosition = targetElement.offsetTop;
                const offsetPosition = elementPosition - headerHeight;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
                
                // URLクリーンアップ
                if (history.replaceState) {
                    history.replaceState(null, null, window.location.pathname);
                }
            }, 500); // 500ms遅延でコンテンツ完全読み込み待機
        }
    }
});
```

#### 動作フロー
```
1. 他ページでボタンクリック
   ↓
2. scrollToSection(targetId)実行
   ↓
3. targetElement = null（要素なし）
   ↓
4. else節実行：closeNavigation() + URL遷移
   ↓
5. front-page.php読み込み（/#targetId付き）
   ↓
6. DOMContentLoaded発火
   ↓
7. URLハッシュ検出 + 500ms後スクロール実行
   ↓
8. history.replaceState()でURLクリーンアップ
```

## セクションID対応表
| ボタン名 | data-scroll-target | 対象section ID | 用途 |
|----------|-------------------|----------------|------|
| HOME | hero-section | hero-section | ヒーローセクション |
| SPONSORS | sponsor-section | sponsor-section | スポンサーエリア |
| ABOUT | whsj-section | whsj-section | WHSJについて |
| LIBRARY | lib-top-section | lib-top-section | ライブラリトップ |

## 技術実装パターン

### ナビゲーション競合回避パターン
```javascript
// 問題：closeNavigation()とscrollTo()の同時実行による競合
// 解決：setTimeout()による非同期化
this.closeNavigation();
setTimeout(() => {
    // overflow復元完了後にスクロール実行
    window.scrollTo({ /* ... */ });
}, 100);
```

### WordPressページ判定パターン
```javascript
// front-page.php（ホームページ）判定
const currentPath = window.location.pathname;
const isHomePage = currentPath === '/' || currentPath === '/index.php' || currentPath === '';
```

### URLハッシュ処理パターン
```javascript
// URLハッシュからtargetId抽出
const targetId = window.location.hash.substring(1); // #を除去

// URLクリーンアップ
if (history.replaceState) {
    history.replaceState(null, null, window.location.pathname);
}
```

## マイクロコンポーネント設計原則

### 責務分離
- **nav-overlay.php**: HTML構造とCSS（スタイル）のみ
- **main.js**: すべてのJavaScript動作制御を一本化
- **STEPJAMreApp**: 統合されたナビゲーション機能管理クラス

### ファイル間連携
- **テンプレート**: データ属性（data-scroll-target）で要素指定
- **JavaScript**: データ属性読み取りで汎用的な処理実行
- **分離メリット**: HTMLとJavaScriptの独立性、保守性向上

## デバッグ・検証手順

### ID参照問題の調査
```javascript
// ブラウザコンソールで要素存在確認
console.log('Target element:', document.getElementById('sponsor-section'));

// data-scroll-target属性確認
document.querySelectorAll('[data-scroll-target]').forEach(el => {
    console.log('Target:', el.getAttribute('data-scroll-target'));
});
```

### クロスページナビゲーション動作確認
1. archive-info-news.phpに移動
2. ナビゲーション開く
3. SPONSORS/ABOUT/LIBRARYボタンクリック
4. front-page.phpに遷移 + 該当セクションスクロール確認

### Playwright MCP検証パターン
```javascript
// ナビゲーション開 → ボタンクリック → 遷移確認
await page.click('[data-nav-toggle]');
await page.click('[data-scroll-target="sponsor-section"]');
await page.waitForURL('**/');
```

## 今後の保守指針

### 新規セクション追加時
1. front-page.phpで`<section id="new-section">`設定
2. nav-overlay.phpで`data-scroll-target="new-section"`設定
3. 自動的にクロスページナビゲーション対応完了

### ID命名規則
- **統一形式**: `{機能名}-section`（例：sponsor-section, whsj-section）
- **避けるべき**: 単数形・複数形の混在
- **推奨**: 機能を表現する明確な名称

### JavaScript機能拡張時
- STEPJAMreAppクラス内での一元管理
- bindNavigationEvents()メソッド内でイベントリスナー追加
- closeNavigation()での状態リセット処理追加

## バックアップとリストア

### 作成済みバックアップ
```
/バックアップ/sponsor-id-fix/
├── nav-overlay_backup_20250902_223000.php
└── BACKUP_INFO.md

/バックアップ/cross-page-navigation-fix/
├── main_backup_20250902_223000.js
├── front-page_backup_20250902_223000.php
└── BACKUP_INFO.md
```

### リストア手順
```bash
# SPONSORボタン修正を元に戻す場合
cp /バックアップ/sponsor-id-fix/nav-overlay_backup_*.php ../template-parts/nav-overlay.php

# クロスページナビゲーション修正を元に戻す場合
cp /バックアップ/cross-page-navigation-fix/main_backup_*.js ../assets/js/main.js
cp /バックアップ/cross-page-navigation-fix/front-page_backup_*.php ../front-page.php
```

## ACF・他機能への影響なし確認済み
- スポンサー関連ACFフィールド：正常動作
- 既存Swiperスライダー機能：影響なし
- レスポンシブ挙動：デスクトップ・モバイル両対応
- 他ページテンプレート：影響なし