<?php
require 'cfg/dbconnect.php';
session_start();

// Initialize a flag for the modal display
$showModal = false;

// Initialize variables
$pet_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : null;
$client_id = isset($_GET['client_id']) ? htmlspecialchars($_GET['client_id']) : null;

// Initialize names
$client_name = '';
$pet_name = '';

// Fetch client name
if ($client_id !== null) {
    $client_query = "SELECT FirstName, LastName FROM client WHERE ClientID = ?";
    $stmt = $conn->prepare($client_query);
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $client_name = htmlspecialchars($row['FirstName'] . ' ' . $row['LastName']);
    } else {
        echo "Client not found.<br>";
    }
}

// Fetch pet name
if ($pet_id !== null) {
    $pet_query = "SELECT name FROM pets WHERE pet_id = ?";
    $stmt = $conn->prepare($pet_query);
    $stmt->bind_param("i", $pet_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $pet_name = htmlspecialchars($row['name']);
    } else {
        echo "Pet not found.<br>";
    }
}

// Fetch veterinarians
$vets = [];
$vet_query = "SELECT user_id, user_firstname, user_lastname FROM users WHERE user_type = 'vet'";
$vet_result = $conn->query($vet_query);

if ($vet_result->num_rows > 0) {
    while ($row = $vet_result->fetch_assoc()) {
        $vets[] = [
            'id' => $row['user_id'],
            'name' => htmlspecialchars($row['user_firstname'] . ' ' . $row['user_lastname'])
        ];
    }
} else {
    echo "No veterinarians found.<br>";
}

// Handle form submission
if (isset($_POST['submit'])) {
    // Retrieve form data
    $vet_id = $_POST['vet_id'];
    $date = $_POST['date'];
    $condition = $_POST['condition'];
    $diagnosis = $_POST['diagnosis'];
    $symptoms = $_POST['symptoms'];
    $treatment = $_POST['treatment'];
    $next_visit_date = $_POST['next_visit_date'];
    $notes = $_POST['notes'];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO medical_records (pet_id, date, `condition`, diagnosis, symptoms, treatment, next_visit_date, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $pet_id, $date, $condition, $diagnosis, $symptoms, $treatment, $next_visit_date, $notes);

    // Execute the statement
    if ($stmt->execute()) {
        $showModal = true; // Set modal flag
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- == CSS == -->
<link rel="stylesheet" href="cssfolder/Pet_consultation.css">

<!-- == Boxicons CSS == -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<title>Test</title>
</head>
<body>
<?php include 'Sidebar.php';?>
    <section class="home">
            <div class="text">Consultation
            </div>
            <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a href="Dashboard.php">Home</a>
            <span>/</span>
            <a href="Client.php">Client</a>
            <span>/</span>
            <a href="Client_details.php?client_id=<?= htmlspecialchars($client_id) ?>">Client Details</a>
            <span>/</span>
            <span>Pet Consultation</span>
        </nav>

        <div class="container">
        <div class="text">Pet Consultation</div>
        <form action="#" method="POST">
        <div class="section-header">Consultation Details</div>
            <input type="hidden" name="pet_id" value="<?= htmlspecialchars($pet_id) ?>">
            <input type="hidden" name="client_id" value="<?= htmlspecialchars($client_id) ?>">


            <div class="form-group">
                <label for="vet">Choose Veterinarian:</label>
                <select id="vet" name="vet_id" required>
                    <option value="" disabled selected>Select a veterinarian</option>
                    <?php foreach ($vets as $vet): ?>
                        <option value="<?= $vet['id'] ?>"><?= $vet['name'] ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="client_name">Client Name:</label>
                <input type="text" id="client_name" name="client_name" value="<?= $client_name ?>" readonly>

                <label for="pet_name">Pet Name:</label>
                <input type="text" id="pet_name" name="pet_name" value="<?= $pet_name ?>" readonly>

                <label for="date">Date <span>*</span></label>
                <input type="date" id="date" name="date" required readonly>

                <label for="condition">Condition</label>
                <input type="text" id="condition" name="condition" placeholder="Enter Condition" required>

                <label for="diagnosis">Diagnosis</label>
                <input type="text" id="diagnosis" name="diagnosis" placeholder="Enter Diagnosis" required>

                <label for="symptoms">Symptoms</label>
                <textarea id="symptoms" name="symptoms" placeholder="Enter Symptoms" required></textarea>

                <label for="treatment">Treatment</label>
                <textarea id="treatment" name="treatment" placeholder="Enter Treatment" required></textarea>

                <label for="next_visit_date">Next Visit Date</label>
                <input type="date" id="next_visit_date" name="next_visit_date" required>

                <label for="notes">Notes</label>
                <textarea id="notes" name="notes" placeholder="Enter any additional notes"></textarea>
            </div>

            <div class="form-actions">
                <a href="Client_details.php?client_id=<?= htmlspecialchars($client_id) ?>" class="cancel-btn">Cancel</a>
                <button type="submit" name="submit" class="submit-btn">Add Record</button>
            </div>
        </form>
    </div>
    
    <!-- Modal -->
    <div class="modal-wrapper <?php echo $showModal ? 'active' : ''; ?>">
        <div class="modal">
            <h2>Success</h2>
            <p>Client has been added successfully!</p>
            <button onclick="closeModal()">Close</button>
        </div>
    </div>

    <script>
        function closeModal() {
            document.querySelector('.modal-wrapper').classList.remove('active');
        }
    </script>

<script>
  // Get today's date
  const today = new Date();

  // Format the date as YYYY-MM-DD
  const todayFormatted = today.toISOString().split('T')[0];

  // Set the value of the "date" input to today's date and make it readonly
  const dateInput = document.getElementById('date');
  dateInput.value = todayFormatted;

  // Set the max attribute for the "date" input to today's date
  dateInput.setAttribute('max', todayFormatted);

  // Set the min attribute for the "next_visit_date" input to tomorrow's date
  today.setDate(today.getDate() + 1);  // Set the date to tomorrow
  const tomorrowFormatted = today.toISOString().split('T')[0];
  document.getElementById('next_visit_date').setAttribute('min', tomorrowFormatted);
</script>

</section>
<script src="scriptToggle.js"></script>
</body>
</html>
