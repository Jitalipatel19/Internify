<?php
include("admin_report_header.php");
include("conn.php");
?>
<div class="container">
    <h3 class="text-center mb-4">Studentwise Project</h3>

    <?php
    $res4 = mysqli_query($conn, "SELECT pi.*, sr.erno, sr.clg FROM project_info AS pi INNER JOIN student_regis AS sr ON pi.intern_name = sr.name");
    if (mysqli_num_rows($res4) > 0) {
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Enrollment No</th>
                        <th>College</th>
                        <th>Company Name</th>
                        <th>Project Title</th>
                        <th>Manager Name</th>
                        <th>Technology</th>
                        <th>Stipend</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($r4 = mysqli_fetch_array($res4)) {
                        echo "<tr>";
                        echo "<td>" . $r4[0] . "</td>";
                        echo "<td>" . $r4[1] . "</td>";
                        echo "<td>" . $r4['erno'] . "</td>"; // Display enrollment number from student_regis table
                        echo "<td>" . $r4['clg'] . "</td>"; // Display college name from student_regis table
                        echo "<td>" . $r4[2] . "</td>";
                        echo "<td>" . $r4[3] . "</td>";
                        echo "<td>" . $r4[7] . "</td>";
                        echo "<td>" . $r4[6] . "</td>";
                        echo "<td>" . $r4[8] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    } else {
        echo "<div class='alert alert-info' role='alert'>No Data Found</div>";
    }
    ?>
</div>

<?php
include("footer.php");
?>
