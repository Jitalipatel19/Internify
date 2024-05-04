<?php
include("faculty_header.php");
include("conn.php");

echo "<div class='container'>";
echo "<h3 class='text-center mb-4'>Manage Projects</h3>";

$res4 = mysqli_query($conn, "SELECT * FROM project_info");
if(mysqli_num_rows($res4) > 0) { 
    echo "<div class='table-responsive'>";
    echo "<table class='table table-bordered table-striped text-center'>";
    echo "<thead class='thead-dark'>
            <tr>
                <th>NO</th>
                <th>STUDENT NAME</th>
                <th>PROJECT TITLE</th>
                <th>DURATION</th>
                <th>TOOL</th>
                <th>TECHNOLOGY</th>
                <th>MANAGER NAME</th>
                <th>STIPEND AMOUNT</th>
                <th>SCORE</th>
            </tr>
        </thead>";
    
    while($r4 = mysqli_fetch_array($res4)) {
        echo "<tr>";
        echo "<td>$r4[0]</td>";
        echo "<td>$r4[1]</td>";
        echo "<td>$r4[2]</td>";
        echo "<td>$r4[3]</td>";
        echo "<td>$r4[4]</td>";
        echo "<td>$r4[5]</td>";
        echo "<td>$r4[6]</td>";
        echo "<td>$r4[7]</td>";
        echo "<td><a href='faculty_manage_score.php?action=insert&intern_name=$r4[1]' class='btn btn-primary'>SCORE</a></td>";
        echo "</tr>";
    } 
    
    echo "</table></div>";
} else {
    echo "<h2 class='text-center'>No Data Found</h2>"; 
}

echo "</div>";
include("footer.php");
?>
