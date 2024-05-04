<?php
session_start();
include("admin_report_header.php");
include("conn.php");
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="section-title text-center pb-3 mb-4">
                <h3 class="mb-0">Reports</h3>
            </div>
            <div class="list-group">
                <a href="admin_view_student_report.php" class="list-group-item list-group-item-action bg-light rounded mb-2">
                    <i class="bi bi-person me-2"></i>All Students
                </a>
                <a href="admin_view_faculty_report.php" class="list-group-item list-group-item-action bg-light rounded mb-2">
                    <i class="bi bi-people me-2"></i>All Faculties
                </a>
                <a href="admin_view_internship.php" class="list-group-item list-group-item-action bg-light rounded mb-2">
                    <i class="bi bi-briefcase me-2"></i>All Internships
                </a>
                <a href="admin_view_company.php" class="list-group-item list-group-item-action bg-light rounded mb-2">
                    <i class="bi bi-building me-2"></i>All Companies
                </a>
                <a href="admin_view_studentwise_project.php" class="list-group-item list-group-item-action bg-light rounded mb-2">
                    <i class="bi bi-file-earmark-text me-2"></i>Studentwise Projects
                </a>
                <a href="admin_guidewise_report.php" class="list-group-item list-group-item-action bg-light rounded mb-2">
                    <i class="bi bi-person-lines-fill me-2"></i>Guidewise Info
                </a>
                <a href="admin_view_facultywise_score.php" class="list-group-item list-group-item-action bg-light rounded mb-2">
                    <i class="bi bi-journal-text me-2"></i>Guidewise Score
                </a>
                <a href="admin_view_compamywise_vacancies.php" class="list-group-item list-group-item-action bg-light rounded mb-2">
                    <i class="bi bi-collection-play-fill me-2"></i>Companywise Vacancies
                </a>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>
