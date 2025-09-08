#!/bin/bash

# STEPJAM NX Tokyo Height Overflow Investigation Runner
# Ultra Think 6-Phase Analysis Automation

echo "🚀 STEPJAM NX Tokyo Height Overflow Investigation"
echo "================================================"
echo "Ultra Think 6-Phase Analysis Starting..."
echo ""

# Check if Node.js is available
if ! command -v node &> /dev/null; then
    echo "❌ Node.js is required but not installed."
    echo "Please install Node.js from https://nodejs.org/"
    exit 1
fi

# Check if npm is available
if ! command -v npm &> /dev/null; then
    echo "❌ npm is required but not installed."
    exit 1
fi

echo "✅ Node.js and npm found"

# Install dependencies if not already installed
if [ ! -d "node_modules" ]; then
    echo "📦 Installing Playwright dependencies..."
    npm install
    
    echo "🔧 Installing Playwright browsers..."
    npx playwright install
    
    echo "✅ Dependencies installed"
else
    echo "✅ Dependencies already installed"
fi

# Check if Local by Flywheel server is running
echo "🔍 Checking if STEPJAM local server is accessible..."
if curl -s --head http://stepjam.local | head -n 1 | grep -q "200 OK"; then
    echo "✅ Local server is running at http://stepjam.local"
else
    echo "⚠️  Warning: Local server may not be running at http://stepjam.local"
    echo "Please ensure Local by Flywheel is running with STEPJAM site active"
    echo ""
    read -p "Continue anyway? (y/N): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        echo "Investigation cancelled."
        exit 1
    fi
fi

echo ""
echo "🔍 Starting Ultra Think Investigation..."
echo "Target: http://stepjam.local/nx-tokyo/stepjam-tokyo-2025-summer-nx-event/"
echo ""
echo "📋 Investigation Phases:"
echo "  Phase 1: Initial height measurement and overflow detection setup"
echo "  Phase 2: Multi-viewport testing (375px, 768px, 1024px, 1920px)"
echo "  Phase 3: Parent-child height relationship analysis"
echo "  Phase 4: Overflow detection using computed styles and scroll measurements"
echo "  Phase 5: Content variation impact assessment"
echo "  Phase 6: Comprehensive results summary and recommendations"
echo ""

# Run the Playwright investigation
if [ "$1" == "--debug" ]; then
    echo "🐛 Running in debug mode..."
    npx playwright test nx-tokyo-height-overflow-analysis.js --debug
elif [ "$1" == "--headed" ]; then
    echo "👁️  Running in headed mode (visible browser)..."
    npx playwright test nx-tokyo-height-overflow-analysis.js --headed
else
    echo "🔍 Running in headless mode..."
    npx playwright test nx-tokyo-height-overflow-analysis.js
fi

echo ""
echo "📊 Investigation Results:"
echo "  Screenshots: ./screenshots/"
echo "  Test Results: ./test-results/"
echo "  HTML Report: ./test-results/html-report/index.html"
echo "  Investigation Data: ./reports/"
echo ""

# Check if HTML report exists and offer to open it
if [ -f "test-results/html-report/index.html" ]; then
    echo "📈 HTML report generated successfully!"
    if command -v open &> /dev/null; then
        read -p "Open HTML report in browser? (y/N): " -n 1 -r
        echo
        if [[ $REPLY =~ ^[Yy]$ ]]; then
            open test-results/html-report/index.html
        fi
    fi
fi

echo "✅ Ultra Think Investigation Complete!"
echo "Check the generated files for comprehensive analysis results."