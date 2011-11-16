<h1><?php echo $section->getCourse()->getName() . ' - ' . $section->getSection(); ?> </h1>

<h4>Create New Announcement</h4>
<div>
	<form method="post" action="/dashboard/announcements/create_new">
		<div class="formItem">
			<label>Subject</label>
			<input type="text" name="announcement[title]" value="" id="announcement_title" />
		</div>
		<div class="formItem">
			<label>Text/Notes</label>
			<textarea id="announcement_text" name="announcement[text]" value=""></textarea>
		</div>
		<div class="formItem">
			<label>Expires</label>
			<input type="text" id="announcement_dateExpires" name="announcement[dateExpires]" value="" />
		</div>
		<div class="formItem">
			<input type="hidden" name="announcement[section]" value="<?php echo $section->getId() ?>" />
			<input type="submit" id="submitBtn" value="Create" />
		</div>
		
		
	</form>
	
</div>