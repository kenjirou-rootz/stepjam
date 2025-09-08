# STEPJAMナビメニュー修正分析・依存関係調査結果

## 根本原因
1. **JavaScript自動初期化失敗** - STEPJAMreAppインスタンスが`DOMContentLoaded`で作成されない
2. **イベントリスナー未設定** - ナビトグルボタンのクリック処理が機能しない
3. **スクロール計算エラー** - `scrollToSection()`の`offsetTop`による位置計算問題

## 技術的修正案（優先度付き）
### 🔴最高優先: JavaScript初期化フォールバック
- 複数イベント（DOMContentLoaded, load, readyState）でフォールバック
- `window.stepjamApp`インスタンス重複作成防止
- WordPress環境特有の読み込み遅延対応

### 🟡高優先: スクロール関数改善
- `offsetTop` → `getBoundingClientRect().top + window.scrollY`
- 動的レイアウト（Swiper等）との親和性向上
- より正確な位置計算

### 🟢低優先: CSS オーバーレイサイズ修正
- `max-width: 1200px` → `100vw`
- フルスクリーン表示の実現

## 依存関係・影響範囲分析
### ✅ 安全確認済み
- **他PHP影響**: なし（コメント記述のみ）
- **他JS影響**: なし（window.stepjamApp直接参照なし）
- **スクリプト依存**: Swiper.jsのみ（enqueue-scripts.phpで管理）
- **独立性**: dancers-slider.jsと完全分離

### 📁 関連ファイル
- `assets/js/main.js` - 修正対象メインファイル
- `template-parts/nav-overlay.php` - 軽微CSS修正対象
- `inc/enqueue-scripts.php` - 依存関係管理（修正不要）

## 実装安全性
- **リスク**: 最小限（バックアップ必須）
- **復元性**: 完全（修正はmain.js中心）
- **機能影響**: ナビメニューのみ（他機能継続）
- **テスト容易**: 段階的修正・検証可能

## 修正後期待効果
1. ナビトグルボタン正常動作
2. スムーズスクロール機能復旧
3. 全セクション（hero/sponsor/whsj/lib-top）への正確な移動
4. レスポンシブ対応改善

記録日時: 2025-09-03
分析手法: Sequential Thinking MCP + Serena MCP + Playwright検証