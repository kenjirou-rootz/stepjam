# main.js リファクタリング分析・設計方針

## WordPressテーマ構成分析結果

### テーマ構造
- 標準的なWordPressテーマ構造（functions.php, inc/, template-parts/, assets/）
- 単一main.jsファイル（423行）
- CDN依存: Tailwind CSS + Swiper.js
- 配布想定: WordPressテーマとしてパッケージ化

## 最適解判定結果

### 1. 静的解析ツール選定

**選定結果: 軽量統合ソリューション**

**理由:**
- エンドユーザー（WordPress管理者）がNode.js環境を持たない前提
- 開発品質確保と配布利便性の両立が必要
- WordPressテーマとして自己完結性が重要

**実装方針:**
1. **開発時品質確保**: .eslintrc.js設定ファイル（package.json不要）
2. **実行時診断**: main.js内に自己診断機能組み込み
3. **WordPress統合**: admin_notices フックでエラー通知

### 2. ハードコード値管理方式

**選定結果: CSS変数連携方式**

**理由:**
- 既存style.cssのCSS変数システムと整合性保持
- 最小構成かつ保守性・パフォーマンス両立
- 設定変更頻度低の前提に適合

**対象値:**
- `window.innerWidth >= 768` → CSS変数 `--breakpoint-tablet`
- `headerHeight = 97.36` → 既存 `--header-height` 活用
- `switchLibraryTab('tokyo')` → CSS変数 `--default-library-tab`

### 3. 外部依存関係構成

**選定結果: ハイブリッド構成**

**構成・安定性・速度分析結果:**
- **Tailwind CSS**: CDN維持
  - 理由: 複雑な設定、頻繁な更新、カスタム設定多数
- **Swiper.js**: ローカルファイル化
  - 理由: 限定機能使用、安定性重視、自己完結性向上

**実装:**
- Swiperを assets/js/vendor/ に配置
- enqueue-scripts.phpでローカル読み込みに変更

### 4. nav-overlay再設計

**対象範囲:**
- 過去の手動JavaScript実装（完全置換）
- enqueue-scripts.phpの一時対応（完全置換）
- main.js内実装の最適化

**設計方針:**
- 統一されたイベントハンドリング
- CSS変数によるz-index管理との連携
- エラーハンドリング統合

### 5. エラーハンドリングレベル

**選定結果: 標準レベル**

**理由:**
- WordPressテーマとして適切なレベル
- 開発・保守時のデバッグ支援
- エンドユーザーへの配慮

**実装内容:**
- try-catch による基本例外処理
- console.warn による開発者向け警告
- WordPress admin_notices による管理者通知
- デバッグモード対応（WP_DEBUGフラグ連動）

## 実装優先順位

1. **高優先度**: 構文エラー修正、nav-overlay再設計
2. **中優先度**: ハードコード値管理、エラーハンドリング
3. **低優先度**: 静的解析ツール、外部依存最適化

## 技術的課題・注意点

- CSS変数のブラウザ互換性（IE11サポート要否確認）
- Swiperバージョン固定による機能制限
- WordPressフック使用時のパフォーマンス影響