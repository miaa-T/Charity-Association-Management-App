
// JavaScript can be used for adding interactivity or dynamic functionality later.
console.log("Page loaded!");
document.getElementById('search-input').addEventListener('input', function () {
    console.log('Searching:', this.value);
    // Add functionality to filter table rows based on search query
});
document.addEventListener("DOMContentLoaded", () => {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll(".nav-links a");

    navLinks.forEach(link => {
        if (link.href.includes(currentPath)) {
            link.classList.add("active");
        }
    });
});
document.addEventListener("DOMContentLoaded", () => {
    const scrollContainers = document.querySelectorAll(".scroll-container");

    scrollContainers.forEach((container) => {
        container.addEventListener("wheel", (event) => {
            if (event.deltaY !== 0) {
                event.preventDefault();
                container.scrollLeft += event.deltaY;
            }
        });
    });
});
document.querySelector('.filter-btn').addEventListener('click', () => {
    alert('Filter functionality coming soon!');
});

document.querySelector('.search-input').addEventListener('input', (e) => {
    console.log('Searching for:', e.target.value);
});
// Example: Alert on Submit
document.querySelectorAll('form').forEach((form) => {
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        alert('Form submitted!');
    });
});
// File upload change handler
document.querySelectorAll('.file-upload input').forEach(input => {
    input.addEventListener('change', (e) => {
        alert(`File selected: ${e.target.files[0].name}`);
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const newsContainer = document.querySelector(".news-container");
    let isScrolling = false;

    // Fonction de défilement automatique
    const autoScroll = () => {
        if (!isScrolling) {
            newsContainer.scrollBy({
                left: 1,
                behavior: "smooth",
            });
            if (
                newsContainer.scrollLeft + newsContainer.offsetWidth >=
                newsContainer.scrollWidth
            ) {
                newsContainer.scrollTo({ left: 0, behavior: "smooth" });
            }
        }
    };

    let scrollInterval = setInterval(autoScroll, 20);

    // Pause le défilement au survol de la souris
    newsContainer.addEventListener("mouseenter", () => {
        isScrolling = true;
        clearInterval(scrollInterval);
    });

    // Reprendre le défilement en quittant la zone
    newsContainer.addEventListener("mouseleave", () => {
        isScrolling = false;
        scrollInterval = setInterval(autoScroll, 20);
    });
});

