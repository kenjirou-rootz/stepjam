const { defineConfig, devices } = require('@playwright/test');

module.exports = defineConfig({
  testDir: './',
  testMatch: '**/css-debug-test-new.js',
  
  globalTimeout: 120000,
  timeout: 30000,
  expect: { timeout: 5000 },

  use: {
    baseURL: 'http://stepjam.local',
    headless: true,
    screenshot: 'only-on-failure',
    ignoreHTTPSErrors: true,
    locale: 'ja-JP'
  },

  projects: [{ name: 'chromium', use: { ...devices['Desktop Chrome'] } }],
  reporter: [['list']],
  outputDir: 'test-results/',
  workers: 1,
  retries: 0,
});