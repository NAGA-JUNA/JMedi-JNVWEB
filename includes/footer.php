<footer class="footer text-light">
    <div class="container">
        <div class="row g-4 pb-4">
            <div class="col-lg-4 col-md-6">
                <h5 class="mb-3" style="font-size:1.8rem;"><span style="color:var(--primary);">J</span><span style="color:var(--secondary);">Medi</span></h5>
                <p style="color:#8899aa;line-height:1.8;"><?= e($settings['tagline'] ?? 'Smart Medical Platform') ?>. Providing world-class healthcare services with compassion and excellence.</p>
                <ul class="list-unstyled" style="color:#8899aa;">
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2" style="color:var(--primary);width:18px;"></i><?= e($settings['address'] ?? '') ?></li>
                    <li class="mb-2"><i class="fas fa-phone me-2" style="color:var(--primary);width:18px;"></i><?= e($settings['phone'] ?? '') ?></li>
                    <li class="mb-2"><i class="fas fa-envelope me-2" style="color:var(--primary);width:18px;"></i><?= e($settings['email'] ?? '') ?></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-6">
                <h6 class="mb-3 pb-2" style="border-bottom:2px solid var(--primary);display:inline-block;">Quick Links</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="/">Home</a></li>
                    <li><a href="/public/departments.php">Departments</a></li>
                    <li><a href="/public/doctors.php">Our Doctors</a></li>
                    <li><a href="/public/appointment.php">Appointment</a></li>
                    <li><a href="/public/blog.php">Blog</a></li>
                    <li><a href="/public/contact.php">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="mb-3 pb-2" style="border-bottom:2px solid var(--primary);display:inline-block;">Departments</h6>
                <ul class="list-unstyled footer-links">
                    <?php
                    $footerDepts = getDepartments($pdo);
                    foreach (array_slice($footerDepts, 0, 6) as $dept): ?>
                    <li><a href="/public/departments.php?slug=<?= e($dept['slug']) ?>"><?= e($dept['name']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="mb-3 pb-2" style="border-bottom:2px solid var(--primary);display:inline-block;">Emergency</h6>
                <div class="p-3 rounded-3 mb-3" style="background:rgba(13,110,253,0.12);border-left:4px solid var(--primary);">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fas fa-phone-alt" style="color:var(--primary);"></i>
                        <span style="color:#ccc;font-size:0.9rem;">Emergency Line</span>
                    </div>
                    <p class="h5 mb-1" style="color:var(--primary);font-weight:700;"><?= e($settings['emergency_phone'] ?? '') ?></p>
                    <small style="color:#8899aa;">Available 24/7 for emergencies</small>
                </div>
                <div class="social-icons mt-3">
                    <?php if (!empty($settings['facebook'])): ?><a href="<?= e($settings['facebook']) ?>"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
                    <?php if (!empty($settings['twitter'])): ?><a href="<?= e($settings['twitter']) ?>"><i class="fab fa-twitter"></i></a><?php endif; ?>
                    <?php if (!empty($settings['instagram'])): ?><a href="<?= e($settings['instagram']) ?>"><i class="fab fa-instagram"></i></a><?php endif; ?>
                    <?php if (!empty($settings['linkedin'])): ?><a href="<?= e($settings['linkedin']) ?>"><i class="fab fa-linkedin-in"></i></a><?php endif; ?>
                </div>
            </div>
        </div>
        <div class="footer-bottom text-center">
            <p class="mb-0" style="color:#6c7a8a;font-size:0.9rem;"><?= e($settings['footer_text'] ?? '© 2026 JMedi. All Rights Reserved.') ?></p>
        </div>
    </div>
</footer>

<?php
$whatsappNum = $settings['whatsapp_number'] ?? '';
?>

<?php if ($whatsappNum): ?>
<a href="https://wa.me/<?= e($whatsappNum) ?>" target="_blank" class="whatsapp-float" title="Chat on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>
<?php endif; ?>

<a href="/public/appointment.php" class="appointment-float" title="Book Appointment">
    <i class="fas fa-calendar-check"></i>
    <span>Book Appointment</span>
</a>

<style>
.whatsapp-float {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 56px;
    height: 56px;
    background: #25D366;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    box-shadow: 0 4px 15px rgba(37,211,102,0.4);
    z-index: 999;
    text-decoration: none;
    transition: all 0.3s;
}
.whatsapp-float:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(37,211,102,0.5);
    color: #fff;
}
.appointment-float {
    position: fixed;
    right: -2px;
    top: 50%;
    transform: translateY(-50%);
    background: var(--primary, #0D6EFD);
    color: #fff;
    text-decoration: none;
    padding: 12px 14px;
    border-radius: 12px 0 0 12px;
    writing-mode: vertical-lr;
    text-orientation: mixed;
    font-size: 0.82rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    z-index: 999;
    box-shadow: -3px 0 15px rgba(0,0,0,0.15);
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 8px;
}
.appointment-float i {
    font-size: 1.1rem;
    writing-mode: horizontal-tb;
}
.appointment-float:hover {
    right: 0;
    padding-right: 18px;
    background: #0b5ed7;
    color: #fff;
    box-shadow: -5px 0 20px rgba(0,0,0,0.2);
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="/assets/js/main.js"></script>
<script src="/assets/js/hero-slider.js"></script>
<script>
(function() {
    const form = document.getElementById('loginForm');
    if (!form) return;

    const alert = document.getElementById('loginAlert');
    const btnText = document.getElementById('loginBtnText');
    const spinner = document.getElementById('loginSpinner');
    const submitBtn = document.getElementById('loginSubmitBtn');
    const toggleBtn = document.getElementById('togglePassword');
    const passInput = document.getElementById('loginPassword');

    toggleBtn.addEventListener('click', function() {
        const type = passInput.type === 'password' ? 'text' : 'password';
        passInput.type = type;
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });

    function showAlert(message, type) {
        alert.className = 'alert alert-' + type + ' mb-3';
        alert.textContent = message;
        alert.classList.remove('d-none');
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const username = document.getElementById('loginUsername').value.trim();
        const password = passInput.value;

        if (!username || !password) {
            showAlert('Please enter both username and password.', 'danger');
            return;
        }

        submitBtn.disabled = true;
        btnText.classList.add('d-none');
        spinner.classList.remove('d-none');
        alert.classList.add('d-none');

        try {
            const csrfToken = form.querySelector('input[name="csrf_token"]').value;
            const res = await fetch('/public/api/login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ username, password, csrf_token: csrfToken })
            });
            const data = await res.json();

            if (data.success) {
                showAlert(data.message, 'success');
                setTimeout(function() {
                    window.location.href = data.redirect || '/admin/';
                }, 800);
            } else {
                showAlert(data.message, 'danger');
                submitBtn.disabled = false;
                btnText.classList.remove('d-none');
                spinner.classList.add('d-none');
            }
        } catch (err) {
            showAlert('Connection error. Please try again.', 'danger');
            submitBtn.disabled = false;
            btnText.classList.remove('d-none');
            spinner.classList.add('d-none');
        }
    });

    document.getElementById('loginModal').addEventListener('hidden.bs.modal', function() {
        form.reset();
        alert.classList.add('d-none');
        submitBtn.disabled = false;
        btnText.classList.remove('d-none');
        spinner.classList.add('d-none');
        passInput.type = 'password';
        toggleBtn.querySelector('i').className = 'fas fa-eye';
    });
})();
</script>
</body>
</html>
