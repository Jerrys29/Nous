

<?php $__env->startSection('document'); ?>
<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 mb-4 d-flex align-items-center justify-content-between flex-wrap">
                        <h6>Publicité</h6>
                        <div class="buttons d-flex align-items-center">
                            <form action="<?php echo e(route('searchpub')); ?>" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control mx-2" placeholder="Rechercher">
                                <button class="btn btn-primary my-0 me-2" type="submit">
                                    <i class="fa fa-search me-2"></i>
                                    Filter
                                </button>
                            </form>
                            <a class="btn btn-success my-0" href="<?php echo e(route('publicite.create.view')); ?>">
                                <i class="fa fa-plus me-2"></i>
                                Ajouter
                            </a>
                        </div>



                    </div>
                    <div class="card-body px-2 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Nom de l'entreprise</th>
                                        <th>Titre</th>
                                        <th>Details</th>
                                        <th>Statut</th>
                                        <th>Créé le</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $publicites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $publicite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($publicite->name); ?></td>
                                        <td><?php echo e(Str::limit($publicite->offre, 20)); ?></td>
                                        <td><?php echo e(Str::limit(strip_tags($publicite->detail), 20)); ?></td>


                                        <td>    
                                            <span class="badge bg-gradient-<?php echo e($publicite->statut == 1 ? 'success' : 'danger'); ?>">
                                                <?php echo e($publicite->statut == 1 ? 'Actif' : 'Inactif'); ?>

                                            </span>
                                        </td>

                                        <td><?php echo e($publicite->created_at); ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">

                                                <a class="btn p-2 d-flex align-items-center me-1" href="<?php echo e(route('publicites.edit', $publicite->id)); ?>" title="Modifier">
                                                    <i class="fa fa-edit text-primary cursor-pointer"></i>
                                                </a>
                                                <form action="<?php echo e(route('publicites.toggle', $publicite->id)); ?>" method="post">
                                                    <?php echo csrf_field(); ?>
                                                    <button class="btn p-2 d-flex align-items-center me-1" type="submit" data-bs-toggle="tooltip" title="<?php echo e($publicite->statut == '1' ? 'Désactiver' : 'Activer'); ?>">
                                                        <i class="fa <?php echo e($publicite->statut == '1' ? 'fa-times' : 'fa-check'); ?> text-<?php echo e($publicite->statut == '1' ? 'danger' : 'success'); ?> cursor-pointer"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Aucune publicité n'a été enregistrée.</td>
                                    </tr>
                                    <?php endif; ?>
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
<?php echo $__env->make('templates.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Documents\Abitech2024\Nous\resources\views/Admin/publicite/index.blade.php ENDPATH**/ ?>