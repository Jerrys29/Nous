<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Inscription</title>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/ins.css">

    <!-- Favicons -->
    <link href="assets/img/nous_logo.png" rel="icon">
    <link href="assets/img/nous_logo.png" rel="apple-touch-icon">
    
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body class="kbody">

    <div class="main">
        <div class="container">
            <div class="booking-content">
                <div class="booking-image">
                    <!-- Remplacez l'image par le texte -->
                    <div class="booking-text text-center text-white">
                        <h1 style="text-align: center;font-size:3rem;">Bienvenu dans l’espace Karaoké</h1>
                        <p style="font-size:1.9rem; margin-top: 5rem;">Le lieu des rencontres les plus fun. Vos données personnelles sont en sécurité avec nous. Votre identité ou pseudo et vos photos seront affichés sur votre profil.</p>
                    </div>
                </div>
                <div class="booking-form">
                    <form action="{{ route('filleinscrip') }}" method="POST" id="booking-form" enctype="multipart/form-data">
                        <!-- Première étape -->
                        @csrf
                        
                        <div class="form-step" id="step-1">
                            <h1>INSCRIVEZ-VOUS MAINTENANT</h1>
                            <div id="error-message" class="error-message" style="display: none; color: red;">Vous devez avoir au moins 18 ans pour vous inscrire.</div>

                            <div class="form-group form-input">
                                <input type="text" name="name" id="first_name" class="input-text" placeholder="Nom & Prénom" required>
                            </div>
                            @if(session('error'))
                                <div id="alert-message" class="alert alert-success">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="form-group form-input">
                                <input type="tel" name="numero" id="phone_number" class="input-text" placeholder="Numéro de téléphone whatsapp" required>
                            </div>
                           
                            <div class="form-group form-input">
                                <input type="password" name="password" id="mdp" class="input-text" placeholder="Mot de passe" required>
                            </div>
                
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" onclick="nextStep(1, 2)">Suivant</button>
                            </div>
                        </div>
    
                        <!-- Deuxième étape -->
                        <div class="form-step" id="step-2" style="display: none;">
                            <h1>Fin Inscription</h1>

                            <div class="form-group form-input">
                                <input type="text" name="pseudo" id="first_pseudo" class="input-text" placeholder="Pseudo" required>
                            </div><br>
        
                            <div class="form-group">
                                <input type="date" name="birthdate" class="birthdate" id="birthdate" placeholder="Date de Naissance" required>
                                <div id="birthdate-error" class="error-message" style="display: none; color: red;">Vous devez avoir au moins 18 ans pour vous inscrire.</div>
                            </div><br>
                            
                            <div class="form-group">
                                <input type="text" name="birthplace" class="birthplace" id="birthplace" placeholder="Lieu de Naissance" required>
                            </div><br>

                            <div class="form-group">
                                <input type="text" name="town" class="input-text" id="town" placeholder="Ville" required>
                            </div><br>

                            <!-- Ajout du champ photo de profil -->
                            <div class="form-group">
                                <label for="profile_photo">Photo de profil</label>
                                <input type="file" name="profile_photo" id="profile_photo" class="form-control" accept="image/*" onchange="previewImage(event)">
                                <div class="mt-2">
                                    <img id="photo_preview" src="#" alt="Aperçu de la photo" style="display: none; width: 100%; max-width: 200px;">
                                </div>
                            </div><br>
                           

                            <div class="form-group" id="error-message-step-2"></div>

                            <div class="form-group">
                                <button type="button" class="btn btn-secondary" onclick="prevStep(2)">Précédent</button>
                                
                                <button type="submit" class="btn btn-primary" onclick="return validateAndSubmit()">Enregistrer</button>
                            </div>
                        </div>
    
                    </form>
                    <a href="{{('/connection')}}"> <h4 class="w-100 text-center">&mdash; ou Se connecter &mdash;</h4></a>

                </div>
            </div>
        </div>
    </div>
    

    <!-- Vos scripts personnalisés -->
    <script src="js/main.js"></script>

    <script>
        function nextStep(currentStep, nextStep) {
            if (currentStep === 1 && !validateDateOfBirth()) {
                return;
            }
            $('#step-' + currentStep).hide();
            $('#step-' + nextStep).show();
        }

        function prevStep(step) {
            $('#step-' + step).hide();
            $('#step-' + (step - 1)).show();
        }

        function validateDateOfBirth() {
            var birthdateInput = document.getElementById('birthdate');
            var birthdateError = document.getElementById('birthdate-error');
            
            var birthdate = new Date(birthdateInput.value);
            var today = new Date();
            var age = today.getFullYear() - birthdate.getFullYear();
            var monthDifference = today.getMonth() - birthdate.getMonth();

            if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthdate.getDate())) {
                age--;
            }

            if (age < 18) {
                birthdateError.style.display = 'block';
                return false;
            } else {
                birthdateError.style.display = 'none';
                return true;
            }
        }

        function validateAndSubmit() {
            // Récupérez les champs d'entrée de l'étape 2
            var inputs = $('#step-2 input[required], #step-2 select[required]');

            // Vérifiez si tous les champs sont remplis
            var fieldsAreFilled = true;
            inputs.each(function () {
                if ($(this).val() === '') {
                    fieldsAreFilled = false;
                    // Affichez un message d'erreur pour le champ actuel
                    var fieldName = $(this).attr('placeholder') || $(this).attr('name');
                    $('#error-message-step-2').html('<div class="alert alert-danger">Veuillez remplir tous les champs.</div>');
                    return false; // Sortez de la boucle si un champ est vide
                }
            });

            // Si des champs sont vides, ne continuez pas
            if (!fieldsAreFilled) {
                return false;
            }

            // Vérifiez la date de naissance
            if (!validateDateOfBirth()) {
                return false;
            }

            // Cachez tout message d'erreur précédent et procédez à l'enregistrement
            $('#error-message-step-2').text('');  // Utilisez la méthode text ici
            showCongratulationsPopup();
            return true;
        }

        // function showCongratulationsPopup() {
        //     Swal.fire({
        //         title: 'Félicitations !!',
        //         text: 'Votre inscription a bien été enregistrée. Votre compte sera activé dans les plus brefs délais.',
        //         icon: 'success',
        //         confirmButtonText: 'OK'
        //     });
        // }

        // Masquer le message d'alerte après 15 secondes
        setTimeout(function(){
            document.getElementById('alert-message').style.display = 'none';
        }, 15000);

        // Script pour précharger l'image
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('preload-link').addEventListener('click', function() {
                const imageUrl = 'assets/img/nous_logo.png';
                const preloadImage = new Image();
                preloadImage.src = imageUrl;
            });
        });

        function previewImage(event) {
            var file = event.target.files[0];
            var preview = document.getElementById('photo_preview');
            var fileSizeError = document.getElementById('file-size-error');
            
            if (file) {
                if (file.size > 1.3 * 1024 * 1024) { // 1.3 Mo en octets
                    fileSizeError.style.display = 'block';
                    event.target.value = ''; // Réinitialiser le champ de fichier
                    preview.style.display = 'none';
                    return;
                } else {
                    fileSizeError.style.display = 'none';
                }

                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
                fileSizeError.style.display = 'none';
            }
        }

    </script>

</body>
</html>
