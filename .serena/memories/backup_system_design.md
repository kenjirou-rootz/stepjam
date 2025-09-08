# Backup System Design - Hierarchical Rotation Strategy

## Core Architecture: 3-Tier Backup Rotation (Latest 3 + Weekly 4 + 30-day Archive)

### 1. Primary Backup Manager (backup_manager.py)

**Purpose**: Sophisticated backup rotation system with 3-tier hierarchy for Claude configuration files

**Key Components**:
- Latest tier: 3 most recent backups (daily rotation)
- Weekly tier: 4 weekly snapshots (monthly rotation)
- Archive tier: Long-term storage with 30-day cleanup
- Automated promotion between tiers
- Space-efficient deduplication
- Integrity verification and corruption detection

**Core Implementation**:
```python
class BackupManager:
    def __init__(self):
        self.backup_root = Path("claude-backups/")
        self.latest_dir = self.backup_root / "latest"      # 3 most recent
        self.weekly_dir = self.backup_root / "weekly"      # 4 weekly snapshots
        self.archive_dir = self.backup_root / "archive"    # 30-day archive
        
    def create_backup(self, backup_type="automatic"):
        # Create backup → Place in latest/ → Rotate older backups
        # Weekly promotion → Archive promotion → Cleanup
```

### 2. 3-Tier Hierarchy Management

**Tier 1: Latest (最新3つ)**:
```
claude-backups/latest/
├── .claude_backup_20250826_120000.json    # Most recent
├── .claude_backup_20250825_180000.json    # Yesterday
└── .claude_backup_20250824_150000.json    # 2 days ago
```

**Tier 2: Weekly (週4つ)**:
```
claude-backups/weekly/
├── .claude_backup_week_35_2025.json       # Current week
├── .claude_backup_week_34_2025.json       # Last week  
├── .claude_backup_week_33_2025.json       # 2 weeks ago
└── .claude_backup_week_32_2025.json       # 3 weeks ago
```

**Tier 3: Archive (30日保存)**:
```
claude-backups/archive/
├── 2025-08/
│   ├── .claude_backup_20250801_monthly.json
│   └── .claude_backup_20250815_monthly.json
└── 2025-07/
    ├── .claude_backup_20250701_monthly.json
    └── .claude_backup_20250715_monthly.json
```

### 3. Automatic Rotation Logic

**Backup Creation & Rotation Flow**:
```python
def create_and_rotate_backup(self, source_file):
    # 1. Create new backup in latest/
    new_backup = self.create_timestamped_backup(source_file)
    
    # 2. Check latest/ count
    if len(self.get_latest_backups()) > 3:
        # 3. Promote oldest latest/ to weekly/
        oldest_latest = self.get_oldest_latest_backup()
        self.promote_to_weekly(oldest_latest)
        
        # 4. Check weekly/ count
        if len(self.get_weekly_backups()) > 4:
            # 5. Promote oldest weekly/ to archive/
            oldest_weekly = self.get_oldest_weekly_backup()
            self.promote_to_archive(oldest_weekly)
            
    # 6. Cleanup archive/ (30+ days old)
    self.cleanup_old_archives()
```

**Promotion Criteria**:
- Latest → Weekly: When latest/ exceeds 3 backups
- Weekly → Archive: When weekly/ exceeds 4 backups  
- Archive → Deletion: When files are 30+ days old
- Special events: Manual promotion for critical backups

### 4. Backup Types & Triggers

**Automatic Backup Types**:
- **Pre-cleanup**: Before any cleanup operation
- **Scheduled**: Weekly Friday 22:00 maintenance
- **Threshold**: When file size exceeds critical levels
- **Manual**: User-initiated backup requests

**Backup Metadata**:
```json
{
  "backup_id": "backup_20250826_120000",
  "timestamp": "2025-08-26T12:00:00Z",
  "trigger_type": "pre_cleanup",
  "original_size_bytes": 87552,
  "backup_size_bytes": 87552,
  "checksum_sha256": "a1b2c3d4...",
  "projects_count": 5,
  "mcp_servers_count": 6,
  "tier": "latest",
  "can_rollback": true,
  "retention_until": "2025-09-25T12:00:00Z"
}
```

### 5. Space Optimization & Deduplication

**Deduplication Strategy**:
```python
def check_duplicate_backup(self, new_backup_path):
    new_checksum = self.calculate_checksum(new_backup_path)
    
    # Check against recent backups
    for existing_backup in self.get_recent_backups(days=7):
        if self.get_backup_checksum(existing_backup) == new_checksum:
            # Skip duplicate backup
            return existing_backup
            
    return None
```

**Compression Options**:
- JSON minification for storage efficiency
- Optional gzip compression for archive tier
- Selective compression based on file size
- Metadata preservation during compression

### 6. Integrity & Verification System

**Backup Verification**:
```python
def verify_backup_integrity(self, backup_path):
    checks = {
        "file_exists": backup_path.exists(),
        "file_readable": self.can_read_file(backup_path),
        "json_valid": self.validate_json_structure(backup_path),
        "size_reasonable": self.check_reasonable_size(backup_path),
        "checksum_match": self.verify_stored_checksum(backup_path),
        "mcp_settings_intact": self.verify_mcp_settings(backup_path)
    }
    
    return all(checks.values()), checks
```

**Corruption Detection**:
- Periodic integrity checks (weekly)
- Checksum verification on access
- JSON structure validation
- Size consistency checks
- MCP settings preservation verification

### 7. Restoration & Rollback Interface

**Restoration Options**:
```python
def restore_from_backup(self, backup_identifier, restore_type="full"):
    restore_options = {
        "full": self.restore_complete_config,
        "selective": self.restore_specific_projects,
        "mcp_only": self.restore_mcp_settings_only,
        "merge": self.merge_with_current_config
    }
    
    return restore_options[restore_type](backup_identifier)
```

**Rollback Interface**:
```bash
# List available backups
$ python backup_manager.py --list
Latest Backups:
  1. 2025-08-26 12:00 - Pre-cleanup (87KB) [可能]
  2. 2025-08-25 18:00 - Scheduled (85KB) [可能] 
  3. 2025-08-24 15:00 - Manual (83KB) [可能]

Weekly Backups:
  1. Week 35 2025 - Weekly snapshot (89KB) [可能]
  2. Week 34 2025 - Weekly snapshot (91KB) [可能]

# Restore specific backup
$ python backup_manager.py --restore "backup_20250826_120000"
```

### 8. Integration Points

**Monitor Integration**:
```python
# file_monitor.py からの自動バックアップトリガー
if file_size > critical_threshold:
    backup_manager = BackupManager()
    backup_path = backup_manager.create_backup("critical_size")
    monitor.record_backup_event(backup_path)
```

**Executor Integration**:
```python
# cleanup_executor.py での実行前バックアップ
def execute_cleanup(self, cleanup_plan):
    # Create pre-cleanup backup
    backup_path = self.backup_manager.create_backup("pre_cleanup")
    cleanup_plan["backup_path"] = backup_path
    
    # Execute cleanup with rollback capability
    result = self.perform_cleanup_with_backup(cleanup_plan)
    
    return result
```

**Scheduler Integration**:
```python
# Weekly scheduled backups
def weekly_maintenance_backup(self):
    backup_manager = BackupManager()
    backup_path = backup_manager.create_backup("scheduled_weekly")
    
    # Promote to weekly tier immediately
    backup_manager.promote_to_weekly(backup_path, force=True)
```

### 9. Configuration & Customization

**Backup Configuration** (`backup_config.json`):
```json
{
  "rotation": {
    "latest_keep_count": 3,
    "weekly_keep_count": 4,
    "archive_retention_days": 30
  },
  "triggers": {
    "pre_cleanup": true,
    "scheduled_weekly": true,
    "file_size_threshold": true,
    "manual_request": true
  },
  "optimization": {
    "enable_deduplication": true,
    "compress_archives": false,
    "min_size_for_compression": 1048576
  },
  "verification": {
    "integrity_check_interval_days": 7,
    "checksum_verification": true,
    "json_structure_validation": true
  }
}
```

**Storage Limits**:
- Latest tier: Max 50MB total
- Weekly tier: Max 200MB total  
- Archive tier: Max 500MB total
- Auto-cleanup when limits exceeded

### 10. Monitoring & Analytics

**Backup Statistics**:
```json
{
  "total_backups": 12,
  "latest_tier": 3,
  "weekly_tier": 4, 
  "archive_tier": 5,
  "total_storage_mb": 157.3,
  "oldest_backup": "2025-07-26T12:00:00Z",
  "newest_backup": "2025-08-26T12:00:00Z",
  "successful_restorations": 0,
  "failed_restorations": 0,
  "integrity_check_passed": 12,
  "integrity_check_failed": 0
}
```

**Health Monitoring**:
- Backup creation success rate
- Storage space utilization  
- Integrity check results
- Restoration success rate
- Rotation efficiency metrics

### 11. Cleanup & Maintenance

**Automatic Cleanup Rules**:
```python
def cleanup_expired_backups(self):
    # Archive cleanup (30+ days)
    cutoff_date = datetime.now() - timedelta(days=30)
    
    for archive_file in self.archive_dir.glob("**/*.json"):
        if archive_file.stat().st_mtime < cutoff_date.timestamp():
            self.safe_delete_backup(archive_file)
            
    # Storage limit enforcement
    self.enforce_storage_limits()
    
    # Corrupted backup removal
    self.remove_corrupted_backups()
```

**Maintenance Operations**:
- Weekly integrity verification
- Monthly storage optimization
- Quarterly backup audit
- Annual retention policy review

### 12. Error Handling & Recovery

**Backup Failure Scenarios**:
- Insufficient disk space → Cleanup oldest archives
- Permission denied → Request elevated access
- Corruption during backup → Retry with verification
- Network interruption → Resume backup operation
- JSON parsing error → Create diagnostic backup

**Recovery Strategies**:
```python
backup_recovery_actions = {
    "disk_full": self.cleanup_old_archives_emergency,
    "permission_denied": self.request_backup_permissions,
    "corruption_detected": self.create_emergency_backup,
    "network_failure": self.resume_backup_operation,
    "json_error": self.create_diagnostic_backup
}
```

This backup system provides comprehensive, space-efficient backup management with intelligent rotation, deduplication, and robust recovery capabilities for the SuperClaude Framework.