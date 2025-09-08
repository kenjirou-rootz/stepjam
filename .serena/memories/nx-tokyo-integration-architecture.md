# NX Tokyo ページ統合アーキテクチャ

## セクション間連携構造

### テンプレート階層
```
single-nx-tokyo.php (メインコンテナ)
├── WordPress標準ループ（while have_posts）
├── ACF データ取得・処理層
├── レイアウト構造（nx-tokyo-wrapper）
│   ├── nx-area1（ビジュアルエリア）
│   └── nx-area2（コンテンツエリア）
└── template-parts/dancers-section.php（動的インクルード）
    └── 独立したACF制御とレイアウト
```

### データフロー
```
WordPress投稿データ → ACFフィールド群 → テンプレート処理
│
├── single-nx-tokyo.php
│   ├── イベント基本情報
│   ├── コンテンツブロック  
│   ├── リンク・メディア設定
│   └── ビジュアル制御
│
└── dancers-section.php
    ├── セクション表示制御
    ├── DAY1/DAY2データ
    └── スライダー設定
```

## 統一デザインシステム

### CSS変数体系
```css
/* single-nx-tokyo.php定義（ルートレベル） */
:root {
  --nx-red: #FF0000;
  --nx-blue: #0000FF;  
  --nx-green: #00FF6A;
  --nx-black: #000000;
  --nx-white: #FFFFFF;
  --font-family: 'Noto Sans JP', sans-serif;
}

/* dancers-section.phpでの活用 */
.dancers-section__day--day1 { background-color: transparent; }
.dancers-section__day--day2 { background-color: var(--nx-blue); }
.dancers-section__slide-bg { background-color: var(--nx-red); }
```

### レスポンシブ統一戦略
```css
/* 共通ブレイクポイント：768px */
/* single-nx-tokyo.php */
@container nx-container (min-width: 768px) {
  .nx-tokyo-wrapper {
    grid-template-columns: minmax(300px, var(--area1-max-width)) 1fr;
  }
}

/* dancers-section.php */
@container (max-width: 767px) {
  .dancers-section__container {
    flex-direction: column;
  }
}
```

### タイポグラフィ統一
```css
/* clamp()による流体設計 */
--title-size: clamp(2rem, 4vw + 1rem, 2.8125rem);
--content-title-size: clamp(0.875rem, 1.5vw + 0.5rem, 1rem);  
--content-text-size: clamp(0.75rem, 1vw + 0.5rem, 0.875rem);
```

## JavaScript統合（main.js連携）

### アプリケーションクラス構造
```javascript
STEPJAMreApp {
  // single-nx-tokyo.php制御
  ├── nx-tokyo固有機能
  │   ├── 背景メディア制御
  │   ├── リンクボタン制御
  │   └── レスポンシブ制御
  │
  // dancers-section.php制御  
  └── Swiper統合
      ├── .dancers-section__swiper（セレクタ）
      ├── スライダー初期化
      └── レスポンシブ対応
}
```

### セレクタ統合管理
```javascript
// 統一命名規則
'.nx-tokyo-container'     // メインコンテナ
'.nx-area1', '.nx-area2'  // レイアウトエリア
'.dancers-section'        // サブセクション
'.dancers-section__swiper' // Swiper統合ポイント
```

## レスポンシブ実装の協調動作

### デバイス別レイアウト戦略
```
モバイル（〜767px）:
├── single-nx-tokyo: 縦積みレイアウト
├── dancers-section: 100%幅、縦積み
└── 共通：タッチ最適化、大きめタップエリア

デスクトップ（768px〜）:
├── single-nx-tokyo: 2カラムグリッド
├── dancers-section: 50vw分割または100%
└── 共通：ホバーエフェクト、精密操作
```

### Container Query活用利点
```css
/* 親コンテナサイズベースの制御 */
.nx-tokyo-container { container-type: inline-size; }
.dancers-section { container-type: inline-size; }

/* グローバルビューポートに依存しない柔軟性 */
@container nx-container (min-width: 768px) { /* 局所制御 */ }
@container (max-width: 767px) { /* 局所制御 */ }
```

## パフォーマンス統合戦略

### CLS（Cumulative Layout Shift）対策
```css
/* 両セクション共通のCLS対策 */
aspect-ratio: inherit; /* アスペクト比保持 */
min-height: 1px;       /* レイアウト安定化 */
width: 100%; height: auto; /* 画像最適化 */
```

### アニメーション制御統一
```css
/* アクセシビリティ配慮の統一実装 */
@media (prefers-reduced-motion: reduce) {
  .nx-*, .dancers-section__* {
    transition: none;
    transform: none;
    animation: none;
  }
}
```

### 画像最適化統合
```html
<!-- 両セクションでの統一実装 -->
<img loading="lazy" width="X" height="Y" alt="...">
```

## 保守・拡張における注意点

### ACF設定変更時の影響範囲
1. **single-nx-tokyo.php影響**：メインコンテンツ、ビジュアル制御
2. **dancers-section.php影響**：ダンサーデータ、表示制御
3. **クロスセクション影響**：CSS変数、JavaScript制御

### 新機能追加時のガイドライン
1. **CSS変数の拡張**：:root レベルで定義
2. **レスポンシブ対応**：Container Query活用
3. **JavaScript統合**：STEPJAMreApp クラス拡張
4. **ACF構造**：階層的命名規則維持（nx_プレフィックス）

### セクション独立性の維持
- dancers-section.phpは自己完結型設計
- 単独でのテンプレート呼び出しが可能
- メインテンプレートに依存しない動作保証