<?php $__env->startSection('document'); ?>
  <main class="main-content position-relative border-radius-lg ">
   
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Comptes utilisateurs Nous</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nom Complet</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Numéro</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pseudo</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ville</th>
                    <th class="text-secondary opacity-7">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm"><?php echo e($user->name); ?></h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0"><?php echo e($user->numero); ?></p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0"><?php echo e($user->pseudo); ?></p>
                        </td>
                        <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold"><?php echo e($user->town); ?></span>
                        </td>
                        
                        <td class="align-middle">
                        <form method="post" action="<?php echo e(route('block.user', ['id' => $user->id, 'redirect' => 'Noussers'])); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('POST'); ?>
                                    <?php if(!$user->active): ?>
                                        <button type="submit" class="btn btn-danger btn-sm">Bloquer</button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-danger btn-sm" disabled>Bloquer</button>
                                    <?php endif; ?>
                                </form>
                        </td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
              </div>
            </div>
          </div>
        </div>
      </div>
   
    
    </div>
  </main>
   
  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Documents\Abitech2024\Nous\resources\views/Admin/NousUsers.blade.php ENDPATH**/ ?>