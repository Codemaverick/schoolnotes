<?php set_page_title($note->getName() . " - Update"); ?>
<h1>Class Notes</h1>

<h3>Edit</h3>
<div>
	<form method="post" action="/dashboard/classnotes/update">
		<div class="formItem">
			<label>Name</label>
			<input type="text" name="classnote[name]" value="<?php echo $note->getName(); ?>" id="classnote_name" />
		</div>
		<div class="formItem">
			<label>Text/Notes</label>
			<textarea id="classnote_note" name="classnote[note]" rows="10" cols="40">
				<?php echo $note->getNote(); ?>
			</textarea>
		</div>
		<div class="formItem">
			<label>Attachment</label>
			<input type="text" id="classnote_attachment" name="classnote[attachment]" value="" />
		</div>
		<div class="formItem">
			<input type="hidden" name="classnote[id]" value="<?php echo $note->getId(); ?>" />
			<input type="hidden" name="classnote[section]" value="<?php echo $section->getId() ?>" />
			<input type="submit" id="submitBtn" value="Update" />
		</div>
		
		
		
	</form>
	<?php echo anchor("/courses", "Back to index"); ?>
	
</div>