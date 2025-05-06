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
    // public/js/theme-customizer.js
    document.addEventListener('DOMContentLoaded', function() {
        // Store CSS default values (not from localStorage)
        const cssDefaultValues = {};
        const colorInputs = document.querySelectorAll('.color-picker-group input[type="color"]');

        // Get the root element for CSS variables
        const root = document.documentElement;

        // Initialize storage for theme colors
        let themeColors = {};
        let currentPage = 1;
        const totalPages = document.querySelectorAll('.color-page').length;

        // Capture the original CSS default values BEFORE applying any saved theme
        // This ensures we're storing the true defaults from the CSS stylesheet
        captureDefaultCssValues();

        // Try to load saved colors from localStorage
        if (localStorage.getItem('themeColors')) {
            try {
                themeColors = JSON.parse(localStorage.getItem('themeColors'));

                // Try to load theme name if available
                if (localStorage.getItem('themeName')) {
                    document.getElementById('theme-name').value = localStorage.getItem('themeName');
                }

                // Apply saved colors
                Object.keys(themeColors).forEach(varName => {
                    root.style.setProperty(varName, themeColors[varName]);

                    // Update color input values
                    const input = document.querySelector(`[data-var="${varName}"]`);
                    if (input) {
                        input.value = themeColors[varName];
                    }
                });
            } catch (e) {
                console.error('Error loading saved theme:', e);
            }
        }

        // Set up all color inputs
        setupColorInputs();

        // Pagination setup
        setupPagination();

        // Setup toggle functionality
        setupToggle();

        // Setup buttons
        setupButtons();

        // ------- Helper Functions -------

        // Capture default CSS values
        function captureDefaultCssValues() {
            const defaultStylesheet = getComputedStyle(root);

            colorInputs.forEach(input => {
                const varName = input.dataset.var;
                // Get the default CSS value or fallback to input's value attribute
                const defaultValue = defaultStylesheet.getPropertyValue(varName).trim() || input.value;
                cssDefaultValues[varName] = defaultValue;

                // For debugging
                // console.log(`Captured default for ${varName}: ${defaultValue}`);
            });
        }

        // Setup color inputs with listeners
        function setupColorInputs() {
            colorInputs.forEach(input => {
                const varName = input.dataset.var;
                const computedStyle = getComputedStyle(root);
                const currentValue = computedStyle.getPropertyValue(varName).trim() || input.value;

                // Set input value to match current CSS var value
                input.value = currentValue.startsWith('#') ? currentValue : rgbToHex(currentValue);

                // Add change event listener
                input.addEventListener('input', function() {
                    const varName = this.dataset.var;
                    const value = this.value;
                    root.style.setProperty(varName, value);
                    themeColors[varName] = value;
                });
            });
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
            // Reset button - Important: Reset to CSS defaults, not localStorage values
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
                root.style.setProperty(varName, cssDefaultValues[varName]);

                // Update color input values
                const input = document.querySelector(`[data-var="${varName}"]`);
                if (input) {
                    input.value = cssDefaultValues[varName].startsWith('#') ?
                        cssDefaultValues[varName] : rgbToHex(cssDefaultValues[varName]);
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
                    Object.keys(themeColors).forEach(varName => {
                        root.style.setProperty(varName, themeColors[varName]);

                        // Update color input values
                        const input = document.querySelector(`[data-var="${varName}"]`);
                        if (input) {
                            input.value = themeColors[varName];
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

        // Helper: Convert RGB to Hex
        function rgbToHex(rgb) {
            // Check if already hex
            if (rgb.startsWith('#')) {
                return rgb;
            }

            // Handle rgb() format
            let rgbArray = rgb.match(/\d+/g);
            if (!rgbArray) return '#000000';

            return '#' + rgbArray.map(x => {
                const hex = parseInt(x).toString(16);
                return hex.length === 1 ? '0' + hex : hex;
            }).join('');
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
    });


    // Extend theme-customizer.js with RGBA color picking capabilities
    document.addEventListener('DOMContentLoaded', function() {
        // Add RGBA functionality after the original customizer script has loaded
        setupRgbaColorPickers();

        function setupRgbaColorPickers() {
            // Wait a short time to ensure main script has initialized
            setTimeout(() => {
                // Find all color input groups
                const colorGroups = document.querySelectorAll('.color-picker-group');

                colorGroups.forEach(group => {
                    // Get the original elements
                    const originalLabel = group.querySelector('label');
                    const originalInput = group.querySelector('input[type="color"]');
                    const varName = originalInput.dataset.var;

                    // Create new structure for RGBA picker
                    enhanceColorPickerWithAlpha(group, originalLabel, originalInput, varName);
                });

                // Extend the original reset function to properly handle RGBA values
                extendResetFunction();

                // Extend the original export/import functions
                extendExportImportFunctions();
            }, 100);
        }

        function enhanceColorPickerWithAlpha(group, originalLabel, originalInput, varName) {
            // Current color state
            const colorState = {
                hexColor: originalInput.value,
                alpha: 1, // Default to 100% opacity
                originalValue: getComputedStyle(document.documentElement).getPropertyValue(varName).trim()
            };

            // Determine initial alpha value from current CSS value
            if (colorState.originalValue.startsWith('rgba(')) {
                const matches = colorState.originalValue.match(/rgba\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,\s*([\d.]+)\s*\)/);
                if (matches) {
                    colorState.alpha = parseFloat(matches[4]);

                    // Convert RGB to hex for the color input
                    const r = parseInt(matches[1]);
                    const g = parseInt(matches[2]);
                    const b = parseInt(matches[3]);
                    colorState.hexColor = rgbToHex(r, g, b);
                    originalInput.value = colorState.hexColor;
                }
            }

            // Save original CSS value for reset functionality
            // Store in a global object if it doesn't exist yet
            if (!window.originalCssValues) {
                window.originalCssValues = {};
            }
            window.originalCssValues[varName] = colorState.originalValue;

            // Save original HTML structure
            const originalHtml = group.innerHTML;

            // Create new RGBA picker HTML
            group.innerHTML = `
            <div class="color-picker-header">
                <label for="${originalInput.id}">${originalLabel.textContent}</label>
                <div class="color-preview" id="preview-${originalInput.id}"></div>
            </div>
            <div class="color-input-row">
                <input type="color" id="${originalInput.id}" data-var="${varName}" value="${colorState.hexColor}">
            </div>
            <div class="alpha-control">
                <div class="alpha-slider-row">
                    <span class="alpha-label">Opacity:</span>
                    <input type="range" class="alpha-slider" id="alpha-${originalInput.id}"
                           min="0" max="1" step="0.01" value="${colorState.alpha}">
                    <span class="alpha-value" id="alpha-value-${originalInput.id}">${Math.round(colorState.alpha * 100)}%</span>
                </div>
            </div>
            <div class="hex-value-row">
                <input type="text" class="hex-value-input" id="hex-${originalInput.id}"
                       value="${colorState.hexColor}${alphaToHex(colorState.alpha)}" readonly>
            </div>
        `;

            // Get the new elements
            const colorInput = document.getElementById(originalInput.id);
            const alphaSlider = document.getElementById(`alpha-${originalInput.id}`);
            const alphaValue = document.getElementById(`alpha-value-${originalInput.id}`);
            const hexValue = document.getElementById(`hex-${originalInput.id}`);
            const colorPreview = document.getElementById(`preview-${originalInput.id}`);

            // Update function to apply RGBA color
            function updateColor() {
                // Update color state
                colorState.hexColor = colorInput.value;
                colorState.alpha = parseFloat(alphaSlider.value);

                // Generate RGBA
                const rgbaColor = hexToRgba(colorState.hexColor, colorState.alpha);

                // Update CSS variable
                document.documentElement.style.setProperty(varName, rgbaColor);

                // Update alpha percentage display
                alphaValue.textContent = `${Math.round(colorState.alpha * 100)}%`;

                // Update hex + alpha value
                hexValue.value = `${colorState.hexColor}${alphaToHex(colorState.alpha)}`;

                // Update color preview
                colorPreview.style.backgroundColor = rgbaColor;

                // Store in theme colors (for save/export)
                if (window.themeColors) {
                    window.themeColors[varName] = rgbaColor;
                }
            }

            // Add event listeners
            colorInput.addEventListener('input', updateColor);
            alphaSlider.addEventListener('input', updateColor);

            // Initialize
            updateColor();
        }

        function extendResetFunction() {
            // Store the original reset function
            const originalResetFunction = window.resetToDefaults;

            if (originalResetFunction) {
                // Override with our extended version
                window.resetToDefaults = function() {
                    // Apply original CSS values stored when we first captured them
                    if (window.originalCssValues) {
                        Object.keys(window.originalCssValues).forEach(varName => {
                            const originalValue = window.originalCssValues[varName];

                            // Apply to CSS variable
                            document.documentElement.style.setProperty(varName, originalValue);

                            // Update color picker UI
                            const input = document.querySelector(`[data-var="${varName}"]`);
                            if (input) {
                                // Find the group containing this input
                                const group = input.closest('.color-picker-group');
                                if (group) {
                                    // Extract RGB/RGBA values
                                    let r, g, b, a = 1;

                                    if (originalValue.startsWith('rgba(')) {
                                        const matches = originalValue.match(/rgba\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,\s*([\d.]+)\s*\)/);
                                        if (matches) {
                                            [, r, g, b, a] = matches.map((v, i) => i === 4 ? parseFloat(v) : parseInt(v));
                                        }
                                    } else if (originalValue.startsWith('rgb(')) {
                                        const matches = originalValue.match(/rgb\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)/);
                                        if (matches) {
                                            [, r, g, b] = matches.map(v => parseInt(v));
                                        }
                                    } else if (originalValue.startsWith('#')) {
                                        const hex = originalValue.substring(1);
                                        r = parseInt(hex.substr(0, 2), 16);
                                        g = parseInt(hex.substr(2, 2), 16);
                                        b = parseInt(hex.substr(4, 2), 16);
                                        // Check if it's a 8-digit hex with alpha
                                        if (hex.length === 8) {
                                            a = parseInt(hex.substr(6, 2), 16) / 255;
                                        }
                                    }

                                    if (r !== undefined && g !== undefined && b !== undefined) {
                                        // Convert to hex
                                        const hexColor = rgbToHex(r, g, b);

                                        // Update color input
                                        input.value = hexColor;

                                        // Update alpha slider if it exists
                                        const alphaSlider = document.getElementById(`alpha-${input.id}`);
                                        if (alphaSlider) {
                                            alphaSlider.value = a;
                                        }

                                        // Update alpha value display
                                        const alphaValue = document.getElementById(`alpha-value-${input.id}`);
                                        if (alphaValue) {
                                            alphaValue.textContent = `${Math.round(a * 100)}%`;
                                        }

                                        // Update hex value display
                                        const hexValue = document.getElementById(`hex-${input.id}`);
                                        if (hexValue) {
                                            hexValue.value = `${hexColor}${alphaToHex(a)}`;
                                        }

                                        // Update color preview
                                        const colorPreview = document.getElementById(`preview-${input.id}`);
                                        if (colorPreview) {
                                            colorPreview.style.backgroundColor = originalValue;
                                        }
                                    }
                                }
                            }
                        });
                    }

                    // Reset themeColors object
                    window.themeColors = {};

                    // Clear theme name
                    document.getElementById('theme-name').value = '';

                    // Show reset confirmation
                    showConfirmation(document.getElementById('reset-theme'), 'Reset!', '#6c757d');
                };
            }
        }

        function extendExportImportFunctions() {
            // No need to extend export as it already uses the themeColors object
            // which is updated by our RGBA picker

            // Extend import function to handle RGBA values
            const originalImportTheme = window.importTheme;

            if (originalImportTheme) {
                window.importTheme = function(e) {
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
                            window.themeColors = themeData.colors;
                            Object.keys(window.themeColors).forEach(varName => {
                                const colorValue = window.themeColors[varName];
                                document.documentElement.style.setProperty(varName, colorValue);

                                // Update color picker UI
                                const input = document.querySelector(`[data-var="${varName}"]`);
                                if (input) {
                                    // Find the group containing this input
                                    const group = input.closest('.color-picker-group');
                                    if (group) {
                                        // Extract RGB/RGBA values
                                        let r, g, b, a = 1;

                                        if (colorValue.startsWith('rgba(')) {
                                            const matches = colorValue.match(/rgba\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,\s*([\d.]+)\s*\)/);
                                            if (matches) {
                                                [, r, g, b, a] = matches.map((v, i) => i === 4 ? parseFloat(v) : parseInt(v));
                                            }
                                        } else if (colorValue.startsWith('rgb(')) {
                                            const matches = colorValue.match(/rgb\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)/);
                                            if (matches) {
                                                [, r, g, b] = matches.map(v => parseInt(v));
                                            }
                                        } else if (colorValue.startsWith('#')) {
                                            const hex = colorValue.substring(1);
                                            r = parseInt(hex.substr(0, 2), 16);
                                            g = parseInt(hex.substr(2, 2), 16);
                                            b = parseInt(hex.substr(4, 2), 16);
                                            // Check if it's a 8-digit hex with alpha
                                            if (hex.length === 8) {
                                                a = parseInt(hex.substr(6, 2), 16) / 255;
                                            }
                                        }

                                        if (r !== undefined && g !== undefined && b !== undefined) {
                                            // Convert to hex
                                            const hexColor = rgbToHex(r, g, b);

                                            // Update color input
                                            input.value = hexColor;

                                            // Update alpha slider if it exists
                                            const alphaSlider = document.getElementById(`alpha-${input.id}`);
                                            if (alphaSlider) {
                                                alphaSlider.value = a;
                                            }

                                            // Update alpha value display
                                            const alphaValue = document.getElementById(`alpha-value-${input.id}`);
                                            if (alphaValue) {
                                                alphaValue.textContent = `${Math.round(a * 100)}%`;
                                            }

                                            // Update hex value display
                                            const hexValue = document.getElementById(`hex-${input.id}`);
                                            if (hexValue) {
                                                hexValue.value = `${hexColor}${alphaToHex(a)}`;
                                            }

                                            // Update color preview
                                            const colorPreview = document.getElementById(`preview-${input.id}`);
                                            if (colorPreview) {
                                                colorPreview.style.backgroundColor = colorValue;
                                            }
                                        }
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
                };
            }
        }

        // Helper functions

        // Convert RGB to Hex
        function rgbToHex(r, g, b) {
            return '#' + [r, g, b].map(x => {
                const hex = x.toString(16);
                return hex.length === 1 ? '0' + hex : hex;
            }).join('');
        }

        // Convert Hex to RGBA
        function hexToRgba(hex, alpha) {
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

        // Notification helper (if not defined in main script)
        if (typeof showNotification !== 'function') {
            window.showNotification = function(message, type) {
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
            };
        }

        // Button confirmation helper (if not defined in main script)
        if (typeof showConfirmation !== 'function') {
            window.showConfirmation = function(button, message, color) {
                const originalText = button.textContent;
                const originalBg = button.style.backgroundColor;

                button.textContent = message;
                button.style.backgroundColor = color;

                setTimeout(() => {
                    button.textContent = originalText;
                    button.style.backgroundColor = originalBg;
                }, 2000);
            };
        }

        // Add these helper functions to your theme-customizer.js file

// Helper: Convert RGB to Hex
        function rgbToHex(r, g, b) {
            return '#' + [r, g, b].map(x => {
                const hex = x.toString(16);
                return hex.length === 1 ? '0' + hex : hex;
            }).join('');
        }

// Helper: Convert Hex to RGBA
        function hexToRgba(hex, alpha) {
            const r = parseInt(hex.slice(1, 3), 16);
            const g = parseInt(hex.slice(3, 5), 16);
            const b = parseInt(hex.slice(5, 7), 16);
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        }

// Helper: Convert alpha value (0-1) to hex (00-ff)
        function alphaToHex(alpha) {
            const decimal = Math.round(alpha * 255);
            const hex = decimal.toString(16);
            return hex.length === 1 ? '0' + hex : hex;
        }

// Setup RGBA functionality
        function setupRgbaColorPickers() {
            // Find all color input groups
            const colorGroups = document.querySelectorAll('.color-picker-group');

            colorGroups.forEach(group => {
                // Get the original elements
                const originalLabel = group.querySelector('label');
                const originalInput = group.querySelector('input[type="color"]');

                if (!originalInput || !originalLabel) return;

                const varName = originalInput.dataset.var;

                // Current color state
                const colorState = {
                    hexColor: originalInput.value,
                    alpha: 1, // Default to 100% opacity
                    originalValue: getComputedStyle(document.documentElement).getPropertyValue(varName).trim()
                };

                // Determine initial alpha value from current CSS value
                if (colorState.originalValue.startsWith('rgba(')) {
                    const matches = colorState.originalValue.match(/rgba\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,\s*([\d.]+)\s*\)/);
                    if (matches) {
                        colorState.alpha = parseFloat(matches[4]);

                        // Convert RGB to hex for the color input
                        const r = parseInt(matches[1]);
                        const g = parseInt(matches[2]);
                        const b = parseInt(matches[3]);
                        colorState.hexColor = rgbToHex(r, g, b);
                        originalInput.value = colorState.hexColor;
                    }
                }

                // Save original HTML structure
                const originalHtml = group.innerHTML;

                // Create new RGBA picker HTML
                group.innerHTML = `
            <div class="color-picker-header">
                <label for="${originalInput.id}">${originalLabel.textContent}</label>
                <div class="color-preview" id="preview-${originalInput.id}"></div>
            </div>
            <div class="color-input-row">
                <input type="color" id="${originalInput.id}" data-var="${varName}" value="${colorState.hexColor}">
            </div>
            <div class="alpha-control">
                <div class="alpha-slider-row">
                    <span class="alpha-label">Opacity:</span>
                    <input type="range" class="alpha-slider" id="alpha-${originalInput.id}"
                           min="0" max="1" step="0.01" value="${colorState.alpha}">
                    <span class="alpha-value" id="alpha-value-${originalInput.id}">${Math.round(colorState.alpha * 100)}%</span>
                </div>
            </div>
        `;

                // Get the new elements
                const colorInput = document.getElementById(originalInput.id);
                const alphaSlider = document.getElementById(`alpha-${originalInput.id}`);
                const alphaValue = document.getElementById(`alpha-value-${originalInput.id}`);
                const colorPreview = document.getElementById(`preview-${originalInput.id}`);

                // Update function to apply RGBA color
                function updateColor() {
                    // Update color state
                    colorState.hexColor = colorInput.value;
                    colorState.alpha = parseFloat(alphaSlider.value);

                    // Generate RGBA
                    const rgbaColor = hexToRgba(colorState.hexColor, colorState.alpha);

                    // Update CSS variable
                    document.documentElement.style.setProperty(varName, rgbaColor);

                    // Update alpha percentage display
                    alphaValue.textContent = `${Math.round(colorState.alpha * 100)}%`;

                    // Update color preview
                    colorPreview.style.backgroundColor = rgbaColor;

                    // Store in theme colors (for save/export)
                    if (window.themeColors) {
                        window.themeColors[varName] = rgbaColor;
                    }
                }

                // Add event listeners
                colorInput.addEventListener('input', updateColor);
                alphaSlider.addEventListener('input', updateColor);

                // Initialize
                updateColor();
            });
        }

// Call setup after page is fully loaded
        window.addEventListener('load', function() {
            // Add a small delay to ensure everything is initialized
            setTimeout(setupRgbaColorPickers, 500);
        });
    });
</script>
