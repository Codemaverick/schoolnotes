<div class="image_placeholder">
		
</div>
<div class="mini_profile">
	<?php echo $model->professor->getUser()->getFullName(); ?>
	<p><?= $model->profile->getTitle() ?></p>
	<p><?php if(count($model->professor->getDepartment()) > 0){ ?>
		<?php echo $model->professor->getDepartment()->getName(); ?>
	</p><?php } ?>
</div>