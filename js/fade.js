
        // Initialize AOS when the content has loaded
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
               
            });
        });

        // Initialize Smooth Scroll
        var scroll = new SmoothScroll('a[data-scroll]', {
            speed: 500
        });