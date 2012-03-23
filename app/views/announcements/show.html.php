<?php $this->title($model->course->getName()); ?>
<?php $user = $model->professor->getUser(); ?>
<?php $this->title($model->professor->getUser()->getFullName() . " - " . $model->course->getName() . " - " . $model->coursesection->getSection()); ?>
<div class="row profile_header">
	<?php echo $this->_render('element', 'profile_courseview'); ?>
</div>
<div class="shell">
<?php 	$announcement = $model->announcements[0]; 
		$username = $model->professor->getUser()->getUsername();
		$sectionId = $model->coursesection->getId();
		$courseId = $model->course->getId(); 
?>
	
	<h2><?= $announcement->getTitle() ?></h2>
	<h4><?= $announcement->getCourseSection()->getSemester()->getName(); ?></h4>
	<div>
		<div class="formItem">
			<p><?= $announcement->getText(); ?></p>
		</div>
	</div>
	<div>
		<p>
		<?= $this->html->link("Back to Index","/professors/{$username}/announcements/index/{$courseId}/{$sectionId}"); ?></p>
	</div>
</div>