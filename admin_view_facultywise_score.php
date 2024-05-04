<?php
include("admin_report_header.php");
include("conn.php");
?>
<div class="container">
    <h3 class="text-center mb-4">Guidewise Info</h3>

    <?php
    $res4 = mysqli_query($conn, "SELECT ag.*, sr.clg, si.score FROM assigned_guide_info AS ag INNER JOIN student_regis AS sr ON ag.erno = sr.erno LEFT JOIN score_info AS si ON sr.erno = si.erno");
    if (mysqli_num_rows($res4) > 0) {
        ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Guide Name</th>
                        <th>Student Name</th>
                        <th>Enrollment No</th>
                        <th>College Name</th>
                        <th>Project Title</th>
                        <th>Company Name</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($r4 = mysqli_fetch_array($res4)) {
                        echo "<tr>";
                        echo "<td>" . $r4[0] . "</td>";
                        echo "<td>" . $r4[5] . "</td>";
                        echo "<td>" . $r4[2] . "</td>";
                        echo "<td>" . $r4[1] . "</td>";
                        echo "<td>" . $r4['clg'] . "</td>";
                        echo "<td>" . $r4[3] . "</td>";
                        echo "<td>" . $r4[4] . "</td>";
                        echo "<td>" . $r4['score'] . "</td>";
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
