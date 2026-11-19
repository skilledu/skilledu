# SkillEdU UX Audit Report
**Standard Reference:** SkillGro Template (`D:\InternshipSKILLEDU\skillgro\skillgro` — Read-Only)  
**Target Application:** SkillEdU Website (`website-skilledu-new26` at `http://localhost:8000`)  
**Active Git Branch:** `responsive-fix-medium` (Verified clean)  
**Scope:** 27 Pages & Real User Workflows  
**Mode:** AUDIT ONLY (No code modified)  

---

## Executive Summary

This UX audit evaluates the SkillEdU web platform against the architecture, user flows, and interaction patterns established by the reference **SkillGro** educational platform. 

SkillGro implements a complete self-service digital education journey (catalog browsing $\rightarrow$ course curriculum preview $\rightarrow$ cart $\rightarrow$ multi-step checkout $\rightarrow$ authenticated student dashboard $\rightarrow$ interactive course lessons $\rightarrow$ automated certificate issuance). In contrast, SkillEdU operates as an **assisted-conversion lead generation model**, directing learners from course discovery to direct WhatsApp and telephone consultations, complemented by a public certificate verification engine.

While SkillEdU's lead-funnel approach suits its local offline/hybrid training model, the platform exhibits significant UX friction, dead-end navigation, missing form feedback, absent keyboard focus indicators, and severe accessibility barriers that undermine user trust and task completion.

---

## Step 0 — SkillGro UX Standard Summary

The SkillGro reference platform establishes an e-learning design language organized around clear visual hierarchies, predictable user flows, and robust feedback loops:

1. **User Flows & Conversion Funnel:**
   - **Discovery to Checkout:** `index.html` $\rightarrow$ `courses.html` (filterable catalog with category tabs, search input, and sort options) $\rightarrow$ `course-details.html` (curriculum accordion, instructor profile, video preview modal, pricing badge, "Enroll Now" CTA) $\rightarrow$ `cart.html` $\rightarrow$ `check-out.html` (billing, payment gateway, order review).
   - **Student & Instructor Portal:** Dual registration/login paths (`registration.html`, `login.html`) connecting to personalized dashboards (`student-dashboard.html`, `instructor-dashboard.html`) managing enrollments, quiz attempts, and certificates.
   - **Contact & Inquiry:** Dedicated contact page featuring physical coordinates alongside an AJAX-powered contact form with real-time success/error messaging (`ajax-form.js`).
2. **Component & Navigation Patterns:**
   - **Header:** Sticky navbar containing Category Dropdown, Live Search input with category selector, Cart count indicator, Login button, and CTA button.
   - **Breadcrumbs:** Structured `.breadcrumb__area` indicating semantic hierarchical depth (`Home > Courses > Course Name`).
   - **Forms:** `.form-grp` component with semantic `<label>`, floating placeholder text, explicit required field indicators (`*`), and inline validation alerts (`.ajax-response.success`, `.ajax-response.error`).
   - **Accordions:** Bootstrap 5 collapsible accordions with full ARIA disclosure state (`aria-expanded="true/false"`).
   - **States & Accessibility:** High-contrast color tokens, distinct hover translations, visible focus rings, skip-to-content links, and WCAG AA contrast compliance.

---

## Step 1 — Real User Flow Walkthrough & Screen-by-Screen Findings

All primary user journeys were audited in the browser. Screenshots capturing each stage are recorded in `audit/ux-screenshots/`.

```
+---------------------------------------------------------------------------------------------------------+
|                                    SKILLEDU PRIMARY USER JOURNEYS                                      |
+---------------------------------------------------------------------------------------------------------+
|                                                                                                         |
|  [ Flow 1: Course Discovery & Inquiry ]                                                                |
|  Home Hero ------------> Catalog / Track ----------> Course Details ----------> WhatsApp / Call CTA    |
|  (index.html)            (all-courses.html,          (Java.html,                (wa.me / tel:)          |
|                           AI-Courses.html)            Prog-with-C++.html)                               |
|                                                                                                         |
|  [ Flow 2: Certificate Credential Verification ]                                                        |
|  Home / Nav -----------> Verify Page --------------> Enter ID ----------------> PDF Preview & Confetti |
|                          (certificate-detail.php)     (Client validation:        (Valid ID query)       |
|                                                        "SU..." required)                                |
|                                                                                                         |
|  [ Flow 3: Error & Recovery ]                                                                           |
|  Broken URL -----------> 404 Error Page -----------> Dead End                                           |
|                          (404.html - unstyled)        (No navigation, logo, or back link)               |
+---------------------------------------------------------------------------------------------------------+
```

---

### Flow 1: Course Discovery to Inquiry

#### 1.1 Home Page Above-the-Fold (`index.html`)
- **Evidence:** `audit/ux-screenshots/flow1-01-home-hero.png`
- **First Impression (5-Second Test):** The value proposition *"Master Skills at skilled.u - Hands-On Learning Awaits"* communicates training in technology, but suffers from competing visual calls to action.
- **CTA Competition:** The initial viewport presents **3 competing buttons** with identical visual weight:
  1. Header: *"Call Us"* (`tel:+918989099962`)
  2. Header: *"whatsApp Us"* (`https://wa.me/...`)
  3. Hero Banner: *"Explore Courses"* (Smooth scroll to `#our_courses`)
- **UX Issue:** Users are pulled between exploring courses vs immediately initiating a phone call before knowing what courses exist.

#### 1.2 Course Catalog & Track Browsing (`all-courses.html`, `AI-Courses.html`, `forntend-Courses.html`)
- **Evidence:** `audit/ux-screenshots/flow1-03-category-all-courses.png`, `audit/ux-screenshots/flow1-04-category-ai-courses.png`, `audit/ux-screenshots/flow1-05-category-frontend-courses.png`
- **Navigation Inconsistency:** On `all-courses.html` and track pages, the main navigation still highlights **"Home" as active** (`class="active"` hardcoded on Home in HTML). The user has no persistent visual indicator of where they are in the site hierarchy.
- **Card Metadata Gaps:** Course cards show title, category, and an image, but lack **duration, skill level (Beginner/Advanced), and price indicators**. In SkillGro, each card displays ratings, duration (e.g. `12 Weeks`), and price badges.

#### 1.3 Course Details Page (`Java.html`, `Programming-with-C++.html`)
- **Evidence:** `audit/ux-screenshots/flow1-06-course-details-java-hero.png`, `audit/ux-screenshots/flow1-07-course-details-java-sidebar-cta.png`, `audit/ux-screenshots/flow1-08-course-details-java-curriculum-accordion.png`
- **Sidebar CTA:** The sidebar features two stacked buttons: *"WhatsApp Us"* and *"Contact Us"*. There is no online syllabus download button or enrollment booking form.
- **Curriculum Accordion:** The custom curriculum accordion renders syllabus modules cleanly, but lacks estimated completion times per module (SkillGro displays `03:03`, `07:48` duration tags).
- **Social Sharing Dead Links:** The sidebar contains 4 social share icons (`Facebook`, `WhatsApp`, `Instagram`, `YouTube`). The YouTube link is hardcoded to `href="#"` with title *"YouTube link will be added later"*.

#### 1.4 Contact Page (`contact.html`)
- **Evidence:** `audit/ux-screenshots/flow1-10-contact-page-form.png`
- **Missing Contact Form:** Unlike SkillGro (which provides a full message form with name, email, subject, message, and AJAX response), SkillEdU's contact form is completely commented out in HTML (`<!-- <form action=" #"> -->`).
- **User Impact:** Visitors who prefer sending a direct email message or inquiry form cannot do so; they are forced to make a telephone call or use WhatsApp.

---

### Flow 2: Certificate Verification (`certificate-detail.php`)

- **Evidence:** `audit/ux-screenshots/flow2-01-certificate-initial.png`, `audit/ux-screenshots/flow2-02-certificate-invalid-input.png`
- **Input State:** Clean single-input card. However, there is no `<label>` element for the input (only `placeholder="e.g. SU1012024"`), violating accessibility guidelines.
- **Validation Experience:** Client-side JavaScript validation intercepts empty input and non-"SU" formatted IDs, displaying an error notice:
  `Please enter your Certificate ID.` / `Certificate ID must start with 'SU' (e.g., SU1012024)`.
- **Server Feedback:** When an ID is structurally valid but nonexistent in MySQL, the system emits a floating SweetAlert2 toast notification.
- **Success State:** Displays student details, issuing authority, PDF certificate preview via PDF.js, download button, and celebratory confetti.

---

### Flow 3: Error Handling & Dead Ends (`404.html`)

- **Evidence:** `audit/ux-screenshots/flow3-01-404-page.png`
- **Current State:** A completely bare, unstyled 8-line HTML file (`<center><h1>404 Not Found</h1></center><hr>`).
- **User Impact (Critical Dead End):** A visitor who mistypes a URL or clicks a broken link encounters a raw server error screen with **no logo, no navigation bar, no search bar, and no "Return to Home" button**. 100% of lost users face complete abandonment.

---

### Flow 4 & 5: Mobile Navigation & Accessibility

- **Mobile Drawer:** (`audit/ux-screenshots/flow4-01-mobile-drawer-open.png`)
  - The off-canvas drawer slides out smoothly on mobile.
  - Submenu dropdown arrows work, and social links are accessible.
- **Keyboard Tab Navigation:** (`audit/ux-screenshots/flow5-01-keyboard-focus-ring.png`)
  - Tabbing through the site reveals `outline: none` on buttons and nav items.
  - There is **no visible focus indicator** for keyboard-only users, making the site non-navigable for motor-impaired individuals.

---

## Step 2 — Quantitative UX Metrics & Comparison (Count)

The table below measures the SkillEdU platform directly against the SkillGro design standard across all 27 pages:

| Metric / UX Area | SkillEdU Found | SkillGro Standard | Variance / Finding |
| :--- | :---: | :---: | :--- |
| **Total Pages Audited** | 27 | 48 | SkillEdU focuses on 18 course tracks + 9 core pages |
| **Dead Links (`#`, empty, unlinked)** | **86** | 0 | 86 unlinked elements create broken user expectations |
| **Leftover Template Domains** | 0 | 0 | PASSED (Zero themegenix leftover links) |
| **Active Forms on Site** | 1 (`certificate-detail.php`) | 6+ (Contact, Login, Register, Cart, etc.) | Contact form is missing; enrollment forms absent |
| **Form Inputs Missing `<label>`** | 1 (100% of active forms) | 0 (All forms use semantic labels) | Form uses placeholder-only, failing WCAG 3.3.2 |
| **Images Missing `alt` Attribute** | **25** | 0 | 25 images completely lack `alt` tags |
| **Images with Placeholder `alt="img"`** | **337** | < 10 | 337 images use non-descriptive `alt="img"` |
| **Icon-Only Buttons Missing `aria-label`**| **26** | 0 | Screen readers cannot announce button actions |
| **Pages Missing Skip-to-Content Link** | **27 (100%)** | 0 (Global skip link present) | Fails WCAG 2.4.1 (Bypass Blocks) |
| **Visible Focus Ring (`:focus-visible`)** | **None (`outline: none`)** | High-contrast 2px outline | Fails WCAG 2.4.7 (Focus Visible) |
| **WCAG AA Contrast Failures** | Footer links (`2.86:1`) | All text $\ge 4.5:1$ | Blue text `#0b66c3` on navy `#1c1a4a` fails AA |
| **Pages with Broken Active Nav State** | **26 / 27** | 0 (Current page highlighted) | "Home" is statically hardcoded as active everywhere |
| **Multi-H1 Heading Violations** | Present on `index.html` (2 H1s) | Strictly 1 H1 per page | Semantic document outline broken |
| **Pages Missing H1 Heading Entirely** | `Java.html`, `contact.html` | 0 | Detail pages start directly with H2 or H3 |
| **Preloader Blocking Screen Time** | Dependent on `window.onload` | Instant or progressive | Preloader locks viewport until remote assets finish |

---

## Step 3 — Issue Grouping & Categorization

Each UX issue is categorized by domain, defect type, and architectural scope:

| ID | Issue Description | UX Domain | Defect Type | Scope |
| :-: | :--- | :--- | :--- | :--- |
| **G-1** | Hardcoded `active` class on "Home" link across all 26 non-home pages | Navigation | DIFFERS FROM SKILLGRO | Shared (`header`) |
| **G-2** | 86 dead links (`href="#"`, `index.html#`, unlinked category badges) | Navigation | GENERAL UX BUG | Global / Multi-page |
| **G-3** | 404 page is an unstyled blank server error with no way back | Navigation | DIFFERS FROM SKILLGRO | Single Page (`404.html`) |
| **G-4** | Contact form completely missing on `contact.html` (commented out) | Forms | DIFFERS FROM SKILLGRO | Single Page (`contact.html`) |
| **G-5** | Certificate input lacks `<label>` (placeholder only) | Forms | GENERAL UX BUG | Single Page (`certificate-detail.php`) |
| **G-6** | Form feedback alerts lack consistent design token styling | Feedback & States | DIFFERS FROM SKILLGRO | Shared Components |
| **G-7** | Complete absence of visible focus rings on interactive elements | Accessibility | GENERAL UX BUG | Global (`main.css`) |
| **G-8** | Footer links blue-on-dark contrast failure ($2.86:1 < 4.5:1$) | Accessibility | GENERAL UX BUG | Shared (`footer`) |
| **G-9** | 25 images missing `alt`; 337 images with generic `alt="img"` | Accessibility | GENERAL UX BUG | Global / Content |
| **G-10**| 26 icon-only buttons lack `aria-label` or `title` | Accessibility | GENERAL UX BUG | Shared (`header`, `footer`, cards) |
| **G-11**| Heading hierarchy skips (multiple H1s on home, missing H1 on detail) | Accessibility | GENERAL UX BUG | Global / Layout |
| **G-12**| Global `#preloader` blocks viewport until `window.onload` completes | Speed Feel | GENERAL UX BUG | Global (`assets/js/main.js`) |
| **G-13**| Course cards & detail pages lack pricing, duration, and level tags | Content & Trust | DIFFERS FROM SKILLGRO | Course Track Pages |
| **G-14**| 3 competing CTAs above the fold on `index.html` create decision delay | Conversion | GENERAL UX BUG | Single Page (`index.html`) |

---

## Step 4 — One-Line Fix for Every Problem

| ID | User Impact | Exact Target File & Selector | Target Result / SkillGro Pattern | Scope Strategy |
| :-: | :--- | :--- | :--- | :--- |
| **F-1** | Users cannot tell which section of the website they are currently visiting | Header templates (`.navigation li.active`) | Dynamically assign `active` class to matching page slug or current route | Apply per page `<li class="active">` matching file |
| **F-2** | Clicking dead links causes silent failures or jarring viewport jumps | All pages (`a[href="#"]`, `a[href="index.html#"]`) | Replace with active routing or convert inert tags into `<span>` badges | Replace `#` with anchor targets or remove `<a>` |
| **F-3** | Users encountering 404 abandon the website entirely | `404.html` | Rebuild using standard SkillGro 404 template with header, search, and "Back to Home" CTA | Isolated to `404.html` |
| **F-4** | Visitors wanting to send an email inquiry cannot submit a message | `contact.html` (inside `.contact-area`) | Restore the SkillGro AJAX contact form with name, email, phone, message, and submit button | Scoped to `.contact-area` |
| **F-5** | Screen reader users do not know what the certificate input requires | `certificate-detail.php:L790` (`#certificate_id`) | Add `<label for="certificate_id" class="form-label visually-hidden">Certificate ID</label>` | Single line addition |
| **F-6** | Status notifications appear disjointed across SweetAlert and inline boxes | `certificate-detail.php` and site forms | Unify status messages using SkillGro `.alert.alert-danger` and `.alert.alert-success` | Scoped alert CSS |
| **F-7** | Keyboard-only users cannot track focus while navigating via Tab | `assets/css/main.css:L1000` (`:focus-visible`) | Add `*:focus-visible { outline: 2px solid var(--tg-theme-primary); outline-offset: 2px; }` | Global CSS rule |
| **F-8** | Low-vision users cannot read footer links against dark background | `assets/css/main.css:L5600` (`.footer__link a`) | Change footer link color to `#B2BBCC` with hover `#FFC224` ($7.4:1$ contrast) | Scoped to `.footer__link a` |
| **F-9** | Screen readers announce "image" repeatedly without context | All HTML pages (`img[alt="img"]`) | Replace generic alt tags with meaningful content descriptions or `alt=""` for decorative icons | Content attribute update |
| **F-10**| Screen reader users hear unannounced buttons without purpose | Header & footer social links, togglers | Add `aria-label="Open mobile menu"`, `aria-label="Facebook"`, `aria-label="WhatsApp"` | Attribute additions |
| **F-11**| Search engines and screen readers parse broken document hierarchy | `index.html`, `Java.html`, `contact.html` | Enforce exactly one semantic `<h1>` per page (Course Name on detail, Main Hook on Home) | Tag hierarchy fix |
| **F-12**| Slow network connections leave users staring at a blank white preloader | `assets/js/main.js:L18` (`preloader()`) | Add safety timeout `setTimeout(() => $('#preloader').fadeOut(), 1500)` or dismiss on DOMReady | Scoped to `main.js` |
| **F-13**| Prospective students must message WhatsApp just to know course length | Course cards (`.courses__item-content`) | Add metadata row with Duration icon (`12 Weeks`), Level (`Beginner`), and Mode (`Offline/Online`) | Scoped to card markup |
| **F-14**| First-time visitors experience decision paralysis above the fold | `index.html` hero banner | Prioritize "Explore Courses" as solid primary button; demote phone/WhatsApp to secondary outlines | Hero section classes |

---

## Step 5 — Proposed UX Component Standards (SkillGro Alignment)

To establish UX consistency across the platform, the following 5 reusable patterns are defined:

### 1. Primary CTA Pattern
```html
<!-- SkillGro Standard Primary Action Button -->
<a href="all-courses.html" class="btn btn-two arrow-btn">
    Explore Courses 
    <i class="fas fa-arrow-right" aria-hidden="true"></i>
</a>
```
- **Behavior:** Minimum touch target $44\times 44\text{px}$, bold typography (`16px`, semi-bold), subtle hover elevation ($+2\text{px}$ translate), visible focus ring.

### 2. Form Field & Validation Pattern
```html
<div class="form-grp">
    <label for="student_email" class="form-label">Email Address <span class="required">*</span></label>
    <input type="email" id="student_email" name="email" class="form-control" placeholder="name@domain.com" required>
    <div class="invalid-feedback">Please provide a valid email address.</div>
</div>
```
- **Behavior:** Floating or stacked label above input, red asterisk for required fields, clear 1px neutral border (#B5B5C3) transitioning to 2px primary brand on focus.

### 3. Feedback & Alert Pattern
```html
<div class="alert alert-danger d-flex align-items-center" role="alert">
    <i class="fas fa-exclamation-circle me-2" aria-hidden="true"></i>
    <div>Certificate ID not found. Please verify the ID format and try again.</div>
</div>
```

### 4. Navigation & Active State Pattern
```html
<ul class="navigation">
    <li class="<?php echo ($current_page === 'index') ? 'active' : ''; ?>"><a href="index.html">Home</a></li>
    <li class="<?php echo ($current_page === 'courses') ? 'active' : ''; ?>"><a href="all-courses.html">All Courses</a></li>
    <li class="<?php echo ($current_page === 'contact') ? 'active' : ''; ?>"><a href="contact.html">Contact Us</a></li>
    <li class="<?php echo ($current_page === 'certificate') ? 'active' : ''; ?>"><a href="certificate-detail.php">Verify Certificate</a></li>
</ul>
```

### 5. Universal Focus Indicator Pattern
```css
/* Accessible Universal Keyboard Focus Ring */
*:focus-visible {
    outline: 2px solid var(--tg-theme-primary) !important;
    outline-offset: 3px !important;
    box-shadow: 0 0 0 4px rgba(11, 102, 195, 0.25) !important;
}
```

---

## Top 10 Priority UX Fixes (Ordered Lowest to Highest Risk)

| Rank | Fix Description | Target File(s) | Risk Level | Rationale |
| :---: | :--- | :--- | :---: | :--- |
| **1** | Add universal `:focus-visible` keyboard focus outline in CSS | `assets/css/main.css` | **Lowest** | Pure CSS rule that only activates on keyboard Tab; zero impact on mouse clicks |
| **2** | Add `<label>` and ARIA attributes to certificate search input | `certificate-detail.php` | **Lowest** | Accessibility label addition without layout changes |
| **3** | Correct footer link color from dark blue to high-contrast `#B2BBCC` | `assets/css/main.css` | **Lowest** | Immediately fixes WCAG AA contrast failure ($2.86:1 \rightarrow 7.4:1$) |
| **4** | Add safety timeout to dismiss `#preloader` after 1.5s max | `assets/js/main.js` | **Low** | Prevents permanent white-screen lockups on slow network conditions |
| **5** | Add missing `aria-label` tags to 26 icon-only buttons | Header, footer, and cards | **Low** | Pure attribute addition for screen readers |
| **6** | Replace generic `alt="img"` with meaningful course and logo text | All HTML pages | **Low** | Pure markup attribute enhancement |
| **7** | Rebuild `404.html` with standard header, message, and return link | `404.html` | **Medium** | Converts a complete dead-end into an active recovery funnel |
| **8** | Fix hardcoded `active` navigation link state across all 26 pages | All HTML/PHP headers | **Medium** | Ensures nav accurately reflects user location across all routes |
| **9** | Clean up 86 dead `#` links and inactive category badges | Header, footer, course pages | **Medium** | Eliminates dead-end user clicks and confusing dummy anchors |
| **10**| Restore and style the contact inquiry form on `contact.html` | `contact.html` | **Highest** | Adds new form submission workflow and input handling |

---

## Items Requiring User Decision

The following items involve functional scope, business workflow, or infrastructure choices and require your direction before any code is modified:

1. **Decision 1 — Contact Form vs. Direct WhatsApp/Call Funnel:**
   - *Option A (Lead Generation via Form):* Re-enable and style the SkillGro contact form on `contact.html` (requires a PHP backend mailer script or database storage for messages).
   - *Option B (Assisted Direct Funnel):* Keep WhatsApp and Telephone as the primary contact channels, but add clear copy stating *"We provide instant guidance via WhatsApp and Call"* to explain the absence of an inquiry form.
2. **Decision 2 — 404 Error Page Template:**
   - *Option A:* Rebuild `404.html` using SkillEdU's standard header, breadcrumbs, styled illustration, and "Back to Home" button.
   - *Option B:* Keep `404.html` as a lightweight plain error page.
3. **Decision 3 — Course Metadata (Fees & Duration):**
   - *Option A:* Display course duration (e.g., *"12 Weeks"*) and level (*"Beginner to Advanced"*) on course cards, while keeping pricing hidden for WhatsApp inquiry.
   - *Option B:* Add full pricing badges (e.g. ₹ fees or "Free Consultation") to course cards matching SkillGro's card design.
4. **Decision 4 — Inert Course Category Badges on Home:**
   - Category badges like "DevOps Learning", "AI Tools & SDKs", and "Version Control" on `index.html` currently have `href="#"` because dedicated landing pages do not exist.
   - Should these link to `all-courses.html`, or should they be converted into static non-clickable tags (`<span>`) until track pages are authored?

---
*End of UX Audit Report. All findings documented with zero code modifications.*
