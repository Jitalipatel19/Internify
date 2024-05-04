<?php
include("admin_report_header.php");
include("conn.php");
?>
<div class="container">
    <h3 class="text-center mb-4">Companywise Vacancies Info</h3>

    <?php
    $res4 = mysqli_query($conn, "SELECT ci.*, vm.vimg, vm.post_date, vm.end_date FROM company_info AS ci INNER JOIN vacancy_master AS vm ON ci.cid = vm.cid");
    if (mysqli_num_rows($res4) > 0) {
        ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Company Name</th>
                        <th>HR Name</th>
                        <th>Email</th>
                        <th>Location</th>
                        <th>Vacancy Image</th>
                        <th>Post Date</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($r4 = mysqli_fetch_array($res4)) {
                        echo "<tr>";
                        echo "<td>" . $r4[0] . "</td>";
                        echo "<td>" . $r4[1] . "</td>";
                        echo "<td>" . $r4[2] . "</td>";
                        echo "<td>" . $r4[4] . "</td>";
                        echo "<td>" . $r4[6] . "</td>";
                        echo "<td><a href='vacancy_images/" . $r4['vimg'] . "' target='_blank'><img src='vacancy_images/" . $r4['vimg'] . "' alt='Vacancy Image' class='img-fluid' style='max-width: 100px; max-height: 100px;'></a></td>";
                        echo "<td>" . $r4['post_date'] . "</td>";
                        echo "<td>" . $r4['end_date'] . "</td>";
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
