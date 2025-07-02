<!doctype html>
<html lang="en">
  <!--begin::Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AV Multispeciality | Patient Timeline</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AV Multispeciality | Patient Timeline" />
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
                <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Patient Timeline</a></li>
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
        <?php include('common_sidebar.php'); ?>
        <!--begin::App Main-->
        <main class="app-main">
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                    <div class="col-sm-6"><h3 class="mb-0">Patient Timeline</h3></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Patient Timeline</li>
                        </ol>
                    </div>
                    </div>
                    <!--end::Row-->
                </div>
            <!--end::Container-->
            </div>
            <div class="app-content">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!-- Patient Timeline -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Patient Search -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="patientSearch" class="form-label">Search Patient</label>
                                    <input type="text" class="form-control" id="patientSearch" placeholder="Enter patient Id">
                                </div>
                                <div class="mb-3">
                                    <button type="button" class="btn btn-primary" id="searchPatientBtn">Search</button>
                                </div>
                            </div>

                            <!-- Display Patient Details after Search -->
                            <div id="patientDetails" class="mb-3" style="display: none;">
                                <h5>Patient Info</h5>
                                <p id="patientName"></p>
                                <p id="patientAge"></p>
                            </div>

                            <!-- Vaccine Section (shown only for eligible patients) -->
                            <div id="vaccineSection" style="display: none;" class="mt-5">
                                <h5 class="mb-3">Update Vaccine</h5>

                                <div id="lastVaccine" class="alert alert-info" style="display: none;">
                                    <strong>Last Vaccine:</strong> <span id="lastVaccineText"></span>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="vaccineSelect" class="form-label">Select Vaccine</label>
                                        <select id="vaccineSelect" class="form-select" style="width: 100%;">
                                            <option value="">-- Select Vaccine --</option>
                                            <?php foreach ($vaccines as $vaccine): ?>
                                                <option value="<?= esc($vaccine['name']) ?>">
                                                    <?= esc($vaccine['name']) ?> (<?= esc($vaccine['due_weeks']) ?> weeks)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="vaccineDate" class="form-label">Vaccination Date</label>
                                        <input type="date" class="form-control" id="vaccineDate">
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button id="submitVaccineBtn" class="btn btn-success">Add Vaccine</button>
                                    </div>
                                </div>
                            </div>


                            <div id="patientTimeline">
                                <div class="timeline"></div>
                            </div>

                            <!-- Create Timeline Entry -->
                            <div id="timelineEntryForm" style="display: none;">
                                <div class="mb-3">
                                    <div class="col-md-6">
                                        <label for="doctorId" class="form-label">Doctor</label>
                                        <select class="form-select" id="doctorId" name="doctorId" required>
                                            <?php foreach ($doctors as $doctor): ?>
                                                <option value="<?= esc($doctor['id']) ?>"><?= esc($doctor['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">Please select a Doctor.</div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="timelineTitle" class="form-label">Timeline Title</label>
                                    <input type="text" class="form-control" id="timelineTitle" name="title" placeholder="Add Title" required>
                                    <input type="hidden" id="selectedPatientId" name="patientId">
                                </div>
                                <div class="mb-3">
                                    <label for="timelineText" class="form-label">Timeline Text</label>
                                    <textarea id="timelineText" class="form-control" rows="3" placeholder="Add timeline description"></textarea>
                                </div>
                                
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" id="timelineFile" />
                                    <label class="input-group-text" for="timelineFile">Upload</label>
                                </div>

                                <button class="btn btn-success" id="addTimelineEntry">Add Timeline Entry</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!--end::Container-->
            </div>

        </main>
        <!--end::App Main-->

        <?php include('common_footer.php'); ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?php include('common_script.php'); ?>
    <script>
        $(document).ready(function () {

            function loadVaccineSection(patient) {
                const maxVaccineAge = 5; // Years
                const patientId = patient.id;
                if (patient.age < maxVaccineAge) {
                    $("#vaccineSection").show();
                        const today = new Date().toISOString().split('T')[0];
                        $("#vaccineDate").val(today); // ✅ Set today as default

                    // Fetch last vaccine if any
                    $.ajax({
                        url: `/admin/patient-vaccines/${patientId}`,
                        method: "GET",
                        success: function (data) {
                            if (data.vaccines && data.vaccines.length > 0) {
                                const last = data.vaccines[data.vaccines.length - 1];
                                $("#lastVaccineText").text(`${last.vaccine_name} on ${last.vaccination_date}`);
                                $("#lastVaccine").show();
                            } else {
                                $("#lastVaccine").hide();
                            }
                        }
                    });
                } else {
                    $("#vaccineSection").hide();
                }
            }

            // Trigger vaccine load on patient search
            $("#searchPatientBtn").on("click", function () {
                const patientSearch = $("#patientSearch").val();
                if (!patientSearch) return;

                $.ajax({
                    url: "/patients/search",
                    type: "GET",
                    data: { patientId: patientSearch },
                    success: function (response) {
                        if (response.patient) {
                            // existing render logic...
                            loadVaccineSection(response.patient); // 🎯 hook vaccine section load
                        }
                    }
                });
            });

            // Submit vaccine record
            $("#submitVaccineBtn").on("click", function () {
                const vaccineName = $("#vaccineSelect").val();
                const vaccinationDate = $("#vaccineDate").val();
                const patientId = $("#selectedPatientId").val();

                if (!vaccineName || !vaccinationDate) {
                    alert("Please select a vaccine and date.");
                    return;
                }

                $.ajax({
                    url: "/admin/patient-vaccines/add",
                    method: "POST",
                    data: {
                        patient_id: patientId,
                        vaccine_name: [vaccineName],
                        dose_number: [1], // You can auto-increment on backend
                        vaccination_date: [vaccinationDate]
                    },
                    success: function (res) {
                        alert("Vaccine added successfully.");
                        $("#vaccineDate").val("");
                        $("#vaccineSelect").val("");
                        $("#searchPatientBtn").click(); // refresh patient
                    },
                    error: function () {
                        alert("Error adding vaccine.");
                    }
                });
            });

            $("#searchPatientBtn").on("click", function() {
                let patientSearch = $("#patientSearch").val();

                if (patientSearch) {
                    $.ajax({
                        url: "/patients/search", // Endpoint for searching patient
                        type: "GET",
                        data: { patientId: patientSearch },
                        success: function(response) {
                            if (response.patient) {
                                // Display patient details
                                $("#patientName").text("Patient Name: " + response.patient.name);
                                $("#patientAge").text("Patient Age: " +response.patient.age);
                                $("#selectedPatientId").val(response.patient.id); // Store patient ID in hidden field
                                $("#patientDetails").show();
                                $("#timelineEntryForm").show();

                                // Store the patientId dynamically
                                let patientId = response.patient.id;

                                // Fetch the patient's timeline after the search
                                fetchPatientTimeline(patientId);
                            } else {
                                alert("Patient not found!");
                            }
                        },
                        error: function() {
                            alert("Error searching for patient.");
                        }
                    });
                }
            });

            // Function to fetch patient's timeline
            function fetchPatientTimeline(patientId) {
                // Check if there are existing timeline events for the patient
                $.ajax({
                    url: `/patients/${patientId}/getPatientTimeline`,  // API endpoint to fetch patient's timeline
                    method: "GET",
                    success: function(response) {
                        $("#patientTimeline .timeline").empty();
                        if (response.timeline && response.timeline.length > 0) {
                            // Display existing events
                            response.timeline.forEach(event => {
                                appendTimelineEvent(event);
                            });

                            // Add the last timeline item as a placeholder or divider
                            let lastTimelineItem = `
                                <div>
                                    <i class="timeline-icon bi bi-clock-fill text-bg-secondary"></i>
                                </div>`;
                        $("#patientTimeline  .timeline").append(lastTimelineItem);
                        } else {
                            // No events, show a placeholder
                            $("#patientTimeline  .timeline").append('<div>No events for this patient.</div>');
                        }
                    },
                    error: function() {
                        alert("Error loading patient timeline.");
                    }
                });
            }

            function appendTimelineEvent(event) {
                let timelineItem = `
                <div>
                    <i class="timeline-icon bi bi-envelope text-bg-primary"></i>
                    <div class="timeline-item">
                        <h3 class="timeline-header">
                            Doctor Name: <a href="#">${event.doctor_name}</a>
                        </h3>

                        <div class="timeline-body">
                            ${event.text}
                        </div>`;

                // If a file is attached to the event, show download link
                if (event.file) {
                    timelineItem += `
                        <div class="timeline-file">
                            <a href="${event.file}" target="_blank">Download File</a>
                        </div>
                    `;
                }

                timelineItem += `
                    </div>
                </div>
                `;

                // Append the event to the timeline container
                $("#patientTimeline .timeline").append(timelineItem);
            }


        // Function to format the date to "10 Feb. 2023"
        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = date.getDate();
            const month = date.toLocaleString('default', { month: 'short' });  // Short month name (e.g., "Feb")
            const year = date.getFullYear();
            return `${day} ${month}. ${year}`;
        }


        // Add a new timeline event
        $("#addTimelineEntry").on("click", function () {
            let text = $('#timelineText').summernote('code');
            let file = $("#timelineFile")[0].files[0];
            let title = $("#timelineTitle").val();
            let doctorId = $("#doctorId").val();
            let patientId = $("#selectedPatientId").val();

             // Validate title
            if (title === "") {
                alert("Please enter a title for the timeline event.");
                $("#timelineTitle").focus();
                return;
            }

            // Validate Summernote content
            if (text.trim() === "" || text.trim() === "<p><br></p>") {
                alert("Please enter some text for the event.");
                $('#timelineText').summernote('focus');
                return;
            }

            // Prepare data for AJAX request
            let formData = new FormData();
            formData.append('patient_id', patientId);
            formData.append('text', text);
            formData.append('title', title);
            formData.append('doctorId', doctorId);

            if (file) {
                formData.append('file', file);
            }

            // Send request to add a new event
            $.ajax({
                url: "/patients/" + patientId + "/addTimelineEntry",  // API endpoint to add a timeline event
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        $("#timelineTitle").val("");
                        $('#timelineText').summernote('code', ''); // Clears the editor content
                        $('#patientSearch').val(patientId)
                        $("#searchPatientBtn").click();

                    } else {
                        alert("Error adding event: " + JSON.stringify(response));
                    }
                },
                error: function (xhr, status, error) {
                    alert("Error adding event."  + xhr.responseText);
                }
            });
        });

        });

    </script>

    <!-- Place the first <script> tag in your HTML's <head> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#timelineText').summernote({
                height: 200,
                callbacks: {
                    onInit: function() {
                        console.log("Summernote is initialized");
                        $('#timelineText').summernote('code', ''); // Safe to clear content
                    }
                }
            });
        });
    </script>

</body>
</html>