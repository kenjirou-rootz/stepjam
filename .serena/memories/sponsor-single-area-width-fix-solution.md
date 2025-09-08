# sponsor-single-area.php スライダーwidth:0問題 解決記録

## 問題概要
- **発生日**: 2025-09-03
- **症状**: 767px以下でスライダー画像すべてがwidth:0で非表示
- **影響**: ユーザー報告「黒い空間・スライダー見えない」

## 根本原因特定

### CSS Flexbox幅配分問題
sponsor-single-area.phpで使用される`.single-dancer-sponsor`コンテナ内の`.sponsor-logo-right`（スライダー）に幅指定がなく、flexboxで幅が決定されない状態。

### 親コンテナチェーン解析結果
```
SECTION (single-sponsor-section) → CONTAINER → sponsor-content-container → sponsor-logo-right (width: auto = 0px)
```

## 解決方法

### CSS修正内容 (style.css 2568-2606行追加)
```css
/* Single Dancer Logo Right (Slider) Width Fix */
.single-dancer-sponsor .sponsor-logo-right {
    flex: 1;
    min-width: 0;
    width: 50%;
}

.single-dancer-sponsor .sponsor-content-left {
    flex: 1;
    min-width: 0;
    width: 50%;
}

/* Mobile: Vertical stacking with proper dimensions */
@media (max-width: 768px) {
    .single-dancer-sponsor {
        flex-direction: column;
    }
    
    .single-dancer-sponsor .sponsor-logo-right {
        width: 100%;
        flex: 0 0 60%;
    }
    
    .single-dancer-sponsor .sponsor-content-left {
        width: 100%;
        flex: 0 0 40%;
    }
}
```

### 修正前後比較

**修正前**:
- スライダー画像: width: 0, height: 130 (非表示)
- sponsorContentImage: width: 0, height: 0 (非表示)
- visible: false (すべて)

**修正後**:
- スライダー画像: width: 360, height: 111 (表示)
- Swiper: initialized: true, autoplay: true
- visible: true (スライダーすべて)

## 技術的詳細

### Flexbox配分ルール
- **Desktop (768px+)**: 50%/50% 水平分割
- **Mobile (767px-)**: 60%/40% 垂直スタック
  - スライダー60% (上部)
  - コンテンツ40% (下部)

### 適用対象
- `.single-dancer-sponsor` コンテナ (sponsor-single-area.php専用)
- front-page.phpには影響なし (完全独立実装)

## 検証結果

### 375px環境最終確認
- ✅ **スライダー3個**: 360×111px 正常表示
- ✅ **Swiper機能**: 初期化済み・自動再生中
- ✅ **レスポンシブ**: 767px以下完全対応
- ⚠️ **コンテンツ画像**: 別途対応必要（width:0残存）

## 今後の保守指針

### 監視項目
1. `.sponsor-logo-right` flexbox幅配分継続監視
2. mobile breakpoint (768px) 境界動作確認
3. スライダー画像読み込み遅延対策

### 関連ファイル
- `/template-parts/sponsor-single-area.php` (テンプレート)
- `/template-parts/sponsor-logo-slider.php` (スライダー構造)
- `/assets/css/style.css` (CSS修正実装)
- `/assets/js/main.js` (Swiper初期化)

### 完了日
2025-09-03 14:30 - スライダー表示問題完全解決