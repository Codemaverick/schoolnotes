<?php $this->title($model->professor->getUser()->getFullName()); ?>
<div class="row profile_header">
	<?php echo $this->_render('element', 'profile_nav'); ?>
</div>
<div class="row shell"> 
	<div class="span-one-third shell_header">
		<div class="shell_profile">
			<?php echo $this->_render('element', 'profile_public_panel'); ?>
		</div>
	</div>
	<div class="span-two-thirds shell_courses">
		<h3>Announcements</h3>
		<h4>Current Semester</h4>
		<?php if(count($courses) > 0) { ?>
			<ul class="course_list">
			<?php 
			$sectionList = $model->professor->getCourses()->toArray();
			foreach($sectionList as $sec){
				$course = $sec->getCourse();
				echo '<li>' . $this->html->link($course->getName(), '/courseview/show/' . $sec->getId()) . '</li>';
			}
			 ?>
			</ul>
		
		<?php } else { ?>
			<p>Professor <?= $model->professor->getUser()->getFullName(); ?> has no courses or course notes listed.</p>
		
		<?php } ?>
	</div>

</div>