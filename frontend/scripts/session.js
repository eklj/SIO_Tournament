/**
 * SIO Tournament
 * Fichier : session.js
 * Rôle : synchroniser la navbar avec la session PHP.
 */

document.addEventListener("DOMContentLoaded", async () => {
    const authButton = document.getElementById("authButton");
    const authButtonText = document.getElementById("authButtonText");

    if (!authButton || !authButtonText) return;

    try {
        const response = await fetch("../backend/session.php", {
            method: "GET",
            credentials: "same-origin",
            cache: "no-store",
            headers: {
                "Accept": "application/json"
            }
        });

        if (!response.ok) return;

        const result = await response.json();

        if (!result.authenticated || !result.user) {
            authButtonText.textContent = "Sign In";
            authButton.href = "login.html";
            authButton.dataset.authenticated = "false";
            delete authButton.dataset.csrf;
            return;
        }

        authButtonText.textContent = result.user.pseudo || "Compte";
        authButton.href = "#";
        authButton.dataset.authenticated = "true";

        if (result.csrf) {
            authButton.dataset.csrf = result.csrf;
        }

        authButton.setAttribute(
            "title",
            `Connecté en tant que ${result.user.pseudo} — cliquer pour se déconnecter`
        );
    } catch (error) {
        console.debug("API session indisponible :", error);
    }
});
