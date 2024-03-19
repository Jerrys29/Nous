@extends('templates.app')

@section('document')
<!-- ======= Hero Section ======= -->

<div class="container" id="ok">
  <div class="row">
    <div class="col-12" style="margin-top: -4rem; margin-bottom:3rem;">
      <div class="scrolling-flags-container" onmouseover="stopAnimation()" onmouseout="startAnimation()" style="margin-top: 4rem; margin-bottom: -2rem;">
        @for ($i = 1; $i <= 56; $i++) <img src="{{ asset('assets/img/drap/' . $i . '.png') }}" alt="Drapeau {{ $i }}" class="flag-image">
          @endfor
      </div>
    </div>
  </div>
</div>

<style>
  .modal-backdrop {
    backdrop-filter: blur(5px);
    /* Utilisez backdrop-filter pour appliquer un effet de flou */
  }

  .scrolling-flags-container {
    flex-wrap: nowrap;
    display: flex;
    justify-content: center;
    margin-top: 2rem;
    animation: scroll 30s linear infinite;
    /* Réduire la durée de l'animation */
  }

  .flag-image {
    width: 5%;
    /* Utilisation d'un pourcentage pour la taille des drapeaux */
    height: auto;
    margin: 5px;
    /* Ajoutez de la marge entre les images */
  }

  @media screen and (max-width: 768px) {
    .flag-image {
      width: 10%;
      /* Réduisez la taille des images pour les écrans plus petits */
    }
  }

  @keyframes scroll {
    0% {
      transform: translateX(0);
    }

    100% {
      transform: translateX(calc(-50px * 28));
      /* Réduire le nombre de drapeaux à défiler */
    }
  }

  #ok {
    padding-top: 60px 0;
    overflow: hidden;
    position: relative;
  }
</style>
<section id="hero" class="d-flex align-items-center">
  <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="{{ asset('assets/slides/1.jpg') }}" class="d-block w-100" alt="...">
        <div class="carousel-caption" >
          <h1>Meilleur site de rencontres au Bénin et dans la sous-région. </h1>
          <h2>Faites une expérience exceptionnelle, rencontrez les meilleures personnes et vivez pleinement vos rencontres.</h2>
          <a href="{{('/profils')}}" class="btn-get-started scrollto">Trouvez votre partenaire</a>
        </div>
      </div>
      <div class="carousel-item">
        <img src="{{ asset('assets/slides/2.jpg') }}" class="d-block w-100" alt="...">
        <div class="carousel-caption">
          <h1>Meilleur site de rencontres au Bénin et dans la sous-région. </h1>
          <h2>Faites une expérience exceptionnelle, rencontrez les meilleures personnes et vivez pleinement vos rencontres.</h2>
          <a href="{{('/profils')}}" class="btn-get-started scrollto">Trouvez votre partenaire</a>
        </div>

      </div>
      <div class="carousel-item">
        <img src="{{ asset('assets/slides/4.jpg') }}" class="d-block w-100" alt="...">
        <div class="carousel-caption">
          <h1>Meilleur site de rencontres au Bénin et dans la sous-région. </h1>
          <h2>Faites une expérience exceptionnelle, rencontrez les meilleures personnes et vivez pleinement vos rencontres.</h2>
          <a href="{{('/profils')}}" class="btn-get-started scrollto">Trouvez votre partenaire</a>
        </div>

      </div>
      <div class="carousel-item">
        <img src="{{ asset('assets/slides/5.jpg') }}" class="d-block w-100" alt="...">
        <div class="carousel-caption">
          <h1>Meilleur site de rencontres au Bénin et dans la sous-région. </h1>
          <h2>Faites une expérience exceptionnelle, rencontrez les meilleures personnes et vivez pleinement vos rencontres.</h2>
          <a href="{{('/profils')}}" class="btn-get-started scrollto">Trouvez votre partenaire</a>
        </div>

      </div>
      <div class="carousel-item">
        <img src="{{ asset('assets/slides/6.jpg') }}" class="d-block w-100" alt="...">
        <div class="carousel-caption">
          <h1>Meilleur site de rencontres au Bénin et dans la sous-région. </h1>
          <h2>Faites une expérience exceptionnelle, rencontrez les meilleures personnes et vivez pleinement vos rencontres.</h2>
          <a href="{{('/profils')}}" class="btn-get-started scrollto">Trouvez votre partenaire</a>
        </div>

      </div>
      <div class="carousel-item">
        <img src="{{ asset('assets/slides/7.jpg') }}" class="d-block w-100" alt="...">
        <div class="carousel-caption">
          <h1>Meilleur site de rencontres au Bénin et dans la sous-région. </h1>
          <h2>Faites une expérience exceptionnelle, rencontrez les meilleures personnes et vivez pleinement vos rencontres.</h2>
          <a href="{{('/profils')}}" class="btn-get-started scrollto">Trouvez votre partenaire</a>
        </div>

      </div>
      <div class="carousel-item">
        <img src="{{ asset('assets/slides/8.jpg') }}" class="d-block w-100" alt="...">
        <div class="carousel-caption">
          <h1>Meilleur site de rencontres au Bénin et dans la sous-région. </h1>
          <h2>Faites une expérience exceptionnelle, rencontrez les meilleures personnes et vivez pleinement vos rencontres.</h2>
          <a href="{{('/profils')}}" class="btn-get-started scrollto">Trouvez votre partenaire</a>
        </div>

      </div>
      <!-- Ajoutez les autres éléments de diapositives si nécessaire -->
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Précédent</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Suivant</span>
    </button>
  </div>
</section><!-- End Hero -->


<!-- Ajoutez Swiper.js -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- Initialisez Swiper.js -->
<script>
  var swiper = new Swiper('.swiper-container', {
    effect: 'fade',
    autoplay: {
      delay: 5000, // 5 secondes entre chaque diapositive
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });
</script>


<main id="main">

  <!-- ======= About Section ======= -->
  <section id="about" class="about ">
    <div class="container" data-aos="fade-up">

      <div class="row no-gutters">
        <div class="content col-xl-4 d-flex align-items-stretch">
          <div class="content">
            <h3>Pourquoi choisir<img src="assets/img/nous_logo.png" alt="" style="max-height: 40px;">?</h3>
            <p>
              Nous vous fournissons une meilleure expérience de rencontre, vous avez la possibilité de rencontrer de nombreuses personnes de plus de 20 pays plus proches de vous que jamais. </p>
          </div>
        </div>
        <div class="content col-xl-4 d-flex align-items-stretch">
          <div class="content">
            <h3>Rencontrez des personnes au Bénin et en Afrique et au-delà.</h3>
            <p>
              Nous insistons sur la vérification des identités de nos utilisateurs, nous vérifions également toutes les informations liées à une inscription avant de vous la proposer. Notre but est de vous aider à trouver votre compagne en toute discrétion et ceci sans risque. Nous travaillons à réunir le plus de personnes pour une expérience folle jamais vue auparavant. </p>
          </div>
        </div>
        <div class="content col-xl-4 d-flex align-items-stretch">
          <div class="content">
            <h3>Débutez votre histoire sur <img src="assets/img/nous_logo.png" alt="" style="max-height: 40px;"></h3>
            <p>
              Abonnez-vous et faites les meilleures rencontres de votre vie. Vous cherchez votre âme sœur ? ?? Nous avons le partenaire idéal pour vous !!! </p>
          </div>
        </div>
      </div>

    </div>
  </section><!-- End About Section -->


  <!-- Modal pour afficher les détails des publicités -->
  <div id="advertisementModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document"> <!-- Ajout de la classe modal-sm -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Publicités</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="3000">
            <!-- <ol class="carousel-indicators">
            @foreach($publicites as $index => $publicite)
            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
            @endforeach
          </ol> -->
            <div class="carousel-inner">
              @foreach($publicites as $index => $publicite)
              <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <!-- Ligne pour l'image -->
                <div class="row">
                  <div class="col text-center">
                    <img class="d-block w-100" src="{{ asset('logos/' . $publicite->logo) }}" alt="{{ $publicite->name }}">
                  </div>
                </div>
                <!-- Ligne pour le texte et le bouton -->
                <div class="row">
                  <div class="col text-center">
                    <h5> <strong>{{ $publicite->name }}</strong></h5>
                    <p>{{ $publicite->offre }}</p>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#advertisementDetailModal{{ $index }}">Détail</button>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Second modal pour afficher les détails de la publicité -->
  @foreach($publicites as $index => $publicite)
  <div class="modal fade" id="advertisementDetailModal{{ $index }}" tabindex="-1" role="dialog" aria-labelledby="advertisementDetailModal{{ $index }}Label" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document"> <!-- Ajout de la classe modal-sm -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="advertisementDetailModal{{ $index }}Label">Détails de la publicité</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="row">
          <div class="col text-center">
            <img class="d-block w-100" src="{{ asset('logos/' . $publicite->logo) }}" alt="{{ $publicite->name }}">
          </div>
        </div>
        <div class="modal-body">
          <h5> <strong>{{ $publicite->name }}</strong></h5>
          <h5>{{ $publicite->offre }}</h5>
          <p style="font-size:large;">{{ $publicite->detail }}</p>
        </div>
      </div>
    </div>
  </div>
  @endforeach


  <button id="toggleChat" class="btn btn-danger" style="margin-bottom: 40px;margin-top: 40px;">Discuter</button>
  <script>
    // Script pour afficher/masquer la section chatbox
    $(document).ready(function() {
      $('#toggleChat').click(function() {
        $('.chatbox').toggle();
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      // Soumettre le formulaire de bienvenue
      $('#welcome-form').submit(function(event) {
        event.preventDefault(); // Empêcher le formulaire de se soumettre normalement

        var name = $('#name').val(); // Récupérer le nom
        var numero = $('#numero').val(); // Récupérer le numéro de téléphone

        // Afficher le formulaire de chat après avoir fourni le nom et le numéro
        $('#chat-form').show();
        $('#chat-window').append('<div class="message">Bienvenue, ' + name + ' ! Vous pouvez désormais commencer à discuter.</div>');

        // Masquer le formulaire de bienvenue
        $('#welcome-form').hide();
      });

      $('#chat-form').submit(function(event) {
        event.preventDefault(); // Empêcher le formulaire de se soumettre normalement

        var message = $('#message').val(); // Récupérer le message

        $.ajax({
          type: 'POST',
          url: '{{ route("discussion.store") }}',
          data: {
            _token: '{{ csrf_token() }}',
            message: message,
            name: $('#name').val(), // Récupérer le nom
            numero: $('#numero').val() // Récupérer le numéro de téléphone
          },
          success: function(response) {
            // Mettre à jour la fenêtre de chat avec le message envoyé
            var chatMessage = '<div class="d-flex flex-row p-3">' +
              '<div class="bg-white mr-2 p-3"><span class="text-muted">' + response.message + '</span></div>' +
              '<img src="https://img.icons8.com/color/48/000000/circled-user-male-skin-type-7.png" width="30" height="30">' +
              '</div>';
            $('#chat-window').append(chatMessage);

            // Effacer le champ de saisie après l'envoi du message
            $('#message').val('');
          }
        });
      });
    });

    var animation; // Variable pour stocker l'animation

    function stopAnimation() {
      var flagsContainer = document.querySelector('.scrolling-flags-container');
      animation = flagsContainer.style.animation; // Sauvegarde l'animation actuelle
      flagsContainer.style.animation = 'none'; // Arrête l'animation
    }

    function startAnimation() {
      var flagsContainer = document.querySelector('.scrolling-flags-container');
      flagsContainer.style.animation = animation; // Redémarre l'animation
    }
  </script>

  <section class="chatbox">
    <div class="container d-flex justify-content-center">
      <div class="card mt-5">
        <div class="d-flex flex-row justify-content-between p-3 adiv text-white">
          <i class="fas fa-chevron-left"></i>
          <span class="pb-3">Nous vous répondrons dans quelques instants...</span>
          <i class="fas fa-times"></i>
        </div>
        <section class="chat-window" id="chat-window">
          <!-- Messages -->
          <div class="message">Bienvenue ! Veuillez fournir votre nom et numéro de téléphone.</div>
        </section>
        <form class="chat-input" id="welcome-form">
          <input type="text" class="form-control" name="name" id="name" placeholder="Votre nom" required>
          <input type="tel" class="form-control" name="numero" id="numero" placeholder="Votre numéro de téléphone" required>
          <button type="submit" class="btn btn-sm btn-danger">Envoyer</button>
        </form>
        <div class="d-flex flex-row p-3">
          <img src="https://img.icons8.com/color/48/000000/circled-user-female-skin-type-7.png" width="30" height="30">
          <div class="chat ml-2 p-3">Hello and thankyou for visiting birdlymind. Please click the video above</div>
        </div>
        <div class="d-flex flex-row p-3">
          <div class="bg-white mr-2 p-3"><span class="text-muted">Hello and thankyou for visiting birdlynind.</span></div>
          <img src="https://img.icons8.com/color/48/000000/circled-user-male-skin-type-7.png" width="30" height="30">
        </div>
        <form class="chat-input" id="chat-form" style="display: none;">
          <div class="form-group px-3">
            <textarea class="form-control" rows="5" placeholder="Type your message" id="message" required></textarea>
            <button type="submit" class="btn btn-primary">Envoyer</button>
          </div>
        </form>
      </div>
    </div>
  </section>
  <style>
    .card {
      width: 300px;
      border: none;
      border-radius: 15px;
    }

    .adiv {
      background: #04CB28;
      border-radius: 15px;
      border-bottom-right-radius: 0;
      border-bottom-left-radius: 0;
      font-size: 12px;
      height: 46px;
    }

    .chat {
      border: none;
      background: #E2FFE8;
      font-size: 10px;
      border-radius: 20px;
    }

    .bg-white {
      border: 1px solid #E7E7E9;
      font-size: 10px;
      border-radius: 20px;
    }

    .myvideo img {
      border-radius: 20px
    }

    .dot {
      font-weight: bold;
    }

    .form-control {
      border-radius: 12px;
      border: 1px solid #F0F0F0;
      font-size: 8px;
    }

    .form-control:focus {
      box-shadow: none;
    }

    .form-control::placeholder {
      font-size: 8px;
      color: #C4C4C4;
    }
  </style>
  <!-- <script>
    $('.chat-input input').keyup(function(e) {
      if ($(this).val() == '')
        $(this).removeAttr('good');
      else
        $(this).attr('good', '');
    });

    window.Echo.channel('chat')
      .listen('ChatMessageEvent', (event) => {
        // Mettez à jour la fenêtre de chat avec le nouveau message
        console.log('Nouveau message:', event.message);
      });
  </script> -->
</main><!-- End #main -->

<script>
  // Afficher le modal au chargement de la page
  $(document).ready(function() {
    $('#advertisementModal').modal('show');
  });
  // Fonction pour précharger une image en arrière-plan
  function preloadImage(url) {
    var img = new Image();
    img.src = url;
  }

  // Précharger les images suivantes dans le carrousel
  $('.carousel').on('slide.bs.carousel', function() {
    var nextSlide = $(this).find('.carousel-item.active').next('.carousel-item');
    if (nextSlide.length > 0) {
      var imgUrl = nextSlide.find('img').attr('src');
      preloadImage(imgUrl);
    }
  });
</script>
@endsection