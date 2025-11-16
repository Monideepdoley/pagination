<?php
include "config.php";

// Number of records per page
$limit = 5;

// Get current page number
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;

// Calculate offset
$offset = ($page - 1) * $limit;

// Fetch paginated records
$sql = "SELECT * FROM users LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>User List</h2>";

// Display records
while ($row = $result->fetch_assoc()) {
    echo $row['id']." - ".$row['name']." - ".$row['email']."<br>";
}

// Count total records
$total_sql = "SELECT COUNT(*) AS total FROM users";
$total_result = $conn->query($total_sql);
$total = $total_result->fetch_assoc()['total'];

// Calculate total pages
$total_pages = ceil($total / $limit);

echo "<br><div style='margin-top:10px;'>";

// Previous button
if ($page > 1) {
    echo "<a href='index.php?page=".($page-1)."'>Previous</a>  ";
}

// Page numbers
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='index.php?page=$i' style='margin:0 5px;'>$i</a>";
}

// Next button
if ($page < $total_pages) {
    echo "  <a href='index.php?page=".($page+1)."'>Next</a>";
}

echo "</div>";
?>
