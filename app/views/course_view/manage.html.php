<?php $this->title($model->course->getName()); ?>
<?php $user = $model->professor->getUser(); ?>
<div class="row profile_header">
	<?php echo $this->_render('element', 'profile_manage'); ?>
</div>
<div class="row shell">
	<div class="span12">
	<?php $cs = $model->coursesection; //shorter for repeated use ?>
		<section>
			<header>
				<h2>Notes</h2>
			</header>
			<div>
				<?php 
				if($model->classnotes){ ?>
					<ul>
						
						<?php foreach($model->classnotes as $note){ ?>
							<li><?php echo $this->html->link($note->getName(), 'dashboard/classnotes/details/'. $note->getId()); ?>
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
		</section>
		<section>
			<header>
				<h2>Homeworks</h2>
			</header>
			<div>
			<?php 
				 if(($model->homeworks) && (count($model->homeworks) > 0)){ ?>
				<ul>
					<?php foreach($model->homeworks as $hw){ ?>
						<li><?php echo $this->html->link($hw->getName(), 'dashboard/homeworks/details/' . $hw->getId()); ?><br/>
							<?php echo $this->html->link("Update",'dashboard/homeworks/edit/'. $hw->getId()); ?> | 
							<?php echo $this->html->link("Delete", 'dashboard/homeworks/delete/'. $hw->getId()); ?>
						</li>
					<?php } ?>
				</ul>
			<?php } else { ?>
				<p>This class has no published homeworks. <br/>
			<?php } ?>
			<?php echo $this->html->link("Create homework", 'dashboard/homeworks/create/' . $cs->getId()); ?></p>
		</div>
		</section>
		<section>
			<header>
				<h2>Announcements</h2>
			</header>
			<div>
			<?php 
				 if(($model->announcements) && (count($model->announcements) > 0)){ ?>
				<ul>
					<?php foreach($model->announcements as $anncmt){ ?>
						<li><?php echo $this->html->link($anncmt->getTitle(),'dashboard/announcements/details/' . $anncmt->getId()); ?><br/>
							<?php echo $this->html->link("Update", 'dashboard/announcements/edit/'. $anncmt->getId()); ?> | 
							<?php echo $this->html->link("Delete", 'dashboard/announcements/delete/'. $anncmt->getId()); ?>
						</li>
					<?php } ?>
				</ul>
			<?php } else { ?>
				<p>This class has no published announcements. <br/>
			<?php } ?>
			<?php echo $this->html->link("Post an announcement",'dashboard/announcements/create/' . $cs->getId()); ?></p>
		</div>
		</section>
	</div>
	<div class="span4">
		<ul>
			<li>Syllabus</li>
		</ul>
		<h4>Class Schedule</h4>
		<p>
			His first office was as one of the twenty annual Quaestors, a training post for 
			serious public administration in a diversity of areas, but with a traditional 
		</p>
	</div><!-- end side content -->
</div>