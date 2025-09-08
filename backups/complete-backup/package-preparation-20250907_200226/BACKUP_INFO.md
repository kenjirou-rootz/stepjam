# バックアップ情報

- **作成日時**: 2025年9月7日 20:02:26
- **目的**: WordPressパッケージ化準備のための完全バックアップ
- **バックアップ元**: /Users/hayashikenjirou/Local Sites/stepjam/

## 復元手順

### 1. ファイルの復元
```bash
# バックアップからファイルを復元
cp -r /Users/hayashikenjirou/Local Sites/stepjam/バックアップ/complete-backup/package-preparation-20250907_200226/files/* /Users/hayashikenjirou/Local Sites/stepjam/
```

### 2. データベースの復元
```bash
# Local by Flywheelを使用している場合
# 1. WordPressの管理画面にログイン
# 2. プラグイン > 新規追加 > 「WP Migrate DB」を検索してインストール
# 3. ツール > Migrate DB でdatabase-backup.sqlをインポート

# または、phpMyAdminやAdminerを使用してインポート
```

### 3. パーミッションの修正
```bash
# 必要に応じて実行
find /Users/hayashikenjirou/Local Sites/stepjam/app/public -type d -exec chmod 755 {} \;
find /Users/hayashikenjirou/Local Sites/stepjam/app/public -type f -exec chmod 644 {} \;
```

## バックアップ内容

- **files/**: プロジェクト全体のファイルバックアップ
- **database-backup.sql**: データベースの完全バックアップ
- **file-structure.txt**: バックアップ時点のファイル構造記録

## 注意事項

- このバックアップは整理作業前の完全な状態を保持しています
- 復元後は必ずサイトの動作確認を行ってください
- Local by Flywheelのサイト設定も合わせて確認してください