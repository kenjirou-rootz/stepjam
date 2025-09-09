# STEPJAM セキュリティ保持型Git運用ワークフロー

## 🔐 セキュリティ概要

**合言葉**: `rootz6002`  
**認証方式**: SSH Agent + パスフレーズ保護  
**セキュリティレベル**: 業界標準準拠

## 🚀 クイック運用コマンド

### **基本Git操作**
```bash
# コミット & プッシュ（推奨フロー）
./deploy/secure-git-workflow.sh git commit "Update theme features"
./deploy/secure-git-workflow.sh git push origin main

# プル更新
./deploy/secure-git-workflow.sh git pull origin main

# ステータス確認
./deploy/secure-git-workflow.sh git status
```

### **デプロイ操作**
```bash
# 本番デプロイ
./deploy/secure-git-workflow.sh deploy production

# 緊急ロールバック
./deploy/secure-git-workflow.sh deploy rollback

# メディア同期
./deploy/secure-git-workflow.sh deploy sync-media
```

### **接続テスト**
```bash
# 全接続確認
./deploy/secure-git-workflow.sh test
```

## 📋 日常運用フロー

### **1. 開発セッション開始**
```bash
cd "/Users/hayashikenjirou/Local Sites/stepjam"
./deploy/secure-git-workflow.sh test
```

### **2. 開発作業**
```bash
# ローカル開発: http://localhost:10004
# テーマファイル編集...
```

### **3. 変更をコミット**
```bash
./deploy/secure-git-workflow.sh git commit "テーマ機能追加"
```

### **4. GitHub同期**
```bash
./deploy/secure-git-workflow.sh git push origin main
```

### **5. 本番デプロイ**
```bash
./deploy/secure-git-workflow.sh deploy production
```

## 🔑 パスフレーズ管理

### **認証フロー**
1. **GitHub**: パスフレーズなしキー（高速認証）
2. **Xserver**: パスフレーズ保護キー（`rootz6002`）

### **パスフレーズ入力タイミング**
- **自動入力**: スクリプト内で `rootz6002` 自動適用
- **手動入力**: 自動失敗時のフォールバック
- **セッション持続**: SSH Agentで一度入力すれば持続

### **セキュリティベストプラクティス**
- ✅ パスフレーズは口外厳禁
- ✅ SSH Agentはセッション終了で自動クリア
- ✅ 定期的なキーローテーション（3ヶ月推奨）

## 🛠️ トラブルシューティング

### **パスフレーズエラー**
```bash
# SSH Agent再起動
eval "$(ssh-agent -s)"
./deploy/secure-git-workflow.sh test
```

### **接続失敗**
```bash
# 個別接続確認
ssh -F ssh/config -T git@github.com
ssh -F ssh/config stepjam-xserver "echo 'test'"
```

### **権限エラー**
```bash
# SSH キー権限修正
chmod 600 ssh/stepjam_xserver_rsa
chmod 644 ssh/stepjam_xserver_rsa.pub
```

## 📊 運用監視ポイント

### **セキュリティチェック**
- [ ] SSH キー権限（600）
- [ ] パスフレーズ強度
- [ ] 不正アクセス監視
- [ ] キーローテーション記録

### **パフォーマンス監視**
- [ ] Git操作レスポンス時間
- [ ] SSH接続安定性
- [ ] デプロイ完了時間
- [ ] ロールバック実行時間

## 🚨 緊急時対応

### **アクセス拒否時**
1. SSH Agentリセット: `ssh-add -D`
2. キー再追加: `./deploy/secure-git-workflow.sh test`
3. 接続確認: 各接続を個別テスト

### **デプロイ失敗時**
1. ログ確認: スクリプト出力詳細確認
2. 手動接続: `ssh -F ssh/config stepjam-xserver`
3. ロールバック: `./deploy/secure-git-workflow.sh deploy rollback`

### **パスフレーズ忘却時**
1. **新キー生成**: `ssh-keygen -t rsa -b 4096`
2. **サーバー登録**: 公開鍵をXserverに追加
3. **設定更新**: SSH configファイル更新

## 📞 サポート情報

**設定ファイル場所**:
- SSH設定: `ssh/config`
- セキュリティスクリプト: `deploy/secure-git-workflow.sh`
- 運用ガイド: `docs/secure-workflow-guide.md`

**合言葉確認**: `rootz6002`  
**最終更新**: 2025年9月8日