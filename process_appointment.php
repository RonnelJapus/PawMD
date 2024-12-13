<?php
require 'cfg/dbconnect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client_id = $_POST['client_id'];
    $pet_id = $_POST['pet'];
    $appointment_date = $_POST['date'];

    // Validate inputs
    if (empty($client_id) || empty($pet_id) || empty($appointment_date)) {
        echo "All fields are required.";
        exit();
    }

    // Insert appointment into database
    $query = "INSERT INTO appointments (ClientID, PetID, AppointmentDate) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iis", $client_id, $pet_id, $appointment_date);

    if ($stmt->execute()) {
        echo "<script>
            alert('Appointment booked successfully.');
            window.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Error: " . addslashes($stmt->error) . "');
            window.location.href = 'index.php';
        </script>";
    }
    

    $stmt->close();
    $conn->close();
}
?>
