<div class="subcontainer" style="width:90%;">
<div class="panel panel-default">
<div class="panel-heading">Add a New Exam Entry</div>
<div class="panel-body">

<form class="exam_form" action="<?php echo site_url('login/verify');?>" method="POST" enctype="multipart/form-data">
<fieldset>
<label>Enter the exam name (Only alphabets,numbers and spaces allowed)</label>
<br>
<input type="text" name="ename" class="form-control">
</fieldset>  
<br><br>
<button type="submit" name="submit" class="btn btn-primary">Submit</button>
<?php echo validation_errors(); ?>
</form>


</div>
</div>
</div>


