<h1>Your Profile</h1>

<div>
	<?php echo $this->html->link("Edit Profile","dashboard/profiles/edit"); ?>
		<div class="formItem">
			Name:
			<?php echo $model->user->getFullName(); ?>
		</div>
		<div class="formItem">
			Username:
			<?php echo $model->user->getUsername(); ?>
		</div>
		<div class="formItem">
			Email:
			<?php echo $model->user->getEmail(); ?>
		</div>
		<div class="formItem">
			Office:
			<?php echo $model->instructor->getOffice() ?>
		</div>
		<div class="formItem">
			Title:
			<?php echo $model->profile->getTitle(); ?>
		</div>
		<div class="formItem">
			Bio:
			<?php echo $model->profile->getBio(); ?>
		</div>
		<div class="formItem">
			Phone Number(s):
			<?php $numbers = $model->profile->getPhoneNumbers();
				if($numbers){ 
					foreach($numbers as $num){ ?>
				<?php echo $num->getNumber(); ?>
				<?php } 
				} ?>
		</div>
		<div class="formItem">
			Office Hour:
			<?php $hours = $model->profile->getOfficeHours();
				if($hours){
					foreach($hours as $hr){ ?>
				<?php echo $hr->getStartTime()->format('H:i:s') . ' - ' . $hr->getEndTime()->format('H:i:s'); ?>
				<?php } 
				} ?>
		</div>
		<div class="formItem">
			Image:
			<?php echo $model->profile->getImage(); ?>
		</div>
		<div class="formItem">
			<?php echo $this->html->link("Back to Dashboard","/dashboard"); ?>
		</div>
	
</div>