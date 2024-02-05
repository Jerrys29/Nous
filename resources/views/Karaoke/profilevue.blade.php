@extends('templates.karaoke')

@section('document')
<main id="main">
  <!-- ======= Portfolio Section ======= -->
  <section id="portfolio" class="portfolio">
    <div class="container">

      <div class="section-title">
        <h2>{{ $user->pseudo }}</h2>
        @if (auth()->user() && auth()->user()->paiement == 0)
        <button type="button" class="btn btn-success launch" data-toggle="modal" data-target="#staticBackdrop"><i class="bi bi-whatsapp whatsapp-icon launch" data-toggle="modal" data-target="#staticBackdrop">Contacter</i></button>

        
        <div class="modal fade" id="staticBackdrop" data-backdrop="false" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">

            <div class="modal-content">
              <div class="modal-body">
                <div class="text-right">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="text-center mt-2"> <img src="{{asset('assets/img/nous_logo.png')}}" width="200"> </div>
                  </div>
                  <div class="col-md-6">
                    <div class="text-white mt-4">
                      <div class="mt-2"> <span class="intro-2">Veuillez payer votre forfait pour communiquer avec <h5>{{ $user->pseudo }}</h5> .</span> </div>
                      <kkiapay-widget amount="1" key="de9c4e671f1c676a8613e0a567252e182c8fc52c" callback="https://wa.me/{{ $user->numero}}?text=Un%20utilisateur%20de%20l%27espace%20karaok%C3%A9%20vous%20a%20contact%C3%A9."/>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @else
        <a href="https://wa.me/{{ $user->numero}}" target="_blank">
          <div class="btn btn-danger" style="margin-left: 1000px;">Discuter</div>
        </a>
        @endif
      </div>
      <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="150">

        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
          <img src="{{ asset('storage/' . $user->photo1) }}" class="img-fluid" alt="">
          <div class="portfolio-info">
            <a href="{{ asset('storage/' . $user->photo1) }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title=""><i class="bx bx-plus"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-web">
          <img src="{{ asset('storage/' . $user->photo2) }}" class="img-fluid" alt="">
          <div class="portfolio-info">
            <a href="{{ asset('storage/' . $user->photo2) }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title=""><i class="bx bx-plus"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
          <img src="{{ asset('storage/' . $user->photo3) }}" class="img-fluid" alt="">
          <div class="portfolio-info">
            <a href="{{ asset('storage/' . $user->photo3) }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title=""><i class="bx bx-plus"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-card">
          <img src="{{ asset('storage/' . $user->photo4) }}" class="img-fluid" alt="">
          <div class="portfolio-info">
            <a href="{{ asset('storage/' . $user->photo4) }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title=""><i class="bx bx-plus"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-web">
          <img src="{{ asset('storage/' . $user->photo5) }}" class="img-fluid" alt="">
          <div class="portfolio-info">
            <a href="{{ asset('storage/' . $user->photo5) }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title=""><i class="bx bx-plus"></i></a>

          </div>
        </div>

      </div>

    </div>
  </section><!-- End Portfolio Section -->
  <script>
    $(document).ready(function() {
      $('.close').click(function() {
        $('#staticBackdrop').modal('hide');
      });
    });
  </script>

 <style>
  .modal {
    z-index: 1050;
    /* Valeur plus élevée que le z-index par défaut de Bootstrap */
  }

  .modal-body {
    background-color: #5165ff;
    border-color: #5165ff;
    height: 40vh;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 50%; /* Ajustez cette valeur pour centrer verticalement le modal */
  }

  .intro-1 {
    font-size: 20px
  }

  .close {
    color: #fff
  }

  .close:hover {
    color: #fff
  }

  .intro-2 {
    font-size: 13px
  }

  .btn-primary {
    color: #5165ff;
    background-color: #fffaff;
    border-color: #fffaff;
    padding: 12px;
    font-weight: 700;
    border-radius: 41px;
    padding-right: 20px;
    padding-left: 20px;
  }
</style>

</main><!-- End #main -->

@endsection