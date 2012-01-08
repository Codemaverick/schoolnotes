<?php $this->title("Semesters"); ?>
<h1>Semesters</h1>

<h3>Index</h3>
<div>
	<ul>
		<?php foreach($semesters as $sms){ ?>
			<li><?= $this->html->link($sms->getName(), 'semesters/show/'.$sms->getId(), array('title'=> $sms->getName())); ?>  |
			 <?= $this->html->link("edit",'semesters/edit/'.$sms->getId()); ?> |
			 <?= $this->html->link("delete",'semesters/delete/'.$sms->getId()); ?>
			 </li>
		<?php } ?>
	</ul>
	
	<?= $this->html->link("Add New Semester",'/semesters/create'); ?>
</div>