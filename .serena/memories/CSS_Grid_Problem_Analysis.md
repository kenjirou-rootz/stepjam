# CSS Grid Problem Analysis - Info News Archive

## 問題特定完了

### 問題箇所の特定
**ファイル**: `app/public/wp-content/themes/stepjam-theme/assets/css/style.css`
**行**: 1761行目 `grid-template-columns: repeat(12, minmax(0, 1fr));`

### 現在の問題ある実装
```css
@container info-news-archive (min-width: 768px) {
    .info-news-archive-desktop {
        display: grid;
        grid-template-columns: repeat(12, minmax(0, 1fr)); /* 問題のある12列グリッド */
        gap: 0 var(--info-news-gap-x);
        padding: var(--info-news-container-pad);
    }
    
    /* 非効率な配置システム */
    .info-news-archive-item:nth-child(odd) {
        grid-column: span 5; /* 5列使用 = 295px */
    }
    
    .info-news-archive-item:nth-child(even) {
        grid-column: span 5;
        grid-column-start: 8; /* 8列目開始で5列使用 = 59px幅の問題 */
    }
}
```

### 実測結果（1200px時）
- 各列幅: 59px（極端に狭い）
- アイテム1,3,5: 439px（正常）
- アイテム2,4,6: 59px（表示不可能）

## 修正方針
1. **12列グリッド完全削除**
2. **2列グリッド（1fr 1fr）実装**
3. **参考画像に合わせた余白調整**

## 関連ファイル
- CSS: `app/public/wp-content/themes/stepjam-theme/assets/css/style.css` (行1761-)
- PHP: `app/public/wp-content/themes/stepjam-theme/archive-info-news.php`（ACFフィールド保持）