




function handleAvatarChange(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById('avatar-preview');
            preview.src = e.target.result;
            document.getElementById('avatar-input').value = e.target.result; // Update the hidden input value
        };
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('avatar-input').addEventListener('change', handleAvatarChange);



    
function showCommentForm(id) {
    var commentForm = document.getElementById('commentForm' + id);
    commentForm.style.display = 'block';
}


// ajouter des objets à la liste----------------------------------------------------------//
var selectObjets = document.getElementById('objets');
    var objetSelectionne = selectObjets.value;

    // Vérifier si l'objet est déjà sélectionné
    if (objetsSelectionnes.includes(objetSelectionne)) {
        alert("Cet objet est déjà sélectionné.");
        return;
    }

    objetsSelectionnes.push(objetSelectionne);

    // Afficher les objets sélectionnés dans la section de prévisualisation
    var listeObjetsSelectionnes = document.getElementById('listeObjetsSelectionnes');
    listeObjetsSelectionnes.innerHTML = ''; // Effacer le contenu précédent

    for (var i = 0; i < objetsSelectionnes.length; i++) {
        var objetId = objetsSelectionnes[i];
        var nomObjet = selectObjets.options[selectObjets.selectedIndex].text;
        var objetHTML = '<div><p>Nom : ' + nomObjet + '</p></div>';
        listeObjetsSelectionnes.innerHTML += objetHTML;

        // Mettre à jour la valeur du champ objets[] dans le formulaire
        var inputObjets = document.createElement('input');
        inputObjets.setAttribute('type', 'hidden');
        inputObjets.setAttribute('name', 'objets[]');
        inputObjets.setAttribute('value', objetId);
        document.getElementById('listeObjetsSelectionnes').appendChild(inputObjets);
    }

