<h1>Admin</h1>
<h2>Semesters</h2>

<div class="shell_courses">
	<ul>
		<?php foreach($semesters as $sms){ ?>
			<li><?php echo anchor('semesters/show/'.$sms->getId(), $sms->getName(), array('title'=> $sms->getName())); ?>  |
			 <?php echo anchor('semesters/edit/'.$sms->getId(), "edit"); ?> |
			 <?php echo anchor('semesters/delete/'.$sms->getId(), "delete"); ?>
			 
			 <?php if($sms->getCourses()->count() > 0){ ?>
			 <span class="listHeader">Available Courses</span>
			 <ul>
			 	<?php 
			 		 $courses = $sms->getCourses()->toArray();
			 		  foreach($courses as $course){ ?>
			 			<li><?php echo anchor("/admin/courses/" . $sms->getId() ."/" . $course->getId(), $course->getName())  ?> </li>
			 	<?php } ?>
			 </ul>
			 <?php } //end if ?>
			 
			 
				<!-- li>Assign Instructors to courses <br/>
					<ul><li><?php echo anchor("/Semesters/courses/". $sms->getId(), "Assign Courses"); ?></li> </ul>-->
				<br/><?php echo anchor("/admin/assign_courses/". $sms->getId(), "Assign/Update Courses for the Semester"); ?>
			 
				
				
			 </li>
		<?php } ?>
	</ul>
	
	<?php echo anchor('/semesters/create', "Add New Semester"); ?>
</div>

