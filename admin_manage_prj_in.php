<?php
include("admin_header.php");
include("conn.php");
?>
<!-- Tags Start -->
<div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
    <div class="section-title section-title-sm position-relative pb-3 mb-4">
        <h3 class="mb-0">Tasks</h3>
    </div>
    <div class="d-flex flex-wrap m-n1">
        <a href="faculty_view_assigned_stud.php" class="btn btn-light m-1">View Students Assigned</a>
        <a href="faculty_manage_project.php" class="btn btn-light m-1">Manage Projects</a>
        <a href="faculty_manage_score.php" class="btn btn-light m-1">Manage Scores</a>
        <a href="faculty_profile.php" class="btn btn-light m-1">Profile</a>
        <a href="faculty_give_score.php" class="btn btn-light m-1">Give Score</a>
    </div>
</div>
<!-- Tags End -->
<?php
$res4 = mysqli_query($conn, "SELECT * FROM intern_applications_info WHERE application_status='approved'");
if (mysqli_num_rows($res4) > 0) {
    echo "<h3>Score</h3>";
    echo "<table class='table table-bordered'>
            <tr>
                <th>NO</th>
                <th>STUDENT NAME</th>
                <th>ENROLLMENT NO</th>
                <th>COMPANY NAME</th>
                <th>PROJECT TITLE</th>
                <th>ASSIGN GUIDE</th>
            </tr>";
    while ($r4 = mysqli_fetch_array($res4)) {
        // Fetch project title from project_info table
        $project_query = "SELECT prj_title FROM project_info WHERE intern_name='$r4[2]'";
        $project_result = mysqli_query($conn, $project_query);
        $project_row = mysqli_fetch_assoc($project_result);
        $project_title = $project_row['prj_title'];

        echo "<tr>";
        echo "<td>$r4[1]</td>";
        echo "<td>$r4[2]</td>";
        echo "<td>$r4[3]</td>";
        echo "<td>$r4[12]</td>";
        echo "<td>$project_title</td>";
        echo "<td><a href='admin_assign_guide.php?sid=$r4[0]&name=$r4[2]&eno=$r4[3]&cname=$r4[12]&ptitle=$project_title'>Assign Guide</a></td>"; // Pass student name, enrollment number, company name, and project title in the URL
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<h2>No Data Found</h2>";
}
?>

<?php
include("footer.php");
?>
