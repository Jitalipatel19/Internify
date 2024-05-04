<?php
include("header.php");
session_start();
include("conn.php");
if(isset($_POST['btnlogin']))
{
    
	$email=$_POST['txtemail'];
	$pwd=$_POST['txtpwd'];
	$res1=mysqli_query($conn,"select * from admin_login where email_id='$email' and pwd='$pwd'");
	if(mysqli_num_rows($res1)>0)
	{
		echo "<script type='text/javascript'>";
		echo "alert('Admin Login Successfull');";
		echo "window.location.href='admin_tasks.php';";
		echo "</script>";
	}else{
		$res2=mysqli_query($conn,"select * from faculty_regis where email='$email' and pwd='$pwd'");
		if(mysqli_num_rows($res2)>0)
		{
			$r2=mysqli_fetch_array($res2);
			$_SESSION['fid']=$r2[0];
			echo "<script type='text/javascript'>";
			echo "alert('Faculty Login Successfull');";
			echo "window.location.href='faculty_profile.php';";
			echo "</script>";
		}else{
            $res3=mysqli_query($conn,"select * from company_info where email='$email' and pwd='$pwd'");
            if(mysqli_num_rows($res3)>0)
            {
                $r3=mysqli_fetch_array($res3);
                $_SESSION['cid']=$r3[0];
                echo "<script type='text/javascript'>";
                echo "alert('Company Login Successfull');";
                echo "window.location.href='company_post_vacancy.php';";
                echo "</script>";
            }
        else{
				echo "<script type='text/javascript'>";
				echo "alert('Check Your Email ID or Password');";
				echo "window.location.href='login.php';";
				echo "</script>";
			}
		}
	}
}
?>
<!-- Form section -->
<div class="container login-form-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="bg-primary rounded h-100 d-flex align-items-center p-5 wow zoomIn" data-wow-delay="0.9s">
                <form method="post">
                    <div class="row g-3">
                        <div class="col-12">
                            <h2 class="text-white mb-4">Login</h2>
                        </div>
                        <div class="col-12">
                            <label for="txtemail" class="form-label text-white">Email</label>
                            <input type="text" name="txtemail" id="txtemail" class="form-control bg-light border-0" placeholder="Enter your email" style="height: 55px;">
                        </div>
                        <div class="col-12">
                            <label for="txtpwd" class="form-label text-white">Password</label>
                            <input type="password" name="txtpwd" id="txtpwd" class="form-control bg-light border-0" placeholder="Enter your password" style="height: 55px;">
                        </div>
                        <div class="col-12">
                            <button class="btn btn-dark btn-lg w-100" type="submit" name="btnlogin">Login</button>
                        </div>
                        <div class="col-12">
                            <a href="student_regis.php" class="text-white">Don't have an account? Create one</a>
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
