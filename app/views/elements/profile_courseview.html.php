<?php $username = $model->professor->getUser()->getUserName(); ?>
<div class="span10">
		<h4 class="running_head"><?= $model->professor->getUser()->getFullName() ?></h4>
		<h1><?= $model->course->getName(); ?> </h1>
		<p><?= $model->course->getCourseCode() . '-' . $model->coursesection->getSection(); ?>&nbsp;&nbsp;
		<?= $model->coursesection->getSemester()->getName(); ?></p>
</div> 
<div id="profile_nav" class="span6">
<nav>
	<ul class="">
		<li>Office: <?= $model->professor->getOffice(); ?></li>
		<?php $numbers = $model->profile->getPhoneNumbers(); ?>
		<li>Phone: <?= $numbers[0]->getNumber(); ?></li>
		<li>Email: <?= $model->professor->getUser()->getEmail(); ?></li>
		<li><?php echo $this->html->link("Profile", '/professors/'. $username . "/profile/"); ?></li>
	</ul>
</nav>
</div>