<?php
require 'cfg/dbconnect.php'; // Include your database connection file
session_start();

// Check if the client is logged in
if (!isset($_SESSION['client_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

$client_id = $_SESSION['client_id']; // Get the logged-in client ID

// Fetch the pets associated with the logged-in client
$query = "SELECT * FROM pets WHERE client_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $client_id); // Bind the client ID as parameter
$stmt->execute();
$result = $stmt->get_result();

$pets = []; // Initialize an empty array for pets

// Fetch all pets
while ($pet = $result->fetch_assoc()) {
    $pets[] = $pet;
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Pets</title>
    <link rel="stylesheet" href="cssfolder/view_pet.css"> <!-- Assuming you have a CSS file -->
</head>
<body>

<?php if (!empty($pets)): ?>
    <h1>Your Pets</h1>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Breed</th>
                <th>Age</th>
                <th>Sex</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pets as $pet): ?>
                <tr>
                    <td>
                        <?php 
                        // Check if the pet has an image
                        $pet_image = $pet['image'] ? "uploads/Pet_pictures/" . $pet['image'] : "uploads/Pet_pictures/dog-default.pfp.png"; 
                        ?>
                        <img src="<?php echo $pet_image; ?>" alt="Pet Image" style="width: 100px; height: auto;">
                    </td>
                    <td><?php echo htmlspecialchars($pet['name']); ?></td>
                    <td><?php echo htmlspecialchars($pet['breed']); ?></td>
                    <td><?php echo htmlspecialchars($pet['age']); ?> years</td>
                    <td><?php echo htmlspecialchars($pet['sex']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>You don't have any pets listed. <a href="add_pet.php">Add a pet</a></p>
<?php endif; ?>
<a href="add-pet-client-ui.php?client_id=<?= htmlspecialchars($client_id) ?>" class="cancel-btn">Add pet</a>
<a href="index.php?client_id=<?= htmlspecialchars($client_id) ?>" class="cancel-btn">Cancel</a>

</body>
</html>
