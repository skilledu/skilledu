# SkillEdU UI Fix Execution Log (Design Standard: SkillGro)

- **Target Project:** `D:\InternshipSKILLEDU\internday6\website-skilledu-new26_2026-10-10_11_48_58\website-skilledu-new26_2026-10-10_11_48_58\website-skilledu-new26`
- **Reference Standard:** `D:\InternshipSKILLEDU\skillgro\skillgro` (Strictly READ-ONLY)
- **Backup Created:** `website-skilledu-new26_BACKUP_before-ui-fix`
- **Git Branch:** `ui-fix-skillgro`
- **Baseline Screenshots:** Saved in `audit/fix-screenshots/baseline/` (1440px desktop & 375px mobile)

---

## Change Log Record

| Area | File | Line(s) | Old Value | New Value | Audit Finding / Reason |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Setup** | - | - | Initial codebase | Full backup & branch `ui-fix-skillgro` | Backup before UI fix execution |

---

## Intentionally Left Unchanged Record

| File | Element / Selector | Reason Kept Unchanged |
| :--- | :--- | :--- |
| All HTML/PHP | Image sources (`src="..."`) | Content integrity: Preserving real assets |
| `certificate-detail.php` | Form actions & PHP query logic | Functional integrity: Preserving database flow |
| All files | JS initialization attributes (`data-background`, `data-aos`, Swiper classes) | Behavioral integrity: Script dependency |
| **(1) Colors** | `assets\css\main.css` | 45 | `:root old tokens` | `:root standardized tokens` | Area 1: Set canonical primary #0b66c3, dark shadow #082a5e, secondary #FFC224, 4 neutrals |
| **(1) Colors** | `index.html` | 90 | `:root ad-hoc neutral tokens` | `:root SkillGro-mapped 4 neutrals` | Area 1: Map 50 greys to 4 neutrals & unify brand blue |
| **(1) Colors** | `index.html` | 1651 | `style="color: #000;"` | `style="color: var(--tg-heading-color);"` | Area 1: Use var(--tg-heading-color) |
| **(1) Colors** | `certificate-detail.php` | 796 | `#64748b` | `var(--tg-body-color)` | Area 1: Replace hardcoded grey with var(--tg-body-color) |
| **(1) Colors** | `assets\css\main.css` | 0 | `#0042c0` | `var(--tg-theme-primary)` | Area 1: Collapse variant blue #0042c0 into var(--tg-theme-primary) |
| **(2) Typography** | `assets\css\main.css` | 178 | `h1-h6 rem scale (40px..16px)` | `SkillGro scale h1:48px, h2:36px, h3:24px, h4:20px, h5:18px, h6:16px` | Area 2: Enforce SkillGro heading scale |
| **(2) Typography** | `assets\css\main.css` | 11500 | `Mobile typography overrides` | `SkillGro mobile floor (>=14px, h1:34px, h2:28px)` | Area 2: Mobile heading scale & 14px floor |
| **(2) Typography** | `index.html` | 124 | `Font family definitions` | `Inter (body) & Poppins (headings)` | Area 2: Confirmed 2 font families |
| **(3) Spacing & Inlines** | `index.html` | 0 | `class="categories-area pt-60 section-py-120"` | `class="categories-area section-py-120"` | Area 3: Remove conflicting pt-60 from categories-area to use SkillGro section-py-120 |
| **(3) Spacing & Inlines** | `index.html` | 0 | `class="features__area-two bread_bg pt-60 section-pb-90"` | `class="features__area-two bread_bg section-pt-120 section-pb-90"` | Area 3: Replace pt-60 with SkillGro section-pt-120 on features__area-two |
| **(3) Spacing & Inlines** | `index.html` | 0 | `class="courses-area pt-60 section-pb-90"` | `class="courses-area section-pt-120 section-pb-90"` | Area 3: Replace pt-60 with SkillGro section-pt-120 on courses-area |
| **(3) Spacing & Inlines** | `index.html` | 0 | `class="testimonial__area pt-60 section-py-120"` | `class="testimonial__area section-py-120"` | Area 3: Remove conflicting pt-60 from testimonial__area to use SkillGro section-py-120 |
| **(3) Spacing & Inlines** | `index.html` | 0 | `id="sss" class="work__area py-5"` | `id="sss" class="work__area section-py-120"` | Area 3: Replace Bootstrap py-5 with SkillGro standard section-py-120 |
| **(3) Spacing & Inlines** | `index.html` | 0 | `id="sms" class="work__area py-5"` | `id="sms" class="work__area section-py-120"` | Area 3: Replace Bootstrap py-5 with SkillGro standard section-py-120 |
| **(3) Spacing & Inlines** | `index.html` | 0 | `style="height: 81px;"` | `[Removed]` | Area 3: Remove inline height from header (Replaced 1 instances) |
| **(3) Spacing & Inlines** | `index.html` | 0 | `style="margin-top: -13px;"` | `[Removed]` | Area 3: Remove inline negative margin from header (Replaced 1 instances) |
| **(3) Spacing & Inlines** | `index.html` | 0 | `style="margin-top: 10px;"` | `[Removed]` | Area 3: Remove inline margin-top from nav menu (Replaced 1 instances) |
| **(3) Spacing & Inlines** | `index.html` | 0 | `style="background-color: var(--tg-neutral-50);"` | `[Removed]` | Area 3: Remove inline neutral-50 background from banner-area (Replaced 2 instances) |
| **(3) Spacing & Inlines** | `index.html` | 0 | `style="margin-left: calc(-1 * var(--space-10));"` | `[Removed]` | Area 3: Remove negative margin-left on hero row (Replaced 1 instances) |
| **(3) Spacing & Inlines** | `index.html` | 0 | `style="margin-left: var(--space-20);"` | `[Removed]` | Area 3: Remove ad-hoc margin-left on hero content (Replaced 1 instances) |
| **(3) Spacing & Inlines** | `index.html` | 0 | `style="width: 800px;"` | `style="max-width: 100%; height: auto;"` | Area 3: Replace fixed width 800px with responsive max-width: 100% (Replaced 1 instances) |
| **(3) Spacing & Inlines** | `index.html` | 0 | `style="margin-top: calc(-1 * var(--space-8));"` | `[Removed]` | Area 3: Remove inline negative margin on brand-area (Replaced 1 instances) |
| **(3) Spacing & Inlines** | `index.html` | 0 | `<section class="about-area-four section-pb-120" style="padding: 0px 0;">` | `<section class="about-area-four section-pb-120">` | Area 3: Delete inline padding: 0px 0 on about-area-four to restore section-pb-120 (Replaced 1 instances) |
| **(3) Spacing & Inlines** | `index.html` | 0 | `style="margin: var(--space-5);"` | `[Removed]` | Area 3: Remove inline margin: var(--space-5) (Replaced 2 instances) |
| **(3) Spacing & Inlines** | `index.html` | 0 | `style="margin-top: var(--space-3);"` | `[Removed]` | Area 3: Remove inline margin-top: var(--space-3) (Replaced 1 instances) |
| **(3) Spacing & Inlines** | `index.html` | 0 | `style="margin-left: -48px;"` | `[Removed]` | Area 3: Remove inline negative margin -48px from SMS/SSS columns (Replaced 2 instances) |
| **(3) Spacing & Inlines** | `index.html` | 0 | `style="padding-left: var(--space-16);"` | `[Removed]` | Area 3: Remove inline padding-left: var(--space-16) (Replaced 3 instances) |
| **(3) Spacing & Inlines** | `index.html` | 0 | `style="background-color: var(--tg-primary-tint);"` | `[Removed]` | Area 3: Remove inline background-color from choose__area-four (Replaced 1 instances) |
| **(3) Spacing & Inlines** | `index.html` | 0 | `style="border-radius: var(--radius-xl);"` | `[Removed]` | Area 3: Remove inline border-radius: var(--radius-xl) on cards (Replaced 6 instances) |
| **(3) Spacing & Inlines** | `index.html` | 0 | `style="background-color: var(--tg-neutral-800);"` | `[Removed]` | Area 3: Remove inline background-color from cta__area (Replaced 1 instances) |
| **(3) Spacing & Inlines** | `index.html` | 0 | `style="margin-top: var(--space-20);"` | `class="mt-80"` | Area 3: Replace inline margin-top: var(--space-20) with SkillGro spacing class mt-80 (Replaced 1 instances) |
| **(4) Components** | `assets\css\main.css` | 11560 | `Fragmented button, card, input, and section title styles` | `Canonical SkillGro 5 component definitions (.btn, .btn-two, .courses__item, .section__title, .form-grp input)` | Area 4: Standardize all core components to SkillGro single-source |
| **(4) Components** | `certificate-detail.php` | 788 | `Inline 2px solid border on certificate search` | `certificate-input using SkillGro 45px #F4F3F8 standard` | Area 4: Standardize certificate search inputs |
| **(5) Dark Theme** | `assets\css\main.css` | 11620 | `Fragmented dark backgrounds (#082a5e, #031333, #080910)` | `Unified #1C1A4A (footer & CTA) and #06042E (footer bottom & mobile menu)` | Area 5: Standardize dark theme to SkillGro tokens |
| **(5) Dark Theme** | `assets\css\aicourses.css` | 2720 | `#080910` | `var(--tg-common-color-dark)` | Area 5: Map ad-hoc dark to var(--tg-common-color-dark) |
