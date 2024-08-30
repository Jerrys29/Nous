<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Inscription</title>

    <!-- Bootstrap CSS  -->
    <link rel="stylesheet" href="chemin-vers-bootstrap-css/bootstrap.min.css">

  <!-- Favicons -->
  <link href="assets/img/nous_logo.png" rel="icon">
  <link href="assets/img/nous_logo.png" rel="apple-touch-icon">

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/ins.css">
</head>
<body>

    <div class="main">
        <div class="container">
            <div class="booking-content">
                <div class="booking-image">
                    <img class="booking-img" src="assets/img/form-img.jpg" alt="Image de réservation" style="height: 100%;">
                </div>
                <div class="booking-form">
                    <form id="booking-form">
                        <!-- Première étape -->
                        <div class="img-logo">
                            <img class="booking-img" src="assets/img/NOUS.png" alt="Image de nous" style="height: 100px;width: 100px;">

                        </div>
                        <div class="form-step" id="step-1">
                            <h2>Inscription - Étape 1</h2>
                            <div class="form-group form-input">
                                <input type="text" name="first_name" id="first_name" class="input-text" placeholder="Nom" required>
                            </div>
                            <div class="form-group form-input">
                                <input type="text" name="last_name" id="last_name" class="input-text" placeholder="Prénom" required>
                            </div>
                            <div class="form-group">
                                <select name="gender" required>
                                    <option value="" disabled selected hidden>Genre</option>
                                    <option value="homme">Homme</option>
                                    <option value="femme">Femme</option>
                                </select>
                                <span class="select-btn">
                                    <i class="zmdi zmdi-chevron-down"></i>
                                </span>
                            </div>
                            <div class="form-group">
                                <select name="eye_color" required>
                                    <option value="" disabled selected hidden>Yeux</option>
                                    <option value="marron">Marron</option>
                                    <option value="noir">Noir</option>
                                    <option value="bleu">Bleu</option>
                                    <option value="vert">Vert</option>
                                </select>
                                <span class="select-btn">
                                    <i class="zmdi zmdi-chevron-down"></i>
                                </span>
                            </div>
                            
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" onclick="nextStep(1, 2)">Suivant</button>
                            </div>
                        </div>

                        <!-- Deuxième étape -->
                        <div class="form-step" id="step-2" style="display: none;">
                            <h2>Inscription - Étape 2</h2>
                            <div class="form-group">
                                <select name="hair_color" required>
                                    <option value="" disabled selected hidden>Cheveux</option>
                                    <option value="noir">Noir</option>
                                    <option value="brun">Brun</option>
                                    <option value="blond">Blond</option>
                                    <option value="roux">Roux</option>
                                </select>
                                <span class="select-btn">
                                    <i class="zmdi zmdi-chevron-down"></i>
                                </span>
                            </div>
                            <div class="form-group">
                                <input type="date" name="birthdate" class="birthdate" id="birthdate" placeholder="Date de Naissance" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="birthplace" class="birthplace" id="birthplace" placeholder="Lieu de Naissance" required>
                            </div>
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
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" onclick="nextStep(2, 3)">Suivant</button>
                                <button type="button" class="btn btn-primary" onclick="prevStep(2)">Précédent</button>
                            </div>
                        </div>

                        <!-- Troisième étape -->
                        <div class="form-step" id="step-3" style="display: none;">
                            <h2>Inscription - Étape 3</h2>
                            <div class="form-group">
                                <input type="text" name="profession" class="profession" id="profession" placeholder="Profession" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="city" class="city" id="city" placeholder="Ville" required>
                            </div>
                            <div class="form-group">
                                <select name="marital_status" required>
                                    <option value="" disabled selected hidden>Situation Matrimoniale</option>
                                    <option value="celibataire">Célibataire</option>
                                    <option value="marie">Marié(e)</option>
                                    <option value="divorce">Divorcé(e)</option>
                                    <option value="celibataireE">Célibataire avec enfants</option>
                                    <option value="marieE">Marié(e) avec enfants</option>
                                    <option value="divorceE">Divorcé(e) avec enfants</option>
                                </select>
                                <span class="select-btn">
                                    <i class="zmdi zmdi-chevron-down"></i>
                                </span>
                            </div>
                            <div class="form-group">
                                <label>Je recherche :</label>
                                <select name="looking_for" required>
                                    <option value=""></option>
                                    <option value="homme">Homme</option>
                                    <option value="femme">Femme</option>
                                </select>
                                <span class="select-btn">
                                    <i class="zmdi zmdi-chevron-down"></i>
                                </span>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" onclick="prevStep(3)">Précédent</button>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Assurez-vous d'inclure le fichier JS Bootstrap dans votre projet) -->
    <script src="chemin-vers-bootstrap-js/bootstrap.min.js"></script>
    <!-- jQuery (Assurez-vous d'inclure jQuery avant le fichier JS Bootstrap) -->
    <script src="vendor/jquery/jquery.min.js"></script>
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
</body>
</html>
<?php /**PATH C:\Users\HP\Documents\nous\resources\views/Nous/register.blade.php ENDPATH**/ ?>