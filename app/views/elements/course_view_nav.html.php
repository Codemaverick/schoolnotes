<?php $user = $model->professor->getUser(); ?>
<ul class="course_menu">
			<li><?php echo $this->html->link("Overview","/professors/". $user->getUserName() .'/courseview/show/' . $model->coursesection->getId()); ?></li>
			<li><?php echo $this->html->link("Class Notes", "/professors/". $user->getUserName() .'/classnotes/index/'. $model->course->getId() . '/'. $model->coursesection->getId()); ?> </li>
			<li><?php echo $this->html->link("Homeworks", "/professors/". $user->getUserName() .'/homeworks/index/'. $model->course->getId() . '/'. $model->coursesection->getId()); ?></li>
			<li><?php echo $this->html->link("Syllabus", "/professors/". $user->getUserName() .'/syllabus/index/'. $model->course->getId() . '/'. $model->coursesection->getId()); ?></li>
			<li><?php echo $this->html->link("Schedule", "/professors/". $user->getUserName() .'/schedule/index/'. $model->course->getId() . '/'. $model->coursesection->getId()); ?></li>
			<li><?php echo $this->html->link("Subscribe", "/professors/". $user->getUserName() .'/subscribe/index/'. $model->course->getId() . '/'. $model->coursesection->getId()); ?></li>
		</ul>