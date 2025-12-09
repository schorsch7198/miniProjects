# **CSS POSITIONING EXERCISE - Q3**

## **📁 BIG SQUARE WITH 2 HALF-SIZE CORNER SQUARES**
**📄 File**: `Q3-half-size-corner-squares.html`
**🎯 Type**: HTML/CSS Positioning Exercise
**💡 Solution**: Container-based approach with relative and absolute positioning hierarchy

### **📋 Overview**
This file demonstrates a **big square (400px × 400px)** with **2 small squares (200px × 200px)** positioned at opposite corners (top-left and bottom-right), maintaining **20px spacing from the edges**. Each small square is exactly half the size of the big square. The entire structure is perfectly centered on the page.

### **✅ Features**
- **📦 Hierarchical positioning** (container → big square → small squares)
- **🎯 Perfect centering** of the entire structure
- **📐 Half-size squares** (200px = 400px ÷ 2)
- **📏 Consistent 20px spacing** between squares and edges
- **⚡ Efficient CSS** with minimal attributes
- **📝 Includes student information**
- **✔️ W3C Valid HTML5**

### **🎨 CSS Approach**
1. Container Centering:
Absolute positioning relative to viewport
Centered using left: 50%, top: 50%
Negative margins (-200px = half of 400px) for perfect alignment
Fixed dimensions: 400px × 400px

2. Big Square:
Dimensions: 400px × 400px with black border
position: relative - creates positioning context for child elements
No positioning offsets (fills container)

3. Small Squares:
Dimensions: 200px × 200px with grey border (half of big square)
position: absolute - positioned relative to big square
Two positioning rules for two corners
20px offset from each edge

4. Positioning Strategy:
Top-left: left: 20px, top: 20px
Bottom-right: right: 20px, bottom: 20px

### **📐 Dimensions & Spacing**

Big Square:     400px × 400px
Small Squares:  200px × 200px  (exactly half size)
Edge Spacing:   20px

Positions:
• Top-left:     left: 20px,     top: 20px
• Bottom-right: right: 20px,    bottom: 20px

Space Calculations:
• Top-left fits: 20px + 200px = 220px (within 400px)
• Bottom-right fits: 400px - 20px - 200px = 180px offset from left/top

### **📋 Instructions**
Save file as Q3.html
Open in any web browser
View the perfectly centered square arrangement
Modify spacing by changing offset values (20px)
Adjust square sizes by modifying width/height

### **🔑 Key Takeaways**
1. Positioning Hierarchy:
Container → Centering
Big square → Positioning context
Small squares → Absolute positioning

2. Half-Size Ratio:
Small squares are exactly 50% of big square dimensions
Mathematical relationship: 200px = 400px ÷ 2
Consistent proportional design

3. Minimal Attributes:
Uses only required CSS properties
No unnecessary styling
Clean, maintainable code

4. Scalable Structure:
Easy to add more squares
Simple to modify spacing
Clear relationship between elements