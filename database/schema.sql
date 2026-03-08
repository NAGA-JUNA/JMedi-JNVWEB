CREATE TABLE IF NOT EXISTS admins (
    admin_id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    full_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS departments (
    department_id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    icon VARCHAR(50) DEFAULT 'fa-heartbeat',
    services TEXT,
    image VARCHAR(255),
    status SMALLINT DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS doctors (
    doctor_id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    photo VARCHAR(255),
    department_id INT REFERENCES departments(department_id) ON DELETE SET NULL,
    qualification VARCHAR(255),
    experience VARCHAR(100),
    specialization VARCHAR(255),
    bio TEXT,
    email VARCHAR(100),
    phone VARCHAR(30),
    available_days VARCHAR(255),
    available_time VARCHAR(100),
    status SMALLINT DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS appointments (
    appointment_id SERIAL PRIMARY KEY,
    patient_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    department_id INT REFERENCES departments(department_id) ON DELETE SET NULL,
    doctor_id INT REFERENCES doctors(doctor_id) ON DELETE SET NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    message TEXT,
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS posts (
    post_id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content TEXT,
    featured_image VARCHAR(255),
    author VARCHAR(100) DEFAULT 'Admin',
    status VARCHAR(20) DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS testimonials (
    testimonial_id SERIAL PRIMARY KEY,
    patient_name VARCHAR(100) NOT NULL,
    photo VARCHAR(255),
    content TEXT NOT NULL,
    rating SMALLINT DEFAULT 5,
    status SMALLINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS settings (
    setting_id SERIAL PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT
);

CREATE INDEX IF NOT EXISTS idx_doctors_department ON doctors(department_id);
CREATE INDEX IF NOT EXISTS idx_appointments_status ON appointments(status);
CREATE INDEX IF NOT EXISTS idx_appointments_date ON appointments(appointment_date);
CREATE INDEX IF NOT EXISTS idx_posts_status ON posts(status);
CREATE INDEX IF NOT EXISTS idx_posts_slug ON posts(slug);
CREATE INDEX IF NOT EXISTS idx_departments_slug ON departments(slug);

INSERT INTO admins (username, password, email, full_name)
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@jmedi.com', 'Administrator')
ON CONFLICT (username) DO NOTHING;

INSERT INTO settings (setting_key, setting_value) VALUES
('site_name', 'JMedi – Smart Medical Platform'),
('tagline', 'Powered by JNVWeb'),
('phone', '+1 (800) 123-4567'),
('emergency_phone', '+1 (800) 911-0000'),
('email', 'info@jmedi.com'),
('address', '123 Medical Center Drive, Health City, HC 10001'),
('facebook', 'https://facebook.com/jmedi'),
('twitter', 'https://twitter.com/jmedi'),
('instagram', 'https://instagram.com/jmedi'),
('linkedin', 'https://linkedin.com/company/jmedi'),
('primary_color', '#0D6EFD'),
('secondary_color', '#20C997'),
('footer_text', '© 2026 JMedi. All Rights Reserved. Powered by JNVWeb')
ON CONFLICT (setting_key) DO NOTHING;

INSERT INTO departments (name, slug, description, icon, services) VALUES
('Cardiology', 'cardiology', 'Our cardiology department provides comprehensive heart care including diagnosis, treatment, and prevention of cardiovascular diseases.', 'fa-heartbeat', 'ECG & Echo Tests, Cardiac Catheterization, Heart Surgery, Pacemaker Implantation, Cardiac Rehabilitation'),
('Neurology', 'neurology', 'Expert neurological care for conditions affecting the brain, spinal cord, and nervous system with advanced diagnostic tools.', 'fa-brain', 'EEG & EMG Testing, Stroke Treatment, Epilepsy Management, Headache Clinic, Neurosurgery Consultation'),
('Orthopedics', 'orthopedics', 'Specialized care for bones, joints, ligaments, and muscles with modern surgical and non-surgical treatment options.', 'fa-bone', 'Joint Replacement, Fracture Treatment, Sports Medicine, Spine Surgery, Physical Therapy'),
('Pediatrics', 'pediatrics', 'Dedicated healthcare for infants, children, and adolescents with a caring and child-friendly approach.', 'fa-baby', 'Well-Child Visits, Vaccinations, Developmental Screening, Pediatric Emergency, Neonatal Care'),
('Dermatology', 'dermatology', 'Complete skin care solutions from medical dermatology to cosmetic treatments by experienced dermatologists.', 'fa-allergies', 'Skin Cancer Screening, Acne Treatment, Laser Therapy, Cosmetic Procedures, Allergy Testing'),
('Dental', 'dental', 'Full range of dental services from preventive care to advanced dental procedures in a comfortable environment.', 'fa-tooth', 'Dental Cleaning, Root Canal, Dental Implants, Cosmetic Dentistry, Orthodontics')
ON CONFLICT (slug) DO NOTHING;

INSERT INTO doctors (name, photo, department_id, qualification, experience, specialization, bio, email, phone, available_days, available_time) VALUES
('Dr. James Wilson', NULL, 1, 'MD, FACC', '15 Years', 'Interventional Cardiology', 'Dr. Wilson is a board-certified cardiologist with over 15 years of experience in interventional cardiology and cardiovascular disease management.', 'wilson@jmedi.com', '+1-800-101-0001', 'Mon, Tue, Wed, Thu, Fri', '09:00 AM - 05:00 PM'),
('Dr. Sarah Chen', NULL, 2, 'MD, PhD Neuroscience', '12 Years', 'Clinical Neurology', 'Dr. Chen specializes in neurological disorders with a focus on stroke prevention and treatment, bringing cutting-edge research to patient care.', 'chen@jmedi.com', '+1-800-101-0002', 'Mon, Wed, Fri', '10:00 AM - 04:00 PM'),
('Dr. Michael Roberts', NULL, 3, 'MD, FAAOS', '20 Years', 'Joint Replacement Surgery', 'Dr. Roberts is an internationally recognized orthopedic surgeon specializing in minimally invasive joint replacement procedures.', 'roberts@jmedi.com', '+1-800-101-0003', 'Tue, Thu, Sat', '08:00 AM - 03:00 PM'),
('Dr. Emily Johnson', NULL, 4, 'MD, FAAP', '10 Years', 'General Pediatrics', 'Dr. Johnson provides compassionate pediatric care with a special interest in childhood development and preventive medicine.', 'johnson@jmedi.com', '+1-800-101-0004', 'Mon, Tue, Wed, Thu', '09:00 AM - 05:00 PM'),
('Dr. David Park', NULL, 5, 'MD, FAAD', '8 Years', 'Medical Dermatology', 'Dr. Park is a fellowship-trained dermatologist specializing in skin cancer detection and advanced cosmetic dermatology.', 'park@jmedi.com', '+1-800-101-0005', 'Mon, Wed, Thu, Fri', '10:00 AM - 06:00 PM'),
('Dr. Lisa Anderson', NULL, 6, 'DDS, MS', '14 Years', 'Prosthodontics', 'Dr. Anderson is an expert in dental implants and cosmetic dentistry, known for her gentle approach and excellent patient outcomes.', 'anderson@jmedi.com', '+1-800-101-0006', 'Tue, Wed, Thu, Fri', '09:00 AM - 04:00 PM')
ON CONFLICT DO NOTHING;

INSERT INTO testimonials (patient_name, content, rating) VALUES
('John Martinez', 'The care I received at JMedi was exceptional. Dr. Wilson and his team treated my heart condition with the utmost professionalism and compassion.', 5),
('Sarah Thompson', 'I brought my daughter to the pediatrics department and was amazed by how child-friendly and caring the entire staff was. Highly recommended!', 5),
('Robert Kim', 'After my knee replacement surgery with Dr. Roberts, I was back on my feet in no time. The orthopedics team is truly world-class.', 5),
('Maria Garcia', 'The dermatology department helped me with a skin condition I had been struggling with for years. Dr. Park is incredibly knowledgeable.', 4)
ON CONFLICT DO NOTHING;

INSERT INTO posts (title, slug, content, author, status) VALUES
('Understanding Heart Health: A Comprehensive Guide', 'understanding-heart-health', 'Heart disease remains the leading cause of death worldwide. Understanding the risk factors, symptoms, and prevention strategies is crucial for maintaining a healthy heart. Regular exercise, a balanced diet, and routine check-ups can significantly reduce your risk of cardiovascular disease. Our cardiology department offers comprehensive screenings and personalized treatment plans to help you stay heart-healthy.', 'Dr. James Wilson', 'published'),
('The Importance of Regular Health Check-ups', 'importance-regular-health-checkups', 'Regular health check-ups are essential for early detection of potential health issues. Many serious conditions, including certain cancers, diabetes, and heart disease, can be detected early through routine screenings. At JMedi, we recommend annual comprehensive health evaluations for adults and regular well-child visits for children.', 'Admin', 'published'),
('Advances in Orthopedic Surgery', 'advances-orthopedic-surgery', 'Modern orthopedic surgery has made remarkable advances in recent years. Minimally invasive techniques, robotic-assisted surgery, and improved implant materials have revolutionized joint replacement procedures. These advances mean shorter hospital stays, less pain, and faster recovery times for patients.', 'Dr. Michael Roberts', 'published')
ON CONFLICT (slug) DO NOTHING;
