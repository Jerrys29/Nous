<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
                    <form id="booking-form" method="post" action="{{ route('login') }}">
                        @csrf
                        <div class="img-logo">
                            <img class="booking-img" src="assets/img/NOUS.png" alt="Image de nous" style="height: 100px;width: 100px;">

                        </div>
                        <div class="form-step" id="step-1">
                            <h2>Veuillez vous connecter avec les informations entrées à l'inscription!</h2>
                            <div class="form-group form-input">
                                <input type="text" name="numero" id="numero" class="input-text" placeholder="Numéro" required>
                            </div>
                            <div class="form-group form-input">
                                <input type="text" name="password" id="password" class="input-text" placeholder="Mot de passe" required>
                            </div>
                    
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Se connecter</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- jQuery (Assurez-vous d'inclure jQuery avant le fichier JS Bootstrap) -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>