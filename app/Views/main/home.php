<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>AV Multispeciality , Ortho & Child Care - Tirupattur</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <?php include('common_styles.php'); ?>
</head>
<body>
    <?php include('common_header.php'); ?>
    <!-- Hero Start -->
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-start">
                <div class="col-lg-8 text-center text-lg-start">
                    <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5" style="border-color: rgba(256, 256, 256, .3) !important;">Welcome To AV Multispeciality</h5>
                    <h1 class="display-1 text-white mb-md-4">Best Healthcare Solution In Your City</h1>
                    <div class="pt-2">
                        <a href="<?php echo base_url('appointment'); ?>" class="btn btn-light rounded-pill py-md-3 px-md-5 mx-2">Book An Appointment</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->


    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-5 mb-5 mb-lg-0" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100 rounded" src="<?= base_url('assets/main/img/home-about.jpg'); ?>" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="mb-4">
                        <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">About Us</h5>
                        <h1 class="display-4">Best Medical Care For Yourself and Your Family</h1>
                    </div>
                    <p>AV Multispeciality Hospital is a well-known hospital located in Tirupattur, Sandal Town. Our hospital is easily accessible by various modes of transportation.</p>
                    <h3>Vision</h3>
                    <p>Our goal is to provide heartfelt service and satisfaction to all our patients. The hospital was founded by Dr. S. Aravintharaj and Dr. N. Vidhu Varsha on 23.02.2022. Whether you're seeking routine check-ups, vaccinations, surgical interventions, physiotherapy, or rehabilitation services our expert team of physicians and staff are here to guide you through every step of your healthcare journey.</p>
                    <div class="row g-3 pt-3">
                        <div class="col-sm-3 col-6">
                            <div class="bg-light text-center rounded-circle py-4">
                                <i class="fa fa-3x fa-user-md text-primary mb-3"></i>
                                <h6 class="mb-0">Qualified<small class="d-block text-primary">Doctors</small></h6>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="bg-light text-center rounded-circle py-4">
                                <i class="fa fa-3x fa-procedures text-primary mb-3"></i>
                                <h6 class="mb-0">Emergency<small class="d-block text-primary">Services</small></h6>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="bg-light text-center rounded-circle py-4">
                                <i class="fa fa-3x fa-microscope text-primary mb-3"></i>
                                <h6 class="mb-0">Accurate<small class="d-block text-primary">Testing</small></h6>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="bg-light text-center rounded-circle py-4">
                                <i class="fa fa-3x fa-camera-retro text-primary mb-3"></i>
                                <h6 class="mb-0">24 X 7<small class="d-block text-primary">Imaging</small></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->
    

    <!-- Services Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width: 500px;">
                <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Services</h5>
                <h1 class="display-4">Excellent Medical Services</h1>
            </div>
            <div class="row g-5">
                <div class="col-lg-4 col-md-6">
                    <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="service-icon mb-4">
                            <i class="fa fa-2x fa-user-md text-white"></i>
                        </div>
                        <h4 class="mb-3">Pharmacy</h4>
                        <p>24-hour Pharmacy Service
                            </br>Computerized Stock Management</br>
                            Always maintaining optimum stock levels</p>
                       <a class="btn btn-lg btn-primary rounded-pill" href="<?php echo base_url('service'); ?>">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="service-icon mb-4">
                            <i class="fa fa-2x fa-procedures text-white"></i>
                        </div>
                        <h4 class="mb-3">Operation & Surgery</h4>
                        <p class="m-0">Trauma & Fracture Fixation, Spine Surgery, </br>Joint Replacement, Arthroscopy</p>
                        <a class="btn btn-lg btn-primary rounded-pill" href="<?php echo base_url('service'); ?>">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="service-icon mb-4">
                            <i class="fa fa-2x fa-stethoscope text-white"></i>
                        </div>
                        <h4 class="mb-3">Child care</h4>
                        <p class="m-0">Newborn Care, </br> Growth & Development Monitoring, Nutrition Guidance, Allergy Clinic, Lactation Counselling, </br> Vaccination Services, Acute Illness Care.</p>
                        <a class="btn btn-lg btn-primary rounded-pill" href="<?php echo base_url('service'); ?>">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="service-icon mb-4">
                            <i class="fa fa-2x fa-ambulance text-white"></i>
                        </div>
                        <h4 class="mb-3">Psychiatry</h4>
                        <p class="m-0">Psychiatric consultation services offered for Schizophrenia, Bipolar disorder, OCD, Deaddiction management ,Depression and Anxiety disorder, Sleep disorder, Dementia</p>
                        <a class="btn btn-lg btn-primary rounded-pill" href="<?php echo base_url('service'); ?>">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="service-icon mb-4">
                            <i class="fa fa-2x fa-pills text-white"></i>
                        </div>
                        <h4 class="mb-3">Physiotherapy</h4>
                        <p class="m-0">Well-trained and qualified physiotherapists. </br> Home consultation available. </br>Rehabilitation without pain.</p>
                        <a class="btn btn-lg btn-primary rounded-pill" href="<?php echo base_url('service'); ?>">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="service-icon mb-4">
                            <i class="fa fa-2x fa-microscope text-white"></i>
                        </div>
                        <h4 class="mb-3">Imaging & Laboratory Services</h4>
                        <p class="m-0"> Digital X-ray Imaging. </br> Complete Biochemistry and Basic Tests. </br> Culture & Sensitivity tests at authorized laboratories.</p>
                        <a class="btn btn-lg btn-primary rounded-pill" href="<?php echo base_url('service'); ?>">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Services End -->


    <!-- Appointment Start -->
    <div class="container-fluid bg-primary my-5 py-5">
        <div class="container py-5">
            <div class="row gx-5">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="mb-4">
                        <h5 class="d-inline-block text-white text-uppercase border-bottom border-5">Appointment</h5>
                        <h1 class="display-4">Make An Appointment For Your Family</h1>
                    </div>
                    <a class="btn btn-dark rounded-pill py-3 px-5 me-3" href="">Find Doctor</a>
                    <a class="btn btn-outline-dark rounded-pill py-3 px-5" href="">Read More</a>
                </div>
                <div class="col-lg-6">
                    <div class="bg-white text-center rounded p-5">
                        <h1 class="mb-4">Book An Appointment</h1>
                        <div class="row g-3">
                            <div class="col-12 col-sm-12">
                                <input type="text" class="form-control bg-light border-0" placeholder="Your Number" id="phoneNumber" style="height: 55px;">
                                <input type="hidden" id="patientId" name="patient_id">
                            </div>
                            <div id="newPatientDetails" style="display: none;">
                                <div class="row g-3">
                                    <div class="col-12 col-sm-6">
                                        <input type="text" class="form-control bg-light border-0" placeholder="Your Name" id="patientName" style="height: 55px;">
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <input type="number" class="form-control bg-light border-0" placeholder="Your Age" id="patientAge" style="height: 55px;">
                                    </div>
                                    <div class="col-12">
                                        <input type="email" class="form-control bg-light border-0" placeholder="Your Email(Optional)" id="patientEmail" style="height: 55px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12">
                                <select class="form-select bg-light border-0" id="appointmentType" style="height: 55px;">
                                    <option selected disabled>Select Appointment Type</option>
                                    <option value="vaccination">vaccination</option>
                                    <option value="general">General Consultation</option>
                                    <option value="online">Online Consultation(Pediatric)</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <select class="form-select bg-light border-0" id="doctorSelect" style="height: 55px;">
                                    <option selected disabled>Select Doctor</option>
                                    <?php foreach ($doctors as $doctor): ?>
                                        <option value="<?= $doctor['id'] ?>"><?= $doctor['name'] ?> (<?= $doctor['specialization'] ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="date" data-target-input="nearest">
                                    <input type="date"
                                        class="form-control bg-light border-0"
                                        id="appointmentDate"
                                        placeholder="Select Date" style="height: 55px;">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12" id="avialableSlots" style="display: none;">
                                <div class="slots-section mb-3">
                                    <h5>Morning Slots</h5>
                                    <div id="morningSlotsContainer" class="d-flex flex-wrap gap-2"></div>
                                </div>
        
                                <!-- Evening Slots Section -->
                                <div class="slots-section">
                                    <h5>Evening Slots</h5>
                                    <div id="eveningSlotsContainer" class="d-flex flex-wrap gap-2"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" id="bookAppointment" disabled>Make An Appointment</button>
                            </div>
                            <div class="col-12">
                                <div id="appointmentStatus" class="mb-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Appointment End -->
     <!-- Team Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width: 500px;">
                <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Our Doctors</h5>
                <h1 class="display-4">Qualified Healthcare Professionals</h1>
            </div>
            <div class="owl-carousel team-carousel position-relative">
                
                <?php if (!empty($doctors)): ?>
                    <?php foreach ($doctors as $doctor): ?>
                        <div class="team-item mb-4">
                            <div class="row g-0 bg-light rounded overflow-hidden">
                                <div class="col-12 col-sm-5 h-100">
                                    <a href="<?= base_url('doctor/' . $doctor['id']); ?>">
                                        <img class="img-fluid h-100" 
                                            src="<?= base_url('uploads/' . $doctor['profile_pic']); ?>" 
                                            style="object-fit: cover;" 
                                            alt="<?= esc($doctor['name']); ?>">
                                    </a>
                                </div>
                                <div class="col-12 col-sm-7 h-100 d-flex flex-column">
                                    <div class="mt-auto p-4">
                                        <h3><a href="<?= base_url('doctor/' . $doctor['id']); ?>" class="text-dark"><?= esc($doctor['name']); ?></a></h3>
                                        <h5 class="fw-normal fst-italic text-primary mb-4"><?= esc($doctor['qualifications']); ?></h5>
                                        <h6><?= esc($doctor['specialization']); ?></h6>
                                    </div>

                                    <?php 
                                        $social = json_decode($doctor['social_links'], true);
                                    ?>

                                    <div class="d-flex mt-auto border-top p-4">
                                        <?php if (!empty($social['facebook'])): ?>
                                            <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-3" href="<?= esc($social['facebook']) ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                        <?php endif; ?>

                                        <?php if (!empty($social['twitter'])): ?>
                                            <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-3" href="<?= esc($social['twitter']) ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                                        <?php endif; ?>

                                        <?php if (!empty($social['linkedin'])): ?>
                                            <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-3" href="<?= esc($social['linkedin']) ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                        <?php endif; ?>

                                        <?php if (!empty($social['instagram'])): ?>
                                            <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-3" href="<?= esc($social['instagram']) ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                                        <?php endif; ?>

                                        <?php if (!empty($social['youtube'])): ?>
                                            <a class="btn btn-lg btn-primary btn-lg-square rounded-circle" href="<?= esc($social['youtube']) ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-warning text-center">
                        No doctors available at the moment.
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <!-- Team End -->
    <?php include('common_footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url('assets/common.js'); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <?php include('common_scripts.php'); ?>
    
</body>
</html>