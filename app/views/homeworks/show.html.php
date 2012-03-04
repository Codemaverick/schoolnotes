<?php $this->title($model->course->getName()); ?>
<?php $user = $model->professor->getUser(); ?>
<?php $this->title($model->professor->getUser()->getFullName() . " - " . $model->course->getName() . " - " . $model->coursesection->getSection()); ?>
<div class="row profile_header">
	<?php echo $this->_render('element', 'profile_courseview'); ?>
</div>
<div class="row shell">
	<div class="span4 shell_menu">
		<?php echo $this->_render('element', 'course_view_nav'); ?>
	</div>
	<div class="span12 shell_content">
	<div>
		<div class="formItem">
			This homework is due on:<br/>
			<?php echo $homework->getDateDue(); ?>
		</div>
		<div class="formItem">
			<?php echo $homework->getText(); ?>
		</div>
		<div class="formItem">
			Attachments:
			<?php //echo $school->getAddress(); ?>
		</div>
	</div>
	<div>
		<p><?php echo $this->html->link("Back to Index", "/professors/". $user->getUserName() . "/homeworks/index/". $model->course->getId() . '/'. $homework->getCourseSection()->getId()); ?></p>
	</div>
</div>