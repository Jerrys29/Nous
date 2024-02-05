@extends('templates.app')

@section('document')
<main id="main">
  <!-- ======= Portfolio Section ======= -->
  <section id="portfolio" class="portfolio">
    <div class="container">

      <div class="section-title">
        <h2>{{ $user->name }}</h2>
        @if (auth()->user() && auth()->user()->paiement == 0)
        <i class="bi bi-whatsapp whatsapp-icon launch" data-toggle="modal" data-target="#staticBackdrop"></i>
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
                      <div class="mt-2"> <span class="intro-2">Veuillez payer votre abonnement mensuel pour communiquer avec votre potentiel partenaire.</span> </div>

                      <script amount="981" callback="{{ url('/mettre-a-jour-paiement') }}" data="" position="right" theme="red" sandbox="false" key="de9c4e671f1c676a8613e0a567252e182c8fc52c" src="https://cdn.kkiapay.me/k.js"></script>

                      <div class="mt-4 mb-5">
                        <a id="lienWhatsApp" href="#" class="kkiapay-button btn btn-primary">Payer mon abonnement <i class="fa fa-cloud-download"></i></a>
                      </div>

                      <script>
                        document.getElementById('lienWhatsApp').addEventListener('click', function(event) {
                          // Empêcher la redirection immédiate
                          event.preventDefault();

                          // Stocker une indication du début de la redirection dans le stockage local
                          localStorage.setItem('redirectionInProgress', 'true');

                          // Effectuer la requête Ajax pour déclencher le paiement avec Kkiapay
                          var xhr = new XMLHttpRequest();
                          xhr.open('GET', '{{ url("/effectuer-paiement") }}', true);
                          xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                              if (xhr.status === 200) {
                                console.log('Paiement Kkiapay effectué avec succès.');
                                localStorage.removeItem('redirectionInProgress');
                                var numeroWhatsApp = '{{ $user->numero }}';
                                var urlWhatsApp = 'https://wa.me/' + numeroWhatsApp;
                                console.log('URL WhatsApp:', urlWhatsApp);

                                // Simuler un clic sur le lien créé
                                var lienWhatsApp = document.getElementById('lienWhatsApp');
                                lienWhatsApp.href = urlWhatsApp;
                                lienWhatsApp.click();
                              } else {
                                console.error('Échec du paiement Kkiapay. Status:', xhr.status);
                              }
                            }
                          };
                          xhr.send();
                        });
                      </script>


                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @else
        <a href="https://wa.me/{{ $user->numero }}" target="_blank"><i class="bi bi-whatsapp whatsapp-icon"></i></a>
        @endif
      </div>
      <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="150">
        <div class="col-6">
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

    </div>
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
      }

      .modal-body {
        background-color: #5165ff;
        border-color: #5165ff;
        height: 40vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 90px;

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
      margin-top: 90px;

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