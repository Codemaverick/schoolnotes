<?php $this->title($model->course->getName()); ?>
<div class="shell">
	<div class="shell_header">
		<div class="shell_branding">
		<h3>City College of New York</h3>
	
		</div>
		<div class="shell_nav">
			<?php echo $this->html->link("Archived Courses", "/courses/archived"); ?>
		</div>
	</div>
	<div class="shell_profile">
		<div class="image_placeholder">
		
		</div>
		<div class="mini_profile">
			<?php //echo $model->professor->getFullName(); ?>
			<p>Associate Professor</p>
			<p>Department of Computer Science</p>
			<p><?php echo $this->html->link("Update Your Profile", "instructors/profile"); ?></p>
		</div>
	</div>
	<div class="shell_courses">
		<h3>Spring 2011<!-- Update with correct dynamic semester --></h3>
		<?php $cs = $model->coursesection; //shorter for repeated use ?>
		<h4><?php  echo $model->course->getName() . '-' . $cs->getSection() ?></h4>
		<article>
		<h5>Class Notes</h5>
		<div>
			<?php 
			if($model->classnotes){ ?>
				<ul>
					<?php foreach($model->classnotes as $note){ ?>
						<li><?php echo $this->html->link($note->getName(), 'dashboard/classnotes/show/'. $note->getId()); ?>
							<br/>
							<?php echo $this->html->link("Update",'dashboard/classnotes/edit/'.$note->getId()); ?> | 
							<?php echo $this->html->link("Delete",'dashboard/classnotes/delete/'.$note->getId()); ?>
						</li>
						
					<?php } ?>
				</ul>
			<?php } else { ?>
				<p>This class has no published class notes.</p>
			<?php } ?>
			<p><?php echo $this->html->link("Create a note",'dashboard/classnotes/create/' . $cs->getId()); ?></p>
		</div>
		</article>
		<article>
		<h5>Homeworks</h5>
		<div>
			<?php 
				 if(($model->homeworks) && (count($model->homeworks) > 0)){ ?>
				<ul>
					<?php foreach($model->homeworks as $hw){ ?>
						<li><?php echo $this->html->link($hw->getName(), 'dashboard/homeworks/show/' . $hw->getId()); ?><br/>
							<?php echo $this->html->link("Update",'dashboard/homeworks/edit/'. $hw->getId()); ?> | 
							<?php echo $this->html->link("Delete", 'dashboard/homeworks/delete/'. $hw->getId()); ?>
						</li>
					<?php } ?>
				</ul>
			<?php } else { ?>
				<p>This class has no published homeworks. <br/>
			<?php } ?>
			<?php echo $this->html->link("Create a homework", 'dashboard/homeworks/create/' . $cs->getId()); ?></p>
		</div>
		</article>
		<article>
		<h5>Announcements</h5>
		<div>
			<?php 
				 if(($model->announcements) && (count($model->announcements) > 0)){ ?>
				<ul>
					<?php foreach($model->announcements as $anncmt){ ?>
						<li><?php echo $this->html->link('dashboard/announcements/show/' . $anncmt->getId(), $anncmt->getTitle()); ?><br/>
							<?php echo $this->html->link('dashboard/announcements/edit/'. $anncmt->getId(),"Update"); ?> | 
							<?php echo $this->html->link('dashboard/announcements/delete/'. $anncmt->getId(),"Delete"); ?>
						</li>
					<?php } ?>
				</ul>
			<?php } else { ?>
				<p>This class has no published announcements. <br/>
			<?php } ?>
			<?php echo $this->html->link('dashboard/announcements/create/' . $cs->getId() , "Post an announcement"); ?></p>
		</div>
		</article>
	</div>
	<div class="clearfix"></div>
</div>