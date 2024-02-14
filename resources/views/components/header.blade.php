<section class="d-flex align-items-center">
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center">
      <a href="{{('/')}}" class="logo me-auto"><img src="{{asset('assets/img/nous_logo.png')}}" alt=""></a>
      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="{{('/profils')}}">Trouver votre partenaire</a></li>
          @if(auth()->check() && auth()->user()->role === 'nous')
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
              <button type="submit" class="get-started-btn scrollto">Déconnexion</button>
            </form>
          </li>
          @endif

          @if(!auth()->check() || (auth()->check() && auth()->user()->role !== 'nous'))
          <li class="button-container">
            <a href="{{ url('/register') }}" class="get-started-btn scrollto" style="color: white;">Inscription</a>
            <a href="{{ url('/login') }}" class="get-started-btn scrollto" style="color: white;">Connexion</a>
          </li>
          @endif
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
    </div>
  </header><!-- End Header -->
</section><!-- End Hero -->
<style>.button-container {
  display: flex;
  list-style-type: none;
  padding: 0;
}

.button-container a {
  margin-right: 10px; /* Ajoutez une marge entre les boutons pour l'espace */
}
</style>