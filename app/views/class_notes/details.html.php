<?php $this->title($model->course->getName()); ?>
<?php $user = $model->professor->getUser(); ?>
<?php $this->title($model->professor->getUser()->getFullName() . " - " . $model->course->getName() . " - " . $note->getCourseSection()->getSection()); ?>
<div class="row profile_header">
	<?php echo $this->_render('element', 'profile_manage'); ?>
</div>
<div class="shell">
	<div>
		<article>
			<header>
				<h4><?= $note->getName(); ?></h4>	
			</header>
			<div class="formItem">
				<?php echo $note->getNote(); ?>
			</div>
			<div class="formItem">
				<h5>Attachments:</h5>
				<?php //echo $school->getAddress(); ?>
			</div>
		</article>
	</div>
	<div>
		<p><?= $this->html->link("Back to Index","/dashboard/classnotes/manage/". $note->getCourseSection()->getId()); ?></p>
	</div>
</div>