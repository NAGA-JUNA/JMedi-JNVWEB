<footer class="footer bg-dark text-light pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <h5 class="mb-3"><span class="text-primary">J</span><span class="text-success">Medi</span></h5>
                <p class="text-muted"><?= e($settings['tagline'] ?? 'Smart Medical Platform') ?></p>
                <p class="text-muted small"><i class="fas fa-map-marker-alt me-2"></i><?= e($settings['address'] ?? '') ?></p>
                <p class="text-muted small"><i class="fas fa-phone me-2"></i><?= e($settings['phone'] ?? '') ?></p>
                <p class="text-muted small"><i class="fas fa-envelope me-2"></i><?= e($settings['email'] ?? '') ?></p>
            </div>
            <div class="col-lg-2 col-md-6">
                <h6 class="mb-3">Quick Links</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="/">Home</a></li>
                    <li><a href="/public/departments.php">Departments</a></li>
                    <li><a href="/public/doctors.php">Doctors</a></li>
                    <li><a href="/public/blog.php">Blog</a></li>
                    <li><a href="/public/contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="mb-3">Departments</h6>
                <ul class="list-unstyled footer-links">
                    <?php
                    $footerDepts = getDepartments($pdo);
                    foreach (array_slice($footerDepts, 0, 6) as $dept): ?>
                    <li><a href="/public/departments.php?slug=<?= e($dept['slug']) ?>"><?= e($dept['name']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="mb-3">Emergency</h6>
                <div class="emergency-box p-3 rounded" style="background: rgba(13,110,253,0.1); border-left: 4px solid var(--primary);">
                    <p class="mb-1 fw-bold"><i class="fas fa-phone-alt me-2 text-primary"></i>Emergency Line</p>
                    <p class="h5 text-primary mb-1"><?= e($settings['emergency_phone'] ?? '') ?></p>
                    <small class="text-muted">Available 24/7</small>
                </div>
                <div class="mt-3">
                    <?php if (!empty($settings['facebook'])): ?><a href="<?= e($settings['facebook']) ?>" class="text-muted me-3 fs-5"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
                    <?php if (!empty($settings['twitter'])): ?><a href="<?= e($settings['twitter']) ?>" class="text-muted me-3 fs-5"><i class="fab fa-twitter"></i></a><?php endif; ?>
                    <?php if (!empty($settings['instagram'])): ?><a href="<?= e($settings['instagram']) ?>" class="text-muted me-3 fs-5"><i class="fab fa-instagram"></i></a><?php endif; ?>
                    <?php if (!empty($settings['linkedin'])): ?><a href="<?= e($settings['linkedin']) ?>" class="text-muted fs-5"><i class="fab fa-linkedin-in"></i></a><?php endif; ?>
                </div>
            </div>
        </div>
        <hr class="border-secondary mt-4">
        <p class="text-center text-muted small mb-0"><?= e($settings['footer_text'] ?? '© 2026 JMedi. All Rights Reserved.') ?></p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="/assets/js/main.js"></script>
</body>
</html>
