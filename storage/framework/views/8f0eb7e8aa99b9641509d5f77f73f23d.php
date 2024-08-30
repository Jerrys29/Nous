  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3><img src="<?php echo e(asset('assets/img/NOUS LOGO 1_Plan de travail 1.png')); ?>" alt="" style="width: 100px;height: 100px;"></h3>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Liens importants</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i><a href="<?php echo e(('/')); ?>" class="logo me-auto">Accueil</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="<?php echo e(('/profils')); ?>">Trouver un partenaire</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="<?php echo e(('/terms')); ?>">Termes et Conditions</a></li>
              <li>
                Vous aimez ce site ?
                <br>
                Donnez votre
              </li>
              <li> <a href="<?php echo e(('/avis')); ?>" class="logo me-auto">
                  <i class="bx bx-chevron-right"></i> Avis
                </a> </li>

            </ul>
          </div>


          <div class="col-lg-3 col-md-6 col-sm-12 footer-newsletter">

            <div>
              <a href="<?php echo e(('/index')); ?>" class="btn-get-started scrollto">ESPACE KARAOKE</a>
            </div>
          </div>


          <div class="col-lg-3 col-md-6 col-sm-12 " style="position: relative;">
            <div id="chatContainer" style="position: relative;">
              <button id="toggleChat" class="btn-get-started scrollto">Discuter avec un modérateur </button>
              <div class="chatbox" style="position: absolute; top: -250px; display: none;">
                <section class="chatbox">
                  <div class="container d-flex justify-content-center">
                    <div class="card mt-5">
                      <div class="d-flex flex-row justify-content-between p-3 adiv text-white" style="height: 60px;">
                        <i class="fas fa-chevron-left"></i>
                        <span class="pb-3">Nous vous répondrons dans quelques instants...</span>
                        <i id="closePopup" class="fas fa-times"></i>
                      </div>
                      <section class="chat-window" id="chat-window">
                        <!-- Message de bienvenue -->
                        <div class="message" id="welcome-message">Bienvenue ! Veuillez fournir votre nom et numéro de téléphone.</div>

                      </section>
                      <form class="chat-input" id="welcome-form">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Votre nom" required>
                        <input type="tel" class="form-control" name="numero" id="numero" placeholder="Votre numéro de téléphone" required>
                        <button type="submit" class="btn btn-sm btn-danger">Envoyer</button>
                      </form>
                      <form class="chat-input" id="chat-form" style="display: none;">
                        <div class="form-group px-3">
                          <textarea class="form-control" rows="5" placeholder="Type your message" id="message" required></textarea>
                          <button type="submit" class="btn btn-primary">Envoyer</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </section>
              </div>
            </div>
          </div>

          <script>
            // Script pour afficher/masquer la section chatbox
            $(document).ready(function() {
              // Cacher la chatbox au chargement de la page
              $('.chatbox').hide();
              $('#closePopup').click(function() {
                // Masquer le popup
                $('.chatbox').hide();
              });
              // Déclencher l'ouverture/fermeture de la chatbox lors du clic sur le bouton
              $('#toggleChat').click(function() {
                $('.chatbox').toggle();
              });
            });
          </script>


          <script>
            $(document).ready(function() {
              // Soumettre le formulaire de bienvenue
              $('#welcome-form').submit(function(event) {
                event.preventDefault(); // Empêcher le formulaire de se soumettre normalement

                var name = $('#name').val(); // Récupérer le nom
                var numero = $('#numero').val(); // Récupérer le numéro de téléphone

                // Envoyer les données au serveur pour traitement
                $.ajax({
                  type: 'POST',
                  url: '<?php echo e(route("discussion.store")); ?>',
                  data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    name: name,
                    numero: numero
                  },
                  success: function(response) {
                    // Masquer le formulaire de bienvenue
                    $('#welcome-form').hide();
                    $('#welcome-message').hide();
                    // Afficher le formulaire de chat
                    $('#chat-form').show();

                    // Mettre à jour les champs avec le nom et le numéro
                    $('#name').val(response.name);
                    $('#numero').val(response.numero);


                    // Afficher les messages existants dans la fenêtre de discussion
                    response.messages.forEach(function(message) {
                      var html = '';
                      if (message instanceof Object && message.hasOwnProperty('message')) {
                        // Afficher un message de l'utilisateur
                        html = '<div class="d-flex flex-row p-3">' +
                          '<img src="https://img.icons8.com/color/48/000000/circled-user-female-skin-type-7.png" width="30" height="30">' +
                          '<div class="chat ml-2 p-3">' + message.message + '</div>' +
                          '</div>';
                      } else if (message instanceof Object && message.hasOwnProperty('contenu')) {
                        // Afficher une réponse du modérateur
                        html = '<div class="d-flex flex-row p-3">' +
                          '<div class="bg-white mr-2 p-3"><span class="text-muted">' + message.contenu + '</span></div>' +
                          '<img src="https://img.icons8.com/color/48/000000/circled-user-male-skin-type-7.png" width="30" height="30">' +
                          '</div>';
                      }
                      $('#chat-window').append(html);
                    });

                    // Afficher un message de bienvenue
                    $('#chat-window').append('<div class="message">Bienvenue, ' + $('#name').val() + ' ! Vous pouvez désormais commencer à discuter.</div>');
                  },

                });
              });


              $('#chat-form').submit(function(event) {
                event.preventDefault(); // Empêcher le formulaire de se soumettre normalement

                var message = $('#message').val(); // Récupérer le message

                $.ajax({
                  type: 'POST',
                  url: '<?php echo e(route("discussion.send")); ?>',
                  data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    message: message,
                    name: $('#name').val(), // Récupérer le nom
                    numero: $('#numero').val() // Récupérer le numéro de téléphone
                  },
                  success: function(response) {

                    // Mettre à jour la fenêtre de chat avec le message envoyé
                    var chatMessage = '<div class="d-flex flex-row p-3">' +
                      '<div class="bg-white mr-2 p-3"><span class="text-muted">' + response.message + '</span></div>' +
                      '<img src="https://img.icons8.com/color/48/000000/circled-user-male-skin-type-7.png" width="30" height="30">' +
                      '</div>';
                    $('#chat-window').append(chatMessage);

                    // Effacer le champ de saisie après l'envoi du message
                    $('#message').val('');
                  }
                });
              });
            });
            var animation; // Variable pour stocker l'animation

            function stopAnimation() {
              var flagsContainer = document.querySelector('.scrolling-flags-container');
              animation = flagsContainer.style.animation; // Sauvegarde l'animation actuelle
              flagsContainer.style.animation = 'none'; // Arrête l'animation
            }

            function startAnimation() {
              var flagsContainer = document.querySelector('.scrolling-flags-container');
              flagsContainer.style.animation = animation; // Redémarre l'animation
            }
          </script>


          <style>
            .card {
              width: 300px;
              border: none;
              border-radius: 15px;
            }

            .adiv {
              background: #04CB28;
              border-radius: 15px;
              border-bottom-right-radius: 0;
              border-bottom-left-radius: 0;
              font-size: 12px;
              height: 46px;
            }

            .chat {
              border: none;
              background: #E2FFE8;
              font-size: 10px;
              border-radius: 20px;
            }

            .bg-white {
              border: 1px solid #E7E7E9;
              font-size: 10px;
              border-radius: 20px;
            }

            .myvideo img {
              border-radius: 20px
            }

            .dot {
              font-weight: bold;
            }

            .form-control {
              border-radius: 12px;
              border: 1px solid #F0F0F0;
              font-size: 8px;
            }

            .form-control:focus {
              box-shadow: none;
            }

            .form-control::placeholder {
              font-size: 8px;
              color: #C4C4C4;
            }
          </style>
        </div>
      </div>
    </div>

    <div class="container d-md-flex py-4">

      <div class="me-md-auto text-center text-md-start">
        <div class="copyright">
          &copy; Copyright <strong><span>NOUS</span></strong>. Tous droits réservés
        </div>
      </div>
      <div class="social-links text-center text-md-end pt-3 pt-md-0">
        <a href="http://facebook.com/nous.meet" class="facebook" target="_blank"><i class="bx bxl-facebook"></i></a>
        <a href="https://web.whatsapp.com/" class="whatsapp" target="_blank"><i class="bx bxl-whatsapp"></i></a>
        <a href="mailto:example@gmail.com" class="gmail" target="_blank"><i class="bx bxl-google"></i></a>

      </div>
    </div>
  </footer><!-- End Footer --><?php /**PATH C:\Users\HP\Documents\Abitech2024\Nous\resources\views/components/footer.blade.php ENDPATH**/ ?>