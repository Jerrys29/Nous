<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Inscription</title>

    <!-- jQuery (Assurez-vous d'inclure jQuery avant le fichier JS Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Bootstrap CSS  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Bootstrap JS (Assurez-vous d'inclure le fichier JS Bootstrap après jQuery) -->
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
                        <h1 style="text-align: center;">Bienvenu dans l’espace Karaoké</h1>
                        <p style="font-size: 22px; margin-top: 12rem;">Le lieu des rencontres les plus fun. Vos données personnelles sont en sécurité avec nous. Votre identité ou pseudo et vos photos seront affichés sur votre profil.</p>
                    </div>
                </div>
                <div class="booking-form">
                    <form action="{{ route('filleinscrip') }}" method="POST" id="booking-form">
                        <!-- Première étape -->
                        @csrf
                        <div class="form-step" id="step-1">
                            <h2>INSCRIVEZ-VOUS MAINTENANT</h2>
                            <div class="form-group form-input">
                                <input type="text" name="name" id="first_name" class="input-text" placeholder="Nom & Prénom" required>
                            </div>
                            @if(session('error'))
                                <div id="alert-message" class="alert alert-success">
                                    {{ error('error') }}
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
                            <h2>Fin Inscription</h2>

                            <div class="form-group form-input">
                                <input type="text" name="pseudo" id="first_name" class="input-text" placeholder="Pseudo" required>
                            </div><br>
        
                            <div class="form-group">
                                <input type="date" name="birthdate" class="birthdate" id="birthdate" placeholder="Date de Naissance" required>
                            </div><br>
                            
                            <div class="form-group">
                                <input type="text" name="birthplace" class="birthplace" id="birthplace" placeholder="Lieu de Naissance" required>
                            </div><br>
                            

                            <!-- <div class="form-group">
                                <select name="origin_country" class="origin_country" id="origin_country" placeholder="Pays d'Origine" required>
                                    <option value="" disabled selected hidden>Pays d'Origine</option>
                                    <option value="Benin">Bénin</option>
                                    <option value="BurkinaFaso">Burkina Faso</option>
                                    <option value="CapeVert">Cap Vert</option>
                                    <option value="Gambia">Gambie</option>
                                    <option value="Ghana">Ghana</option>
                                    <option value="Guinea">Guinée</option>
                                    <option value="GuineaBissau">Guinée-Bissau</option>
                                    <option value="Mali">Mali</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="Senegal">Sénégal</option>
                                    <option value="Togo">Togo</option>
                                </select>
                                <span class="select-btn">
                                    <i class="zmdi zmdi-chevron-down"></i>
                                </span>
                            </div> -->
                            <div class="form-group">
                                <select name="origin_country" class="form-control" id="origin_country" placeholder="Pays d'Origine" class="form-control" required>
                                    <option value="" disabled selected hidden>Pays d'Origine</option>
                                    <option value="Benin">Bénin</option>
                                    <option value="Togo">Togo</option>
                                    <option value="Ivoire">Côte d'Ivoire</option>
                                    <option value="BurkinaFaso">Burkina Faso</option>
                                    <option value="CapeVert">Cap Vert</option>
                                    <option value="Gambia">Gambie</option>
                                    <option value="Ghana">Ghana</option>
                                    <option value="Guinea">Guinée</option>
                                    <option value="GuineaBissau">Guinée-Bissau</option>
                                    <option value="Mali">Mali</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="Senegal">Sénégal</option>

                                </select>
                                <span class="select-btn">
                                    <i class="zmdi zmdi-chevron-down"></i>
                                </span>

                            </div>
                            <div class="form-group" id="error-message-step-2"></div>

                            <div class="form-group onsubmit="showCongratulationsPopup();>
                                <button type="button" class="btn btn-secondary" onclick="prevStep(2)">Précédent</button>
                                
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </div>
    
                        <div class="form-check form-check-info text-left">
                                <input class="form-check-input" type="checkbox" name="agreement" id="flexCheckDefault" checked>
                                <label class="form-check-label" for="flexCheckDefault">
                                    J'accepte <a href="{{('terms')}}:;" class="text-dark font-weight-bolder">les termes et conditions</a>
                                </label>
                                @error('agreement')
                                <p class="text-danger text-xs mt-2">Vous n'avez pas accepté les termes et conditions.</p>
                                @enderror
                            </div>
                    </form>
                    <a href="{{('/connection')}}"> <p class="w-100 text-center">&mdash; ou Se connecter &mdash;</p></a>

                </div>
            </div>
        </div>
    </div>
    

    <!-- Vos scripts personnalisés -->
    <script src="js/main.js"></script>

    <script>
        function nextStep(currentStep, nextStep) {
            $('#step-' + currentStep).hide();
            $('#step-' + nextStep).show();
        }

        function prevStep(step) {
            $('#step-' + step).hide();
            $('#step-' + (step - 1)).show();
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
        return;
    }

    // Cachez tout message d'erreur précédent et procédez à l'enregistrement
    $('#error-message-step-2').text('');  // Utilisez la méthode text ici
    // Continuez avec la logique d'enregistrement ou l'action de formulaire ici
    showCongratulationsPopup();
}
 //Mon code JavaScript pour masquer le message après 15 secondes
 setTimeout(function(){
        document.getElementById('alert-message').style.display = 'none';
    }, 9000);

    </script>

    <script>
        function showCongratulationsPopup() {
            Swal.fire({
                title: 'Félicitations !!',
                text: 'Votre inscription a bien été enregistrée. Votre compte sera activé dans les plus brefs délais.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }
    </script>
</body>
</html>

