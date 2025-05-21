document.addEventListener("DOMContentLoaded", () => {
    const radios = document.querySelectorAll('.metode-group input[type="radio"]');
    const labels = document.querySelectorAll('.metode-group label');
    let lastCheckedRadio = null;

    radios.forEach(radio => {
        const label = document.querySelector('label[for="' + radio.id + '"]');
        if (!label) return;

        label.addEventListener('click', (e) => {
            if (lastCheckedRadio === radio) {
                radio.checked = false;
                label.classList.remove('active');
                lastCheckedRadio = null;
                e.preventDefault();
            } else {
                labels.forEach(l => l.classList.remove('active'));
                label.classList.add('active');
                lastCheckedRadio = radio;
            }
        });
    });

    // Saat halaman dimuat, tandai label aktif jika radio sudah dipilih
    radios.forEach(radio => {
        if (radio.checked) {
            const activeLabel = document.querySelector('label[for="' + radio.id + '"]');
            if (activeLabel) {
                activeLabel.classList.add('active');
                lastCheckedRadio = radio;
            }
        }
    });

    // Deteksi success dari data attribute
    const isSuccess = document.body.getAttribute("data-success") === "true";
    if (isSuccess) {
        const popup = document.getElementById("popup-success");
        if (popup) {
            popup.style.display = "flex";
            setTimeout(() => {
                window.location.href = "produk.php";
            }, 2500);
        }
    }
});
