<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Réinitialisation</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }

        .form {
            background-color: #fff;
            display: block;
            padding: 1rem;
            max-width: 350px;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .form-title {
            font-size: 1.25rem;
            line-height: 1.75rem;
            font-weight: 600;
            text-align: center;
            color: #000;
        }

        .input-container {
            position: relative;
        }

        .input-container input, .form button {
            outline: none;
            border: 1px solid #e5e7eb;
            margin: 8px 0;
        }

        .input-container input {
            background-color: #fff;
            padding: 1rem;
            padding-right: 3rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            width: 300px;
            border-radius: 0.5rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .submit {
            display: block;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            padding-left: 1.25rem;
            padding-right: 1.25rem;
            background-color: #4F46E5;
            color: #ffffff;
            font-size: 0.875rem;
            line-height: 1.25rem;
            font-weight: 500;
            width: 100%;
            border-radius: 0.5rem;
            text-transform: uppercase;
            cursor: pointer;
        }

        .submit:hover {
            background-color: #3730a3;
        }

        .signup-link {
            color: #6B7280;
            font-size: 0.875rem;
            line-height: 1.25rem;
            text-align: center;
        }

        .signup-link a {
            text-decoration: underline;
        }

        .alert {
            padding: 10px;
            background-color: #f44336;
            color: white;
            margin-bottom: 15px;
            border-radius: 0.5rem;
            max-width: 90%; /* Ajustement de la largeur maximale */
            text-align: center; /* Centre le texte */
            margin-left: auto; /* Centre horizontalement */
            margin-right: auto; /* Centre horizontalement */
        }

        .success {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            margin-bottom: 15px;
            border-radius: 0.5rem;
        }
        .input-container {
    position: relative;
}

.field-icon {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
}

    </style>
</head>
<body>
    <form class="form" action="{{ route('password.update') }}" method="POST" onsubmit="return validatePasswords()">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        <p class="form-title">Réinitialisation</p>

        <div id="password-error" class="alert" style="display: none;"></div>
        
        @if (session('error'))
            <div class="alert">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        <div class="input-container">
            <input type="password" id="password" name="password" required placeholder="Nouveau mot de passe" style="padding-right: 30px;">
            <span class="fa fa-fw fa-eye field-icon toggle-password" onclick="togglePassword('#password')"></span>
        </div>
        
        <div class="input-container">
            <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Répéter le mot de passe" style="padding-right: 30px;">
            <span class="fa fa-fw fa-eye field-icon toggle-password" onclick="togglePassword('#password_confirmation')"></span>
        </div>
        
        <button type="submit" class="submit">Réinitialiser</button>
    </form>

    <script>
        function togglePassword(inputId) {
            var passwordField = document.querySelector(inputId);
            var eyeIcon = passwordField.nextElementSibling;

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }

        function validatePasswords() {
            var password = document.getElementById('password').value;
            var passwordConfirmation = document.getElementById('password_confirmation').value;
            var passwordError = document.getElementById('password-error');

            if (password.length < 8) {
                passwordError.style.display = 'block';
                passwordError.textContent = 'Le mot de passe doit contenir au moins 8 caractères.';
                return false; // Empêche la soumission du formulaire
            } else if (password !== passwordConfirmation) {
                passwordError.style.display = 'block';
                passwordError.textContent = 'Les mots de passe ne correspondent pas.';
                return false; // Empêche la soumission du formulaire
            } else {
                passwordError.style.display = 'none';
                passwordError.textContent = '';
            }
            return true; // Autorise la soumission du formulaire
        }
    </script>
    <script>
        var inactivityTimeout = 30 * 60 * 1000;

        var timeout;

        function resetTimer() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
              window.location.href = "{{ route('connection') }}";
            }, inactivityTimeout);
        }

        document.addEventListener('mousemove', resetTimer);
        document.addEventListener('keypress', resetTimer);
        document.addEventListener('scroll', resetTimer);

        resetTimer(); // Initialise le minuteur lors du chargement de la page
    </script>
</body>


</html>
