# Monitoring Subsystem Design - Claude Configuration Bloat Prevention

## Core Architecture: 50KB Threshold Real-time Monitor

### 1. Primary Monitor (file_monitor.py)

**Purpose**: Real-time .claude.json file size monitoring with 50KB threshold detection

**Key Components**:
- FileSystemWatcher implementation using watchdog library
- Configurable threshold system (default: 50KB)
- History tracking with 30-day rotation
- Notification trigger system
- JSON file integrity validation

**Core Algorithm**:
```python
class ClaudeConfigMonitor:
    def __init__(self, config_path="~/.claude.json", threshold=50*1024):
        self.config_path = expanduser(config_path)
        self.threshold = threshold
        self.history_file = "monitoring-history/monitor_log.json"
        self.last_check = None
        
    def start_monitoring(self):
        # Watchdog FileSystemEventHandler implementation
        # Triggers on .claude.json modification events
        # Performs size check → threshold validation → notification
```

### 2. Size Analysis Engine

**Granular Monitoring**:
- Total file size tracking
- Project-specific history size analysis
- pastedContents blob size calculation
- mcpServers configuration size protection
- Growth rate analysis (KB/day)

**Critical Metrics**:
- Current file size vs threshold
- History section size percentage
- Project count impact analysis
- Growth velocity calculation
- Bloat risk assessment (Low/Medium/High/Critical)

### 3. Detection & Alerting Logic

**Threshold Levels**:
- 🟢 Normal: 0-30KB (Healthy)
- 🟡 Watch: 30-50KB (Monitor closely)
- 🔴 Alert: 50KB+ (Immediate notification)
- 🚨 Critical: 100KB+ (Urgent cleanup needed)

**Trigger Conditions**:
- File size exceeds 50KB threshold
- Growth rate >10KB/hour detected
- History entries >20 per project
- Base64 media content detected

### 4. Monitoring Data Storage

**History Schema**:
```json
{
  "timestamp": "2025-08-26T12:00:00Z",
  "file_size_bytes": 51200,
  "threshold_exceeded": true,
  "projects_analyzed": {
    "stepjam": {
      "history_entries": 15,
      "history_size_bytes": 30720,
      "has_media": true
    }
  },
  "risk_level": "high",
  "notification_sent": true
}
```

**Storage Strategy**:
- JSON-based monitoring log
- Daily aggregation files
- 30-day automatic cleanup
- Size-based rotation (max 1MB per log)

### 5. Integration Points

**Notification Trigger**:
- Calls macos_notifier.py with alert payload
- Includes file size, project details, recommended actions
- Audio alert capability for critical thresholds

**Report Generation**:
- Generates markdown reports in superclaude-reports/
- Includes trend analysis and recommendations
- Links to backup manager for cleanup options

**Error Handling**:
- File access permission checks
- JSON parsing error recovery
- Watchdog service failure recovery
- Graceful degradation to polling mode

### 6. Configuration Options

**Customizable Parameters**:
```json
{
  "monitoring": {
    "threshold_kb": 50,
    "check_interval_seconds": 5,
    "history_retention_days": 30,
    "enable_audio_alerts": true,
    "risk_assessment_enabled": true,
    "growth_rate_monitoring": true
  }
}
```

**Performance Optimizations**:
- Debounced file modification events (avoid rapid-fire alerts)
- Cached file size comparisons
- Lazy JSON parsing (only when size changes)
- Background thread monitoring (non-blocking)

### 7. Output & Reporting

**Real-time Status**:
- Current file size display
- Time since last check
- Active project count
- Threshold status indicator

**Alert Payload Format**:
```json
{
  "alert_type": "threshold_exceeded",
  "current_size": 51200,
  "threshold": 50000,
  "projects_affected": ["stepjam", "hayashikenjirou"],
  "recommended_action": "cleanup_history",
  "severity": "medium",
  "timestamp": "2025-08-26T12:00:00Z"
}
```

This monitoring subsystem provides the foundation for proactive bloat prevention with real-time detection and automated alerting capabilities.