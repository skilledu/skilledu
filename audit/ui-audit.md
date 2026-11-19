# Comprehensive UI Design Audit: SkillEdU vs. SkillGro Design Standard

- **Audit Subject (TARGET):** SkillEdU Website (`D:\InternshipSKILLEDU\internday6\website-skilledu-new26_2026-10-10_11_48_58\website-skilledu-new26`)
- **Design Standard (REFERENCE):** SkillGro Template (`D:\InternshipSKILLEDU\skillgro\skillgro` - *Read Only*)
- **Local Dev Server URL:** `http://localhost:8000` (Served via PHP 8.2 Development Server)
- **Status:** **READ ONLY AUDIT COMPLETE** (No template or source files were modified during this audit)

---

## Executive Summary

SkillEdU was originally initialized from the SkillGro educational template, but over iterative customizations, its design system has severely fractured:
1. **Primary & Accent Colors Drifted:** The brand identity shifted from SkillGro's signature vibrant purple `#5751E1` and golden secondary `#FFC224` into at least **48 disconnected shades of blue** (`#0b66c3`, `#0866c6`, `#0866d1`, `#0959a9`, `#0284c7`, `#050071`, `#2f466a`) and fragmented amber/oranges.
2. **Grey & Neutral Explosion:** Instead of SkillGro's disciplined neutral scale (4 core functional shades: background `#F7F7F9`, badge pill `#EFEEFE`, border `#B5B5C3`, and shadow `#CAC9D6`), SkillEdU accumulated **50 distinct shades of grey** across CSS rules and ad-hoc inline styles.
3. **Typography & Hierarchy Inconsistency:** Headings fluctuate randomly between 18px and 48px with 36 distinct font sizes and 28 distinct line-height values. Ad-hoc font weights and line heights break vertical reading rhythm.
4. **Spacing Breakdown:** Sections violate SkillGro's standardized `section-py-120` (120px) / `section-pb-90` (90px) rhythm by stacking conflicting utility classes (`pt-60 section-py-120`) and inline overrides (`style="padding: 0px 0;"`, `style="width: 800px;"`, `style="margin-left: -48px;"`).
5. **Component Fragmentation:** Buttons exist in **15 different variations** with mismatched padding, radii, border styles, and shadows. Cards mix soft blurred box-shadows, translate hovers, and missing borders, losing SkillGro's signature brutalist-modern `drop-shadow(10px 10px 0px #CAC9D6)`.

---

## Step 0 — Learn the Standard (SkillGro System Summary)

From direct inspection of SkillGro's canonical stylesheets (`assets/css/main.css` `:root` tokens and `assets/css/spacing.css`):

### 1. Color Palette Tokens (`:root`)
| Category | Token | Hex Value | Purpose & Application |
| :--- | :--- | :--- | :--- |
| **Brand Primary** | `--tg-theme-primary` | `#5751E1` | Primary CTA buttons, active links, badge pill text, icons |
| **Brand Secondary** | `--tg-theme-secondary` | `#FFC224` | Secondary buttons (`.btn-two`), warning badges, accent highlights |
| **Heading Text** | `--tg-heading-color` | `#161439` | All headings (`h1`-`h6`), titles, high-contrast labels |
| **Body Text** | `--tg-body-color` | `#6D6C80` | Paragraph text, descriptions, metadata |
| **Primary Shadow** | `--tg-common-color-blue` | `#050071` | Hard box-shadow for primary buttons (`4px 6px 0px 0px #050071`) |
| **Secondary Shadow**| `--` | `#3D3D3D` | Hard box-shadow for secondary buttons (`4px 4px 0px 0px #3D3D3D`) |
| **Dark / Black** | `--tg-common-color-black` | `#06042E` | Deep dark backgrounds, mega menu base |
| **Dark Accent** | `--tg-common-color-dark` | `#1C1A4A` | Footer background, dark card contrast |
| **Background Grey** | `--tg-common-color-gray` | `#F7F7F9` | Neutral section backgrounds, alternating strips |
| **Pill Tint Grey** | `--tg-common-color-gray-2` | `#EFEEFE` | Section title badge background (`.sub-title`) |
| **Card Border** | `--` | `#B5B5C3` | 1px solid stroke on all course and feature cards |
| **Card Hover Shadow**| `--` | `#CAC9D6` | Signature hover drop-shadow (`drop-shadow(10px 10px 0px #CAC9D6)`) |
| **Input Background** | `--` | `#F4F3F8` | Form field background fill |
| **Divider Border** | `--tg-border-1` | `#C9C9DD` | Border dividers, subtle hairline borders |

### 2. Typography Standard
- **Body Font:** `'Inter', sans-serif` (`--tg-body-font-family`), size `16px`, line-height `1.75`, weight `400` (Regular) / `500` (Medium).
- **Heading Font:** `'Poppins', sans-serif` (`--tg-heading-font-family`), line-height `1.3`, weights `600` (Semi-bold) / `700` (Bold).
- **Type Scale:**
  - `h1`: `48px` (`line-height: 1.25`)
  - `h2` / `.section__title .title`: `36px` desktop / `28px` mobile (`line-height: 1.33`)
  - `h3`: `24px` (`line-height: 1.35`)
  - `h4`: `20px` (`line-height: 1.4`)
  - `h5`: `18px` (`line-height: 1.45`)
  - `h6`: `16px` (`line-height: 1.5`)
  - Body / Paragraph: `16px` (`line-height: 1.75`)
  - Small / Meta / Badge: `14px` (`line-height: 1.62`)

### 3. Spacing Scale (`assets/css/spacing.css`)
- **Section Spacing Standards:**
  - `section-py-120`: `padding: 120px 0;` (Standard section vertical rhythm)
  - `section-pt-120`: `padding-top: 120px;`
  - `section-pb-90`: `padding-bottom: 90px;` (Standard bottom section breathing room before card rows)
  - `section-py-140`: `padding: 140px 0;` (Hero / prominent featured blocks)
- **Element Utility Scale:** Standard 5px increments (`mt-10`, `mt-15`, `mt-20`, `mt-25`, `mt-30`, etc.).

### 4. Component Standards
- **Primary Button (`.btn`):**
  - Background: `var(--tg-theme-primary)` (`#5751E1`)
  - Color: `#FFFFFF`
  - Typography: Poppins 16px, weight 600, line-height 1.12
  - Padding: `16px 30px`
  - Border Radius: `50px` (pill)
  - Shadow: `4px 6px 0px 0px #050071`
  - Overflow: `hidden`, transition: `0.3s ease-out`
- **Secondary Button (`.btn.btn-two`):**
  - Background: `var(--tg-theme-secondary)` (`#FFC224`)
  - Color: `#000000`
  - Border: `2px solid #000000`
  - Shadow: `4px 4px 0px 0px #3D3D3D`
  - Padding: `16px 30px`
  - Border Radius: `50px`
- **Icon Modifier (`.arrow-btn`):**
  - Animated double SVG arrows shifting on hover.
- **Course / Content Card (`.courses__item`):**
  - Background: `#FFFFFF`
  - Border: `1px solid #B5B5C3`
  - Border Radius: `10px`
  - Padding: `25px 25px 32px`
  - Hover: `filter: drop-shadow(10px 10px 0px #CAC9D6);`
- **Section Title Block (`.section__title`):**
  - Sub-title badge (`.sub-title`): `display: inline-block; background: #EFEEFE; color: #5751E1; border-radius: 30px; padding: 3px 16px; font-weight: 500; font-size: 14px; margin-bottom: 14px;`
  - Title (`.title`): `font-size: 36px; line-height: 1.33; font-family: 'Poppins', sans-serif; font-weight: 700; color: #161439; margin-bottom: 0;`
  - Description (`.desc`): `font-size: 16px; line-height: 1.75; color: #6D6C80; margin-top: 15px;`
- **Form Inputs (`.form-grp input`):**
  - Height: `45px`
  - Background: `#F4F3F8`
  - Border: `none`
  - Border Radius: `4px`
  - Padding: `10px 20px`
  - Typography: 14px, color: `#161439`

---

## Step 1 — Gather Everything from SkillEdU (Inventory & Evidence)

### 1. Target Pages Audited
The following pages were loaded on `http://localhost:8000` and visual evidence was captured:
1. `index.html` (Main Home Page) — `screenshots/01-home-desktop.png`
2. `all-courses.html` (Course Catalog) — `screenshots/02-all-courses.png`
3. `contact.html` (Contact Us) — `screenshots/03-contact.html.png`
4. `sms.html` (Social Media / Placement Showcase) — `screenshots/04-sms.png`
5. `certificate-detail.php` (Certificate Verification) — `screenshots/05-certificate-detail.png`
6. `AI-Courses.html` (AI Course Track) — `screenshots/06-ai-courses.png`
7. `Mern-stack-development.html` (MERN Course Track) — `screenshots/07-mern-stack.png`
8. `Term-of-Use.html` (Terms & Policies) — `screenshots/08-term-of-use.png`

### 2. Section Visual Evidence (Home Page)
| Section Name | Screenshot | Visual Reference | Key Findings Observed |
| :--- | :--- | :--- | :--- |
| **Header / Nav** | `sec-01-header.png` | ![Header](screenshots/sec-01-header.png) | Inline height `81px`, negative margin `-13px`, inconsistent CTA button |
| **Hero Banner** | `sec-02-hero.png` | ![Hero Banner](screenshots/sec-02-hero.png) | Ad-hoc `--tg-neutral-50` background, fixed `width: 800px` inline text container, negative margin `-40px` |
| **Popular Categories** | `sec-04-categories.png` | ![Categories](screenshots/sec-04-categories.png) | Clashing padding `pt-60 section-py-120`, missing standardized hover elevation |
| **About Section** | `sec-09-about.png` | ![About](screenshots/sec-09-about.png) | Inline `padding: 0px 0;` clashing with `section-pb-120`, hardcoded link colors |
| **Marquee Ticker** | `sec-05-marquee.png` | ![Marquee](screenshots/sec-05-marquee.png) | Ad-hoc border and color values not linked to SkillGro tokens |
| **Docker Workshop**| `sec-06-docker.png` | ![Docker Workshop](screenshots/sec-06-docker.png) | Overridden with ad-hoc `--radius-xl` inline styles, inconsistent badges |
| **Our Courses** | `sec-03-courses.png` | ![Our Courses](screenshots/sec-03-courses.png) | Missing `filter: drop-shadow(10px 10px 0px #CAC9D6)` hover; courses items use soft box-shadow |
| **Testimonial** | `sec-10-testimonial.png` | ![Testimonial](screenshots/sec-10-testimonial.png) | Clashing `pt-60 section-py-120`, badge styling mismatch |
| **FAQ Accordion** | `sec-11-faq.png` | ![FAQ](screenshots/sec-11-faq.png) | Inconsistent border radius and card stroke values |
| **CTA Block** | `sec-07-cta.png` | ![CTA Area](screenshots/sec-07-cta.png) | Inline `style="background-color: var(--tg-neutral-800);"` breaking dark token harmony |
| **Footer** | `sec-08-footer.png` | ![Footer](screenshots/sec-08-footer.png) | Multiple dark backgrounds (`#082a5e`, `#031333`, `#111827`) instead of `--tg-common-color-dark: #1C1A4A` |

---

## Step 2 — Count & Comparison Table

| Design System Item | SkillEdU Found | SkillGro Standard | Status | Discrepancy Note |
| :--- | :---: | :---: | :---: | :--- |
| **Primary Blue/Purple Shades** | **48** | **1** (`#5751E1`) | ⚠️ Severe Drift | `#0b66c3`, `#0866c6`, `#0866d1`, `#0959a9`, `#0284c7`, etc. |
| **Secondary Yellow Shades** | **3** | **1** (`#FFC224`) | ⚠️ Drift | `#ffc224`, `#f8bc24`, `#fcb428` |
| **Grey / Neutral Shades** | **50** | **4** Core Tokens | ⚠️ Severe Bloat | 50 arbitrary hex values across CSS and HTML |
| **Dark / Black Values** | **4** | **2** (`#161439`, `#1C1A4A`) | ⚠️ Inconsistent | `#000`, `#23232b`, `#171717`, `#141109` |
| **Font Families** | **4** | **2** (`Inter`, `Poppins`) | ⚠️ Fragmented | Body mixes Inter, Poppins, system sans-serif, and FontAwesome |
| **Unique Font Sizes** | **36** | **9** Steps | ⚠️ Unscaled | From 12px to 48px with arbitrary 13px, 15px, 22px, 26px, 35px |
| **Line Height Values** | **28** | **3** Standard Steps | ⚠️ Unscaled | 1.12 (btn), 1.3 (headings), 1.75 (body) vs. 28 ad-hoc values |
| **Primary Button Variants** | **15** | **1** (`.btn`) | ⚠️ Inconsistent | 15 different class strings and override styles |
| **Secondary Button Variants**| **5** | **1** (`.btn.btn-two`)| ⚠️ Inconsistent | Missing black border, wrong shadows |
| **Card Components** | **8** | **2** (`.courses__item`) | ⚠️ Drift | Course cards lack SkillGro's brutalist drop-shadow hover |
| **Section Spacing Utilities**| **18** | **3** (`py-120`, `pt-120`, `pb-90`) | ⚠️ Conflicting | Double paddings (`pt-60 section-py-120`) and inline `padding: 0` |
| **Form Input Styles** | **6** | **1** (`.form-grp input`) | ⚠️ Inconsistent | Differing heights (40-60px), borders, and padding |

---

## Step 3 — Group & Classify Near-Duplicates

### 1. Primary Colors & Accent Blues (48 values -> 1 SkillGro Token)
| Found Value | Frequency | Sample Locations | Classification | Target Mapping |
| :--- | :---: | :--- | :--- | :--- |
| `#0b66c3` | 11 | `main.css:53`, `main.css:5819`, `main.css:10356` | **NEAR-MATCH** | `--tg-theme-primary` (`#5751E1`) |
| `#0284c7` | 6 | `main.css:7849`, `main.css:7882`, `main.css:7929` | **OFF-SYSTEM** | `--tg-theme-primary` (`#5751E1`) |
| `#0866c6` | 4 | `main.css:1120`, `main.css:4820` | **NEAR-MATCH** | `--tg-theme-primary` (`#5751E1`) |
| `#0866d1` | 3 | `main.css:2104`, `main.css:4950` | **NEAR-MATCH** | `--tg-theme-primary` (`#5751E1`) |
| `#0959a9` | 3 | `main.css:6100`, `main.css:8400` | **NEAR-MATCH** | `--tg-theme-primary` (`#5751E1`) |
| `#050071` | 6 | `main.css:56`, `main.css:4973`, `main.css:4974` | **MATCHES** | `--tg-common-color-blue` (Button Shadow) |
| `#282568` | 2 | `main.css:57`, `main.css:3709` | **MATCHES** | `--tg-common-color-blue-2` |
| `#5751e1` | 1 | `main.css:54` | **MATCHES** | `--tg-theme-primary` |

### 2. Neutral & Grey Shades (50 values -> 4 SkillGro Tokens)
| Found Value | Frequency | Sample Locations | Classification | Target Mapping |
| :--- | :---: | :--- | :--- | :--- |
| `#3d3d3d` | 17 | `main.css:621`, `main.css:2851`, `main.css:8094` | **MATCHES** | Button Secondary Box-shadow (`#3D3D3D`) |
| `#dfdfdf` | 13 | `main.css:5053`, `main.css:5177`, `main.css:5337` | **MATCHES** | `--tg-border-6` (`#dfdfdf`) |
| `#cac9d6` | 11 | `main.css:8044`, `main.css:8045`, `main.css:9535` | **MATCHES** | Card Hover Drop-shadow (`#CAC9D6`) |
| `#b5b5c3` | 4 | `main.css:3908`, `main.css:8027`, `main.css:9515` | **MATCHES** | Card Border Stroke (`#B5B5C3`) |
| `#f7f7f9` / `#f7f7fa` | 8 | `main.css:69`, `main.css:10119`, `main.css:10732` | **MATCHES** | `--tg-common-color-gray` (`#F7F7F9`) |
| `#efeefe` | 4 | `main.css:70`, `main.css:6925`, `main.css:10040` | **MATCHES** | `--tg-common-color-gray-2` (Badge bg) |
| `#e6eaef` / `#e6e9ef` | 10 | `main.css:1266`, `main.css:1359`, `main.css:5114` | **NEAR-MATCH** | `--tg-border-2` (`#D0DAE9`) |
| `#e8e8e8` / `#e1e1e1` | 12 | `main.css:4722`, `main.css:9786`, `main.css:10731`| **NEAR-MATCH** | `--tg-border-3` (`#E2E2E2`) |
| `#d7d7d7` / `#d9d9d9` | 9 | `main.css:4647`, `main.css:5497`, `main.css:9304` | **NEAR-MATCH** | `--tg-border-1` (`#C9C9DD`) |
| `#6d6c80` | 2 | `main.css:51`, `main.css:7246` | **MATCHES** | `--tg-body-color` (`#6D6C80`) |
| `#7f7e97` | 7 | `main.css:71`, `main.css:1885`, `main.css:1886` | **MATCHES** | `--tg-common-color-gray-3` (`#7F7E97`) |
| `#64748b` | 3 | `main.css:7923`, `certificate-detail.php:796` | **OFF-SYSTEM** | `--tg-body-color` (`#6D6C80`) |
| `#f8fbff` / `#f0f7ff` | 5 | `index.html`, `certificate-detail.php` | **OFF-SYSTEM** | `--tg-common-color-gray` (`#F7F7F9`) |

### 3. Typography & Hierarchy Grouping
| Found Values | Frequency | SkillGro Standard | Classification | Target Mapping |
| :--- | :---: | :--- | :--- | :--- |
| `12px`, `13px`, `14px` | 41 | `14px` (`font-size: 14px`) | **NEAR-MATCH** | Unify to `14px` for meta/captions/badges |
| `15px`, `16px` | 68 | `16px` (`--tg-body-font-size`) | **MATCHES** | Standard body text: `16px` (`line-height: 1.75`) |
| `18px`, `20px` | 59 | `18px` (`h5`), `20px` (`h4`)| **MATCHES** | Map card titles to `20px` (`font-weight: 600`) |
| `22px`, `24px`, `26px` | 30 | `24px` (`h3`) | **NEAR-MATCH** | Sub-headings unify to `24px` (`line-height: 1.35`) |
| `28px`, `30px`, `32px` | 26 | `30px` (mobile title) | **NEAR-MATCH** | Mobile section titles unify to `28px`-`30px` |
| `35px`, `36px`, `40px` | 21 | `36px` (`.section__title .title`)| **MATCHES** | Desktop section titles unify to `36px` (`line-height: 1.33`) |
| `45px`, `48px` | 9 | `48px` (`h1`) | **MATCHES** | Hero main headings unify to `48px` (`line-height: 1.25`) |

---

## Step 4 — One-Line Fix for Every Problem

1. **48 Blue Variations -> 1 Brand Primary Token:** Replace all primary button, link, and accent blues with `var(--tg-theme-primary)` (`#5751E1`) and button shadow with `var(--tg-common-color-blue)` (`#050071`).
2. **50 Grey Shades -> 4 Core Neutral Tokens:** Standardize all neutrals to `--tg-body-color: #6D6C80` (body), `#F7F7F9` (bg), `#EFEEFE` (badge pill), and `#B5B5C3` (card border).
3. **15 Button Variations -> 2 Standard SkillGro Buttons:** Revert all buttons to standard `.btn` (primary purple with 4px 6px shadow) and `.btn.btn-two` (secondary yellow with 2px black border and 4px 4px shadow).
4. **Card Hover Disconnect -> Brutalist Drop-Shadow:** Remove irregular translateY and blurred shadows from `.courses__item` and restore `filter: drop-shadow(10px 10px 0px #CAC9D6)`.
5. **Section Title Inconsistency -> Standard `.section__title` Structure:** Remove inline colors and non-standard badges; enforce `.sub-title` (30px radius, `#EFEEFE` bg, `#5751E1` text) and `.title` (`36px`, `line-height: 1.33`, Poppins).
6. **Double Padding on Sections -> Single Rhythmic Padding:** Remove conflicting classes like `pt-60 section-py-120` from categories, testimonials, and courses, leaving only `section-py-120` or `section-pt-120 section-pb-90`.
7. **Inline Negative Margins & Fixed Widths -> Clean Flex/Grid:** Remove `style="width: 800px;"`, `style="margin-left: -48px;"`, and `style="margin-top: -13px;"` in `index.html` and rely on Bootstrap's grid container.
8. **Inline Overrides on About Section -> Native Spacing Classes:** Remove `style="padding: 0px 0;"` from `.about-area-four` and restore SkillGro's native section spacing.
9. **Form Field Inconsistency -> Standard `.form-grp input`:** Standardize input heights to `45px`, background `#F4F3F8`, border `none`, and border-radius `4px`.
10. **Fragmented Dark Footers -> Unified `--tg-common-color-dark`:** Replace `#082a5e`, `#031333`, and `#111827` footer backgrounds with `#1C1A4A`.

---

## Step 5 — Proposed System for SkillEdU (Derived from SkillGro)

To align SkillEdU fully with SkillGro without redesigning or adding new dependencies, the following system tokens and single-source definitions must be applied:

### 1. Proposed Core Variables (`:root` in `assets/css/main.css`)
```css
:root {
  /* Fonts */
  --tg-body-font-family: 'Inter', sans-serif;
  --tg-heading-font-family: 'Poppins', sans-serif;
  --tg-body-font-size: 16px;
  --tg-body-line-height: 1.75;
  --tg-heading-line-height: 1.3;

  /* Brand Colors */
  --tg-theme-primary: #5751E1;       /* SkillGro Primary */
  --tg-theme-secondary: #FFC224;     /* SkillGro Secondary */

  /* Semantic & Text */
  --tg-heading-color: #161439;       /* Headings */
  --tg-body-color: #6D6C80;          /* Body Text */
  --tg-common-color-white: #FFFFFF;  /* White */

  /* Neutral & Grey Scale (4 Core) */
  --tg-common-color-gray: #F7F7F9;   /* Neutral Section BG */
  --tg-common-color-gray-2: #EFEEFE; /* Badge Pill BG */
  --tg-border-card: #B5B5C3;         /* Card Stroke */
  --tg-shadow-card: #CAC9D6;         /* Card Drop-Shadow */
  --tg-input-bg: #F4F3F8;            /* Input Field BG */

  /* Shadows & Darks */
  --tg-common-color-blue: #050071;   /* Btn Primary Shadow */
  --tg-common-color-dark: #1C1A4A;   /* Footer & Dark BG */
  --tg-common-color-black: #06042E;  /* Mega Menu & Dark */
  --tg-shadow-secondary: #3D3D3D;    /* Btn Secondary Shadow */
}
```

### 2. Single Source Definitions for Key Components

#### A. Primary Button (`.btn`)
```css
.btn {
  background: var(--tg-theme-primary) none repeat scroll 0 0;
  border: medium none;
  color: var(--tg-common-color-white);
  cursor: pointer;
  display: inline-block;
  font-size: 16px;
  font-weight: 600;
  font-family: var(--tg-heading-font-family);
  line-height: 1.12;
  padding: 16px 30px;
  text-align: center;
  border-radius: 50px;
  white-space: nowrap;
  box-shadow: 4px 6px 0px 0px var(--tg-common-color-blue);
  transition: all 0.3s ease-out 0s;
  overflow: hidden;
}
.btn:hover {
  background: var(--tg-heading-color);
  color: var(--tg-common-color-white);
  box-shadow: 4px 6px 0px 0px var(--tg-heading-color);
}
```

#### B. Secondary Button (`.btn.btn-two`)
```css
.btn-two {
  background: var(--tg-theme-secondary);
  border: 2px solid #000000;
  box-shadow: 4px 4px 0px 0px #3D3D3D;
  color: #000000;
  border-radius: 50px;
  font-family: var(--tg-heading-font-family);
  font-weight: 600;
  padding: 16px 30px;
  transition: all 0.3s ease-out 0s;
}
.btn-two:hover {
  background: var(--tg-theme-primary);
  color: var(--tg-common-color-white);
  border-color: var(--tg-common-color-blue);
  box-shadow: 4px 4px 0px 0px var(--tg-common-color-blue);
}
```

#### C. Course & Content Card (`.courses__item`)
```css
.courses__item {
  margin: 0 0 30px;
  background: var(--tg-common-color-white);
  border-radius: 10px;
  padding: 25px 25px 32px;
  border: 1px solid #B5B5C3;
  transition: all 0.2s ease-out 0s;
}
.courses__item:hover {
  filter: drop-shadow(10px 10px 0px #CAC9D6);
}
```

#### D. Form Input (`.form-grp input`)
```css
.form-grp input {
  border: none;
  background: #F4F3F8;
  width: 100%;
  border-radius: 4px;
  font-size: 14px;
  padding: 10px 20px;
  color: var(--tg-heading-color);
  height: 45px;
  transition: 0.3s;
}
.form-grp input:focus {
  border: 1px solid var(--tg-theme-primary);
  background: var(--tg-common-color-white);
}
```

#### E. Section Title (`.section__title`)
```css
.section__title .sub-title {
  display: inline-block;
  line-height: 1.62;
  background: var(--tg-common-color-gray-2);
  border-radius: 30px;
  padding: 3px 16px;
  font-weight: 500;
  font-size: 14px;
  color: var(--tg-theme-primary);
  margin-bottom: 14px;
}
.section__title .title {
  font-size: 36px;
  line-height: 1.33;
  font-family: var(--tg-heading-font-family);
  font-weight: 700;
  color: var(--tg-heading-color);
  letter-spacing: -0.75px;
  text-transform: capitalize;
  margin-bottom: 0;
}
@media (max-width: 767.98px) {
  .section__title .title {
    font-size: 28px;
  }
}
```

### 3. List of SkillEdU Files That Must Change When Applying Fixes
1. `website-skilledu-new26/assets/css/main.css` — Update `:root` variables, buttons, course item hover, form-grp, section title styles.
2. `website-skilledu-new26/assets/css/custom.css` — Remove ad-hoc overrides (`--tg-neutral-*`, non-standard `.btn` overrides).
3. `website-skilledu-new26/index.html` — Strip all 37 inline `style="..."` overrides (fixed widths, negative margins, padding: 0, inline colors) and fix clashing section padding classes.
4. `website-skilledu-new26/all-courses.html` & course track pages — Remove conflicting inline styles and link cards to standard `.courses__item`.
5. `website-skilledu-new26/certificate-detail.php` — Replace hardcoded `#0284c7` and `#64748b` with `--tg-theme-primary` and `--tg-body-color`.

---

## Detailed Audit Findings Table

| Page / Section | Problem Identified | SkillEdU Value | SkillGro Standard | One-Line Fix | Exact File : Line | Priority |
| :--- | :--- | :--- | :--- | :--- | :--- | :---: |
| **Global :root** | Primary brand color drifted to non-standard blue | `#0b66c3` | `--tg-theme-primary: #5751E1` | Set `--tg-theme-primary: #5751E1;` in `:root` | `main.css:53` | **High** |
| **Global :root** | Ad-hoc primary tint variable added without token | `--tg-primary-tint: #e0f2fe;` | `--tg-common-color-gray-2: #EFEEFE;` | Replace with `--tg-common-color-gray-2` | `main.css:55` | **Med** |
| **Header / Nav** | Inline height & negative margins distorting nav bar | `style="height: 81px; margin-top: -13px;"` | Clean CSS navbar height in `main.css` | Remove inline height and margin styles | `index.html:1639-1642` | **High** |
| **Header / Nav** | Login CTA button missing SkillGro primary button shadow | `box-shadow: none;` | `box-shadow: 4px 6px 0px 0px #050071;` | Add standard `.btn` class with blue shadow | `main.css:1240` | **Med** |
| **Hero Banner** | Fixed hardcoded width breaking layout container | `style="width: 800px;"` | Responsive Bootstrap `.col-lg-8` | Remove inline width; use grid column | `index.html:1794` | **High** |
| **Hero Banner** | Ad-hoc negative margin on content | `style="margin-top: calc(-1 * var(--space-8));"` | Native `margin-top: 0` with standard grid gap | Remove inline style | `index.html:1852` | **Med** |
| **Categories Area**| Conflicting padding utilities stacking top padding | `class="... pt-60 section-py-120"` | `class="... section-py-120"` | Remove `pt-60` to prevent uneven spacing | `index.html:2012` | **High** |
| **About Area Four**| Inline `padding: 0px 0` wipes out `section-pb-120` | `style="padding: 0px 0;"` | Standard `section-pb-120` padding | Delete `style="padding: 0px 0;"` | `index.html:2145` | **High** |
| **About Area Four**| Hardcoded inline color overrides on links | `style="color: var(--tg-primary); padding: 0;"` | CSS class inheritance | Move to `.about-content a` in CSS | `index.html:2193` | **Low** |
| **Features Area Two**| Clashing padding classes | `class="... pt-60 section-pb-90"` | `class="... section-pt-120 section-pb-90"` | Replace `pt-60` with standard `section-pt-120` | `index.html:2396` | **Med** |
| **How It Works (SSS)**| Bootstrap `py-5` instead of SkillGro section rhythm | `class="work__area py-5"` | `class="work__area section-py-120"` | Replace `py-5` with `section-py-120` | `index.html:2602` | **Med** |
| **How It Works (SSS)**| Inline negative margin displacing layout | `style="margin-left: -48px;"` | Bootstrap standard gutter / grid alignment | Remove inline negative margin | `index.html:2638` | **High** |
| **Choose Area Four**| Inline background color override | `style="background-color: var(--tg-primary-tint);"` | CSS class `.choose__area-four` rule | Use `.tg-common-color-gray-2` in CSS | `index.html:2653` | **Low** |
| **Courses Area** | Double padding classes creating abnormal gap | `class="courses-area pt-60 section-pb-90"` | `class="courses-area section-pt-120 section-pb-90"` | Replace `pt-60` with `section-pt-120` | `index.html:2824` | **High** |
| **Courses Area** | Course cards hover uses soft shadow instead of drop-shadow | `box-shadow: 0 10px 30px rgba(0,0,0,0.08);` | `filter: drop-shadow(10px 10px 0px #CAC9D6);` | Enforce SkillGro brutalist drop-shadow hover | `main.css:8044` | **High** |
| **Course Card** | Card border color missing or overridden | `border: 1px solid #e2e8f0;` | `border: 1px solid #B5B5C3;` | Set `border: 1px solid #B5B5C3;` | `main.css:8027` | **Med** |
| **Docker Workshop**| Inline border-radius override injected | `style="border-radius: var(--radius-xl);"` | Clean `border-radius: 10px;` in CSS | Remove repeated inline `border-radius` | `index.html:4244-4377` | **Med** |
| **Docker Workshop**| Ad-hoc background override | `style="background-color: var(--tg-neutral-50);"` | `var(--tg-common-color-gray)` | Remove inline style | `index.html:4232` | **Low** |
| **Testimonial Area**| Double padding conflict | `class="testimonial__area pt-60 section-py-120"` | `class="testimonial__area section-py-120"` | Remove `pt-60` | `index.html:4568` | **High** |
| **CTA Area** | Inline background color breaking dark theme token | `style="background-color: var(--tg-neutral-800);"` | `background: var(--tg-common-color-dark);` | Replace with `--tg-common-color-dark` | `index.html:4898` | **High** |
| **Fact Area** | Inline margin-top override | `style="margin-top: var(--space-20);"` | Standard spacing utility `mt-80` | Remove inline style; add `mt-80` | `index.html:4960` | **Med** |
| **Footer** | Footer background using off-brand `#082a5e` | `#082a5e` | `--tg-common-color-dark: #1C1A4A` | Set `.footer-bg` to `#1C1A4A` | `main.css:5565` | **High** |
| **Buttons (.btn)** | Missing signature blue offset shadow | `box-shadow: 0 4px 6px ...` or none | `box-shadow: 4px 6px 0px 0px #050071;` | Enforce SkillGro 4px 6px shadow | `main.css:4973` | **High** |
| **Buttons (.btn-two)**| Secondary button missing 2px black border | `border: none;` | `border: 2px solid #000; box-shadow: 4px 4px 0 #3D3D3D;` | Enforce 2px black border + 4px shadow | `main.css:5020` | **High** |
| **Form Inputs** | Inconsistent input borders and height across pages | `height: 50px; border: 1px solid #dfdfdf;` | `height: 45px; border: none; bg: #F4F3F8;` | Standardize to `.form-grp input` specs | `main.css:5114` | **Med** |
| **Certificate Page**| Certificate search inputs using Tailwind-like border/radius | `border: 2px solid #0284c7;` | SkillGro `.form-grp input` standard | Unify inputs to SkillGro standard | `certificate-detail.php:788` | **Med** |

---

## Top 10 Priority Fixes

1. **Restore Canonical Brand Primary Token:** In `assets/css/main.css`, revert `--tg-theme-primary` to `#5751E1` and `--tg-common-color-blue` to `#050071` to unify all 48 fragmented blue shades across the site.
2. **Re-establish SkillGro's Primary Button Component:** Enforce standard `.btn` with `padding: 16px 30px`, `border-radius: 50px`, `box-shadow: 4px 6px 0px 0px #050071`, and Poppins 16px semi-bold typography.
3. **Re-establish SkillGro's Secondary Button Component:** Enforce `.btn.btn-two` with `background: #FFC224`, `border: 2px solid #000000`, `box-shadow: 4px 4px 0px 0px #3D3D3D`, and black text.
4. **Restore Signature Course Card Hover Drop-Shadow:** In `assets/css/main.css`, update `.courses__item:hover` with `filter: drop-shadow(10px 10px 0px #CAC9D6)` and ensure cards have `border: 1px solid #B5B5C3; border-radius: 10px;`.
5. **Strip All 37 Inline Styles from `index.html`:** Remove inline `style="width: 800px;"`, `style="margin-left: -48px;"`, `style="padding: 0px 0;"`, and ad-hoc `--space-*` / `--tg-neutral-*` overrides to allow clean CSS hierarchy.
6. **Fix Clashing Section Padding Classes:** On `index.html`, eliminate double paddings like `pt-60 section-py-120` and `pt-60 section-pb-90`, establishing consistent 120px / 90px vertical breathing room.
7. **Unify Section Titles:** Standardize `.section__title .sub-title` across all sections to use `background: #EFEEFE; color: #5751E1; border-radius: 30px; padding: 3px 16px;` and `.title` to Poppins 36px.
8. **Unify 50 Grey Shades to 4 Core Functional Tokens:** Eliminate loose `#e6eaef`, `#e8e8e8`, `#dfdfdf`, `#d7d7d7`, and map exclusively to body `#6D6C80`, bg `#F7F7F9`, badge `#EFEEFE`, and border `#B5B5C3`.
9. **Harmonize Dark Theme Tokens (Footer & CTA):** Standardize all dark backgrounds in the footer, mega menu, and CTA to SkillGro's `--tg-common-color-dark` (`#1C1A4A`) and `--tg-common-color-black` (`#06042E`).
10. **Standardize Form Input Elements:** Enforce `.form-grp input` standards (`height: 45px; background: #F4F3F8; border: none; border-radius: 4px; padding: 10px 20px;`) across contact forms, course search, and certificate verification.
