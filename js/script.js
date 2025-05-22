const navbarNav = document.querySelector(".navbar-nav");
const hamburger = document.querySelector("#hamburger-menu");

hamburger.onclick = () => {
    navbarNav.classList.toggle("active");
};

document.addEventListener("click", function(e) {
    if (!hamburger.contains(e.target) && !navbarNav.contains(e.target)) {
        navbarNav.classList.remove("active");
    }
});

// Tambahan: Tutup navbar saat link diklik
document.querySelectorAll(".navbar-nav a").forEach(link => {
    link.addEventListener("click", () => {
        navbarNav.classList.remove("active");
    });
});
