/**
 * SIO Tournament
 * Fichier : logout.js
 * Rôle : déconnecter l'utilisateur via l'API PHP logout.php.
 *
 * CONTRAT ATTENDU :
 * POST ../backend/logout.php
 * Header :
 * X-CSRF-Token: <token>
 *
 * Réponse JSON succès :
 * {
 *   "success": true,
 *   "message": "Déconnexion réussie."
 * }
 */

document.addEventListener("DOMContentLoaded", () => {
    const authButton = document.getElementById("authButton");
    const authButtonText = document.getElementById("authButtonText");

    if (!authButton || !authButtonText) return;

    authButton.addEventListener("click", async (event) => {
        if (authButton.dataset.authenticated !== "true") {
            return;
        }

        event.preventDefault();

        const csrf = authButton.dataset.csrf;

        if (!csrf) {
            console.error("Token CSRF absent pour la déconnexion.");
            return;
        }

        const originalText = authButtonText.textContent;

        authButton.classList.add("loading");
        authButtonText.textContent = "Déconnexion...";

        try {
            const response = await fetch("../backend/logout.php", {
                method: "POST",
                credentials: "same-origin",
                headers: {
                    "Accept": "application/json",
                    "X-CSRF-Token": csrf
                }
            });

            const contentType = response.headers.get("content-type") || "";

            if (!contentType.includes("application/json")) {
                throw new Error("logout.php n'a pas retourné du JSON.");
            }

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(result.message || "Déconnexion impossible.");
            }

            authButton.dataset.authenticated = "false";
            delete authButton.dataset.csrf;
            authButton.href = "login.html";
            authButtonText.textContent = "Sign In";
            authButton.setAttribute("title", "Se connecter");

            window.location.href = "index.html";
        } catch (error) {
            console.error("Erreur logout :", error);
            authButtonText.textContent = originalText;
        } finally {
            authButton.classList.remove("loading");
        }
    });
});
