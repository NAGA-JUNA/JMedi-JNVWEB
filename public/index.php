<?php
require_once __DIR__ . '/../includes/header.php';
$departments = getDepartments($pdo);
$doctors = getDoctors($pdo);
$testimonials = getTestimonials($pdo);
$latestPosts = getPosts($pdo, true, 3);
$emergencyPhone = $settings['emergency_phone'] ?? '';
?>

<section class="hero-section">
    <div class="container position-relative" style="z-index:2;">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="mb-4">Your Health Is Our<br>Top <span style="color: var(--secondary);">Priority</span></h1>
                <p class="mb-4 fs-5">Providing world-class medical services with compassion and excellence. Trust JMedi for comprehensive healthcare solutions.</p>
                <a href="/public/appointment.php" class="btn btn-light btn-lg px-5 me-3">Book Appointment</a>
                <a href="/public/doctors.php" class="btn btn-outline-light btn-lg px-4">Our Doctors</a>
            </div>
            <div class="col-lg-5 d-none d-lg-block text-center">
                <i class="fas fa-heartbeat" style="font-size:15rem;opacity:0.15;"></i>
            </div>
        </div>
    </div>
</section>

<section class="emergency-banner">
    <div class="container d-flex flex-wrap justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <i class="fas fa-ambulance fs-2 me-3"></i>
            <div>
                <small class="d-block opacity-75">24/7 Emergency Service</small>
                <span class="phone-number"><?= e($emergencyPhone) ?></span>
            </div>
        </div>
        <a href="/public/appointment.php" class="btn btn-dark px-4 mt-2 mt-md-0">Book Now</a>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="section-title">
            <h2>Our Departments</h2>
            <p>We provide specialized medical services across a wide range of departments</p>
        </div>
        <div class="row g-4">
            <?php foreach (array_slice($departments, 0, 6) as $dept): ?>
            <div class="col-lg-4 col-md-6">
                <div class="dept-card">
                    <div class="icon-box">
                        <i class="fas <?= e($dept['icon'] ?? 'fa-heartbeat') ?>"></i>
                    </div>
                    <h5><?= e($dept['name']) ?></h5>
                    <p><?= e(truncateText($dept['description'] ?? '', 100)) ?></p>
                    <a href="/public/departments.php?slug=<?= e($dept['slug']) ?>" class="btn btn-sm btn-outline-primary mt-2">Learn More</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="section-title">
            <h2>Meet Our Doctors</h2>
            <p>Experienced and dedicated medical professionals committed to your health</p>
        </div>
        <div class="row g-4">
            <?php foreach (array_slice($doctors, 0, 4) as $doc): ?>
            <div class="col-lg-3 col-md-6">
                <div class="card doctor-card">
                    <div class="doctor-img">
                        <?php if ($doc['photo']): ?>
                            <img src="<?= e($doc['photo']) ?>" alt="<?= e($doc['name']) ?>">
                        <?php else: ?>
                            <i class="fas fa-user-md placeholder-icon"></i>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <h5><?= e($doc['name']) ?></h5>
                        <span class="dept-badge"><?= e($doc['department_name'] ?? '') ?></span>
                        <div class="mt-3">
                            <a href="/public/doctor-profile.php?id=<?= $doc['doctor_id'] ?>" class="btn btn-sm btn-outline-primary">View Profile</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="/public/doctors.php" class="btn btn-primary px-5">View All Doctors</a>
        </div>
    </div>
</section>

<section class="appointment-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <h2 class="fw-bold mb-3">Book an Appointment</h2>
                <p class="opacity-75">Schedule your visit with our specialists. Fill out the form and we'll confirm your appointment within 24 hours.</p>
                <div class="d-flex align-items-center mt-4">
                    <i class="fas fa-phone-alt fs-3 me-3"></i>
                    <div>
                        <small class="d-block opacity-75">Or call us directly</small>
                        <span class="fs-5 fw-bold"><?= e($settings['phone'] ?? '') ?></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
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
                            <button type="submit" class="btn btn-light btn-lg px-5 fw-bold">Submit Appointment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php if ($testimonials): ?>
<section class="py-5 bg-light">
    <div class="container">
        <div class="section-title">
            <h2>Patient Testimonials</h2>
            <p>What our patients say about their experience at JMedi</p>
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
                        <p class="patient-name mb-0"><?= e($t['patient_name']) ?></p>
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
<section class="py-5">
    <div class="container">
        <div class="section-title">
            <h2>Latest Articles</h2>
            <p>Stay informed with the latest medical news and health tips</p>
        </div>
        <div class="row g-4">
            <?php foreach ($latestPosts as $post): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card blog-card">
                    <div class="blog-img">
                        <?php if ($post['featured_image']): ?>
                            <img src="<?= e($post['featured_image']) ?>" alt="<?= e($post['title']) ?>">
                        <?php else: ?>
                            <i class="fas fa-newspaper placeholder-icon"></i>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <span class="blog-date"><?= formatDate($post['created_at']) ?></span>
                        <h5><?= e($post['title']) ?></h5>
                        <p class="text-muted"><?= e(truncateText($post['content'] ?? '', 120)) ?></p>
                        <a href="/public/blog.php?slug=<?= e($post['slug']) ?>" class="btn btn-sm btn-outline-primary">Read More</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="cta-section">
    <div class="container">
        <h2>Need Medical Assistance?</h2>
        <p class="mb-4 opacity-75 fs-5">Our team of experienced doctors is ready to help you. Book your appointment today.</p>
        <a href="/public/appointment.php" class="btn btn-primary btn-lg px-5 me-2">Book Appointment</a>
        <a href="/public/contact.php" class="btn btn-outline-light btn-lg px-5">Contact Us</a>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
