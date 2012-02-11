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
		<h3>Homeworks</h3>
		<h3><?php echo $homeworks[0]->getCourseSection();</h3>
		<div>
			<ul>
				<?php foreach($homeworks as $hw){ ?>
					<li><?php echo anchor('dashboard/homeworks/show/'.$hw->getId(), $hw->getName(), array('title'=> $hw->getName())); ?>  |
					 <?php echo anchor('dashboard/homeworks/show/'.$hw->getId(), "edit"); ?> |
					 <?php echo anchor('dashboard/homeworks/show/'.$hw->getId(), "delete"); ?> |
					 <?php echo anchor('dashboard/homeworks/show/'. $hw->getDepartment()->getId() . '/' .$hw->getId(), "sections"); ?>
					 </li>
				<?php } ?>
			</ul>
			
			<?php echo anchor('/dashboard/homeworks/create', "Add New Homework"); ?>
		</div>
	</div>
</div>