# STEPJAM ダンサーセクション統合システム

## ダンサーセクション概要

### ファイル場所
- **テンプレート**: `/template-parts/dancers-section.php`
- **呼び出し元**: `single-nx-tokyo.php` (700行目)
- **呼び出し方法**: `<?php get_template_part('template-parts/dancers-section'); ?>`

### 構造とレイアウト
```html
<div class="dancers-section">
    <div class="dancers-section__tabs">
        <!-- TOKYO/OSAKA タブ切り替え -->
    </div>
    
    <div class="dancers-section__content">
        <div class="dancers-section__location dancers-section__location--tokyo">
            <div class="dancers-section__days">
                <div class="dancers-section__day dancers-section__day--day1">
                    <!-- DAY1 ダンサー一覧 -->
                </div>
                <div class="dancers-section__day dancers-section__day--day2">
                    <!-- DAY2 ダンサー一覧 (NX TOKYOエリア選択と連動) -->
                </div>
            </div>
        </div>
        
        <div class="dancers-section__location dancers-section__location--osaka">
            <!-- OSAKA エリア同様の構造 -->
        </div>
    </div>
</div>
```

## NX TOKYO エリア選択連動システム

### DAY2背景色制御の仕組み
**問題**: ダンサーセクションのDAY2背景色をNX TOKYOページのエリア選択と連動
**解決**: CSS + JavaScript ハイブリッド制御

### CSS制御 (primary)
```css
/* single-nx-tokyo.php 内のスタイル */
.nx-tokyo-container.area-none .dancers-section__day--day2 {
  background-color: transparent !important;
}
.nx-tokyo-container.area-tokyo .dancers-section__day--day2 {
  background-color: #0000FF !important; /* 青 */
}
.nx-tokyo-container.area-osaka .dancers-section__day--day2 {
  background-color: #FF0000 !important; /* 赤 */
}
.nx-tokyo-container.area-tohoku .dancers-section__day--day2 {
  background-color: #00FF6A !important; /* 緑 */
}
```

### JavaScript制御 (fallback)
```javascript
// single-nx-tokyo.php 内のスクリプト
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.nx-tokyo-container');
    const day2Section = document.querySelector('.dancers-section__day--day2');
    
    if (container && day2Section) {
        let bgColor = '#0000FF'; // デフォルト: TOKYO青
        
        if (container.classList.contains('area-none')) {
            bgColor = 'transparent';
        } else if (container.classList.contains('area-osaka')) {
            bgColor = '#FF0000';
        } else if (container.classList.contains('area-tohoku')) {
            bgColor = '#00FF6A';
        }
        
        day2Section.style.setProperty('background-color', bgColor, 'important');
    }
});
```

## 技術的実装詳細

### 親コンテナとの連携
- **親要素**: `.nx-tokyo-container` に動的クラス (`area-tokyo`, `area-osaka`, `area-tohoku`, `area-none`)
- **対象要素**: `.dancers-section__day--day2` (ダンサーセクション内)
- **制御方法**: CSSセレクタの親子関係を利用した制御

### スタイル優先度管理
1. **!important** を使用してCSS specificity問題を回避
2. **JavaScript fallback** でCSS適用失敗時の保険
3. **setProperty with important** でJavaScript強制適用

### エリア別カラーマッピング
```javascript
const colorMap = {
    'area-none': 'transparent',
    'area-tokyo': '#0000FF',     // 青
    'area-osaka': '#FF0000',     // 赤  
    'area-tohoku': '#00FF6A'     // 緑
};
```

## ダンサーデータとACF連携

### 関連カスタム投稿タイプ
- **投稿タイプ**: `toroku-dancer`
- **役割**: 登録ダンサー情報管理
- **表示場所**: ダンサーセクション各DAY

### ACF連携パターン (推測)
```php
// ダンサー情報取得 (template-parts/dancers-section.php内)
$tokyo_day1_dancers = get_field('tokyo_day1_dancers') ?: [];
$tokyo_day2_dancers = get_field('tokyo_day2_dancers') ?: [];
$osaka_day1_dancers = get_field('osaka_day1_dancers') ?: [];
$osaka_day2_dancers = get_field('osaka_day2_dancers') ?: [];
```

## レスポンシブ対応

### ブレークポイント連携
- **768px以下**: モバイルレイアウト
- **768px以上**: デスクトップレイアウト
- **NX TOKYO本体と同じブレークポイント**: 一貫したUX

### JavaScript初期化タイミング
- **DOMContentLoaded**: DOM構築完了後即座に実行
- **対象セレクタ**: `.nx-tokyo-container`, `.dancers-section__day--day2`
- **エラーハンドリング**: 要素存在確認 (`if (container && day2Section)`)

## 保守性向上の設計

### 色管理の一元化
- **CSS変数**: `:root` での色定義
- **JavaScript定数**: colorMap での管理
- **PHP配列**: `$area_configs` での設定管理

### 拡張性
- **新エリア追加**: 3箇所の修正のみ (CSS, JS, PHP)
- **色変更**: CSS変数の変更で全体反映
- **ロジック変更**: 各制御層の独立性維持