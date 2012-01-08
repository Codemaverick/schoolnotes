<?php //$this->setViewMaster('layouts/layout-home.chtm'); ?>
<?php $this->title("Welcome to SchoolNotes"); ?>
<div class="row">
	
		<div class="span-one-third">
			<h2>City College of New York</h2>
			<p>
				SchoolNotes is your centralized resource for the class notes, assignments, 
				due dates and resources supplied by your professor.
			</p>
			<p>
				Subscribe to be notified when your professor posts class notes, assignments and class announcements.
			</p>
			<h4>Announcements/Notices?</h4>
			<p>Final Exams start ONE WEEK</p>
		</div>	
	
		<div class="span-one-third">
			<form method="post" action="/home/findbyprofessor/">
				<h4>Search Professor/Class:</h4>
				<input type="text" name="prof_search" id="prof_search" class="formInput" />
				<input type="submit" value="Search" class="formBtn" id="prof_submit_btn" />
			</form>
			<div class="itemlist">
				<h4>Recent Updates</h4>
				<?php if(($instructors) && (count($instructors) > 0)) { ?>
					<ul class="contentList">
						<?php foreach($instructors as $ins){ ?>
							<li><?php echo $this->html->link($ins->getUser()->getFullName(), '/professors/'. $ins->getUser()->getUserName()); ?></li>
						<?php } ?>
					</ul>
				<?php } ?>
			</div>
		</div>
		
		<div class="span-one-third">
			
				<h3>Browse Directory</h3>
				<div class="sub-section">
				<h4>By Subject</h4>
				<?php if(($courses) && (count($courses) > 0)) { ?>
					<ul class="contentList">
						<?php foreach($courses as $crs){ ?>
							<li><?php echo $this->html->link($crs->getName(), '/courses/show/'. $crs->getId()); ?></li>
						<?php } ?>
					</ul>
				<?php } ?>
				</div>
				<div class="sub-section">
				<h4>By Professor</h4>
				<?php if(($instructors) && (count($instructors) > 0)) { ?>
					<ul class="contentList">
						<?php foreach($instructors as $ins){ ?>
							<li><?php echo $this->html->link($ins->getUser()->getFullName(), '/professors/'. $ins->getUser()->getUserName()); ?></li>
						<?php } ?>
					</ul>
				<?php } ?>
				</div>
			
		</div>
	
</div>
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