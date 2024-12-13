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
$accountsPerPage = 5;  // Limit to 5 accounts per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $accountsPerPage; // The offset for SQL query

// Calculate the total number of accounts
$totalAccountsResult = $conn->query("SELECT COUNT(*) AS total FROM users");
$totalAccounts = $totalAccountsResult->fetch_assoc()['total'];
$totalPages = ceil($totalAccounts / $accountsPerPage); // Total pages

// Fetch accounts from the database with LIMIT and OFFSET
$userListResult = $conn->query("SELECT * FROM users LIMIT $accountsPerPage OFFSET $offset");

// Check if the query was successful
if (!$userListResult) {
    die("Error retrieving data: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cssfolder/Accounts.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Accounts</title>
</head>
<body>
<?php include 'Sidebar.php'; ?>

<section class="home">
    <div class="text">Accounts</div>

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="Dashboard.php">Home</a>
        <span>/</span>
        <span>Accounts</span>
    </nav>

    <!-- Account List Container -->
    <div class="container">
        <div class="header">
            <div class="text">List</div>
            <a class="add-button" href="Add_account.php">Add Account</a>
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
                    <th>User Type</th> <!-- Updated header to User Type -->
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTable">
                <?php if ($userListResult->num_rows > 0): ?>
                    <?php while ($row = $userListResult->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['user_firstname'] . ' ' . $row['user_lastname']) ?></td>
                            <td><?= htmlspecialchars($row['user_type']) ?></td> <!-- Updated to display user_type -->
                            <td><?= htmlspecialchars($row['contact_number']) ?></td>
                            <td><?= htmlspecialchars($row['user_email']) ?></td>
                            <td class="actions">
                                <a href="Edit_account.php?id=<?= $row['user_id'] ?>" class="edit"><i class='bx bx-pencil'></i></a>
                                <a href="#" class="delete" onclick="openDeleteModal(<?= $row['user_id'] ?>)"><i class='bx bx-trash'></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No accounts found.</td>
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

    <!-- Modal for Deletion Confirmation -->
    <div id="deleteModal" class="modal-wrapper" style="display: none;">
        <div class="modal">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this account?</p>
            <button class="confirm-btn" id="confirmDeleteBtn">Yes, Delete</button>
            <button class="cancel-btn" onclick="closeModal()">Cancel</button>
        </div>
    </div>
</section>

<script>
    let userIdToDelete = null;

    function openDeleteModal(userId) {
        userIdToDelete = userId; // Set the user ID to delete
        document.getElementById('deleteModal').style.display = "block"; // Show the modal
    }

    function closeModal() {
        document.getElementById('deleteModal').style.display = "none"; // Hide the modal
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (userIdToDelete) {
            window.location.href = "delete_account.php?id=" + userIdToDelete; // Redirect to delete the account
        }
    });

    // Close the modal if the user clicks anywhere outside of it
    window.onclick = function(event) {
        if (event.target == document.getElementById('deleteModal')) {
            closeModal();
        }
    };

    // JavaScript for filtering/searching the table
    document.getElementById("searchInput").addEventListener("keyup", function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll("#userTable tr");
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>

<script src="scriptToggle.js"></script>
</body>
</html>
