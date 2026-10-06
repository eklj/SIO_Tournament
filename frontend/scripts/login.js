/**
 * SIO Tournament
 * Fichier : login.js
 * Rôle : envoyer le formulaire de connexion à l'API PHP login.php.
 *
 * CONTRAT ATTENDU :
 * POST ../backend/login.php
 * Réponse JSON succès :
 * {
 *   "success": true,
 *   "user": {
 *     "id": 1,
 *     "pseudo": "Adam",
 *     "role": "joueur"
 *   }
 * }
 *
 * Réponse JSON erreur :
 * {
 *   "success": false,
 *   "message": "Pseudo ou mot de passe incorrect."
 * }
 */

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("loginForm");
    const message = document.getElementById("loginMessage");
    const submit = document.getElementById("loginSubmit");

    if (!form || !message || !submit) return;

    function showMessage(text, type = "error") {
        message.textContent = text;
        message.className = `auth-message visible ${type}`;
    }

    form.addEventListener("submit", async (event) => {
        event.preventDefault();

        submit.disabled = true;
        submit.textContent = "Connexion...";

        try {
            const response = await fetch("../backend/login.php", {
                method: "POST",
                body: new FormData(form),
                credentials: "same-origin",
                headers: {
                    "Accept": "application/json"
                }
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                showMessage(result.message || "Connexion impossible.");
                return;
            }

            window.location.href = "index.html";
        } catch (error) {
            console.error("Erreur login :", error);
            showMessage("Impossible de contacter l'API de connexion.");
        } finally {
            submit.disabled = false;
            submit.textContent = "Se connecter";
        }
    });
});
