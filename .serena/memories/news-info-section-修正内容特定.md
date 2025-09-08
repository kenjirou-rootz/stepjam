# News・Infoセクション修正内容特定

## 修正が必要な項目：

### 1. ガイドカラーパスの背景色削除
- 黄色背景（`background-color: #FFFF00`）→ 削除
- ピンク背景（`background-color: #FF00FF`）→ 削除  
- 青背景（`background-color: #0000FF`）→ 削除
- これらはデザインガイドのため実装に含めない

### 2. Info/NewsタイトルのSVG置き換え
- テキストの「Info」「News」を削除
- `/vecter/info-v.svg`を使用
- `/vecter/news-v.svg`を使用

### 確認済み内容：
- vectorフォルダ内に2つのSVGファイル存在
  - info-v.svg（白文字のInfo）
  - news-v.svg（白文字のNews）