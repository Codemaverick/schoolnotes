<h1><?php echo $section->getCourse()->getName() . ' - ' . $section->getSection(); ?> </h1>

<h4>Create New Homework Assignment</h4>
<div>
	<form method="post" action="/dashboard/homeworks/create_new">
		<div class="formItem">
			<label>Name</label>
			<input type="text" name="homework[name]" value="" id="homework_name" />
		</div>
		<div class="formItem">
			<label>Due Date:</label>
			<input type="text" id="homework_dateDue" name="homework[dateDue]" value="" />
		</div>
		<div class="formItem">
			<label>Text/Notes</label>
			<textarea id="homework_text" name="homework[text]" value=""></textarea>
		</div>
		<div class="formItem">
			<label>Attachment:</label>
			<input type="text" id="homework_attachment" name="homework[attachment]" value="" />
		</div>
		
		<div class="formItem">
			<input type="hidden" name="homework[section]" value="<?php echo $section->getId() ?>" />
			<input type="submit" id="submitBtn" value="Create" />
		</div>
		
		
	</form>
	
</div>