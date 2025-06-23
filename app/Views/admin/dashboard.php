<!doctype html>
<html lang="en">
  <!--begin::Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AV Multispeciality | Dashboard</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AV Multispeciality | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <?php include('common_styles.php'); ?>
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!--begin::Header-->
        <nav class="app-header navbar navbar-expand bg-body">
            <!--begin::Container-->
            <div class="container-fluid">
            <!--begin::Start Navbar Links-->
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
                </li>
                <li class="nav-item d-none d-md-block"><a href="<?php echo base_url('admin/dashboard'); ?>" class="nav-link">Home</a></li>
                <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Dashboard</a></li>
            </ul>
            <!--end::Start Navbar Links-->
                <!--begin::End Navbar Links-->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item user-menu">
                        <a href="/logout" class="nav-link" id="logoutBtn">
                            <span class="d-none d-md-inline">Sign out</span>
                        </a>
                    </li>
                </ul>
                <!--end::End Navbar Links-->
            </div>
            <!--end::Container-->
        </nav>
        <!--end::Header-->
        <?php include('common_sidebar.php'); ?>
        <!--begin::App Main-->
        <main class="app-main">
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                    <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </div>
                    </div>
                    <!--end::Row-->
                </div>
            <!--end::Container-->
            </div>
            <div class="app-content">

                <div class="container-fluid">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header"><h3 class="card-title">Appointment</h3></div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Patient Name</th>
                                                <th>Doctor</th>
                                                <th>Appointment Type</th>
                                                <th>Slot Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($appointments)): ?>
                                                <?php foreach ($appointments as $index => $appointment): ?>
                                                    <tr class="align-middle">
                                                        <td><?= esc($appointment['patient_id']) ?></td>
                                                        <td><?= esc($appointment['patient_name']) ?></td>
                                                        <td><?= esc($appointment['doctor_name']) ?></td>
                                                        <td><?= esc($appointment['appointment_type']) ?></td>
                                                        <td><?= date("h:i A", strtotime($appointment['start_time'])) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr><td colspan="5" class="text-center">No appointments for today.</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-primary card-outline mb-4">

                                <div class="card-header"><div class="card-title">Book an Appointment</div></div>
                                <!-- Select Doctor -->
                                <div class="card-body">
                                    <!-- Patient Number -->
                                    <div class="mb-3">
                                        <label for="phoneNumber" class="form-label">Patient Number</label>
                                        <input type="text" class="form-control" id="phoneNumber">
                                        <input type="hidden" id="patientId" name="patient_id">
                                    </div>
                                        <!-- New Patient Details (conditional) -->
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

                                    <div class="mb-3">
                                        <label for="doctorSelect" class="form-label">Select Doctor</label>
                                        <select class="form-select" id="doctorSelect">
                                            <option value="">Choose Doctor</option>
                                            <?php foreach ($doctors as $doctor): ?>
                                                <option value="<?= $doctor['id'] ?>"><?= $doctor['name'] ?> (<?= $doctor['specialization'] ?>)</option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                
                                    <!-- Select Date -->
                                    <div class="mb-3">
                                        <label for="appointmentDate" class="form-label">Select Date</label>
                                        <input type="date" class="form-control" id="appointmentDate">
                                    </div>
                
                                    <!-- Available Slots -->
                                    <div class="mb-3" id="avialableSlots" style="display: none;">
                                        <label class="form-label">Available Slots</label>
                                        <!-- Morning Slots Section -->
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
                                    
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary" id="bookAppointment" disabled>Book Appointment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!--end::App Main-->

        <?php include('common_footer.php'); ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url('assets/common.js'); ?>"></script>
    <?php include('common_script.php'); ?>
</body>
</html>