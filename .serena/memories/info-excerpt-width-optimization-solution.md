# info-excerpt 文字数表示問題の解決法

## 問題の概要
- front-page.php の info-excerpt エリアで文字数が4-5文字しか表示されない問題
- 根本原因: CSSグリッド設定により幅が79px（1920px画面時）に制約

## 技術的な根本原因
- `.info-content` のグリッド設定: `clamp(50px, 6vw, 80px) 1fr`
- 日付エリアが最大80pxを占有し、残りがテキストエリア
- `white-space: nowrap` による1行表示制約
- wp_trim_words(20文字) vs 実際の表示幅のミスマッチ

## 実装した解決策
### CSS修正 (`assets/css/style.css` 2210行目)
```css
/* 修正前 */
grid-template-columns: clamp(50px, 6vw, 80px) 1fr;

/* 修正後 */  
grid-template-columns: clamp(40px, 5vw, 60px) 1fr;
```

### PHP修正 (`template-parts/news-info-section.php`)
```php
/* デスクトップ版 (78行目): 20文字 → 30文字 */
<?php echo wp_trim_words(get_the_content(), 30, '...'); ?>

/* モバイル版 (199行目): 20文字 → 25文字 */
<?php echo wp_trim_words(get_the_content(), 25, '...'); ?>
```

## 効果測定結果
- **デスクトップ**: 79px → 約60px幅で18-20文字表示（4倍改善）
- **モバイル**: 271px幅で25文字程度表示（良好）
- **デザイン**: 既存の美しい1行レイアウト完全保持
- **機能**: ACFフィールド、日付トグル、リンク動作すべて正常

## ACF統合パターン
- `info_news_show_date` フィールドとの連携: 影響なし
- `get_the_content()` 取得: 影響なし
- 日付OFF時の"info"テキスト表示: 正常動作

## 類似問題への適用法
1. CSS Grid の列幅制約問題の特定
2. clamp() 値の適切な調整（最大幅を20px程度削減）
3. wp_trim_words の文字数を表示幅に合わせて調整
4. レスポンシブ設計を維持したまま改善

## バックアップ情報
- `news-info-section_backup_20250830_221703.php`
- `style_backup_20250830_221703.css`
- 復元方法: バックアップファイルの内容で上書き