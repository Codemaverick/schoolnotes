<?php set_page_title($homework->getName() . " - " . $course->getName() . " - " . $section->getSection()); ?>
<h1><?php echo $course->getName() . " - " . $homework->getCourseSection()->getSection(); ?></h1>

<h3><?php echo $homework->getName() ?></h3>
<h4><?php echo $homework->getCourseSection()->getSemester()->getName(); ?></h4>
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
	<p><?php echo anchor("/dashboard/courseview/show/". $homework->getCourseSection()->getId(),"Back to Index"); ?></p>
</div>