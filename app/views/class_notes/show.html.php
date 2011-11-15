<?php $this->title($course->getName() . " - " . $note->getCourseSection()->getSection()); ?>
<h1><?= $course->getName() . " - " . $note->getCourseSection()->getSection(); ?></h1>

<h3><?= $note->getName() ?></h3>
<h4><?= $note->getCourseSection()->getSemester()->getName(); ?></h4>
<div>
	
		<div class="formItem">
			Name:
			<?php echo $note->getNote(); ?>
		</div>
		<div class="formItem">
			Attachments:
			<?php //echo $school->getAddress(); ?>
		</div>
	
</div>
<div>
	<p><?= $this->html->link("Back to Index","/professors/". $instructor->getUser()->getUserName() . "/courseview/show/". $note->getCourseSection()->getId()); ?></p>
</div>