<h1>Homeworks</h1>

<h3><?php echo $homeworks[0]->getCourseSection();</h3>
<div>
	<ul>
		<?php foreach($homeworks as $hw){ ?>
			<li><?php echo anchor('dashboard/homeworks/show/'.$hw->getId(), $hw->getName(), array('title'=> $hw->getName())); ?>  |
			 <?php echo anchor('dashboard/homeworks/show/'.$hw->getId(), "edit"); ?> |
			 <?php echo anchor('dashboard/homeworks/show/'.$hw->getId(), "delete"); ?> |
			 <?php echo anchor('dashboard/homeworks/show/'. $hw->getDepartment()->getId() . '/' .$hw->getId(), "sections"); ?>
			 </li>
		<?php } ?>
	</ul>
	
	<?php echo anchor('/dashboard/homeworks/create', "Add New Homework"); ?>
</div>