<?php
include("student_header.php");
include("conn.php");

$query = "SELECT v.cid, v.vid, v.vimg, v.vtype, v.position, v.post_date, v.end_date, v.`desc`, c.name AS company_name, c.location 
          FROM vacancy_master v 
          INNER JOIN company_info c ON v.cid = c.cid";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
?>

<div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container py-3"> 
        <div class="section-title text-center position-relative pb-3 mb-3 mx-auto" style="max-width: 600px;">
            <h5 class="fw-bold text-primary text-uppercase">Available Vacancies</h5>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-3"> 
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                // Pass company name and position as query parameters
                $company_name = urlencode($row['company_name']);
                $position = urlencode($row['position']);
            ?>
                <div class="col">
                    <div class="card h-100 shadow">
                        <!-- Wrap the image inside an anchor tag to make it clickable -->
                        <a href="vacancy_images/<?php echo $row['vimg']; ?>" target="_blank">
                            <div class="image-container">
                                <img class="card-img-top" src="vacancy_images/<?php echo $row['vimg']; ?>" alt="<?php echo $row['vtype']; ?>">
                                <div class="overlay">
                                    <h6 class="text-white"><?php echo $row['position']; ?></h6>
                                </div>
                            </div>
                        </a>
                        <div class="card-body">
                            <p class="card-text mb-1" style="font-size: 0.9rem;"><?php echo $row['desc']; ?></p>
                            <h7 class="card-title mb-1"><?php echo $row['location']; ?></h7>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <div>
                                <label for="">Posted Date:<?php echo $row['post_date']; ?></label>
                            </div>
                            <!-- Adjusted link with query parameters -->
                            <a href="student_apply_internship.php?company_name=<?php echo $company_name; ?>&position=<?php echo $position; ?>" class="btn btn-sm btn-primary">Apply Now <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                
            <?php
            }
            ?>
        </div>
    </div>
</div>

<?php
}
include("footer.php");
?>
