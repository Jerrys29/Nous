@extends('templates.karaoke')

@section('document')

<style>
  .custom-modal-body {
    background-color: #5165ff;
    /* Remplacez cette couleur par celle de votre choix */
    border-color: #5165ff;
    /* Vous pouvez ajuster la couleur de la bordure si nécessaire */
    /* Autres styles CSS personnalisés */
  }

  .sp {
    font-size: 1rem;
  }
</style>
<main id="main">
  <!-- ======= Portfolio Section ======= -->
  <section id="portfolio" class="portfolio">
    <div class="container">
      <div class="section-title">
        <h2>{{ $user->pseudo }}</h2>
        <!-- Bouton pour déclencher le modal -->
        <a href="{{ url('/visiteur/' . $user->id) }}" target="_blank">
          <button type="button" class="btn btn-success">
            <i class="bi bi-whatsapp whatsapp-icon launch"></i> Contacter
          </button>
        </a>
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="false" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-body custom-modal-body">
                <div class="text-right">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="text-center mt-2">
                      <img src="{{asset('assets/img/nous_logo.png')}}" width="200">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="text-white mt-4">
                      <div class="mt-2">
                        <span class="sp">Veuillez payer votre forfait pour communiquer avec {{ $user->pseudo }}</span>
                        <span class="sp">Votre paiement sera irrécupérable </span>
                        <kkiapay-widget amount="1" key="de9c4e671f1c676a8613e0a567252e182c8fc52c" callback="https://wa.me/{{ $user->numero}}?text=Un%20utilisateur%20de%20l%27espace%20karaok%C3%A9%20vous%20a%20contact%C3%A9." />
                      </div>
                      <!-- Bouton de paiement -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="150">
        <!-- Photo 1 -->
        @if ($user->photo1)
          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <a href="{{ asset('storage/' . $user->photo1) }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="">
              <div class="position-relative">
                <img src="{{ asset('storage/' . $user->photo1) }}"  data-gallery="portfolioGallery" class="img-fluid" alt="">
                <div class="portfolio-info position-absolute top-50 start-50 translate-middle">
                  <i class="bx bx-zoom-in"></i>
                </div>
              </div>
            </a>
          </div>
        @else
          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <p>Aucune photo pour l'instant</p>
          </div>
        @endif

        <!-- Photo 2 -->
        @if ($user->photo2)
          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <a href="{{ asset('storage/' . $user->photo2) }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="">
              <div class="position-relative">
                <img src="{{ asset('storage/' . $user->photo2) }}"  data-gallery="portfolioGallery" class="img-fluid" alt="">
                <div class="portfolio-info position-absolute top-50 start-50 translate-middle">
                  <i class="bx bx-zoom-in"></i>
                </div>
              </div>
            </a>
          </div>
        @else
          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <p>Aucune photo pour l'instant</p>
          </div>
        @endif

        <!-- Photo 3 -->
        @if ($user->photo3)
          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <a href="{{ asset('storage/' . $user->photo3) }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="">
              <div class="position-relative">
                <img src="{{ asset('storage/' . $user->photo3) }}"  data-gallery="portfolioGallery" class="img-fluid" alt="">
                <div class="portfolio-info position-absolute top-50 start-50 translate-middle">
                  <i class="bx bx-zoom-in"></i>
                </div>
              </div>
            </a>
          </div>
        @else
          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <p>Aucune photo pour l'instant</p>
          </div>
        @endif

        <!-- Photo 4 -->
        @if ($user->photo4)
          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <a href="{{ asset('storage/' . $user->photo4) }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="">
              <div class="position-relative">
                <img src="{{ asset('storage/' . $user->photo4) }}"  data-gallery="portfolioGallery" class="img-fluid" alt="">
                <div class="portfolio-info position-absolute top-50 start-50 translate-middle">
                  <i class="bx bx-zoom-in"></i>
                </div>
              </div>
            </a>
          </div>
        @else
          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <p>Aucune photo pour l'instant</p>
          </div>
        @endif

        <!-- Photo 5 -->
        @if ($user->photo5)
          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <a href="{{ asset('storage/' . $user->photo5) }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="">
              <div class="position-relative">
                <img src="{{ asset('storage/' . $user->photo5) }}"  data-gallery="portfolioGallery" class="img-fluid" alt="">
                <div class="portfolio-info position-absolute top-50 start-50 translate-middle">
                  <i class="bx bx-zoom-in"></i>
                </div>
              </div>
            </a>
          </div>
        @else
          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <p>Aucune photo pour l'instant</p>
          </div>
        @endif

        <!-- Photo 6 -->
        @if ($user->photo6)
          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <a href="{{ asset('storage/' . $user->photo6) }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="">
              <div class="position-relative">
                <img src="{{ asset('storage/' . $user->photo6) }}"  data-gallery="portfolioGallery" class="img-fluid" alt="">
                <div class="portfolio-info position-absolute top-50 start-50 translate-middle">
                  <i class="bx bx-zoom-in"></i>
                </div>
              </div>
            </a>
          </div>
        @else
          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <p>Aucune photo pour l'instant</p>
          </div>
        @endif
      </div>
    </div>
  </section><!-- End Portfolio Section -->
</main><!-- End #main -->
<script>
    var inactivityTimeout = 30 * 60 * 1000; // 30 minutes d'inactivité

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

@endsection
