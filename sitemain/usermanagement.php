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
if (isset($_POST['change_admin'])) {
    // Handle form submission to change the user's admin state
    $username = $_POST['username'];
    $newAdmin = isset($_POST['admin']) ? $_POST['admin'] : 0;
    $sql = "UPDATE accounts SET Admin = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $Admin, $username);

    if ($stmt->execute()) {
        echo "Admin state changed successfully for user: $username";
    } else {
        echo "Error changing admin state for user: $username - " . $stmt->error;
    }
}

    } elseif (isset($_POST['change_admin'])) {
        // Handle form submission to change the user's admin state
        $username = $_POST['username'];
        $newAdmin = isset($_POST['new_admin']) ? 1 : 0;
        $sql = "UPDATE accounts SET admin = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $Admin, $username);

        if ($stmt->execute()) {
            echo "Admin state changed successfully for user: $username";
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
            echo "User account '$username' deleted successfully.";
        } else {
            echo "Error deleting user account: $username - " . $stmt->error;
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
    <title>Admin - User Management</title>
</head>
<body>
    <h1>User Management</h1>

    <!-- Create User Account Form -->
    <form method="post">
        <!-- ... -->
    </form>

    <!-- User List -->
    <h2>User List</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Admin</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['username']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>" . ($row['admin'] == 1 ? "true" : "false") . "</td>";

                echo "<td>
                        <form method='post'>
                            <input type='hidden' name='username' value='{$row['username']}'>
                            
                            <label for='new_admin'>Change Admin:</label>
                            <select name='new_admin' id='Admin'>
                                <option value='1'>True</option>
                                <option value='0'>False</option>
                            </select>
                            <input type='submit' name='change_admin' value='Change Admin'>
                            
                            <input type='submit' name='delete_user' value='Delete User'>
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
</html>
