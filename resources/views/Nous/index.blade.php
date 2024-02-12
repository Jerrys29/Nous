@extends('templates.app')

@section('document')
  <!-- ======= Hero Section ======= -->

    <!-- style drapeaux -->
    <style>
    .scrolling-flags-container {
      display: flex; /* Utilisation de flexbox pour aligner les drapeaux horizontalement */
      animation: scroll 60s linear infinite; /* Animation de défilement */
    }

    .flag-image {
      width: 25; /* Ajustez la largeur selon vos besoins */
      height: 25px; /* Pour conserver les proportions de l'image */
      margin-right: 10px; /* Espace entre les drapeaux */
    }

    /* Animation de défilement */
    @keyframes scroll {
      0% {
        transform: translateX(0); /* Départ du défilement */
      }
      100% {
        transform: translateX(calc(-50px * 56)); /* Fin du défilement - défilement de 56 drapeaux */
      }
    }
  </style>

    <div class="scrolling-flags-container" onmouseover="stopAnimation()" onmouseout="startAnimation()">
      @for ($i = 1; $i <= 56; $i++)
          <img src="{{ asset('assets/img/drap/' . $i . '.png') }}" alt="Drapeau {{ $i }}" class="flag-image">
      @endfor
  </div>


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
            <i class="flag-icon flag-icon-bj"></i>
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

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>Comment ça marche?</h2>
          <p>
            Commencez sur nous dès aujourd'hui en quatre étapes.</p>
        </div>

        <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
          <div class="row">

            <div class="col-3">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <img src="assets/img/testimonials/register.png" class="testimonial-img" alt="">
                  <h3>Créer un profil</h3>
                  <p>
                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                    Créez votre profil en quelques secondes grâce à notre inscription facile. N'oubliez pas d'ajouter une photo !
                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                  </p>
                </div>
              </div>
            </div><!-- End testimonial item -->

            <div class="col-3">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <img src="assets/img/testimonials/Confirmed-pana.png" class="testimonial-img" alt="">
                  <h3>Valider votre inscription</h3>
                  <p>
                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                    Finalisez votre inscription en consultant votre mail et accéder à notre large liste de potentiels compagnons de vie qui vous attendent.
                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                  </p>
                </div>
              </div>
            </div><!-- End testimonial item -->

            <div class="col-3">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <img src="assets/img/testimonials/Photos-rafiki.png" class="testimonial-img" alt="">
                  <h3>Parcourir les photos</h3>
                  <p>
                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                    Recherchez facilement parmi notre vaste base de membres, avec une gamme de préférences et de paramètres de votre choix.
                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                  </p>
                </div>
              </div>
            </div><!-- End testimonial item -->

            <div class="col-3">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <img src="assets/img/testimonials/Chatting-bro.png" class="testimonial-img" alt="">
                  <h3> Commencer à communiquer : </h3>

                  <p>
                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                    Envoyer un message à fan POP ou Flash pour commencer à communiquer avec les membres. Il est temps de montrer votre charme. <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                  </p>
                </div>
              </div>
            </div><!-- End testimonial item -->

          </div>
          <center>
            <div>
              <a href="{{('/profils')}}" class="btn-get-started scrollto">Trouvez votre partenaire</a>
            </div>
          </center>

        </div>

      </div>
    </section>
    <script>
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

<!-- End Testimonials Section -->
    <!-- <section class="chatbox">
      <section class="chat-window">
        <article class="msg-container msg-remote" id="msg-1">
          <div class="msg-box">
            <img class="user-img" id="user-0" src="//gravatar.com/avatar/00034587632094500000000000000000?d=retro" />
            <div class="flr">
              <div class="messages">
                <p class="msg" id="msg-0">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent varius, neque non tristique tincidunt, mauris nunc efficitur erat, elementum semper justo odio id nisi.
                </p>
              </div>
              <span class="timestamp"><span class="username">Name</span>&bull;<span class="posttime">3 minutes ago</span></span>
            </div>
          </div>
        </article>
        <article class="msg-container msg-self" id="msg-2">
          <div class="msg-box">
            <div class="flr">
              <div class="messages">
                <p class="msg" id="msg-1">
                  Lorem ipsum dolor sit amet
                </p>
                <p class="msg" id="msg-2">
                  Praesent varius
                </p>
              </div>
              <span class="timestamp"><span class="username">Name</span>&bull;<span class="posttime">2 minutes ago</span></span>
            </div>
            <img class="user-img" id="user-0" src="//gravatar.com/avatar/56234674574535734573000000000001?d=retro" />
          </div>
        </article>
      </section>
      <form class="chat-input" id="chat-form" onsubmit="return false;">
        <input type="text" id="new-message" autocomplete="on" placeholder="Type a message" />
        <button type="submit">
          <svg style="width:24px;height:24px" viewBox="0 0 24 24">
            <path fill="rgba(0,0,0,.38)" d="M17,12L12,17V14H8V10H12V7L17,12M21,16.5C21,16.88 20.79,17.21 20.47,17.38L12.57,21.82C12.41,21.94 12.21,22 12,22C11.79,22 11.59,21.94 11.43,21.82L3.53,17.38C3.21,17.21 3,16.88 3,16.5V7.5C3,7.12 3.21,6.79 3.53,6.62L11.43,2.18C11.59,2.06 11.79,2 12,2C12.21,2 12.41,2.06 12.57,2.18L20.47,6.62C20.79,6.79 21,7.12 21,7.5V16.5M12,4.15L5,8.09V15.91L12,19.85L19,15.91V8.09L12,4.15Z" />
          </svg>
        </button>
      </form>
    </section> -->

    <!-- <button id="toggleChat" class="btn btn-danger" style="margin-left: 1400px;margin-bottom: 40px;margin-top: 40px;">Discuter</button>

    <script>
      // Script pour afficher/masquer la section chatbox
      $(document).ready(function() {
        $('#toggleChat').click(function() {
          $('.chatbox').toggle();
        });
      });
    </script>
    <script>
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