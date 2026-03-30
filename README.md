# Extend Elements for Elementor

Custom Elementor widgets, each in its own folder under `widgets/`.

## Folder structure

```
extend-elements-for-elementor/
├── extend-elements.php          # Main plugin file (bootstrap)
├── includes/
│   ├── loader.php               # Loads widget manager
│   └── widget-manager.php       # Registers assets + scans widgets/*/widget.php
├── widgets/
│   └── {widget-slug}/
│       ├── widget.php           # Widget class (extends Elementor\Widget_Base)
│       ├── style.css            # Optional; handle eefe-widget-{widget-slug}
│       └── script.js            # Optional; same handle as style
├── assets/
│   ├── css/                     # Shared plugin CSS (optional)
│   └── js/                      # Shared plugin JS (optional)
├── README.md
├── LICENSE
└── screenshot.png               # Banner for WordPress.org (e.g. 772×250); replace as needed
```

## Adding a widget

1. Create `widgets/your-slug/` (lowercase letters, numbers, hyphens only).
2. Add `widget.php` with a class extending `Elementor\Widget_Base`.
3. Optionally add `style.css` and/or `script.js`. The plugin registers handle `eefe-widget-your-slug` for each file that exists—use that handle in `get_style_depends()` / `get_script_depends()`.
4. Reload the Elementor editor.

## Main plugin file rename

If you previously used `extend-elements-for-elementor.php` as the bootstrap file, switch WordPress to use `extend-elements.php` (deactivate the old entry if needed, then activate the plugin again).

## Included widget

- **Gradient Heading** (`widgets/gradient-heading/`) — gradient text, typography, alignment, animation presets (Shimmer, Pulse, Wave, Float).

## Requirements

- WordPress 5.0+
- [Elementor](https://wordpress.org/plugins/elementor/) installed and active
