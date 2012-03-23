<?php $this->title($model->course->getName() . '- Announcements'); ?>
<?php $user = $model->professor->getUser(); ?>
<div class="row profile_header">
	<?php echo $this->_render('element', 'profile_courseview'); ?>
</div>
<div class="row shell">
	<div class="span4 shell_menu">
		<?php echo $this->_render('element', 'course_view_nav'); ?>
	</div>
	<div class="span12 shell_content">
		<h3>Announcements</h3>
		<div>
			<div>
			<?php 
				 if(($model->announcements) && (count($model->announcements) > 0)){ ?>
				<ul>
					<?php foreach($model->announcements as $ann){ ?>
						<li><?php echo $this->html->link($ann->getTitle(), '/professors/'.$user->getUsername().'/announcements/show/' . $ann->getId()); ?>
						<br/>
						</li>
					<?php } ?>
				</ul>
			<?php } else { ?>
				<p>This class has no announcements. <br/>
			<?php } ?>
			</p>
		</div>
			
			
		</div>
	</div>
</div>
	
	
	
