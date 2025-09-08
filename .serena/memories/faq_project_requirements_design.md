# FAQページ作成プロジェクト - 要件・設計仕様書

## プロジェクト概要

### 基本要件
- **タイプ**: カスタム投稿タイプ + アーカイブページ
- **ACF管理**: 質問・回答の2項目フィールド
- **UI**: アコーディオン型（初期全閉じ状態）
- **アニメーション**: スライド+フェードの組み合わせ
- **設計**: シンプル&ミニマル、1カラム、全件表示
- **URL**: `/faq`
- **技術方針**: モノリシック統合回避、マイクロコンポーネント設計

## 技術仕様

### WordPress実装
**カスタム投稿タイプ:**
- 投稿タイプ名: `faq`
- パブリック: `true`
- 管理画面表示: `true`
- アーカイブ: `true`
- リライト: `array('slug' => 'faq')`

**ACFフィールド設計:**
- フィールドグループ: FAQ Management
- 質問 (faq_question): Textarea
- 回答 (faq_answer): Wysiwyg Editor
- 表示順 (faq_order): Number
- 公開状態 (faq_published): True/False

**ファイル構成:**
- `inc/custom-post-types.php` - FAQ投稿タイプ追加
- `inc/acf-fields.php` - ACFフィールドグループ追加
- `archive-faq.php` - アーカイブページテンプレート
- `template-parts/faq-accordion.php` - アコーディオンコンポーネント
- `nav-overlay.php` - ナビメニューにFAQ追加

### JavaScript実装（分離コンポーネント設計）
**独立ファイル:**
- `assets/js/faq-accordion.js`
- クラス名: `FAQAccordion`
- ネームスペース: `STEPJAM.FAQ`
- 既存`STEPJAMreApp`との完全分離

**機能仕様:**
- スムーズなアコーディオン開閉
- 複数項目同時展開対応
- キーボードアクセシビリティ (Enter, Space, Arrow keys)
- ARIA属性制御 (aria-expanded, aria-controls)

### CSS/アニメーション仕様
**アニメーション詳細:**
```css
/* 初期状態 */
.faq-answer {
    height: 0;
    opacity: 0;
    overflow: hidden;
    transform: translateY(-10px);
    transition: height 0.3s ease-out, opacity 0.3s ease-out, transform 0.3s ease-out;
}

/* 展開状態 */
.faq-answer.expanded {
    height: auto;
    opacity: 1;
    transform: translateY(0);
}
```

**デザインシステム統合:**
- カラー: figma-black (#000000), figma-white (#FFFFFF), figma-cyan (#00F7FF)
- フォント: Noto Sans JP
- レスポンシブ: 768px境界
- Tailwind CSS + カスタムCSS

### レスポンシブ設計
**ブレークポイント:**
- デスクトップ: 768px以上
- モバイル: 767px以下

**モバイル最適化:**
- タッチターゲット: 44px以上
- フォントサイズ調整
- 余白・パディング最適化
- スワイプジェスチャー対応（将来実装）

## 品質保証・テスト戦略

### 自動テスト（Playwright）
1. FAQ投稿の管理画面作成・編集・削除
2. アーカイブページの表示確認
3. アコーディオン開閉動作
4. レスポンシブ動作検証
5. アクセシビリティ基準確認
6. 既存システム影響確認

### 手動確認項目
- アニメーション滑らかさ
- デザイン統合性
- ユーザビリティ
- パフォーマンス

## セキュリティ・保守性

### セキュリティ対策
- 入力値サニタイゼーション (wp_kses, esc_html)
- XSS対策 (出力エスケープ)
- 権限チェック (manage_options)
- CSRF対策 (WordPress nonce)

### 保守性設計
- コードコメント日本語化
- エラーハンドリング
- デバッグ情報出力
- 設定変更の柔軟性

## 実装スケジュール
**6段階のPhase実装:**
1. カスタム投稿タイプ+ACF設定
2. アーカイブテンプレート作成
3. JavaScriptアコーディオン実装
4. モダンアニメーション実装
5. ナビメニュー統合
6. 最終検証・調整

各Phase完了後にユーザー確認・承認を得てから次Phase進行。

## 運用・管理方針
- WordPress管理画面での直感的編集
- 表示順の任意調整
- 公開・非公開の切り替え
- SEO最適化対応
- 将来的な機能拡張への柔軟性確保