# Contact Form Modern Selector Proposals - STEPJAM

## User Requirements
- White and black color scheme only (sophisticated/chic)
- Modern mechanism (not radio buttons)
- Multiple selection capability
- Replace existing checkbox group for "概要" field

## Proposed Solutions

### A案: Elegant Pill Toggle
- Design: Rounded rectangle buttons with monochrome inversion effect
- State: Transparent border (unselected) → White background/black text (selected)
- Style: Pharmaceutical capsule-inspired, minimal transitions
- Benefits: Intuitive, clear selection state, modern appearance

### B案: Minimalist Card System  
- Design: Flat cards with border weight changes
- State: Thin border (unselected) → Thick border (selected)
- Style: Content-first approach, maximum readability
- Benefits: Scannable, organized appearance, professional

### C案: Modern Badge System
- Design: Hashtag-style labels with symbol prefixes
- State: # symbol (unselected) → ● symbol (selected) with background inversion
- Style: Typography-focused, flexible layout
- Benefits: Contemporary feel, SNS-generation friendly

## Technical Implementation Plan
- Hidden checkbox inputs for form submission compatibility
- ARIA accessibility attributes (aria-pressed, role="button")
- Keyboard navigation support
- CSS-only animations for performance
- Responsive design for all devices
- Maintains existing contact_category[] name attribute

## Current Context
- Form location: page-contact.php template
- Current system: 6 checkbox options (お問い合わせ要項, 次回STEPJAM, 参加, 協賛, チケット, その他)
- Form submission: WordPress AJAX handler already implemented
- Design consistency: Must match STEPJAM black background theme