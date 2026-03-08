document.addEventListener('DOMContentLoaded', function() {
    const testimonialSwiper = document.querySelector('.testimonial-swiper');
    if (testimonialSwiper) {
        new Swiper('.testimonial-swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 }
            }
        });
    }

    const deptFilter = document.getElementById('deptFilter');
    if (deptFilter) {
        deptFilter.addEventListener('change', function() {
            const url = new URL(window.location);
            if (this.value) {
                url.searchParams.set('department', this.value);
            } else {
                url.searchParams.delete('department');
            }
            window.location = url;
        });
    }

    const doctorSelect = document.getElementById('doctor_id');
    const departmentSelect = document.getElementById('department_id');
    if (departmentSelect && doctorSelect) {
        departmentSelect.addEventListener('change', function() {
            const deptId = this.value;
            fetch('/public/api/doctors-by-dept.php?department_id=' + deptId)
                .then(r => r.json())
                .then(doctors => {
                    doctorSelect.innerHTML = '<option value="">Select Doctor</option>';
                    doctors.forEach(doc => {
                        doctorSelect.innerHTML += `<option value="${doc.doctor_id}">${doc.name}</option>`;
                    });
                });
        });
    }

    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
});
