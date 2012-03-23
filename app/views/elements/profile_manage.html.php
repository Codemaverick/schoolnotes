<?php $username = $model->professor->getUser()->getUserName(); ?>
<div class="span10">
		<h4 class="running_head"><?= $model->professor->getUser()->getFullName() ?></h4>
		<h1><?= $model->course->getName(); ?> </h1>
		<p><?= $model->course->getCourseCode() . '-' . $model->coursesection->getSection(); ?>&nbsp;&nbsp;
		<?= $model->coursesection->getSemester()->getName(); ?></p>
		<nav>
			<ul class="h_nav left_edge">
				<li><?php echo $this->html->link("Course Home", '/dashboard/courseview/manage/' . $model->coursesection->getId()); ?> | </li>
				<li><?php echo $this->html->link("Notes", '/dashboard/classnotes/manage/' . $model->coursesection->getId()); ?> | </li>
				<li><?php echo $this->html->link("Homeworks", '/dashboard/homeworks/manage/' . $model->coursesection->getId()); ?> |</li>
				<li><?php echo $this->html->link("Announcements", '/dashboard/announcements/manage/' . $model->coursesection->getId()); ?> </li>
			</ul>
		</nav>
</div> 
<div id="profile_nav" class="span6">
<nav>
	<ul class="h_nav">
		<li><?php echo $this->html->link("Dashboard", '/dashboard/'); ?> /</li>
		<li><?php echo $this->html->link("Profile", '/professors/'. $username . "/profile/"); ?> /</li>
		<li><?php echo $this->html->link("Courses", '/professors/'. $username . "/profile/"); ?> /</li>
		<li><?php echo $this->html->link("Profile", '/professors/'. $username . "/profile/"); ?></li>
	</ul>
</nav>
</div>
