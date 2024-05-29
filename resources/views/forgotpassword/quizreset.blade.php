<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mot de Passe Oublié</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0; /* Optionnel : Ajoute une couleur de fond pour plus de contraste */
        }

        .card {
            position: relative;
            width: 400px; /* Augmenté pour plus de place pour le formulaire */
            height: 250px; /* Augmenté pour plus de place pour le formulaire */
            padding: 20px;
            border-radius: 14px;
            z-index: 1111;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 20px 20px 60px #bebebe, -20px -20px 60px #ffffff;
            background: #fff; /* Assure que le formulaire est lisible */
        }

        .bg {
            position: absolute;
            top: 10px; /* Ajouté pour ajouter une marge en haut */
            left: 10px; /* Ajouté pour ajouter une marge à gauche */
            right: 10px; /* Ajouté pour ajouter une marge à droite */
            bottom: 10px; /* Ajouté pour ajouter une marge en bas */
            z-index: 2;
            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(24px);
            border-radius: 10px;
            overflow: hidden;
            outline: 2px solid white;
        }

        .blob {
            position: absolute;
            z-index: 1;
            top: 50%;
            left: 50%;
            width: 200px; /* Augmenté pour mieux correspondre à la taille de la carte */
            height: 200px; /* Augmenté pour mieux correspondre à la taille de la carte */
            border-radius: 50%;
            background-color: #ff0000;
            opacity: 1;
            filter: blur(12px);
            animation: blob-bounce 5s infinite ease;
        }

        @keyframes blob-bounce {
            0% {
                transform: translate(-100%, -100%) translate3d(0, 0, 0);
            }
            25% {
                transform: translate(-100%, -100%) translate3d(100%, 0, 0);
            }
            50% {
                transform: translate(-100%, -100%) translate3d(100%, 100%, 0);
            }
            75% {
                transform: translate(-100%, -100%) translate3d(0, 100%, 0);
            }
            100% {
                transform: translate(-100%, -100%) translate3d(0, 0, 0);
            }
        }

        form {
            display: flex;
            flex-direction: column;
            z-index: 3; /* Assure que le formulaire est au-dessus du background et du blob */
            width: 100%;
        }

        label {
            margin-bottom: 10px;
        }

        input {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: calc(100% - 20px);
        }

        button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
    <div class="card">
        <div class="bg"></div>
        <div class="blob"></div>
        @if (session('error'))
        <div class="alert">
            {{ session('error') }}
        </div>
    @endif
        <form action="{{route('verify.information')}}" method="POST">
            @csrf
            <label for="fullname">Assurez-vous de fournir les informations</label>
            <input type="hidden" name="numero" value="{{ $numero }}">

            <input type="text" id="name" name="name" required placeholder="Votre Nom complet d'inscription">
            <input type="text" id="pseudo" name="pseudo" required placeholder="Pseudo">
            <button type="submit">Soumettre</button>
        </form>
    </div>
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
