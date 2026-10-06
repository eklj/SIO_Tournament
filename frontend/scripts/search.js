/**
 * SIO Tournament
 * Fichier : search.js
 * Rôle : ouverture/fermeture de la barre de recherche
 *        + affichage de la fenêtre centrale des résultats.
 *
 * IMPORTANT :
 * Les jeux ne sont PAS stockés ici.
 * Ils devront être récupérés depuis la BDD via l'API PHP.
 *
 * Branche la fonction fetchSearchResults(query) sur ton endpoint
 * lorsque le contrat de l'API sera défini.
 */

document.addEventListener("DOMContentLoaded", () => {
    const searchWrap = document.getElementById("searchWrap");
    const searchToggle = document.getElementById("searchToggle");
    const siteSearch = document.getElementById("siteSearch");
    const searchBackdrop = document.getElementById("searchBackdrop");
    const searchResults = document.getElementById("searchResults");
    const searchResultsBody = document.getElementById("searchResultsBody");
    const searchClose = document.getElementById("searchClose");

    if (
        !searchWrap ||
        !searchToggle ||
        !siteSearch ||
        !searchBackdrop ||
        !searchResults ||
        !searchResultsBody ||
        !searchClose
    ) {
        return;
    }

    let searchTimer = null;

    function openSearch() {
        searchWrap.classList.add("open");
        searchToggle.setAttribute("aria-expanded", "true");

        window.setTimeout(() => {
            siteSearch.focus();
        }, 100);
    }

    function closeResults() {
        searchResults.classList.remove("visible");
        searchBackdrop.classList.remove("visible");
    }

    function closeSearch() {
        closeResults();
        searchWrap.classList.remove("open");
        searchToggle.setAttribute("aria-expanded", "false");
        siteSearch.blur();
    }

    function showMessage(message) {
        searchResultsBody.innerHTML = `
            <div class="search-empty">${escapeHTML(message)}</div>
        `;

        searchBackdrop.classList.add("visible");
        searchResults.classList.add("visible");
    }

    function renderResults(results, query) {
        if (!results.length) {
            showMessage(`Aucun résultat pour « ${query} ».`);
            return;
        }

        searchResultsBody.innerHTML = results.map((item) => `
            <a class="search-result-item" href="${escapeHTML(item.href || "#")}">
                <span class="search-result-icon">${escapeHTML(item.icon || "🎮")}</span>

                <span class="search-result-copy">
                    <strong>${escapeHTML(item.title || "")}</strong>
                    <span>${escapeHTML(item.subtitle || "")}</span>
                </span>

                <span class="search-result-type">
                    ${escapeHTML(item.type || "")}
                </span>
            </a>
        `).join("");

        searchBackdrop.classList.add("visible");
        searchResults.classList.add("visible");
    }

    /**
     * Point d'entrée des données de recherche.
     *
     * À connecter plus tard à la BDD via backend/API.php.
     * Exemple futur :
     *
     * const response = await fetch(
     *     `../backend/API.php?action=search&q=${encodeURIComponent(query)}`
     * );
     * return await response.json();
     */
    async function fetchSearchResults(query) {
        // Placeholder tant que l'endpoint de recherche n'est pas défini.
        // Aucun jeu n'est hardcodé ici.
        return [];
    }

    async function runSearch() {
        const query = siteSearch.value.trim();

        if (!query) {
            closeResults();
            return;
        }

        showMessage("Recherche en cours...");

        try {
            const results = await fetchSearchResults(query);
            renderResults(Array.isArray(results) ? results : [], query);
        } catch (error) {
            console.error("Erreur pendant la recherche :", error);
            showMessage("Impossible d'effectuer la recherche pour le moment.");
        }
    }

    function scheduleSearch() {
        window.clearTimeout(searchTimer);

        searchTimer = window.setTimeout(() => {
            runSearch();
        }, 220);
    }

    function escapeHTML(value) {
        return String(value).replace(/[&<>"']/g, (character) => ({
            "&": "&amp;",
            "<": "&lt;",
            ">": "&gt;",
            '"': "&quot;",
            "'": "&#039;"
        })[character]);
    }

    searchToggle.addEventListener("click", () => {
        if (!searchWrap.classList.contains("open")) {
            openSearch();
            return;
        }

        if (siteSearch.value.trim()) {
            runSearch();
        } else {
            closeSearch();
        }
    });

    siteSearch.addEventListener("input", scheduleSearch);

    siteSearch.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            closeSearch();
        }

        if (event.key === "Enter") {
            event.preventDefault();
            window.clearTimeout(searchTimer);
            runSearch();
        }
    });

    searchBackdrop.addEventListener("click", closeSearch);
    searchClose.addEventListener("click", closeResults);

    searchResultsBody.addEventListener("click", (event) => {
        if (event.target.closest(".search-result-item")) {
            closeSearch();
        }
    });


    // Un clic ailleurs que dans la recherche ou la fenêtre de résultats
    // referme complètement la barre et la remet à sa taille compacte.
    document.addEventListener("click", (event) => {
        const clickedInsideSearch = searchWrap.contains(event.target);
        const clickedInsideResults = searchResults.contains(event.target);

        if (!clickedInsideSearch && !clickedInsideResults) {
            closeSearch();
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            closeSearch();
        }
    });
});
