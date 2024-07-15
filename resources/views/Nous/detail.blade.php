@extends('templates.app')

@section('document')
<main id="main">
  <!-- ======= Portfolio Section ======= -->
  <section id="portfolio" class="portfolio">
    <div class="container">

      <div class="section-title">
        <h2>{{ $user->name }}</h2>
        @if (auth()->user() && auth()->user()->paiement == 0)
        <button class="btn btn-danger" data-toggle="modal" data-target="#staticBackdrop">Discuter avec {{$user->name}}</button>
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

                      <kkiapay-widget amount="981" key="de9c4e671f1c676a8613e0a567252e182c8fc52c" callback="{{ url('/mettre-a-jour-paiement') }}" theme="red" />
                      <div class="mt-4 mb-5">
                        <a id="lienWhatsApp" href="#" class="kkiapay-button btn btn-primary">Payer mon abonnement <i class="fa fa-cloud-download"></i></a>
                      </div>


                      <script>
                        document.getElementById('lienWhatsApp').addEventListener('click', function(event) {
                          event.preventDefault();

                          // Activer le widget Kkiapay
                          Kkiapay.activateWidget();
                        });

                        // Écouter le callback de Kkiapay une fois que le paiement est effectué avec succès
                        window.addEventListener('kkiapayCallback', function(event) {
                          var paiementReussi = event.detail.success;

                          if (paiementReussi) {
                            // Effectuer la requête Ajax pour mettre à jour le paiement avec Kkiapay
                            var xhr = new XMLHttpRequest();
                            xhr.open('GET', '{{ url("/mettre-a-jour-paiement") }}', true);
                            xhr.onreadystatechange = function() {
                              if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                  // Redirection vers la route "profils"
                                  window.location.href = "{{ route('profils') }}";
                                } else {
                                  console.error('Échec de la mise à jour du paiement. Status:', xhr.status);
                                }
                              }
                            };
                            xhr.send();
                          } else {
                            console.error('Échec du paiement Kkiapay.');
                          }
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
        @if(auth()->user())
        <a href="https://wa.me/{{ $user->numero }}" target="_blank"><button class="btn btn-danger">Discuter avec {{$user->name}}</button></a>
                          @else
                          <a href="{{ route('login') }}"><button class="btn btn-danger">Discuter avec {{$user->name}}</button></a>
                          @endif
        @endif
      </div>
      <div class="container">

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
            <div class="col-lg-12  mb-3">
              <p style="text-align: center;">Aucune photo disponible pour cet utilisateur.</p>
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



        <style>
          .form-control,
          .form-control-static {
            font-size: 16px;
            /* Ajustez cette valeur selon vos besoins */
          }
        </style>

        <div class="row">
          <div class="col-lg-6">
            <!-- Champ de numéro WhatsApp -->
            <!-- Champ de nom -->
            <div class="mb-3 row align-items-center">
              <label for="name" class="col-sm-4 col-form-label fw-bold">Nom:</label>
              <div class="col-sm-8">
                <p class="form-control-static">{{ $user->name }}</p>
              </div>
            </div>
            <!-- Champ d'âge -->
            <div class="mb-3 row align-items-center">
              <label for="age" class="col-sm-4 col-form-label fw-bold">Âge:</label>
              <div class="col-sm-8">
                <p class="form-control-static">{{ $user->age }}</p>
              </div>
            </div>
            <div class="mb-3 row align-items-center">
              <label for="genre" class="col-sm-4 col-form-label fw-bold">Genre:</label>
              <div class="col-sm-8">
                <p class="form-control-static">{{ $user->genre }}</p>
              </div>
            </div>
            <div class="mb-3 row align-items-center">
              <label for="looking_for" class="col-sm-4 col-form-label fw-bold">Genre recherché:</label>
              <div class="col-sm-8">
                <p class="form-control-static">{{ $user->looking_for }}</p>
              </div>
            </div>
            <div class="mb-3 row align-items-center">
              <label for="town" class="col-sm-4 col-form-label fw-bold">Ville:</label>
              <div class="col-sm-8">
                <p class="form-control-static">{{ $user->town }}</p>
              </div>
            </div>
            <div class="mb-3 row align-items-center">
              <label for="origin_country" class="col-sm-4 col-form-label fw-bold">Pays d'origine:</label>
              <div class="col-sm-8">
                <p class="form-control-static">{{ $user->origin_country }}</p>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="mb-3 row align-items-center">
              <label for="birthplace" class="col-sm-4 col-form-label fw-bold">Ville de naissance:</label>
              <div class="col-sm-8">
                <p class="form-control-static">{{ $user->birthplace }}</p>
              </div>
            </div>
            <div class="mb-3 row align-items-center">
              <label for="town" class="col-sm-4 col-form-label fw-bold">Ville:</label>
              <div class="col-sm-8">
                <p class="form-control-static">{{ $user->town }}</p>
              </div>
            </div>
            <div class="mb-3 row align-items-center">
              <label for="mariatal_status" class="col-sm-4 col-form-label fw-bold">Situation Matrimoniale:</label>
              <div class="col-sm-8">
                <p class="form-control-static">{{ $user->mariatal_status }}</p>
              </div>
            </div>
            <div class="mb-3 row align-items-center">
              <label for="hair_color" class="col-sm-4 col-form-label fw-bold">Couleur des cheveux:</label>
              <div class="col-sm-8">
                <p class="form-control-static">{{ $user->hair_color }}</p>
              </div>
            </div>
            <div class="mb-3 row align-items-center">
              <label for="eyes_color" class="col-sm-4 col-form-label fw-bold">Couleur des yeux:</label>
              <div class="col-sm-8">
                <p class="form-control-static">{{ $user->eyes_color }}</p>
              </div>
            </div>
            <!-- Champ d'À propos de moi -->
            <div class="mb-3 row align-items-center">
              <label for="about" class="col-sm-4 col-form-label fw-bold">À propos de cet utilisateur:</label>
              <div class="col-sm-8">
                <p class="form-control-static">{{ $user->about }}</p>
              </div>
            </div>
            <!-- Champ des centres d'intérêt -->
            <div class="mb-3 row align-items-center">
              <label for="interests" class="col-sm-4 col-form-label fw-bold">Centres d'intérêt</label>
              <div class="col-sm-8">
                <p class="form-control-static">{{ $user->interests }}</p>
              </div>
            </div>
          </div>
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