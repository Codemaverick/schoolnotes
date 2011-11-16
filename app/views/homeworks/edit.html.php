<?php set_page_title($homework->getName() . " - Update"); ?>
<h1>Homeworks</h1>

<h3>Edit</h3>
<div>
	<form method="post" action="/dashboard/homeworks/update">
		<div class="formItem">
			<label>Name</label>
			<input type="text" name="homework[name]" value="<?php echo $homework->getName(); ?>" id="homework_name" />
		</div>
		<div class="formItem">
			<label>Due Date:</label>
			<input type="text" id="homework_dateDue" name="homework[dateDue]" value="<?php echo $homework->getDateDue(); ?>" />
		</div>
		<div class="formItem">
			<label>Text/Notes</label>
			<textarea id="homework_text" name="homework[text]" value=""><?php echo $homework->getText(); ?></textarea>
		</div>
		<div class="formItem">
			<label>Attachment</label>
			<input type="text" id="homework_attachment" name="homework[attachment]" value="" />
		</div>
		<div class="formItem">
			<input type="hidden" name="homework[id]" value="<?php echo $homework->getId(); ?>" />
			<input type="hidden" name="homework[section]" value="<?php echo $section->getId() ?>" />
			<input type="submit" id="submitBtn" value="Update" />
		</div>
		
		
		
	</form>
	<?php echo anchor('/dashboard/courseview/show/' . $section->getId(), "Cancel"); ?>
	
</div>