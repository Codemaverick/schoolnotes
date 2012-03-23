<?php $this->title($model->course->getName()); ?>
<?php $user = $model->professor->getUser(); ?>
<?php $this->title($model->professor->getUser()->getFullName()); ?>
<div class="row profile_header">
	<?php echo $this->_render('element', 'profile_manage'); ?>
</div>
<div class="shell">
	
		<h2>Class Notes</h2>
		<div>
			<?php 
			if($model->classnotes){ ?>
				<ul>
					<?php foreach($model->classnotes as $note){ ?>
						<li>
						<?php echo $this->html->link($note->getName(), '/dashboard/classnotes/details/'. $note->getId()); ?>
						</li>
						
					<?php } ?>
				</ul>
			<?php } else{ ?>
				<p>This class has no published class notes.</p>
			<?php } ?>	
		</div>
</div>