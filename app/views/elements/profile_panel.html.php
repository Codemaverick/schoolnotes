<div class="image_placeholder">
		
</div>
<div class="mini_profile">
	<?php echo $model->professor->getUser()->getFullName(); ?>
	<p>Associate Professor</p>
	<p>Department of Computer Science</p>
	<p><?php echo $this->html->link("Update Your Profile","dashboard/profiles/show"); ?></p>
	<p><?php echo $this->html->link("Change Password", "dashboard/profiles/passcode"); ?></p>
</div>
		