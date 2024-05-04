<?php
session_start();
include("conn.php");
include("student_header.php");
?>
<div class="bg-light rounded p-5">
    <div class="section-title section-title-sm position-relative pb-3 mb-4">
        <h3 class="mb-0">Apply For Internship</h3>
    </div>
    <?php
    // Loop through the data and populate the form field
    $sql="select * from student_regis where sid='$_SESSION[sid]'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        ?>
        <form method="post">
            <div class="row g-3 owl">
                <div class="col-12 col-sm-6">
                    <label for="">Intern Name</label>
                    <input type="text" name="txtinm" class="form-control bg-white border-0" placeholder="Intern Name" value="<?php echo $row['name']; ?>" style="height: 45px;">
                </div>
                <div class="col-12 col-sm-6">
                    <label for="">Enrollment No</label>
                    <input type="text" name="txterno" class="form-control bg-white border-0" placeholder="Enrollment No" value="<?php echo $row['erno']; ?>" style="height: 45px;">
                </div>
                <?php
    }
?>
                <div class="col-12 col-sm-6">
                    <label for="">Education</label>
                    <input type="text" name="txtedu" class="form-control bg-white border-0" placeholder="Education" style="height: 45px;">
                </div>
                <div class="col-12 col-sm-6">
                    <label for="">Current Sem</label>
                    <input type="text" name="txtcs" class="form-control bg-white border-0" placeholder="Current Sem" style="height: 45px;">
                </div>
                <div class="col-12 col-sm-6">
                    <label for="">Starting  Year</label>
                    <input type="text" name="txtsy" class="form-control bg-white border-0" placeholder="Accademic Year" style="height: 45px;">
                </div>
                <div class="col-12 col-sm-6">
                    <label for="">Ending  Year</label>
                    <input type="text" name="txtey" class="form-control bg-white border-0" placeholder="Accademic Year" style="height: 45px;">
                </div>
                <div class="col-12 col-6 col-sm-6">
                    <label for="">Experience</label>
                    <input type="text" name="txtexp" class="form-control bg-white border-0" placeholder="Experience" style="height: 45px;">
                </div>
                <div class="col-12 col-6 col-sm-6">
                    <label for="">Resume</label>
                    <input type="file" name="res" class="form-control" required data-parsley-required-message="Please select your resume*" data-rule="doc:2" data-msg="Upload File within specified file size upto 2MB"  />
                </div>
                <div class="col-12 col-6 col-sm-6">
    <label for="">Position</label>
    <select class="form-control" name="position" id="position" required data-parsley-required-message="Select Position*">
        <option value="" disabled selected>Select Position*</option>
        <?php 
        $select_positions = "SELECT * FROM `vacancy_info`";
        $qry_positions = mysqli_query($conn, $select_positions);
        while ($position_assoc = mysqli_fetch_assoc($qry_positions)) {
            ?>
            <option value="<?php echo $position_assoc['vid']?>"><?php echo $position_assoc['position'];?></option>  
        <?php
        }
        ?>
    </select>
</div>

<div class="col-12 col-6 col-sm-6">
                    <label for="">Company Name</label>
                    <select class="form-control" name="company" id="company" required data-parsley-required-message="Select District*">
                        <option value="" disabled selected>Select Company*</option>
                        <?php 
                        $select_companies = "SELECT * FROM `company_info`";
                        $qry_companies = mysqli_query($conn, $select_companies);
                        while ($company_assoc = mysqli_fetch_assoc($qry_companies)) {
                            ?>
                            <option value="<?php echo $company_assoc['cid']?>"><?php echo $company_assoc['name'];?></option>  
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-12 col-6">
                    <button class="btn btn-primary w-100 py-3"  name="btnsubmit" type="submit">Submit</button>
                </div>
                <div class="col-12 col-6">
                    <p>Application Status</p>
                </div>
            </div>
        </form>
    </div>
                    <!-- Company Form End -->

<?php
include("footer.php");
?>
<?php
include("admin_header.php");
include("conn.php");
?>
<?php
if(isset($_REQUEST['eeid']))
{
	$eid1=$_REQUEST['eeid'];
	$qur2=mysqli_query($conn,"select * from event_master where event_id='$eid1'");
	$q2=mysqli_fetch_array($qur2);
	
	$name1=$q2[2];
	$desc1=$q2[3];
	$sdate1=$q2[4];
	$edate1=$q2[5];
	$timings1=$q2[6];
	$eimg1=$q2[7];
}

if(isset($_POST['btnedit']))
{
	$name=$_POST['txtname'];
	$desc=$_POST['txtdesc'];
	$timings=$_POST['txttimings'];
	$udate=date("Y-m-d");
	$sdate=date("Y-m-d",strtotime($_POST['txtsdate']));
	$edate=date("Y-m-d",strtotime($_POST['txtedate']));
	
	$eid=$_REQUEST['eeid'];
	
	if($_FILES['txtimg']['size']>0)
	{
		$tmppath=$_FILES['txtimg']['tmp_name'];
		$imgpath="event_img/EI".$eid."_".rand(1000,9999).".png";	
		move_uploaded_file($tmppath,$imgpath);
		$query="update event_master set event_name='$name',event_description='$desc',event_start_date='$sdate',event_end_date='$edate',event_timings='$timings',event_img='$imgpath' where event_id='$eid'";	
	}else{
		$query="update event_master set event_name='$name',event_description='$desc',event_start_date='$sdate',event_end_date='$edate',event_timings='$timings' where event_id='$eid'";	
	}
	
	
	if(mysqli_query($conn,$query))
	{
		echo "<script type='text/javascript'>";
		echo "alert('Event Record Updated Successfull');";
		echo "window.location.href='admin_manage_events.php';";
		echo "</script>";
	}
}

if(isset($_REQUEST['edid']))
{
	$eid1=$_REQUEST['edid'];
	$query="delete from event_master where event_id='$eid1'";
	if(mysqli_query($conn,$query))
	{
		echo "<script type='text/javascript'>";
		echo "alert('Event Record Deleted Successfull');";
		echo "window.location.href='admin_manage_events.php';";
		echo "</script>";
	}
}
?>
    <div class="header banner">
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-12">
                        <h1><a class="brand" href="#">Yoga Classes</a></h1>
                        <!-- <a class="brand" href="index.html"><img alt="Logo" src="img/logo.jpg"></a> -->
                    </div>
                </div>

                <div class="col-md-12">
                    <h1></h1>
                </div>
            </div>
        </div>
        <!-- Header Section End -->
        
        <!-- Contact Section Start -->
        <div id="contact" style="padding-top: 50px;">
            <div class="container">
                <div class="section-header">
                    <h2>MANAGE EVENTS DETAIL</h2>
                  
                </div>
                
                <div class="row contact-form">
                    <div class="col-md-6 contact-col">
                        <div class="contact-form">
                           <form  name="form1" id="contactForm" method="post" enctype="multipart/form-data">
                               <div class="control-group">
								<span style='color:#FFFFFF; float:left;' >Enter Event Name</span>
                                    <input type="text" class="form-control" name="txtname" placeholder="Enter Event Name"  value="<?php echo $name1; ?>"/>
                                    <p class="help-block text-danger"></p>
                                </div>
								<div class="control-group">
								<span style='color:#FFFFFF; float:left;' >Enter Event Description</span>
                                    <textarea class="form-control" name="txtdesc" rows="3" placeholder="Enter Event Description" ><?php echo $desc1; ?></textarea>
                                    <p class="help-block text-danger"></p>
                                </div>
								
								 <div class="control-group">
								<span style='color:#FFFFFF; float:left;' >Enter Event Timings</span>
                                    <input type="text" class="form-control" name="txttimings" placeholder="Enter Event Timings"  value="<?php echo $name1; ?>"/>
                                    <p class="help-block text-danger"></p>
                                </div>								
                               <br/><br/>
                        </div>
                    </div>
                    <div class="col-md-6 contact-col">
                        <div class="contact-form">
                            <div id="success"></div>
								<div class="control-group">
									<span style='color:#FFFFFF; float:left;' >Select Start Date</span>
                                    <input type="date" class="form-control" name="txtsdate"  value="<?php if(isset($sdate1)){ echo $sdate1; }else{ echo date("Y-m-d",strtotime("+1 days")); } ?>" min="<?php echo date("Y-m-d",strtotime("+1 days")); ?>" />
                                    <p class="help-block text-danger"></p>
                                </div>
								<div class="control-group">
									<span style='color:#FFFFFF; float:left;' >Select End Date</span>
                                    <input type="date" class="form-control" name="txtedate"  value="<?php if(isset($edate1)){ echo $edate1; }else{ echo date("Y-m-d",strtotime("+1 days")); }  ?>" min="<?php echo date("Y-m-d",strtotime("+1 days")); ?>" />
                                    <p class="help-block text-danger"></p>
                                </div>
							
								<div class="control-group">
									<span style='color:#FFFFFF; float:left;' >Select Event Banner Images</span>
                                    <input type="file" class="form-control" name="txtimg" id="txtimg"  />
                                    <p class="help-block text-danger"></p>
                                </div>
								<br/>
								
                                <div class="button">
								<?php
								if(isset($_REQUEST['eeid']))
								{
									?>
									<img src='<?php echo $eimg1; ?>' style="width:150px; height:150px;">
									<button type="submit" name="btnedit" onclick="return edit_validation();">EDIT</button>
									<?php
								}else{
									?>
									<button type="submit" name="btnsave" onclick="return validation();">SAVE</button>
									<br/>
									<?php
									
								}
								?>
								
								</div>
                            </form>
                        </div>
                    </div>
					
					
                </div>
				<div class="row">
				<div class="col-md-12 contact-col">
					
                    <?php
					$res4=mysqli_query($conn,"select * from event_master");
					if(mysqli_num_rows($res4)>0)
					{
						echo "<table class='table table-bordered'>
								<tr>
									<th>EVENT ID</th>
									<th>UPLOAD DATE</th>
									<th>EVENT NAME</th>
									<th>DESCRIPTION</th>
									<th>START DATE</th>
									<th>END DATE</th>
									<th>TIMINGS</th>
								
									<th>EVENT IMAGE</th>
									<th>EDIT</th>
									<th>DELETE</th>
								</tr>";
						while($r4=mysqli_fetch_array($res4))
						{
							echo "<tr>";
							echo "<td>$r4[0]</td>";
							echo "<td>$r4[1]</td>";
							echo "<td>$r4[2]</td>";
							echo "<td>$r4[3]</td>";
							echo "<td>$r4[4]</td>";
							echo "<td>$r4[5]</td>";
							echo "<td>$r4[6]</td>";
							echo "<td><img src='$r4[7]' style='width:150px; height:150px;'></td>";
							echo "<td><a href='admin_manage_events.php?eeid=$r4[0]'>EDIT</a></td>";
							echo "<td><a href='admin_manage_events.php?edid=$r4[0]'>DELETE</a></td>";
							echo "</tr>";
						}
						echo "</table>";
					}else{
						echo "<h2>No Course Found</h2>";
					}
					
					?>
                         
                       
                    </div>
				</div>
            </div>
        </div>
        <!-- Contact Section Start -->
        

<?php
include("footer.php");
?>