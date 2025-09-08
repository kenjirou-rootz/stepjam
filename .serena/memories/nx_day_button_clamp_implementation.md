# nx-day-button ベクターはみ出し修正実装記録

## 実施日時
2025-08-29

## 問題概要
- nx-day-button内のDAY1/DAY2ベクター(d1-bt.svg, d2-bt.svg)が親コンテナからはみ出し表示
- 原因: width: 100%により、高さ制約clamp(60px, 10vw, 91px)を無視してベクターが拡大

## ベクター仕様
- d1-bt.svg: 193×93px (アスペクト比 2.075:1)
- d2-bt.svg: 193×93px (アスペクト比 2.075:1)

## 実装した解決策
### 修正前のCSS
```css
.nx-day-button img {
  width: 100%;
  height: auto;
  max-height: 100%;
  object-fit: contain;
}
```

### 修正後のCSS (clamp()最適化)
```css
.nx-day-button img {
  max-width: clamp(125px, 20.75vw, 189px);
  width: 100%;
  height: auto;
  max-height: 100%;
  object-fit: contain;
}
```

## clamp()値の計算根拠
- 親コンテナ高さ: clamp(60px, 10vw, 91px)
- ベクターアスペクト比: 2.075:1
- 最小幅: 60px × 2.075 = 125px (四捨五入)
- 推奨幅: 10vw × 2.075 = 20.75vw
- 最大幅: 91px × 2.075 = 189px (四捨五入)

## 期待される効果
1. ベクターが親コンテナ高さを超過しない
2. アスペクト比の適切な維持
3. レスポンシブ対応(375px-1920px)
4. 既存のobject-fit: contain機能継続

## 修正ファイル
- single-nx-tokyo.php (行168-174)