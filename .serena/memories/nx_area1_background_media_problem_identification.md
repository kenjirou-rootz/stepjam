# NX Area1 背景メディア機能要望 - 問題特定

## 要望日時
2025-08-28

## 要望概要
nx-area1の背景に画像・動画を設置できる仕組み実装

## 現状分析
### 現在のnx-area1構造
```css
.nx-area1 {
  background-color: var(--nx-red);
  display: grid;
  grid-template-rows: 1fr auto;
  min-height: 100vh;
  min-height: 100dvh;
  position: relative;
}
```

### 現在のnx-header構造
```css  
.nx-header {
  background-color: var(--nx-blue);
  display: flex;
  flex-direction: column;
  gap: clamp(2rem, 5vw, 3rem);
  padding: clamp(2rem, 5vw, 3rem) clamp(1.5rem, 4vw, 2.5rem);
  overflow: hidden;
  position: relative;
  min-height: 0;
}
```

## 特定された問題点
1. **nx-header高さ制御なし**: 現在はflexで伸縮（flex: 1相当）
2. **背景設定機能なし**: ACFフィールドで画像・動画選択不可
3. **メディア表示機能なし**: CSS background-image、HTML5 video未対応
4. **優先度制御なし**: 画像・動画の表示優先度設定不可

## 実装必要機能
### ACFフィールド追加
- 背景画像フィールド（Image）
- 背景動画フィールド（File - mp4）
- 表示優先度フィールド（Radio: 画像優先/動画優先）

### CSS実装
- nx-area1: `100svh`高さ設定、フォールバック`100dvh → 100vh`
- nx-header: 最大400px制限（モバイル300px）
- 背景画像: `background-image`でcover表示
- 背景動画: HTML5 `video`要素で自動再生・ループ

### テンプレート実装
- ACF条件分岐での背景メディア表示制御
- video要素: `muted autoplay loop` 属性
- フォールバック: 青背景（#0000FF）維持

## SuperClaudeコマンド使用
`--ultrathink --serena --seq --playwright`

## 次のステップ
Sequential MCPで技術分析開始