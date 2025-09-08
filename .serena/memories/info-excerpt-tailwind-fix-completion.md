# Info-excerpt表示幅修正完了レポート

## 修正概要
デスクトップ幅でinfo-excerptテキストが4-5文字しか表示されない問題を!important CSS適用により解決。

## 根本原因
Tailwind CSS (CDN版) がカスタムCSSより後に読み込まれ、.info-contentのgrid-template-columnsを上書きしていた。

## 修正内容
`/assets/css/style.css` の2506行目に以下を追加：
```css
/* =========================
   Tailwind CSS競合回避
   ========================= */

/* info-content グリッド設定 - Tailwind優先度を上書き */
.info-content {
    grid-template-columns: clamp(40px, 5vw, 60px) 1fr !important;
}
```

## 修正前の状況（2025-08-30前）
- **デスクトップ1920px**: info-excerpt幅が60pxに制限され、overflow:hidden により4-5文字表示
- **モバイル768px**: mobile-info-excerptは629px幅で正常表示（25文字設定）

## 修正後の検証結果（Playwright検証完了）

### デスクトップ (1920x1080)
✅ **grid-template-columns**: `60px 649.078px` - 正常にclamp計算が適用
✅ **info-excerpt表示**: 33文字（PHP wp_trim_words設定通り）
✅ **レイアウト**: グリッド2列構造正常

### モバイル/タブレット (768x1024)
✅ **mobile-info-excerpt表示**: 28文字（25文字PHP設定＋省略記号）
✅ **幅設定**: 629px正常
✅ **レスポンシブ**: デスクトップ・モバイル切り替え正常

## 技術詳細
- **CSS優先度**: !important により Tailwind CSS上書きを強制適用
- **バックアップ**: `news-info-section_backup_20250830_221703.php` 作成済み
- **影響範囲**: .info-content グリッド設定のみ限定適用

## 今後の検討事項
- Tailwind CSS をCDNからビルド版への移行を検討
- CSS読み込み順序の最適化検討

## 検証完了日
2025-08-30 Playwright全デバイス検証完了