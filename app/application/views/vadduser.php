
<div class="subcontainer" style="width:90%;">
<div class="panel panel-default">
<div class="panel-heading">Add a New User</div>
<div class="panel-body">

<form class="exam_form" action="<?php echo site_url('exams/adduserstatus');?>" method="POST" enctype="multipart/form-data">

<fieldset>

<label>Enter the User Name</label>
<br>
<input type="text" name="uname" value="<?php echo set_value('uname'); ?>" size="250" class="form-control">


<br><br>
<label>Enter the Password</label>
<br>
<input type="password" name="pass" value="<?php echo set_value('pass'); ?>" size="250" class="form-control">

</fieldset>  
<br><br>
<button type="submit" name="submit" class="btn btn-primary">Submit</button><br><br>
<?php echo validation_errors(); ?>
</form>


<script>
function myFunction() {
    var x = document.getElementById("reportID").value;
    switch(x)
	{
		case '1':
		document.getElementById("info").innerHTML = "The Overall Pass Percentage report displays the percentage of students who have passed in all subjects.";
		break;
		case '2':
		document.getElementById("info").innerHTML = "The Department Pass Percentage report displays the percentage of students who have passed in all subjects for each department.";
		break;
		case '3':
		document.getElementById("info").innerHTML = "The Overall College Topper report displays the student who has the highest percentage.";
		break;
		case '4':
		document.getElementById("info").innerHTML = "The Department Pass Percentage report provides the percentage of students who have passed in all subjects for each department of college.";
		break;
		case '5':
		document.getElementById("info").innerHTML = "The Student Rank report provides the percentage of students who have passed in all subjects for each department of college.";
		break;
	}
	
}
</script>

</div>
</div>
</div>
