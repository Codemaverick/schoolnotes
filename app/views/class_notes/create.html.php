<h1><?php echo $section->getCourse()->getName() . ' - ' . $section->getSection(); ?> </h1>

<h4>Create New Class/Lecture Note</h4>
<div>
	<form method="post" action="/dashboard/classnotes/create_new">
		<div class="formItem">
			<label>Name</label>
			<input type="text" name="classnote[name]" value="" id="classnote_name" />
		</div>
		<div class="formItem">
			<label>Text/Notes</label>
			<textarea id="classnote_note" name="classnote[note]" value=""></textarea>
		</div>
		<div class="formItem">
			<label>Attachment</label>
			<input type="text" id="classnote_attachment" name="classnote[attachment]" value="" />
		</div>
		<div class="formItem">
			<input type="hidden" name="classnote[section]" value="<?php echo $section->getId() ?>" />
			<input type="submit" id="submitBtn" value="Create" />
		</div>
		
		
	</form>
	
</div>