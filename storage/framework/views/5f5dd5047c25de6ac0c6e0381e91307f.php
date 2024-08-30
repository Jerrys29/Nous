<?php $__env->startSection('document'); ?>
    <main id="main">
        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container">
                <div class="row" data-aos="fade-up">
                    <div class="col-lg-6 mx-auto">
                        <div class="text-center" >
                            <strong>VOS INFORMATIONS NE SERONT PAS DIVULGUÉES</strong> <br>
                            <i class="fa fa-info-circle"></i> L'accès à la discussion est payante(1000FCFA) <br>

                        </div>
                        <form action="<?php echo e(route('paiementV', ['id' => $userId])); ?>" method="POST" class="p-4 p-md-5 border rounded">
                            <?php echo csrf_field(); ?>
                            ENREGISTRER VOUS POUR DISCUTER
                            <div class="form-group" style="margin-top: 1rem;">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Entrez votre nom complet" required style="font-size:1rem; border: 4px solid #F0F0F0; text-align: center;">
                            </div>
                            <div class="form-group">
                                <label for="numero" class="form-label">Numéro</label>
                                <input type="text" name="numero" class="form-control" id="numero" placeholder="Entrez votre numéro" required style="font-size:1rem; border: 4px solid #F0F0F0;text-align: center;">
                            </div>
                            <button type="submit" id="submitBtn" class="btn btn-primary">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>
        </section><!-- End Contact Section -->

        
    </main><!-- End #main -->
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

    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.karaoke', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Documents\Abitech2024\Nous\resources\views/Karaoke/formulaire.blade.php ENDPATH**/ ?>