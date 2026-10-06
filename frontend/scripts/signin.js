/**
 * SIO Tournament
 * Fichier : signin.js
 * Rôle : envoyer le formulaire d'inscription à l'API PHP signin.php.
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

    function clearMessage() {
        message.textContent = "";
        message.className = "auth-message";
    }

    form.addEventListener("submit", async (event) => {
        event.preventDefault();
        clearMessage();

        const payload = {
            nom: form.elements["nom"].value.trim(),
            prenom: form.elements["prenom"].value.trim(),
            pseudo: form.elements["pseudo"].value.trim(),
            email: form.elements["email"].value.trim(),
            mot_de_passe: form.elements["mot_de_passe"].value,
            confirmation: form.elements["confirmation"].value
        };

        if (payload.mot_de_passe !== payload.confirmation) {
            showMessage("Les mots de passe ne correspondent pas.");
            return;
        }

        submit.disabled = true;
        submit.textContent = "Création...";

        try {
            const response = await fetch("../backend/signin.php", {
                method: "POST",
                credentials: "same-origin",
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(payload)
            });

            const contentType = response.headers.get("content-type") || "";

            if (!contentType.includes("application/json")) {
                throw new Error("signin.php n'a pas retourné du JSON.");
            }

            const result = await response.json();

            if (!response.ok || !result.success) {
                const text =
                    Array.isArray(result.errors) && result.errors.length
                        ? result.errors.join(" ")
                        : (result.message || "Inscription impossible.");

                showMessage(text);
                return;
            }

            showMessage(result.message || "Compte créé avec succès.", "success");

            window.setTimeout(() => {
                window.location.href = "login.html";
            }, 800);
        } catch (error) {
            console.error("Erreur inscription :", error);
            showMessage("Impossible de contacter l'API d'inscription.");
        } finally {
            submit.disabled = false;
            submit.textContent = "S'inscrire";
        }
    });
});
