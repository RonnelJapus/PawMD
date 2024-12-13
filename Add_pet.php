<?php
require 'cfg/dbconnect.php'; // Include your database connection file
session_start();

// Initialize a flag for the modal display
$showModal = false;
// Check if the client ID is provided in the URL
$client_id = isset($_GET['client_id']) ? (int)$_GET['client_id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $name = trim($_POST['name']);
    $breed = trim($_POST['breed']);
    $age = (int)$_POST['age']; // Cast to integer for safety
    $sex = trim($_POST['sex']);
    $client_id = isset($_POST['client_id']) ? (int)$_POST['client_id'] : null; // Get client_id from POST

    // Handle file upload
    $image = null; // Initialize image variable
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/"; // Ensure this directory exists and is writable
        $target_file = $target_dir . basename($image);

        // Validate file type (you can add more types as needed)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['image']['type'], $allowed_types)) {
            die("Error: Only JPG, PNG, and GIF files are allowed.");
        }

        // Move the uploaded file to the target directory
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            die("Error: There was an error uploading your file.");
        }
    }

    // Validate client_id if provided
    if ($client_id !== null) {
        $stmt = $conn->prepare("SELECT * FROM client WHERE ClientID = ?");
        $stmt->bind_param("i", $client_id);
        $stmt->execute();
        $checkClient = $stmt->get_result();
        if ($checkClient->num_rows == 0) {
            die("Error: The specified client ID does not exist.");
        }
        $stmt->close();
    }

    // Prepare the SQL statement using prepared statements
    $sql = "INSERT INTO pets (name, breed, age, sex, client_id, image) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisss", $name, $breed, $age, $sex, $client_id, $target_file);

    if ($stmt->execute()) {
        $showModal = true; // Set modal flag
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- == CSS == -->
    <link rel="stylesheet" href="cssfolder/Add_pet.css">

    <!-- == Boxicons CSS == -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Add Pet</title>
</head>
<body>
<?php include 'Sidebar.php';?>
    
    <section class="home">
        <div class="text">Pet Information</div>
            <nav class="breadcrumb">
                <a href="Dashboard.php">Home</a>
                <span>/</span>
                <a href="Client.php">Client<span>/</span>
                <a href="Client_details.php?client_id=<?= htmlspecialchars($client_id) ?>">Client Details</a>
                <span>/</span>
                <span>Add Pet</span>
            </nav>
        
        <div class="container">
        <div class="text">Add Pet</div>
        <form action="" method="POST" enctype="multipart/form-data">
            <!-- Section Header -->
            <div class="section-header">Pet Details</div>

            <!-- Form Group -->
            <div class="form-group">
                <input type="hidden" name="client_id" value="<?= htmlspecialchars($client_id) ?>">
                <label for="name">Pet Name <span>*</span></label>
                <input type="text" id="name" name="name" placeholder="Enter Pet Name" required>

                <label for="breed">Breed <span>*</span></label>
                <input type="text" id="breed" name="breed" placeholder="Enter Breed" required>

                <label for="age">Age <span>*</span></label>
                <input type="number" id="age" name="age" placeholder="Enter Age" required>

                <label for="sex">Sex <span>*</span></label>
                <div class="gender-options">
                    <input type="radio" id="male" name="sex" value="Male" required>
                    <label for="male">Male</label>

                    <input type="radio" id="female" name="sex" value="Female" required>
                    <label for="female">Female</label>
                </div>

                <label for="image">Upload Image:</label>
                <div class="preview">
                <input type="file" id="image" name="image" accept="image/*">
                <img id="imagePreview" src="#" alt="Image Preview">
                </div>
                
            </div>

            <footer>
            <div class="form-actions">
                <a href="Client_details.php?client_id=<?= htmlspecialchars($client_id) ?>" class="cancel-btn">Cancel</a>
                <button type="submit" class="submit-btn">Add Pet</button>
            </div>
            </footer>
            <!-- Form Actions -->
        </form>
    </div>


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

    <!-- Modal -->
    <div class="modal-wrapper <?php echo $showModal ? 'active' : ''; ?>">
        <div class="modal">
            <h2>Success</h2>
            <p>Pet has been added successfully!</p>
            <button onclick="closeModal()">Close</button> 
        </div>
    </div>
    <script>
        function closeModal() {
            document.querySelector('.modal-wrapper').classList.remove('active');
            
        }
    </script>
   
</body>
<script src="scriptToggle.js"></script>
</html>

