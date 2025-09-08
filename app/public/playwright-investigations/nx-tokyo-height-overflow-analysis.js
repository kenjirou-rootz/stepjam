const { test, expect } = require('@playwright/test');

/**
 * STEPJAM NX Tokyo - Ultra Think Height Overflow Analysis
 * 6-Phase Systematic Investigation
 * 
 * Target: Parent-child container height relationships
 * Focus: .nx-content-block → .nx-block-title + .nx-block-content
 */

test.describe('NX Tokyo Height Overflow Investigation - Ultra Think Analysis', () => {
  const targetUrl = 'http://stepjam.local/nx-tokyo/stepjam-tokyo-2025-summer-nx-event/';
  const viewports = [
    { name: 'Mobile', width: 375, height: 667 },
    { name: 'Tablet', width: 768, height: 1024 },
    { name: 'Desktop', width: 1024, height: 768 },
    { name: 'Large Desktop', width: 1920, height: 1080 }
  ];

  let investigationResults = {
    phases: {},
    overflowIssues: [],
    recommendations: [],
    evidence: {}
  };

  test('Phase 1: Initial Height Measurement and Overflow Detection Setup', async ({ page }) => {
    console.log('🔍 PHASE 1: Initial Setup and Container Detection');
    
    // Navigate and wait for full load
    await page.goto(targetUrl, { waitUntil: 'networkidle' });
    
    // Wait for any animations or dynamic content
    await page.waitForTimeout(2000);
    
    // Detect all nx-content-block containers
    const containers = await page.$$('.nx-content-block');
    console.log(`✅ Found ${containers.length} .nx-content-block containers`);
    
    // Initialize measurement functions
    await page.addScriptTag({
      content: `
        window.measureContainerHeights = function() {
          const containers = document.querySelectorAll('.nx-content-block');
          const measurements = [];
          
          containers.forEach((container, index) => {
            const rect = container.getBoundingClientRect();
            const computedStyle = window.getComputedStyle(container);
            
            const titleElement = container.querySelector('.nx-block-title');
            const contentElement = container.querySelector('.nx-block-content');
            
            const measurement = {
              index,
              container: {
                clientHeight: container.clientHeight,
                scrollHeight: container.scrollHeight,
                offsetHeight: container.offsetHeight,
                boundingRect: rect,
                computedHeight: parseFloat(computedStyle.height),
                minHeight: computedStyle.minHeight,
                maxHeight: computedStyle.maxHeight,
                overflow: computedStyle.overflow,
                overflowY: computedStyle.overflowY,
                display: computedStyle.display,
                gridTemplateRows: computedStyle.gridTemplateRows,
                hasOverflow: container.scrollHeight > container.clientHeight
              },
              title: titleElement ? {
                clientHeight: titleElement.clientHeight,
                scrollHeight: titleElement.scrollHeight,
                offsetHeight: titleElement.offsetHeight,
                boundingRect: titleElement.getBoundingClientRect(),
                hasOverflow: titleElement.scrollHeight > titleElement.clientHeight
              } : null,
              content: contentElement ? {
                clientHeight: contentElement.clientHeight,
                scrollHeight: contentElement.scrollHeight,
                offsetHeight: contentElement.offsetHeight,
                boundingRect: contentElement.getBoundingClientRect(),
                hasOverflow: contentElement.scrollHeight > contentElement.clientHeight
              } : null
            };
            
            measurements.push(measurement);
          });
          
          return measurements;
        };
        
        window.detectHeightRelationships = function() {
          const containers = document.querySelectorAll('.nx-content-block');
          const relationships = [];
          
          containers.forEach((container, index) => {
            const titleElement = container.querySelector('.nx-block-title');
            const contentElement = container.querySelector('.nx-block-content');
            
            const containerHeight = container.clientHeight;
            const titleHeight = titleElement ? titleElement.offsetHeight : 0;
            const contentHeight = contentElement ? contentElement.offsetHeight : 0;
            const expectedChildrenHeight = titleHeight + contentHeight;
            
            relationships.push({
              index,
              containerHeight,
              titleHeight,
              contentHeight,
              expectedChildrenHeight,
              heightDeficit: containerHeight - expectedChildrenHeight,
              isProperlyContaining: containerHeight >= expectedChildrenHeight,
              overflowRisk: expectedChildrenHeight > containerHeight
            });
          });
          
          return relationships;
        };
      `
    });
    
    investigationResults.phases.phase1 = {
      containersFound: containers.length,
      setupComplete: true,
      timestamp: new Date().toISOString()
    };
    
    console.log('✅ Phase 1 Complete: Measurement functions initialized');
  });

  for (const viewport of viewports) {
    test(`Phase 2: Multi-Viewport Testing - ${viewport.name} (${viewport.width}x${viewport.height})`, async ({ page }) => {
      console.log(`🔍 PHASE 2: ${viewport.name} Viewport Analysis`);
      
      // Set viewport
      await page.setViewportSize({ width: viewport.width, height: viewport.height });
      await page.goto(targetUrl, { waitUntil: 'networkidle' });
      await page.waitForTimeout(1500);
      
      // Take baseline screenshot
      await page.screenshot({
        path: `/Users/hayashikenjirou/Local Sites/stepjam/app/public/playwright-investigations/nx-tokyo-${viewport.name.toLowerCase()}-baseline.png`,
        fullPage: true
      });
      
      // Get measurements for this viewport
      const measurements = await page.evaluate(() => window.measureContainerHeights());
      const relationships = await page.evaluate(() => window.detectHeightRelationships());
      
      // Analyze overflow issues
      const overflowIssues = measurements.filter(m => m.container.hasOverflow);
      const heightMismatches = relationships.filter(r => r.overflowRisk);
      
      console.log(`📊 ${viewport.name} Results:`);
      console.log(`   - Containers with overflow: ${overflowIssues.length}`);
      console.log(`   - Height relationship issues: ${heightMismatches.length}`);
      
      // Store viewport-specific results
      if (!investigationResults.phases.phase2) {
        investigationResults.phases.phase2 = {};
      }
      
      investigationResults.phases.phase2[viewport.name] = {
        viewport,
        measurements,
        relationships,
        overflowIssues: overflowIssues.length,
        heightMismatches: heightMismatches.length,
        evidence: {
          screenshotPath: `nx-tokyo-${viewport.name.toLowerCase()}-baseline.png`
        }
      };
      
      // Add to global overflow issues if found
      if (overflowIssues.length > 0) {
        investigationResults.overflowIssues.push({
          viewport: viewport.name,
          issues: overflowIssues,
          type: 'container_overflow'
        });
      }
      
      if (heightMismatches.length > 0) {
        investigationResults.overflowIssues.push({
          viewport: viewport.name,
          issues: heightMismatches,
          type: 'parent_child_mismatch'
        });
      }
      
      console.log(`✅ Phase 2 ${viewport.name} Complete`);
    });
  }

  test('Phase 3: Parent-Child Height Relationship Deep Analysis', async ({ page }) => {
    console.log('🔍 PHASE 3: Parent-Child Height Relationship Analysis');
    
    // Use desktop viewport for detailed analysis
    await page.setViewportSize({ width: 1024, height: 768 });
    await page.goto(targetUrl, { waitUntil: 'networkidle' });
    await page.waitForTimeout(1500);
    
    // Enhanced analysis script
    const detailedAnalysis = await page.evaluate(() => {
      const containers = document.querySelectorAll('.nx-content-block');
      const analysis = [];
      
      containers.forEach((container, index) => {
        const rect = container.getBoundingClientRect();
        const containerStyle = window.getComputedStyle(container);
        
        const titleElement = container.querySelector('.nx-block-title');
        const contentElement = container.querySelector('.nx-block-content');
        
        // Get all child elements to understand content flow
        const allChildren = Array.from(container.children);
        
        const containerAnalysis = {
          index,
          containerInfo: {
            tagName: container.tagName,
            className: container.className,
            id: container.id,
            clientHeight: container.clientHeight,
            scrollHeight: container.scrollHeight,
            offsetHeight: container.offsetHeight,
            boundingRect: rect,
            styles: {
              height: containerStyle.height,
              minHeight: containerStyle.minHeight,
              maxHeight: containerStyle.maxHeight,
              padding: containerStyle.padding,
              margin: containerStyle.margin,
              border: containerStyle.border,
              boxSizing: containerStyle.boxSizing,
              display: containerStyle.display,
              flexDirection: containerStyle.flexDirection,
              justifyContent: containerStyle.justifyContent,
              alignItems: containerStyle.alignItems,
              gridTemplateRows: containerStyle.gridTemplateRows,
              gap: containerStyle.gap,
              overflow: containerStyle.overflow,
              overflowY: containerStyle.overflowY
            }
          },
          children: allChildren.map(child => {
            const childStyle = window.getComputedStyle(child);
            return {
              tagName: child.tagName,
              className: child.className,
              clientHeight: child.clientHeight,
              offsetHeight: child.offsetHeight,
              boundingRect: child.getBoundingClientRect(),
              styles: {
                height: childStyle.height,
                minHeight: childStyle.minHeight,
                margin: childStyle.margin,
                padding: childStyle.padding,
                position: childStyle.position,
                display: childStyle.display
              }
            };
          }),
          heightCalculations: {
            containerInnerHeight: container.clientHeight,
            totalChildrenHeight: allChildren.reduce((sum, child) => sum + child.offsetHeight, 0),
            containerPadding: parseFloat(containerStyle.paddingTop) + parseFloat(containerStyle.paddingBottom),
            containerBorder: parseFloat(containerStyle.borderTopWidth) + parseFloat(containerStyle.borderBottomWidth),
            availableContentHeight: container.clientHeight - (parseFloat(containerStyle.paddingTop) + parseFloat(containerStyle.paddingBottom))
          }
        };
        
        // Calculate overflow indicators
        const totalContentHeight = containerAnalysis.heightCalculations.totalChildrenHeight;
        const availableHeight = containerAnalysis.heightCalculations.availableContentHeight;
        
        containerAnalysis.overflowAnalysis = {
          isOverflowing: totalContentHeight > availableHeight,
          overflowAmount: Math.max(0, totalContentHeight - availableHeight),
          utilizationPercentage: (totalContentHeight / availableHeight) * 100,
          hasScrollableContent: container.scrollHeight > container.clientHeight
        };
        
        analysis.push(containerAnalysis);
      });
      
      return analysis;
    });
    
    // Take detailed screenshots of problematic containers
    for (let i = 0; i < detailedAnalysis.length; i++) {
      const analysis = detailedAnalysis[i];
      if (analysis.overflowAnalysis.isOverflowing) {
        await page.locator(`.nx-content-block`).nth(i).screenshot({
          path: `/Users/hayashikenjirou/Local Sites/stepjam/app/public/playwright-investigations/overflow-container-${i}.png`
        });
      }
    }
    
    investigationResults.phases.phase3 = {
      detailedAnalysis,
      overflowingContainers: detailedAnalysis.filter(a => a.overflowAnalysis.isOverflowing).length,
      timestamp: new Date().toISOString()
    };
    
    console.log(`✅ Phase 3 Complete: Found ${detailedAnalysis.filter(a => a.overflowAnalysis.isOverflowing).length} containers with height relationship issues`);
  });

  test('Phase 4: Overflow Detection Using Computed Styles and Scroll Measurements', async ({ page }) => {
    console.log('🔍 PHASE 4: Overflow Detection Analysis');
    
    await page.setViewportSize({ width: 1024, height: 768 });
    await page.goto(targetUrl, { waitUntil: 'networkidle' });
    await page.waitForTimeout(1500);
    
    const overflowDetection = await page.evaluate(() => {
      const containers = document.querySelectorAll('.nx-content-block');
      const detectionResults = [];
      
      containers.forEach((container, index) => {
        const containerStyle = window.getComputedStyle(container);
        
        // Multiple overflow detection methods
        const detection = {
          index,
          methods: {
            // Method 1: ScrollHeight vs ClientHeight
            scrollMethod: {
              hasOverflow: container.scrollHeight > container.clientHeight,
              scrollHeight: container.scrollHeight,
              clientHeight: container.clientHeight,
              difference: container.scrollHeight - container.clientHeight
            },
            
            // Method 2: Bounding box comparison
            boundingBoxMethod: {
              containerRect: container.getBoundingClientRect(),
              childrenOutOfBounds: Array.from(container.children).filter(child => {
                const childRect = child.getBoundingClientRect();
                const containerRect = container.getBoundingClientRect();
                return childRect.bottom > containerRect.bottom;
              }).length > 0
            },
            
            // Method 3: CSS overflow detection
            cssMethod: {
              overflow: containerStyle.overflow,
              overflowY: containerStyle.overflowY,
              hasScrollBehavior: containerStyle.overflow !== 'visible' && containerStyle.overflowY !== 'visible'
            },
            
            // Method 4: Content measurement
            contentMethod: {
              hasChildrenExceedingHeight: (() => {
                const containerHeight = container.clientHeight;
                let cumulativeChildHeight = 0;
                const containerPadding = parseFloat(containerStyle.paddingTop) + parseFloat(containerStyle.paddingBottom);
                
                Array.from(container.children).forEach(child => {
                  cumulativeChildHeight += child.offsetHeight;
                  const childStyle = window.getComputedStyle(child);
                  cumulativeChildHeight += parseFloat(childStyle.marginTop) + parseFloat(childStyle.marginBottom);
                });
                
                return cumulativeChildHeight > (containerHeight - containerPadding);
              })()
            }
          }
        };
        
        // Consensus detection
        const overflowIndicators = [
          detection.methods.scrollMethod.hasOverflow,
          detection.methods.boundingBoxMethod.childrenOutOfBounds,
          detection.methods.contentMethod.hasChildrenExceedingHeight
        ];
        
        detection.consensus = {
          overflowIndicatorCount: overflowIndicators.filter(Boolean).length,
          likelyOverflowing: overflowIndicators.filter(Boolean).length >= 2,
          confidence: (overflowIndicators.filter(Boolean).length / overflowIndicators.length) * 100
        };
        
        detectionResults.push(detection);
      });
      
      return detectionResults;
    });
    
    investigationResults.phases.phase4 = {
      overflowDetection,
      likelyOverflowingContainers: overflowDetection.filter(d => d.consensus.likelyOverflowing).length,
      highConfidenceOverflows: overflowDetection.filter(d => d.consensus.confidence >= 67).length,
      timestamp: new Date().toISOString()
    };
    
    console.log(`✅ Phase 4 Complete: ${overflowDetection.filter(d => d.consensus.likelyOverflowing).length} containers likely overflowing`);
  });

  test('Phase 5: Content Variation Impact Assessment', async ({ page }) => {
    console.log('🔍 PHASE 5: Content Variation Impact Assessment');
    
    await page.setViewportSize({ width: 1024, height: 768 });
    await page.goto(targetUrl, { waitUntil: 'networkidle' });
    await page.waitForTimeout(1500);
    
    // Test content variation scenarios
    const contentVariationTests = await page.evaluate(() => {
      const containers = document.querySelectorAll('.nx-content-block');
      const variationResults = [];
      
      containers.forEach((container, index) => {
        const originalHeight = container.clientHeight;
        const originalScrollHeight = container.scrollHeight;
        
        // Find content elements
        const contentElement = container.querySelector('.nx-block-content');
        const titleElement = container.querySelector('.nx-block-title');
        
        if (contentElement) {
          const originalContent = contentElement.innerHTML;
          const originalTitle = titleElement ? titleElement.innerHTML : '';
          
          // Test scenarios
          const scenarios = [];
          
          // Scenario 1: Add more content
          contentElement.innerHTML = originalContent + '<p>Additional content to test overflow behavior. This is extra text to see how the container responds to increased content height.</p>';
          scenarios.push({
            name: 'increased_content',
            newHeight: container.clientHeight,
            newScrollHeight: container.scrollHeight,
            heightChange: container.clientHeight - originalHeight,
            overflowChange: (container.scrollHeight > container.clientHeight) !== (originalScrollHeight > originalHeight)
          });
          
          // Reset content
          contentElement.innerHTML = originalContent;
          
          // Scenario 2: Test with longer title
          if (titleElement) {
            titleElement.innerHTML = originalTitle + ' - Extended Title for Overflow Testing';
            scenarios.push({
              name: 'longer_title',
              newHeight: container.clientHeight,
              newScrollHeight: container.scrollHeight,
              heightChange: container.clientHeight - originalHeight,
              overflowChange: (container.scrollHeight > container.clientHeight) !== (originalScrollHeight > originalHeight)
            });
            
            // Reset title
            titleElement.innerHTML = originalTitle;
          }
          
          variationResults.push({
            index,
            originalHeight,
            originalScrollHeight,
            scenarios,
            contentFlexibility: {
              expandsWithContent: scenarios.some(s => s.heightChange > 0),
              maintainsOverflowBehavior: scenarios.every(s => !s.overflowChange),
              isResponsiveToContent: scenarios.some(s => Math.abs(s.heightChange) > 5)
            }
          });
        }
      });
      
      return variationResults;
    });
    
    investigationResults.phases.phase5 = {
      contentVariationTests,
      containersWithFlexibleHeight: contentVariationTests.filter(t => t.contentFlexibility.expandsWithContent).length,
      containersWithStableOverflowBehavior: contentVariationTests.filter(t => t.contentFlexibility.maintainsOverflowBehavior).length,
      timestamp: new Date().toISOString()
    };
    
    console.log(`✅ Phase 5 Complete: ${contentVariationTests.filter(t => t.contentFlexibility.expandsWithContent).length} containers show flexible height behavior`);
  });

  test('Phase 6: Comprehensive Results Summary and Recommendations', async ({ page }) => {
    console.log('🔍 PHASE 6: Final Analysis and Recommendations');
    
    // Generate comprehensive recommendations based on all phases
    const recommendations = [];
    const criticalIssues = [];
    const evidenceSummary = {};
    
    // Analyze Phase 2 results (multi-viewport)
    if (investigationResults.phases.phase2) {
      const viewportIssues = Object.values(investigationResults.phases.phase2).filter(v => v.overflowIssues > 0 || v.heightMismatches > 0);
      if (viewportIssues.length > 0) {
        criticalIssues.push({
          type: 'multi_viewport_overflow',
          severity: 'high',
          affectedViewports: viewportIssues.map(v => v.viewport.name),
          description: `Overflow issues detected across ${viewportIssues.length} viewport(s)`
        });
        
        recommendations.push({
          category: 'responsive_design',
          priority: 'high',
          action: 'Implement responsive height handling for .nx-content-block containers',
          details: 'Consider using min-height instead of fixed height, or implement viewport-specific CSS'
        });
      }
    }
    
    // Analyze Phase 3 results (parent-child relationships)
    if (investigationResults.phases.phase3) {
      const overflowingContainers = investigationResults.phases.phase3.overflowingContainers;
      if (overflowingContainers > 0) {
        criticalIssues.push({
          type: 'parent_child_height_mismatch',
          severity: 'high',
          count: overflowingContainers,
          description: `${overflowingContainers} container(s) with parent-child height relationship issues`
        });
        
        recommendations.push({
          category: 'css_architecture',
          priority: 'high',
          action: 'Review .nx-content-block height constraints',
          details: 'Ensure parent containers can expand to accommodate child content, or implement proper scrolling'
        });
      }
    }
    
    // Analyze Phase 4 results (overflow detection)
    if (investigationResults.phases.phase4) {
      const highConfidenceOverflows = investigationResults.phases.phase4.highConfidenceOverflows;
      if (highConfidenceOverflows > 0) {
        criticalIssues.push({
          type: 'confirmed_overflow',
          severity: 'critical',
          count: highConfidenceOverflows,
          description: `${highConfidenceOverflows} container(s) with high-confidence overflow detection`
        });
        
        recommendations.push({
          category: 'immediate_fix',
          priority: 'critical',
          action: 'Fix confirmed overflow containers immediately',
          details: 'These containers have been confirmed as overflowing through multiple detection methods'
        });
      }
    }
    
    // Analyze Phase 5 results (content variation)
    if (investigationResults.phases.phase5) {
      const inflexibleContainers = investigationResults.phases.phase5.containersWithFlexibleHeight;
      const totalContainers = investigationResults.phases.phase5.contentVariationTests.length;
      
      if (inflexibleContainers < totalContainers * 0.7) {
        recommendations.push({
          category: 'content_flexibility',
          priority: 'medium',
          action: 'Improve content flexibility for NX containers',
          details: 'Many containers do not expand properly with additional content, consider using flexible height CSS'
        });
      }
    }
    
    // Generate final evidence summary
    evidenceSummary.totalIssuesFound = criticalIssues.length;
    evidenceSummary.severityBreakdown = {
      critical: criticalIssues.filter(i => i.severity === 'critical').length,
      high: criticalIssues.filter(i => i.severity === 'high').length,
      medium: criticalIssues.filter(i => i.severity === 'medium').length
    };
    evidenceSummary.recommendationCategories = [...new Set(recommendations.map(r => r.category))];
    
    // Store final results
    investigationResults.phases.phase6 = {
      criticalIssues,
      recommendations,
      evidenceSummary,
      investigationComplete: true,
      timestamp: new Date().toISOString()
    };
    
    investigationResults.recommendations = recommendations;
    
    // Generate final report
    console.log('\n' + '='.repeat(80));
    console.log('📊 ULTRA THINK ANALYSIS - FINAL REPORT');
    console.log('='.repeat(80));
    console.log(`🎯 Target: ${targetUrl}`);
    console.log(`📅 Analysis Date: ${new Date().toISOString()}`);
    console.log('');
    
    console.log('🚨 CRITICAL ISSUES DETECTED:');
    if (criticalIssues.length === 0) {
      console.log('   ✅ No critical issues found');
    } else {
      criticalIssues.forEach((issue, index) => {
        console.log(`   ${index + 1}. ${issue.description} (${issue.severity.toUpperCase()})`);
      });
    }
    
    console.log('\n📋 RECOMMENDATIONS:');
    if (recommendations.length === 0) {
      console.log('   ✅ No recommendations needed');
    } else {
      recommendations.forEach((rec, index) => {
        console.log(`   ${index + 1}. [${rec.priority.toUpperCase()}] ${rec.action}`);
        console.log(`      Details: ${rec.details}`);
      });
    }
    
    console.log('\n📈 EVIDENCE SUMMARY:');
    console.log(`   Total Issues: ${evidenceSummary.totalIssuesFound}`);
    console.log(`   Critical: ${evidenceSummary.severityBreakdown.critical}`);
    console.log(`   High: ${evidenceSummary.severityBreakdown.high}`);
    console.log(`   Medium: ${evidenceSummary.severityBreakdown.medium}`);
    
    console.log('='.repeat(80));
    console.log('✅ Phase 6 Complete: Ultra Think Analysis Finished');
    
    // Save investigation results to file
    await page.evaluate((results) => {
      const jsonResults = JSON.stringify(results, null, 2);
      const blob = new Blob([jsonResults], { type: 'application/json' });
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = 'nx-tokyo-height-overflow-investigation.json';
      a.click();
    }, investigationResults);
  });
});