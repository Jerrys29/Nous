<!doctype html>
<html lang="en">
  <head>
  	<title>Connection</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
    <link rel="stylesheet" href="assets/css/login.css">


	</head>
	<body class="img js-fullheight" >


	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">KARAOKE</h2>
				</div>
			</div>
			

			<div class="row justify-content-center">
			
				<div class="col-md-6 col-lg-4">
				@if(session('success'))
				<div id="alert-message" class="alert alert-success">
					{{ session('success') }}
				</div>
			@endif
					<div class="login-wrap p-0">
		      	
		      	<form method="POST"  action="{{route('logins') }}" class="signin-form">
				  @csrf
					<!-- Display error messages -->
					@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
						@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
						</ul>
					</div>
					@endif
					@if(session('error'))
						<div class="alert alert-danger">
							{{ session('error') }}
						</div>
					@endif

				  <div class="form-group">
							<input type="tel" name="numero" class="form-control" placeholder="Numéro de téléphone" required>
				 </div>
				 <div class="form-group">
					<input id="password-field" type="password" name="password" class="form-control" placeholder="Mot de passe" required>
					<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password" onclick="togglePassword()"></span>
				</div>

	            <div class="form-group">
	            	<button type="submit" class="form-control btn btn-primary submit px-3">Se connecter</button>
	            </div>
	            <div class="form-group d-md-flex">
	            	<div class="w-50">
		            	<label class="checkbox-wrap checkbox-primary">Se souvenir
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
									</label>
								</div>
								<div class="w-100 text-md-right">
									<a href="{{ route('password.request') }}"> <p class="w-100 "> Mot de passe oublié? </p></a>

								</div>
	            </div>
	          </form>
	         <a href="{{('/inscription')}}" id="preload-link"> <p class="w-100 text-center">&mdash; ou S'inscrire &mdash;</p></a>
	          
		      </div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  
  <script>

function togglePassword() {
    var passwordField = document.getElementById("password-field");
    var eyeIcon = document.querySelector(".toggle-password");

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

    //Mon code JavaScript pour masquer le message après 15 secondes
    setTimeout(function(){
        document.getElementById('alert-message').style.display = 'none';
    }, 9000);
	</script>
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

	</body>
</html>
