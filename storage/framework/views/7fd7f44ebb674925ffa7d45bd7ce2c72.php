<section class="d-flex align-items-center">
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center">

      <a href="<?php echo e(('/')); ?>" class="logo me-auto"><img src="<?php echo e(asset('assets/img/nous_logo.png')); ?>" alt=""></a>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
        <li><a class="nav-link scrollto active" href="<?php echo e(('/profils')); ?>">Trouver votre partenaire</a></li>
          <!-- <li class="dropdown"><a href="#"><span>Langues</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Francais</a></li>
              <li><a href="#">Anglais</a></li>
            </ul>
          </li> -->
          


        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
    </div>
  </header><!-- End Header -->
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

</section><!-- End Hero --><?php /**PATH C:\Users\HP\Documents\Abitech2024\Nous\resources\views/components/headerKa.blade.php ENDPATH**/ ?>