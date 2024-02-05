<div class="min-height-300 bg-primary position-absolute w-100"></div>
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
   
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" href="{{'utilisateurs'}}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Utilisateurs</span>
                </a>
                <ul class="nav-dropdown">
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
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Compte</span>
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
            </li>

            <li class="nav-item">
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
            </li>

        </ul>
    </div>
</aside>
