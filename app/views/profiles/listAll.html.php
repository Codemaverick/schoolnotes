<?php $this->title($model->professor->getUser()->getFullName()); ?>
<div class="row profile_header">
	<?php echo $this->_render('element', 'profile_nav'); ?>
</div>
<div class="row shell"> 
	<div class="span-one-third shell_header">
		<div class="shell_profile">
			<?php echo $this->_render('element', 'profile_public_panel'); ?>
		</div>
	</div>
	<div class="span-two-thirds">
		<div class="formItem">
			Image:
			<?php echo $model->profile->getImage(); ?>
		</div>
		<div class="formItem">
			Name:
			<?php echo $model->user->getFullName(); ?>
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
	</div>
</div>