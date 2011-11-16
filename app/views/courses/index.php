<?php $this->setViewData('title', 'Courses'); ?>
<h1>Courses</h1>

<h3>Available Courses</h3>
<div class="contextBar">
	<?php echo anchor('/courses/create', "Add New Course"); ?>
</div>
<div class="shell">
	<?php if(($courses) && ($courses->count() > 0)){ ?>
	<ul class="contentList">
		<?php foreach($courses as $cs){ ?>
			<li><?php echo anchor('courses/show/'.$cs->getId(), $cs->getName(), array('title'=> $cs->getName())); ?>  |
			 <?php echo anchor('courses/edit/'.$cs->getId(), "edit"); ?> |
			 <?php echo anchor('courses/delete/'.$cs->getId(), "delete"); ?> |
			 <?php echo anchor('coursesections/index/'. $cs->getDepartment()->getId() . '/' .$cs->getId(), "sections"); ?>
			 </li>
		<?php } ?>
	</ul>
	<?php }else{ ?>
		<p>There are no courses in the database</p>
	<?php } ?>
	
</div>