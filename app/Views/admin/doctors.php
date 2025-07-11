<!doctype html>
<html lang="en">
  <!--begin::Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AV Multispeciality | Doctors</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AV Multispeciality | Doctors" />
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
                <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Doctors</a></li>
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
                    <div class="col-sm-6"><h3 class="mb-0">Doctors</h3></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Doctors</li>
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
                            <form action="/doctors/store" method="POST" enctype="multipart/form-data">
                                <div class="card card-primary card-outline mb-4">
                                    <div class="card-header">
                                        <div class="card-title">Create Doctors</div>
                                    </div>

                                    <div class="card-body">
                                        <!-- Doctor Name -->
                                        <input type="hidden" name="doctor_id" id="doctorId" value="">
                                        <div class="mb-3">
                                            <label for="doctorName" class="form-label">Doctor Name</label>
                                            <input type="text" class="form-control" id="doctorName" name="doctor_name" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="doctorEmail" class="form-label">Doctor Email</label>
                                            <input type="text" class="form-control" id="doctorEmail" name="doctor_email" required>
                                        </div>

                                        <!-- Qualifications -->
                                        <div class="mb-3">
                                            <label for="qualifications" class="form-label">Qualifications</label>
                                            <input type="text" class="form-control" id="qualifications" name="qualifications">
                                        </div>

                                        <!-- Specialization -->
                                        <div class="mb-3">
                                            <label for="specialization" class="form-label">Specialization</label>
                                            <input type="text" class="form-control" id="specialization" name="specialization" required>
                                        </div>
    
                                        <!-- About Doctor (markdown supported) -->
                                        <div class="mb-3">
                                            <label for="about" class="form-label">About Doctor</label>
                                            <textarea class="form-control" id="about" name="about" rows="5" placeholder="You can use markdown here..."></textarea>
                                        </div>

                                        <!-- Slot Duration -->
                                        <div class="mb-3">
                                            <label for="slotDuration" class="form-label">Slot Duration (in minutes)</label>
                                            <input type="number" class="form-control" id="slotDuration" name="slot_duration" required>
                                        </div>
    
                                        <!-- Social Media Links -->
                                        <div class="mb-3">
                                            <label class="form-label d-block">Social Media Links</label>
                                            <div class="row g-4">
                                                <div class="col-md-3">
                                                    <label for="fburl" class="form-label">Facebook URL</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="url" class="form-control mb-2" name="social_links[facebook]" placeholder="Facebook URL" value="https://www.facebook.com">
                                                </div>
                                            </div>
                                            <div class="row g-4">
                                                <div class="col-md-3">
                                                    <label for="instaurl" class="form-label">Instagram URL</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="url" class="form-control mb-2" name="social_links[instagram]" placeholder="Instagram URL" value="https://www.instagram.com">
                                                </div>
                                            </div>
                                            <div class="row g-4">
                                                <div class="col-md-3">
                                                    <label for="twitterurl" class="form-label">Twitter URL</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="url" class="form-control mb-2" name="social_links[twitter]" placeholder="Twitter URL" value="https://x.com/home">
                                                </div>
                                            </div>
                                            <div class="row g-4">
                                                <div class="col-md-3">
                                                    <label for="linkedurl" class="form-label">LinkedIn URL</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="url" class="form-control mb-2" name="social_links[linkedin]" placeholder="LinkedIn URL" value="https://www.linkedin.com">
                                                </div>
                                            </div>
                                            <div class="row g-4">
                                                <div class="col-md-3">
                                                    <label for="youtubeurl" class="form-label">YouTube URL</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="url" class="form-control" name="social_links[youtube]" placeholder="YouTube URL" value="https://www.youtube.com">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Profile Pic -->
                                        <div class="input-group mb-3">
                                            <input type="file" class="form-control" id="inputGroupFile02" name="profile_pic" required />
                                            <label class="input-group-text" for="inputGroupFile02">Upload Profile Pic</label>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary" id="createDoctors" disabled>Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header"><h3 class="card-title">Doctors</h3></div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Doctor Name</th>
                                                <th>Specialization</th>
                                                <th>Slot Duration</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($doctors)): ?>
                                                <?php foreach ($doctors as $index => $doctor): ?>
                                                    <tr class="align-middle">
                                                        <td><?= esc($doctor['id']) ?></td>
                                                        <td><?= esc($doctor['name']) ?></td>
                                                        <td><?= esc($doctor['specialization']) ?></td>
                                                        <td><?= esc($doctor['slot_duration']) ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary edit-doctor-btn"
                                                                data-id="<?= esc($doctor['id']) ?>"
                                                                data-name="<?= esc($doctor['name']) ?>"
                                                                data-email="<?= esc($doctor['email']) ?>"
                                                                data-specialization="<?= esc($doctor['specialization']) ?>"
                                                                data-slot_duration="<?= esc($doctor['slot_duration']) ?>"
                                                                data-qualifications="<?= esc($doctor['qualifications'] ?? '') ?>"
                                                                data-about="<?= esc($doctor['about'] ?? '') ?>"
                                                                data-social_links='<?= esc($doctor['social_links'] ?? '{}') ?>'
                                                            >Edit</button>

                                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#availabilityModal" data-doctor-id="<?= $doctor['id'] ?>">Set Availability</button>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr><td colspan="5" class="text-center">No doctors available.</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
        <!--end::App Main-->
        <div class="modal fade" id="availabilityModal" tabindex="-1" aria-labelledby="availabilityModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="availabilityForm">
                <input type="hidden" id="doctorIdAvailability" name="doctor_id">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Doctor Weekly Availability</h5>
                    </div>
                    <div class="modal-body">
                    <div id="availabilityDays">
                        <?php
                        $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                        foreach ($days as $day):
                        ?>
                        <div class="border rounded p-3 mb-2">
                            <div class="form-check mb-2">
                                <input class="form-check-input day-checkbox" type="checkbox" value="<?= $day ?>" id="check-<?= $day ?>" name="selected_days[]">
                                <label class="form-check-label fw-bold" for="check-<?= $day ?>"><?= $day ?></label>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label>Morning (Start - End)</label>
                                    <input type="time" class="form-control" name="availability[<?= $day ?>][morning_start]" value="09:00">
                                    <input type="time" class="form-control" name="availability[<?= $day ?>][morning_end]" value="12:00">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label>Evening (Start - End)</label>
                                    <input type="time" class="form-control" name="availability[<?= $day ?>][evening_start]" value="18:00">
                                    <input type="time" class="form-control" name="availability[<?= $day ?>][evening_end]" value="20:00">
                                </div>
                            </div>

                        </div>
                        <?php endforeach; ?>
                    </div>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Availability</button>
                    </div>
                </div>
                </form>
            </div>
        </div>



        <?php include('common_footer.php'); ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?php include('common_script.php'); ?>
    <script>
        let isUpdateMode = false;
        $("#doctorName, #doctorEmail, #specialization, #slotDuration, #inputGroupFile02").on("change", function() {
            let doctorName = $("#doctorName").val();
            let doctorEmail = $("#doctorEmail").val();
            let specialization = $("#specialization").val();
            let slotDuration = $("#slotDuration").val();
            let profilePic = $("#inputGroupFile02")[0].files.length;

            if (doctorName && doctorEmail && specialization && slotDuration && (isUpdateMode || profilePic > 0)) {
                $("#createDoctors").prop('disabled', false);
            } else {
                $("#createDoctors").prop('disabled', true);
            }
        });

        $(document).ready(function () {
            $('#availabilityModal').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget); // Button that triggered the modal
                const doctorId = button.data('doctor-id'); // Extract info from data-* attributes

                $('#doctorIdAvailability').val(doctorId); // ✅ Set hidden input

                // Clear all fields first
                $('#availabilityForm input[type="checkbox"]').prop('checked', false);
                // $('#availabilityForm input[type="time"]').val('');

                // Fetch existing availability
                $.get(`/admin/doctor/availability/${doctorId}`, function (data) {
                    data.forEach(entry => {
                        $(`#check-${entry.day_of_week}`).prop('checked', true);
                        $(`[name="availability[${entry.day_of_week}][morning_start]"]`).val(entry.morning_start);
                        $(`[name="availability[${entry.day_of_week}][morning_end]"]`).val(entry.morning_end);
                        $(`[name="availability[${entry.day_of_week}][evening_start]"]`).val(entry.evening_start);
                        $(`[name="availability[${entry.day_of_week}][evening_end]"]`).val(entry.evening_end);
                    });
                });
            });
        });

        $('#availabilityForm').on('submit', function (e) {
            e.preventDefault();
            const doctorId = $('#doctorIdAvailability').val();
            const availability = {};

            $('input[type="checkbox"]:checked').each(function () {
                const day = $(this).val();
                availability[day] = {
                    morning_start: $(`[name="availability[${day}][morning_start]"]`).val(),
                    morning_end: $(`[name="availability[${day}][morning_end]"]`).val(),
                    evening_start: $(`[name="availability[${day}][evening_start]"]`).val(),
                    evening_end: $(`[name="availability[${day}][evening_end]"]`).val()
                };
            });

            $.post('/admin/doctor/availability/update', {
                doctor_id: doctorId,
                availability: availability
            }, function (res) {
                if (res.status === 'success') {
                    alert('Availability saved successfully.');
                    $('#availabilityModal').modal('hide');
                } else {
                    alert('Failed to save availability.');
                }
            });
        });


    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#about').summernote({
                height: 200,
                callbacks: {
                    onInit: function() {
                        console.log("Summernote is initialized");
                        $('#about').summernote('code', ''); // Safe to clear content
                    }
                }
            });
        });
        document.querySelectorAll('.edit-doctor-btn').forEach(button => {
            button.addEventListener('click', () => {
                // Populate fields
                isUpdateMode = true;
                $('#inputGroupFile02').removeAttr('required');
                document.querySelector('#doctorId').value = button.dataset.id;
                document.querySelector('#doctorName').value = button.dataset.name;
                document.querySelector('#doctorEmail').value = button.dataset.email;
                document.querySelector('#specialization').value = button.dataset.specialization;
                document.querySelector('#slotDuration').value = button.dataset.slot_duration;
                document.querySelector('#qualifications').value = button.dataset.qualifications;
                $('#about').summernote('code', button.dataset.about || '');

                const socialLinks = JSON.parse(button.dataset.social_links || '{}');
                document.querySelector('[name="social_links[facebook]"]').value = socialLinks.facebook || '';
                document.querySelector('[name="social_links[instagram]"]').value = socialLinks.instagram || '';
                document.querySelector('[name="social_links[twitter]"]').value = socialLinks.twitter || '';
                document.querySelector('[name="social_links[linkedin]"]').value = socialLinks.linkedin || '';
                document.querySelector('[name="social_links[youtube]"]').value = socialLinks.youtube || '';

                // Enable submit button
                document.querySelector('#createDoctors').innerText = 'Update';
                document.querySelector('#createDoctors').disabled = false;
            });
        });

    </script>
</body>
</html>