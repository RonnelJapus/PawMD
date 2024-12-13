<?php
// Include the database connection file
include 'cfg/dbconnect.php';

// Start the session to access session variables
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Set up pagination variables
$reportsPerPage = 5;  // Limit to 5 reports per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $reportsPerPage; // The offset for SQL query

// Calculate the total number of reports
$totalReportsResult = $conn->query("SELECT COUNT(*) AS total FROM medical_records");
$totalReports = $totalReportsResult->fetch_assoc()['total'];
$totalPages = ceil($totalReports / $reportsPerPage); // Total pages

// Fetch reports from the database with LIMIT and OFFSET
$reportListResult = $conn->query("
    SELECT 
        CONCAT(c.FirstName, ' ', c.LastName) AS OwnerName,
        p.name AS PetName,
        c.Address AS OwnerAddress,
        c.PhoneNumber AS PhoneNumber,
        c.Email AS Email,
        m.date AS ConsultationDate,
        CONCAT(u.user_firstname, ' ', u.user_lastname) AS VetName
    FROM 
        client AS c
    JOIN 
        pets AS p ON c.ClientID = p.client_id
    JOIN 
        medical_records AS m ON p.pet_id = m.pet_id
    LEFT JOIN 
        users AS u ON u.user_type = 'vet'  -- Use user_type to identify the vet
    ORDER BY 
        m.date DESC
    LIMIT $reportsPerPage OFFSET $offset;
");

// Check if the query was successful
if (!$reportListResult) {
    die("Error retrieving data: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cssfolder/Reports.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Reports</title>
</head>
<body>

<!-- Include Sidebar -->
<?php include 'Sidebar.php'; ?>

<section class="home">
    <div class="text">Reports</div>

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="Dashboard.php">Home</a>
        <span>/</span>
        <span>Reports</span>
    </nav>

    <!-- Report List Container -->
    <div class="container">
        <div class="header">
            <div class="text">Pet Reports</div>
        </div>

        <div class="controls">
            <div class="search">
                <label>Search:
                    <input type="text" id="searchInput" placeholder="Search...">
                </label>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Pet Name</th>
                    <th>Address</th>
                    <th>Contact Info</th>
                    <th>Date</th>
                    <th>Veterinarian</th>
                </tr>
            </thead>
            <tbody id="reportTable">
                <?php if ($reportListResult->num_rows > 0): ?>
                    <?php while ($row = $reportListResult->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['OwnerName']) ?></td>
                            <td><?= htmlspecialchars($row['PetName']) ?></td>
                            <td><?= htmlspecialchars($row['OwnerAddress']) ?></td>
                            <td><?= htmlspecialchars($row['PhoneNumber']) ?><br><?= htmlspecialchars($row['Email']) ?></td>
                            <td><?= htmlspecialchars($row['ConsultationDate']) ?></td>
                            <td><?= htmlspecialchars($row['VetName']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No reports found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <span>Showing Page <?= $page ?> of <?= $totalPages ?></span>
            <div class="pagination-buttons">
                <!-- Previous button -->
                <a href="?page=<?= $page > 1 ? $page - 1 : 1 ?>"><button <?= $page <= 1 ? 'disabled' : '' ?>>Previous</button></a>

                <!-- Current page button -->
                <button class="active"><?= $page ?></button>

                <!-- Next button -->
                <a href="?page=<?= $page < $totalPages ? $page + 1 : $totalPages ?>"><button <?= $page >= $totalPages ? 'disabled' : '' ?>>Next</button></a>
            </div>
        </div>
    </div>
</section>

<script>
    // JavaScript for filtering/searching the table
    document.getElementById("searchInput").addEventListener("keyup", function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll("#reportTable tr");
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>

<script src="scriptToggle.js"></script>
</body>
</html>
