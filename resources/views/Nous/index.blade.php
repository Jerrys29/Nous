@extends('templates.app')

@section('document')
<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">
  <!-- ======= Header ======= -->

  <div class="container" data-aos="zoom-out" data-aos-delay="100">
    <div class="row">
      <div class="col-xl-6">
        <h1>Meilleur site de rencontres au Bénin et dans la sous-région. </h1>
        <h2>Faites une expérience exceptionnelle, rencontrez les meilleures personnes et vivez pleinement vos rencontres.</h2>
        <a href="{{('/profils')}}" class="btn-get-started scrollto">Trouvez votre partenaire</a>
      </div>
    </div>
  </div>

</section><!-- End Hero -->

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
@endsection