<?php $__env->startSection('document'); ?>
<main id="main">
  <section id="about" class="about">
    <div class="container">
      <div class="row">
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="col-lg-3 mb-4">
            <a href="<?php echo e(url('/Karaokeprofils/' . $user->id)); ?>" style="text-decoration: none; color: inherit;">
              <div class="card h-100 custom-card d-flex justify-content-center align-items-center">
                <div style="width: 100%; height: 18rem; overflow: hidden;">
                  <!-- Vérifie les cinq champs de photos et affiche la première photo valide -->
                  <?php if($user->photo1 && Storage::disk('public')->exists($user->photo1)): ?>
                    <img src="<?php echo e(asset('storage/' . $user->photo1)); ?>" class="card-img-top" style="object-fit: cover; width: 100%; height: 100%;" alt="Profile Image <?php echo e($user->id); ?>">
                  <?php elseif($user->photo2 && Storage::disk('public')->exists($user->photo2)): ?>
                    <img src="<?php echo e(asset('storage/' . $user->photo2)); ?>" class="card-img-top" style="object-fit: cover; width: 100%; height: 100%;" alt="Profile Image <?php echo e($user->id); ?>">
                  <?php elseif($user->photo3 && Storage::disk('public')->exists($user->photo3)): ?>
                    <img src="<?php echo e(asset('storage/' . $user->photo3)); ?>" class="card-img-top" style="object-fit: cover; width: 100%; height: 100%;" alt="Profile Image <?php echo e($user->id); ?>">
                  <?php elseif($user->photo4 && Storage::disk('public')->exists($user->photo4)): ?>
                    <img src="<?php echo e(asset('storage/' . $user->photo4)); ?>" class="card-img-top" style="object-fit: cover; width: 100%; height: 100%;" alt="Profile Image <?php echo e($user->id); ?>">
                  <?php elseif($user->photo5 && Storage::disk('public')->exists($user->photo5)): ?>
                    <img src="<?php echo e(asset('storage/' . $user->photo5)); ?>" class="card-img-top" style="object-fit: cover; width: 100%; height: 100%;" alt="Profile Image <?php echo e($user->id); ?>">
                  <?php else: ?>
                    <!-- Icône d'utilisateur par défaut si aucune photo n'est trouvée -->
                    <i class="bi bi-person-fill" style="font-size: 15rem;"></i>
                  <?php endif; ?>
                </div>
                <div class="card-body text-center">
                  <h5 class="card-title"><?php echo e($user->pseudo); ?></h5>
                  <div class="like-container">
                    <?php if(auth()->user() && auth()->user()->paiement == 0): ?>
                      <a href="<?php echo e(url('/visiteur/' . $user->id)); ?>" target="_blank">
                        <button type="button" class="btn btn-success">
                          <i class="bi bi-whatsapp whatsapp-icon launch"></i> Discuter
                        </button>
                      </a> 
                    <?php else: ?>
                      <a href="<?php echo e(url('/visiteur/' . $user->id)); ?>" target="_blank">
                        <button type="button" class="btn btn-success">
                          <i class="bi bi-whatsapp whatsapp-icon launch"></i> Discuter
                        </button>
                      </a> 
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </a>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  </section>
</main>
<style>
  /* Custom CSS for cards */
.custom-card {
  border: 1px solid #dee2e6;
  border-radius: 10px;
  transition: transform 0.3s ease-in-out;
}

.custom-card:hover {
  transform: translateY(-5px);
}

.custom-card .card-img-top {
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}

.custom-card .card-title {
  font-size: 18px;
  margin-bottom: 10px;
}

.custom-card .btn {
  width: 100%;
}
</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.karaoke', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Documents\Abitech2024\Nous\resources\views/Karaoke/index.blade.php ENDPATH**/ ?>