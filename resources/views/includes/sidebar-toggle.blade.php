<script>
    (function () {
        var $pageContainer = $(".page-container");
        var $menuSpans = $("#menu span");
        var $sidebarClose = $(".sidebar-close");

        function isMobile() {
            return window.matchMedia("(max-width: 991px)").matches;
        }

        function setDesktopCollapsed(collapsed) {
            if (collapsed) {
                $pageContainer.addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
                $menuSpans.css({ "position": "absolute" });
            } else {
                $pageContainer.removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
                setTimeout(function () {
                    $menuSpans.css({ "position": "relative" });
                }, 400);
            }
        }

        function closeMobileSidebar() {
            if (isMobile()) {
                $pageContainer.removeClass("sidebar-open");
                $("body").removeClass("sidebar-open");
            }
        }

        $(".sidebar-icon").on("click", function (event) {
            event.preventDefault();

            if (isMobile()) {
                $pageContainer.toggleClass("sidebar-open");
                $("body").toggleClass("sidebar-open", $pageContainer.hasClass("sidebar-open"));
                return;
            }

            setDesktopCollapsed(!$pageContainer.hasClass("sidebar-collapsed"));
        });

        $sidebarClose.on("click", function () {
            closeMobileSidebar();
        });

        $(document).on("click", function (event) {
            if (!isMobile()) {
                return;
            }

            if (!$pageContainer.hasClass("sidebar-open")) {
                return;
            }

            if ($(event.target).closest(".sidebar-menu, .sidebar-icon").length === 0) {
                closeMobileSidebar();
            }
        });

        $(window).on("resize", function () {
            if (!isMobile()) {
                $pageContainer.removeClass("sidebar-collapsed-back");
                $pageContainer.removeClass("sidebar-open");
                $("body").removeClass("sidebar-open");
            }
        });

        $(document).on("keydown", function (event) {
            if (event.key === "Escape") {
                closeMobileSidebar();
            }
        });
    })();
</script>
