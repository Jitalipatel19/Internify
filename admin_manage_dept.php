<?php
include("conn.php");
session_start();
include("admin_header.php");
if(isset($_POST['btnregis']))
{
	$dname=$_POST['txtdnm'];
    $desig=$_POST['txtdesig'];
	$res1=mysqli_query($conn,"select * from dept_detail where dept_name='$dname'");
	if(mysqli_num_rows($res1)>0)
	{
		echo "<script type='text/javascript'>";
		echo "alert('Deparment Already Exists');";
		echo "window.location.href='admin_manage_dept.php';";
		echo "</script>";
	}else{
		//auto no code start..
		$qur1=mysqli_query($conn,"select max(dept_id) from dept_detail");
		$mid=0;
		while($q1=mysqli_fetch_array($qur1))
		{
			$mid=$q1[0];
		}
		$mid++;
		//auto no code end..
		$query="insert into dept_detail values('$mid','$dname','$desig')";
		if(mysqli_query($conn,$query))
		{
			echo "<script type='text/javascript'>";
			echo "alert('Department Saved Successfully');";
			echo "window.location.href='login.php';";
			echo "</script>";
		}
	}
}
?>
<!-- Tags Start -->
<div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                        <div class="section-title section-title-sm position-relative pb-3 mb-4">
                            <h3 class="mb-0">Tasks</h3>
                        </div>
                        <div class="d-flex flex-wrap m-n1">
                            <a href="admin_manage_dept.php" class="btn btn-light m-1">Manage Departments</a>
                            <a href="admin_manage_stud.php" class="btn btn-light m-1">Manage Students</a>
                            <a href="admin_manage_faculty.php" class="btn btn-light m-1">Manage Faculties</a>
                            <a href="admin_manage_prj_in.php" class="btn btn-light m-1">Manage Projects/Internship</a>
                            <a href="admin_manage_stud_data.php" class="btn btn-light m-1">Request Student Data</a>
                            <a href="admin_reports.php" class="btn btn-light m-1">Reports</a>
                        </div>
                    </div>
                    <!-- Tags End -->
  <!-- Registration Form Start -->
  <div class="bg-light rounded p-5">
                        <div class="section-title section-title-sm position-relative pb-3 mb-4">
                            <h3 class="mb-0">Manage Department</h3>
                        </div>
                        <form method="post">
                            <div class="row g-3 owl">
                                <div class="col-12 col-sm-6">
                                    <label for="dept">Department Name</label>
                                    <input type="text" name="txtname" class="form-control bg-white border-0"  style="height: 45px;">
                                </div>
                                <div class="col-12 col-sm-6">
                                <label for="desig">Designation</label>
                                    <input type="text" name="txtsnm" class="form-control bg-white border-0"  style="height: 45px;">
                                </div>
                                <div class="col-12 col-6">
                                    <button class="btn btn-primary w-100 py-3"  name="btnsave" type="submit">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Registraion Form End -->
<?php
include("footer.php");
?>