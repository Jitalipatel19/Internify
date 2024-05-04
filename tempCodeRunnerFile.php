<?php
session_start();
include("header.php");
include("conn.php");
function generateRandomNumber($length) {
    $characters = '0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
if(isset($_POST['btnsubmit'])) {
    $nm=$_POST['txtnm'];
    $snm=$_POST['txtsnm'];
    $gen=$_POST['txtgen'];
    $clg=$_POST['txtclg'];
    $desig=$_POST['txtdesig'];
    $dept=$_POST['txtdept'];
    $cnm=$_POST['txtcnm'];
    $email=$_POST['txtemail'];
    $pwd = generateRandomNumber(4);
    $mno=$_POST['txtmno'];
    $res1=mysqli_query($conn,"select * from faculty_regis where email='$email'");
    if(mysqli_num_rows($res1)>0) {
        echo "<script type='text/javascript'>";
        echo "alert('Email Already Exists');";
        echo "window.location.href='faculty_regis.php';";
        echo "</script>";
    } else {
        //auto no code start..
        $qur1=mysqli_query($conn,"select max(fid) from faculty_regis");
        $mid=0;
        while($q1=mysqli_fetch_array($qur1)) {
            $mid=$q1[0];
        }
        $mid++;
        //auto no code end..
        $query="insert into faculty_regis
        (fid,name,surname,gender,mno ,email,pwd,dept,desig,coursenm,clg) 
        values('$mid', '$nm', '$snm', '$gen', '$mno', '$email', '$pwd','$desig', '$dept','$cnm', '$clg')";
        if(mysqli_query($conn, $query)) {
            echo "<script type='text/javascript'>";
            echo "alert('Faculty Registered Successfully');";
            echo "window.location.href='login.php';";
            echo "</script>";
        }
    }
}
?>
<!-- Registration Form Start -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="bg-light rounded p-5">
                <div class="section-title section-title-sm position-relative pb-3 mb-4">
                    <h3 class="mb-0">Faculty Registration</h3>
                </div>
                <form method="post">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="txtnm" class="form-label">Name</label>
                            <input type="text" name="txtnm" class="form-control" placeholder="Name">
                        </div>
                        <div class="col-md-6">
                            <label for="txtsnm" class="form-label">Surname</label>
                            <input type="text" name="txtsnm" class="form-control" placeholder="Surname">
                        </div>
                        <div class="col-md-6">
                            <label for="txtgen" class="form-label">Gender</label>
                            <input type="text" name="txtgen" class="form-control" placeholder="Gender">
                        </div>
                        <div class="col-md-6">
                            <label for="txtmno" class="form-label">Mobile No</label>
                            <input type="text" name="txtmno" class="form-control" placeholder="Mobile No">
                        </div>
                        <div class="col-md-6">
                            <label for="txtclg" class="form-label">College Name</label>
                            <input type="text" name="txtclg" class="form-control" placeholder="College Name">
                        </div>
                        <div class="col-md-6">
                            <label for="txtdept" class="form-label">Department</label>
                            <input type="text" name="txtdept" class="form-control" placeholder="Department">
                        </div>
                        <div class="col-md-6">
                            <label for="txtdept" class="form-label">Designation</label>
                            <input type="text" name="txtdesig" class="form-control" placeholder="Designation">
                        </div>
                        <div class="col-md-6">
                            <label for="txtcnm" class="form-label">Course Name</label>
                            <input type="text" name="txtcnm" class="form-control" placeholder="Department">
                        </div>
                        <div class="col-md-6">
                            <label for="txtemail" class="form-label">Email</label>
                            <input type="email" name="txtemail" class="form-control" placeholder="Email">
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary w-100 py-3" name="btnsubmit" type="submit">Submit</button>
                        </div>
                        <div class="col-md-6">
                            <a href="student_login.php" class="btn btn-outline-primary w-100 py-3">Already Registered? Login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Registration Form End -->


<?php
include("footer.php");
?>