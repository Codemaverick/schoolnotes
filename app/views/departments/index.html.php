<?php $this->title('Departments'); ?>
<h1><?= $school->getName(); ?></h1>

<h3>Departments</h3>
<div class="contextBar">
	<?= $this->html->link("Add New Department",'/departments/create', array('class'=>'linkBtn')); ?>
</div>
<div class="shell">
	<ul class="itemList">
		<?php foreach($departments as $dep){ ?>
			<li><?= $this->html->link($dep->getName(), 'departments/show/'.$dep->getId(), array('title'=> $dep->getName())); ?>  |
			 <?= $this->html->link("edit",'departments/edit/'.$dep->getId()); ?> |
			 <?= $this->html->link("delete",'departments/delete/'.$dep->getId()); ?>
			 	
			 	<ul class="submenu">
			 		<li> <?= $this->html->link("Courses",'departments/courses/'.$dep->getId()); ?></li>
			 	</ul>
			 </li>
		<?php } ?>
	</ul>
	
	
</div>