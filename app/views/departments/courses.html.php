<?php $this->title('Courses') ?>
<h1><?= $model->department->getName(); ?></h1>

<h3>Courses</h3>
<div class="contextBar">
	<?= $this->html->link("Add New Course", '/courses/create/'.$model->department->getId(), array('class'=>'linkBtn')); ?>
</div>
<div class="shell">
	<?php if(($model->courses) && (count($model->courses) > 0)){ ?>
	<ul class="itemlist">
		<?php foreach($model->courses as $course){ ?>
			<li><?= $this->html->link($course->getName(),'courses/show/'.$course->getId(), array('title'=> $course->getName())); ?>  |
			 <?= $this->html->link("edit", 'courses/edit/'.$course->getId()); ?> |
			 <?= $this->html->link("delete", 'courses/delete/'.$course->getId()); ?> |
			  <?= $this->html->link("sections",'coursesections/index/'. $model->department->getId() . "/". $course->getId()); ?>
			 </li>
		<?php } ?>
	</ul>
	<?php } else { ?>
		<p>This department has no courses</p>
	<?php } ?>
</div>
<p><?= $this->html->link("Back to Department List",'/departments/'); ?></p>