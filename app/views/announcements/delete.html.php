<?php set_page_title($ann->getCourseSection()->getSection()); ?>
<h1>Delete</h1>

<h4>Are You Sure?</h4>
<div>
	<form method="post" action="/dashboard/announcements/destroy">
		<div class="formItem">
			Subject:
			<?php echo $ann->getTitle(); ?>
		</div>
		<div class="formItem">
			<input type="hidden" name="announcement[section]" value="<?php echo $ann->getCourseSection()->getId(); ?>" />
			<input type="hidden" name="announcement[id]" value="<?php echo $ann->getId(); ?>" />
			<input type="submit" id="submitBtn" value="Delete" name="submit" />
		</div>
		<div class="formItem">
			<?php echo anchor('dashboard/courseview/show/' . $ann->getCourseSection()->getId(), "Cancel")  ?>
		</div>
	</form>
</div>