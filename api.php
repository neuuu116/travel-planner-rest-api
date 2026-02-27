<?php
/**
 * Travel Planner - Database API
 * Supports: GET, POST, PUT, DELETE
 */

require_once 'config.php';

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight (important for PUT/DELETE)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$conn = getDBConnection();
$method = $_SERVER['REQUEST_METHOD'];

/* =======================
   GET - READ
======================= */
if ($method === 'GET') {

    $action = $_GET['action'] ?? 'list';

    // List all packages
    if ($action === 'list') {

        $result = $conn->query("SELECT * FROM trip_packages ORDER BY id DESC");

        $packages = [];
        while ($row = $result->fetch_assoc()) {
            $packages[] = formatPackage($row);
        }

        echo json_encode(['packages' => $packages]);
        exit;
    }

    // Get single package
    if ($action === 'get') {

        $id = intval($_GET['id'] ?? 0);

        $stmt = $conn->prepare("SELECT * FROM trip_packages WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            echo json_encode(['package' => formatPackage($row)]);
        } else {
            echo json_encode(['error' => 'Package not found']);
        }

        $stmt->close();
        exit;
    }

    // Search
    if ($action === 'search') {

        $query = '%' . ($_GET['q'] ?? '') . '%';

        $stmt = $conn->prepare("SELECT * FROM trip_packages 
                                WHERE title LIKE ? OR destination LIKE ?
                                ORDER BY id DESC");
        $stmt->bind_param("ss", $query, $query);
        $stmt->execute();
        $result = $stmt->get_result();

        $packages = [];
        while ($row = $result->fetch_assoc()) {
            $packages[] = formatPackage($row);
        }

        echo json_encode(['packages' => $packages]);
        $stmt->close();
        exit;
    }

    echo json_encode(['error' => 'Unknown action']);
    exit;
}

/* =======================
   POST - CREATE
======================= */
if ($method === 'POST') {

    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || empty($data['title'])) {
        echo json_encode(['error' => 'Title is required']);
        exit;
    }

    $title = htmlspecialchars($data['title']);
    $destination = htmlspecialchars($data['destination'] ?? 'Unknown');
    $durationDays = intval($data['duration_days'] ?? 3);
    $price = floatval($data['price'] ?? 0);
    $rating = floatval($data['rating'] ?? 0);
    $highlights = json_encode($data['highlights'] ?? []);
    $imageUrl = htmlspecialchars($data['image_url'] ?? '');

    $stmt = $conn->prepare("INSERT INTO trip_packages 
        (title, destination, duration_days, price, rating, highlights, image_url)
        VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssidsss",
        $title,
        $destination,
        $durationDays,
        $price,
        $rating,
        $highlights,
        $imageUrl
    );

    if ($stmt->execute()) {

        echo json_encode([
            'success' => true,
            'message' => 'Package created successfully'
        ]);

    } else {
        echo json_encode(['error' => 'Failed to create package']);
    }

    $stmt->close();
    exit;
}

/* =======================
   PUT - UPDATE
======================= */
if ($method === 'PUT') {

    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['id']) || !is_numeric($data['id'])) {
        echo json_encode(['error' => 'Invalid ID']);
        exit;
    }

    $id = intval($data['id']);

    // Check existence
    $check = $conn->prepare("SELECT id FROM trip_packages WHERE id = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
        echo json_encode(['error' => 'Package not found']);
        $check->close();
        exit;
    }
    $check->close();

    $title = htmlspecialchars($data['title']);
    $destination = htmlspecialchars($data['destination']);
    $durationDays = intval($data['duration_days']);
    $price = floatval($data['price']);
    $rating = floatval($data['rating']);
    $highlights = json_encode($data['highlights']);
    $imageUrl = htmlspecialchars($data['image_url']);

    $stmt = $conn->prepare("UPDATE trip_packages 
        SET title=?, destination=?, duration_days=?, price=?, rating=?, highlights=?, image_url=? 
        WHERE id=?");

    $stmt->bind_param("ssidsssi",
        $title,
        $destination,
        $durationDays,
        $price,
        $rating,
        $highlights,
        $imageUrl,
        $id
    );

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Package updated successfully'
        ]);
    } else {
        echo json_encode(['error' => 'Failed to update package']);
    }

    $stmt->close();
    exit;
}

/* =======================
   DELETE
======================= */
if ($method === 'DELETE') {

    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['id']) || !is_numeric($data['id'])) {
        echo json_encode(['error' => 'Invalid ID']);
        exit;
    }

    $id = intval($data['id']);

    $stmt = $conn->prepare("DELETE FROM trip_packages WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Package deleted successfully'
        ]);
    } else {
        echo json_encode(['error' => 'Package not found']);
    }

    $stmt->close();
    exit;
}

/* =======================
   METHOD NOT ALLOWED
======================= */
echo json_encode(['error' => 'Method not allowed']);
$conn->close();

/* =======================
   FORMAT FUNCTION
======================= */
function formatPackage($row) {
    return [
        'id' => intval($row['id']),
        'title' => $row['title'],
        'destination' => $row['destination'],
        'duration_days' => intval($row['duration_days']),
        'price' => floatval($row['price']),
        'rating' => floatval($row['rating']),
        'highlights' => json_decode($row['highlights'], true),
        'image_url' => $row['image_url']
    ];
}
?>