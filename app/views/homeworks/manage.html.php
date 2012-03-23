<?php $this->title($model->course->getName()); ?>
<?php $user = $model->professor->getUser(); ?>
<?php $this->title($model->professor->getUser()->getFullName() . " - " . $model->course->getName() . " - " . $model->coursesection->getSection()); ?>
<div class="row profile_header">
	<?php echo $this->_render('element', 'profile_manage'); ?>
</div>
<div class="shell">
	<div>
			<h2>Homeworks</h2>
			<?php 
			if($model->homeworks){ ?>
				<ul>
					<?php foreach($model->homeworks as $hw){ ?>
						<li>
						<?php echo $this->html->link($hw->getName(), '/dashboard/homeworks/details/'. $hw->getId()); ?>
							<br/>Due: <?php echo $hw->getDateDue(); ?>
						</li>
						
					<?php } ?>
				</ul>
			<?php } else{ ?>
				<p>This class has no homeworks.</p>
			<?php } ?>	
		</div>
</div>