<h1>Instructors</h1>

<h3>Details</h3>
<?php //echo var_dump($instructor); ?>
<div class="shell">
	
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
			Department:
			<?php foreach($instructor->getDepartments() as $dept){ ?>
				<?=  $dept->getName(); ?>
			<?php } ?>
		</div>
</div>

<div class="formItem">
	<?php echo $this->html->link("Back to Index","instructors/index"); ?>
</div>