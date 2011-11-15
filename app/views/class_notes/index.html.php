<h1>Class Notes</h1>

<h3>Class Name and Semester</h3>
<div>
	<ul>
		<?php foreach($courses as $cs){ ?>
			<li><?php echo anchor('courses/show/'.$cs->getId(), $cs->getName(), array('title'=> $cs->getName())); ?>  |
			 <?php echo anchor('courses/edit/'.$cs->getId(), "edit"); ?> |
			 <?php echo anchor('courses/delete/'.$cs->getId(), "delete"); ?> |
			 <?php echo anchor('coursesections/index/'. $cs->getDepartment()->getId() . '/' .$cs->getId(), "sections"); ?>
			 </li>
		<?php } ?>
	</ul>
	
	<?php echo anchor('/dashboard/classnotes/create', "Add New Note"); ?>
</div>