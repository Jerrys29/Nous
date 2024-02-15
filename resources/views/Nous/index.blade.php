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
            <p style="text-align: justify;">
              Nous vous fournissons une meilleure expérience de rencontre, vous avez la possibilité de rencontrer de nombreuses personnes de plus de 20 pays plus proches de vous que jamais. </p>
          </div>
        </div>
        <div class="content col-xl-4 d-flex align-items-stretch">
          <div class="content">
            <h3>Rencontrez des personnes au Bénin et en Afrique et au-delà.</h3>
            <p style="text-align: justify;">
              Nous insistons sur la vérification des identités de nos utilisateurs, nous vérifions également toutes les informations liées à une inscription avant de vous la proposer. Notre but est de vous aider à trouver votre compagne en toute discrétion et ceci sans risque. Nous travaillons à réunir le plus de personnes pour une expérience folle jamais vue auparavant. </p>
          </div>
        </div>
        <div class="content col-xl-4 d-flex align-items-stretch">
          <div class="content">
            <h3>Débutez votre histoire sur <img src="assets/img/nous_logo.png" alt="" style="max-height: 40px;"></h3>
            <p style="text-align: justify;">
              Abonnez-vous et faites les meilleures rencontres de votre vie. Vous cherchez votre âme sœur ? ?? Nous avons le partenaire idéal pour vous !!! </p>
          </div>
        </div>
      </div>

    </div>
  </section><!-- End About Section -->


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