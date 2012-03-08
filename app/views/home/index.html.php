<?php //$this->setViewMaster('layouts/layout-home.chtm'); ?>
<?php //$this->setViewData('title', "Welcome to SchoolNotes"); ?>

<section class="triptych">
	<p>
		Hello There! SchoolNotes is your centralized resource for the class notes, assignments, 
		due dates and resources supplied by your professor.
	</p>
	<p>
		Subscribe to be notified when your professor posts class notes, assignments and class announcements.
	</p>	
</section>
<section class="triptych">
	<form method="post" action="/home/findbyprofessor/">
		<div class="fp_section right">
		<h4>Find Your Professor:</h4>
		<input type="text" name="prof_search" id="prof_search" class="formInput" />
		<input type="submit" value="Search" class="formBtn" id="prof_submit_btn" />
	</form>
	<div class="itemlist">
		<?php if(($instructors) && (count($instructors) > 0)) { ?>
			<ul class="contentList">
				<?php foreach($instructors as $ins){ ?>
					<li><?php echo $ins->getUser()->getFullName(); ?></li>
				<?php } ?>
			</ul>
		<?php } ?>
	</div>
</section>
<section  class="triptych">
	<form method="post" action="/home/findbycourse/">
		<div class="fp_section right">
		<h4>Find Your Course:</h4>
		<input type="text" name="course_search" id="course_search" class="formInput" />
		<input type="submit" value="Search" class="formBtn" id="course_submit_btn" />
	</form>
</div>
<div>

</div>
</section>

<?php //echo render_partial("_scripts") ?>

<script type="text/javascript">

	$(document).ready(function(){
	
		var schoolTxt;
		var schoolsList = ['New York University', 'BMCC', 'City College of New York', 'Columbia University'];
		
		function init(){
		
			schoolTxt = $('#school_search');
			schoolTxt.autocomplete({
			source: schoolsList,
			minLength: 2
			});
		}
	
		init();
	});

</script>