<h1>Admin</h1>

<h2>Assign Courses for the <?php echo $model->semester->getName();  ?> semester</h2>

<div>
	<p>Semester Keys <?php echo var_dump($model->semester->getCourses()->getKeys()) ?></p>
	<form id="course_assign" action="/admin/assign" method="post">
	<?php if($model->courses){  ?>
		<table id="courseList">
			<?php foreach($model->courses as $cs){ ?>
				<tr>
					<td>
						<?php if($model->semester->getCourses()->contains($cs)){ ?>
						<input type="checkbox" name="courses[]" checked="checked" id="courses" value="<?php echo $cs->getId(); ?>" />
						<?php } else { ?>
						<input type="checkbox" name="courses[]" id="courses" value="<?php echo $cs->getId(); ?>" />
						<?php } ?>
					</td>
					<td>
						<?php echo anchor('courses/show/'.$cs->getId(), $cs->getName(), array('title'=> $cs->getName())); ?> 
					</td>
				</tr>
			<?php } ?>
		</table>
		<input type="hidden" name="semesterId" value="<?php echo $model->semester->getId(); ?>" />
		<input type="submit" name="submit" value="Assign Courses" />
	</form>	
	<?php } ?>
	<?php echo anchor('/admin/semesters', "Back to Semester List"); ?>
</div>

<?php echo render_partial("_scripts") ?>

<script type="text/javascript">

	$(document).ready(function(){
	
		function init(){
		
		}
	
		init();
	});

</script>