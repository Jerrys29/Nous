<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photos</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 80vh;
            margin-top: 0;
            padding-top: 50px;
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.2rem;
            color: #333;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            max-width: 1000px;
        }

        .card {
            width: 250px;
            height: 200px;
            border: 2px solid #ddd;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
            text-align: center;
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .card .image {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
            display: none;
        }

        .card .default-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .card .default-icon svg {
            width: 50px;
            height: 50px;
            color: #007bff;
        }

        .card button {
            width: auto;
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            margin-top: 10px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .card button:hover {
            background-color: #0056b3;
        }

        .submit-container {
            text-align: center;
            margin-top: 10px;
        }

        #submit-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        #submit-button:disabled {
            background-color: #ddd;
            cursor: not-allowed;
        }

        #submit-button:hover:not(:disabled) {
            background-color: #0056b3;
        }

        @media (min-width: 768px) {
            .card {
                flex: 1 0 30%;
                max-width: 30%;
            }
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 500;
            text-align: center;
            position: relative;
            width: 100%;
            max-width: 600px;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">
            <h3>Vos photos seront affichées sur votre profil</h3>
        </div>
        <div class="col-md-6 col-lg-4">
            @if(session('success'))
                <div id="alert-message" class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('storePhotos') }}" method="POST" enctype="multipart/form-data" id="photo-upload-form">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="card-container">
                    @foreach(range(1, 2) as $i)
                        <div class="card">
                            <div class="image">
                                <img id="preview{{ $i }}" src="{{ asset('images/default-placeholder.png') }}" alt="Preview">
                                <div class="default-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 15v-6m-3 3h6m-7 8h14V4H5v14z"></path></svg>
                                </div>
                            </div>
                            <input type="file" id="photo{{ $i }}" name="photo{{ $i }}" class="file-input" data-preview-id="preview{{ $i }}" style="display: none;" />
                            <button type="button" class="upload-btn">Ajoutez une photo</button>
                        </div>
                    @endforeach
                </div>
                <div class="submit-container">
                    <button type="submit" id="submit-button" class="btn btn-primary" disabled>Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInputs = document.querySelectorAll('.file-input');
            const submitButton = document.getElementById('submit-button');
            const maxFileSize = 1.2 * 1024 * 1024; // 1.2 Mo en octets

            function updatePreview(input, previewId) {
                const file = input.files[0];
                if (file) {
                    if (file.size > maxFileSize) {
                        alert('La taille du fichier dépasse 1.2 Mo. Veuillez choisir un fichier plus petit.');
                        input.value = ''; // Clear the input
                        const img = document.getElementById(previewId);
                        img.src = '{{ asset('images/default-placeholder.png') }}';
                        img.style.display = 'none'; // Hide the image
                        img.nextElementSibling.style.display = 'flex'; // Show the icon
                        checkPhotoInputs();
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const img = document.getElementById(previewId);
                        img.src = e.target.result;
                        img.style.display = 'block'; // Affiche l'image
                        img.nextElementSibling.style.display = 'none'; // Cache l'icône
                    };
                    reader.readAsDataURL(file);
                }
            }

            function checkPhotoInputs() {
                let filledPhotoCount = 0;
                fileInputs.forEach(input => {
                    if (input.files.length > 0) {
                        filledPhotoCount++;
                    }
                });

                submitButton.disabled = filledPhotoCount < 1;
            }

            fileInputs.forEach(input => {
                const previewId = input.getAttribute('data-preview-id');
                input.addEventListener('change', () => {
                    updatePreview(input, previewId);
                    checkPhotoInputs();
                });
            });

            document.querySelectorAll('.upload-btn').forEach(button => {
                button.addEventListener('click', function() {
                    this.previousElementSibling.click();
                });
            });

            const alertMessage = document.getElementById('alert-message');
            if (alertMessage) {
                setTimeout(function(){
                    alertMessage.style.display = 'none';
                }, 9000);
            }

            checkPhotoInputs();
        });
    </script>
</body>
</html>
