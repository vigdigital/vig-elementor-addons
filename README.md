# VIG Elementor Addons

Custom Elementor widgets by [VIG Digital](https://vigdigital.com) — timeline, product carousels, video carousel and icon search.

> Bộ widget Elementor tuỳ chỉnh của VIG Digital: Timeline, Product Carousel, Video Carousel, Icon Search.

## Widgets

| Widget | `get_name` | Description |
|---|---|---|
| Timeline | `vig_timeline` | Vertical/horizontal timeline blocks |
| Product Carousel | `vig_product_carousel` | Carousel of `product` CPT items |
| Product Tab Carousel | `vig_product_carousel_tabs` | Product carousel with category tabs (Polylang-aware) |
| Video Carousel | `vig_video_carousel` | Responsive video slider |
| Icon Search | `vig_icon_search` | Searchable icon grid |

Toggle individual widgets in **WP Admin → VIG Toolkit → Elementor Addons**.

## Requirements

- WordPress 6.0+
- PHP 7.4+
- [Elementor](https://elementor.com) (free) — declared via `Requires Plugins: elementor`

## Installation

1. Download the latest `vig-elementor-addons.zip` from [Releases](https://github.com/vigdigital/vig-elementor-addons/releases).
2. WP Admin → **Plugins → Add New → Upload Plugin** → choose the zip → **Install** → **Activate**.

> Do **not** use GitHub's green "Download ZIP" button — its folder name is wrong for WordPress. Always use the release asset above (or let auto-update handle it).

## Updates

Self-update is powered by [Plugin Update Checker](https://github.com/YahnisElsts/plugin-update-checker) reading this repo's GitHub Releases. When a new release is tagged, WordPress shows a normal **Update** prompt under Plugins.

Because this repo is **private**, each site must authorise access via `wp-config.php`:

```php
// ⚠️ Quote the token string. Give the token only `repo` scope.
define( 'VIG_GH_TOKEN', 'ghp_xxxxxxxxxxxxxxxxxxxx' );
```

(Public repos / a VIG update server do not need this.)

## Releasing (maintainers)

Tagging a version automatically builds a clean zip and attaches it to the release — see [`.github/workflows/build-release.yml`](.github/workflows/build-release.yml).

```bash
# bump Version: in vig-elementor-addons.php + VIG_ADDON_VERSION, commit, then:
git tag v2.1.0
git push origin v2.1.0
```

## License

GPL-2.0-or-later © VIG Digital
