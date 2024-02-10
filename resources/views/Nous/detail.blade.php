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
        <a href="https://wa.me/{{ $user->numero }}" target="_blank"><button class="btn btn-danger">Discuter avec {{$user->name}}</button></a>
        @endif
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
               
                <div class="user-images">
                  <div class="row">
                    <div class="col-4"> @if ($user->photo1)
                      <img style="width: 200px;height:200px;object-fit: cover;  margin-right: 10px;" src="{{ asset('storage/' . $user->photo1) }}" alt="Photo 1">
                      @endif
                    </div>
                    <div class="col-4"> @if ($user->photo2)
                      <img style="width: 200px;height:200px;object-fit: cover;  margin-right: 10px;" src="{{ asset('storage/' . $user->photo2) }}" alt="Photo 2">
                      @endif
                    </div>
                    <div class="col-4"> @if ($user->photo3)
                      <img style="width: 200px;height:200px;object-fit: cover;  margin-right: 10px;" src="{{ asset('storage/' . $user->photo3) }}" alt="Photo 3">
                      @endif
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      @if ($user->photo4)
                      <img style="width: 200px;height:200px;object-fit: cover;  margin-right: 10px;" src="{{ asset('storage/' . $user->photo4) }}" alt="Photo 4">
                      @endif
                    </div>
                    <div class="col-6"> @if ($user->photo5)
                      <img style="width: 200px;height:200px;object-fit: cover;  margin-right: 10px;" src="{{ asset('storage/' . $user->photo5) }}" alt="Photo 5">
                      @endif
                    </div>
                  </div>
                  <!-- Afficher un message si aucune photo n'est disponible -->
                  @if (!$user->photo1 && !$user->photo2 && !$user->photo3 && !$user->photo4 && !$user->photo5)
                  <p style="text-align: center;">Aucune photo disponible pour cet utilisateur.</p>
                  @endif
                </div>


              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6"> <!-- Champ de numéro WhatsApp -->

                    <!-- Champ de nom -->
                    <div class="mb-3">
                      <label for="name" class="form-label fw-bold">Nom:</label>
                      <p class="form-control-static">{{ $user->name }}</p>
                    </div>

                    <!-- Champ d'âge -->
                    <div class="mb-3">
                      <label for="age" class="form-label fw-bold">Âge:</label>
                      <p class="form-control-static">{{ $user->age }}</p>
                    </div>
                    <div class="mb-3">
                      <label for="genre" class="form-label fw-bold">Genre:</label>
                      <p class="form-control-static">{{ $user->genre }}</p>
                    </div>
                    <div class="mb-3">
                      <label for="looking_for" class="form-label fw-bold">Genre recherché:</label>
                      <p class="form-control-static">{{ $user->looking_for }}</p>
                    </div>

                    <div class="mb-3">
                      <label for="town" class="form-label fw-bold">Ville:</label>
                      <p class="form-control-static">{{ $user->town }}</p>                
                        </div>
                    <div class="mb-3">
                      <label for="origin_country" class="form-label fw-bold">Pays d'origine:</label>
                      <p class="form-control-static">{{ $user->origin_country }}</p>                    </div>

                  </div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label for="birthplace" class="form-label fw-bold">Ville de naissance:</label>
                      <p class="form-control-static">{{ $user->birthplace }}</p>
                    </div>
                    <div class="mb-3">
                      <label for="town" class="form-label fw-bold">Ville:</label>
                      <p class="form-control-static">{{ $user->town }}</p>
                                    </div>

                    <div class="mb-3">
                      <label for="mariatal_status" class="form-label fw-bold">Situation Matrimoniale:</label>
                      <p class="form-control-static">{{ $user->mariatal_status }}</p>                    </div>
                    <div class="mb-3">
                      <label for="hair_color" class="form-label fw-bold">Couleur des cheveux:</label>
                      <p class="form-control-static">{{ $user->hair_color }}</p>                    </div>
                    <div class="mb-3">
                      <label for="eyes_color" class="form-label fw-bold">Couleur des yeux</label>
                      <p class="form-control-static">{{ $user->eyes_color }}</p>                    </div>
                    <!-- Champ d'À propos de moi -->
                    <div class="mb-3">
                      <label for="about" class="form-label fw-bold">À propos de cet utilisateur:</label>
                      <p class="form-control-static">{{ $user->about }}</p>                    </div>

                    <!-- Champ des centres d'intérêt -->
                    <div class="mb-3">
                      <label for="interests" class="form-label fw-bold">Centres d'intérêt</label>
                      <p class="form-control-static">{{ $user->interests }}</p> 
                                       </div>
                  </div>
                </div>

              </div>

              </form>


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