<h1><?php echo $course->getName() . " - " . $note->getCourseSection()->getSection(); ?></h1>

<h3><?php echo $note->getName() ?></h3>
<h4><?php echo $note->getCourseSection()->getSemester()->getName(); ?></h4>
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
	<p><?php echo anchor("/dashboard/courseview/show/". $note->getCourseSection()->getId(),"Back to Index"); ?></p>
</div>