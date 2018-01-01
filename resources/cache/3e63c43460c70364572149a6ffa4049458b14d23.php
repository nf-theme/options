<div id="nf-theme-option">
	<?php if($should_flash): ?>
		<div class="alert alert-success" role="alert">
		  <strong>Well done!</strong> Options are saved successfully.
		</div>
	<?php endif; ?>
    <div class="nto-header">
        <h4 class="nto-title bd-title">Theme Configuration</h4>
        <ul class="nto-tabs nav nav-tabs">
            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="nto-item nav-item">
                <a class="<?php echo e($manager->isPage($page->name) ? 'nto-menu-link-link nav-link active' : 'nto-menu-link-link nav-link'); ?>" href="<?php echo e($manager->getTabUrl($page->name)); ?>"><?php echo e($page->name); ?></a>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <div class="nto-content">
        <div class="nto-form">
            <form method="POST" name="nto_form" action="<?php echo e(admin_url('admin-post.php')); ?>">
            	<input type="hidden" value="nto_save" name="action" required>
            	<input type="hidden" value="<?php echo e($current_page->name); ?>" name="page" required>
                <?php $__currentLoopData = $current_page->fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $field->render(); ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Save">
                    <button name="nto_cancel" class="btn btn-secondary" onclick="document.location.reload(); return false;">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
