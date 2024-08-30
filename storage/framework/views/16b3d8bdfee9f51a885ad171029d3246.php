<section class="d-flex align-items-center">
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center">
      <a href="<?php echo e(('/')); ?>" class="logo me-auto"><img src="<?php echo e(asset('assets/img/nous_logo.png')); ?>" alt=""></a>
      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="<?php echo e(('/profils')); ?>">Trouver votre partenaire</a></li>
          <?php if(auth()->check() && auth()->user()->role === 'nous'): ?>
          <a href="<?php echo e(url('/edit')); ?>" class="get-started-btn scrollto" style="color: white;">Mon profil</a>
          <a href="<?php echo e(url('/notification')); ?>" class="get-started-btn scrollto" style="color: white;">Notifications</a>

          <li class="dropdown">
            <form method="POST" action="<?php echo e(route('logout')); ?>">
              <?php echo csrf_field(); ?>
              <button type="submit" class="get-started-btn scrollto">Déconnexion</button>
            </form>
          </li>
          <?php endif; ?>

          <?php if(!auth()->check() || (auth()->check() && auth()->user()->role !== 'nous')): ?>
          <li class="button-container">
            <a href="<?php echo e(url('/register')); ?>" class="get-started-btn scrollto" style="color: white;">Inscription</a>
            <a href="<?php echo e(url('/login')); ?>" class="get-started-btn scrollto" style="color: white;">Connexion</a>
          </li>
          <?php endif; ?>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
    </div>
  </header><!-- End Header -->
</section><!-- End Hero -->
<style>
  .button-container {
    display: flex;
    list-style-type: none;
    padding: 0;
  }

  .button-container a {
    margin-right: 10px;
    /* Ajoutez une marge entre les boutons pour l'espace */
  }
</style>

</section><!-- End Hero -->

<!-- End Hero --><?php /**PATH C:\Users\HP\Documents\Abitech2024\Nous\resources\views/components/header.blade.php ENDPATH**/ ?>