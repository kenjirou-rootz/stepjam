# 作業継続用コンテキスト情報

## ユーザーからの継続依頼パターン認識

### 継続を示すキーワード・フレーズ
- 「前回の続きから」
- 「作業の続き」  
- 「継続して」
- 「前回の ClaudeCode が強制終了した」
- 「途中で停止している」
- 「どこまで進んでいたか」
- 「Serena上の記録を確認」

### 継続時の理解すべき前提条件

#### 1. 技術的状況
**完了済み改修**:
- INFO・NEWS ACFフィールドの完全最適化（2025年8月29日完了）
- toroku-dancerフィールド削減（80%削減）
- HTML表示問題修正（single-toroku-dancer.php）

**現在のフェーズ**: 
- 技術実装: ✅ 完了
- 自動テスト: ✅ 完了  
- ユーザー確認: 🔄 待機中

#### 2. システム状態
```php
// 現在のINFO・NEWSフィールド構成（変更済み）
'info_news_show_date' => true_false（デフォルト:true）
'info_news_show_category' => true_false（デフォルト:true） 
'info_news_visual_type' => select（image/video、デフォルト:image）
'info_news_image' => image（条件付き表示）
'info_news_video_url' => url（条件付き表示）
'info_news_video_thumbnail' => image（条件付き表示）
'info_news_show_button' => true_false（デフォルト:false）
'info_news_button_text' => text（条件付き表示）
'info_news_button_url' => url（条件付き表示）
'info_news_button_target' => select（条件付き表示）
```

#### 3. 確認が必要な項目
**ユーザー視点での確認待ち**:
1. WordPress管理画面での新フィールド操作感
2. conditional_logic による動的表示の使用感
3. 画像・動画アップロード機能の動作
4. フロント表示の最終確認

## 継続作業時の標準対応フロー

### Phase 1: 状況確認（必須）
```markdown
1. Serenaメモリ確認: `stepjam_project_current_status_2025_08_29`
2. 詳細作業記録参照: `info_news_acf_field_optimization_2025_08_29`
3. ユーザーへの状況説明: 前回完了内容の要約提示
```

### Phase 2: 現在の課題確認
```markdown
1. ユーザー確認結果のヒアリング
   - 管理画面での使用感はどうか？
   - 意図しない動作はないか？
   - 追加の調整が必要か？

2. 問題がある場合の対応準備
   - バックアップファイル: `acf-fields_backup_20250829_HHMMSS.php`
   - 復元手順の準備
   - 追加調整のための分析
```

### Phase 3: 次のアクションプラン提示
```markdown
A. 確認結果が良好な場合:
   - 他のカスタム投稿タイプ最適化の提案
   - 全体システムの統合テスト提案
   - パフォーマンス最適化の提案

B. 調整が必要な場合:
   - 具体的な問題の特定
   - 修正方針の提示
   - 実装と再テスト

C. 重大な問題がある場合:
   - バックアップからの復元
   - 原因分析と再設計
```

## 技術的継続情報

### 使用中のMCPサーバー構成
- **Sequential MCP**: 複雑分析用（--seq, --think-hard）
- **Serena MCP**: プロジェクト記憶・継続用（--serena）
- **Playwright MCP**: 自動UI検証用（--play）
- **Context7 MCP**: WordPress/PHP公式ドキュメント参照用（--c7）

### SuperClaudeフレームワーク設定
```
適用フラグ: --ultrathink --serena --seq --play
理由: 
- 複雑なWordPressカスタマイズ
- セッション間継続の重要性
- 自動検証の必要性
```

### ファイル変更履歴
```
/inc/acf-fields.php (558-783行): INFO・NEWSフィールド完全置換
/single-toroku-dancer.php (93, 167行): HTML表示問題修正
バックアップ: 各変更前に自動作成済み
```

### 品質保証状況
- ✅ Playwright自動テスト: フロント表示確認済み
- ✅ 管理画面動作: 基本操作確認済み
- 🔄 ユーザー受け入れテスト: 未完了
- ⏳ 統合テスト: 次フェーズ予定

## セッション継続時の注意点

### 1. 前回との差分認識
```markdown
前回セッション終了時点:
- 技術実装: 100%完了
- 自動検証: 100%完了  
- Serenaメモリ: 記録完了
- ユーザー確認: 0%（これから開始）
```

### 2. 期待される継続パターン
```markdown
正常な継続:
User: "前回の続きをお願いします"
Assistant: 
1. Serenaメモリから現状確認
2. INFO・NEWS ACF最適化完了済みの説明
3. ユーザー確認作業の案内
4. 確認結果に基づく次アクション提案

異常検知時:
User: "エラーが出ている" / "表示がおかしい"
Assistant:
1. 緊急対応モード
2. バックアップ復元の準備
3. 問題の詳細確認
4. 修正または復元の実行
```

### 3. 継続効率化のための情報
- **作業時間**: INFO・NEWS改修に約2時間要した
- **複雑度**: 中〜高（フィールド依存関係の解析が必要）
- **リスク**: 低（バックアップ完備）
- **次回予想時間**: 確認→微調整で30分〜1時間程度

---

**このメモリの目的**: 将来のClaude Codeセッションが、ユーザーの「継続」依頼を受けた際に、適切に前回の状況を理解し、効率的に作業を継続できるようにすること。