
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
    $address      = $_POST['address'];
    $email       = $_POST['email'];
    $gender    = $_POST['gender'];

    // Insert new user into the database
    $query = "INSERT INTO client (FirstName, LastName, PhoneNumber, Email, Address, Gender) 
    VALUES ('$firstname', '$lastname', '$phonenumber', '$email', '$address', '$gender')";

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
<link rel="stylesheet" href="cssfolder/Add_Client.css">

<!-- == Boxicons CSS == -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<title>Test</title>
</head>
<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="" alt="">
                </span>

                <div class="text header-text">
                    <span class="name"></span>
                    <span class="profession"></span>
                </div>
            </div>
                
            <i class='bx bx-menu toggle'></i>
        </header>

        <div class="menu-bar">

            <div class="menu">
              <!--  <li class="search-box">
                        
                </li>-->
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="Dashboard.php">
                            <i class='bx bx-home icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                </ul>

                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="Client.php">
                            <i class='bx bx-book-heart icon'></i>
                            <span class="text nav-text">Client</span>
                        </a>
                    </li>
                </ul>

                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="Accounts.php">
                            <i class='bx bx-group icon'></i>
                            <span class="text nav-text">Accounts</span>
                        </a>
                    </li>
                </ul>

                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-heart-square icon'></i>
                            <span class="text nav-text">Consultation</span>
                        </a>
                    </li>
                </ul>

                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bxs-report icon'></i>
                            <span class="text nav-text">Reports</span>
                        </a>
                    </li>
                </ul>
            </div>

        <div class="bottom-content">
            <li class="">
                <a href="">
                    <i class='bx bx-log-out icon'></i>
                    <span class="text nav-text">Logout</span>
                </a>
            </li>
<!--
            <li class="mode">
                
                <div class="moon-sun">
                    <i class='bx bx-sun icon sun'></i>
                    <i class='bx bx-moon icon moon'></i>
                </div>
               
                <span class="mode-text text">Dark Mode</span>

                <div class="toggle-switch">
                    
                </div>
            </li>
             -->
        </div>
    </nav>
    <section class="home">
            <div class="text">Add Client
            </div>
            <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a href="Dashboard.php">Home</a>
            <span>/</span>
            <a href="Client.php">Client</a>
            <span>/</span>
            <span>Add Client</span>
        </nav>

        <div class="container">
            <div class="text">Create Client</div>
            <form action="" method="POST">
                <!-- Section Header -->
                <div class="section-header">Client Personal Details</div>

                <!-- Form Group -->
                <div class="form-group">
                    <label for="firstname">First Name <span>*</span></label>
                    <input type="text" id="firstname" name="firstname" placeholder="Enter First Name" required>

                    <label for="lastname">Last Name <span>*</span></label>
                    <input type="text" id="lastname" name="lastname" placeholder="Enter Last Name" required>

                    <label for="phonenumber">Mobile Number <span>*</span></label>
                    <input type="text" id="phonenumber" name="phonenumber" placeholder="Enter Mobile Number" required>

                    <label for="address">Address <span>*</span></label>
                    <input type="text" id="address" name="address" placeholder="Address" required>

                    <label for="email">Email <span>*</span></label>
                    <input type="email" id="email" name="email" placeholder="Enter Email" required>

                    <label>Gender <span>*</span></label>
                    <div class="gender-options">
                        <input type="radio" id="male" name="gender" value="Male" required>
                        <label for="male">Male</label>

                        <input type="radio" id="female" name="gender" value="Female" required>
                        <label for="female">Female</label>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="Client.php" class="cancel-btn">Cancel</a>
                    <button type="submit" name="submit" class="submit-btn">Add Client</button>
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

    </div>
  <script src="scriptToggle.js"></script>
</body>
</html>

        