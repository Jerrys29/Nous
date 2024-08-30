
<?php $__env->startSection('document'); ?>
<h2 style="text-align: center;">Trouver votre Partenaire ici</h2>
<main id="main">

  <section id="about" class="about">
    <div class="container">
      <div class="row">
        <!-- User Profile Cards -->
        <div class="col-lg-8">
          <div class="row">
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 mb-3">
              <a href="<?php echo e(url('/profil/' . $user->id)); ?>" style="text-decoration: none; color: inherit; cursor: auto;">
                <div class="card">
                  <img src="<?php echo e(asset('storage/' . $user->photo1)); ?>" class="card-img-top" alt="Profile Image <?php echo e($user->id); ?>">
                  <div class="card-body">
                    <h5 class="card-title"><?php echo e($user->name); ?></h5>
                    <div class="like-container">
                      <?php if(auth()->user() && auth()->user()->hasLikedProfile($user->id)): ?>
                      <a href="<?php echo e(route('unlike-profile', ['profile_id' => $user->id])); ?>" onclick="event.preventDefault(); document.getElementById('unlike-form-<?php echo e($user->id); ?>').submit();">
                        <svg class="like-svg" width="20" height="20" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                          <path fill="#BE1931" d="M2.067 11.319C2.067 2.521 14.251-.74 18 9.445C21.749-.741 33.933 2.52 33.933 11.319C33.933 20.879 18 33 18 33S2.067 20.879 2.067 11.319" />
                        </svg>
                      </a>
                      <form id="unlike-form-<?php echo e($user->id); ?>" action="<?php echo e(route('unlike-profile', ['profile_id' => $user->id])); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                      </form>
                      <?php else: ?>
                      <a href="<?php echo e(route('like-profile', ['profile_id' => $user->id])); ?>" onclick="event.preventDefault(); document.getElementById('like-form-<?php echo e($user->id); ?>').submit();">
                        <i class="bi bi-heart like-button" style="width:50px; height: 50px;"></i>
                      </a>
                      <?php endif; ?>
                      <form id="like-form-<?php echo e($user->id); ?>" action="<?php echo e(route('like-profile', ['profile_id' => $user->id])); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                      </form>

                      <?php if(auth()->user() && auth()->user()->paiement == 0): ?>
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
                                  <div class="text-center mt-2"> <img src="<?php echo e(asset('assets/img/nous_logo.png')); ?>" width="200"> </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="text-white mt-4">
                                    <div class="mt-2"> <span class="intro-2">Veuillez payer votre abonnement mensuel pour communiquer avec votre potentiel partenaire.</span> </div>
                            
                                    <script amount="981" callback="<?php echo e(url('/mettre-a-jour-paiement')); ?>" data="" position="right" theme="red" sandbox="false" key="de9c4e671f1c676a8613e0a567252e182c8fc52c" src="https://cdn.kkiapay.me/k.js"></script>

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
                                        xhr.open('GET', '<?php echo e(url("/effectuer-paiement")); ?>', true);
                                        xhr.onreadystatechange = function() {
                                          if (xhr.readyState === XMLHttpRequest.DONE) {
                                            if (xhr.status === 200) {
                                              console.log('Paiement Kkiapay effectué avec succès.');
                                              localStorage.removeItem('redirectionInProgress');
                                              var numeroWhatsApp = '<?php echo e($user->numero); ?>';
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
                      <?php else: ?>
                      <a href="https://wa.me/<?php echo e($user->numero); ?>" target="_blank"><i class="bi bi-whatsapp whatsapp-icon"></i></a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
          </div>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Documents\Abitech2024\Nous\resources\views/nous/profils.blade.php ENDPATH**/ ?>