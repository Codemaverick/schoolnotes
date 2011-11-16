<h1>Delete</h1>

<h4>Are You Sure?</h4>
<div class="shell">
	<form method="post" action="/instructors/destroy">
		<div class="formItem">
			First Name:
			<?php echo $user->getFirstName(); ?>
		</div>
		<div class="formItem">
			Last Name:
			<?php echo $user->getLastName(); ?>
		</div>
		<div class="formItem">
			Username:
			<?php echo $user->getUsername(); ?>
		</div>
		<div class="formItem">
			Email:
			<?php echo $user->getEmail(); ?>
		</div>
		<div class="formItem">
			<input type="hidden" name="instructor[id]" value="<?php echo $instructor->getId(); ?>" />
			<input type="submit" id="submitBtn" value="Delete" name="submit" />
		</div>
		<div class="formItem">
			<?php echo anchor("/instructors/index", "Back to Index"); ?>
		</div>
	</form>
</div>		