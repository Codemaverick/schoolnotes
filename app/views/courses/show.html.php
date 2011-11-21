<?php $this->title("Courses"); ?>
<h1>Courses</h1>

<h3>Details</h3>
<?php //echo var_dump($school); ?>
<div>
	
		<div class="formItem">
			Name:
			<?php echo $course->getName(); ?>
		</div>
		<div class="formItem">
			Department:
			<?php echo $course->getDepartment()->getName(); ?>
		</div>
		<div class="formItem">
			Description:
			<?php echo $course->getDescription(); ?>
		</div>
		<div class="formItem">
			Course Code:
			<?php echo $course->getCourseCode(); ?>
		</div>
		<div class="formItem">
			<?php echo $this->html->link("Back to Index","/departments/courses/" . $course->getDepartment()->getId()); ?>
		</div>
	
</div>