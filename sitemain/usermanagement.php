<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    echo '<script>alert("You do not have permission to access this page.");</script>';
    echo '<script>window.location.href = "home.php";</script>';
    exit;
}

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}

$conn = new mysqli("localhost", "root", "", "phplogin");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create_user'])) {
        // Handle form submission to create a new user account
        // ...
    } elseif (isset($_POST['change_admin'])) {
        // Handle form submission to change the user's admin state
        $username = $_POST['username'];
        $newAdmin = isset($_POST['Admin']) ? $_POST['Admin'] : 0; // Verander 'admin' naar 'Admin' hier
        $sql = "UPDATE accounts SET Admin = ? WHERE username = ?"; // Verander 'admin' naar 'Admin' hier
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $newAdmin, $username); // Verander 'admin' naar 'newAdmin' hier

        if ($stmt->execute()) {
            echo '<script>alert("Admin succesvol aangepast voor gebruiker(s)");</script>';
        } else {
            echo "Error changing admin state for user: $username - " . $stmt->error;
        }
    } elseif (isset($_POST['delete_user'])) {
        // Handle form submission to delete a user account
        $username = $_POST['username'];
        $sql = "DELETE FROM accounts WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);

        if ($stmt->execute()) {
            echo '<script>alert("Gebruiker succesvol vewijderd");</script>';
        } else {
            echo '<script>alert("Error tijdens verwijderen gebruiker");</script>' . $stmt->error;
        }
    }
}


// Query to retrieve a list of all users
$sql = "SELECT username, email, admin FROM accounts";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mountain Goats - Admin</title>
    <link rel="stylesheet" type="text/css" href="styleadmin.css">

</head>
<body>
    <h1>Gebruikers beheer</h1>
    

    <!-- Create User Account Form -->
    <form method="post">
        <!-- ... -->
    </form>

    <!-- User List -->
    <table>
        <tr>
            <th>naam</th>
            <th>Email</th>
            <th>Admin</th>
            <th>Acties</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['username']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>" . ($row['admin'] == 1 ? "ja" : "nee") . "</td>";

                echo "<td>
                        <form method='post'>
                            <input type='hidden' name='username' value='{$row['username']}'>
                            
                            <label for='new_admin'>Admin:</label>
                            <select name='Admin' id='Admin'>
                                <option value='1'>Ja</option>
                                <option value='0'>Nee</option>
                            </select>   
                            <input type='submit' name='change_admin' value='Verander'>
                            
                            <input type='submit' name='delete_user' value='Verwijder gebruiker'>
                        </form>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No users found.</td></tr>";
        }
        ?>
    </table>
</body>