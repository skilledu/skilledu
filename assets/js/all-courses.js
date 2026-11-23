
    // Whole card click functionality for course cards (excluding Enroll button)
    (function () {
      function initCourseCardClicks() {
        var container = document.getElementById("our_courses");
        if (!container) return;

        // Cache data-course-url on cards for accessibility and inspector visibility
        var cards = container.querySelectorAll(".courses__item");
        cards.forEach(function (card) {
          var thumbLink = card.querySelector(".courses__item-thumb a");
          if (thumbLink && thumbLink.getAttribute("href")) {
            card.setAttribute("data-course-url", thumbLink.getAttribute("href"));
          }
        });

        function handleCardNavigation(e) {
          // Exclude clicks on or inside the Enroll button
          if (e.target.closest(".courses__item-bottom .button a, .button a, a[href*='wa.me']")) {
            return;
          }

          // Find parent course card
          var card = e.target.closest(".courses__item");
          if (!card) return;

          // Extract course detail URL
          var thumbLink = card.querySelector(".courses__item-thumb a");
          var targetUrl = card.getAttribute("data-course-url") || (thumbLink ? thumbLink.getAttribute("href") : null);
          if (!targetUrl) return;

          // Do not navigate if user is selecting text
          var selection = window.getSelection ? window.getSelection().toString() : "";
          if (selection && selection.trim().length > 0) {
            return;
          }

          // If click is on a native link already pointing to targetUrl (e.g. image link, title link), let browser handle it
          var clickedAnchor = e.target.closest("a");
          if (clickedAnchor && (clickedAnchor.getAttribute("href") === targetUrl || clickedAnchor.href === (thumbLink && thumbLink.href))) {
            return;
          }

          // Navigate to course detail page
          e.preventDefault();
          if (e.metaKey || e.ctrlKey || e.button === 1) {
            window.open(targetUrl, "_blank");
          } else {
            window.location.href = targetUrl;
          }
        }

        container.addEventListener("click", handleCardNavigation);

        // Support middle-click on blank card areas
        container.addEventListener("auxclick", function (e) {
          if (e.button === 1) {
            handleCardNavigation(e);
          }
        });
      }

      if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initCourseCardClicks);
      } else {
        initCourseCardClicks();
      }
    })();
  