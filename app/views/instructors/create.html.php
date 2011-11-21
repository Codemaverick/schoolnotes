<?php $this->setViewData('title', "Add a new instructor"); ?>
<h1>Instructors</h1>

<h3>Create</h3>
<div class="shell">
	<form method="post" action="/instructors/create_new">
		<div class="formItem">
			<label>Username</label>
			<input type="text" id="membershipuser_username" name="membershipuser[username]" value="" />
		</div>
		<div class="formItem">
			<label>Password</label>
			<input type="password" id="membershipuser_password" name="membershipuser[password]" value="" />
		</div>
		<div class="formItem">
			<label>Email</label>
			<input type="text" id="membershipuser_email" name="membershipuser[email]" value="" />
		</div>
		<div class="formItem">
			<label>Firstname</label>
			<input type="text" id="membershipuser_firstname" name="membershipuser[firstname]" value="" />
		</div>
		<div class="formItem">
			<label>Lastname</label>
			<input type="text" id="membershipuser_lastname" name="membershipuser[lastname]" value="" />
		</div>
		<div class="formItem">
			<label>Office:</label>
			<input type="text" id="membershipuser_firstname" name="instructor[office]" value="" />
		</div>
		<div class="formItem">
			<input type="hidden" name="school[id]" value="<?php //echo $school->getId() ?>" />
			<input type="submit" id="submitBtn" value="Create" />
		</div>
		
		
	</form>
	
</div>