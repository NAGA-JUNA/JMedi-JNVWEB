<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/auth.php';

$departments = getDepartments($pdo);
$doctors = getDoctors($pdo);
$testimonials = getTestimonials($pdo);
$latestPosts = getPosts($pdo, true, 3);
$emergencyPhone = $settings['emergency_phone'] ?? '';
$heroSlides = getHeroSlides($pdo, true);
?>

<?php if (!empty($heroSlides)): ?>
<section class="hero-slider">
    <div id="heroSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
        <div class="carousel-indicators">
            <?php foreach ($heroSlides as $i => $slide): ?>
            <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="<?= $i ?>" <?= $i === 0 ? 'class="active"' : '' ?>></button>
            <?php endforeach; ?>
        </div>

        <div class="carousel-inner">
            <?php foreach ($heroSlides as $i => $slide):
                $bgStyle = !empty($slide['background_image'])
                    ? "background-image:url('" . e($slide['background_image']) . "');"
                    : "background:linear-gradient(110deg, #0f2b5c 0%, #0D6EFD 50%, #20C997 100%);";
                $overlay = e($slide['overlay_color'] ?? 'rgba(15,33,55,0.7)');
                $anim = e($slide['text_animation'] ?? 'fadeIn');
            ?>
            <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>" data-animation="<?= $anim ?>" data-transition="<?= e($slide['transition_effect'] ?? 'slide') ?>">
                <div class="slide-bg" style="<?= $bgStyle ?>"></div>
                <div class="slide-overlay" style="background:<?= $overlay ?>;"></div>

                <div class="slide-floating-shapes">
                    <div class="floating-shape"></div>
                    <div class="floating-shape"></div>
                    <div class="floating-shape"></div>
                </div>

                <div class="slide-content">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <?php if (!empty($slide['subtitle'])): ?>
                                <div class="slide-subtitle"><i class="fas fa-plus-circle me-2"></i><?= e($slide['subtitle']) ?></div>
                                <?php endif; ?>
                                <h1 class="slide-title"><?= e($slide['title']) ?></h1>
                                <?php if (!empty($slide['description'])): ?>
                                <p class="slide-description"><?= e($slide['description']) ?></p>
                                <?php endif; ?>
                                <div class="slide-buttons">
                                    <a href="<?= e($slide['button_link'] ?? '#') ?>" class="slide-btn slide-btn-primary">
                                        <i class="fas fa-calendar-check"></i>
                                        <?= e($slide['button_text'] ?? 'Learn More') ?>
                                    </a>
                                    <a href="/public/departments.php" class="slide-btn slide-btn-outline">
                                        <i class="fas fa-stethoscope"></i>
                                        Our Services
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="slide-pattern"></div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="slide-medical-icons d-none d-lg-flex">
            <div class="med-icon"><i class="fas fa-heartbeat"></i></div>
            <div class="med-icon"><i class="fas fa-lungs"></i></div>
            <div class="med-icon"><i class="fas fa-brain"></i></div>
            <div class="med-icon"><i class="fas fa-tooth"></i></div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</section>
<?php else: ?>
<section class="hero-section">
    <div class="container position-relative" style="z-index:2;">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="hero-badge"><i class="fas fa-plus-circle me-1"></i> Welcome to JMedi</span>
                <h1 class="mb-4">We Take Care Of<br>Your <span style="color: var(--secondary);">Healthy</span> Life</h1>
                <p class="hero-subtitle mb-4">Providing comprehensive healthcare solutions with world-class medical professionals.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="/public/appointment.php" class="hero-btn hero-btn-light"><i class="fas fa-calendar-check me-2"></i>Make Appointment</a>
                    <a href="/public/departments.php" class="hero-btn hero-btn-outline"><i class="fas fa-stethoscope me-2"></i>Our Services</a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="hero-icon-grid">
                    <div class="hero-floating-icon"><i class="fas fa-heartbeat"></i></div>
                    <div class="hero-floating-icon"><i class="fas fa-lungs"></i></div>
                    <div class="hero-floating-icon"><i class="fas fa-brain"></i></div>
                    <div class="hero-floating-icon"><i class="fas fa-tooth"></i></div>
                    <div class="hero-floating-icon"><i class="fas fa-bone"></i></div>
                    <div class="hero-floating-icon"><i class="fas fa-eye"></i></div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<div class="container">
    <div class="info-strip">
        <div class="row g-0">
            <div class="col-lg-3 col-md-6">
                <a href="/public/appointment.php" class="info-strip-item text-decoration-none">
                    <div class="strip-icon" style="background:var(--primary);">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <h6>Request Appointment</h6>
                        <p>Book a visit online</p>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="/public/doctors.php" class="info-strip-item text-decoration-none">
                    <div class="strip-icon" style="background:var(--secondary);">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <div>
                        <h6>Find Doctors</h6>
                        <p>Expert specialists</p>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="/public/contact.php" class="info-strip-item text-decoration-none">
                    <div class="strip-icon" style="background:#6f42c1;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h6>Find Locations</h6>
                        <p>Visit our hospital</p>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="info-strip-item">
                    <div class="strip-icon" style="background:#dc3545;">
                        <i class="fas fa-ambulance"></i>
                    </div>
                    <div>
                        <h6>Emergency</h6>
                        <p><?= e($emergencyPhone) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="about-section section-padding">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 fade-in-left">
                <div class="about-img-wrapper">
                    <div class="rounded-3 overflow-hidden" style="background:linear-gradient(135deg,#e8f4fd,#d4f5e9);padding:3rem;text-align:center;">
                        <i class="fas fa-hospital" style="font-size:10rem;color:var(--primary);opacity:0.2;"></i>
                    </div>
                    <div class="about-experience-badge">
                        <div class="number">25+</div>
                        <small>Years of<br>Experience</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 fade-in-right">
                <div class="section-title text-start mb-4">
                    <span class="subtitle" style="padding-left:0;">About Us</span>
                    <h2>Welcome To JMedi<br>Central Hospital</h2>
                </div>
                <p class="mb-4" style="line-height:1.8;">At JMedi, we are committed to delivering the highest standard of medical care. Our state-of-the-art facilities combined with experienced medical professionals ensure you receive comprehensive healthcare tailored to your needs.</p>
                <ul class="about-feature-list mb-4">
                    <li><i class="fas fa-check"></i> Advanced Medical Technology</li>
                    <li><i class="fas fa-check"></i> Certified & Experienced Doctors</li>
                    <li><i class="fas fa-check"></i> 24/7 Emergency Support</li>
                    <li><i class="fas fa-check"></i> Comprehensive Health Packages</li>
                </ul>
                <a href="/public/departments.php" class="btn btn-primary px-4 py-2" style="border-radius:30px;">
                    <i class="fas fa-arrow-right me-2"></i>Discover More
                </a>
            </div>
        </div>
    </div>
</section>

<section class="section-padding" style="background:var(--light-bg);">
    <div class="container">
        <div class="section-title fade-in">
            <span class="subtitle">Departments</span>
            <h2>Our Medical Services</h2>
            <p>We provide specialized medical services across a wide range of departments</p>
        </div>
        <div class="row g-4">
            <?php foreach (array_slice($departments, 0, 6) as $i => $dept): ?>
            <div class="col-lg-4 col-md-6 fade-in delay-<?= ($i % 3) + 1 ?>">
                <div class="dept-card">
                    <div class="icon-box">
                        <i class="fas <?= e($dept['icon'] ?? 'fa-heartbeat') ?>"></i>
                    </div>
                    <h5><?= e($dept['name']) ?></h5>
                    <p><?= e(truncateText($dept['description'] ?? '', 100)) ?></p>
                    <a href="/public/departments.php?slug=<?= e($dept['slug']) ?>" class="btn btn-sm btn-outline-primary">
                        Learn More <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="section-title fade-in">
            <span class="subtitle">Meet Our Team</span>
            <h2>Specialist Doctors</h2>
            <p>Experienced and dedicated medical professionals committed to your health</p>
        </div>
        <div class="row g-4">
            <?php foreach (array_slice($doctors, 0, 4) as $i => $doc): ?>
            <div class="col-lg-3 col-md-6 scale-in delay-<?= $i + 1 ?>">
                <div class="card doctor-card">
                    <div class="doctor-img">
                        <?php if ($doc['photo']): ?>
                            <img src="<?= e($doc['photo']) ?>" alt="<?= e($doc['name']) ?>">
                        <?php else: ?>
                            <i class="fas fa-user-md placeholder-icon"></i>
                        <?php endif; ?>
                        <div class="doctor-overlay">
                            <a href="/public/doctor-profile.php?id=<?= $doc['doctor_id'] ?>" class="social-icon"><i class="fas fa-link"></i></a>
                            <?php if (!empty($doc['email'])): ?>
                            <a href="mailto:<?= e($doc['email']) ?>" class="social-icon"><i class="fas fa-envelope"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($doc['phone'])): ?>
                            <a href="tel:<?= e($doc['phone']) ?>" class="social-icon"><i class="fas fa-phone"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5><a href="/public/doctor-profile.php?id=<?= $doc['doctor_id'] ?>" class="text-decoration-none text-dark"><?= e($doc['name']) ?></a></h5>
                        <span class="dept-badge"><?= e($doc['department_name'] ?? '') ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5 fade-in">
            <a href="/public/doctors.php" class="btn btn-primary px-5 py-2" style="border-radius:30px;">
                View All Doctors <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container position-relative" style="z-index:2;">
        <div class="row align-items-center">
            <div class="col-lg-8 text-lg-start">
                <h2 style="font-size:2.2rem;">Need a Doctor for Check-up?</h2>
                <p class="mb-0">Just make an appointment and you're done!</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="/public/appointment.php" class="btn btn-light btn-lg px-5" style="border-radius:30px;font-weight:700;color:var(--primary);">
                    <i class="fas fa-calendar-check me-2"></i>Make Appointment
                </a>
            </div>
        </div>
    </div>
</section>

<section class="appointment-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0 fade-in-left">
                <span class="hero-badge"><i class="fas fa-calendar-alt me-1"></i> Appointment</span>
                <h2 class="fw-bold mb-3" style="color:white;font-size:2.2rem;">Book Your<br>Appointment</h2>
                <p class="opacity-75 mb-4" style="line-height:1.8;">Schedule your visit with our specialists. Fill out the form and we'll confirm your appointment within 24 hours.</p>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width:50px;height:50px;border-radius:50%;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-phone-alt fs-5"></i>
                    </div>
                    <div>
                        <small class="d-block opacity-75">Call us directly</small>
                        <span class="fs-5 fw-bold"><?= e($settings['phone'] ?? '') ?></span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div style="width:50px;height:50px;border-radius:50%;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-clock fs-5"></i>
                    </div>
                    <div>
                        <small class="d-block opacity-75">Working Hours</small>
                        <span class="fw-bold">Mon-Sat: 8:00 AM - 7:00 PM</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 fade-in-right">
                <form action="/public/appointment.php" method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCSRFToken()) ?>">
                    <input type="hidden" name="book_appointment" value="1">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="patient_name" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                        </div>
                        <div class="col-md-6">
                            <input type="tel" name="phone" class="form-control" placeholder="Phone Number" required>
                        </div>
                        <div class="col-md-6">
                            <select name="department_id" class="form-select" required>
                                <option value="">Select Department</option>
                                <?php foreach ($departments as $dept): ?>
                                <option value="<?= $dept['department_id'] ?>"><?= e($dept['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="date" name="appointment_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <input type="time" name="appointment_time" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <textarea name="message" class="form-control" rows="3" placeholder="Your Message (optional)"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn-appointment">
                                <i class="fas fa-paper-plane me-2"></i>Submit Appointment
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="process-section section-padding">
    <div class="container">
        <div class="section-title fade-in">
            <span class="subtitle">Working Process</span>
            <h2>How It Helps You Stay Healthy</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 fade-in delay-1">
                <div class="process-card">
                    <div class="process-icon">
                        <i class="fas fa-calendar-check"></i>
                        <span class="process-number">01</span>
                    </div>
                    <h5>Book Appointment</h5>
                    <p>Schedule your visit online easily with our booking system</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 fade-in delay-2">
                <div class="process-card">
                    <div class="process-icon">
                        <i class="fas fa-stethoscope"></i>
                        <span class="process-number">02</span>
                    </div>
                    <h5>Consultation</h5>
                    <p>Meet with experienced doctors for thorough evaluation</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 fade-in delay-3">
                <div class="process-card">
                    <div class="process-icon">
                        <i class="fas fa-prescription"></i>
                        <span class="process-number">03</span>
                    </div>
                    <h5>Treatment Plan</h5>
                    <p>Receive personalized treatment plans tailored for you</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 fade-in delay-4">
                <div class="process-card">
                    <div class="process-icon">
                        <i class="fas fa-smile-beam"></i>
                        <span class="process-number">04</span>
                    </div>
                    <h5>Get Healthy</h5>
                    <p>Recover and enjoy a healthy, happy life with ongoing care</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="stats-section">
    <div class="container position-relative" style="z-index:2;">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item fade-in delay-1">
                    <div class="stat-icon"><i class="fas fa-hospital"></i></div>
                    <div class="stat-number"><span class="counter-number" data-target="25">0</span>+</div>
                    <div class="stat-label">Years of Experience</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item fade-in delay-2">
                    <div class="stat-icon"><i class="fas fa-user-md"></i></div>
                    <div class="stat-number"><span class="counter-number" data-target="<?= getCount($pdo, 'doctors') ?>">0</span></div>
                    <div class="stat-label">Medical Specialists</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item fade-in delay-3">
                    <div class="stat-icon"><i class="fas fa-procedures"></i></div>
                    <div class="stat-number"><span class="counter-number" data-target="13">0</span></div>
                    <div class="stat-label">Modern Rooms</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item fade-in delay-4">
                    <div class="stat-icon"><i class="fas fa-smile"></i></div>
                    <div class="stat-number"><span class="counter-number" data-target="1500">0</span>+</div>
                    <div class="stat-label">Happy Patients</div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ($testimonials): ?>
<section class="section-padding" style="background:var(--light-bg);">
    <div class="container">
        <div class="section-title fade-in">
            <span class="subtitle">Testimonials</span>
            <h2>What Our Patients Say</h2>
            <p>Real stories from real patients about their experience at JMedi</p>
        </div>
        <div class="swiper testimonial-swiper">
            <div class="swiper-wrapper">
                <?php foreach ($testimonials as $t): ?>
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <div class="stars">
                            <?php for ($i = 0; $i < ($t['rating'] ?? 5); $i++): ?>
                                <i class="fas fa-star"></i>
                            <?php endfor; ?>
                        </div>
                        <blockquote>"<?= e($t['content']) ?>"</blockquote>
                        <div class="patient-info">
                            <div class="patient-avatar"><?= strtoupper(substr($t['patient_name'], 0, 1)) ?></div>
                            <div>
                                <p class="patient-name"><?= e($t['patient_name']) ?></p>
                                <span class="patient-title">Patient</span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($latestPosts): ?>
<section class="section-padding">
    <div class="container">
        <div class="section-title fade-in">
            <span class="subtitle">Articles</span>
            <h2>Our Latest News</h2>
            <p>Stay informed with the latest medical news and health tips</p>
        </div>
        <div class="row g-4">
            <?php foreach ($latestPosts as $i => $post): ?>
            <div class="col-lg-4 col-md-6 fade-in delay-<?= $i + 1 ?>">
                <div class="card blog-card">
                    <div class="blog-img">
                        <?php if ($post['featured_image']): ?>
                            <img src="<?= e($post['featured_image']) ?>" alt="<?= e($post['title']) ?>">
                        <?php else: ?>
                            <i class="fas fa-newspaper placeholder-icon"></i>
                        <?php endif; ?>
                        <span class="blog-date-badge"><i class="far fa-calendar-alt me-1"></i><?= formatDate($post['created_at']) ?></span>
                    </div>
                    <div class="card-body">
                        <div class="blog-meta">
                            <i class="fas fa-user"></i> <?= e($post['author'] ?? 'Admin') ?>
                        </div>
                        <h5><?= e($post['title']) ?></h5>
                        <p class="text-muted small"><?= e(truncateText($post['content'] ?? '', 110)) ?></p>
                        <a href="/public/blog.php?slug=<?= e($post['slug']) ?>" class="read-more">
                            Read More <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="cta-section" style="background:linear-gradient(110deg,var(--secondary-dark),var(--secondary));">
    <div class="container position-relative" style="z-index:2;">
        <i class="fas fa-heartbeat mb-3" style="font-size:3rem;opacity:0.3;"></i>
        <h2>Ready to Get Started?</h2>
        <p class="mb-4 mx-auto" style="max-width:600px;">Our team of experienced doctors is ready to help you. Book your appointment today and take the first step towards better health.</p>
        <a href="/public/appointment.php" class="btn btn-light btn-lg px-5 me-2" style="border-radius:30px;font-weight:700;color:var(--secondary);">
            <i class="fas fa-calendar-check me-2"></i>Book Appointment
        </a>
        <a href="/public/contact.php" class="btn btn-outline-light btn-lg px-5" style="border-radius:30px;">
            <i class="fas fa-phone me-2"></i>Contact Us
        </a>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
