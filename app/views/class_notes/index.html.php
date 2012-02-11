<?php $this->title($model->course->getName()); ?>
<?php $user = $model->professor->getUser(); ?>
<?php $this->title($model->professor->getUser()->getFullName()); ?>
<div class="row profile_header">
	<?php echo $this->_render('element', 'profile_courseview'); ?>
</div>
<div class="row shell">
	<div class="span4 shell_menu">
		<?php echo $this->_render('element', 'course_view_nav'); ?>
	</div>
	<div class="span12 shell_content">
		<h3>Class Notes</h3>
		<div>
			<?php 
			if($model->classnotes){ ?>
				<ul>
					<?php foreach($model->classnotes as $note){ ?>
						<li>
						<?php echo $this->html->link($note->getName(), '/professors/'. $user->getUserName() .'/classnotes/show/'. $note->getId()); ?>
						</li>
						
					<?php } ?>
				</ul>
			<?php } else{ ?>
				<p>This class has no published class notes.</p>
			<?php } ?>
			
		</div>
	</div>
	<div class="clearfix"></div>
</div>