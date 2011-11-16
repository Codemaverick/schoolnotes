<h1>Announcements</h1>

<h3>Class Name and Semester</h3>
<div>
	<ul>
		<?php foreach($announcements as $cs){ ?>
			<li><?php echo anchor('courses/show/'.$cs->getId(), $cs->getTitle(), array('title'=> $cs->getTitle())); ?>  |
			 <?php echo anchor('courses/edit/'.$cs->getId(), "edit"); ?> |
			 <?php echo anchor('courses/delete/'.$cs->getId(), "delete"); ?> |
			 <?php echo anchor('coursesections/index/'. $cs->getCourseSection()->getId() . '/' .$cs->getId(), "sections"); ?>
			 </li>
		<?php } ?>
	</ul>
	
	<?php echo anchor('/dashboard/announcements/create', "Add New Announcements"); ?>
</div>