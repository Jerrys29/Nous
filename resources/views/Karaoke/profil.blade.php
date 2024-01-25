<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Profil de Cathérine</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/nous_logo.png" rel="icon">
  <link href="assets/img/nous_logo.png" rel="apple-touch-icon">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
  <section class="d-flex align-items-center">
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center">
      <div class="container d-flex align-items-center">
      <h1 class="logo me-auto"><img src="assets/img/nous_logo.png" alt=""></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt=""></a>-->

        <nav id="navbar" class="navbar order-last order-lg-0">
          <ul>
            <li><a class="nav-link scrollto active" href="persospace.html">Trouver votre partenaire</a></li>
            <li class="dropdown"><a href="#"><span>Langues</span> <i class="bi bi-chevron-down"></i></a>
              <ul>
                <li><a href="#">Francais</a></li>
                <li><a href="#">Anglais</a></li>
              </ul>
            </li>
          </ul>
          <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
      </div>
    </header><!-- End Header -->

  </section><!-- End Hero -->
  <h2 style="text-align: center;">Profil de Cathérine</h2>
  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 mx-auto mb-3">
            <div class="card">
              <div class="card-body text-center">
                <img src="assets\img\tabs-3.jpg" class="avatar img-circle img-thumbnail" alt="avatar">
                <h6>Modifier la photo...</h6>
                <input type="file" class="text-center center-block file-upload">
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Nom: Cathérine</li>
                <li class="list-group-item">Âge: 25 ans</li>
                <li class="list-group-item">Ville: Cotonou</li>
              </ul>
            </div>
          </div>

          <div class="col-lg-8">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#home">À propos de moi</a></li>
              <li><a data-toggle="tab" href="#messages">Photos</a></li>
              <li><a data-toggle="tab" href="#settings">Paramètres</a></li>
            </ul>

            <div class="tab-content">
              <div class="tab-pane active" id="home">
                <hr>
                <form class="form" action="##" method="post" id="registrationForm">
                  <div class="form-group">
                    <div class="col-xs-12">
                      <label for="about"><h4>À propos de moi</h4></label>
                      <textarea class="form-control" name="about" id="about" placeholder="Parlez de vous..." rows="5"></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-xs-12">
                      <label for="interests"><h4>Centres d'intérêt</h4></label>
                      <input type="text" class="form-control" name="interests" id="interests" placeholder="Centres d'intérêt (séparés par des virgules)">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-xs-12">
                      <br>
                      <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Enregistrer</button>
                    </div>
                  </div>
                </form>
                <hr>
              </div>

              <div class="tab-pane" id="messages">
                <h2>Galerie de photos</h2>
                <!-- Ajoutez ici la section pour afficher les photos -->
              </div>

              <div class="tab-pane" id="settings">
                <h2>Paramètres du compte</h2>
                <hr>
                <form class="form" action="##" method="post" id="accountSettingsForm">
                  <!-- Ajoutez ici les champs pour les paramètres du compte (nom, âge, ville, etc.) -->
                </form>
                <hr>
                <div class="form-group">
                  <div class="col-xs-12">
                    <button class="btn btn-lg btn-success pull-right" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Sauvegarder</button>
                  </div>
                </div>
              </div>

            </div><!--/tab-content-->

          </div><!--/col-9-->
        </div><!--/row-->

      </div><!--/container-->
    </section><!-- End About Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <div class="row d-flex align-items-center">
        <div class="col-lg-12 text-lg-left text-center">
          <p>&copy; 2024 Nous. Tous droits réservés.</p>
        </div>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
