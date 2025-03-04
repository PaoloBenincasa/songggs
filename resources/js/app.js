import 'bootstrap/dist/css/bootstrap.min.css';  // Importa il CSS di Bootstrap
import 'bootstrap';  // Importa il JS di Bootstrap

document.addEventListener("DOMContentLoaded", () => {
    const nav = document.querySelector(".navbar");

    if (nav) {
        window.addEventListener("scroll", () => {
            if (window.scrollY > 78) {
                nav.classList.add("scrolled");
            } else {
                nav.classList.remove("scrolled");
            }
        });
    } else {
        console.error("Navbar non trovata!");
    }
});

