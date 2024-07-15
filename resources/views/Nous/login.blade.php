<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Favicons -->
    <link href="assets/img/nous_logo.png" rel="icon">
    <link href="assets/img/nous_logo.png" rel="apple-touch-icon">

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/inscription.css') }}">
</head>

<body>
    <style>
        .birthdate::-webkit-calendar-picker-indicator {
            filter: invert(100%);
        }
        .eye-toggle .toggle-icon {
    color: #000; /* Couleur de l'icône par défaut */
}

.eye-toggle.active .toggle-icon {
    color: red; /* Couleur de l'icône lorsque le mot de passe est affiché */
}

    </style>
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="main">
        <div class="container">
            <div class="booking-content">
                <div class="booking-image">
                    <img class="booking-img" src="{{ asset('assets/slides/5.jpg') }}" alt="Image de réservation" style="height: 100%;">
                </div>
                <div class="booking-form">
                    <form id="booking-form" method="post" action="{{ route('login') }}">
                        @csrf
                        <a href="{{('/')}}">
                            <div class="img-logo">
                                <img class="booking-img" src="assets/img/NOUS.png" alt="Image de nous" style="height: 100px;width: 100px;">

                            </div>
                        </a>
                        <div class="form-step" id="step-1">
                            <h2>Veuillez vous connecter avec les informations entrées à l'inscription!</h2>
                            <div class="form-group form-input">
                                <input type="text" name="numero" id="numero" class="input-text" placeholder="Numéro" required>
                            </div>
                            <div class="form-group password-container">
    <input type="password" name="password" class="password" id="password" placeholder="Mot de passe" required>
    <span toggle="#password" class="eye-toggle">
        <i class="fa fa-eye toggle-icon" aria-hidden="true"></i>
    </span>
</div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Se connecter</button>
                            </div>
                            @if(session('error') || !auth()->check())
                            <p>Vous n'avez pas de compte ? <a href="{{ route('inscription.store') }}" style="color: white;">Inscrivez-vous ici</a>.</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
 document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.querySelector('.eye-toggle');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        // Changer la couleur de l'icône
        this.classList.toggle('active');
    });
});


    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- jQuery (Assurez-vous d'inclure jQuery avant le fichier JS Bootstrap) -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>