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

        .form-label {
            font-weight: bold;
            color: black;
            /* Couleur bleue */
            font-size: 18px;
            /* Taille de police */
        }

        .user-photo {
            width: 200px;
            /* Ajustez la largeur et la hauteur selon vos besoins */
            height: 200px;
            object-fit: cover;
            /* Pour ajuster la taille de l'image tout en conservant son aspect ratio */
            margin-right: 10px;
            /* Espacement entre les images */
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
    @include('components.header')
    <main id="main">
        @if(!$user->photo1)
        <div class="alert alert-warning" role="alert">
            Attention : Veuillez sélectionner une image pour la première photo.
        </div>

        @endif

        <section id="user-profile" class="user-profile">
            <div class="container">
                <h2>{{ $user->name }}</h2>
                <div class="user-images">
                    <div class="row">
                        @if ($user->photo1)
                        <div class="col-lg-3 user-image-col mb-3">
                            <img class="img-fluid" src="{{ asset('storage/' . $user->photo1) }}" alt="Photo 1">
                        </div>
                        @endif

                        @if ($user->photo2)
                        <div class="col-lg-3 user-image-col mb-3">
                            <img class="img-fluid" src="{{ asset('storage/' . $user->photo2) }}" alt="Photo 2">
                        </div>
                        @endif

                        @if ($user->photo3)
                        <div class="col-lg-3 user-image-col mb-3">
                            <img class="img-fluid" src="{{ asset('storage/' . $user->photo3) }}" alt="Photo 3">
                        </div>
                        @endif

                        @if ($user->photo4)
                        <div class="col-lg-3 user-image-col mb-3">
                            <img class="img-fluid" src="{{ asset('storage/' . $user->photo4) }}" alt="Photo 4">
                        </div>
                        @endif

                        @if (!$user->photo1 && !$user->photo2 && !$user->photo3 && !$user->photo4 )
                        <div class="col-lg-12 ">
                            <p style="text-align: center;">Aucune photo disponible pour vous. Veuillez charger vos photos.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <style>
                    .user-images img {
                        width: 200px;
                        /* Largeur fixe de 200 pixels */
                        height: auto;
                        /* Hauteur automatique pour maintenir les proportions */
                        object-fit: cover;
                        /* Pour couvrir la zone de l'image */
                    }

                    .form-control {
                        height: 45px;
                        /* Ajustez cette valeur selon vos besoins */
                        font-size: 108px;
                        /* Ajustez cette valeur selon vos besoins */
                    }
             
                </style>




                <form action="{{ route('profile.photos.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="photo1" class="fw-bold">Changer la photo1</label>
                                <input type="file" class=" form-control" style="font-size: 16px;"  id="photo1" name="photo1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="delete_photo1" name="delete_photo1">
                                    <label class="form-check-label btn btn-danger btn-sm" for="delete_photo1">Supprimer la photo1</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="photo2" class="fw-bold">Changer la photo2</label>
                                <input type="file" class="form-control" style="font-size: 16px;" id="photo2" name="photo2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="delete_photo2" name="delete_photo2">
                                    <label class="form-check-label btn btn-danger btn-sm" for="delete_photo2">Supprimer la photo2</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="photo3" class="fw-bold">Changer la photo3</label>
                                <input type="file" class="form-control" style="font-size: 16px;" id="photo3" name="photo3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="delete_photo3" name="delete_photo3">
                                    <label class="form-check-label btn btn-danger btn-sm" for="delete_photo3">Supprimer la photo3</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="photo4" class="fw-bold">Changer la photo4</label>
                                <input type="file" class="form-control" style="font-size: 16px;"  id="photo4" name="photo4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="delete_photo4" name="delete_photo4">
                                    <label class="form-check-label btn btn-danger btn-sm" for="delete_photo4">Supprimer la photo4</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Ajoutez des blocs similaires pour les autres photos -->

                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <button type="submit" class="get-started-btn scrollto">Valider</button>
                        </div>
                    </div>
                </form>





                <h2 style="margin-top: 3rem;">Informations Personnelles</h2>
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <input type="hidden" name="user_id" value="{{ $user->id }}">

                        <div class="col-lg-6">
                            <div class="mb-3 row align-items-center">
                                <label for="numero" class="col-sm-4 col-form-label fw-bold">Numéro Whatsapp:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" style="font-size: 16px;" id="numero" name="numero" value="{{ $user->numero }}">
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="email" class="col-sm-4 col-form-label fw-bold">Adresse Email:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" style="font-size: 16px;" id="email" name="email" value="{{ $user->email }}">
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="password" class="col-sm-4 col-form-label fw-bold">Mot de passe:</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" style="font-size: 16px;"  id="password" name="password">
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="name" class="col-sm-4 col-form-label fw-bold">Nom:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" style="font-size: 16px;"  id="name" name="name" value="{{ $user->name }}">
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="pseudo" class="col-sm-4 col-form-label fw-bold">Pseudo:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" style="font-size: 16px;"  id="pseudo" name="pseudo" value="{{ $user->pseudo }}">
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="age" class="col-sm-4 col-form-label fw-bold">Âge:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" style="font-size: 16px;" id="age" name="age" value="{{ $user->age }}">
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="genre" class="col-sm-4 col-form-label fw-bold">Genre:</label>
                                <div class="col-sm-8">
                                    <select class="form-select" id="genre" name="genre">
                                        <option value="homme" {{ $user->genre == 'homme' ? 'selected' : '' }}>Homme</option>
                                        <option value="femme" {{ $user->genre == 'femme' ? 'selected' : '' }}>Femme</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="looking_for" class="col-sm-4 col-form-label fw-bold">Genre recherché:</label>
                                <div class="col-sm-8">
                                    <select class="form-select" id="looking_for" name="looking_for">
                                        <option value="homme" {{ $user->looking_for == 'homme' ? 'selected' : '' }}>Homme</option>
                                        <option value="femme" {{ $user->looking_for == 'femme' ? 'selected' : '' }}>Femme</option>
                                        <option value="lesdeux" {{ $user->looking_for == 'lesdeux' ? 'selected' : '' }}>Homme et Femme</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="town" class="col-sm-4 col-form-label fw-bold">Ville:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" style="font-size: 16px;" id="town" name="town" value="{{ $user->town }}">
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="origin_country" class="col-sm-4 col-form-label fw-bold">Pays d'origine:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" style="font-size: 16px;"  id="origin_country" name="origin_country" value="{{ $user->origin_country }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3 row align-items-center">
                                <label for="birthplace" class="col-sm-4 col-form-label fw-bold">Ville de naissance:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" style="font-size: 16px;"  id="birthplace" name="birthplace" value="{{ $user->birthplace }}">
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="mariatal_status" class="col-sm-4 col-form-label fw-bold">Situation Matrimoniale:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" style="font-size: 16px;"  id="mariatal_status" name="mariatal_status" value="{{ $user->mariatal_status }}">
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="hair_color" class="col-sm-4 col-form-label fw-bold">Couleur des cheveux:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" style="font-size: 16px;"  id="hair_color" name="hair_color" value="{{ $user->hair_color }}">
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="eyes_color" class="col-sm-4 col-form-label fw-bold">Couleur des yeux:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" style="font-size: 16px;"  id="eyes_color" name="eyes_color" value="{{ $user->eyes_color }}">
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="about" class="col-sm-4 col-form-label fw-bold">À propos de moi:</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" style="font-size: 16px;"  id="about" name="about" rows="3">{{ $user->about }}</textarea>
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="interests" class="col-sm-4 col-form-label fw-bold">Centres d'intérêt(séparés par des virgules):</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" style="font-size: 16px;"  id="interests" name="interests" value="{{ $user->interests }}">
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <button type="submit" class="get-started-btn scrollto">Valider</button>
                        </div>
                    </div>
                </form>
            </div>

        </section>
    </main>
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

</body>

</html>