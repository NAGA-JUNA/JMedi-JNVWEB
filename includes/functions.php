<?php
function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function slugify(string $text): string {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9-]/', '-', $text);
    $text = preg_replace('/-+/', '-', $text);
    return trim($text, '-');
}

function getSettings(PDO $pdo): array {
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
    $settings = [];
    while ($row = $stmt->fetch()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    return $settings;
}

function getSetting(PDO $pdo, string $key, string $default = ''): string {
    $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = :key");
    $stmt->execute([':key' => $key]);
    $result = $stmt->fetch();
    return $result ? ($result['setting_value'] ?? $default) : $default;
}

function updateSetting(PDO $pdo, string $key, string $value): void {
    $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:key, :value) ON CONFLICT (setting_key) DO UPDATE SET setting_value = :value2");
    $stmt->execute([':key' => $key, ':value' => $value, ':value2' => $value]);
}

function getDepartments(PDO $pdo, bool $activeOnly = true): array {
    $sql = "SELECT * FROM departments";
    if ($activeOnly) $sql .= " WHERE status = 1";
    $sql .= " ORDER BY sort_order, name";
    return $pdo->query($sql)->fetchAll();
}

function getDepartment(PDO $pdo, int $id): ?array {
    $stmt = $pdo->prepare("SELECT * FROM departments WHERE department_id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch() ?: null;
}

function getDepartmentBySlug(PDO $pdo, string $slug): ?array {
    $stmt = $pdo->prepare("SELECT * FROM departments WHERE slug = :slug");
    $stmt->execute([':slug' => $slug]);
    return $stmt->fetch() ?: null;
}

function getDoctors(PDO $pdo, ?int $departmentId = null, bool $activeOnly = true): array {
    $sql = "SELECT d.*, dep.name as department_name FROM doctors d LEFT JOIN departments dep ON d.department_id = dep.department_id";
    $conditions = [];
    $params = [];
    if ($activeOnly) {
        $conditions[] = "d.status = 1";
    }
    if ($departmentId) {
        $conditions[] = "d.department_id = :dept_id";
        $params[':dept_id'] = $departmentId;
    }
    if ($conditions) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }
    $sql .= " ORDER BY d.sort_order, d.name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getDoctor(PDO $pdo, int $id): ?array {
    $stmt = $pdo->prepare("SELECT d.*, dep.name as department_name FROM doctors d LEFT JOIN departments dep ON d.department_id = dep.department_id WHERE d.doctor_id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch() ?: null;
}

function getAppointments(PDO $pdo, ?string $status = null, ?string $search = null): array {
    $sql = "SELECT a.*, d.name as doctor_name, dep.name as department_name FROM appointments a LEFT JOIN doctors d ON a.doctor_id = d.doctor_id LEFT JOIN departments dep ON a.department_id = dep.department_id";
    $conditions = [];
    $params = [];
    if ($status) {
        $conditions[] = "a.status = :status";
        $params[':status'] = $status;
    }
    if ($search) {
        $conditions[] = "(a.patient_name ILIKE :search OR a.email ILIKE :search2 OR a.phone ILIKE :search3)";
        $params[':search'] = "%$search%";
        $params[':search2'] = "%$search%";
        $params[':search3'] = "%$search%";
    }
    if ($conditions) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }
    $sql .= " ORDER BY a.created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getPosts(PDO $pdo, bool $publishedOnly = false, int $limit = 0): array {
    $sql = "SELECT * FROM posts";
    if ($publishedOnly) $sql .= " WHERE status = 'published'";
    $sql .= " ORDER BY created_at DESC";
    if ($limit > 0) $sql .= " LIMIT $limit";
    return $pdo->query($sql)->fetchAll();
}

function getPost(PDO $pdo, int $id): ?array {
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE post_id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch() ?: null;
}

function getPostBySlug(PDO $pdo, string $slug): ?array {
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE slug = :slug AND status = 'published'");
    $stmt->execute([':slug' => $slug]);
    return $stmt->fetch() ?: null;
}

function getTestimonials(PDO $pdo, bool $activeOnly = true): array {
    $sql = "SELECT * FROM testimonials";
    if ($activeOnly) $sql .= " WHERE status = 1";
    $sql .= " ORDER BY created_at DESC";
    return $pdo->query($sql)->fetchAll();
}

function getCount(PDO $pdo, string $table): int {
    $allowed = ['doctors', 'departments', 'appointments', 'posts', 'testimonials', 'hero_slides', 'menus', 'pages'];
    if (!in_array($table, $allowed)) return 0;
    return (int)$pdo->query("SELECT COUNT(*) FROM $table")->fetchColumn();
}

function getMenus(PDO $pdo, bool $activeOnly = true): array {
    $sql = "SELECT * FROM menus";
    if ($activeOnly) $sql .= " WHERE status = 1";
    $sql .= " ORDER BY menu_order ASC, id ASC";
    try {
        return $pdo->query($sql)->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

function getPage(PDO $pdo, string $slug): ?array {
    try {
        $stmt = $pdo->prepare("SELECT * FROM pages WHERE page_slug = :slug");
        $stmt->execute([':slug' => $slug]);
        return $stmt->fetch() ?: null;
    } catch (Exception $e) {
        return null;
    }
}

function getHeroSlides(PDO $pdo, bool $activeOnly = false): array {
    $sql = "SELECT * FROM hero_slides";
    if ($activeOnly) $sql .= " WHERE status = 1";
    $sql .= " ORDER BY sort_order ASC, id ASC";
    return $pdo->query($sql)->fetchAll();
}

function getHeroSlide(PDO $pdo, int $id): ?array {
    $stmt = $pdo->prepare("SELECT * FROM hero_slides WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch() ?: null;
}

function uploadImage(array $file, string $dir = 'uploads'): ?string {
    $uploadDir = __DIR__ . '/../assets/' . $dir . '/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($file['type'], $allowed)) return null;
    if ($file['size'] > 5 * 1024 * 1024) return null;

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $ext;
    $filepath = $uploadDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return '/assets/' . $dir . '/' . $filename;
    }
    return null;
}

function formatDate(string $date): string {
    return date('M d, Y', strtotime($date));
}

function truncateText(string $text, int $length = 150): string {
    if (strlen($text) <= $length) return $text;
    return substr($text, 0, $length) . '...';
}
