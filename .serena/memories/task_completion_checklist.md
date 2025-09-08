# Task Completion Checklist for STEPJAM

## When Completing a Development Task

### 1. Code Review
- [ ] Check that all code follows WordPress coding standards
- [ ] Verify proper escaping of output
- [ ] Ensure no syntax errors in PHP files
- [ ] Check for console errors in browser

### 2. Testing
- [ ] Test functionality in Local Sites environment
- [ ] Check responsive design on different screen sizes
- [ ] Verify cross-browser compatibility
- [ ] Test with WordPress Debug mode enabled

### 3. Backup
- [ ] Create backup of modified files before changes
- [ ] Use timestamp format: `filename.backup.YYYYMMDD_HHMMSS`
- [ ] Store backups in appropriate location

### 4. Documentation
- [ ] Update code comments if needed
- [ ] Document any new functions or features
- [ ] Note any dependencies or requirements

### 5. Final Checks
- [ ] Remove any debug code or console.log statements
- [ ] Check that no sensitive information is exposed
- [ ] Verify file permissions are correct
- [ ] Ensure all assets are properly enqueued

## Important Reminders
- Since this is a Local Sites project, no deployment commands are needed
- PHP linting/formatting tools are not configured - manual review required
- Always work within the theme directory structure
- Respect the project's file organization patterns