# Notification Subsystem Design - macOS Audio Alert System

## Core Architecture: macOS Desktop Notification with Audio Alerts

### 1. Primary Notifier (macos_notifier.py)

**Purpose**: macOS native notification system with audio alerts for Claude configuration bloat detection

**Key Components**:
- macOS osascript integration for native notifications
- Audio alert system with severity-based sounds
- Persistent notification display with action buttons
- Notification history and frequency control
- Integration with monitoring subsystem

**Core Implementation**:
```python
class MacOSNotifier:
    def __init__(self):
        self.app_name = "SuperClaude Bloat Prevention"
        self.notification_history = []
        self.audio_enabled = True
        self.frequency_limit = 300  # seconds between notifications
        
    def send_threshold_alert(self, alert_data):
        # Native macOS notification with audio alert
        # Persistent display with action buttons
        # Frequency control to prevent spam
```

### 2. Notification Types & Severity Levels

**Alert Categories**:
- 🔴 **Threshold Exceeded** (50KB+): Immediate cleanup recommendation
- 🚨 **Critical Size** (100KB+): Urgent action required
- 📈 **Growth Rate Alert** (>10KB/hour): Rapid bloat detection
- ⚠️ **Maintenance Reminder** (Weekly): Scheduled cleanup notification

**Audio Alert Mapping**:
- 🔔 Normal: System default sound
- ⚠️ Medium: Attention sound (Glass)
- 🚨 High: Alert sound (Sosumi)
- 🆘 Critical: Urgent sound (Funk) + repeat

### 3. Notification Content & Actions

**Alert Message Format**:
```
SuperClaude Bloat Detection
━━━━━━━━━━━━━━━━━━━━━━━━━━━━
⚠️ .claude.json size: 51.2KB (>50KB)
📁 Projects affected: stepjam, hayashikenjirou
📊 Risk level: HIGH
💾 History entries: 25 (contains media)

Recommended: Cleanup history data
```

**Action Buttons**:
- "🔧 Start Cleanup" → Launch cleanup_executor.py
- "📊 View Details" → Open detailed analysis report
- "⏰ Remind Later" → Snooze for 1 hour
- "❌ Dismiss" → Mark as acknowledged

### 4. Notification Display Control

**Frequency Management**:
- Maximum 1 notification per 5 minutes per alert type
- Escalation after 24 hours without action
- Silent hours: 23:00-08:00 (configurable)
- Weekend mode: Reduced frequency

**Persistence Settings**:
- Critical alerts: Stay until dismissed
- High alerts: 30-minute auto-dismiss
- Medium alerts: 15-minute auto-dismiss
- Maintenance: 5-minute auto-dismiss

### 5. Audio System Architecture

**Sound Selection Logic**:
```python
audio_mapping = {
    "normal": "default",
    "low": "Glass",      # Gentle notification
    "medium": "Tink",    # Attention getter
    "high": "Sosumi",    # Urgent alert
    "critical": "Funk"   # Immediate action
}
```

**Audio Features**:
- System volume respect
- Do Not Disturb mode detection
- Custom sound file support
- Repeat alerts for critical issues
- Mute during screen sharing/presentations

### 6. Integration Points

**Monitor Integration**:
- Receives alert_data from file_monitor.py
- Processes risk level and project information
- Determines appropriate notification type and urgency

**Executor Integration**:
- Action buttons trigger cleanup_executor.py
- Passes context data for targeted cleanup
- Provides user confirmation interface

**Report Integration**:
- Links to generated markdown reports
- Opens superclaude-reports in Finder
- Displays trend analysis in notification

### 7. Configuration & Customization

**User Settings**:
```json
{
  "notifications": {
    "enabled": true,
    "audio_alerts": true,
    "silent_hours": {
      "start": "23:00",
      "end": "08:00"
    },
    "frequency_limit_seconds": 300,
    "weekend_mode": false,
    "do_not_disturb_respect": true,
    "custom_sounds": {
      "critical": "/path/to/urgent.aiff"
    }
  }
}
```

**Notification Templates**:
- Customizable message formats
- Multi-language support (Japanese/English)
- Icon and branding customization
- Action button text modification

### 8. Error Handling & Fallbacks

**Failure Recovery**:
- osascript failure → Terminal notification
- Audio failure → Visual-only mode
- Permission denied → Console logging
- System busy → Queue for retry

**Graceful Degradation**:
- macOS < 10.14 → Simple dialog boxes
- Terminal-only environment → Text notifications
- SSH session → Log file notifications
- System overloaded → Minimal alerts

### 9. History & Analytics

**Notification Tracking**:
```json
{
  "timestamp": "2025-08-26T12:00:00Z",
  "alert_type": "threshold_exceeded",
  "severity": "high",
  "user_action": "cleanup_started",
  "response_time_seconds": 120,
  "dismissed": false
}
```

**Analytics Features**:
- Notification response rates
- Most effective alert types
- User interaction patterns
- Cleanup success correlation

### 10. Testing & Validation

**Test Scenarios**:
- Threshold exceeded simulation
- Audio system testing
- Action button functionality
- Frequency limiting validation
- Do Not Disturb mode testing

**Mock Data Generation**:
- Simulated alert conditions
- Various risk level testing
- Edge case scenario testing
- Performance under load

This notification subsystem provides immediate, actionable alerts with native macOS integration and intelligent frequency control to prevent alert fatigue while ensuring critical issues get attention.