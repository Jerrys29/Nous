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
                    <form id="booking-form">
                        <!-- Première étape -->
                       
                        <div class="form-step" id="step-1">
                            <h2>INSCRIVEZ-VOUS MAINTENANT</h2>
                            <div class="form-group form-input">
                                <input type="text" name="name" id="first_name" class="input-text" placeholder="Nom & Prénom" required>
                            </div>
                            
    
                            <div class="form-group form-input">
                                <input type="tel" name="phone_number" id="phone_number" class="input-text" placeholder="Numéro de téléphone" required>
                            </div>

                            <div class="form-group form-input">
                            <input type="password" name="mdp" id="mdp" class="input-text" placeholder="Mot de passe" required>
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
                            

                            <div class="form-group">
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
                            </div>
                            <div class="form-group onsubmit="showCongratulationsPopup();>
                                <button type="button" class="btn btn-secondary" onclick="prevStep(2)">Précédent</button>
                                
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </div>
    
                    
                    </form>
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

