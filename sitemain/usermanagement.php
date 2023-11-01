<!DOCTYPE html>
<html>
<head>
    <title>Admin - User Management</title>
</head>
<body>
    <?php
    // Check if the user is an admin (You should have a better way to authenticate admins).
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
        $conn = new mysqli("localhost", "root", "", "phplogin");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle user deletion
        if (isset($_GET['delete_user'])) {
            $userToDelete = $_GET['delete_user'];
            $sql = "DELETE FROM user_accounts WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $userToDelete);

            if ($stmt->execute()) {
                echo "User account '$userToDelete' deleted successfully.";
            } else {
                echo "Error deleting user account: " . $stmt->error;
            }
        }

        // Query to retrieve a list of all users
        $sql = "SELECT username FROM user_accounts";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h1>User List</h1>";
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>{$row['username']} - <a href='admin.php?delete_user={$row['username']}'>Delete</a></li>";
            }
            echo "</ul>";
        } else {
            echo "No users found.";
        }

        $conn->close();
    } else {
        echo "You are not authorized to manage user accounts.";
    }
    ?>
</body>
</html>
