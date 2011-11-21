<h1>Instructors</h1>

<h3>Update</h3>
<div class="shell">
	<form method="post" action="/instructors/update">
		<div class="formItem">
			<label>Username</label>
			<?php echo $user->getUserName(); ?>
		</div>
		<div class="formItem">
			<label>Email</label>
			<input type="text" id="instructor_email" name="membershipuser[email]" value="<?php echo $user->getEmail(); ?>" />
		</div>
		<div class="formItem">
			<label>Firstname</label>
			<input type="text" id="instructor_firstname" name="membershipuser[firstname]" value="<?php echo $user->getFirstName(); ?>" />
		</div>
		<div class="formItem">
			<label>Lastname</label>
			<input type="text" id="instructor_lastname" name="membershipuser[lastname]" value="<?php echo $user->getLastName(); ?>" />
		</div>
		<div class="formItem">
			<input type="hidden" name="instructor[id]" value="<?php echo $instructor->getId() ?>" />
			<input type="submit" id="submitBtn" value="Update" />
		</div>
		
	</form>
</div>
<div>
	<?php echo anchor('/instructors', "Back to List"); ?>
</div>