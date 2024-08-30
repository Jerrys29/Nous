<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="<?php echo e(asset('assets/img/nous_logo.png')); ?>" rel="icon">
    <link href="<?php echo e(asset('assets/img/nous_logo.png')); ?>" rel="apple-touch-icon">

    <!-- Bootstrap CSS -->
    <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">

    <!-- Font Icon -->
    <link rel="stylesheet" href="<?php echo e(asset('fonts/material-icon/css/material-design-iconic-font.min.css')); ?>">

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/inscription.css')); ?>">

</head>

<body>
    <style>
.birthdate::-webkit-calendar-picker-indicator {
    filter: invert(100%);
}

    </style>
    <!-- Affichage du message d'erreur global -->
    <?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <?php echo e($errors->first()); ?>

    </div>
    <?php endif; ?>

    <div class="main">
        <div class="container">
            <div class="booking-content">
                <div class="booking-image">
                    <img class="booking-img" src="<?php echo e(asset('assets/img/Accueil.jpg')); ?>" alt="Image de réservation" style="height: 100%;">
                </div>
                <div class="booking-form">
                    <form id="booking-form" method="post" action="<?php echo e(route('inscription.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <a href="<?php echo e(('/')); ?>"><div class="img-logo">
                            <img class="booking-img" src="assets/img/NOUS.png" alt="Image de nous" style="height: 100px;width: 100px;">

                        </div></a>
                        
                        <div class="form-step" id="step-1">
                            <h2>Inscription - Étape 1</h2>
                            <div class="form-group form-input">
                                <input type="text" name="name" id="name" class="input-text" placeholder="Nom Complet" required>
                            </div>
                            <label for="email">Email :(Facultatif)</label>
                            <input type="email" id="email" name="email" optional>

                            <div class="form-group form-input">
                                <input type="text" name="pseudo" id="pseudo" class="input-text" placeholder="Pseudo" required>
                            </div>

                            <div class="form-group">
                                <div class="form-group">
                                    <label for="genre">Genre</label>
                                    <select name="genre" id="genre" class="form-control" required>
                                        <option value="" disabled selected hidden>Quel est votre genre?</option>
                                        <option value="homme">Homme</option>
                                        <option value="femme">Femme</option>

                                    </select>
                                </div>
                                <span class="select-btn">
                                    <i class="zmdi zmdi-chevron-down"></i>
                                </span>
                            </div>
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="yeux">Couleur des yeux</label>
                                    <select name="eyes_color" id="eyes_color" class="form-control" required>
                                        <option value="" disabled selected hidden>Choisissez une couleur</option>
                                        <option value="marron">Marron</option>
                                        <option value="noir">Noir</option>
                                        <option value="bleu">Bleu</option>
                                        <option value="vert">Vert</option>
                                    </select>
                                </div>

                                <span class="select-btn">
                                    <i class="zmdi zmdi-chevron-down"></i>
                                </span>
                            </div>
                            <p>Vous avez déjà compte ? <a href="<?php echo e(route('login')); ?>" style="color: white;">Connectez-vous ici</a>.</p>

                            <div class="form-group">
                                <button type="button" class="btn btn-primary" onclick="nextStep(1, 2)">Suivant</button>
                            </div>
                        </div>

                        <!-- Deuxième étape -->
                        <div class="form-step" id="step-2" style="display: none;">
                            <h2>Inscription - Étape 2</h2>
                            <div class="form-group">
                                <select name="hair_color" class="form-control" required>
                                    <option value="" disabled selected hidden>Cheveux</option>
                                    <option value="noir">Noirs</option>
                                    <option value="brun">Bruns</option>
                                    <option value="blond">Blonds</option>
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
                                <input type="text" name="origin_country" class="origin_country" id="origin_country" placeholder="Pays de Naissance" required>
                            </div>
                            <div class="form-group">
            
                                <span class="select-btn">
                                    <i class="zmdi zmdi-chevron-down"></i>
                                </span>
                                <p>Vous avez déjà compte ? <a href="<?php echo e(route('login')); ?>" style="color: white;">Connectez-vous ici</a>.</p>

                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" onclick="prevStep(2)">Précédent</button>
                                <button type="button" class="btn btn-primary" onclick="nextStep(2, 3)">Suivant</button>
                            </div>
                        </div>

                        <!-- Troisième étape -->
                        <div class="form-step" id="step-3" style="display: none;">
                            <h2>Inscription - Étape 3</h2>
                            <div class="form-group">
                                <input type="text" name="profession" class="profession" id="profession" placeholder="Profession" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="town" class="town" id="town" placeholder="Ville" required>
                            </div>
                            <div class="form-group">
                                <select name="mariatal_status" id="mariatal_status" placeholder="Marital Status" class="form-control" required>
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
                                <div class="form-group">
                                    <label for="yeux">Je recherche</label>
                                    <select name="looking_for" id="looking_for" class="form-control" required>
                                        <option value="" disabled selected hidden>Que recherchez-vous?</option>
                                        <option value="homme">Homme</option>
                                        <option value="femme">Femme</option>
                                        <option value="lesdeux">Femme et Homme</option>
                                        <option value="Amitie">Amitié</option>

                                    </select>
                                </div>
                                <span class="select-btn">
                                    <i class="zmdi zmdi-chevron-down"></i>
                                </span>
                            </div>
                            <div class="form-group">
                                <input type="text" name="numero" class="numero" id="numero" placeholder="Votre numéro" required>
                                <?php $__errorArgs = ['numero'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-danger text-xs mt-2"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group password-container">
                                <input type="password" name="password" class="password" id="password" placeholder="Mot de passe" required>
                                <span toggle="#password" class="eye-toggle">
                                    <i class="fa fa-eye toggle-icon" aria-hidden="true"></i>
                                </span>
                            </div>

                            <div class="form-check form-check-info text-left">
                                <input class="form-check-input" type="checkbox" name="agreement" id="flexCheckDefault" checked>
                                <label class="form-check-label" for="flexCheckDefault">
                                    J'accepte <a href="<?php echo e(('terms')); ?>" class="text-white text-light font-weight-bolder">les termes et conditions</a>
                                </label>
                                <?php $__errorArgs = ['agreement'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-danger text-xs mt-2">Vous n'avez pas accepté les termes et conditions.</p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <p>Vous avez déjà compte ? <a href="<?php echo e(route('login')); ?>" style="color: white;">Connectez-vous ici</a>.</p>

                            <div class="form-group">
                                <button type="button" class="btn btn-primary" onclick="prevStep(3)">Précédent</button>
                                <button type="submit" class="btn btn-primary">S'inscrire</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="<?php echo e(asset('vendor/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/main.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            $(".eye-toggle").click(function() {
                var input = $($(this).attr("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                    $(this).find(".toggle-icon").removeClass("fa-eye").addClass("fa-eye-slash");
                } else {
                    input.attr("type", "password");
                    $(this).find(".toggle-icon").removeClass("fa-eye-slash").addClass("fa-eye");
                }
            });
        });
    </script>

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

</html><?php /**PATH C:\Users\HP\Documents\Abitech2024\Nous\resources\views/Nous/register.blade.php ENDPATH**/ ?>