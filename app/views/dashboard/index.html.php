<?php $this->title("Welcome to Dashboard"); ?>
<div class="row profile_header">
	<?php echo $this->_render('element', 'profile_view'); ?>
</div>
<div class="shell">
	<div class="shell_courses">
		<h3><?php echo ($model->semester) ? $model->semester->getName() : "Spring 2012" ?></h3>
		<h4>My Courses</h4>
		<ul class="course_list">
		<?php 
			$sectionList = $model->coursesections->toArray();
			foreach($sectionList as $sec){
				$course = $sec->getCourse(); ?>
				<li>
					<div>
						<?= $this->html->link($course->getName(), 'dashboard/courseview/manage/' . $sec->getId()) ?>
						<nav>
							<ul>
								<li><?= $this->html->link("Add Class Note","/classnotes/create/" . $sec->getId()); ?></li>
								<li><?= $this->html->link("New Homewwork","/homeworks/create/" . $sec->getId()); ?></li>
								<li><?= $this->html->link("Post an Announcement","/announcements/create/" . $sec->getId()); ?></li>
							</ul>
						</nav>
					</div>
				</li>
		<?php } ?>
		
		</ul>
	</div>
	<div class="shell_header">
		
		<div class="shell_nav">
			<?php echo $this->html->link("Archived Courses","/courses/archived"); ?>
		</div>
	</div>
	<div class="shell_profile">
		<?php //= $this->_render('element', 'profile_panel'); ?>
	</div>
	
	<div class="clearfix"></div>
</div>