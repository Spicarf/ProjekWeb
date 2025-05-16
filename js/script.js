// Toggle
const navbarNav = document.querySelector(".navbar-nav");
const hamburger = document.querySelector("#hamburger-menu");

document.querySelector("#hamburger-menu").onclick = () => {
    navbarNav.classList.toggle("active");
};

document.addEventListener("click", function(e) {
    // Perbaikan typo: targer => target
    if (!hamburger.contains(e.target) && !navbarNav.contains(e.target)) {
        navbarNav.classList.remove("active");
    }
});
