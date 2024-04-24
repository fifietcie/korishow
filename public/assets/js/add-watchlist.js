document.querySelector('.mdc-button').addEventListener('click', function () {
    const animeId = this.getAttribute('data-anime-id');
    const csrfToken = this.getAttribute('data-csrf-token');
    fetch('/watchlist/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': csrfToken
        },
        body: JSON.stringify({ anime_id: animeId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Anime ajouté à votre collection!');
            // Vous pouvez aussi ajouter du code ici pour mettre à jour la page dynamiquement.
        } else {
            alert('Erreur : ' + data.error);
        }
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
});
