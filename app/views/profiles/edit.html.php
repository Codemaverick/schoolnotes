<h1>Your Profile</h1>

<div>
	<form id="updateform" method="post" action="/dashboard/profiles/update">
		<div class="formItem">
			<label>First Name:</label>
			<input type="text" name="membershipuser[firstName]" id="membershipuser_firstname" value="<?= $model->user->getFirstName(); ?>" ?>
		</div>
		<div class="formItem">
			<label>Last Name:</label>
			<input type="text" name="membershipuser[lastName]" id="membershipuser_lastname" value="<?= $model->user->getLastName(); ?>" ?>
		</div>
		<div class="formItem">
			<label>Email:</label>
			<input type="text" name="membershipuser[email]" id="instructor_email" value="<?= $model->user->getEmail(); ?>" />
		</div>
		<div class="formItem">
			<label>Office:</label>
			<input type="text" name="instructor[office]" id="instructor_office" value="<?= $model->instructor->getOffice() ?>" />
		</div>
		<div class="formItem">
			<label>Title (Professor/Associate Professor):</label>
			<input type="text" name="profile[title]" id="profile_title" value="<?php echo $model->profile->getTitle(); ?>" />
		</div>
		<div class="formItem">
			<label>Bio:</label>
			<textarea name="profile[bio]" id="profile_bio" rows="10" cols="40"><?php echo $model->profile->getBio(); ?></textarea>
		</div>
		<div class="formItem">
			<label>Phone Number(s):</label>
			<?php 
			$numbers = $model->profile->getPhoneNumbers();
			if(($numbers)&&(count($numbers) > 0)){
				foreach($numbers as $num){ ?>
				<input type="text" name="profile[phoneNumber]" id="profile_phoneNumber" value="<?php echo $num->getNumber(); ?>" />
			<?php } 
			}else{ ?>
				<input type="text" name="profile[phoneNumber]" id="profile_phoneNumber" value="" />
			<?php }?>
			
		</div>
		<div class="formItem">
			<label>Office Hour:</label>
			<?php 
			$hours = $model->profile->getOfficeHours();
			if(($hours) && (count($hours) > 0)){
				foreach($hours as $hr){ ?>
					<input type="text" name="profile[officeHour]" id="profile_officeHour" value="<?php echo $hr->getStartTime()->format('H:i:s'); ?>" />
			<?php } 
			}else{ ?>
					<input type="text" name="profile[officeHour]" id="profile_officeHour" value="" />
			<?php } ?>
		</div>
		<div class="formItem">
			<label>Image:</label>
			<input type="text" name="profile[Image]" id="profile_Image" value="<?php echo $model->profile->getImage(); ?>" />
		</div>
		<div class="formItem">
			<input type="hidden" name="instructor[id]" value="<?php echo $model->instructor->getId(); ?>" />
			<input type="submit" name="submit" id="submit_btn" value="Update Profile" class="formBtn" />
		</div>
		<div class="formItem">
			<?php echo $this->html->link("Back to Dashboard","dashboard/index"); ?>
		</div>
	</form>
</div>