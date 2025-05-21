document.addEventListener("DOMContentLoaded", () => {
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

    const stars = document.querySelectorAll('.rating-group label');
    stars.forEach(label => {
        label.addEventListener('mouseenter', () => {
            let val = parseInt(label.getAttribute('for').replace('rating', ''));
            stars.forEach(star => {
                let current = parseInt(star.getAttribute('for').replace('rating', ''));
                star.style.color = current <= val ? 'gold' : '#ccc';
            });
        });

        label.addEventListener('mouseleave', () => {
            const selected = document.querySelector('.rating-group input[type="radio"]:checked');
            let val = selected ? parseInt(selected.value) : 0;
            stars.forEach(star => {
                let current = parseInt(star.getAttribute('for').replace('rating', ''));
                star.style.color = current <= val ? 'gold' : '#ccc';
            });
        });
    });
});
