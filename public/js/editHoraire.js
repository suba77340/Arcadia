document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.edit-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            fetch(`/admin/horaires/edit/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.querySelector(`#jour-${id}`).value = data.jour;
                    document.querySelector(`#ouverture-${id}`).value = data.ouverture;
                    document.querySelector(`#fermeture-${id}`).value = data.fermeture;
                    document.querySelector(`#form-${id}`).style.display = 'block';
                })
                .catch(() => alert('Une erreur s\'est produite. Veuillez réessayer.'));
        });
    });

    document.querySelectorAll('.edit-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(this);
            const id = formData.get('id');

            fetch(`/admin/horaires/edit/${id}`, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('L\'horaire a été modifié avec succès');
                        location.reload();
                    } else {
                        alert('Erreur : ' + data.message);
                    }
                })
                .catch(() => alert('Une erreur s\'est produite. Veuillez réessayer.'));
        });
    });

    document.querySelectorAll('.delete-btn').forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const id = this.dataset.id;

            fetch(`/admin/horaires/delete/${id}`, {
                method: 'POST'
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('L\'horaire a été supprimé avec succès');
                        location.reload();
                    } else {
                        alert('Erreur : ' + data.message);
                    }
                })
                .catch(() => alert('Une erreur s\'est produite. Veuillez réessayer.'));
        });
    });

    const formAjout = document.querySelector('#form-ajout-horaire');
    if (formAjout) {
        formAjout.addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch('/admin/horaires/create', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('L\'horaire a été ajouté avec succès');
                        location.reload();
                    } else {
                        alert('Erreur : ' + data.message);
                    }
                })
                .catch(() => alert('Une erreur s\'est produite. Veuillez réessayer.'));
        });
    }
});
