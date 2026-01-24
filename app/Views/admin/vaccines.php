<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AV Multispeciality | Vaccines</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php include('common_styles.php'); ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

    <!-- HEADER -->
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#">
                        <i class="bi bi-list"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-md-block">
                    <a href="<?= base_url('admin/dashboard') ?>" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-md-block">
                    <a href="#" class="nav-link">Vaccines</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="/logout" class="nav-link">Sign out</a>
                </li>
            </ul>
        </div>
    </nav>

    <?php include('common_sidebar.php'); ?>

    <!-- MAIN -->
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <h3>Patient Vaccines</h3>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row g-4">

                    <!-- LEFT: PATIENT VACCINE LOG -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="bi bi-capsule"></i> Patient Vaccination
                                </h3>
                            </div>

                            <div class="card-body">

                                <!-- SEARCH -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <input type="text" id="patient_id" class="form-control"
                                               placeholder="Enter Patient ID">
                                    </div>
                                    <div class="col-md-2">
                                        <button id="search_btn" class="btn btn-primary">Search</button>
                                    </div>
                                </div>

                                <!-- PATIENT INFO -->
                                <div id="patient_info" style="display:none;">
                                    <h5>Patient Info</h5>
                                    <p><strong>Name:</strong> <span id="p_name"></span></p>
                                    <p><strong>Gender:</strong> <span id="p_gender"></span></p>
                                    <p><strong>DOB:</strong> <span id="p_dob"></span></p>
                                    <p><strong>Age:</strong> <span id="p_age"></span></p>
                                </div>

                                <!-- VACCINE TABLE -->
                                <div class="mt-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Due Age</th>
                                                    <th>Vaccine</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="due_vaccines">
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        Search patient to load vaccines
                                                    </td>
                                                </tr>
                                            </tbody>
    
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- RIGHT: VACCINATION CHART -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="bi bi-calendar"></i> Vaccination Chart
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Due Age</th>
                                            <th>Vaccines</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($vaccinesByStage as $stage): ?>
                                            <?php $count = count($stage['vaccines']); ?>
                                            <?php foreach ($stage['vaccines'] as $k => $vaccine): ?>
                                                <tr>
                                                    <?php if ($k === 0): ?>
                                                        <td rowspan="<?= $count ?>"><?= $i++ ?></td>
                                                        <td rowspan="<?= $count ?>">
                                                            <?= esc($stage['stage_label']) ?>
                                                        </td>
                                                    <?php endif; ?>
                                                    <td><?= esc($vaccine) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
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

    <?php include('common_footer.php'); ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php include('common_script.php'); ?>

<script>
    function renderVaccinationChart(doses) {
        let html = '';
        let index = 1;

        const stages = {};

        // Group by stage
        doses.forEach(d => {
            if (!stages[d.stage_label]) {
                stages[d.stage_label] = [];
            }
            stages[d.stage_label].push(d);
        });

        Object.keys(stages).forEach(stage => {
            const rows = stages[stage];
            const pending = rows.some(r => r.status === 'pending');
            const stageStatus = pending ? 'pending' : 'completed';

            rows.forEach((r, i) => {
                html += '<tr>';

                if (i === 0) {
                    html += `
                        <td rowspan="${rows.length}">${index++}</td>
                        <td rowspan="${rows.length}">${stage}</td>
                    `;
                }

                html += `<td>${r.vaccine_name} ${r.dose_label ?? ''}</td>`;

                if (i === 0) {
                    html += `
                        <td rowspan="${rows.length}">
                            <span class="badge bg-${stageStatus === 'pending' ? 'warning' : 'success'}">
                                ${stageStatus}
                            </span>
                        </td>
                        <td rowspan="${rows.length}">
                            ${
                                stageStatus === 'pending'
                                ? `<button class="btn btn-sm btn-success mark-stage"
                                        data-stage="${r.vaccination_stage_id}">
                                    Mark Given
                                </button>`
                                : '-'
                            }
                        </td>
                    `;
                }

                html += '</tr>';
            });
        });

        $('#due_vaccines').html(html);
    }

    // EVENTS
    $(document).on('click', '.mark-stage', function () {
        $.post('/admin/patient-vaccines/add', {
            patient_id: $('#patient_id').val(),
            vaccination_stage_id: $(this).data('stage')
        }, () => $('#search_btn').click());
    });

    $(document).ready(function () {
        $('#search_btn').click(function () {
            const patientId = $('#patient_id').val().trim();
            if (!patientId) return alert('Enter Patient ID');

            $.get('/admin/patient-vaccines/' + patientId, function (data) {

                if (!data.patient) {
                    alert('Patient not found');
                    return;
                }

                $('#p_name').text(data.patient.name);
                $('#p_gender').text(data.patient.gender ?? '-');
                $('#p_dob').text(data.patient.dob ?? '-');
                $('#p_age').text(data.patient.age ?? '-');
                $('#patient_info').show();

                if (!data.doses || data.doses.length === 0) {
                    $('#due_vaccines').html(
                        `<tr><td colspan="5">No vaccination schedule found</td></tr>`
                    );
                } else {
                    renderVaccinationChart(data.doses);
                }
            });
        });
    });
</script>


</body>
</html>