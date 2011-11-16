<h1>Semesters</h1>

<h3>Index</h3>
<div>
	<ul>
		<?php foreach($semesters as $sms){ ?>
			<li><?php echo anchor('semesters/show/'.$sms->getId(), $sms->getName(), array('title'=> $sms->getName())); ?>  |
			 <?php echo anchor('semesters/edit/'.$sms->getId(), "edit"); ?> |
			 <?php echo anchor('semesters/delete/'.$sms->getId(), "delete"); ?>
			 </li>
		<?php } ?>
	</ul>
	
	<?php echo anchor('/semesters/create', "Add New Semester"); ?>
</div>