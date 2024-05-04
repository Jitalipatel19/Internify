<?php
include("header.php");
session_start();
include("conn.php");
if(isset($_POST['btnlogin']))
{
    $erno=$_POST['txterno'];
	$pwd=$_POST['txtpwd'];
	$res1=mysqli_query($conn,"select * from student_regis where erno='$erno' and pwd='$pwd'");
	if(mysqli_num_rows($res1) > 0)
	{
        $r2=mysqli_fetch_array($res1);
        $_SESSION['sid']=$r2[0];
        echo "<script type='text/javascript'>";
        echo "alert('Student Login Successful');";
        echo "window.location.href='student_profile.php';";
        echo "</script>";
	}
	else
	{
		echo "<script type='text/javascript'>";
		echo "alert('Check Your Enrollment or Password');";
		echo "window.location.href='student_login.php';";
		echo "</script>";
    }
}
?>

<div class="container mt-5"> <!-- Align the form in the center -->
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="bg-primary rounded h-100 d-flex align-items-center p-5 wow zoomIn" data-wow-delay="0.9s">
                <form method="post">
                    <div class="row g-3">
                        <h2 class="text-white mb-4">Login</h2>
                        <div class="col-12">
                            <label for="txterno" class="text-white">Enrollment no</label>
                            <input type="text" name="txterno" id="txterno" class="form-control bg-light border-0" placeholder="Enrollment no" style="height: 55px;">
                        </div>
                        <div class="col-xl-12">
                            <label for="txtpwd" class="text-white">Password</label>
                            <input type="password" name="txtpwd" id="txtpwd" class="form-control bg-light border-0" placeholder="Your Password" style="height: 55px;">
                        </div>
                        <div class="col-12">
                            <button class="btn btn-dark w-100 py-3" type="submit" name="btnlogin">Login</button>
                        </div>
                        <div class="col-12 col-6">
                            <a href="student_regis.php" class="text-white">Don't Have Account ? Create Account</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>
