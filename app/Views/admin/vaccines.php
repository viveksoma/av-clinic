<!doctype html>
<html lang="en">
  <!--begin::Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AV Multispeciality | Vaccines</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AV Multispeciality | Vaccines" />
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
                <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Vaccines</a></li>
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
                    <div class="col-sm-6"><h3 class="mb-0">Vaccines</h3></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Vaccines</li>
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
                                <div class="card-header"><h3 class="card-title"><i class="bi bi-capsule"></i> Patient Vaccine History</h3></div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="container mt-4">
                                                <!-- Patient ID Search -->
                                        <div class="row mb-4">
                                            <div class="col-md-4">
                                                <input type="text" id="patient_id" class="form-control" placeholder="Enter Patient ID">
                                            </div>
                                            <div class="col-md-2">
                                                <button id="search_btn" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>

                                        <!-- Patient Info -->
                                        <div id="patient_info" class="mb-4" style="display:none;">
                                            <h5>Patient Info</h5>
                                            <p><strong>Name:</strong> <span id="p_name"></span></p>
                                            <p><strong>Gender:</strong> <span id="p_gender"></span></p>
                                            <p><strong>DOB:</strong> <span id="p_dob"></span></p>
                                            <p><strong>Age:</strong> <span id="p_age"></span></p>
                                        </div>

                                         <!-- Existing Vaccine History -->
                                        <div id="existing_vaccines" class="mb-5"></div>

                                        <!-- Auto Fill Row (Shown only if no vaccine records) -->
                                        <div id="auto_fill_row" class="mb-4" style="display:none;">
                                            <h5>Add Previous Doses Automatically</h5>
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <input type="text" id="auto_vaccine_name" class="form-control" placeholder="Vaccine Name">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="number" id="auto_dose_count" class="form-control" placeholder="Total Doses" min="1">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="date" id="auto_last_date" class="form-control" placeholder="Last Dose Date">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-warning" id="auto_generate">Auto Fill</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Add Manual Dose Form -->
                                        <h5>Add Previous Vaccine Doses</h5>
                                        <form id="vaccine_form" style="display:none;">
                                            <input type="hidden" name="patient_id" id="form_patient_id">

                                            <table class="table table-bordered" id="vaccine_table" style="display:none;">
                                                <thead>
                                                    <tr>
                                                        <th>Vaccine Name</th>
                                                        <th>Dose Number</th>
                                                        <th>Vaccination Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="vaccine_rows">
                                                    <!-- dynamic rows -->
                                                </tbody>
                                            </table>

                                            <button type="button" id="add_row" class="btn btn-success" style="display:none;">+ Add Dose</button>
                                            <button type="submit" class="btn btn-primary">Submit Doses</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header"><h3 class="card-title"><i class="bi bi-capsule"></i> Vaccination Chart</h3></div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="container mt-4">
                                        <table class="table table-bordered mt-3">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Vaccine Name</th>
                                                    <th>Due Week</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($vaccines as $index => $vaccine): ?>
                                                    <tr>
                                                        <td><?= $index + 1 ?></td>
                                                        <td><?= esc($vaccine['name']) ?></td>
                                                        <td>
                                                            <?= esc($vaccine['due_weeks'])  ?>
                                                        </td>
                                                        <td><?= esc($vaccine['description']) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
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
     <script>
        $(document).ready(function () {
            $('#auto_fill_row').hide();
            $('#add_row').hide();
            $('#vaccine_table').hide();
            $('#vaccine_form').hide();

            // Search button logic
            $('#search_btn').click(function () {
                const patientId = $('#patient_id').val().trim();
                if (!patientId) return alert("Enter Patient ID");

                $('#form_patient_id').val(patientId);

                // Clear UI
                $('#existing_vaccines').empty();
                $('#vaccine_rows').empty();
                $('#patient_info').hide();
                $('#auto_fill_row').hide();
                $('#add_row').hide();
                $('#vaccine_table').hide();
                $('#vaccine_form').hide();

                $.ajax({
                    url: '/admin/patient-vaccines/' + patientId,
                    method: 'GET',
                    success: function (data) {
                        if (!data || !data.patient) {
                            alert("Patient not found.");
                            return;
                        }

                        // Show patient info
                        $('#p_name').text(data.patient.name);
                        $('#p_gender').text(data.patient.gender);
                        $('#p_dob').text(data.patient.dob);
                        $('#p_age').text(data.patient.age);
                        $('#patient_info').show();

                        // Show vaccines
                        let html = '<h5>Existing Vaccines:</h5><table class="table table-sm table-bordered"><thead><tr><th>Vaccine</th><th>Dose</th><th>Date</th></tr></thead><tbody>';
                        if (!data.vaccines || data.vaccines.length === 0) {
                            html += '<tr><td colspan="3">No vaccine records found.</td></tr>';
                            $('#auto_fill_row').show();
                        } else {
                            $.each(data.vaccines, function (_, row) {
                                html += `<tr><td>${row.vaccine_name}</td><td>${row.dose_number}</td><td>${row.vaccination_date}</td></tr>`;
                            });
                        }
                        html += '</tbody></table>';
                        $('#existing_vaccines').html(html);

                        $('#vaccine_form').show();
                        $('#add_row').show();
                        $('#vaccine_table').show();
                    },
                    error: function () {
                        alert("Error fetching patient data.");
                    }
                });
            });

            // Auto-generate previous doses
            $('#auto_generate').click(function () {
                const name = $('#auto_vaccine_name').val();
                const count = parseInt($('#auto_dose_count').val());
                const lastDate = $('#auto_last_date').val();
                if (!name || !count || !lastDate) {
                    alert("Fill all auto-fill fields");
                    return;
                }

                $('#vaccine_rows').empty();
                const intervalDays = 28;
                let currentDate = new Date(lastDate);

                for (let i = count; i >= 1; i--) {
                    const formattedDate = currentDate.toISOString().split('T')[0];
                    const row = `
                        <tr>
                            <td><input type="text" name="vaccine_name[]" class="form-control" value="${name}" required></td>
                            <td><input type="number" name="dose_number[]" class="form-control" value="${i}" required></td>
                            <td><input type="date" name="vaccination_date[]" class="form-control" value="${formattedDate}" required></td>
                            <td><button type="button" class="btn btn-danger remove_row">Remove</button></td>
                        </tr>
                    `;
                    $('#vaccine_rows').append(row);
                    currentDate.setDate(currentDate.getDate() - intervalDays);
                }
            });

            // Remove row
            $(document).on('click', '.remove_row', function () {
                $(this).closest('tr').remove();
            });

            // Add manual row
            $('#add_row').click(function () {
                const row = `
                    <tr>
                        <td><input type="text" name="vaccine_name[]" class="form-control" required></td>
                        <td><input type="number" name="dose_number[]" class="form-control" min="1" required></td>
                        <td><input type="date" name="vaccination_date[]" class="form-control" required></td>
                        <td><button type="button" class="btn btn-danger remove_row">Remove</button></td>
                    </tr>
                `;
                $('#vaccine_rows').append(row);
            });

            // Submit form
            $('#vaccine_form').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: '/admin/patient-vaccines/add',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function () {
                        alert("Doses added successfully!");
                        $('#vaccine_rows').empty();
                        $('#search_btn').click(); // reload data
                    }
                });
            });
        });
    </script>
</body>
</html>