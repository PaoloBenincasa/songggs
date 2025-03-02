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

// document.addEventListener("DOMContentLoaded", function () {
//     const visitor = document.querySelector("visitor");
//     const loggedIn = document.querySelector("loggedIn");
    
//     const visitorModal = new bootstrap.Modal(document.querySelector("visitorModal"));
//     const loggedInModal = new bootstrap.Modal(document.querySelector("loggedInModal"));

//     if (visitor) {
//         visitor.addEventListener("click", function () {
//             visitorModal.show();
//         });
//     }

//     if (loggedIn) {
//         loggedIn.addEventListener("click", function () {
//             loggedInModal.show();
//         });
//     }
// });

