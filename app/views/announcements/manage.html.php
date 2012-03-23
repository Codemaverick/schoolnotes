<?php $this->title($model->course->getName() . '- Announcements'); ?>
<?php $user = $model->professor->getUser(); ?>
<div class="row profile_header">
	<?php echo $this->_render('element', 'profile_manage'); ?>
</div>
<div class="shell">
	<div class="span12 shell_content">
		<h3>Announcements</h3>
		<div>
			
			<?php 
				 if(($model->announcements) && (count($model->announcements) > 0)){ ?>
				<ul>
					<?php foreach($model->announcements as $ann){ ?>
						<li><?php echo $this->html->link($ann->getTitle(), '/dashboard/announcements/details/' . $ann->getId()); ?>
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
	