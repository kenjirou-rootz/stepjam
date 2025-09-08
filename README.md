# STEPJAM

**Official website project for STEPJAM, a dance event platform showcasing performances, schedules, and event details.**

## 🚀 クイックスタート

### 初回セットアップ
```bash
# 1. Gitリポジトリクローン
git clone git@github.com:kenjirou-rootz/stepjam.git
cd stepjam

# 2. デプロイスクリプト実行権限設定
chmod +x deploy/*.sh

# 3. 初回デプロイ
./deploy/deploy-production.sh
```

### 日常の開発フロー
```bash
# 1. 開発作業
# テーマファイルを編集...

# 2. コミット & デプロイ
git add .
git commit -m "Update theme"
./deploy/deploy-production.sh
```

## 📁 プロジェクト構造

```
stepjam/
├── .git/                      # Gitリポジトリ
├── .gitignore                 # Git除外設定
├── README.md                  # このファイル
├── deploy/                    # デプロイスクリプト
│   ├── deploy-production.sh   # 本番デプロイ
│   ├── sync-media.sh         # メディア同期
│   ├── rollback.sh           # 緊急ロールバック
│   └── rsync-exclude.txt     # rsync除外リスト
├── docs/                      # ドキュメント
│   └── server-git-setup.md   # サーバーGit設定
├── ssh/                       # SSH設定
│   ├── ssh-env.md            # 環境情報
│   └── kenjirou0402.key      # SSH秘密鍵
└── app/public/               # WordPress本体
    └── wp-content/themes/stepjam-theme/  # テーマ（Git管理）
```

## 🔧 主要コマンド

### デプロイ
```bash
./deploy/deploy-production.sh      # フルデプロイ
./deploy/sync-media.sh            # メディアのみ同期
```

### 緊急対応
```bash
./deploy/rollback.sh              # ロールバック
```

### SSH接続
```bash
ssh stepjam-xserver               # 本番サーバー接続
```

### WP-CLI操作（リモート）
```bash
ssh stepjam-xserver "cd /home/kenjirou0402/rootzexport.info/public_html && wp cache flush"
```

## 🌐 環境情報

| 項目 | 内容 |
|------|------|
| ローカル | http://localhost:10004 |
| 本番 | https://rootzexport.info |
| GitHub | https://github.com/kenjirou-rootz/stepjam |
| サーバー | Xserver (sv3020) |

## 🛡️ セキュリティ

- SSH秘密鍵は `.gitignore` で除外
- `wp-config.php` は Git管理外
- デプロイ前に自動バックアップ

## 📞 サポート

問題が発生した場合は、`docs/` ディレクトリのドキュメントを参照してください。
