## Arborescence prévue

```text
plateforme-esport-sio/
├── frontend/
├── backend/
├── database/
├── docs/
├── .gitignore
└── README.md
```

## Initialiser Git

```bash
cd plateforme-esport-sio
git init -b main
git status
```

Le fichier `.gitignore` doit être présent avant le premier commit. Aucun mot de passe, token, secret ou fichier `.env` ne doit être envoyé sur GitHub.

## Créer le premier commit

```bash
git add .
git commit -m "Initialisation et conception du projet"
```

## Relier le dépôt GitHub

Après avoir créé un dépôt vide nommé `plateforme-esport-sio` sur GitHub :

```bash
git remote add origin URL_DU_DEPOT
git remote -v
git push -u origin main
```

`URL_DU_DEPOT` devra être remplacée par l'adresse réelle du dépôt GitHub.
