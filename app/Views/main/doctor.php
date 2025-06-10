<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>AV Multispeciality | Service , Ortho & Child Care</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <?php include('common_styles.php'); ?>
</head>
<body>
    <?php include('common_header.php'); ?>

            <!-- Team Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width: 500px;">
                <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Our Doctors</h5>
                <h1 class="display-4">Qualified Healthcare Professionals</h1>
            </div>
            <!-- <div class="owl-carousel team-carousel position-relative"> -->
                
            <?php if (!empty($doctors)): ?>
                <div class="row g-4">
                    <?php foreach ($doctors as $doctor): ?>
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm">
                                <a href="<?= base_url('doctor/' . $doctor['id']); ?>">
                                    <img src="<?= base_url('uploads/' . $doctor['profile_pic']); ?>" 
                                        class="card-img-top" 
                                        alt="<?= esc($doctor['name']); ?>" 
                                        style="height: 350px; object-fit: cover;">
                                </a>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">
                                        <a href="<?= base_url('doctor/' . $doctor['id']); ?>" class="text-dark text-decoration-none">
                                            <?= esc($doctor['name']); ?>
                                        </a>
                                    </h5>
                                    <p class="card-text text-primary fst-italic mb-1">
                                        <?= esc($doctor['qualifications']); ?>
                                    </p>
                                    <p class="card-text mb-2">
                                        <?= esc($doctor['specialization']); ?>
                                    </p>

                                    <?php 
                                        $social = json_decode($doctor['social_links'], true);
                                    ?>

                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <?php if (!empty($social['facebook'])): ?>
                                            <a href="<?= esc($social['facebook']) ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($social['twitter'])): ?>
                                            <a href="<?= esc($social['twitter']) ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($social['linkedin'])): ?>
                                            <a href="<?= esc($social['linkedin']) ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($social['instagram'])): ?>
                                            <a href="<?= esc($social['instagram']) ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($social['youtube'])): ?>
                                            <a href="<?= esc($social['youtube']) ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle">
                                                <i class="fab fa-youtube"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>

                                    <a href="<?= base_url('doctor/' . $doctor['id']); ?>" class="btn btn-sm btn-primary mt-auto w-100">
                                        View Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-warning text-center">No doctors available at the moment.</div>
            <?php endif; ?>


            <!-- </div> -->
        </div>
    </div>
    <!-- Team End -->
    <?php include('common_footer.php'); ?>
    <?php include('common_scripts.php'); ?>
</body>
</html>