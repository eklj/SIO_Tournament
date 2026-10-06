/**
 * SIO Tournament
 * Fichier : leaderboard-tabs.js
 * Rôle : gestion visuelle des onglets du classement.
 *
 * Ce fichier ne gère QUE les onglets du leaderboard.
 */

document.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll(".tab");

    tabs.forEach((button) => {
        button.addEventListener("click", () => {
            tabs.forEach((tab) => tab.classList.remove("active"));
            button.classList.add("active");
        });
    });
});
