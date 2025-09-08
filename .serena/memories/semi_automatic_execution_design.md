# Semi-Automatic Execution Subsystem Design - Confirmation Process History Cleanup

## Core Architecture: Safe History Deletion with User Confirmation

### 1. Primary Executor (cleanup_executor.py)

**Purpose**: Semi-automatic Claude configuration cleanup with mandatory user confirmation and SuperClaude Framework MCP settings absolute protection

**Key Components**:
- Interactive confirmation system with detailed preview
- SuperClaude Framework MCP server protection mechanism
- Selective history cleanup with project-specific targeting
- Rollback capability with automatic backup creation
- Progress tracking with real-time status updates

**Core Implementation**:
```python
class CleanupExecutor:
    def __init__(self):
        self.config_path = Path("~/.claude.json").expanduser()
        self.protected_keys = ["mcpServers", "settings", "preferences"]
        self.confirmation_required = True
        self.backup_before_cleanup = True
        
    def execute_cleanup(self, cleanup_plan):
        # 1. Create safety backup
        # 2. Show detailed confirmation dialog
        # 3. Execute selective history cleanup
        # 4. Preserve ALL MCP settings
        # 5. Verify cleanup success
```

### 2. Confirmation & Safety System

**Interactive Confirmation Flow**:
```
1. 📊 Pre-Cleanup Analysis
   ├─ Current file size: 85.2KB
   ├─ Target size after cleanup: ~35KB (58% reduction)
   ├─ Projects to clean: stepjam (15 entries), hayashikenjirou (8 entries)
   ├─ Media content detected: ✅ (Base64 images will be removed)
   └─ MCP servers: 🛡️ PROTECTED (6 servers will be preserved)

2. ⚠️ Confirmation Dialog
   ┌─────────────────────────────────────────────────┐
   │ SuperClaude 肥大化クリーンアップ確認            │
   ├─────────────────────────────────────────────────┤
   │ 🗑️ 削除対象: 23個の履歴エントリ              │
   │ 🛡️ 保護対象: MCP設定 (絶対保護)              │
   │ 📦 バックアップ: 自動作成                      │
   │ ⏪ ロールバック: 可能                          │
   │                                                 │
   │ [🚀 実行] [📋 詳細] [❌ キャンセル]            │
   └─────────────────────────────────────────────────┘
```

**Safety Checkpoints**:
- Pre-cleanup config validation
- MCP server configuration verification  
- Backup creation success confirmation
- Post-cleanup integrity check
- Rollback availability verification

### 3. SuperClaude Framework Protection

**Absolute Protection Mechanism**:
```python
PROTECTED_SECTIONS = {
    "mcpServers": {
        "figma-official-sse": "PRESERVE",
        "playwright": "PRESERVE", 
        "serena": "PRESERVE",
        "sequential-thinking": "PRESERVE",
        "morphllm-fast-apply": "PRESERVE",
        "context7": "PRESERVE"
    },
    "globalSettings": "PRESERVE",
    "userPreferences": "PRESERVE"
}
```

**Protection Verification**:
- Pre-cleanup: Store protected section checksums
- During cleanup: Skip protected keys entirely
- Post-cleanup: Verify protected sections unchanged
- Integrity check: Compare checksums before/after

### 4. Selective History Cleanup Algorithm

**Cleanup Targeting Strategy**:
```python
def analyze_cleanup_targets(config_data):
    cleanup_plan = {
        "projects_to_clean": [],
        "entries_to_remove": 0,
        "estimated_size_reduction": 0,
        "media_content_removal": False
    }
    
    for project_path, project_data in config_data["projects"].items():
        history = project_data.get("history", [])
        if len(history) > 5:  # Keep latest 5 entries
            cleanup_plan["projects_to_clean"].append({
                "path": project_path,
                "current_entries": len(history),
                "entries_to_remove": len(history) - 5,
                "has_media": detect_media_content(history)
            })
            
    return cleanup_plan
```

**Cleanup Rules**:
- Keep latest 5 history entries per project
- Remove all pastedContents with base64 media
- Preserve project structure and basic metadata
- Maintain MCP server configurations untouched
- Clean empty projects (no history, no MCP servers)

### 5. Backup & Rollback System

**Automatic Backup Creation**:
```python
def create_safety_backup(self):
    timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
    backup_filename = f".claude_backup_{timestamp}_pre_cleanup.json"
    backup_path = self.system_root / "backup" / backup_filename
    
    # Copy original file with metadata preservation
    shutil.copy2(self.config_path, backup_path)
    
    return backup_path
```

**Rollback Mechanism**:
- Immediate rollback: Available during execution
- Emergency rollback: Available within 24 hours
- Verification rollback: Compare before/after states
- Selective rollback: Restore specific projects only

### 6. Progress Tracking & Reporting

**Real-time Progress Display**:
```
SuperClaude クリーンアップ実行中...
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
🔄 ステップ 1/5: バックアップ作成中... ✅
🔄 ステップ 2/5: 設定解析中... ✅  
🔄 ステップ 3/5: 履歴クリーンアップ中... ████████░░ 80%
🔄 ステップ 4/5: 整合性確認中... ⏳
🔄 ステップ 5/5: レポート生成中... ⏳

📊 処理状況: 
├─ stepjam: 15→5 entries (-10) ✅
├─ hayashikenjirou: 8→5 entries (-3) ✅
└─ MCP設定: 6 servers 🛡️ 保護済み
```

**Completion Report**:
```json
{
  "execution_timestamp": "2025-08-26T12:00:00Z",
  "original_size_kb": 85.2,
  "cleaned_size_kb": 34.7,
  "size_reduction_percent": 59.3,
  "projects_cleaned": 2,
  "total_entries_removed": 13,
  "mcp_servers_protected": 6,
  "backup_location": "claude-backups/latest/",
  "rollback_available": true,
  "execution_time_seconds": 3.4
}
```

### 7. User Interface & Interaction

**CLI Interface Design**:
```bash
$ python cleanup_executor.py --interactive
SuperClaude Bloat Prevention - 半自動クリーンアップ
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

📊 現在の状況:
   ファイルサイズ: 85.2KB (閾値: 50KB)
   履歴エントリ: 23個
   影響プロジェクト: stepjam, hayashikenjirou

🎯 クリーンアップ計画:
   予想削除サイズ: 50.5KB (59% 削減)
   保持エントリ: プロジェクト毎に最新5個
   保護設定: MCP servers (6個) → 絶対保護

Continue? [y/N/details]:
```

**GUI Integration Points**:
- macOS notification → action button → executor launch
- Confirmation dialogs with native macOS styling  
- Progress windows with cancel capability
- Results display with rollback options

### 8. Integration with Other Subsystems

**Monitor Integration**:
```python
# file_monitor.py からのトリガー
if threshold_exceeded and auto_cleanup_enabled:
    executor = CleanupExecutor()
    cleanup_plan = executor.analyze_cleanup_targets(config_data)
    
    # notification → user confirmation → execution
    if user_confirmed:
        executor.execute_cleanup(cleanup_plan)
```

**Notification Integration**:
- Action button "🔧 クリーンアップ開始" → launch executor
- Progress notifications during execution
- Completion notification with results summary

**Backup Integration**:
```python
# backup_manager.py 連携
backup_manager = BackupManager()
backup_location = backup_manager.create_backup("pre_cleanup")
cleanup_executor.set_backup_location(backup_location)
```

### 9. Error Handling & Recovery

**Error Scenarios & Recovery**:
- JSON parsing failure → Restore from backup
- Permission denied → Request elevated access
- Partial cleanup failure → Resume from checkpoint
- MCP settings corruption → Emergency rollback
- Disk space insufficient → Abort with cleanup

**Recovery Strategies**:
```python
class CleanupRecovery:
    def handle_error(self, error_type, context):
        recovery_actions = {
            "json_corrupt": self.restore_from_backup,
            "permission_denied": self.request_sudo_access,
            "partial_failure": self.resume_from_checkpoint,
            "mcp_corruption": self.emergency_rollback,
            "disk_full": self.abort_with_cleanup
        }
        
        return recovery_actions.get(error_type, self.safe_abort)()
```

### 10. Validation & Testing

**Pre-execution Validation**:
- Config file accessibility check
- Backup directory write permission
- JSON structure validity
- MCP server configuration integrity

**Post-execution Verification**:
- File size reduction confirmation
- MCP settings preservation verification
- JSON structure validity check
- History data consistency validation

**Test Scenarios**:
- Normal cleanup execution
- Emergency rollback testing
- MCP settings protection validation
- Large file handling (>100MB configs)
- Network interruption recovery

This semi-automatic execution subsystem provides safe, user-controlled history cleanup with absolute protection for SuperClaude Framework settings and comprehensive backup/rollback capabilities.