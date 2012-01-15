<?php $this->setViewData('title', "Site Administration"); ?>
<div class="shell">
	<div class="shell_header">
		<div class="shell_branding">
		<h4><?php echo $model->school->getName(); ?></h4>
		<h3>Admin</h3>
		</div>
	</div>
	<div class="shell_courses">
		<p>
			Welcome to SchoolNotes. Create your account with the following steps:
			<ul class="menu">
				<li>Manage departments / Add/Remove Courses <br/>
					<?= $this->html->link("Departments","/admin/Departments/"); ?>
				</li>
				<!--
				<?php if(($model->departments)&&(count($model->departments) > 0)){ ?>
					<li>Create a list of courses <br/>
						<?= $this->html->link("Courses","/admin/Courses/"); ?>
					</li>
				<?php } ?>
				-->
				<li>Create a list of instructors/professors <br/>
					<?= $this->html->link("Instructors","admin/Instructors/"); ?>
				</li>
				<li>Initialize a semester <br/>
					<?= $this->html->link("Semesters","/admin/semesters"); ?>
				</li>
				<li>Assign Roles <br/>
					<?= $this->html->link("Roles", "/dashboard/roles/users"); ?>
				</li>
				
				
			</ul>
		</p>
		
	</div>
	<div class="clearfix"></div>
</div>