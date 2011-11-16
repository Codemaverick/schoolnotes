<h1>Schools</h1>

<h3>Registered Schools</h3>
<div>
	<ul>
		<?php foreach($buildings as $bd){ ?>
			<li><?php echo anchor('buildings/show/'.$bd->getId(), $bd->getName(), array('title'=> $bd->getName())); ?>  |
			 <?php echo anchor('buildings/edit/'.$bd->getId(), "edit"); ?> |
			 <?php echo anchor('buildings/delete/'.$bd->getId(), "delete"); ?>
			 </li>
		<?php } ?>
	</ul>
	
	<?php echo anchor('/buildings/create', "Add New Building"); ?>
</div>