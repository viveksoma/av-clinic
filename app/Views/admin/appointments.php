<!doctype html>
<html lang="en">
  <!--begin::Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AV Multispeciality | Appointments</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AV Multispeciality | Appointments" />
    <meta name="author" content="ColorlibHQ" />
     <link href="<?= base_url('assets/simple-datatables/style.css'); ?>" rel="stylesheet">
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
                <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Appointments</a></li>
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
                    <div class="col-sm-6"><h3 class="mb-0">Appointments</h3></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Appointments</li>
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
                        <div class="col-md-12">
                            <!-- Online Filter -->
                            <form method="get" class="row g-3 mb-3">
                                <div class="col-md-3">
                                    <label>From Date (Online)</label>
                                    <input type="date" class="form-control" name="from_date_online" value="<?= esc($fromOnline ?? '') ?>">
                                </div>
                                <div class="col-md-3">
                                    <label>To Date (Online)</label>
                                    <input type="date" class="form-control" name="to_date_online" value="<?= esc($toOnline ?? '') ?>">
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button class="btn btn-primary" type="submit">Filter</button>
                                </div>
                            </form>

                            <!-- Online Table -->
                            <div class="card mb-4">
                                <div class="card-header"><h3 class="card-title">Online Appointments</h3></div>
                                <div class="card-body">
                                    <table class="table datatable" id="onlineAppointmentsTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Patient Name</th>
                                                <th>Doctor</th>
                                                <th>Appointment Type</th>
                                                <th>Appointment Date</th>
                                                <th>Slot Time</th>
                                                <th>Update Payment</th>
                                                <th>Payment Status</th>
                                                <th>Generate GoogleMeet Link</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($onlineAppointments)): ?>
                                                <?php foreach ($onlineAppointments as $appointment): ?>
                                                    <tr>
                                                        <td><?= esc($appointment['patient_id']) ?></td>
                                                        <td><?= esc($appointment['patient_name']) ?></td>
                                                        <td><?= esc($appointment['doctor_name']) ?></td>
                                                        <td><?= esc($appointment['appointment_type']) ?></td>
                                                        <td><?= date("d-m-Y", strtotime($appointment['appointment_date'])) ?></td>
                                                        <td><?= date("h:i A", strtotime($appointment['start_time'])) ?></td>
                                                        <td>
                                                            <button class="btn btn-sm btn-outline-primary update-payment-btn"
                                                                data-appointment-id="<?= $appointment['id'] ?>"
                                                                data-amount="<?= esc($appointment['payment_amount'] ?? '') ?>"
                                                                data-mode="<?= esc($appointment['payment_mode'] ?? '') ?>"
                                                                data-status="<?= esc($appointment['payment_status'] ?? '') ?>"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#paymentModal">
                                                                Update
                                                            </button>
                                                        </td>
                                                        <!-- Payment Status Column -->
                                                        <td>
                                                            <?php if (!empty($appointment['payment_status'])): ?>
                                                                <span class="badge bg-<?= $appointment['payment_status'] === 'received' ? 'success' : 'warning' ?>">
                                                                    <?= ucfirst($appointment['payment_status']) ?>
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="badge bg-secondary">Pending</span>
                                                            <?php endif; ?>
                                                        </td>

                                                        <!-- Google Meet Link Column -->
                                                        <td>
                                                            <?php if (!empty($appointment['google_meet_link'])): ?>
                                                                <a href="<?= esc($appointment['google_meet_link']) ?>" target="_blank" class="btn btn-sm btn-success">
                                                                    Join
                                                                </a>
                                                            <?php else: ?>
                                                                <?php if (strtolower($appointment['payment_status']) === 'received'): ?>
                                                                    <a href="<?= base_url("admin/appointments/generate-meet/" . $appointment['id']) ?>" class="btn btn-sm btn-outline-secondary">
                                                                        Generate
                                                                    </a>
                                                                <?php else: ?>
                                                                    <button class="btn btn-sm btn-outline-secondary" disabled>
                                                                        Generate
                                                                    </button>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        </td>


                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr><td colspan="9" class="text-center">No online appointments.</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <!-- Other Filter -->
                            <form method="get" class="row g-3 mb-3">
                                <div class="col-md-3">
                                    <label>From Date (Other)</label>
                                    <input type="date" class="form-control" name="from_date_other" value="<?= esc($fromOther ?? '') ?>">
                                </div>
                                <div class="col-md-3">
                                    <label>To Date (Other)</label>
                                    <input type="date" class="form-control" name="to_date_other" value="<?= esc($toOther ?? '') ?>">
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button class="btn btn-primary" type="submit">Filter</button>
                                </div>
                            </form>

                            <!-- Other Table -->
                            <div class="card mb-4">
                                <div class="card-header"><h3 class="card-title">Other Appointments</h3></div>
                                <div class="card-body">
                                    <table class="table datatable" id="otherAppointmentsTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Patient Name</th>
                                                <th>Doctor</th>
                                                <th>Appointment Type</th>
                                                <th>Appointment Date</th>
                                                <th>Slot Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($otherAppointments)): ?>
                                                <?php foreach ($otherAppointments as $appointment): ?>
                                                    <tr>
                                                        <td><?= esc($appointment['patient_id']) ?></td>
                                                        <td><?= esc($appointment['patient_name']) ?></td>
                                                        <td><?= esc($appointment['doctor_name']) ?></td>
                                                        <td><?= esc($appointment['appointment_type']) ?></td>
                                                        <td><?= date("d-m-Y", strtotime($appointment['appointment_date'])) ?></td>
                                                        <td><?= date("h:i A", strtotime($appointment['start_time'])) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr><td colspan="6" class="text-center">No other appointments.</td></tr>
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

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="paymentUpdateForm" method="post">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Update Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                <input type="hidden" name="appointment_id" id="modalAppointmentId">

                <div class="mb-3">
                    <label>Payment Amount</label>
                    <input type="number" step="0.01" name="payment_amount" class="form-control" id="modalAmount">
                </div>

                <div class="mb-3">
                    <label>Mode</label>
                    <select name="payment_mode" class="form-control" id="modalMode">
                    <option value="upi">UPI</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="payment_status" class="form-control" id="modalStatus">
                    <option value="pending">Pending</option>
                    <option value="received">Received</option>
                    <option value="failed">Failed</option>
                    </select>
                </div>
                </div>

                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url('assets/common.js'); ?>"></script>
    <script src="<?= base_url('assets/simple-datatables/simple-datatables.js'); ?>"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            new simpleDatatables.DataTable("#onlineAppointmentsTable");
        });

        document.addEventListener("DOMContentLoaded", function () {
            new simpleDatatables.DataTable("#otherAppointmentsTable");
        });

        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".update-payment-btn").forEach(btn => {
                btn.addEventListener("click", function () {
                    document.getElementById("modalAppointmentId").value = btn.dataset.appointmentId;
                    document.getElementById("modalAmount").value = btn.dataset.amount || '';
                    document.getElementById("modalMode").value = btn.dataset.mode || 'upi';
                    document.getElementById("modalStatus").value = btn.dataset.status || 'pending';
                });
            });

            document.getElementById("paymentUpdateForm").addEventListener("submit", function (e) {
                e.preventDefault();

                const form = this;
                const formData = new FormData(form);

                fetch("/admin/payments/update", {
                    method: "POST",
                    body: formData,
                })
                .then(resp => resp.json())
                .then(data => {
                    if (data.success) {
                        alert("Payment updated.");
                        window.location.reload(); // or update row via JS
                    } else {
                        alert("Failed to update.");
                    }
                })
                .catch(err => alert("Error occurred."));
            });
        });

    </script>
    <?php include('common_script.php'); ?>
</body>
</html>