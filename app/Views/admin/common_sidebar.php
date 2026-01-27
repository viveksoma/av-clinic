<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="<?php echo base_url(); ?>" class="brand-link">
        <!--begin::Brand Text-->
        <span class="brand-text fw-light">AV Multispeciality</span>
        <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
        <!--begin::Sidebar Menu-->
        <ul
            class="nav sidebar-menu flex-column"
            data-lte-toggle="treeview"
            role="menu"
            data-accordion="false"
        >
            <?php 
                $uri = service('uri'); 
                $totalSegments = $uri->getTotalSegments();
                
                // Ensure there is at least one segment before accessing it
                $last_segment = ($totalSegments > 0) ? $uri->getSegment($totalSegments) : 'home';      
            ?>
            <li class="nav-item">
                <a href="<?php echo base_url('admin/dashboard'); ?>" class="nav-link <?php if($last_segment == 'dashboard' ) { echo 'active'; } ?>">
                    <i class="nav-icon bi bi-speedometer"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url('admin/doctors'); ?>" class="nav-link <?php if($last_segment == 'doctors' ) { echo 'active'; } ?>">
                    <i class="nav-icon bi bi-person-fill"></i>
                    <p>
                        Doctors
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url('admin/patient_timeline'); ?>" class="nav-link <?php if($last_segment == 'patient_timeline' ) { echo 'active'; } ?>">
                    <i class="nav-icon bi bi-person-fill"></i>
                    <p>
                        Patient Timeline
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url('admin/appointments'); ?>" class="nav-link <?php if($last_segment == 'appointments' ) { echo 'active'; } ?>">
                    <i class="nav-icon bi bi-calendar"></i>
                    <p>
                        Appointments
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url('admin/vaccines'); ?>" class="nav-link <?php if($last_segment == 'vaccines' ) { echo 'active'; } ?>">
                    <i class="nav-icon bi bi-shield-plus"></i>
                    <p>
                        Vaccines
                    </p>
                </a>
            </li>
        </ul>
        <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="<?= base_url('admin/change-password') ?>">
            <?= csrf_field() ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Old Password</label>
                        <input type="password" name="old_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>New Password</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </div>
        </form>
    </div>
</div>
