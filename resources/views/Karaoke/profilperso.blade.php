<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>NOUS</title>
    <!-- Favicons -->
    <link href="{{ asset('assets/img/nous_logo.png') }}" rel="icon">
<link href="{{ asset('assets/img/nous_logo.png') }}" rel="apple-touch-icon">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
<!-- Vendor CSS Files -->
<link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
<!-- Template Main CSS File -->
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        .edit-icon {
            cursor: pointer;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
    </style>
    
</head>

<body>

    @if($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @include('components.headerKa')
    <main id="main">
    @if(!$user->photo1)
        <div class="alert alert-warning" role="alert">
        Attention : Veuillez ajouter vos photos de profil.
        </div>

        @endif
        
        <section id="user-profile" class="user-profile">
            <div class="container">
                <div class="row">

                    <div class="col-lg-6">
                        <h2>{{ $user->pseudo }}</h2>
                        <div class="user-images">
                            <img src="{{ asset('storage/' . $user->photo1) }}" alt="User Photo 1">
                            <img src="{{ asset('storage/' . $user->photo2) }}" alt="User Photo 2">
                            <img src="{{ asset('storage/' . $user->photo3) }}" alt="User Photo 3">
                            <img src="{{ asset('storage/' . $user->photo4) }}" alt="User Photo 4">
                            <img src="{{ asset('storage/' . $user->photo5) }}" alt="User Photo 5">
                            <img src="{{ asset('storage/' . $user->photo6) }}" alt="User Photo 6">

                        </div>
                        <div class="text-center">
                            <button id="modifyImagesBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#imageModal">Modifier les images</button>
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <!-- Colonne pour les informations de l'utilisateur -->
                        <h2 style="margin-top: 3rem;">Informations Personnelles</h2>


                        <div class="mb-3">
                            <label>
                                <h5>Pseudo:</h5>
                            </label>
                            <span id="userName">{{ $user->pseudo }}</span>
                            <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editPseudo" onclick="editInformation('userName')">Modifier</button>
                            <div class="modal fade" id="editPseudo" tabindex="-1" aria-labelledby="editPseudoLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editPseudoLabel">Modifier l'information</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="post" action="{{ route('update-pseudo', ['id' => $user->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <label for="editField">Nouvelle valeur:</label>
                                                <input type="text" name="pseudo" value="{{ $user->pseudo }}" class="form-control" required required style="font-size: 20px;">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quitter</button>
                                                <button type="submit" class="btn btn-primary" onclick="saveEdit()">Enregistrer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <div class="mb-3">
                            <label>
                                <h5>Tel:</h5>
                            </label>
                            <span id="userPhone">{{ $user->numero }}</span>
                            <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editNumero" onclick="editInformation('userPhone')">Modifier</button>
                            <div class="modal fade" id="editNumero" tabindex="-1" aria-labelledby="editNumeroLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editNumeroLabel">Modifier l'information</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="post" action="{{ route('update-numero', ['id' => $user->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <label for="editField">Nouvelle valeur:</label>
                                                <input type="text" id="editField" name="numero" class="form-control" required style="font-size: 20px;">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quitter</button>
                                                <button type="submit" class="btn btn-primary" onclick="saveEdit()">Enregistrer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label>
                                <h5>Nom:</h5>
                            </label>
                            <span id="userName">{{ $user->name }}</span>
                            <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editName" onclick="editInformation('userName')">Modifier</button>
                            <div class="modal fade" id="editName" tabindex="-1" aria-labelledby="editNameLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editNameLabel">Modifier l'information</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="post" action="{{ route('update-name', ['id' => $user->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <label for="editField">Nouvelle valeur:</label>
                                                <input type="text" name="name" value="{{ $user->name }}" class="form-control" required style="font-size: 20px;">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quitter</button>
                                                <button type="submit" class="btn btn-primary" onclick="saveEdit()">Enregistrer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        </div>
                        
                        </div>
                       
                        </div>

                       
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Modifier les images</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('store-images1') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="modal-body">

                        <div class="image-container">
                            <img src="{{ asset('storage/' . $user->photo1) }}" alt="Image 1" class="image-cropper" data-image-index="1">
                            <label class="btn btn-secondary btn-sm edit-image-btn" data-image-index="1">
                                Choisir une image
                                <input type="file" name="photo1" class="image-input" style="display:none;">
                            </label>
                        </div>
                 
                    </div>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Quitter</button>
                        <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                    <div class="modal-footer">
                       
                    </div>
                </form>
                <form method="POST" action="{{ route('store-images2') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="modal-body">

                        <div class="image-container">
                            <img src="{{ asset('storage/' . $user->photo2) }}" alt="Image 2" class="image-cropper" data-image-index="2">
                            <label class="btn btn-secondary btn-sm edit-image-btn" data-image-index="2">
                                Choisir une image
                                <input type="file" name="photo2" class="image-input" style="display:none;">
                            </label>
                        </div>
                 
                    </div>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Quitter</button>
                        <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                    <div class="modal-footer">
                        
                    </div>
                </form>
                <form method="POST" action="{{ route('store-images3') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="modal-body">

                        <div class="image-container">
                            <img src="{{ asset('storage/' . $user->photo3) }}" alt="Image 3" class="image-cropper" data-image-index="3">
                            <label class="btn btn-secondary btn-sm edit-image-btn" data-image-index="3">
                                Choisir une image
                                <input type="file" name="photo3" class="image-input" style="display:none;">
                            </label>
                        </div>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Quitter</button>
                        <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                    </div>
                    <div class="modal-footer">
                       
                    </div>
                </form>
                <form method="POST" action="{{ route('store-images4') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="modal-body">

                        <div class="image-container">
                            <img src="{{ asset('storage/' . $user->photo4) }}" alt="Image 1" class="image-cropper" data-image-index="4">
                            <label class="btn btn-secondary btn-sm edit-image-btn" data-image-index="4">
                                Choisir une image
                                <input type="file" name="photo4" class="image-input" style="display:none;">
                            </label>
                        </div>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Quitter</button>
                        <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                    </div>
                    <div class="modal-footer">
                       
                    </div>
                </form>
                <form method="POST" action="{{ route('store-images5') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="modal-body">

                        <div class="image-container">
                            <img src="{{ asset('storage/' . $user->photo5) }}" alt="Image 5" class="image-cropper" data-image-index="5">
                            <label class="btn btn-secondary btn-sm edit-image-btn" data-image-index="5">
                                Choisir une image
                                <input type="file" name="photo5" class="image-input" style="display:none;">
                            </label>
                        </div>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Quitter</button>
                        <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </form>


                <form method="POST" action="{{ route('store-images6') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="modal-body">

                        <div class="image-container">
                            <img src="{{ asset('storage/' . $user->photo6) }}" alt="Image 6" class="image-cropper" data-image-index="6">
                            <label class="btn btn-secondary btn-sm edit-image-btn" data-image-index="6">
                                Choisir une image
                                <input type="file" name="photo6" class="image-input" style="display:none;">
                            </label>
                        </div>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Quitter</button>
                        <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </form>
               
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.image-input').change(function() {
                var imageIndex = $(this).closest('.image-container').find('.image-cropper').data('image-index');
                var file = this.files[0];
                if (file) {
                    var imageURL = URL.createObjectURL(file);
                    $(this).closest('.image-container').find('.image-cropper').attr('src', imageURL);
                }
            });
        });

        function uploadNewImages() {
            var formData = new FormData();

            // Ajoutez chaque fichier d'image à formData
            for (var i = 1; i <= 6; i++) {
                var fileInput = $('input[name="photo' + i + '"]')[0];
                var file = fileInput.files[0];
                if (file) {
                    formData.append('photo' + i, file);
                }
            }
            formData.append('user_id', '{{ $user->id }}');
            $.ajax({
                url: '{{ route("store-images1") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    $('#imageModal').modal('hide');
                },
                error: function(error) {
                    console.error(error);
                }
            });
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
        $('#editImageModal').on('show.bs.modal', function(event) {
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
        $('#editImageModal').on('hidden.bs.modal', function() {
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
                reader.onload = function(e) {
                    // Mettre à jour la source de l'image du cropper avec le fichier local
                    $('.image-cropper').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        }
    </script>

    @include('components.footer')
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

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<!-- Vendor JS Files -->
<script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
<script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        $(document).ready(function() {
            $(".edit-icon").click(function() {
                var field = $(this).attr('data-field');
                var currentValue = ""; // Récupérez la valeur actuelle du champ depuis le DOM
                var newValue = prompt("Modifier " + field, currentValue);
                if (newValue !== null) {
                    // Mettez à jour la valeur dans le DOM et enregistrez-la côté serveur
                    alert(field + " mis à jour avec succès: " + newValue);
                }
            });

            $("#photoForm").submit(function(e) {
                e.preventDefault();
                // Gérez le téléchargement des photos ici
                alert("Photos téléchargées avec succès!");
            });
        });
    </script>
    <script>
        var inactivityTimeout = 30 * 60 * 1000;

        var timeout;

        function resetTimer() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
              window.location.href = "{{ route('login') }}";
            }, inactivityTimeout);
        }

        document.addEventListener('mousemove', resetTimer);
        document.addEventListener('keypress', resetTimer);
        document.addEventListener('scroll', resetTimer);

        resetTimer(); // Initialise le minuteur lors du chargement de la page
    </script>
    

</body>

</html>