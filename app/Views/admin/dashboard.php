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
        <?php include('common_sidebar.php'); ?>
        <!--begin::App Main-->
        <main class="app-main">
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
                                        <div class="mb-3">
                                            <label for="patientName" class="form-label">Patient Name</label>
                                            <input type="text" class="form-control" id="patientName">
                                        </div>
                                        <div class="mb-3">
                                            <label for="patientAge" class="form-label">Patient Age</label>
                                            <input type="number" class="form-control" id="patientAge">
                                        </div>
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
                                    <div class="mb-3">
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
    <script>
        $(document).ready(function() {
            $("#phoneNumber").on("blur", function() {
                let phoneNumber = $("#phoneNumber").val().trim();
                // Validate phone number (must be 10 digits)
                if (!/^\d{10}$/.test(phoneNumber)) {
                    $("#phoneNumber").val(""); // Clear invalid input
                    return;
                }

                if (phoneNumber) {
                    // AJAX request to check if patient exists
                    $.ajax({
                        url: "/patients/checkPatient", // Your endpoint to check patient
                        type: "GET",
                        data: { phone_number: phoneNumber },
                        success: function(response) {
                            if (response.exists) {
                                // If patient exists, auto-fill the form with existing patient data (if needed)
                                // Optionally you can show an alert or just proceed to booking the appointment
                                $("#patientId").val(response.patient.id);
                                $("#newPatientDetails").hide();
                            } else {
                                // If patient doesn't exist, show the form to input new details
                                $("#newPatientDetails").show();
                                $("#patientId").val("");
                            }
                        },
                        error: function() {
                            alert("Error checking patient.");
                        }
                    });
                }
            });

            $("#doctorSelect, #appointmentDate").on("change", function() {
                let doctor_id = $("#doctorSelect").val();
                let date = $("#appointmentDate").val();

                if (doctor_id && date) {
                    $.ajax({
                        url: "/appointments/getSlots",  // Get available slots for the doctor on the selected date
                        type: "GET",
                        data: { doctor_id, date },
                        success: function(response) {
                            let morningSlotsContainer = $("#morningSlotsContainer");
                            let eveningSlotsContainer = $("#eveningSlotsContainer");

                            morningSlotsContainer.empty();
                            eveningSlotsContainer.empty();

                            let morningSlots = response.morning_slots;
                            let eveningSlots = response.evening_slots;

                            // Fetch the booked slots once for the selected doctor and date
                            $.ajax({
                                url: "/appointments/getBookedSlots",  // New endpoint to fetch booked slots for doctor and date
                                type: "GET",
                                data: { doctor_id, date },
                                success: function(bookedResponse) {
                                    let bookedSlots = bookedResponse.booked_slots;

                                    // Render morning slots
                                    if (morningSlots.length > 0) {
                                        morningSlots.forEach(slot => {
                                            const buttonHTML = `
                                                <button class="btn btn-outline-primary slot-btn" data-time="${slot}" 
                                                        ${isSlotBooked(slot, bookedSlots) ? 'disabled' : ''}>${slot}</button>
                                            `;
                                            morningSlotsContainer.append(buttonHTML);
                                        });
                                    } else {
                                        morningSlotsContainer.append("<p class='text-danger'>No available morning slots</p>");
                                    }

                                    // Render evening slots
                                    if (eveningSlots.length > 0) {
                                        eveningSlots.forEach(slot => {
                                            const buttonHTML = `
                                                <button class="btn btn-outline-primary slot-btn" data-time="${slot}" 
                                                        ${isSlotBooked(slot, bookedSlots) ? 'disabled' : ''}>${slot}</button>
                                            `;
                                            eveningSlotsContainer.append(buttonHTML);
                                        });
                                    } else {
                                        eveningSlotsContainer.append("<p class='text-danger'>No available evening slots</p>");
                                    }
                                },
                                error: function() {
                                    console.log("Error fetching booked slots");
                                }
                            });
                        },
                        error: function() {
                            console.log("Error fetching available slots");
                        }
                    });
                }
            });



            // Select Slot
            $(document).on("click", ".slot-btn", function() {
                $(".slot-btn").removeClass("btn-primary").addClass("btn-outline-primary");
                $(this).removeClass("btn-outline-primary").addClass("btn-primary");
                $("#bookAppointment").prop("disabled", false).data("time", $(this).data("time"));
            });

            // Book Appointment
            $("#bookAppointment").on("click", function() {
                let doctor_id = $("#doctorSelect").val();
                let date = $("#appointmentDate").val();
                let time = $(this).data("time");
                let phoneNumber = $("#phoneNumber").val().trim();
                let patientName = $("#patientName").val().trim();
                let patientAge = $("#patientAge").val().trim();
                let patientId = $("#patientId").val(); // Hidden input for existing patient ID

                // Validate phone number
                if (!/^\d{10}$/.test(phoneNumber)) {
                    alert("Please enter a valid 10-digit phone number.");
                    return;
                }

                // Ensure necessary details are provided
                if (!doctor_id || !date || !time) {
                    alert("Please select doctor, date, and time for the appointment.");
                    return;
                }

                // Prepare request data
                let requestData = {
                    doctor_id,
                    date,
                    time,
                    phone_number: phoneNumber
                };

                // If patient exists, use the patientId
                if (patientId) {
                    requestData.patient_id = patientId;
                } else {
                    // If new patient, send additional details
                    if (!patientName || !patientAge) {
                        alert("Please enter patient name and age.");
                        return;
                    }
                    requestData.patient_name = patientName;
                    requestData.patient_age = patientAge;
                }

                // AJAX request to book appointment
                $.ajax({
                    url: "/appointments/book",
                    type: "POST",
                    data: requestData,
                    success: function(response) {
                        alert("Appointment booked successfully!");
                        location.reload();
                    },
                    error: function() {
                        alert("Error booking appointment!");
                    }
                });
            });

        });

        // Function to check if a slot is booked
        function isSlotBooked(slot, bookedSlots) {
            return bookedSlots.includes(slot);
        }

    </script>

    <?php include('common_script.php'); ?>
</body>
</html>