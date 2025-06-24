<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>AV Multispeciality | Appointment , Ortho & Child Care</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <?php include('common_styles.php'); ?>
</head>
<body>
    <?php include('common_header.php'); ?>
    <!-- Appointment Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="mb-4">
                        <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Appointment</h5>
                        <h1 class="display-4">Make An Appointment For Your Family</h1>
                    </div>
                    <p class="mb-5">Get expert medical care at your convenience. Schedule an appointment with our specialists in Orthopaedics, Paediatrics, Lactation, and Mental Health for personalized treatment and guidance. We prioritize your health with compassionate, expert-led consultations.</p>
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

    <?php include('common_footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url('assets/common.js'); ?>"></script>
    <?php include('common_scripts.php'); ?></body>
</html>