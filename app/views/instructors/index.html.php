<?php $this->title("Instructors"); ?>


<h1>Instructors</h1>
<div class="contextBar">
	<?= $this->html->link("Add New Instructor", '/instructors/create',array('class'=>'linkBtn')); ?>
	<?= $this->html->link("Import", '/instructors/import',array('class'=>'linkBtn')); ?>
</div>

<div>
	<ul class="itemList">
		<?php foreach($instructors as $ins){ ?>
			<li><?= $this->html->link($ins->getUser()->getFullName(), 'instructors/show/'.$ins->getId(),array('title'=> $ins->getUser()->getFullName())); ?>  |
			 <?= $this->html->link("edit",'instructors/edit/'.$ins->getId()); ?> |
			 <?= $this->html->link("delete",'instructors/delete/'.$ins->getId()); ?>
			 </li>
		<?php } ?>
	</ul>
	
	
</div>