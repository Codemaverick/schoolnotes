<?php $this->setViewData('title', "Instructors"); ?>


<h1>Instructors</h1>
<div class="contextBar">
	<?php echo anchor('/instructors/create', "Add New Instructor", array('class'=>'linkBtn')); ?>
	<?php echo anchor('/instructors/import', "Import", array('class'=>'linkBtn')); ?>
</div>

<div>
	<ul class="itemList">
		<?php foreach($instructors as $ins){ ?>
			<li><?php echo anchor('instructors/show/'.$ins->getId(), $ins->getUser()->getFullName(), array('title'=> $ins->getUser()->getFullName())); ?>  |
			 <?php echo anchor('instructors/edit/'.$ins->getId(), "edit"); ?> |
			 <?php echo anchor('instructors/delete/'.$ins->getId(), "delete"); ?>
			 </li>
		<?php } ?>
	</ul>
	
	
</div>