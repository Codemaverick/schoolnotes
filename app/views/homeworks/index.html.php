<?php $this->title($model->course->getName()); ?>
<?php $user = $model->professor->getUser(); ?>
<?php $this->title($model->professor->getUser()->getFullName()); ?>
<div class="row profile_header">
	<?php echo $this->_render('element', 'profile_courseview'); ?>
</div>
<div class="row shell">
	<div class="span4 shell_menu">
		<?php echo $this->_render('element', 'course_view_nav'); ?>
	</div>
	<div class="span12 shell_content">
		<h3>Homeworks</h3>
		<div>
			<div>
			<?php 
				 if(($model->homeworks) && (count($model->homeworks) > 0)){ ?>
				<ul>
					<?php foreach($model->homeworks as $hw){ ?>
						<li><?php echo $this->html->link($hw->getName(), '/professors/'.$user->getUserName().'/homeworks/show/' . $hw->getId()); ?>
						<br/>
						</li>
					<?php } ?>
				</ul>
			<?php } else { ?>
				<p>This class has no published homeworks. <br/>
			<?php } ?>
			</p>
		</div>
			
			
		</div>
	</div>
</div>