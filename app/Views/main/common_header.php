    <!-- Topbar Start -->
    <div class="container-fluid py-2 border-bottom d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-lg-start mb-2 mb-lg-0">
                    <div class="d-inline-flex align-items-center">
                        <a class="text-decoration-none text-body pe-3" href=""><i class="bi bi-telephone me-2"></i>+91 904 207 6804</a>
                        <span class="text-body">|</span>
                        <a class="text-decoration-none text-body px-3" href=""><i class="bi bi-envelope me-2"></i>info@example.com</a>
                    </div>
                </div>
                <div class="col-md-6 text-center text-lg-end">
                    <div class="d-inline-flex align-items-center">
                        <a class="text-body px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-body px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-body px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-body px-2" href="">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a class="text-body ps-2" href="">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <?php 
      $uri = service('uri'); 
      $totalSegments = $uri->getTotalSegments();
      
      // Ensure there is at least one segment before accessing it
      $last_segment = ($totalSegments > 0) ? $uri->getSegment($totalSegments) : 'home';      
      $first_segment = $uri->getSegment(1); 
    ?>
    <!-- Navbar Start -->
    <div class="container-fluid sticky-top bg-white shadow-sm">
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0">
                <a href="<?php echo base_url(); ?>" class="navbar-brand">
                    <h1 class="m-0 text-uppercase text-primary"><img src="<?= base_url('assets/main/img/av-logo.jpeg'); ?>" style="object-fit: cover; width: 20%;">AV Multispeciality</h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="<?php echo base_url(); ?>" class="nav-item nav-link <?php if($last_segment == 'home' ) { echo 'active'; } ?>">Home</a>
                        <a href="<?php echo base_url('about'); ?>" class="nav-item nav-link <?php if($last_segment == 'about') { echo 'active'; } ?>">About</a>
                        <a href="<?php echo base_url('service'); ?>" class="nav-item nav-link <?php if($last_segment == 'service') { echo 'active'; } ?>">Service</a>
                        <a href="<?php echo base_url('doctor'); ?>" class="nav-item nav-link <?php if($first_segment == 'doctor') { echo 'active'; } ?>">Our Doctors</a>
                        <a href="<?php echo base_url('appointment'); ?>" class="nav-item nav-link <?php if($last_segment == 'appointment') { echo 'active'; } ?>">Appointment</a>
                        <!-- <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu m-0">
                                <a href="blog.html" class="dropdown-item">Blog Grid</a>
                                <a href="detail.html" class="dropdown-item">Blog Detail</a>
                                <a href="team.html" class="dropdown-item">The Team</a>
                                <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                                <a href="appointment.html" class="dropdown-item">Appointment</a>
                                <a href="search.html" class="dropdown-item">Search</a>
                            </div>
                        </div> -->
                        <a href="<?php echo base_url('contact'); ?>" class="nav-item nav-link <?php if($last_segment == 'contact') { echo 'active'; } ?>">Contact</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->