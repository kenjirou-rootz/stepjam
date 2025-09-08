# News & Info Section 問題点特定完了

## 🔴 確認済み問題点

### 1. 固定テキストの問題 (PHPテンプレート)
- **Desktop News（136行目）**: `NEWS 記事タイトルが入る` → `<?php the_title(); ?>`に修正必要
- **Mobile Info（184行目）**: `info 記事タイトル` → `<?php the_title(); ?>`に修正必要  
- **Mobile Info説明文（186行目）**: 固定文 → `<?php echo wp_trim_words(get_the_content(), 20, '...'); ?>`に修正必要
- **Mobile News（246行目）**: `NEWS 記事タイトルが入る` → `<?php the_title(); ?>`に修正必要

### 2. CSSスタイル未実装
- **確認結果**: `app/public/wp-content/themes/stepjam-theme/assets/css/style.css`にnews-info-sectionのスタイルが存在しない
- **必要対応**: グローバル指針.mdに従った完全なCSSスタイル実装

### 3. グローバル指針.md非準拠構造
- **12カラムグリッド**: 未実装
- **コンテナクエリ**: 未実装（現在は古いメディアクエリ方式と推測）
- **clamp()による流体スケーリング**: 未実装
- **woff2フォント**: 確認必要

## 🎯 修正計画

1. **固定テキスト修正** (4箇所の PHPテンプレート修正)
2. **CSS完全実装** (グローバル指針.md準拠)
3. **Playwright確認** (修正後の動作検証)
4. **Serena MCP記録** (完了報告)