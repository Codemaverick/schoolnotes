<?php $this->title($model->course->getName()); ?>
<?php $user = $model->professor->getUser(); ?>
<?php $this->title($model->professor->getUser()->getFullName() . " - " . $model->course->getName() . " - " . $model->coursesection->getSection()); ?>
<div class="row profile_header">
	<?php echo $this->_render('element', 'profile_manage'); ?>
</div>
<div class="shell">
	<h4>Create New Class/Lecture Note</h4>

	<form method="post" action="/dashboard/classnotes/create_new">
		<ul class="formItems">
			<li>
				<div class="formItem">
					<label>Name</label>
					<input type="text" name="classnote[name]" value="" id="classnote_name" class="formText medium" />
				</div>
			</li>
			<li>
				<div class="formItem">
					<label>Text/Notes</label>
					<textarea id="classnote_note" name="classnote[note]" value="" rows="10" class="formText medium"></textarea>
				</div>
			</li>
			<li>
				<div class="formItem">
					<label>Attachment</label>
					<input type="file" id="classnote_attachment" name="classnote[attachment]" value="" />
				</div>
			</li>
			<li>
				<div class="formItem">
					<input type="hidden" name="classnote[section]" value="<?php echo $model->coursesection->getId() ?>" />
					<input type="submit" id="submitBtn" value="Create" class="btn formBtn" />
				</div>
			</li>
		</ul>
		
		
	</form>
	
</div>