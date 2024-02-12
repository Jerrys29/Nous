<div class="min-height-300 bg-primary position-absolute w-100"></div>
<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
  <div class="container-fluid py-1 px-3">

    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
      <div class="ms-md-auto pe-md-3 d-flex align-items-center">
        <div class="input-group">
          <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
          <input type="text" class="form-control" id="searchInput" placeholder="Type here..." oninput="search()">
        </div>
      </div>
     
    </div>
  </div>
  <form method="POST" action="{{ route('Deco') }}">
                @csrf
                <div class="d-grid">
                    <button type="submit" class="btn btn-danger btn-block">Déconnexion</button>
                </div>
            </form>
</nav>
<!-- End Navbar -->
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
   
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user text-primary"></i>
                    </div>
                    <span class="nav-link-text ms-1">Utilisateurs</span>
                </a>
                
                <ul class="nav-dropdown">
                <li class="nav-item">
                        <a class="nav-link" href="{{ route('avisadmin') }}">
                            <span class="ms-2">Avis</span>
                        </a>
                    </li>
                        

                    <li class="nav-item">
                        <a class="nav-link" href="{{'NousUsers'}}">
                            <span class="ms-2">Nous</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{'KaraokeUsers'}}">
                            <span class="ms-2">Karaoke</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{'utilisateurs'}}">
                            <span class="ms-2">Visiteurs</span>
                        </a>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Compte non activé/bloqué</span>
                </a>
            </li>

                <ul class="nav-dropdown">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('LokNousUsers') }}">
                            <span class="ms-2">Nous</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('LokKaraokeUsers') }}">
                            <span class="ms-2">Karaoke</span>
                        </a>
                    </li>
                    
                </ul>
            </li>

            <!-- <li class="nav-item">
                <a class="nav-link" href="#">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Paiement</span>
                </a>
                <ul class="nav-dropdown">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('LokNousUsers') }}">
                            <span class="ms-2">Nous</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('LokKaraokeUsers') }}">
                            <span class="ms-2">Karaoke</span>
                        </a>
                    </li>
                </ul>
            </li> -->

        </ul>
        

    
    </div>
    
</aside>
 
