<div class="min-height-300 bg-primary position-absolute w-100"></div>
<!-- Navbar -->
<main class="main-content position-relative border-radius-lg ">
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
        <div class="container-fluid py-1 px-3">

            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group">
                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                <input type="text" class="form-control" id="searchInput" placeholder="Type here..." oninput="search()">
                </div>
            </div>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line bg-white"></i>
                        <i class="sidenav-toggler-line bg-white"></i>
                        <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                    </a>
                </li> 

            </div>
        </div>
        <form method="POST" action="<?php echo e(route('Deco')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger btn-block">Déconnexion</button>
                        </div>
                    </form>
        </nav>
</main>
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">

    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul>
        <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('avisadmin')); ?>">
                            <span class="ms-2">Avis</span>
                        </a>
                </li>
        <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('utilisateurs')); ?>">
                            <span class="ms-2">Visiteurs</span>
                        </a>
                    </li>
        </ul>
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
                        <a class="nav-link" href="<?php echo e(route('NousUsers')); ?>">
                            <span class="ms-2">Nous</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('KaraokeUsers')); ?>">
                            <span class="ms-2">Karaoke</span>
                        </a>
                    </li>
                    
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
                        <a class="nav-link" href="<?php echo e(route('LokNousUsers')); ?>">
                            <span class="ms-2">Nous</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('LokKaraokeUsers')); ?>">
                            <span class="ms-2">Karaoke</span>
                        </a>
                    </li>
                    
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link active" href="<?php echo e(route('messages')); ?>">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Messages</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" href="<?php echo e(route('publicites')); ?>">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Publicités</span>
                </a>
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
                        <a class="nav-link" href="<?php echo e(route('LokNousUsers')); ?>">
                            <span class="ms-2">Nous</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('LokKaraokeUsers')); ?>">
                            <span class="ms-2">Karaoke</span>
                        </a>
                    </li>
                </ul>
            </li> -->

        </ul>



    </div>
    <script>
        var inactivityTimeout = 30 * 60 * 1000;

        var timeout;

        function resetTimer() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
              window.location.href = "<?php echo e(route('login')); ?>";
            }, inactivityTimeout);
        }

        document.addEventListener('mousemove', resetTimer);
        document.addEventListener('keypress', resetTimer);
        document.addEventListener('scroll', resetTimer);

        resetTimer(); // Initialise le minuteur lors du chargement de la page
    </script>
</aside>


<!-- End Navbar --><?php /**PATH C:\Users\HP\Documents\Abitech2024\Nous\resources\views/components/adminhead.blade.php ENDPATH**/ ?>