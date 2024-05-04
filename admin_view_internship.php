<?php
include("admin_report_header.php");
include("conn.php");
?>
<div class="container">
    <h3 class="text-center mb-4">Internship Info</h3>
    <?php
    $res4 = mysqli_query($conn, "SELECT ia.*, sr.clg FROM intern_applications_info AS ia INNER JOIN student_regis AS sr ON ia.erno = sr.erno");
    if (mysqli_num_rows($res4) > 0) {
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Intern Name</th>
                        <th>ERNO</th>
                        <th>Education</th>
                        <th>College Name</th>
                        <th>Company Name</th>
                        <th>Position</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($r4 = mysqli_fetch_array($res4)) {
                        echo "<tr>";
                        echo "<td>" . $r4[0] . "</td>";
                        echo "<td>" . $r4[2] . "</td>";
                        echo "<td>" . $r4[3] . "</td>";
                        echo "<td>" . $r4[5] . "</td>";
                        echo "<td>" . $r4['clg'] . "</td>";
                        echo "<td>" . $r4[12] . "</td>";
                        echo "<td>" . $r4[11] . "</td>";
                        echo "<td>" . $r4[13] . "</td>";
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
