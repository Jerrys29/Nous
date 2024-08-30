@extends('templates.app')
@section('document')
<h2 style="text-align: center;">Trouver votre Partenaire ici</h2>
<main id="main">

  <section id="about" class="about">
    <div class="container">
      <div class="row">
        <!-- User Profile Cards -->
        <div class="col-lg-12">
          <form action="{{ route('search') }}" method="GET" class="search-form">
            <input type="text" name="query" placeholder="Entrez votre critère de recherche..." class="search-input">
            <button type="submit" class="search-button">Rechercher</button>
          </form>
          <div class="row">
            @if(!is_null($users) && !$users->isEmpty())
            <h2>Résultats de la recherche pour "{{ $query }}" :</h2>
            @foreach($users as $user)
            <div class="col-lg-4 mb-3">
              <a href="{{ url('/profil/' . $user->id) }}" style="text-decoration: none; color: inherit; cursor: auto;">
                <div class="card">
                  <img src="{{ asset('storage/' . $user->photo1) }}" class="card-img card-img-top img-fluid" alt="Profile Image {{ $user->id }}" style="object-fit: cover; height: 100%;">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-8">
                        <h5 class="card-title">{{ $user->name }}</h5>
                      </div>
                      <div class="col-4">
                        <h5 class="card-title">{{ $user->age }} ans</h5>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <div class="like-container">
                          @if (auth()->user() && auth()->user()->hasLikedProfile($user->id))
                          <a href="{{ route('unlike-profile', ['profile_id' => $user->id]) }}" onclick="event.preventDefault(); document.getElementById('unlike-form-{{ $user->id }}').submit();">
                            <svg class="like-svg" width="20" height="20" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                              <path fill="#BE1931" d="M2.067 11.319C2.067 2.521 14.251-.74 18 9.445C21.749-.741 33.933 2.52 33.933 11.319C33.933 20.879 18 33 18 33S2.067 20.879 2.067 11.319" />
                            </svg>
                          </a>
                          <form id="unlike-form-{{ $user->id }}" action="{{ route('unlike-profile', ['profile_id' => $user->id]) }}" method="POST" style="display: none;">
                            @csrf
                          </form>
                          @else
                          <a href="{{ route('like-profile', ['profile_id' => $user->id]) }}" onclick="event.preventDefault(); document.getElementById('like-form-{{ $user->id }}').submit();">
                            <i class="bi bi-heart like-button" style="width:50px; height: 50px;"></i>
                          </a>
                          @endif
                          <form id="like-form-{{ $user->id }}" action="{{ route('like-profile', ['profile_id' => $user->id]) }}" method="POST" style="display: none;">
                            @csrf
                          </form>

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
                                      <div class="text-center mt-2">
                                        <img src="{{ asset('assets/img/nous_logo.png') }}" width="200">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="text-white mt-4">
                                        <div class="mt-2">
                                          <span class="intro-2">Veuillez payer votre abonnement mensuel pour communiquer avec votre potentiel partenaire.</span>
                                        </div>
                                        <kkiapay-widget amount="981" key="de9c4e671f1c676a8613e0a567252e182c8fc52c" callback="{{ url('/mettre-a-jour-paiement') }}" theme="red"></kkiapay-widget>
                                        <div class="mt-4 mb-5">
                                          <a id="lienWhatsApp" href="#" class="kkiapay-button btn btn-primary">Payer mon abonnement <i class="fa fa-cloud-download"></i></a>
                                        </div>
                                        <script>
                                          document.getElementById('lienWhatsApp').addEventListener('click', function(event) {
                                            event.preventDefault();
                                            Kkiapay.activateWidget();
                                          });
                                          window.addEventListener('kkiapayCallback', function(event) {
                                            var paiementReussi = event.detail.success;
                                            if (paiementReussi) {
                                              var xhr = new XMLHttpRequest();
                                              xhr.open('GET', '{{ url("/mettre-a-jour-paiement") }}', true);
                                              xhr.onreadystatechange = function() {
                                                if (xhr.readyState === XMLHttpRequest.DONE) {
                                                  if (xhr.status === 200) {
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
                          <a href="https://wa.me/{{ $user->numero }}" target="_blank"><i class="bi bi-whatsapp whatsapp-icon"></i></a>
                          @endif
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="text-right">
                          <a href="{{ url('/profil/' . $user->id) }}" class="btn btn-danger btn-sm">Voir le profil</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            @endforeach
            @endif
            @if(auth()->user())
            <h2>Vos correspondances</h2>
            @endif
            @foreach($users as $user)
            <div class="col-lg-4 mb-3">
              <a href="{{ url('/profil/' . $user->id) }}" style="text-decoration: none; color: inherit; cursor: auto;">
                <div class="card">
                  @if ($user->photo1)
                  <div style="overflow: hidden; height: 400px;">
                    <img src="{{ asset('storage/' . $user->photo1) }}" class="card-img card-img-top img-fluid" alt="Profile Image {{ $user->id }}" style="object-fit: cover; height: 100%; width: 400px;">
                  </div>
                  @else
                  <div style="overflow: hidden; height: 400px;">
                    <img src="{{ asset('assets/img/person-fill.svg') }}" class="card-img card-img-top img-fluid" alt="Profile Image {{ $user->id }}" style="object-fit: cover; height: 100%; width: 400px;">
                  </div>
                  @endif
                  <div class="card-body">
                    <div class="row">
                      <div class="col-8">
                        <h5 class="card-title">{{ $user->name }}</h5>
                      </div>
                      <div class="col-4">
                        <h5 class="card-title">{{ $user->age }} ans</h5>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <div class="like-container">
                          @if (auth()->user() && auth()->user()->hasLikedProfile($user->id))
                          <a href="{{ route('unlike-profile', ['profile_id' => $user->id]) }}" onclick="event.preventDefault(); document.getElementById('unlike-form-{{ $user->id }}').submit();">
                            <svg class="like-svg" width="20" height="20" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                              <path fill="#BE1931" d="M2.067 11.319C2.067 2.521 14.251-.74 18 9.445C21.749-.741 33.933 2.52 33.933 11.319C33.933 20.879 18 33 18 33S2.067 20.879 2.067 11.319" />
                            </svg>
                          </a>
                          <form id="unlike-form-{{ $user->id }}" action="{{ route('unlike-profile', ['profile_id' => $user->id]) }}" method="POST" style="display: none;">
                            @csrf
                          </form>
                          @else
                          <a href="{{ route('like-profile', ['profile_id' => $user->id]) }}" onclick="event.preventDefault(); document.getElementById('like-form-{{ $user->id }}').submit();">
                            <i class="bi bi-heart like-button" style="width:50px; height: 50px;"></i>
                          </a>
                          @endif
                          <form id="like-form-{{ $user->id }}" action="{{ route('like-profile', ['profile_id' => $user->id]) }}" method="POST" style="display: none;">
                            @csrf
                          </form>

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
                                      <div class="text-center mt-2">
                                        <img src="{{ asset('assets/img/nous_logo.png') }}" width="200">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="text-white mt-4">
                                        <div class="mt-2">
                                          <span class="intro-2">Veuillez payer votre abonnement mensuel pour communiquer avec votre potentiel partenaire.</span>
                                        </div>
                                        <kkiapay-widget amount="981" key="de9c4e671f1c676a8613e0a567252e182c8fc52c" callback="{{ url('/mettre-a-jour-paiement') }}" theme="red"></kkiapay-widget>
                                        <div class="mt-4 mb-5">
                                          <a id="lienWhatsApp" href="#" class="kkiapay-button btn btn-primary">Payer mon abonnement <i class="fa fa-cloud-download"></i></a>
                                        </div>
                                        <script>
                                          document.getElementById('lienWhatsApp').addEventListener('click', function(event) {
                                            event.preventDefault();
                                            Kkiapay.activateWidget();
                                          });
                                          window.addEventListener('kkiapayCallback', function(event) {
                                            var paiementReussi = event.detail.success;
                                            if (paiementReussi) {
                                              var xhr = new XMLHttpRequest();
                                              xhr.open('GET', '{{ url("/mettre-a-jour-paiement") }}', true);
                                              xhr.onreadystatechange = function() {
                                                if (xhr.readyState === XMLHttpRequest.DONE) {
                                                  if (xhr.status === 200) {
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
                          <a href="https://wa.me/{{ $user->numero }}" target="_blank"><i class="bi bi-whatsapp whatsapp-icon"></i></a>
                          @else
                          <a href="{{ route('login') }}"><i class="bi bi-whatsapp whatsapp-icon"></i></a>
                          @endif
                          @endif
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="text-right">
                          <a href="{{ url('/profil/' . $user->id) }}" class="btn btn-danger btn-sm">Voir le profil</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            @endforeach
            <!-- Bouton "Précédent" -->
            @if ($users->previousPageUrl())
            <a href="{{ $users->previousPageUrl() }}" class="btn btn-primary">Précédent</a>
            @endif

            <!-- Bouton "Suivant" -->
            @if ($users->nextPageUrl())
            <a href="{{ $users->nextPageUrl() }}" class="btn btn-primary">Suivant</a>
            @endif

            @if(auth()->user())
            <h2>Tous les profils :</h2>
            @foreach($allusers as $alluser)
            <div class="col-lg-4 mb-3">
              <a href="{{ url('/profil/' . $alluser->id) }}" style="text-decoration: none; color: inherit; cursor: auto;">
                <div class="card">
                  @if ($alluser->photo1)
                  <div style="overflow: hidden; height: 400px;">
                    <img src="{{ asset('storage/' . $alluser->photo1) }}" class="card-img card-img-top img-fluid" alt="Profile Image {{ $alluser->id }}" style="object-fit: cover; height: 100%; width: 400px;">
                  </div>
                  @else
                  <div style="overflow: hidden; height: 400px;">
                    <img src="{{ asset('assets/img/person-fill.svg') }}" class="card-img card-img-top img-fluid" alt="Profile Image {{ $alluser->id }}" style="object-fit: cover; height: 100%; width: 400px;">
                  </div>
                  @endif
                  <div class="card-body">
                    <div class="row">
                      <div class="col-8">
                        <h5 class="card-title">{{ $alluser->name }}</h5>
                      </div>
                      <div class="col-4">
                        <h5 class="card-title">{{ $alluser->age }} ans</h5>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <div class="like-container">
                          @if (auth()->user() && auth()->user()->hasLikedProfile($alluser->id))
                          <a href="{{ route('unlike-profile', ['profile_id' => $alluser->id]) }}" onclick="event.preventDefault(); document.getElementById('unlike-form-{{ $alluser->id }}').submit();">
                            <svg class="like-svg" width="20" height="20" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                              <path fill="#BE1931" d="M2.067 11.319C2.067 2.521 14.251-.74 18 9.445C21.749-.741 33.933 2.52 33.933 11.319C33.933 20.879 18 33 18 33S2.067 20.879 2.067 11.319" />
                            </svg>
                          </a>
                          <form id="unlike-form-{{ $alluser->id }}" action="{{ route('unlike-profile', ['profile_id' => $alluser->id]) }}" method="POST" style="display: none;">
                            @csrf
                          </form>
                          @else
                          <a href="{{ route('like-profile', ['profile_id' => $alluser->id]) }}" onclick="event.preventDefault(); document.getElementById('like-form-{{ $alluser->id }}').submit();">
                            <i class="bi bi-heart like-button" style="width:50px; height: 50px;"></i>
                          </a>
                          @endif
                          <form id="like-form-{{ $alluser->id }}" action="{{ route('like-profile', ['profile_id' => $alluser->id]) }}" method="POST" style="display: none;">
                            @csrf
                          </form>

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
                                      <div class="text-center mt-2">
                                        <img src="{{ asset('assets/img/nous_logo.png') }}" width="200">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="text-white mt-4">
                                        <div class="mt-2">
                                          <span class="intro-2">Veuillez payer votre abonnement mensuel pour communiquer avec votre potentiel partenaire.</span>
                                        </div>
                                        <kkiapay-widget amount="981" key="de9c4e671f1c676a8613e0a567252e182c8fc52c" callback="{{ url('/mettre-a-jour-paiement') }}" theme="red"></kkiapay-widget>
                                        <div class="mt-4 mb-5">
                                          <a id="lienWhatsApp" href="#" class="kkiapay-button btn btn-primary">Payer mon abonnement <i class="fa fa-cloud-download"></i></a>
                                        </div>
                                        <script>
                                          document.getElementById('lienWhatsApp').addEventListener('click', function(event) {
                                            event.preventDefault();
                                            Kkiapay.activateWidget();
                                          });
                                          window.addEventListener('kkiapayCallback', function(event) {
                                            var paiementReussi = event.detail.success;
                                            if (paiementReussi) {
                                              var xhr = new XMLHttpRequest();
                                              xhr.open('GET', '{{ url("/mettre-a-jour-paiement") }}', true);
                                              xhr.onreadystatechange = function() {
                                                if (xhr.readyState === XMLHttpRequest.DONE) {
                                                  if (xhr.status === 200) {
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
                          <a href="https://wa.me/{{ $alluser->numero }}" target="_blank"><i class="bi bi-whatsapp whatsapp-icon"></i></a>
                          @else
                          <a href="{{ route('login') }}"><i class="bi bi-whatsapp whatsapp-icon"></i></a>
                          @endif
                          @endif
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="text-right">
                          <a href="{{ url('/profil/' . $alluser->id) }}" class="btn btn-danger btn-sm">Voir le profil</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            @endforeach

            @if ($allusers->previousPageUrl())
            <a href="{{ $allusers->previousPageUrl() }}" class="btn btn-primary">Précédent</a>
            @endif

            <!-- Bouton "Suivant" -->
            @if ($allusers->nextPageUrl())
            <a href="{{ $allusers->nextPageUrl() }}" class="btn btn-primary">Suivant</a>
            @endif
            @endif

          </div>

          <script>
            $(document).ready(function() {
              $('.close').click(function() {
                $('#staticBackdrop').modal('hide');
              });
            });
          </script>

          <style>
            .search-form {
              display: flex;
              align-items: center;
            }

            .card-img {
              height: 200px;
              object-fit: cover;
            }

            .search-input {
              flex: 1;
              padding: 10px;
              border: 2px solid #ccc;
              border-radius: 5px;
              font-size: 16px;
            }

            .search-button {
              background-color: #007bff;
              color: #fff;
              border: none;
              border-radius: 5px;
              padding: 10px 20px;
              font-size: 16px;
              cursor: pointer;
              transition: background-color 0.3s ease;
            }

            .search-button:hover {
              background-color: #0056b3;
            }

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

        </div>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

        <!-- Script du popup -->
        <script>
          $(document).ready(function() {
            // Afficher le popup lorsqu'on clique sur l'icône WhatsApp
            $('.whatsapp-icon').click(function() {
              $('#myModal').modal('show');
            });
          });
        </script>

      </div>
    </div>
  </section>


</main><!-- End #main -->

@endsection