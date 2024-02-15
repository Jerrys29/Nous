<section class="d-flex align-items-center">
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center">

      <a href="{{('/')}}" class="logo me-auto"><img src="{{asset('assets/img/nous_logo.png')}}" alt=""></a>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="{{('/profils')}}">Trouver votre partenaire</a></li>
          <!-- <li class="dropdown"><a href="#"><span>Langues</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Francais</a></li>
              <li><a href="#">Anglais</a></li>
            </ul>
          </li> -->
        
    @auth
    <a href="{{ url('/edit') }}" class="get-started-btn scrollto" style="color: white;">Mon profil</a>
    
    <li class="dropdown">
    <a href="#"><span>Notifications</span> <i class="bi bi-chevron-down"></i></a>
    <ul>
        @if (Session::has('notifications_' . auth()->user()->id))
            @php
                $alreadyNotifiedUsers = [];
            @endphp

            @foreach (Session::get('notifications_' . auth()->user()->id) as $notification)
                @php
                    preg_match('/(.+) a aimé votre profil/', $notification, $matches);
                    $likerName = isset($matches[1]) ? $matches[1] : null;
                    // Fetch the user by name and get the ID
                    $liker = App\Models\User::where('name', $likerName)->first();
                    $likerId = $liker ? $liker->id : null;
                @endphp
                @if ($likerId && !in_array($likerId, $alreadyNotifiedUsers))
                    <li><a href="{{ url('/profil/' . $likerId) }}">{{ $notification }} <br>
                            Veuillez consulter son profil.</a></li>
                    @php
                        $alreadyNotifiedUsers[] = $likerId;
                    @endphp
                @endif
            @endforeach
        @endif
    </ul>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="get-started-btn">Déconnexion</button>
    </form>
    
    @else
    <style>
    .button-container {
        display: flex;
    }
</style>

<div class="button-container">
    <a href="{{ url('/register') }}" class="get-started-btn scrollto" style="color: white;">Inscription</a>
    <a href="{{ url('/login') }}" class="get-started-btn scrollto" style="color: white;">Connexion</a>
</div>


    @endauth
</li>




        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
    </div>  
  </header><!-- End Header -->

  <div class="container">
  <div class="row">
    <div class="col-12">
      <div class="scrolling-flags-container" onmouseover="stopAnimation()" onmouseout="startAnimation()" style="margin-top: 4rem; margin-bottom: -2rem;">
        @for ($i = 1; $i <= 56; $i++)
        <img src="{{ asset('assets/img/drap/' . $i . '.png') }}" alt="Drapeau {{ $i }}" class="flag-image">
        @endfor
      </div>
    </div>
  </div>
</section><!-- End Hero -->

<!-- End Hero -->


   <style>
    .scrolling-flags-container {
      flex-wrap: nowrap;
      display: flex; /* Utilisation de flexbox pour aligner les drapeaux horizontalement */
      justify-content: center;
      
      margin-top: 2rem; /* Espace au-dessus des drapeaux */



      animation: scroll 60s linear infinite; /* Animation de défilement */
    }

    .flag-image {
      width: 50px; /* Ajustez cette valeur en fonction de vos besoins */
    height: auto;
    margin: 5px; /* Ajoutez de la marge entre les images */
    }

    @media screen and (max-width: 768px) {
    .flag-image {
        width: 50px; /* Réduisez la taille des images pour les écrans plus petits */
    }
  }
  @keyframes scroll {
  0% {
    transform: translateX(0); /* Départ du défilement */
  }
  100% {
    transform: translateX(calc(-50px * 56)); /* Fin du défilement - défilement de 56 drapeaux */
  }
}

   
  </style>
  