<div class="span8">
		<h1><?= $model->professor->getUser()->getFullName() ?></h1>
	</div> 
	<div id="profile_nav" class="span8">
	<?php $username = $model->professor->getUser()->getUserName(); ?>
	<nav>
		<ul class="h_nav">
			<li><?php echo $this->html->link("Class Notes", '/professors/'. $username . "/classnotes/"); ?> |</li>
			<li><?php echo $this->html->link("Assignments", '/professors/'. $username. "/homeworks/"); ?> |</li>
			<li><?php echo $this->html->link("Announcements", '/professors/'. $username. "/announcements/"); ?> |</li>
			<li><?php echo $this->html->link("Profile", '/professors/'. $username. "/profile/"); ?></li>
		</ul>
	</nav>
	</div>

