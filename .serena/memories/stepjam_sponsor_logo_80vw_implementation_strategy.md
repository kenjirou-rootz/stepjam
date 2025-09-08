# STEPJAMスポンサーロゴ80vw実装戦略

## ユーザー要望
- 767px以下でロゴ80%幅・アスペクト比維持
- ACFゲットフィールド機能保持
- スライダー機能保持
- front-page.php影響なし

## 採用方針: A案 - 高さ制約削除による直接実装

### 技術的根拠
**現在の問題**:
```css
h-[clamp(55%,61.7%,70%)] = 206.25px高さ制約
→ object-contain により画像縮小（366.7px × 206.25px）
→ 視覚的に小さなロゴ表示
```

**A案解決方針**:
```css
@media (max-width: 767px) {
    .single-dancer-sponsor .sponsor-logo-right {
        width: 80vw;           /* 直接80%幅指定 */
        height: auto;          /* 高さ制約削除 */
        aspect-ratio: 16/9;    /* ACF画像比率維持 */
        margin: 0 auto;        /* 中央配置 */
    }
}
```

### 機能保持確認
- ✅ ACF: `get_field('sponsors_slides', 'option')` 変更なし
- ✅ Swiper: `single-logo-slider-mobile` 初期化変更なし  
- ✅ 画像出力: PHPループ処理変更なし
- ✅ front-page: 完全独立実装で影響なし

### 修正範囲
**変更あり**: `/assets/css/style.css` - 767px以下CSS追加のみ
**変更なし**: 
- `/template-parts/sponsor-single-area.php`
- `/template-parts/sponsor-logo-slider.php`
- ACF設定・JavaScript

### 期待される結果
- ロゴサイズ: 375px × 211px (80vw × 16:9比率)
- 視覚的改善: 現在の366.7px → 300px (80vw)
- アスペクト比: 16:9維持でACF画像の最適表示