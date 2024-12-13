<?php
require 'cfg/dbconnect.php';
session_start();

// Initialize variables
$pet_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : null;
$client_id = isset($_GET['client_id']) ? htmlspecialchars($_GET['client_id']) : null;

// Check if 'client_id' is set in the query string
if (isset($_GET['client_id'])) {
    $clientID = $_GET['client_id'];

    // Fetch client details
    $clientSql = "SELECT * FROM client WHERE ClientID = ?";
    $clientStmt = $conn->prepare($clientSql);
    $clientStmt->bind_param("i", $clientID);
    $clientStmt->execute();
    $clientResult = $clientStmt->get_result();
    $client = $clientResult->fetch_assoc();

       // Fetch the selected pet's details if 'pet_id' is provided
       if ($pet_id) {
        $petSql = "SELECT * FROM Pets WHERE pet_id = ?";
        $petStmt = $conn->prepare($petSql);
        $petStmt->bind_param("i", $pet_id);
        $petStmt->execute();
        $petResult = $petStmt->get_result();
        $pet = $petResult->fetch_assoc();

        if (!$pet) {
            die("Pet not found.");
        }
    } else {
        die("Pet ID is not provided.");
    }

    // Fetch medical records for the specific pet
    $medicalSql = "SELECT * FROM medical_records WHERE pet_id = ?";
    $medicalStmt = $conn->prepare($medicalSql);
    $medicalStmt->bind_param("i", $pet_id);
    $medicalStmt->execute();
    $medicalResult = $medicalStmt->get_result();
} else {
    die("Client ID is not provided.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- == CSS == -->
<link rel="stylesheet" href="cssfolder/Medical_records.css">

<!-- == Boxicons CSS == -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<title>Client List</title>
</head>
    <!-- Sidebar -->
    <?php include 'Sidebar.php';?>
<body>
    <section class="home">
        <div class="text">Pet Medical Records</div>
        <nav class="breadcrumb">
            <a href="Dashboard.php">Home</a>
            <span>/</span>
            <a href="Client.php">Client</a>
            <span>/</span>
            <a href="Client_details.php?client_id=<?= htmlspecialchars($client_id) ?>">Client Details</a>
            <span>/</span>
            <span>Pet Medical Records</span>
        </nav>
         <div class="container">
         <h1>Medical Records for 
    <?php 
    // Check if the pet data is available and display the pet's name
    if (isset($pet['name'])) {
        echo htmlspecialchars($pet['name']);  // Display pet name
    } else {
        echo "Unknown Pet";  // Fallback if name is missing
    }
    ?>
    </h1>
    
    <?php if (isset($medicalResult) && $medicalResult->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Condition</th>
                <th>Diagnosis</th>
                <th>Symptoms</th>
                <th>Treatment</th>
                <th>Next Visit Date</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $medicalResult->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['date']); ?></td>
                <td><?php echo htmlspecialchars($row['condition']); ?></td>
                <td><?php echo htmlspecialchars($row['diagnosis']); ?></td>
                <td><?php echo htmlspecialchars($row['symptoms']); ?></td>
                <td><?php echo htmlspecialchars($row['treatment']); ?></td>
                <td><?php echo htmlspecialchars($row['next_visit_date']); ?></td>
                <td><?php echo htmlspecialchars($row['notes']); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>No medical records found for this pet.</p>
    <?php endif; ?>
    </section>
    </body>
    <script src="scriptToggle.js"></script>
</html>