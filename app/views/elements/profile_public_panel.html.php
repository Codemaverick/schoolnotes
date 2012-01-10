<?php $depts = $model->professor->getDepartment(); ?> 
<div class="image_placeholder">
		
</div>
<div class="mini_profile">
	<?php echo $model->professor->getUser()->getFullName(); ?>
	<?php if($model->profile){ ?>
		<p><?= $model->profile->getTitle() ?><br/>
		<?php if(count($depts) > 0){ 
			 		foreach($depts as $d){ ?>
						<?= $d->getName(); ?>
				<?php } 
			 } ?></p>
	<?php } ?>
</div>