# **CSS POSITIONING EXERCISE - Q3**

## **📁 BIG SQUARE WITH 4 CORNER SQUARES**
**📄 File**: Q3-corner-squares.html**
**🎯 Type**: HTML/CSS Positioning Exercise
**💡 Solution**: Container-based approach with relative and absolute positioning hierarchy

### **📋 Overview**
This file demonstrates a **big square (400px × 400px)** with **4 small squares (50px × 50px)** positioned at each corner, maintaining 20px spacing from the edges. The entire structure is perfectly centered on the page.

### **✅ Features**
- **📦 Hierarchical positioning** (container → big square → small squares)
- **🎯 Perfect centering** of the entire structure
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
Dimensions: 50px × 50px with grey border
position: absolute - positioned relative to big square
Four positioning rules for four corners
20px offset from each edge

4. Positioning Strategy:
Top-left: left: 20px, top: 20px
Top-right: right: 20px, top: 20px
Bottom-left: left: 20px, bottom: 20px
Bottom-right: right: 20px, bottom: 20px

### **⚙️ CSS Properties Used**
- Category      Properties                          Purpose
- Positioning	position, left, right, top, bottom	Element placement and offsets
- dimensions    width, height                       Size definition
- Styling	    borders                             Visual boundaries
- spacing       margin-left, margin-top             Centering calculations
- Typography    font-family, font-size, color       Info text styling


### **🧠 Positioning Analysis**
- Why position: relative on Big Square?
Creates a positioning context for child elements
Child position: absolute elements are positioned relative to this container
Without relative, small squares would position relative to viewport

- Why position: absolute on Small Squares?
Positions elements relative to nearest positioned ancestor
Allows precise placement using left/right/top/bottom
Takes elements out of normal document flow

### **📐 Dimensions & Spacing**
text
Big Square:     400px   ×   400px
Small Squares:  50px    ×   50px
Edge Spacing:   20px

Positions:
• Top-left:     left: 20px,     top: 20px
• Top-right:    right: 20px,    top: 20px
• Bottom-left:  left: 20px,     bottom: 20px
• Bottom-right: right: 20px,    bottom: 20px

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

2. Minimal Attributes:
Uses only required CSS properties
No unnecessary styling
Clean, maintainable code

3. Scalable Structure:
Easy to add more squares
Simple to modify spacing
Clear relationship between elements