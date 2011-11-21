<h1>Admin</h1>

<h3><?php echo $semester->getName(); ?></h3>
<h2><?php echo $course->getName(); ?> - Sections</h2>
<h4>Available Course Sections</h4>
<div>
	<ul>
		<?php foreach($sections as $sec){ ?>
			<li><?= $this->html->link($sec->getSection(),'coursesections/show/'.$sec->getId(), array('title'=> $sec->getSection())); ?>  |
			 <?= $this->html->link("edit",'coursesections/edit/'.$sec->getId()); ?> |
			 <?= $this->html->link("delete",'coursesections/delete/'.$sec->getId()); ?>
			 </li>
			 <p><?= if($sec->getInstructor()) echo "Professor:  " . $sec->getInstructor()->getFullName(); ?></p>
		<?php } ?>
	</ul>
	
	<?= $this->html->link("Add New Section",'/coursesections/create/'. $semester->getId() . "/" . $course->getId(), ); ?>
	
	<p>Back to <?php echo $this->html->link("Course Listing","/departments/courses/". $course->getDepartment()->getId()); ?></p>
</div>