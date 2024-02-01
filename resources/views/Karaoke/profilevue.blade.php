@extends('templates.karaoke')

@section('document')

  <!-- Ajout du style pour les images -->
  <style>
    .user-images {
      display: flex;
      flex-wrap: wrap;
      justify-content: flex-end;
      gap: 10px;
    }

    .image-container {
      position: relative;
    }

    .user-images img {
      width: calc(25% - 10px);
      max-width: 100%;
      height: auto;
    }

    .user-images img:first-child {
      width: 100%;
    }

    .edit-image-btn {
      position: absolute;
      bottom: 10px;
      right: 10px;
    }

    #modifyImagesBtn {
      margin-top: 20px;
    }

    #imageModal .modal-body {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      max-height: 60vh;
      overflow-y: auto;
    }

    #imageModal .modal-body img {
      width: calc(33.33% - 10px);
      max-width: 100%;
      height: auto;
    }

    #imageModal .modal-body .edit-image-btn {
      position: absolute;
      bottom: 5px;
      right: 5px;
      
    }
    
    .editable-content {
      border: 1px solid #ced4da;
      border-radius: 0.1rem;
      padding: 0.375rem 0.75rem;
      margin-bottom: 1rem;
      display: inline-block;
       /* Ensures the content expands to fill the available space */
    }

    .editable-content button {
      margin-left: 1rem;
    }
     
    body {
      background-color: #f8f9fa;
      font-family: 'Open Sans', sans-serif;
    }
    
    section {
      padding: 60px 0;
    }
    .user-profile h2 {
      color: #007bff;
    }
    .user-profile {
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }
  </style>
</head>
<body>

  <section class="d-flex align-items-center">
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center">
      <div class="container d-flex align-items-center">
        <h1 class="logo me-auto"><img src="assets/img/nous_logo.png" alt=""></h1>
      </div>
    </header><!-- End Header -->
  </section><!-- End Hero -->

  <main id="main">
    <section id="user-profile" class="user-profile">
      <div class="container">
        <div class="row">

            <div class="col-lg-4">
                <h2>Cathérine</h2>
                <div class="user-images">
                  <img src="assets\img\tabs-1.jpg" alt="Image 1">
                  <img src="assets\img\tabs-2.jpg" alt="Image 2">
                  <img src="assets\img\tabs-3.jpg" alt="Image 3">
                  <img src="assets\img\tabs-4.jpg" alt="Image 4">
                  <img src="assets\img\tabs-4.jpg" alt="Image 5">
                </div>
                <div class="text-center">
                    <!-- Bouton "Modifier les images"  -->
                    <button id="modifyImagesBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#imageModal">Modifier les images</button>
                </div>
                                  
            </div>

          <div class="col-lg-8 ">
            <!-- Colonne pour les informations de l'utilisateur -->
            <h2 style="margin-top: 2rem;">informations Personnelles</h2>
           
              <div class="mb-3">
                <label><h5>Tel:</h5></label>
                <span id="userPhone">29 99 99 99</span>
                <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editInformation('userPhone')">Modifier</button>
              </div>
            <div class="mb-3">
              <label><h5>Nom:</h5></label>
              <span id="userName">Cathérine</span>
              <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editInformation('userName')">Modifier</button>
            </div>
            <div class="mb-3">
              <label> <h5>Âge:</h5></label>
              <span id="userAge">25</span>
              <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editInformation('userAge')">Modifier</button>
            </div>
            <div class="mb-3">
                <label><h5>À propos de moi</h5></label><br>
                <span  class="editable-content" id="about">MOi bon voila ok aloons y seulement pfffff <br>
                    MOi bon voila ok aloons y seulement pfffff
                MOi bon voila ok aloons y seulement pfffff</span>
                <button class="btn btn-secondary btn-sm" onclick="editBiography('about')">Modifier</button>
            </div>

            <div class="mb-3">
                <label><h5>Centres d'intérêt</h5></label><br>
                <span  class="editable-content"  id="interests">Intérêt 1, Intérêt 2</span>
                <button class="btn btn-secondary btn-sm" onclick="editBiography('interests')">Modifier</button>
            </div>
            <!-- 
              <div class="mb-3">
                <label><h5>Centres d'intérêt</h5></label>
                <div id="interestsView" class="editable-content">
                  <span id="interests">Intérêt 1, Intérêt 2</span>
                  <button class="btn btn-secondary btn-sm" onclick="editBiography('interests')">Modifier</button>
                </div>
              </div>
            </div> -->
          </div>
          <!-- Colonne pour les images de l'utilisateur -->
          
        </div>
      </div>
    </section>
  </main>

  <div class="modal fade" id="editImageModal" tabindex="-1" aria-labelledby="editImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editImageModalLabel">Modifier l'image</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <label for="editImageInput">Nouvelle image:</label>
          <input type="file" id="editImageInput" name="editImageInput" class="form-control">
          <button class="btn btn-primary" onclick="uploadImage()">Uploader</button>
  
          <!-- Cropper.js -->
          <div class="image-container">
            <img src="assets\img\tabs-1.jpg" alt="Image 1" class="image-cropper">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quitter</button>
          <button type="button" class="btn btn-primary" onclick="saveImageEdit()">Enregistrer</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Ajouter une modal pour l'édition des informations -->
  <!-- Ajouter une modal pour l'édition des informations -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Modifier l'information</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <label for="editField">Nouvelle valeur:</label>
          <input type="text" id="editField" name="editField" class="form-control">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quitter</button>
          <button type="button" class="btn btn-primary" onclick="saveEdit()">Enregistrer</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Ajouter une modal pour modifier les images -->
  <!-- Ajouter une modal pour modifier les images -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imageModalLabel">Modifier les images</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Vignettes des images avec bouton "Modifier" -->
          <div class="image-container">
            <img src="assets\img\tabs-1.jpg" alt="Image 1" class="image-cropper">
            <label class="btn btn-secondary btn-sm edit-image-btn" data-image-index="0">
                Choisir une image
                <input type="file" class="image-input" style="display:none;" data-image-index="0">
                </label>
          </div>
          <div class="image-container">
            <img src="assets\img\tabs-2.jpg" alt="Image 2" class="image-cropper">
            <label class="btn btn-secondary btn-sm edit-image-btn" data-image-index="0">
                Choisir une image
                <input type="file" class="image-input" style="display:none;" data-image-index="0">
                </label>
          </div>
          <div class="image-container">
            <img src="assets\img\tabs-3.jpg" alt="Image 3" class="image-cropper">
            <label class="btn btn-secondary btn-sm edit-image-btn" data-image-index="0">
                Choisir une image
                <input type="file" class="image-input" style="display:none;" data-image-index="0">
                </label>
          </div>
          <div class="image-container">
            <img src="assets\img\tabs-4.jpg" alt="Image 4" class="image-cropper">
            <label class="btn btn-secondary btn-sm edit-image-btn" data-image-index="0">
                Choisir une image
                <input type="file" class="image-input" style="display:none;" data-image-index="0">
                </label>
          </div>
         <!-- Vignettes des images avec bouton "Choisir une image" -->
        <div class="image-container">
            <img src="assets\img\tabs-4.jpg" alt="Image 1" class="image-cropper">
            <label class="btn btn-secondary btn-sm edit-image-btn" data-image-index="0">
            Choisir une image
            <input type="file" class="image-input" style="display:none;" data-image-index="0">
            </label>
        </div>
  <!-- Répéter la structure ci-dessus pour les autres images -->
  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Quitter</button>
          <button type="button" class="btn btn-primary ml-auto" onclick="uploadNewImages()">Enregistrer</button>
        </div>
      </div>
    </div>
  </div>
  

<!-- Ajouter ce script à la fin de votre balise body -->
<script>

function uploadImage() {
    // Récupérer le fichier sélectionné par l'utilisateur
    var input = document.getElementById('editImageInput');
    var file = input.files[0];

    if (file) {
      // Créer un objet FormData et y ajouter le fichier
      var formData = new FormData();
      formData.append('image', file);

      // Envoyer le fichier au serveur
      fetch('URL_DE_VOTRE_SCRIPT_SERVEUR', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        // Gérer la réponse du serveur ici
        console.log('Réponse du serveur:', data);
      })
      .catch(error => {
        console.error('Erreur lors de l\'envoi de l\'image:', error);
      });
    }
  }
   var currentFieldName; // Variable globale pour stocker le nom du champ en cours d'édition
    var currentImageIndex; // Variable globale pour stocker l'index de l'image en cours d'édition
    var cropper; // Variable globale pour stocker l'instance du cropper

    function editInformation(fieldName) {
      // Récupérer la valeur actuelle de l'information
      var currentValue = $("#" + fieldName).text();

      // Pré-remplir le champ d'édition du modal avec la valeur actuelle
      $("#editField").val(currentValue);

      // Stocker le nom du champ en cours d'édition dans la variable globale
      currentFieldName = fieldName;

      // Afficher le modal
      $("#editModal").modal("show");
    }

    // Événement avant l'affichage du modal d'édition des images
    $('#editImageModal').on('show.bs.modal', function (event) {
      // Récupérer l'index de l'image en cours d'édition
      currentImageIndex = $(event.relatedTarget).data('image-index');

      // Initialiser le cropper avec l'image sélectionnée
      cropper = new Cropper($('.image-cropper')[currentImageIndex], {
        aspectRatio: 16 / 9, // Vous pouvez ajuster le ratio selon vos besoins
      });
    });

    function saveImageEdit() {
      // Récupérer le canvas résultant du cropper
      var canvas = cropper.getCroppedCanvas();

      // Convertir le canvas en une image base64
      var editedImageSrc = canvas.toDataURL('image/jpeg');

      // Mettre à jour la source de l'image sur la page
      $('.image-cropper')[currentImageIndex].src = editedImageSrc;

      // Fermer le modal
      $('#editImageModal').modal('hide');
    }

    function saveEdit() {
            // Récupérer la nouvelle valeur depuis le champ d'édition du modal
            var newValue = $("#editField").val();

// Mettre à jour la valeur sur la page
$("#" + currentFieldName).text(newValue);

// Fermer le modal
$("#editModal").modal("hide");
}

function editBiography(fieldName) {
// Récupérer la valeur actuelle de la biographie ou des centres d'intérêt
var currentValue = $("#" + fieldName).text();

// Pré-remplir le champ d'édition du modal avec la valeur actuelle
$("#editField").val(currentValue);

// Stocker le nom du champ en cours d'édition dans la variable globale
currentFieldName = fieldName;

// Afficher le modal
$("#editModal").modal("show");
}

// Événement avant la fermeture du modal d'édition des images
$('#editImageModal').on('hidden.bs.modal', function () {
// Détruire l'instance du cropper pour libérer les ressources
cropper.destroy();
});
function uploadImage() {
    // Récupérer le fichier sélectionné par l'utilisateur
    var input = document.getElementById('editImageInput');
    var file = input.files[0];

    if (file) {
      // Lire le fichier en tant que Data URL
      var reader = new FileReader();
      reader.onload = function (e) {
        // Mettre à jour la source de l'image du cropper avec le fichier local
        $('.image-cropper').attr('src', e.target.result);
      };
      reader.readAsDataURL(file);
    }
  }
</script>

@endsection