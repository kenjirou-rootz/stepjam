# Scheduler System Design - Cron-based Weekly Automation

## Core Architecture: Weekly Friday 22:00 Automatic Maintenance System

### 1. Primary Scheduler (cron_manager.py)

**Purpose**: Automated weekly maintenance scheduling with cron integration for SuperClaude bloat prevention

**Key Components**:
- Cron job management and installation
- Weekly Friday 22:00 scheduled execution
- Pre-execution system health checks
- Maintenance task orchestration
- Post-execution reporting and notifications
- Failure recovery and retry mechanisms

**Core Implementation**:
```python
class CronScheduler:
    def __init__(self):
        self.schedule_time = "0 22 * * 5"  # Friday 22:00
        self.maintenance_script = "superclaude_weekly_maintenance.py"
        self.log_rotation = True
        self.retry_on_failure = True
        
    def install_cron_job(self):
        # Install cron job for weekly maintenance
        # Handle user permissions and validation
        # Create maintenance wrapper script
```

### 2. Weekly Maintenance Task Orchestration

**Maintenance Task Sequence**:
```python
WEEKLY_MAINTENANCE_TASKS = [
    {
        "name": "system_health_check",
        "function": "check_system_health",
        "priority": "CRITICAL",
        "timeout_minutes": 5,
        "retry_count": 3
    },
    {
        "name": "mcp_protection_verification", 
        "function": "verify_mcp_protection_status",
        "priority": "CRITICAL",
        "timeout_minutes": 2,
        "retry_count": 2
    },
    {
        "name": "configuration_analysis",
        "function": "analyze_claude_configuration",
        "priority": "HIGH",
        "timeout_minutes": 10,
        "retry_count": 1
    },
    {
        "name": "preventive_backup_creation",
        "function": "create_weekly_backup",
        "priority": "HIGH", 
        "timeout_minutes": 15,
        "retry_count": 2
    },
    {
        "name": "conditional_cleanup_execution",
        "function": "execute_conditional_cleanup",
        "priority": "MEDIUM",
        "timeout_minutes": 30,
        "retry_count": 1
    },
    {
        "name": "backup_rotation_maintenance",
        "function": "rotate_and_cleanup_backups",
        "priority": "MEDIUM",
        "timeout_minutes": 10,
        "retry_count": 1
    },
    {
        "name": "system_optimization",
        "function": "optimize_system_performance",
        "priority": "LOW",
        "timeout_minutes": 20,
        "retry_count": 0
    },
    {
        "name": "report_generation",
        "function": "generate_maintenance_report",
        "priority": "HIGH",
        "timeout_minutes": 5,
        "retry_count": 1
    }
]
```

### 3. Intelligent Execution Conditions

**Conditional Cleanup Logic**:
```python
def should_execute_cleanup(system_analysis):
    cleanup_triggers = {
        "file_size_threshold": system_analysis["current_size_kb"] > 35,
        "history_entries_excessive": system_analysis["total_history_entries"] > 15,
        "growth_rate_concerning": system_analysis["growth_rate_kb_per_day"] > 2,
        "media_content_present": system_analysis["has_media_content"],
        "last_cleanup_old": system_analysis["days_since_last_cleanup"] > 14
    }
    
    # Execute if 2+ triggers are active
    active_triggers = sum(cleanup_triggers.values())
    
    execution_decision = {
        "should_cleanup": active_triggers >= 2,
        "active_triggers": [k for k, v in cleanup_triggers.items() if v],
        "trigger_count": active_triggers,
        "confidence_level": min(active_triggers * 25, 100)  # 25% per trigger
    }
    
    return execution_decision
```

**Pre-execution Health Checks**:
```python
def perform_system_health_check():
    health_checks = {
        "claude_config_accessible": check_config_file_access(),
        "backup_directory_writable": check_backup_directory(),
        "mcp_servers_responsive": check_mcp_server_health(),
        "disk_space_sufficient": check_available_disk_space(min_mb=100),
        "system_load_acceptable": check_system_load(max_load=0.8),
        "no_active_claude_processes": check_active_claude_processes()
    }
    
    health_score = sum(health_checks.values()) / len(health_checks) * 100
    
    return {
        "healthy": health_score >= 80,
        "health_score": health_score,
        "failed_checks": [k for k, v in health_checks.items() if not v],
        "passed_checks": [k for k, v in health_checks.items() if v]
    }
```

### 4. Cron Job Management

**Cron Installation & Management**:
```python
class CronJobManager:
    def __init__(self):
        self.cron_comment = "# SuperClaude Weekly Maintenance"
        self.job_command = self.build_job_command()
        self.schedule = "0 22 * * 5"  # Friday 22:00
        
    def install_cron_job(self):
        """Install or update cron job for weekly maintenance"""
        try:
            # Get current crontab
            current_crontab = subprocess.run(['crontab', '-l'], 
                                           capture_output=True, text=True)
            
            # Remove existing SuperClaude jobs
            crontab_lines = []
            if current_crontab.returncode == 0:
                lines = current_crontab.stdout.strip().split('\n')
                crontab_lines = [line for line in lines 
                               if self.cron_comment not in line]
            
            # Add new job
            new_job = f"{self.schedule} {self.job_command} {self.cron_comment}"
            crontab_lines.append(new_job)
            
            # Install updated crontab
            new_crontab = '\n'.join(crontab_lines) + '\n'
            process = subprocess.run(['crontab', '-'], 
                                   input=new_crontab, text=True)
            
            if process.returncode == 0:
                self.logger.info(f"Cron job installed: {new_job}")
                return True
            else:
                self.logger.error("Failed to install cron job")
                return False
                
        except Exception as e:
            self.logger.error(f"Error installing cron job: {e}")
            return False
            
    def build_job_command(self):
        """Build complete cron job command with environment and logging"""
        script_path = Path(__file__).parent / "superclaude_weekly_maintenance.py"
        log_path = Path(__file__).parent.parent / "logs" / "weekly_maintenance.log"
        
        # Environment variables for cron execution
        env_vars = [
            "PATH=/usr/local/bin:/usr/bin:/bin",
            "HOME=" + os.path.expanduser("~"),
            "USER=" + os.getenv("USER", "unknown")
        ]
        
        command_parts = [
            " ".join(env_vars),
            sys.executable,  # Python executable
            str(script_path),
            "--automated",
            f">> {log_path} 2>&1"
        ]
        
        return " ".join(command_parts)
        
    def remove_cron_job(self):
        """Remove SuperClaude cron job"""
        try:
            current_crontab = subprocess.run(['crontab', '-l'], 
                                           capture_output=True, text=True)
            
            if current_crontab.returncode == 0:
                lines = current_crontab.stdout.strip().split('\n')
                filtered_lines = [line for line in lines 
                                if self.cron_comment not in line]
                
                new_crontab = '\n'.join(filtered_lines) + '\n'
                process = subprocess.run(['crontab', '-'], 
                                       input=new_crontab, text=True)
                
                if process.returncode == 0:
                    self.logger.info("SuperClaude cron job removed")
                    return True
                    
        except Exception as e:
            self.logger.error(f"Error removing cron job: {e}")
            
        return False
```

### 5. Weekly Maintenance Execution Engine

**Main Maintenance Orchestrator**:
```python
class WeeklyMaintenanceExecutor:
    def __init__(self):
        self.execution_id = str(uuid.uuid4())
        self.start_time = datetime.now()
        self.task_results = {}
        self.overall_success = True
        
    def execute_weekly_maintenance(self):
        """Execute complete weekly maintenance sequence"""
        maintenance_log = {
            "execution_id": self.execution_id,
            "start_time": self.start_time.isoformat(),
            "scheduled": True,
            "tasks_executed": [],
            "task_results": {},
            "overall_success": True,
            "total_duration_seconds": 0
        }
        
        try:
            self.logger.info(f"Starting weekly maintenance: {self.execution_id}")
            
            # Execute each maintenance task
            for task_config in WEEKLY_MAINTENANCE_TASKS:
                task_result = self.execute_maintenance_task(task_config)
                maintenance_log["tasks_executed"].append(task_config["name"])
                maintenance_log["task_results"][task_config["name"]] = task_result
                
                # Handle critical task failures
                if not task_result["success"] and task_config["priority"] == "CRITICAL":
                    maintenance_log["overall_success"] = False
                    self.overall_success = False
                    
                    if task_config.get("abort_on_failure", False):
                        self.logger.error(f"Critical task failed, aborting: {task_config['name']}")
                        break
                        
        except Exception as e:
            self.logger.error(f"Weekly maintenance execution failed: {e}")
            maintenance_log["overall_success"] = False
            maintenance_log["error"] = str(e)
            
        finally:
            end_time = datetime.now()
            maintenance_log["end_time"] = end_time.isoformat()
            maintenance_log["total_duration_seconds"] = (end_time - self.start_time).total_seconds()
            
            # Generate and send completion report
            self.generate_maintenance_report(maintenance_log)
            self.send_completion_notification(maintenance_log)
            
        return maintenance_log
        
    def execute_maintenance_task(self, task_config):
        """Execute individual maintenance task with timeout and retry"""
        task_name = task_config["name"]
        task_function = task_config["function"]
        timeout_seconds = task_config.get("timeout_minutes", 10) * 60
        max_retries = task_config.get("retry_count", 0)
        
        task_result = {
            "task_name": task_name,
            "success": False,
            "attempts": 0,
            "duration_seconds": 0,
            "output": None,
            "error": None
        }
        
        for attempt in range(max_retries + 1):
            task_result["attempts"] = attempt + 1
            start_time = time.time()
            
            try:
                self.logger.info(f"Executing {task_name} (attempt {attempt + 1})")
                
                # Get task function
                task_func = getattr(self, task_function, None)
                if not task_func:
                    raise AttributeError(f"Task function not found: {task_function}")
                
                # Execute with timeout
                result = self.execute_with_timeout(task_func, timeout_seconds)
                
                task_result["success"] = True
                task_result["output"] = result
                task_result["duration_seconds"] = time.time() - start_time
                
                self.logger.info(f"Task {task_name} completed successfully")
                break
                
            except Exception as e:
                task_result["error"] = str(e)
                task_result["duration_seconds"] = time.time() - start_time
                
                self.logger.error(f"Task {task_name} failed (attempt {attempt + 1}): {e}")
                
                if attempt < max_retries:
                    time.sleep(2 ** attempt)  # Exponential backoff
                    
        return task_result
```

### 6. Maintenance Task Implementations

**System Health Check Task**:
```python
def check_system_health(self):
    """Comprehensive system health verification"""
    health_report = {
        "timestamp": datetime.now().isoformat(),
        "claude_config_status": self.check_claude_config(),
        "mcp_protection_status": self.check_mcp_protection(),
        "backup_system_status": self.check_backup_system(),
        "disk_usage": self.check_disk_usage(),
        "system_resources": self.check_system_resources()
    }
    
    health_score = self.calculate_health_score(health_report)
    health_report["overall_health_score"] = health_score
    health_report["healthy"] = health_score >= 80
    
    return health_report
```

**Configuration Analysis Task**:
```python
def analyze_claude_configuration(self):
    """Analyze current Claude configuration for maintenance needs"""
    from ..monitors.file_monitor import ClaudeConfigMonitor
    
    monitor = ClaudeConfigMonitor()
    file_size, _ = monitor.check_file_size()
    analysis = monitor.analyze_config_content()
    
    analysis_report = {
        "timestamp": datetime.now().isoformat(),
        "current_size_kb": file_size / 1024 if file_size else 0,
        "size_threshold_exceeded": file_size > 50 * 1024 if file_size else False,
        "projects_analyzed": analysis.get("projects_analyzed", {}),
        "total_history_entries": analysis.get("total_history_entries", 0),
        "has_media_content": analysis.get("has_media_content", False),
        "cleanup_recommendation": self.generate_cleanup_recommendation(analysis)
    }
    
    return analysis_report
```

**Conditional Cleanup Execution Task**:
```python
def execute_conditional_cleanup(self):
    """Execute cleanup only if conditions are met"""
    from ..executors.cleanup_executor import CleanupExecutor
    
    # Analyze current state
    analysis = self.analyze_claude_configuration()
    cleanup_decision = self.should_execute_cleanup(analysis)
    
    cleanup_result = {
        "timestamp": datetime.now().isoformat(),
        "cleanup_executed": False,
        "cleanup_decision": cleanup_decision,
        "cleanup_results": None
    }
    
    if cleanup_decision["should_cleanup"]:
        self.logger.info(f"Executing conditional cleanup: {cleanup_decision['active_triggers']}")
        
        try:
            executor = CleanupExecutor()
            
            # Create backup before cleanup
            backup_result = self.create_weekly_backup()
            if not backup_result.get("success", False):
                raise Exception("Failed to create pre-cleanup backup")
            
            # Load and analyze config
            config = executor.load_config()
            cleanup_plan = executor.analyze_cleanup_targets(config)
            
            # Execute automated cleanup (no user confirmation in scheduled mode)
            if cleanup_plan["projects_to_clean"]:
                execution_result = executor.execute_cleanup(cleanup_plan)
                cleanup_result["cleanup_executed"] = True
                cleanup_result["cleanup_results"] = execution_result
                
                self.logger.info(f"Scheduled cleanup completed: {execution_result['entries_removed']} entries removed")
            else:
                self.logger.info("No cleanup needed based on analysis")
                
        except Exception as e:
            self.logger.error(f"Conditional cleanup failed: {e}")
            cleanup_result["cleanup_error"] = str(e)
    else:
        self.logger.info(f"Skipping cleanup: insufficient triggers ({cleanup_decision['trigger_count']}/2)")
    
    return cleanup_result
```

### 7. Notification Integration

**Maintenance Completion Notification**:
```python
def send_completion_notification(self, maintenance_log):
    """Send maintenance completion notification"""
    from ..notifiers.macos_notifier import MacOSNotifier
    
    notifier = MacOSNotifier()
    
    # Prepare notification data
    success_count = sum(1 for result in maintenance_log["task_results"].values() 
                       if result["success"])
    total_tasks = len(maintenance_log["task_results"])
    duration_minutes = maintenance_log["total_duration_seconds"] / 60
    
    notification_data = {
        "notification_type": "maintenance_completed",
        "overall_success": maintenance_log["overall_success"],
        "tasks_completed": success_count,
        "total_tasks": total_tasks,
        "duration_minutes": round(duration_minutes, 1),
        "cleanup_executed": any(
            "cleanup" in task_name and result.get("success", False)
            for task_name, result in maintenance_log["task_results"].items()
        )
    }
    
    # Send notification
    try:
        notifier.send_maintenance_completion_notification(notification_data)
        self.logger.info("Maintenance completion notification sent")
    except Exception as e:
        self.logger.error(f"Failed to send completion notification: {e}")
```

### 8. Scheduler Configuration Management

**Scheduler Configuration** (`scheduler_config.json`):
```json
{
  "schedule": {
    "enabled": true,
    "cron_schedule": "0 22 * * 5",
    "timezone": "system",
    "maintenance_window_hours": 2
  },
  "execution": {
    "max_total_duration_minutes": 60,
    "task_timeout_minutes": 30,
    "retry_failed_tasks": true,
    "abort_on_critical_failure": true
  },
  "conditions": {
    "minimum_triggers_for_cleanup": 2,
    "skip_if_system_load_above": 0.8,
    "skip_if_disk_space_below_mb": 100,
    "skip_if_claude_processes_active": true
  },
  "notifications": {
    "send_completion_notification": true,
    "send_failure_notification": true,
    "notification_retry_count": 2
  },
  "logging": {
    "log_level": "INFO",
    "rotate_logs": true,
    "keep_log_days": 30
  }
}
```

### 9. Error Handling & Recovery

**Failure Recovery Mechanisms**:
```python
def handle_maintenance_failure(self, failure_info):
    """Handle maintenance execution failures"""
    recovery_actions = {
        "system_health_failure": self.create_diagnostic_report,
        "mcp_protection_failure": self.emergency_mcp_recovery,
        "cleanup_failure": self.rollback_recent_changes,
        "backup_failure": self.verify_existing_backups,
        "notification_failure": self.log_completion_status
    }
    
    for failure_type, recovery_action in recovery_actions.items():
        if failure_type in failure_info.get("failed_tasks", []):
            try:
                recovery_result = recovery_action(failure_info)
                self.logger.info(f"Recovery action completed: {failure_type}")
            except Exception as e:
                self.logger.error(f"Recovery action failed for {failure_type}: {e}")
```

### 10. Monitoring & Analytics

**Maintenance History Tracking**:
```python
def track_maintenance_history(self, maintenance_log):
    """Track maintenance execution history"""
    history_file = self.system_root / "reports" / "maintenance_history.json"
    
    try:
        # Load existing history
        history = []
        if history_file.exists():
            with open(history_file, 'r', encoding='utf-8') as f:
                history = json.load(f)
        
        # Add current maintenance record
        maintenance_record = {
            "execution_id": maintenance_log["execution_id"],
            "timestamp": maintenance_log["start_time"],
            "success": maintenance_log["overall_success"],
            "duration_seconds": maintenance_log["total_duration_seconds"],
            "tasks_summary": {
                task_name: result["success"]
                for task_name, result in maintenance_log["task_results"].items()
            },
            "cleanup_executed": any(
                "cleanup" in task_name and result.get("success", False)
                for task_name, result in maintenance_log["task_results"].items()
            )
        }
        
        history.append(maintenance_record)
        
        # Keep only last 52 records (1 year of weekly maintenance)
        if len(history) > 52:
            history = history[-52:]
        
        # Save updated history
        with open(history_file, 'w', encoding='utf-8') as f:
            json.dump(history, f, indent=2, ensure_ascii=False)
            
    except Exception as e:
        self.logger.error(f"Error tracking maintenance history: {e}")
```

This scheduler system provides comprehensive automated weekly maintenance with intelligent execution conditions, robust error handling, and complete integration with all other SuperClaude Framework subsystems.