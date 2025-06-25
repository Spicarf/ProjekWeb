const navbarNav = document.querySelector(".navbar-nav");
const hamburger = document.querySelector("#hamburger-menu");
let produkIdToBeli = null;

hamburger.onclick = () => {
    navbarNav.classList.toggle("active");
};

document.addEventListener("click", function(e) {
    if (!hamburger.contains(e.target) && !navbarNav.contains(e.target)) {
        navbarNav.classList.remove("active");
    }
});

document.querySelectorAll(".navbar-nav a").forEach(link => {
    link.addEventListener("click", () => {
        navbarNav.classList.remove("active");
    });
});

function konfirmasiBeli(id_produk) {
    produkIdToBeli = id_produk;
    document.getElementById("popup-modal").style.display = "flex";
}

function tutupPopup() {
    document.getElementById("popup-modal").style.display = "none";
}

function prosesBeli() {
    const jumlah = parseInt(document.getElementById("jumlah_pembelian").value);

    if (isNaN(jumlah) || jumlah <= 0) {
        alert("Jumlah tidak valid.");
        return;
    }

    window.location.href = `transaksi.php?id_produk=${produkIdToBeli}&jumlah_pembelian=${jumlah}`;
}
