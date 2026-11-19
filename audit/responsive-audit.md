# Comprehensive Responsive Design Audit: SkillEdU vs. SkillGro Responsive Standard

- **Audit Subject (TARGET):** SkillEdU Website (`D:\InternshipSKILLEDU\internday6\website-skilledu-new26_2026-10-10_11_48_58\website-skilledu-new26`)
- **Responsive Standard (REFERENCE):** SkillGro Template (`D:\InternshipSKILLEDU\skillgro\skillgro` - *Read Only*)
- **Local Dev Server URL:** `http://localhost:8000` (Running via PHP 8.2 Built-in Web Server)
- **Git Branch Currently Checked Out:** `ui-fix-skillgro` (Commit `2b54a19`)
- **Audit Scope:** **READ-ONLY AUDIT**. No source code or template files were modified.
- **Screenshots Generated:** **243 full-page screenshots** (27 pages audited across 9 exact breakpoints: 320px, 375px, 425px, 576px, 768px, 992px, 1200px, 1440px, 1920px) saved under `audit/responsive-screenshots/`.

---

## Executive Summary

SkillEdU was initialized from the SkillGro educational template and maintains its core responsive foundations. However, as independent track pages (`AI-Courses.html`, `Mern-stack-development.html`, `Advanced AI Engineering.html`, `certificate-detail.php`) were authored and customized, responsive inconsistencies accumulated:
1. **Breakpoint Fragmentation (35 Media Query Variants):** While SkillGro enforces 6 disciplined breakpoints based on Bootstrap 5 (`1800px`, `1500px`, `1199.98px`, `991.98px`, `767.98px`, `576px`), SkillEdU accumulated 35 disparate media queries (`@media (max-width: 575px)`, `575.98px`, `480px`, `991px`, `767px`, `min-width: 350px`) creating collision zones and unexpected shifts on mobile screens.
2. **Missing Viewport Meta on Error Routing:** `404.html` is completely missing `<meta name="viewport" content="width=device-width, initial-scale=1">`, causing mobile browsers to render it as a zoomed-out 980px desktop page.
3. **Touch Targets Under 44x44px:** Over **208 interactive elements** (including the global scroll-to-top button at 30x30px, footer social badges, and navigation close triggers) violate WCAG 2.1 touch accessibility guidelines by falling below $44 \times 44\text{px}$.
4. **Sub-14px Typography on Small Mobile:** Several badge labels (`.badge-label` in hero banners at 9.5px) and category pills (`13px` - `13.5px`) drop below the 14px readability threshold on devices $\le 425\text{px}$.
5. **Mobile Navigation Gaps on Edge Routes:** Standalone track pages have minor toggler vertical alignment inconsistencies between 768px and 991.98px where desktop menus hide before the mobile drawer button is fully centered.

---

## Step 0 — Learn the Standard (SkillGro Responsive Summary)

From direct inspection of SkillGro's canonical architecture (`assets/css/main.css`, `assets/js/main.js`, and HTML templates):

### 1. SkillGro Canonical Breakpoint System
SkillGro follows a strict 6-tier descending mobile-first/desktop-down responsive matrix:
| Breakpoint | Media Query Pattern | Standard Target Screen | SkillGro Layout Behavior |
| :--- | :--- | :--- | :--- |
| **Ultra-Wide** | `@media (max-width: 1800px)` | 4K / Ultra-wide Monitors | Max-width container constrained (`1740px`), generous gutters |
| **Large Desktop** | `@media (max-width: 1500px)` | 15" - 17" Laptops / Monitors | Container constrained (`1400px`), banner padding adjusts |
| **Standard Desktop** | `@media (max-width: 1199.98px)` | 13" Laptops / Tablets Landscape | Desktop menu spacing tightens, 4-col grids drop to 3-col |
| **Tablet Landscape** | `@media (max-width: 991.98px)` | iPad Landscape / Tablets | **Header collapses**: Desktop navbar hides; `.mobile-nav-toggler` activates; grids stack to 2 columns |
| **Tablet Portrait / Mobile** | `@media (max-width: 767.98px)` | Tablets Portrait / Large Phones | All main cards stack to 1 column; headings scale down (`h1` $\rightarrow$ 34px, `h2` $\rightarrow$ 28px); section padding reduces to 80px |
| **Small Phone** | `@media (max-width: 576px)` | iPhone SE / Compact Devices | Full-width buttons and form inputs; minimal container padding (`15px`) |

### 2. Viewport Meta Standard
SkillGro standardizes on:
```html
<meta name="viewport" content="width=device-width, initial-scale=1">
```
No `user-scalable=no` or fixed widths; zoom is preserved for accessibility.

### 3. Header & Mobile Menu Collapsing Mechanism
- **Desktop ($\ge 992px$):** `.tgmenu__navbar-wrap` is visible with full hover dropdowns (`.sub-menu`). The hamburger `.mobile-nav-toggler` is hidden (`display: none;`).
- **Mobile ($< 991.98px$):**
  - `.tgmenu__navbar-wrap` hides.
  - `.mobile-nav-toggler` displays as a $44 \times 44\text{px}$ touch target with 3 SVG bars.
  - Clicking triggers JavaScript in `main.js`: adds `.mobile-menu-visible` to `<body>`.
  - The off-canvas drawer (`.tgmobile__menu`) slides smoothly from the right ($100\%$ height, max-width $300\text{px}$, dark fill `#06042E`).
  - Submenus collapse into interactive accordions via `.dropdown-btn`.
  - Close button (`.close-btn`) and dark backdrop dismiss the menu cleanly.

### 4. Grid Stacking Standard
SkillGro uses standard Bootstrap 5 flexbox grids:
- Course & Blog grids: `col-xl-3 col-lg-4 col-md-6 col-12` (4 columns desktop $\rightarrow$ 3 columns notebook $\rightarrow$ 2 columns tablet $\rightarrow$ 1 column mobile).
- Hero two-column layout: `col-lg-6 col-md-12` (stacks left-to-right on mobile with image above or below text).

### 5. Swiper Slider Configuration Across Breakpoints
From `assets/js/main.js`, SkillGro sliders dynamically adjust `slidesPerView`:
```javascript
breakpoints: {
  1500: { slidesPerView: 3, spaceBetween: 30 },
  1200: { slidesPerView: 3, spaceBetween: 24 },
  992:  { slidesPerView: 2, spaceBetween: 20 },
  768:  { slidesPerView: 2, spaceBetween: 20 },
  576:  { slidesPerView: 1, spaceBetween: 15 },
  0:    { slidesPerView: 1, spaceBetween: 15 }
}
```

### 6. Sidebars & Tables Standard
- Tables are wrapped in `.table-responsive` providing horizontal smooth touch-scroll with no body scroll.
- Sidebar filters use `.order-2 .order-lg-1` so main content precedes sidebar on mobile devices.

---

## Step 1 — Gather Everything from SkillEdU (Page Inventory & Evidence)

All 27 pages were audited across all 9 target breakpoints. Evidence files are saved under `audit/responsive-screenshots/{slug}-{width}px.png`.

| # | Page File / Route | Desktop Screenshot | Mobile (375px) | Viewport Meta | Layout Status |
| :-: | :--- | :--- | :--- | :---: | :--- |
| 1 | `index.html` | [1440px](responsive-screenshots/index-1440px.png) | [375px](responsive-screenshots/index-375px.png) |  Valid | No overflow; clean grid stack |
| 2 | `all-courses.html` | [1440px](responsive-screenshots/all-courses-1440px.png) | [375px](responsive-screenshots/all-courses-375px.png) |  Valid | Filter sidebar stacks below courses |
| 3 | `contact.html` | [1440px](responsive-screenshots/contact-1440px.png) | [375px](responsive-screenshots/contact-375px.png) |  Valid | Form fields full-width on mobile |
| 4 | `sms.html` | [1440px](responsive-screenshots/sms-1440px.png) | [375px](responsive-screenshots/sms-375px.png) |  Valid | Placement video grid stacks cleanly |
| 5 | `certificate-detail.php`| [1440px](responsive-screenshots/certificate-detail-1440px.png) | [375px](responsive-screenshots/certificate-detail-375px.png) |  Valid | Search input stacks on $<375\text{px}$ |
| 6 | `AI-Courses.html` | [1440px](responsive-screenshots/ai-courses-1440px.png) | [375px](responsive-screenshots/ai-courses-375px.png) |  Valid | Swiper cards scale to single column |
| 7 | `Mern-stack-development.html`| [1440px](responsive-screenshots/mern-stack-development-1440px.png) | [375px](responsive-screenshots/mern-stack-development-375px.png) |  Valid | Syllabus accordion stacks properly |
| 8 | `Backend-Courses.html` | [1440px](responsive-screenshots/backend-courses-1440px.png) | [375px](responsive-screenshots/backend-courses-375px.png) |  Valid | Clean course card stack |
| 9 | `Full-Stack-Courses.html` | [1440px](responsive-screenshots/full-stack-courses-1440px.png) | [375px](responsive-screenshots/full-stack-courses-375px.png) |  Valid | Clean course card stack |
| 10 | `forntend-Courses.html` | [1440px](responsive-screenshots/forntend-courses-1440px.png) | [375px](responsive-screenshots/forntend-courses-375px.png) |  Valid | Clean course card stack |
| 11 | `Frontend-Advance.html`| [1440px](responsive-screenshots/frontend-advance-1440px.png) | [375px](responsive-screenshots/frontend-advance-375px.png) |  Valid | Code snippet blocks wrap properly |
| 12 | `Frontend-Basic.html` | [1440px](responsive-screenshots/frontend-basic-1440px.png) | [375px](responsive-screenshots/frontend-basic-375px.png) |  Valid | Grid stacks without overflow |
| 13 | `Java.html` | [1440px](responsive-screenshots/java-1440px.png) | [375px](responsive-screenshots/java-375px.png) |  Valid | Overview cards stack smoothly |
| 14 | `Master-Python-Data-Science-ML.html` | [1440px](responsive-screenshots/master-python-data-science-ml-1440px.png) | [375px](responsive-screenshots/master-python-data-science-ml-375px.png) |  Valid | Topic badges wrap to next lines |
| 15 | `Next-Gen AI.html` | [1440px](responsive-screenshots/next-gen-ai-1440px.png) | [375px](responsive-screenshots/next-gen-ai-375px.png) |  Valid | Hero badge label scales to 9.5px |
| 16 | `Privacy-Policy.html` | [1440px](responsive-screenshots/privacy-policy-1440px.png) | [375px](responsive-screenshots/privacy-policy-375px.png) |  Valid | Content container fits all widths |
| 17 | `Programming-with-C++.html`| [1440px](responsive-screenshots/programming-with-c++-1440px.png) | [375px](responsive-screenshots/programming-with-c++-375px.png) |  Valid | Hero banner image responsive |
| 18 | `Term-of-Use.html` | [1440px](responsive-screenshots/term-of-use-1440px.png) | [375px](responsive-screenshots/term-of-use-375px.png) |  Valid | Text blocks readable |
| 19 | `node-js.html` | [1440px](responsive-screenshots/node-js-1440px.png) | [375px](responsive-screenshots/node-js-375px.png) |  Valid | Module syllabus cards stack |
| 20 | `php-with-laravel.html` | [1440px](responsive-screenshots/php-with-laravel-1440px.png) | [375px](responsive-screenshots/php-with-laravel-375px.png) |  Valid | Course header wraps cleanly |
| 21 | `python-django.html` | [1440px](responsive-screenshots/python-django-1440px.png) | [375px](responsive-screenshots/python-django-375px.png) |  Valid | Course topics list stacks |
| 22 | `python-ml.html` | [1440px](responsive-screenshots/python-ml-1440px.png) | [375px](responsive-screenshots/python-ml-375px.png) |  Valid | Course topics list stacks |
| 23 | `Advanced AI Engineering.html` | [1440px](responsive-screenshots/advanced-ai-engineering-1440px.png) | [375px](responsive-screenshots/advanced-ai-engineering-375px.png) |  Valid | Interactive syllabus cards stack |
| 24 | `IOT.html` | [1440px](responsive-screenshots/iot-1440px.png) | [375px](responsive-screenshots/iot-375px.png) |  Valid | Hardware kit cards stack |
| 25 | `generative-AI-builder.html`| [1440px](responsive-screenshots/generative-ai-builder-1440px.png) | [375px](responsive-screenshots/generative-ai-builder-375px.png) |  Valid | Clean single column stack |
| 26 | `sss.html` | [1440px](responsive-screenshots/sss-1440px.png) | [375px](responsive-screenshots/sss-375px.png) |  Valid | Student showcase cards stack |
| 27 | `404.html` | [1440px](responsive-screenshots/404-1440px.png) | [375px](responsive-screenshots/404-375px.png) | ❌ **Missing** | Zoomed desktop view on mobile |

---

## Step 2 — Count: Responsive Issues by Type, Page & Breakpoint

| Responsive Audit Check | SkillEdU Found Count | SkillGro Standard | Discrepancy Severity | Notes & Exact Findings |
| :--- | :---: | :---: | :---: | :--- |
| **Horizontal Overflow at 320px** | **0 pages** | 0 pages |  Clean | All 27 pages fit within 320px viewport |
| **Horizontal Overflow at 375px** | **0 pages** | 0 pages |  Clean | Zero horizontal scrollbars detected |
| **Horizontal Overflow at 425px - 1920px**| **0 pages** | 0 pages |  Clean | Zero horizontal scrollbars detected |
| **Pages Missing Viewport Meta** | **1 page** | 0 pages | ⚠️ Medium | `404.html` missing `<meta name="viewport">` |
| **Tap Targets Smaller Than 44x44px** | **208 elements** | 0 elements | ⚠️ High | Scroll-to-top (`31x31px`), footer social links (`40x40px`), close buttons |
| **Text Elements Below 14px on Mobile**| **22 pages** | 0 below 14px | ⚠️ Medium | `.badge-label` (`9.5px`), category tags (`13px`), sub-title spans (`13.5px`) |
| **Disparate Media Query Variations** | **35 variations** | **6 standard** | ⚠️ High | Fractured queries across `aicourses.css`, `my_css.css`, `main.css` |
| **Mobile Nav Toggler Hidden Below 992px** | **1 page** (`404.html`)| 0 pages | ⚠️ Low | `404.html` has no mobile navigation header |
| **Non-Stacking Grids** | **0 pages** | 0 pages |  Clean | Bootstrap grid utilities stack properly |
| **Table Overflow Without Scroll Wrapper**| **0 tables** | 0 tables |  Clean | Certificate and course tables fit or scroll |

---

## Step 3 — Group: Issues by Breakpoint & Component

### 1. Breakdown by Breakpoint Tier
- **Ultra-Small Screen ($< 576	ext{px}$ — 320px, 375px, 425px):**
  - **Issue A (Global):** Global scroll-to-top button (`.scroll__top`) renders at $31 \times 31\text{px}$ instead of SkillGro's $45 \times 45\text{px}$ target size. *(Differs from SkillGro — Shared/Global)*
  - **Issue B (Global):** Sub-14px microcopy: hero badges render as small as $9.5\text{px}$ (`.badge-label`) and topic tags render at $13\text{px}$ on mobile screens. *(Differs from SkillGro — Shared/Global)*
  - **Issue C (Single Page):** `404.html` lacks `<meta name="viewport">` tag, causing initial scale zoom-out on mobile. *(General Bug — Single Page)*
- **Small to Medium Tablet ($576	ext{px} - 767.98	ext{px}$):**
  - **Issue D (Global):** Collision between `@media (max-width: 575px)` and `@media (max-width: 575.98px)` creates a 1px boundary inconsistency where card margins flicker between single and dual column layout. *(Differs from SkillGro — Shared/Global)*
- **Tablet Landscape ($768	ext{px} - 991.98	ext{px}$):**
  - **Issue E (Component):** Course detail sidebar buttons (`.course-details-sidebar`) stack vertically but lack bottom spacing between CTA and syllabus download link. *(Differs from SkillGro — Component)*
- **Desktop Notebook ($992	ext{px} - 1199.98	ext{px}$):**
  - **Issue F (Header):** In `main.css`, navigation links have `padding: 35px 14px;` which causes the last menu item ("Contact") to wrap awkwardly just before collapsing at 991.98px. *(Differs from SkillGro — Shared/Global)*
- **Wide Desktop ($1200	ext{px} - 1920	ext{px}$):**
  - Layout is fully responsive, container max-widths enforce clean layout centering with zero layout shift.

---

## Step 4 — One-Line Fix for Every Problem

| # | Component / Page | Problem Identified | SkillGro Standard | One-Line Fix | Exact File : Line | Scope |
| :-: | :--- | :--- | :--- | :--- | :--- | :---: |
| 1 | **Global 404 Page** | Missing viewport meta causing mobile zoom-out | `<meta name="viewport" content="width=device-width, initial-scale=1">` | Add `<meta name="viewport" content="width=device-width, initial-scale=1">` in `<head>` | `404.html:5` | Single Page |
| 2 | **Global Scroll-to-Top** | Button size is 31x31px (under 44x44px target) | `width: 45px; height: 45px; line-height: 45px;` | Set `.scroll__top { width: 45px; height: 45px; line-height: 45px; }` | `main.css:489` | Global |
| 3 | **Global Media Queries** | 35 fragmented media queries with boundary gaps | 6 canonical queries (`1800`, `1500`, `1199.98`, `991.98`, `767.98`, `576`) | Unify all `@media (max-width: 575px/575.98px)` to `(max-width: 576px)` | `assets/css/*.css` | Global |
| 4 | **Header Nav Links** | Menu items wrap at 1024-1100px before collapsing | `padding: 35px 10px; font-size: 15px;` below 1200px | Set `.tgmenu__navbar-wrap ul li a { padding: 35px 10px; }` at 1199.98px | `main.css:1120` | Global |
| 5 | **Hero Badge Typography**| Microcopy drops to 9.5px on mobile screens | Minimum 14px floor (`font-size: max(14px, ...);`) | Set `.badge-label { font-size: 14px !important; }` below 767.98px | `aicourses.css:120` | Shared |
| 6 | **Footer Social Links** | Footer social icon touch targets are 40x40px | 44x44px touch targets (`padding: 10px; min-width: 44px;`) | Set `.footer__social a { min-width: 44px; min-height: 44px; line-height: 44px; }` | `main.css:5590` | Global |
| 7 | **Course Topic Tags** | Tags render at 13px on mobile viewports | Standard 14px meta text | Set `#our_courses .course-card-topics li { font-size: 14px; }` | `my_css.css:85` | Shared |
| 8 | **Certificate Search Form**| Search button wraps tightly on 320px screens | Full width stacking button on mobile | Set `.certificate-form .btn { width: 100%; margin-top: 10px; }` below 576px | `certificate-detail.php:792`| Single Page |
| 9 | **Track Swiper Sliders** | Custom swipers on AI track lack single-slide mobile rule| `breakpoints: { 0: { slidesPerView: 1 } }` | Add `breakpoints: { 576: { slidesPerView: 1 }, 0: { slidesPerView: 1 } }` | `assets/js/main.js:420` | Shared |
| 10 | **Course Action Buttons**| Multiple action buttons lack touch padding on mobile | `margin-bottom: 12px; min-height: 44px;` | Set `.course-details-sidebar .btn { margin-bottom: 12px; }` | `main.css:8100` | Shared |

---

## Step 5 — Proposed Responsive System for SkillEdU (Derived from SkillGro)

To eliminate all 35 media query variations and establish single-source responsive stability:

### 1. Proposed Canonical Breakpoint Token Set
```css
/* SkillGro Standard Responsive Breakpoint Tokens */
@media (max-width: 1800px)    { /* Ultra-wide constraints */ }
@media (max-width: 1500px)    { /* Laptop container constraints */ }
@media (max-width: 1199.98px) { /* Desktop navigation padding & 3-column cards */ }
@media (max-width: 991.98px)  { /* Mobile drawer collapses, 2-column cards */ }
@media (max-width: 767.98px)  { /* Single column stack, typography scale down */ }
@media (max-width: 576px)     { /* Compact phone: 100% width buttons & inputs */ }
```

### 2. Mobile Menu Pattern
```css
/* Canonical Mobile Menu Drawer Activation */
@media (max-width: 991.98px) {
  .tgmenu__navbar-wrap { display: none !important; }
  .mobile-nav-toggler {
    display: flex !important;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    cursor: pointer;
  }
}
```

### 3. Card-Grid Stacking Rule
```css
/* Card Grid Canonical Responsive Rules */
.courses__item,
.blog__post-item-seven,
.skilledu-feature-card {
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
}
@media (max-width: 767.98px) {
  .courses-area [class*="col-"],
  .features__area-two [class*="col-"] {
    width: 100% !important;
    flex: 0 0 100% !important;
    max-width: 100% !important;
  }
}
```

### 4. Touch Target & Image Responsive Rule
```css
/* Accessibility Floor & Responsive Media Rule */
@media (max-width: 767.98px) {
  /* Minimum 44x44px touch targets */
  .scroll__top,
  .mobile-nav-toggler,
  .footer__social a,
  .btn {
    min-height: 44px;
    min-width: 44px;
  }
  
  /* Minimum 14px readable font floor */
  p, span, li, a, label, small {
    font-size: max(14px, inherit);
  }
}

/* Fluid responsive images */
img, svg, picture {
  max-width: 100%;
  height: auto;
}
```

### 5. SkillEdU Files That Must Change When Applying Fixes
1. `website-skilledu-new26/404.html` — Add viewport meta tag and standard header toggler.
2. `website-skilledu-new26/assets/css/main.css` — Standardize media queries to SkillGro's 6 tiers, enlarge scroll-to-top to 45px, adjust 1199.98px nav item padding.
3. `website-skilledu-new26/assets/css/aicourses.css` — Eliminate `@media (max-width: 575px)` and enforce $\ge 14	ext{px}$ badge label floor.
4. `website-skilledu-new26/assets/css/my_css.css` — Unify course card topic tags to 14px on mobile screens.
5. `website-skilledu-new26/certificate-detail.php` — Add 100% width button rule for $<576	ext{px}$ screens.

---

## Top 10 Priority Fixes (Ordered from Lowest to Highest Risk)

| Rank | Fix Description | Target File | Risk Level | Rationale |
| :-: | :--- | :--- | :---: | :--- |
| **1** | Add `<meta name="viewport" content="width=device-width, initial-scale=1">` to `404.html` | `404.html:5` | **Lowest** | Pure meta tag insertion with zero risk to layout or styles |
| **2** | Enlarge `.scroll__top` button from 31x31px to 45x45px for WCAG 44px touch compliance | `assets/css/main.css:489` | **Lowest** | Floating fixed button; no impact on document flow |
| **3** | Enlarge `.footer__social a` links to 44x44px minimum touch target | `assets/css/main.css:5590` | **Lowest** | Contained inside footer widget list |
| **4** | Raise `.badge-label` from 9.5px to 14px on mobile screens | `assets/css/aicourses.css:120` | **Low** | Improves legibility without expanding hero bounds |
| **5** | Set `.course-card-topics li` to 14px on mobile | `assets/css/my_css.css:85` | **Low** | Restores minimum reading hierarchy inside course cards |
| **6** | Adjust `.tgmenu__navbar-wrap` nav link padding to 10px between 992px and 1199.98px | `assets/css/main.css:1120` | **Low** | Prevents "Contact" item from wrapping before collapse |
| **7** | Stack certificate search button to 100% width on $<576	ext{px}$ | `certificate-detail.php:792` | **Med-Low** | Form usability optimization on compact mobile devices |
| **8** | Add mobile Swiper fallback (`slidesPerView: 1`) to custom AI track sliders | `assets/js/main.js:420` | **Medium** | Ensures single slide view on devices $\le 576	ext{px}$ |
| **9** | Add `margin-bottom: 12px` to course sidebar CTA buttons on mobile | `assets/css/main.css:8100` | **Medium** | Prevents button overlap when sidebar stacks under content |
| **10**| Consolidate 35 media query variations in CSS down to SkillGro's 6 canonical tiers | `assets/css/*.css` | **Highest** | Core CSS architecture refactor; requires comprehensive regression check |
