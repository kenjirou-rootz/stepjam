// @ts-check
const { defineConfig, devices } = require('@playwright/test');

/**
 * Playwright Configuration for STEPJAM NX Tokyo Height Overflow Analysis
 * Ultra Think Investigation Setup
 */
module.exports = defineConfig({
  testDir: './',
  timeout: 60000, // 60 seconds per test (for comprehensive analysis)
  expect: {
    timeout: 10000 // 10 seconds for assertions
  },
  
  // Run tests serially for consistent investigation results
  fullyParallel: false,
  workers: 1,
  
  // Retry configuration for stability
  retries: process.env.CI ? 2 : 1,
  
  // Reporter configuration for comprehensive output
  reporter: [
    ['html', { outputFolder: './test-results/html-report' }],
    ['junit', { outputFile: './test-results/results.xml' }],
    ['list']
  ],
  
  // Global test configuration
  use: {
    // Base URL for the investigation
    baseURL: 'http://stepjam.local',
    
    // Browser context options
    trace: 'on-first-retry',
    screenshot: 'only-on-failure',
    video: 'retain-on-failure',
    
    // Viewport (will be overridden in tests for multi-viewport analysis)
    viewport: { width: 1280, height: 720 },
    
    // Ignore HTTPS errors for local development
    ignoreHTTPSErrors: true,
    
    // Wait for network to be idle for accurate measurements
    waitForNetworkIdle: true,
    
    // Additional context options for investigation
    extraHTTPHeaders: {
      'User-Agent': 'STEPJAM-NX-Height-Analysis-Bot/1.0.0'
    }
  },

  // Project configuration for comprehensive browser testing
  projects: [
    {
      name: 'nx-height-analysis-chromium',
      use: { ...devices['Desktop Chrome'] },
    },
    
    // Optionally enable other browsers for cross-browser validation
    // {
    //   name: 'nx-height-analysis-firefox',
    //   use: { ...devices['Desktop Firefox'] },
    // },
    // {
    //   name: 'nx-height-analysis-webkit',
    //   use: { ...devices['Desktop Safari'] },
    // },
  ],

  // Output directory for test artifacts
  outputDir: './test-results/',
  
  // Global setup and teardown
  globalSetup: require.resolve('./test-setup.js'),
  
  // Test match patterns
  testMatch: ['nx-tokyo-height-overflow-analysis.js'],
  
  // Web server configuration (if needed)
  webServer: {
    command: 'echo "Using Local by Flywheel server at http://stepjam.local"',
    url: 'http://stepjam.local',
    reuseExistingServer: true,
    timeout: 30000
  }
});