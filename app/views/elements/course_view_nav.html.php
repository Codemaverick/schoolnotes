<?php $user = $model->professor->getUser(); ?>
<?php $courseId = $model->course->getId();?>
<?php $sectionId = $model->coursesection->getId();?>
<ul class="course_menu">
			<li><?php echo $this->html->link("Overview","/professors/". $user->getUserName() .'/courseview/show/' . $model->coursesection->getId()); ?></li>
			<li><?php echo $this->html->link("Class Notes", "/professors/". $user->getUserName() .'/classnotes/index/'. $courseId . '/'. $sectionId); ?> </li>
			<li><?php echo $this->html->link("Homeworks", "/professors/". $user->getUserName() .'/homeworks/index/'. $courseId . '/'. $sectionId); ?></li>
			<li><?php echo $this->html->link("Announcements", "/professors/". $user->getUserName() .'/announcements/index/'. $courseId . '/'. $sectionId); ?></li>
			<li><?php echo $this->html->link("Syllabus", "/professors/". $user->getUserName() .'/syllabus/index/'. $courseId . '/'. $sectionId); ?></li>
			<li><?php echo $this->html->link("Schedule", "/professors/". $user->getUserName() .'/schedule/index/'. $courseId . '/'. $sectionId); ?></li>
			<li><?php echo $this->html->link("Subscribe", "/professors/". $user->getUserName() .'/subscribe/index/'. $courseId . '/'. $sectionId); ?></li>
		</ul>