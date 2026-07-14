# 🧩 VIG Elementor Addons

**Thêm những widget kéo-thả đẹp mắt cho Elementor — timeline, carousel sản phẩm, carousel video, tìm icon. Cài xong là có ngay trong trình dựng trang.**

Nếu bạn đang dựng website bằng **Elementor**, bộ widget này giúp trang của bạn sinh động hơn mà không cần thuê code riêng.

## Có thêm những widget nào

- 🗓️ **Timeline** — dòng thời gian / các mốc sự kiện
- 🛍️ **Product Carousel** — trình chiếu sản phẩm dạng trượt
- 🗂️ **Product Tab Carousel** — carousel sản phẩm có tab theo danh mục
- 🎬 **Video Carousel** — trình chiếu video responsive
- 🔍 **Icon Search** — lưới icon có ô tìm kiếm

Bật/tắt từng widget trong **VIG Toolkit → Elementor Addons**.

## Cần gì để dùng

- Website WordPress đã cài **[Elementor](https://elementor.com)** (bản miễn phí là đủ).

## Cài đặt trong 2 phút

1. Tải file cài đặt mới nhất ở trang [Releases](../../releases).
2. Vào **WordPress → Plugins → Cài mới → Tải plugin lên**, chọn file vừa tải → **Cài đặt** → **Kích hoạt**.
3. Mở trình dựng trang Elementor — các widget "VIG" đã nằm sẵn trong danh sách, chỉ việc **kéo vào trang**.

## Cập nhật

Khi có phiên bản mới, WordPress sẽ tự báo — bạn chỉ cần bấm **Cập nhật** như mọi plugin khác.

## Cần hỗ trợ?

VIG Elementor Addons được phát triển & đồng hành bởi **[VIG Digital](https://vigdigital.com)**. Có widget nào bạn mong muốn? Cứ nhắn tụi mình nhé. 🙌

---

<details>
<summary><b>Dành cho developer / maintainer</b></summary>

> 📚 *Về sau, tài liệu kỹ thuật đầy đủ sẽ chuyển lên **vigdigital.com** — khi đó mục này rút gọn thành một liên kết.*

**Widget `get_name`:**

| Widget | `get_name` |
|---|---|
| Timeline | `vig_timeline` |
| Product Carousel | `vig_product_carousel` |
| Product Tab Carousel | `vig_product_carousel_tabs` |
| Video Carousel | `vig_video_carousel` |
| Icon Search | `vig_icon_search` |

- **Yêu cầu:** WordPress 6.0+, PHP 7.4+, Elementor (khai báo qua `Requires Plugins: elementor`).
- **Tự cập nhật:** dùng [Plugin Update Checker](https://github.com/YahnisElsts/plugin-update-checker) đọc GitHub Releases. Repo đang private → site cần được cấp quyền để nhận update (xử lý theo VIG internal ops notes, không đặt token trong repo).
- **Phát hành bản mới:** bump `Version:` + `VIG_ADDON_VERSION` trong `vig-elementor-addons.php` → commit → `git tag v2.1.0 && git push origin v2.1.0`. GitHub Action (`.github/workflows/build-release.yml`) tự build zip sạch và đính vào Release.

GPL-2.0-or-later © VIG Digital

</details>
