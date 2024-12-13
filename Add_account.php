<?php
require 'cfg/dbconnect.php';

session_start();

// Initialize a flag for the modal display
$showModal = false;

// Handle form submission to add a new user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname   = $_POST['firstname'];
    $lastname    = $_POST['lastname'];
    $phonenumber = $_POST['phonenumber'];
    $gender      = $_POST['gender'];
    $email       = $_POST['email'];
    $password    = $_POST['password'];
    $User_role = $_POST['User_role'];

    // MD5 hashing of the password
    $hashed_password = md5($password);

    // Insert new user into the database
    $query = "INSERT INTO users (user_firstname, user_lastname, contact_number, user_gender, user_email, user_password, user_type)  
    VALUES ('$firstname', '$lastname', '$phonenumber', '$gender', '$email', '$hashed_password', '$User_role')";
    

    if ($conn->query($query)) {
        $showModal = true; // Set modal flag
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- == CSS == -->
<link rel="stylesheet" href="cssfolder/Add_account.css">

<!-- == Boxicons CSS == -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<title>Test</title>
</head>
<body>
<?php include 'Sidebar.php';?>
        <section class="home">
                <div class="text">Add Account</div>
                <!-- Breadcrumb -->
            <nav class="breadcrumb">
                <a href="Dashboard.php">Home</a>
                <span>/</span>
                <a href="Accounts.php">Accounts</a>
                <span>/</span>
                <span>Add Account</span>
            </nav>

                    <div class="container">
                    <div class="text">Create Account</div>
                <form action="" method="POST">
                    <div class="section-header">Personal Details</div>
                    <div class="form-group">
                        <label>First Name <span>*</span></label>
                        <input type="text" name="firstname" placeholder="Enter First Name" required>
                        <label>Last Name <span>*</span></label>
                        <input type="text" name="lastname" placeholder="Enter Last Name" required>
                        <label>Mobile Number <span>*</span></label>
                        <input type="text" name="phonenumber" placeholder="Enter Mobile Number" required>
                        <label>Gender <span>*</span></label>
                        <div class="gender-options">
                            <input type="radio" name="gender" value="Male" id="male" required>
                            <label for="male">Male</label>
                            <input type="radio" name="gender" value="Female" id="female" required>
                            <label for="female">Female</label>
                        </div>
                        <label>Email<span>*</span></label>
                        <input type="email" name="email" placeholder="Enter Email" required>
                        <label>Password<span>*</span></label>
                        <input type="password" name="password" placeholder="Enter Password" required>
                        <label for="User_role">User Role <span>*</span></label>
                        <select name="User_role" id="User_role" required>
                            <option value="Vet">Vet</option>
                            <option value="Staff">Staff</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <a href="Accounts.php" class="cancel-btn">Cancel</a>
                        <button type="submit" name="submit" class="submit-btn">Add Account</button>
                    </div>
                </form>
            </div>

            <!-- Modal -->
            <div class="modal-wrapper <?php echo $showModal ? 'active' : ''; ?>">
                <div class="modal">
                    <h2>Success</h2>
                    <p>User account has been added successfully!</p>
                    <button onclick="closeModal()">Close</button>
                </div>
            </div>

            <script>
                function closeModal() {
                    window.location.href = "Accounts.php"; // Change this to the appropriate previous page URL
                }
            </script>

            
        </section>
        <script src="scriptToggle.js"></script>
</body>
</html>
