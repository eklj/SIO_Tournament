/**
 * SIO Tournament
 * Fichier : signin.js
 * Rôle : envoyer le formulaire d'inscription à l'API PHP signin.php.
 *
 * CONTRAT ATTENDU :
 * POST ../backend/signin.php
 *
 * Réponse JSON succès :
 * {
 *   "success": true,
 *   "message": "Inscription réussie."
 * }
 *
 * Réponse JSON erreur :
 * {
 *   "success": false,
 *   "message": "...",
 *   "errors": ["..."]
 * }
 */

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("signinForm");
    const message = document.getElementById("signinMessage");
    const submit = document.getElementById("signinSubmit");

    if (!form || !message || !submit) return;

    function showMessage(text, type = "error") {
        message.textContent = text;
        message.className = `auth-message visible ${type}`;
    }

    form.addEventListener("submit", async (event) => {
        event.preventDefault();

        const password = form.elements["mot_de_passe"].value;
        const confirmation = form.elements["confirmation"].value;

        if (password !== confirmation) {
            showMessage("Les mots de passe ne correspondent pas.");
            return;
        }

        submit.disabled = true;
        submit.textContent = "Création...";

        try {
            const response = await fetch("../backend/signin.php", {
                method: "POST",
                body: new FormData(form),
                credentials: "same-origin",
                headers: {
                    "Accept": "application/json"
                }
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                const text =
                    Array.isArray(result.errors) && result.errors.length
                        ? result.errors.join(" ")
                        : (result.message || "Inscription impossible.");

                showMessage(text);
                return;
            }

            showMessage(result.message || "Inscription réussie.", "success");

            window.setTimeout(() => {
                window.location.href = "login.html";
            }, 900);
        } catch (error) {
            console.error("Erreur inscription :", error);
            showMessage("Impossible de contacter l'API d'inscription.");
        } finally {
            submit.disabled = false;
            submit.textContent = "S'inscrire";
        }
    });
});
