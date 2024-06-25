<?php
session_start();
if (empty($_SESSION['Username'])) {
    header('location:login.php');
    exit();
}

require_once('classes/database.php');
$con = new database();
$error = "";

if (isset($_POST['multisave'])) {
    // Getting the account information
    $username = $_POST['Username']; // Take from form instead of session if user can change it
    $password = $_POST['password']; // Ensure this is obtained from a form input securely

    // Getting the personal information
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $payment = $_POST['payment'];
    $sex = $_POST['sex'];

    // Getting the address information
    $floor = $_POST['floor'];
    $unitNo = $_POST['unitNo'];
    $numBed = $_POST['numBed'];
    $Amount = $_POST['Amount'];

    // Handle file upload
    $target_dir = "uploads/";
    $original_file_name = basename($_FILES["profile_picture"]["name"]);
    $new_file_name = $original_file_name;
    $target_file = $target_dir . $original_file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Check if file already exists and rename if necessary
    if (file_exists($target_file)) {
        $new_file_name = pathinfo($original_file_name, PATHINFO_FILENAME) . '_' . time() . '.' . $imageFileType;
        $target_file = $target_dir . $new_file_name;
    } else {
        $target_file = $target_dir . $original_file_name;
    }

    // Check if file is an actual image
    $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
    if ($check === false) {
        $error = "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["profile_picture"]["size"] > 500000) {
        $error = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $error = "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $profile_picture_path = 'uploads/' . $new_file_name;

            // Attempt to sign up the user
            $tenantID = $con->signupUser($firstname, $lastname, $payment, $sex, $username, $password, $profile_picture_path);
            if ($tenantID) {
                // Attempt to insert address
                if ($con->insertAddress($tenantID, $floor, $unitNo, $numBed, $Amount)) {
                    // Redirect to success page or homepage
                    header('location:index.php');
                    exit();
                } else {
                    $error = "Error occurred while inserting address. Please try again.";
                }
            } else {
                $error = "Error occurred while signing up. Please try again.";
            }
        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <title>Registration Form For Tenant</title>
    <style>
        body {
    background-color: #6699cc;
}
        .form-step {
            display: none;
        }

        .form-step-active {
            display: block;
        }
    </style>
</head>
<body>
<?php include('includes/navbar.php'); ?>
<div class="container custom-container rounded-3 shadow my-5 p-3 px-5">
    <h3 class="text-center mt-4">Registration Form For Tenant</h3>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form id="registration-form" method="post" action="" enctype="multipart/form-data" novalidate>
        <!-- Step 1 -->
        <div class="form-step form-step-active" id="step-1">
            <div class="card mt-4">
                <div class="card-header bg-info text-white">Account Information</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="Username">Username:</label>
                        <input type="text" class="form-control" name="Username" placeholder="Enter Username" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter password" required>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password:</label>
                        <input type="password" class="form-control" name="confirmPassword" placeholder="Re-enter your password" required>
                    </div>

                    <button type="button" id="nextButton" class="btn btn-primary mt-3" onclick="nextStep()">Next</button>
                </div>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="form-step" id="step-2">
            <div class="card mt-4">
                <div class="card-header bg-info text-white">Tenant Information</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="firstname">First Name:</label>
                        <input type="text" class="form-control" name="firstname" placeholder="Enter first name" required>
                    </div>

                    <div class="form-group">
                        <label for="lastname">Last Name:</label>
                        <input type="text" class="form-control" name="lastname" placeholder="Enter last name" required>
                    </div>

                    <div class="form-group">
                        <label for="payment">Payment:</label>
                        <select class="form-control" name="payment" required>
                            <option selected disabled value="">Select Payment</option>
                            <option>Installment</option>
                            <option>Fully Paid</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sex">Sex:</label>
                        <select class="form-control" name="sex" required>
                            <option selected disabled value="">Select Sex</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="profile_picture">Profile Picture of the Tenant:</label>
                        <input type="file" class="form-control" name="profile_picture" accept="image/*" required>
                    </div>

                    <button type="button" class="btn btn-secondary mt-3" onclick="prevStep()">Previous</button>
                    <button type="button" class="btn btn-primary mt-3" onclick="nextStep()">Next</button>
                </div>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="form-step" id="step-3">
            <div class="card mt-4">
                <div class="card-header bg-info text-white">Tenant Address Information</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="floor">Floor:</label>
                        <input type="text" class="form-control" name="floor" placeholder="Enter Floor" required>
                    </div>

                    <div class="form-group">
                        <label for="unitNo">Unit Number:</label>
                        <input type="text" class="form-control" name="unitNo" placeholder="Enter Unit Number" required>
                    </div>

                    <div class="form-group">
                        <label for="numBed">Number of Bed:</label>
                        <input type="text" class="form-control" name="numBed" placeholder="Enter Number of Beds" required>
                    </div>

                    <div class="form-group">
                        <label for="Amount">Amount:</label>
                        <input type="text" class="form-control" name="Amount" placeholder="Enter Amount" required>
                    </div>

                    <button type="button" class="btn btn-secondary mt-3" onclick="prevStep()">Previous</button>
                    <button type="submit" name="multisave" class="btn btn-primary mt-3">Sign Up</button>
                    <a class="btn btn-outline-danger mt-3" href="index.php">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="./bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentStep = 1;

        window.nextStep = function () {
            if (currentStep < 3) {
                document.getElementById('step-' + currentStep).classList.remove('form-step-active');
                currentStep++;
                document.getElementById('step-' + currentStep).classList.add('form-step-active');
            }
        }

        window.prevStep = function () {
            if (currentStep > 1) {
                document.getElementById('step-' + currentStep).classList.remove('form-step-active');
                currentStep--;
                document.getElementById('step-' + currentStep).classList.add('form-step-active');
            }
        }

        const form = document.querySelector('form');
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                form.classList.add('was-validated');
            }
        });
    });
</script>
</body>
</html>
