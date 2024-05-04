<?php
include("admin_report_header.php");
include("conn.php");
?>
<div class="container mt-5">
    <h3 class="text-center mb-4">Faculty Info Report</h3>

    <?php
    $res4=mysqli_query($conn,"select * from faculty_regis");
    if(mysqli_num_rows($res4)>0)
    {
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-striped'>";
        echo "<tr>
                <th>ID</th>
                <th>NAME</th>
                <th>SURNAME</th>
                <th>MNO</th>
                <th>GENDER</th>
                <th>EMAIL</th>
                <th>PASSWORD</th>
                <th>DESIGNATION</th>
                <th>DEPARTMENT</th>
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
            echo "<td>$r4[7]</td>";
            echo "<td>$r4[8]</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }else{
        echo "<h2 class='text-center'>No Data Found</h2>";
    }
    ?>
</div>

<?php
include("footer.php");
?>
