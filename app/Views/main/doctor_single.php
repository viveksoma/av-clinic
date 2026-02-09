<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Expert Doctors in Tirupathur | AV Multispeciality Hospital</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="
    AV Multispeciality Hospital in Tirupathur offers Paediatrics, Orthopedic, Gynecology, Psychiatry, General Physician and online consultations. Serving Tirupathur, Jolarpet, Vaniyambadi, Ambur, Vellore and nearby areas.
    ">
    <meta name="keywords" content="
    AV Multispeciality Hospital,
    multispeciality hospital in Tirupathur,
    hospital in Tirupathur,
    best hospital in Tirupathur,
    online doctor consultation Tirupathur,

    paediatrician in Tirupathur,
    orthopedic hospital in Tirupathur,
    gynecologist in Tirupathur,
    general physician in Tirupathur,
    psychiatrist in Tirupathur,
    anesthetist in Tirupathur,

    multispeciality hospital in Jolarpet,
    hospital in Jolarpet,
    multispeciality hospital in Vaniyambadi,
    hospital in Vaniyambadi,
    multispeciality hospital in Ambur,
    hospital in Ambur,
    multispeciality hospital in Vellore,
    hospital in Vellore,
    multispeciality hospital in Bargur,
    hospital in Bargur,
    multispeciality hospital in Kanthili,
    hospital in Kanthili,
    multispeciality hospital in Dharmapuri,
    hospital in Dharmapuri,

    paediatric hospital near me,
    orthopedic hospital near me,
    gynecology hospital near me,
    psychiatrist hospital near me,
    general physician near me,
    online consultation hospital Tamil Nadu
    ">
    <?php include('common_styles.php'); ?>
</head>
<body>
    <?php include('common_header.php'); ?>

            <!-- Team Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="container py-5">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img src="<?= base_url('uploads/' . $doctor['profile_pic']); ?>" 
                            class="card-img-top" 
                            alt="<?= esc($doctor['name']); ?>" 
                            style="height: 350px; object-fit: cover;">

                        <div class="mt-3">
                            <?php if (!empty($doctor['social_links']['facebook'])): ?>
                                <a href="<?= esc($doctor['social_links']['facebook']) ?>" target="_blank" class="btn btn-primary btn-sm me-2">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($doctor['social_links']['twitter'])): ?>
                                <a href="<?= esc($doctor['social_links']['twitter']) ?>" target="_blank" class="btn btn-info btn-sm me-2">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($doctor['social_links']['linkedin'])): ?>
                                <a href="<?= esc($doctor['social_links']['linkedin']) ?>" target="_blank" class="btn btn-secondary btn-sm me-2">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($doctor['social_links']['instagram'])): ?>
                                <a href="<?= esc($doctor['social_links']['instagram']) ?>" target="_blank" class="btn btn-danger btn-sm me-2">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($doctor['social_links']['youtube'])): ?>
                                <a href="<?= esc($doctor['social_links']['youtube']) ?>" target="_blank" class="btn btn-danger btn-sm">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <h2><?= esc($doctor['name']) ?></h2>
                        <h5 class="text-muted"><?= esc($doctor['qualifications']) ?></h5>
                        <h6 class="text-primary mb-3"><?= esc($doctor['specialization']) ?></h6>

                        <div class="mb-3">
                            <h5>About</h5>
                            <div><?= $doctor['about'] ?></div>
                        </div>

                        <p><strong>Slot Duration:</strong> <?= esc($doctor['slot_duration']) ?> minutes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->
    <?php include('common_footer.php'); ?>
    <?php include('common_scripts.php'); ?>
</body>
</html>