/**
 * SIO Tournament
 * Fichier : session.js
 * Rôle : synchroniser la navbar avec la session PHP.
 *
 * ENDPOINT ATTENDU :
 * GET ../backend/session.php
 *
 * Exemple connecté :
 * {
 *   "authenticated": true,
 *   "user": {
 *     "id": 1,
 *     "pseudo": "Adam",
 *     "role": "joueur"
 *   }
 * }
 *
 * Exemple déconnecté :
 * {
 *   "authenticated": false
 * }
 *
 * Si session.php n'existe pas encore, la page garde simplement "Sign In".
 */

document.addEventListener("DOMContentLoaded", async () => {
    const authButton = document.getElementById("authButton");
    const authButtonText = document.getElementById("authButtonText");

    if (!authButton || !authButtonText) return;

    try {
        const response = await fetch("../backend/session.php", {
            method: "GET",
            credentials: "same-origin",
            headers: {
                "Accept": "application/json"
            }
        });

        if (!response.ok) return;

        const result = await response.json();

        if (!result.authenticated || !result.user) return;

        authButtonText.textContent = result.user.pseudo || "Compte";
        authButton.href = "#";
        authButton.setAttribute("title", "Compte connecté");
    } catch (error) {
        // session.php peut ne pas encore exister : aucune erreur bloquante.
        console.debug("Session API indisponible :", error);
    }
});
