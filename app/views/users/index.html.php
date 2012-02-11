<?php $this->title($model->professor->getUser()->getFullName()); ?>
<div class="row profile_header">
	<?php echo $this->_render('element', 'profile_view'); ?>
</div>
<div class="shell">
	<div class="accordion">
		<h3>Current Courses - <?php echo ($model->semester) ? $model->semester->getName() : "No Current Semester" ?></h3>
	</div>
	<div class="accordion">
		<h4 class="section_header">Archives</h4>
		<ul class="course_list">
		<?php 
			$sectionList = $model->professor->getCourses()->toArray();
			$user = $model->professor->getUser();
			foreach($sectionList as $sec){
				$course = $sec->getCourse();
				echo '<li>';  
				echo '<span class="semester_name">' . $sec->getSemester()->getName() . '</span>';
				echo $this->html->link($course->getName(), '/professors/'. $user->getUserName() .'/courseview/show/' . $sec->getId()); 
				echo '</li>';
			}
			
			 ?>
		</ul>
	</div>
</div>