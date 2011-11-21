<?php $this->setViewData('title', 'Courses'); ?>
<h1>Courses</h1>

<h3>Available Courses</h3>
<div class="contextBar">
	<?= $this->html->link("Add New Course",'/courses/create'); ?>
</div>
<div class="shell">
	<?php if(($courses) && (count($courses) > 0)){ ?>
	<ul class="contentList">
		<?php foreach($courses as $cs){ ?>
			<li><?= $this->html->link($cs->getName(),'courses/show/'.$cs->getId(), array('title'=> $cs->getName()) ); ?>  |
			 <?= $this->html->link("edit",'courses/edit/'.$cs->getId()); ?> |
			 <?= $this->html->link("delete",'courses/delete/'.$cs->getId()); ?> |
			 <?= $this->html->link("sections",'coursesections/index/'. $cs->getDepartment()->getId() . '/' .$cs->getId()); ?>
			 </li>
		<?php } ?>
	</ul>
	<?php }else{ ?>
		<p>There are no courses in the database</p>
	<?php } ?>
	
</div>