<?php
class database {
    function opencon() {
        return new PDO('mysql:host=localhost;dbname=loginmethods','root','');
    }

    function check($username, $password) {
        $con = $this->opencon();
        $stmt = $con->prepare("SELECT * FROM tenant WHERE Username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['Pass_word'])) {
            return $user;
        }
        return false;
    }

    function SignUp($username, $AccType, $password, $firstname, $lastname, $sex) {
        $con = $this->opencon();
        
        // Check if username already exists
        $query = $con->prepare("SELECT Username FROM tenant WHERE Username = ?");
        $query->execute([$username]);
        $existingUser = $query->fetch();
        
        if ($existingUser) {
            return false; // Username already exists, return false or handle accordingly
        }
        
        // Insert new user into the tenant table
        $stmt = $con->prepare("INSERT INTO tenant (Username, AccType, Pass_word, firstname, lastname, sex) VALUES (?, ?, ?, ?, ?, ?)");
        $result = $stmt->execute([$username, $AccType, password_hash($password, PASSWORD_DEFAULT), $firstname, $lastname, $sex]);
        
        if ($result) {
            return $con->lastInsertId(); // Return the auto-generated tenantID
        } else {
            return false; // Insertion failed
        }
    }

    function insertAddress($tenant_id, $floor, $unitNo, $numBed, $Amount) {
        $con = $this->opencon();
        return $con->prepare("INSERT INTO tenant_info (tenantID, tenant_add_floor, tenant_add_unitNo, tenant_add_numBed, tenant_Amount) VALUES (?, ?, ?, ?, ?)")
                   ->execute([$tenant_id, $floor, $unitNo, $numBed, $Amount]);
    }

    function view() {
        $con = $this->opencon();
        return $con->query("SELECT tenant.tenantID, tenant.firstname, tenant.lastname, tenant.payment, tenant.sex, tenant.Username, tenant.Pass_word, tenant.user_profile_picture,
                            tenant_info.tenant_add_floor,  tenant_info.tenant_add_unitNo, tenant_info.tenant_add_numBed,  tenant_info.tenant_Amount
                            FROM tenant INNER JOIN tenant_info ON tenant.tenantID = tenant_info.tenantID;")->fetchAll(PDO::FETCH_ASSOC);
    }

    function Delete($id) {
        try {
            $con = $this->opencon();
            $con->beginTransaction();
            $query = $con->prepare("DELETE FROM tenant_info WHERE tenantID = ?");
            $query->execute([$id]);
            $query2 = $con->prepare("DELETE FROM tenant WHERE tenantID = ?");
            $query2->execute([$id]);
            $con->commit();
            return true;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }

    function viewdata($id) {
        try {
            $con = $this->opencon();
            $query = $con->prepare("SELECT tenant.tenantID, tenant.firstname, tenant.lastname, tenant.payment, tenant.sex, tenant.Username, tenant.Pass_word, tenant_info.tenant_add_floor, tenant_info.tenant_add_unitNo, tenant_info.tenant_add_numBed, tenant_info.tenant_Amount
             FROM tenant INNER JOIN tenant_info ON tenant.tenantID = tenant_info.tenantID WHERE tenant.tenantID = ? ");
            $query->execute([$id]);
            return $query->fetch();
        } catch (PDOException $e) {
            return [];
        }
    }

    function updateUser($tenant_id, $firstname, $lastname, $payment, $sex, $username) {
        try {
            $con = $this->opencon();
            $con->beginTransaction();
            $query = $con->prepare("UPDATE tenant SET firstname = ?, lastname = ?, payment = ?, sex = ?, Username = ? WHERE tenantID = ?");
            $query->execute([$firstname, $lastname, $payment, $sex, $username, $tenant_id]);
            $con->commit();
            return true;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }

    function updateUserAddress($tenant_id, $floor, $unitNo, $numBed, $Amount) {
        try {
            $con = $this->opencon();
            $con->beginTransaction();
            $query = $con->prepare("UPDATE tenant_info SET tenant_add_floor = ?, tenant_add_unitNo = ?, tenant_add_numBed = ?, tenant_Amount = ? WHERE tenantID = ?");
            $query->execute([$floor, $unitNo, $numBed, $Amount, $tenant_id]);
            $con->commit();
            return true;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }
//loob ng update///
function signupUser($firstname, $lastname,  $sex, $payment, $username, $password, $profilePicture) {
    $con = $this->opencon();
    $stmt = $con->prepare("INSERT INTO tenant (firstname, lastname, payment, sex,  Username, Pass_word, user_profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$firstname, $lastname, $sex, $payment, $username, password_hash($password, PASSWORD_DEFAULT), $profilePicture]);
    return $stmt->rowCount() ? $con->lastInsertId() : false;
}


    function validateCurrentPassword($tenant_id, $currentPassword) {
        $con = $this->opencon();
        $query = $con->prepare("SELECT Pass_word FROM tenant WHERE tenantID = ?");
        $query->execute([$tenant_id]);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        return $user && password_verify($currentPassword, $user['Pass_word']);
    }

    function updatePassword($tenant_id, $hashedPassword) {
        try {
            $con = $this->opencon();
            $con->beginTransaction();
            $query = $con->prepare("UPDATE tenant SET Pass_word = ? WHERE tenantID = ?");
            $query->execute([$hashedPassword, $tenant_id]);
            $con->commit();
            return true;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }

    function updateUserProfilePicture($tenant_id, $profilePicturePath) {
        try {
            $con = $this->opencon();
            $con->beginTransaction();
            $query = $con->prepare("UPDATE tenant SET user_profile_picture = ? WHERE tenantID = ?");
            $query->execute([$profilePicturePath, $tenant_id]);
            $con->commit();
            return true;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }




    function fetchAllRoomsDetails() {
        // Database connection parameters
        $hostname = "your_hostname"; // Replace with your hostname
        $username = "your_username"; // Replace with your username
        $password = "your_password"; // Replace with your password
        $database = "your_database"; // Replace with your database name
        
        // Establish a connection to the database using PDO
        try {
            $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
        
        // Prepare SQL query to fetch all details from rooms table
        $sql = "SELECT * FROM rooms";
        $stmt = $pdo->prepare($sql);
        
        // Execute the query
        $stmt->execute();
        
        // Fetch all rows into an associative array
        $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Close connection
        $pdo = null;
        
        // Return fetched rows
        return $rooms;
    }
  
    




}
?>
