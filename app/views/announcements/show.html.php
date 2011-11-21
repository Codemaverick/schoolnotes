<h1><?= $course->getName() . " - " . $section->getSection(); ?></h1>

<h3><?= $announcement->getTitle() ?></h3>
<h4><?= $announcement->getCourseSection()->getSemester()->getName(); ?></h4>
<div>
	<div class="formItem">
		<p><?= $announcement->getText(); ?></p>
	</div>
</div>
<div>
	<p><?= $this->html->link("Back to Index","/dashboard/courseview/show/". $announcement->getCourseSection()->getId()); ?></p>
</div>