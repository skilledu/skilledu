========================================================================
SKILLEDU TESTIMONIALS & REVIEWS - COMPLETE STANDALONE PACKAGE
========================================================================

Welcome to the standalone edition of the SkillEdU Student Success Stories 
and Testimonials wall.

This package is completely self-contained, portable, and independently
runnable on any modern computer or web server.

------------------------------------------------------------------------
1. WHAT THIS PACKAGE CONTAINS
------------------------------------------------------------------------
- index.html:
  The complete, fully-styled Testimonials page featuring:
  * Think School-inspired balanced 4-column masonry layout.
  * All 67 genuine Google 5-star student review records.
  * All 8 high-definition 9:16 portrait video testimonials with custom
    playback controls (Devendra Lodhi, Khushi Mehar, Karan Borana,
    Yuvraj Chouhan, Tanushree Jhala, Sumit Nandeda, Mahendra Singh,
    and Muskan Chaurasia).
  * Responsive layout (Desktop: 4 columns, Tablet: 2 columns, Mobile: 1 column).
  * Interactive controls: play/pause glassmorphism overlay, progress seek bar,
    mute/unmute, fullscreen toggle, and single-active video auto-pause.

- assets/css/:
  Complete stylesheets including Bootstrap 5, FontAwesome, Flaticon,
  AOS animations, and custom Think School balanced masonry styles.

- assets/js/:
  All interactive JavaScript libraries, jQuery 3.6.0, Swiper, AOS,
  video controls engine, and the shortest-column masonry allocation script.

- assets/fonts/:
  Local icon font files (FontAwesome Brands, Regular, Solid, and Flaticon).

- assets/images/ (and assets/img/):
  All logos, icons, decorative shapes, video poster images, and student
  profile avatar images.

- assets/videos/ (and assets/video/):
  All 8 original MP4 video testimonial files (encoded in H.264 / AAC for
  maximum cross-browser compatibility).

- data/:
  * skilledu_5_star_reviews.csv: Raw CSV containing all 67 Google reviews.
  * skilledu_video_testimonials.csv: Metadata for all 8 video testimonials.
  * skilledu_testimonials_complete.json: Complete unified JSON dataset.

------------------------------------------------------------------------
2. QUICK START / HOW TO RUN LOCALLY
------------------------------------------------------------------------
Because modern web browsers enforce security policies (CORS) on local video
streaming (HTML5 <video>) when opened via `file://`, we recommend opening
the page through a local HTTP server:

OPTION A: Using Python (Recommended & Easiest)
-----------------------------------------------
1. Open a terminal or PowerShell in this folder.
2. Run the command:
   python -m http.server 8080
   (or on Python 2: python -m SimpleHTTPServer 8080)
3. Open your browser and navigate to:
   http://localhost:8080/

OPTION B: Using VS Code Live Server
-----------------------------------------------
1. Open this folder in Visual Studio Code.
2. Install the "Live Server" extension (if not already installed).
3. Right-click `index.html` and click "Open with Live Server".

OPTION C: Using Node.js (npx serve or http-server)
-----------------------------------------------
1. In your terminal, run:
   npx serve .
   or
   npx http-server -p 8080
2. Open the URL displayed in the terminal.

OPTION D: Direct Browser Double-Click
-----------------------------------------------
You can also directly double-click `index.html` to open it in Chrome, Edge,
Safari, or Firefox. All layouts, typography, Google reviews, and cards will
render perfectly. Note that some browsers restrict local MP4 video seeking
when using the file:// protocol.

------------------------------------------------------------------------
3. TESTIMONIAL DATA & ASSET LOCATIONS
------------------------------------------------------------------------
- Google Reviews Data:       ./data/skilledu_5_star_reviews.csv
- Complete Unified JSON:     ./data/skilledu_testimonials_complete.json
- Video Metadata:            ./data/skilledu_video_testimonials.csv
- Video MP4 Files:           ./assets/videos/
- Video Cover Posters:       ./assets/images/banner/
- Reviewer Avatars:          ./assets/images/review-img/
- Brand Logos:               ./assets/images/logo/

------------------------------------------------------------------------
4. EXTERNAL DEPENDENCIES & PRIVACY
------------------------------------------------------------------------
- Web Fonts:
  The page loads Google Fonts ('Inter' and 'Poppins') from Google Fonts CDN
  for enhanced typography. If running completely offline without an internet
  connection, the page automatically falls back to system fonts (sans-serif,
  Segoe UI, Roboto, Arial).
- No Private APIs / No Tokens:
  This package requires ZERO API keys, database credentials, or external tokens.
  All data is bundled locally within this package.

------------------------------------------------------------------------
5. VERIFICATION & INTEGRITY
------------------------------------------------------------------------
- Total Review Records:      67 verified Google 5-star reviews
- Total Video Testimonials:  8 verified student videos (9:16 portrait)
- Total Testimonials:        75 cards
- Column Balance:            Balanced 4-column layout (<3.5% height spread)
- Responsive Viewports:      Desktop (4 cols), Tablet (2 cols), Mobile (1 col)

© SkillEdU. All rights reserved.
========================================================================
