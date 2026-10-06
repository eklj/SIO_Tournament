(() => {
  const script = document.currentScript;
  const backend = new URL('../../backend/', script.src);
  const url = name => new URL(name, backend).href;
  async function init() {
    // Barre indépendante : le contenu et le design de l'accueil restent éditables.
    document.getElementById('sio-auth-navigation')?.remove();
    const nav = document.createElement('nav');
    nav.id = 'sio-auth-navigation';
    nav.setAttribute('aria-label', 'Compte utilisateur');
    document.body.prepend(nav);
    const link = (text, target) => {
      const a = document.createElement('a');
      a.textContent = text;
      a.href = url(target);
      nav.append(a, document.createTextNode(' '));
    };
    try {
      const response = await fetch(url('session.php'), {credentials: 'same-origin', cache: 'no-store'});
      if (!response.ok) throw new Error('Service indisponible');
      const state = await response.json();
      if (state.connecte) {
        const welcome = document.createElement('span');
        welcome.textContent = `Bonjour ${state.utilisateur.pseudo} ! `;
        nav.append(welcome);
        link('Mon profil', 'profil.php');
        const form = document.createElement('form');
        form.method = 'post';
        form.action = url('logout.php');
        const token = document.createElement('input');
        token.type = 'hidden'; token.name = 'csrf'; token.value = state.csrf;
        const button = document.createElement('button');
        button.type = 'submit'; button.textContent = 'Déconnexion';
        form.append(token, button); nav.append(form);
      } else {
        link('Connexion', 'login.php');
        link('Inscription', 'signin.php');
      }
    } catch (error) {
      const message = document.createElement('p');
      message.textContent = 'État de connexion indisponible. Vérifie que le site est ouvert depuis le serveur PHP.';
      nav.append(message);
      link('Connexion', 'login.php');
    }
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
  window.addEventListener('pageshow', event => { if (event.persisted) init(); });
})();
