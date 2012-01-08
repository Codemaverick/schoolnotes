<?php $this->title($model->professor->getUser()->getFullName()); ?>
<div class="row profile_header">
	<?php echo $this->_render('element', 'profile_nav'); ?>
</div>
<div class="row shell"> 
	<div class="span-one-third shell_header">
		<div class="shell_profile">
			<div class="image_placeholder">
		
			</div>
			<div class="mini_profile">
				<?php echo $model->professor->getUser()->getFullName(); ?>
				<p>Associate Professor</p>
				<p>Department of Computer Science</p>
			</div>
		</div>
	</div>
	<div class="span-two-thirds shell_courses">
		<h3>Class Notes</h3>
		<h4>Current Semester</h4>
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