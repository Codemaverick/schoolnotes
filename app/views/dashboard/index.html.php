<?php $this->title("Welcome to Dashboard"); ?>
<div class="shell">
	<div class="shell_header">
		<div class="shell_branding">
		<h3>City College of New York</h3>
	
		</div>
		<div class="shell_nav">
			<?php echo $this->html->link("Archived Courses","/courses/archived"); ?>
		</div>
	</div>
	<div class="shell_profile">
		<?= $this->_render('element', 'profile_panel'); ?>
	</div>
	<div class="shell_courses">
		<h3>Spring 2011<!-- Update with correct dynamic semester --></h3>
		<h4>Your Courses </h4>
		<ul class="course_list">
		<?php 
			$sectionList = $model->professor->getCourses()->toArray();
			foreach($sectionList as $sec){
				$course = $sec->getCourse();
				echo '<li>' . $this->html->link($course->getName(), 'dashboard/courseview/manage/' . $sec->getId()) . '</li>';
			}
			
			 ?>
			 </ul>
	</div>
	<div class="clearfix"></div>
</div>