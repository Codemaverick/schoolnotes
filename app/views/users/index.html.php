<?php $this->title($model->professor->getUser()->getFullName()); ?>
<div class="row profile_header">
	<?php echo $this->_render('element', 'profile_nav'); ?>
</div>
<div class="row shell">
	<div class="shell_profile span-one-third">
		<?php echo $this->_render('element', 'profile_public_panel'); ?>
	</div>
	<div class="shell_courses span-two-third">
		<h3>Spring 2011<!-- Update with correct dynamic semester --></h3>
		<h4>Current Courses </h4>
		<ul class="course_list">
		<?php 
			$sectionList = $model->professor->getCourses()->toArray();
			foreach($sectionList as $sec){
				$course = $sec->getCourse();
				echo '<li>' . $this->html->link($course->getName(), '/courseview/show/' . $sec->getId()) . '</li>';
			}
			
			 ?>
		</ul>
	</div>
</div>