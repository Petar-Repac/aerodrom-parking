 <style>
     /* public/css/theme-customizer.css */
     .theme-customizer {
         position: fixed;
         top: 0;
         right: -320px;
         width: 320px;
         height: 100vh;
         background-color: #fff;
         box-shadow: -3px 0 10px rgba(0, 0, 0, 0.2);
         transition: right 0.3s ease;
         z-index: 9999;
         overflow-y: auto;
     }

     .theme-customizer.active {
         right: 0;
     }

     .theme-customizer-toggle {
         position: absolute;
         top: 50%;
         left: -60px; /* Wider button for text */
         width: 60px;
         height: 40px;
         background-color: var(--clr-accent-form, #742CCC); /* Fallback color if variable not set */
         color: #fff !important; /* Force white text color */
         border-radius: 4px 0 0 4px;
         display: flex;
         align-items: center;
         justify-content: center;
         cursor: pointer;
         box-shadow: -3px 0 10px rgba(0, 0, 0, 0.2);
         border: 1px solid rgba(0,0,0,0.1);
     }

     .theme-customizer-toggle span {
         color: #fff;
         font-weight: bold;
         font-size: 14px;
     }

     .theme-customizer-content {
         padding: 20px;
     }

     .theme-customizer h3 {
         margin-top: 0;
         margin-bottom: 15px;
         color: var(--clr-text-primary, #444444);
         font-size: 18px;
         border-bottom: 1px solid #eee;
         padding-bottom: 10px;
     }

     /* Theme name input */
     .theme-name-input {
         margin-bottom: 15px;
     }

     .theme-name-input label {
         display: block;
         margin-bottom: 5px;
         font-size: 14px;
         color: var(--clr-text-primary, #444444);
     }

     .theme-name-input input[type="text"] {
         width: 100%;
         padding: 8px;
         border: 1px solid #ddd;
         border-radius: 4px;
         font-size: 14px;
         background-color: #eee;
         color: #000 !important;
     }

     /* Pagination navigation */
     .pagination-nav {
         display: flex;
         align-items: center;
         justify-content: space-between;
         margin-bottom: 15px;
         padding: 5px 0;
         border-bottom: 1px solid #eee;
     }

     .nav-btn {
         background: #f1f1f1; /* Light gray background for visibility */
         border: 1px solid #ddd;
         color: #333 !important; /* Dark text for visibility */
         cursor: pointer;
         font-size: 14px;
         padding: 5px 10px;
         border-radius: 4px;
     }

     .nav-btn:hover {
         background-color: #e0e0e0;
     }

     .nav-btn:disabled {
         color: #999 !important;
         background-color: #f8f8f8;
         cursor: not-allowed;
     }

     #page-indicator {
         font-size: 14px;
         color: var(--clr-text-primary, #444444);
         font-weight: bold;
     }

     /* Color picker pages */
     .color-page {
         margin-bottom: 10px;
         min-height: 270px; /* Keep consistent height between pages */
     }

     .color-picker-group {
         margin-bottom: 15px;
     }

     .color-picker-group label {
         display: block;
         margin-bottom: 5px;
         font-size: 14px;
         color: var(--clr-text-primary, #444444);
     }

     .color-picker-group input[type="color"] {
         width: 100%;
         height: 40px;
         border: 1px solid #ddd;
         border-radius: 4px;
         cursor: pointer;
     }

     /* Button groups */
     .btn-group {
         display: flex;
         gap: 10px;
         margin-bottom: 10px;
     }

     .main-actions {
         margin-top: 20px;
     }

     .import-export {
         margin-top: 5px;
         margin-bottom: 15px;
     }

     .btn {
         padding: 8px 15px;
         border: 1px solid rgba(0,0,0,0.1); /* Add border for visibility */
         border-radius: 4px;
         cursor: pointer;
         flex: 1;
         text-align: center;
         font-size: 14px;
         transition: all 0.2s ease;
     }

     .btn-primary {
         background-color: var(--clr-accent-form, #742CCC);
         color: #fff !important; /* Force white text */
     }

     .btn-primary:hover {
         background-color: #6020B0;
     }

     .btn-secondary {
         background-color: #f1f1f1;
         color: #333 !important; /* Darker text for better visibility */
     }

     .btn-secondary:hover {
         background-color: #e0e0e0;
     }

     .btn-outline {
         background-color: #fff;
         border: 1px solid var(--clr-accent-form, #742CCC);
         color: var(--clr-accent-form, #742CCC) !important; /* Force text color */
     }

     .btn-outline:hover {
         background-color: #f0ebf7;
     }

     .import-label {
         display: flex;
         align-items: center;
         justify-content: center;
         margin: 0;
     }

     /* Keyboard shortcut info */
     .keyboard-shortcut-info {
         font-size: 12px;
         color: #777;
         text-align: center;
         margin-top: 15px;
         border-top: 1px solid #eee;
         padding-top: 15px;
     }

     kbd {
         background-color: #f1f1f1;
         border: 1px solid #ddd;
         border-radius: 3px;
         padding: 2px 5px;
         font-size: 11px;
     }

     .nav-btn:disabled {
         color: #999 !important;
         background-color: #f8f8f8;
         cursor: not-allowed;
     }

     .nav-btn:disabled i {
         color: #999 !important;
     }

     #page-indicator {
         font-size: 14px;
         color: var(--clr-text-primary, #444444);
         font-weight: bold;
     }

     /* Color picker pages */
     .color-page {
         margin-bottom: 10px;
         min-height: 270px; /* Keep consistent height between pages */
     }

     .color-picker-group {
         margin-bottom: 15px;
     }

     .color-picker-group label {
         display: block;
         margin-bottom: 5px;
         font-size: 14px;
         color: var(--clr-text-primary, #444444);
     }

     .color-picker-group input[type="color"] {
         width: 100%;
         height: 40px;
         border: 1px solid #ddd;
         border-radius: 4px;
         cursor: pointer;
     }

     /* Additional CSS for RGBA color picker functionality */

     .color-picker-group {
         margin-bottom: 20px;
     }

     .color-picker-header {
         display: flex;
         align-items: center;
         margin-bottom: 5px;
     }

     .color-picker-header label {
         flex: 1;
         margin-bottom: 0;
     }

     .color-preview {
         width: 30px;
         height: 20px;
         border-radius: 3px;
         border: 1px solid #ddd;
         /* Checkered background to show transparency */
         background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAMUlEQVQ4T2NkYGAQYcAP3uCTZhw1gGGYhAGBZIA/nYDCgBDAm9BGDWAAJyRCgLaBCAAgXwixzAS0pgAAAABJRU5ErkJggg==');
     }

     .color-input-row {
         display: flex;
         align-items: center;
         gap: 10px;
         margin-bottom: 8px;
     }

     input[type="color"] {
         flex: 1;
         height: 35px;
         border: 1px solid #ddd;
         border-radius: 4px;
         padding: 0;
         cursor: pointer;
     }

     .alpha-control {
         margin-top: 5px;
     }

     .alpha-slider-row {
         display: flex;
         align-items: center;
         gap: 10px;
     }

     .alpha-label {
         font-size: 12px;
         color: #666;
         min-width: 50px;
     }

     input[type="range"].alpha-slider {
         flex: 1;
         margin: 0;
     }

     .alpha-value {
         font-size: 12px;
         color: #666;
         min-width: 40px;
         text-align: right;
     }

     .hex-value-row {
         display: flex;
         margin-top: 8px;
     }

     .hex-value-input {
         flex: 1;
         padding: 5px 8px;
         border: 1px solid #ddd;
         border-radius: 4px;
         font-family: monospace;
         font-size: 12px;
     }

     /* Additional CSS for RGBA color picker - optimized UI */

     /* Optimize the color picker layout */
     .color-picker-group {
         margin-bottom: 15px;
         padding-bottom: 5px;
     }

     .color-picker-header {
         display: flex;
         align-items: center;
         margin-bottom: 5px;
     }

     .color-picker-header label {
         flex: 1;
         margin-bottom: 0;
         font-size: 14px;
         color: var(--clr-text-primary, #444444);
     }

     .color-input-row {
         display: flex;
         align-items: center;
     }

     input[type="color"] {
         flex: 1;
         height: 35px;
         border: 1px solid #ddd;
         border-radius: 4px;
         padding: 0;
         cursor: pointer;
         margin-right: 8px;
     }

     .color-preview {
         width: 40px;
         height: 35px;
         border-radius: 4px;
         border: 1px solid #ddd;
         /* Checkered background to show transparency */
         background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAMUlEQVQ4T2NkYGAQYcAP3uCTZhw1gGGYhAGBZIA/nYDCgBDAm9BGDWAAJyRCgLaBCAAgXwixzAS0pgAAAABJRU5ErkJggg==');
     }

     .alpha-control {
         margin-top: 5px;
     }

     .alpha-slider-row {
         display: flex;
         align-items: center;
         gap: 5px;
     }

     .alpha-label {
         font-size: 12px;
         color: #666;
         min-width: 55px;
     }

     input[type="range"].alpha-slider {
         flex: 1;
         margin: 0;
         height: 6px;
     }

     .alpha-value {
         font-size: 12px;
         color: #666;
         min-width: 35px;
         text-align: right;
     }

     /* Remove any unused elements from previous version */
     .hex-value-row {
         display: none;
     }
 </style>
 <div id="theme-customizer" class="theme-customizer">
     <div class="theme-customizer-toggle">
         <span>Theme</span>
     </div>
     <div class="theme-customizer-content">
         <h3>Theme Customizer</h3>

         <!-- Theme name input for saving -->
         <div class="theme-name-input">
             <label for="theme-name">Theme Name</label>
             <input type="text" id="theme-name" placeholder="My Custom Theme">
         </div>

         <!-- Pagination navigation -->
         <div class="pagination-nav">
             <button id="prev-page" class="nav-btn" disabled>← Prev</button>
             <span id="page-indicator">Page 1</span>
             <button id="next-page" class="nav-btn">Next →</button>
         </div>

         <!-- Color picker pages - Page 1 -->
         <div class="color-page" data-page="1">
             <div class="color-picker-group">
                 <label for="clr-background">Background Color</label>
                 <input type="color" id="clr-background" data-var="--clr-background" value="#331e36">
             </div>
             <div class="color-picker-group">
                 <label for="clr-accent-light">Accent Light</label>
                 <input type="color" id="clr-accent-light" data-var="--clr-accent-light" value="#41337a">
             </div>
             <div class="color-picker-group">
                 <label for="clr-accent-dark">Accent Dark</label>
                 <input type="color" id="clr-accent-dark" data-var="--clr-accent-dark" value="#150517">
             </div>
             <div class="color-picker-group">
                 <label for="clr-accent-lighter">Accent Lighter</label>
                 <input type="color" id="clr-accent-lighter" data-var="--clr-accent-lighter" value="#7a59ff">
             </div>

         </div>

         <!-- Page 2 -->
         <div class="color-page" data-page="2" style="display: none;">

             <div class="color-picker-group">
                 <label for="clr-text-primary">Text Primary</label>
                 <input type="color" id="clr-text-primary" data-var="--clr-text-primary" value="#444444">
             </div>
             <div class="color-picker-group">
                 <label for="clr-text-accent">Text Accent</label>
                 <input type="color" id="clr-text-accent" data-var="--clr-text-accent" value="#025D88">
             </div>
             <div class="color-picker-group">
                 <label for="clr-accent-form">Form Accent</label>
                 <input type="color" id="clr-accent-form" data-var="--clr-accent-form" value="#742CCC">
             </div>
             <div class="color-picker-group">
                 <label for="clr-accent-form-2">Form Accent #2</label>
                 <input type="color" id="clr-accent-form-2" data-var="--clr-accent-form-2" value="#150517">
             </div>
         </div>

         <!-- Page 3 -->
         <div class="color-page" data-page="3" style="display: none;">
             <div class="color-picker-group">
                 <label for="clr-cta-background">Cta background</label>
                 <input type="color" id="clr-cta-background" data-var="--clr-cta-background" value="#280a2c">
             </div>
             <div class="color-picker-group">
                 <label for="clr-header-bar">Header background</label>
                 <input type="color" id="clr-header-bar" data-var="--clr-header-bar" value="#150517">
             </div>
             <div class="color-picker-group">
                 <label for="clr-hero-gradient-2">Landing gradient #1</label>
                 <input type="color" id="clr-hero-gradient-2" data-var="--clr-hero-gradient-2" value="#331E36">
             </div>
             <div class="color-picker-group">
                 <label for="clr-hero-gradient-3">Landing gradient #2</label>
                 <input type="color" id="clr-hero-gradient-3" data-var="--clr-hero-gradient-3" value="#41337A">
             </div>
         </div>

         <!-- Add more pages here for additional colors -->

         <div class="btn-group main-actions">
             <button id="reset-theme" class="btn btn-secondary">Reset to Default</button>
             <button id="save-theme" class="btn btn-primary">Save Theme</button>
         </div>

         <div class="btn-group import-export">
             <button id="export-theme" class="btn btn-outline">Export Theme</button>
             <label for="import-theme-file" class="btn btn-outline import-label">Import Theme</label>
             <input type="file" id="import-theme-file" accept=".json" style="display: none;">
         </div>

         <div class="keyboard-shortcut-info">
             <small>Press <kbd>Alt</kbd> + <kbd>T</kbd> to toggle this panel</small>
         </div>
     </div>
 </div>
<script>
    // Fixed theme customizer with RGBA support - Optimized UI
    document.addEventListener('DOMContentLoaded', function() {
        // Store CSS default values (not from localStorage)
        const cssDefaultValues = {};

        // Original RGB to Hex conversion
        function rgbToHex(rgb) {
            // If rgb is already an array of r,g,b values
            if (Array.isArray(rgb)) {
                return '#' + rgb.map(x => {
                    const hex = Math.round(x).toString(16);
                    return hex.length === 1 ? '0' + hex : hex;
                }).join('');
            }

            // If rgb is a string like "rgb(r,g,b)" or "rgba(r,g,b,a)"
            if (typeof rgb === 'string') {
                // Handle hex format
                if (rgb.startsWith('#')) {
                    return rgb;
                }

                // Handle rgba format
                if (rgb.startsWith('rgba(')) {
                    const matches = rgb.match(/rgba\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,\s*([\d.]+)\s*\)/);
                    if (matches) {
                        const [, r, g, b] = matches.map(v => parseInt(v));
                        return rgbToHex([r, g, b]);
                    }
                }

                // Handle rgb format
                if (rgb.startsWith('rgb(')) {
                    const matches = rgb.match(/rgb\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)/);
                    if (matches) {
                        const [, r, g, b] = matches.map(v => parseInt(v));
                        return rgbToHex([r, g, b]);
                    }
                }

                // Fallback for other formats
                const rgbArray = rgb.match(/\d+/g);
                if (rgbArray && rgbArray.length >= 3) {
                    return '#' + rgbArray.slice(0, 3).map(x => {
                        const hex = parseInt(x).toString(16);
                        return hex.length === 1 ? '0' + hex : hex;
                    }).join('');
                }
            }

            // Fallback to black
            return '#000000';
        }

        // Convert hex to RGBA
        function hexToRgba(hex, alpha) {
            if (!hex) return 'rgba(0, 0, 0, ' + alpha + ')';

            const r = parseInt(hex.slice(1, 3), 16);
            const g = parseInt(hex.slice(3, 5), 16);
            const b = parseInt(hex.slice(5, 7), 16);
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        }

        // Convert alpha value (0-1) to hex (00-ff)
        function alphaToHex(alpha) {
            const decimal = Math.round(alpha * 255);
            const hex = decimal.toString(16);
            return hex.length === 1 ? '0' + hex : hex;
        }

        // Extract alpha from rgba color
        function extractAlphaFromRgba(rgba) {
            if (rgba.startsWith('rgba(')) {
                const matches = rgba.match(/rgba\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,\s*([\d.]+)\s*\)/);
                if (matches && matches[4]) {
                    return parseFloat(matches[4]);
                }
            }
            return 1; // Default alpha is 1 (fully opaque)
        }

        // Get the root element for CSS variables
        const root = document.documentElement;

        // Initialize storage for theme colors
        let themeColors = {};
        let currentPage = 1;
        const totalPages = document.querySelectorAll('.color-page').length;

        // Initialize the color pickers with RGBA support
        function initColorPickers() {
            const colorGroups = document.querySelectorAll('.color-picker-group');

            colorGroups.forEach(group => {
                const originalLabel = group.querySelector('label');
                const originalInput = group.querySelector('input[type="color"]');

                if (!originalInput || !originalLabel) return;

                const varName = originalInput.dataset.var;

                // Get computed value from CSS
                const computedStyle = getComputedStyle(root);
                const cssValue = computedStyle.getPropertyValue(varName).trim();

                // Store the original CSS value for reset
                cssDefaultValues[varName] = cssValue || originalInput.value;

                // Parse color and alpha
                let hexColor = originalInput.value;
                let alpha = 1;

                if (cssValue) {
                    if (cssValue.startsWith('rgba(')) {
                        // Extract rgba values
                        const matches = cssValue.match(/rgba\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,\s*([\d.]+)\s*\)/);
                        if (matches) {
                            const [, r, g, b, a] = matches.map((v, i) => i === 4 ? parseFloat(v) : parseInt(v));
                            hexColor = rgbToHex([r, g, b]);
                            alpha = a;
                        }
                    } else if (cssValue.startsWith('rgb(')) {
                        // Extract rgb values
                        const matches = cssValue.match(/rgb\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)/);
                        if (matches) {
                            const [, r, g, b] = matches.map(v => parseInt(v));
                            hexColor = rgbToHex([r, g, b]);
                        }
                    } else if (cssValue.startsWith('#')) {
                        hexColor = cssValue;
                    }
                }

                // Create the RGBA picker HTML with integrated preview
                group.innerHTML = `
                <div class="color-picker-header">
                    <label for="${originalInput.id}">${originalLabel.textContent}</label>
                </div>
                <div class="color-input-row">
                    <input type="color" id="${originalInput.id}" data-var="${varName}" value="${hexColor}">
                    <div class="color-preview" id="preview-${originalInput.id}"></div>
                </div>
                <div class="alpha-control">
                    <div class="alpha-slider-row">
                        <span class="alpha-label">Opacity:</span>
                        <input type="range" class="alpha-slider" id="alpha-${originalInput.id}"
                               min="0" max="1" step="0.01" value="${alpha}">
                        <span class="alpha-value" id="alpha-value-${originalInput.id}">${Math.round(alpha * 100)}%</span>
                    </div>
                </div>

                <!-- Hidden hex value field - for internal use only -->
                <input type="hidden" id="hex-${originalInput.id}" value="${hexColor}${alphaToHex(alpha)}">
            `;

                // Get the new elements
                const colorInput = document.getElementById(originalInput.id);
                const alphaSlider = document.getElementById(`alpha-${originalInput.id}`);
                const alphaValue = document.getElementById(`alpha-value-${originalInput.id}`);
                const hexValue = document.getElementById(`hex-${originalInput.id}`);
                const colorPreview = document.getElementById(`preview-${originalInput.id}`);

                // Update function to apply RGBA color
                function updateColor() {
                    const hexColor = colorInput.value;
                    const alpha = parseFloat(alphaSlider.value);

                    // Generate RGBA
                    const rgbaColor = hexToRgba(hexColor, alpha);

                    // Update CSS variable
                    root.style.setProperty(varName, rgbaColor);

                    // Update alpha percentage display
                    alphaValue.textContent = `${Math.round(alpha * 100)}%`;

                    // Update hidden hex value
                    hexValue.value = `${hexColor}${alphaToHex(alpha)}`;

                    // Update color preview
                    colorPreview.style.backgroundColor = rgbaColor;

                    // Store in theme colors (for save/export)
                    themeColors[varName] = rgbaColor;
                }

                // Add event listeners
                colorInput.addEventListener('input', updateColor);
                alphaSlider.addEventListener('input', updateColor);

                // Initialize with current values
                updateColor();

                // Style the color preview
                colorPreview.style.width = '40px';
                colorPreview.style.height = '35px';
                colorPreview.style.marginLeft = '10px';
                colorPreview.style.borderRadius = '4px';
                colorPreview.style.border = '1px solid #ddd';
            });
        }

        // Try to load saved colors from localStorage
        if (localStorage.getItem('themeColors')) {
            try {
                themeColors = JSON.parse(localStorage.getItem('themeColors'));

                // Try to load theme name if available
                if (localStorage.getItem('themeName')) {
                    document.getElementById('theme-name').value = localStorage.getItem('themeName');
                }

                // Apply saved colors to CSS variables
                Object.keys(themeColors).forEach(varName => {
                    root.style.setProperty(varName, themeColors[varName]);
                });
            } catch (e) {
                console.error('Error loading saved theme:', e);
            }
        }

        // Setup pagination
        function setupPagination() {
            const prevBtn = document.getElementById('prev-page');
            const nextBtn = document.getElementById('next-page');
            const pageIndicator = document.getElementById('page-indicator');

            updatePaginationControls();

            prevBtn.addEventListener('click', function() {
                if (currentPage > 1) {
                    changePage(currentPage - 1);
                }
            });

            nextBtn.addEventListener('click', function() {
                if (currentPage < totalPages) {
                    changePage(currentPage + 1);
                }
            });

            function changePage(newPage) {
                // Hide current page
                document.querySelector(`.color-page[data-page="${currentPage}"]`).style.display = 'none';

                // Show new page
                document.querySelector(`.color-page[data-page="${newPage}"]`).style.display = 'block';

                // Update current page
                currentPage = newPage;
                pageIndicator.textContent = `Page ${currentPage}`;

                // Update button states
                updatePaginationControls();
            }

            function updatePaginationControls() {
                prevBtn.disabled = currentPage === 1;
                nextBtn.disabled = currentPage === totalPages;
                pageIndicator.textContent = `Page ${currentPage}`;
            }
        }

        // Setup toggle functionality
        function setupToggle() {
            const customizer = document.getElementById('theme-customizer');
            const customizerToggle = document.querySelector('.theme-customizer-toggle');

            customizerToggle.addEventListener('click', function() {
                customizer.classList.toggle('active');
            });

            // Keyboard shortcut to toggle customizer (Alt+T)
            document.addEventListener('keydown', function(e) {
                if (e.altKey && e.key === 't') {
                    e.preventDefault();
                    customizer.classList.toggle('active');
                }
            });
        }

        // Setup buttons
        function setupButtons() {
            // Reset button
            document.getElementById('reset-theme').addEventListener('click', function() {
                resetToDefaults();
            });

            // Save button
            document.getElementById('save-theme').addEventListener('click', function() {
                saveTheme();
            });

            // Export theme button
            document.getElementById('export-theme').addEventListener('click', function() {
                exportTheme();
            });

            // Import theme
            document.getElementById('import-theme-file').addEventListener('change', function(e) {
                importTheme(e);
            });
        }

        // Reset to CSS defaults
        function resetToDefaults() {
            // Apply original CSS default values
            Object.keys(cssDefaultValues).forEach(varName => {
                const originalValue = cssDefaultValues[varName];

                // Apply to CSS variable
                root.style.setProperty(varName, originalValue);

                // Update color picker UI
                const input = document.querySelector(`[data-var="${varName}"]`);
                if (input) {
                    // Extract color and alpha
                    let hexColor;
                    let alpha = 1;

                    if (originalValue.startsWith('rgba(')) {
                        const matches = originalValue.match(/rgba\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,\s*([\d.]+)\s*\)/);
                        if (matches) {
                            const [, r, g, b, a] = matches.map((v, i) => i === 4 ? parseFloat(v) : parseInt(v));
                            hexColor = rgbToHex([r, g, b]);
                            alpha = a;
                        }
                    } else if (originalValue.startsWith('rgb(')) {
                        const matches = originalValue.match(/rgb\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)/);
                        if (matches) {
                            const [, r, g, b] = matches.map(v => parseInt(v));
                            hexColor = rgbToHex([r, g, b]);
                        }
                    } else if (originalValue.startsWith('#')) {
                        hexColor = originalValue;
                    } else {
                        // Default for unknown formats
                        hexColor = '#000000';
                    }

                    // Update color input
                    input.value = hexColor;

                    // Update alpha slider
                    const alphaSlider = document.getElementById(`alpha-${input.id}`);
                    if (alphaSlider) {
                        alphaSlider.value = alpha;
                    }

                    // Update alpha value display
                    const alphaValue = document.getElementById(`alpha-value-${input.id}`);
                    if (alphaValue) {
                        alphaValue.textContent = `${Math.round(alpha * 100)}%`;
                    }

                    // Update color preview
                    const colorPreview = document.getElementById(`preview-${input.id}`);
                    if (colorPreview) {
                        colorPreview.style.backgroundColor = originalValue;
                    }
                }
            });

            // Reset theme colors object
            themeColors = {};

            // Clear theme name
            document.getElementById('theme-name').value = '';

            // Show reset confirmation
            showConfirmation(document.getElementById('reset-theme'), 'Reset!', '#6c757d');
        }

        // Save theme
        function saveTheme() {
            // Get theme name
            const themeName = document.getElementById('theme-name').value || 'Custom Theme';

            // Save to localStorage
            localStorage.setItem('themeColors', JSON.stringify(themeColors));
            localStorage.setItem('themeName', themeName);

            // Show save confirmation
            showConfirmation(document.getElementById('save-theme'), 'Saved!', '#28a745');
        }

        // Export theme
        function exportTheme() {
            // Get theme name
            const themeName = document.getElementById('theme-name').value || 'custom-theme';
            const safeThemeName = themeName.toLowerCase().replace(/[^a-z0-9]/g, '-');

            // Create theme object with metadata
            const themeExport = {
                name: themeName,
                description: 'Custom theme created with Theme Customizer',
                createdAt: new Date().toISOString(),
                colors: themeColors
            };

            // Convert to JSON
            const themeJson = JSON.stringify(themeExport, null, 2);

            // Create download link
            const blob = new Blob([themeJson], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `${safeThemeName}.json`;

            // Trigger download
            document.body.appendChild(a);
            a.click();

            // Clean up
            setTimeout(() => {
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            }, 0);

            // Show export confirmation
            showConfirmation(document.getElementById('export-theme'), 'Exported!', '#17a2b8');
        }

        // Import theme
        function importTheme(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();

            reader.onload = function(event) {
                try {
                    const themeData = JSON.parse(event.target.result);

                    // Validate theme data
                    if (!themeData.colors || typeof themeData.colors !== 'object') {
                        throw new Error('Invalid theme file format');
                    }

                    // Apply theme name if available
                    if (themeData.name) {
                        document.getElementById('theme-name').value = themeData.name;
                    }

                    // Apply theme colors
                    themeColors = themeData.colors;

                    // Apply colors to CSS and update UI
                    Object.keys(themeColors).forEach(varName => {
                        const colorValue = themeColors[varName];

                        // Apply to CSS variable
                        root.style.setProperty(varName, colorValue);

                        // Update color picker UI
                        const input = document.querySelector(`[data-var="${varName}"]`);
                        if (input) {
                            // Extract color and alpha
                            let hexColor;
                            let alpha = 1;

                            if (colorValue.startsWith('rgba(')) {
                                const matches = colorValue.match(/rgba\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,\s*([\d.]+)\s*\)/);
                                if (matches) {
                                    const [, r, g, b, a] = matches.map((v, i) => i === 4 ? parseFloat(v) : parseInt(v));
                                    hexColor = rgbToHex([r, g, b]);
                                    alpha = a;
                                }
                            } else if (colorValue.startsWith('rgb(')) {
                                const matches = colorValue.match(/rgb\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)/);
                                if (matches) {
                                    const [, r, g, b] = matches.map(v => parseInt(v));
                                    hexColor = rgbToHex([r, g, b]);
                                }
                            } else if (colorValue.startsWith('#')) {
                                hexColor = colorValue;
                            } else {
                                // Default for unknown formats
                                hexColor = '#000000';
                            }

                            // Update color input
                            input.value = hexColor;

                            // Update alpha slider
                            const alphaSlider = document.getElementById(`alpha-${input.id}`);
                            if (alphaSlider) {
                                alphaSlider.value = alpha;
                            }

                            // Update alpha value display
                            const alphaValue = document.getElementById(`alpha-value-${input.id}`);
                            if (alphaValue) {
                                alphaValue.textContent = `${Math.round(alpha * 100)}%`;
                            }

                            // Update color preview
                            const colorPreview = document.getElementById(`preview-${input.id}`);
                            if (colorPreview) {
                                colorPreview.style.backgroundColor = colorValue;
                            }
                        }
                    });

                    // Show import success
                    showNotification('Theme imported successfully!', 'success');

                } catch (error) {
                    console.error('Error importing theme:', error);
                    showNotification('Error importing theme. Invalid format.', 'error');
                }

                // Reset file input
                e.target.value = '';
            };

            reader.readAsText(file);
        }

        // Helper: Show confirmation on button
        function showConfirmation(button, message, color) {
            const originalText = button.textContent;
            const originalBg = button.style.backgroundColor;

            button.textContent = message;
            button.style.backgroundColor = color;

            setTimeout(() => {
                button.textContent = originalText;
                button.style.backgroundColor = originalBg;
            }, 2000);
        }

        // Helper: Show notification
        function showNotification(message, type) {
            // Create notification element if it doesn't exist
            let notification = document.getElementById('theme-notification');

            if (!notification) {
                notification = document.createElement('div');
                notification.id = 'theme-notification';
                notification.style.position = 'fixed';
                notification.style.bottom = '20px';
                notification.style.right = '20px';
                notification.style.padding = '12px 20px';
                notification.style.borderRadius = '4px';
                notification.style.color = '#fff';
                notification.style.fontWeight = 'bold';
                notification.style.zIndex = '10000';
                notification.style.boxShadow = '0 3px 10px rgba(0,0,0,0.2)';
                notification.style.transition = 'all 0.3s ease';
                document.body.appendChild(notification);
            }

            // Set styling based on notification type
            if (type === 'success') {
                notification.style.backgroundColor = '#28a745';
            } else if (type === 'error') {
                notification.style.backgroundColor = '#dc3545';
            } else {
                notification.style.backgroundColor = '#17a2b8';
            }

            // Set message
            notification.textContent = message;

            // Show notification
            notification.style.opacity = '1';

            // Hide after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';

                // Remove from DOM after fade out
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }

        // Initialize everything
        initColorPickers();
        setupPagination();
        setupToggle();
        setupButtons();
    });
</script>
