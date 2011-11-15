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
		<div class="image_placeholder">
		
		</div>
		<div class="mini_profile">
			<?php echo $model->professor->getUser()->getFullName(); ?>
			<p>Associate Professor</p>
			<p>Department of Computer Science</p>
			<p><?php echo $this->html->link("Update Your Profile","dashboard/profiles/show"); ?></p>
			<p><?php echo $this->html->link("Change Password", "dashboard/profiles/passcode"); ?></p>
		</div>
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