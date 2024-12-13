<?php
require 'cfg/dbconnect.php'; // Include your database connection file
session_start();

// Check if the client is logged in
if (!isset($_SESSION['client_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

$client_id = $_SESSION['client_id']; // Get the logged-in client ID

// Initialize error message
$error_msg = '';

// Handle form submission for adding a pet
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $image = ''; // Default value for image

    // Handle the pet image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/Pet_pictures/';
        $image_name = basename($_FILES['image']['name']);
        $image_path = $upload_dir . $image_name;

        // Move the uploaded image to the target folder
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            $image = $image_name; // Store the image name in the database
        } else {
            $error_msg = 'Failed to upload image.';
        }
    }

    // Insert pet data into the database
    if (empty($error_msg)) {
        $query = "INSERT INTO pets (name, breed, age, sex, client_id, image) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssiiis", $name, $breed, $age, $sex, $client_id, $image);

        if ($stmt->execute()) {
            // Redirect to the profile page after successful pet addition
            header('Location: view_pet.php');
            exit();
        } else {
            $error_msg = 'Failed to add pet. Please try again.';
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Pet</title>
    <link rel="stylesheet" href="cssfolder/add-pet-client-ui.css"> <!-- Assuming you have a CSS file -->
</head>
<body>

<h1>Add a New Pet</h1>

<?php if ($error_msg): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error_msg); ?></p>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data">
    <label for="name">Pet Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="breed">Breed:</label>
    <input type="text" id="breed" name="breed"><br><br>

    <label for="age">Age:</label>
    <input type="number" id="age" name="age" required><br><br>

    <label for="sex">Sex:</label>
    <select id="sex" name="sex" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Unknown">Unknown</option>
    </select><br><br>

    <label for="image">Upload Image:</label>
    <div class="preview">
    <input type="file" id="image" name="image" accept="image/*">
    <img id="imagePreview" src="#" alt="Image Preview">
    </div>
    
    <footer>
            <div class="form-actions">
                <a href="view_pet.php?client_id=<?= htmlspecialchars($client_id) ?>" class="cancel-btn">Cancel</a>
                <button type="submit" class="submit-btn">Add Pet</button>
            </div>
            </footer>
</form>


</body>
<script>
    // JavaScript to handle image preview
    document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0]; // Get the selected file
        const preview = document.getElementById('imagePreview'); // Get the image preview element

        if (file) {
            const reader = new FileReader(); // Create a FileReader object

            reader.onload = function(e) {
                preview.src = e.target.result; // Set the preview source to the file's data URL
                preview.style.display = 'block'; // Show the preview
            };

            reader.readAsDataURL(file); // Read the file as a Data URL
        } else {
            preview.src = '#'; // Reset the preview source
            preview.style.display = 'none'; // Hide the preview if no file is selected
        }
    });
</script>
</html>
