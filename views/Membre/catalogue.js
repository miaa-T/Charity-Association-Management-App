document.addEventListener("DOMContentLoaded", () => {
    const scrollContainers = document.querySelectorAll(".scroll-container");
  
    scrollContainers.forEach((container) => {
      container.addEventListener("wheel", (event) => {
        event.preventDefault();
        container.scrollLeft += event.deltaY;
      });
    });
  });
  