const form = document.getElementById("loginForm");
const errorMessage = document.getElementById("loginError");

form.addEventListener("submit", async (event) => {
    event.preventDefault();

    const formData = new FormData(form);

    try {
        const response = await fetch("../backend/login.php", {
            method: "POST",
            body: formData,
            credentials: "same-origin"
        });

        const result = await response.json();

        if (!response.ok || !result.success) {
            errorMessage.textContent =
                result.message || "Connexion impossible.";

            return;
        }

        window.location.href = "index.html";

    } catch (error) {
        console.error(error);

        errorMessage.textContent =
            "Impossible de contacter le serveur.";
    }
});