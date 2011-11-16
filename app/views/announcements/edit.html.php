<?php set_page_title($ann->getTitle() . " - Update"); ?>
<h1>Announcements</h1>

<h3>Edit</h3>
<div>
	<form method="post" action="/dashboard/announcements/update">
		<div class="formItem">
			<label>Subject</label>
			<input type="text" name="announcement[title]" value="<?php echo $ann->getTitle() ?>" id="announcement_title" />
		</div>
		<div class="formItem">
			<label>Text/Notes</label>
			<textarea id="announcement_text" name="announcement[text]"><?php echo $ann->getText() ?></textarea>
		</div>
		<div class="formItem">
			<label>Expires</label>
			<?php $exp = $ann->getDateExpires() ? $ann->getDateExpires()->format('Y-m-d') : ""; ?>
			<input type="text" id="announcement_dateExpires" name="announcement[dateExpires]" value="<?php echo $exp ?>" />
		</div>
		<div class="formItem">
			<input type="hidden" name="announcement[id]" value="<?php echo $ann->getId() ?>" />
			<input type="hidden" name="announcement[section]" value="<?php echo $section->getId() ?>" />
			<input type="submit" id="submitBtn" value="Update" />
		</div>
		
		
		
	</form>
	<?php echo anchor('/dashboard/courseview/show/' . $section->getId(), "Back to index"); ?>
	
</div>