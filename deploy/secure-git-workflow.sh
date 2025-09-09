#!/bin/bash
# STEPJAM セキュリティ保持型Git運用ワークフロー
# 合言葉: rootz6002

set -euo pipefail

# 設定
PROJECT_ROOT="/Users/hayashikenjirou/Local Sites/stepjam"
SSH_CONFIG="$PROJECT_ROOT/ssh/config"
XSERVER_KEY="$PROJECT_ROOT/ssh/kenjirou0402.key"
GITHUB_KEY="$PROJECT_ROOT/ssh/stepjam_github_ed25519"

# カラー出力
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# ログ関数
log() {
    echo -e "${GREEN}[STEPJAM]${NC} $1"
}

warn() {
    echo -e "${YELLOW}[警告]${NC} $1"
}

error() {
    echo -e "${RED}[エラー]${NC} $1"
    exit 1
}

# SSH Agent状態確認
check_ssh_agent() {
    if ! ssh-add -l >/dev/null 2>&1; then
        log "SSH Agentを起動しています..."
        eval "$(ssh-agent -s)"
    fi
}

# SSH キー追加（パスフレーズ保護）
add_ssh_keys() {
    local key_type="$1"
    
    case "$key_type" in
        "github")
            log "GitHubキーを追加中..."
            if ! ssh-add -l | grep -q "stepjam_github_ed25519"; then
                ssh-add "$GITHUB_KEY" || error "GitHubキーの追加に失敗"
            fi
            ;;
        "xserver")
            log "Xserverキーを追加中（パスフレーズ: rootz6002）..."
            if ! ssh-add -l | grep -q "kenjirou0402.key"; then
                echo "rootz6002" | ssh-add "$XSERVER_KEY" || {
                    warn "自動パスフレーズ入力失敗。手動入力してください。"
                    ssh-add "$XSERVER_KEY" || error "Xserverキーの追加に失敗"
                }
            fi
            ;;
        "all")
            add_ssh_keys "github"
            add_ssh_keys "xserver"
            ;;
    esac
}

# Git操作実行
git_operation() {
    local operation="$1"
    shift
    
    export GIT_SSH_COMMAND="ssh -F $SSH_CONFIG"
    
    case "$operation" in
        "push")
            log "GitHub pushを実行中..."
            add_ssh_keys "github"
            git push "$@" || error "Git push に失敗"
            log "✅ Push 完了"
            ;;
        "pull")
            log "GitHub pullを実行中..."
            add_ssh_keys "github"
            git pull "$@" || error "Git pull に失敗"
            log "✅ Pull 完了"
            ;;
        "status")
            git status
            ;;
        "commit")
            if [[ $# -eq 0 ]]; then
                error "コミットメッセージが必要です"
            fi
            git add . && git commit -m "$*" || error "Git commit に失敗"
            log "✅ Commit 完了"
            ;;
        *)
            error "不明なGit操作: $operation"
            ;;
    esac
}

# デプロイ操作（Xserver接続）
deploy_operation() {
    local deploy_type="$1"
    
    add_ssh_keys "xserver"
    
    case "$deploy_type" in
        "production")
            log "本番デプロイを実行中..."
            "$PROJECT_ROOT/deploy/deploy-production.sh"
            ;;
        "rollback")
            log "ロールバックを実行中..."
            "$PROJECT_ROOT/deploy/rollback.sh"
            ;;
        "sync-media")
            log "メディア同期を実行中..."
            "$PROJECT_ROOT/deploy/sync-media.sh"
            ;;
        *)
            error "不明なデプロイ操作: $deploy_type"
            ;;
    esac
}

# SSH接続テスト
test_connections() {
    log "接続テストを実行中..."
    
    add_ssh_keys "github"
    if timeout 10 ssh -F "$SSH_CONFIG" -T git@github.com 2>&1 | grep -q "successfully authenticated"; then
        log "✅ GitHub接続: 成功"
    else
        warn "❌ GitHub接続: 失敗"
    fi
    
    add_ssh_keys "xserver"
    if timeout 15 ssh -F "$SSH_CONFIG" stepjam-xserver "echo 'Connection test'" 2>/dev/null; then
        log "✅ Xserver接続: 成功"
    else
        warn "⚠️ Xserver接続: 要パスフレーズ確認（セキュリティ正常）"
    fi
}

# メイン処理
main() {
    cd "$PROJECT_ROOT"
    
    log "🔐 STEPJAM セキュリティ保持型Git運用ワークフロー"
    log "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    if [[ $# -eq 0 ]]; then
        echo "使用方法:"
        echo "  $0 git <push|pull|commit|status> [引数...]"
        echo "  $0 deploy <production|rollback|sync-media>"
        echo "  $0 test"
        echo ""
        echo "例:"
        echo "  $0 git commit 'Update theme features'"
        echo "  $0 git push origin main"
        echo "  $0 deploy production"
        echo "  $0 test"
        exit 1
    fi
    
    check_ssh_agent
    
    case "$1" in
        "git")
            shift
            git_operation "$@"
            ;;
        "deploy")
            shift
            deploy_operation "$@"
            ;;
        "test")
            test_connections
            ;;
        *)
            error "不明なコマンド: $1"
            ;;
    esac
    
    log "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    log "✅ 操作完了"
}

main "$@"