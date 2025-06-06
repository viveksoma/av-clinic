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
                                        <div class="mb-3">
                                            <label for="doctorName" class="form-label">Doctor Name</label>
                                            <input type="text" class="form-control" id="doctorName" name="doctor_name" required>
                                        </div>

                                        <!-- Specialization -->
                                        <div class="mb-3">
                                            <label for="specialization" class="form-label">Specialization</label>
                                            <input type="text" class="form-control" id="specialization" name="specialization" required>
                                        </div>

                                        <!-- Slot Duration -->
                                        <div class="mb-3">
                                            <label for="slotDuration" class="form-label">Slot Duration (in minutes)</label>
                                            <input type="number" class="form-control" id="slotDuration" name="slot_duration" required>
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

        <?php include('common_footer.php'); ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?php include('common_script.php'); ?>
    <script>
        $("#doctorName, #specialization, #slotDuration, #inputGroupFile02").on("change", function() {
            let doctorName = $("#doctorName").val();
            let specialization = $("#specialization").val();
            let slotDuration = $("#slotDuration").val();
            let profilePic = $("#inputGroupFile02")[0].files.length;

            if (doctorName && specialization && slotDuration && profilePic > 0) {
                $("#createDoctors").prop('disabled', false);
            } else {
                $("#createDoctors").prop('disabled', true);
            }
        });

    </script>
</body>
</html>