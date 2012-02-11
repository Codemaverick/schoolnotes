<?php $username = $model->professor->getUser()->getUserName(); ?>
<div class="span10">
		<h1><?= $model->professor->getUser()->getFullName() ?></h1>
		<h4><?= $model->profile->getTitle(); ?> - <?= $model->professor->getDepartment()->getName(); ?></h4>
		<?php echo $this->html->link("Profile", '/professors/'. $username . "/profile/"); ?>
</div> 
<div id="profile_nav" class="span6">
<nav>
	<ul class="">
		<li>Office: <?= $model->professor->getOffice(); ?></li>
		<?php $numbers = $model->profile->getPhoneNumbers(); ?>
		<li>Phone: <?= $numbers[0]->getNumber(); ?></li>
		<li>Email: <?= $model->professor->getUser()->getEmail(); ?></li>
	</ul>
</nav>
</div>