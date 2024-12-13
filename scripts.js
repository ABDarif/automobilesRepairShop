// Add basic interactivity for UI feedback
document.addEventListener("DOMContentLoaded", function() {
    const links = document.querySelectorAll("nav ul li a");

    // Highlight active link
    links.forEach(link => {
        link.addEventListener("mouseover", () => link.style.color = "#64ffda");
        link.addEventListener("mouseleave", () => link.style.color = "#8892b0");
    });

    // Example: Confirmation on form submission
    const form = document.querySelector("form");
    if (form) {
        form.addEventListener("submit", function(event) {
            const confirmation = confirm("Are you sure you want to submit?");
            if (!confirmation) {
                event.preventDefault();
            }
        });
    }
});
