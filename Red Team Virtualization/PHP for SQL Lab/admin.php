# This file is an intentionally weak page allowing for injections to see user data
<?php
session_start();
include 'db_connect.php';

$is_logged_in = isset($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .filter-form {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .filter-form input,
        .filter-form select {
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .error {
            color: red;
            background-color: #ffe6e6;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        }
        .debug {
            margin-top: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: monospace;
            font-size: 12px;
            word-break: break-all;
        }
        .back-link {
            color: #007bff;
            text-decoration: none;
        }
        .user-info {
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Admin Panel - User Management</h1>
            <div class="user-info">
                <?php if ($is_logged_in): ?>
                    Logged in as: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
                    (<?php echo htmlspecialchars($_SESSION['role'] ?? 'user'); ?>)
                <?php else: ?>
                    Not logged in
                <?php endif; ?>
            </div>
        </div>

        <div class="filter-form">
            <form method="GET" action="admin.php">
                <label>Filter by Role:</label>
                <select name="role">
                    <option value="">All Roles</option>
                    <option value="admin" <?php echo (isset($_GET['role']) && $_GET['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="user" <?php echo (isset($_GET['role']) && $_GET['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                </select>
                
                <label>Search ID:</label>
                <input type="text" name="id" placeholder="User ID" 
                       value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">
                
                <label>Order by:</label>
                <select name="order">
                    <option value="id">ID</option>
                    <option value="username" <?php echo (isset($_GET['order']) && $_GET['order'] == 'username') ? 'selected' : ''; ?>>Username</option>
                    <option value="created_at" <?php echo (isset($_GET['order']) && $_GET['order'] == 'created_at') ? 'selected' : ''; ?>>Date Created</option>
                </select>
                
                <button type="submit">Apply Filters</button>
                <a href="admin.php"><button type="button">Reset</button></a>
            </form>
        </div>

        <?php
        $query = "SELECT * FROM users WHERE 1=1";
        
        if (isset($_GET['role']) && $_GET['role'] != '') {
            $role = $_GET['role'];
            $query .= " AND role = '$role'";
        }
        
        if (isset($_GET['id']) && $_GET['id'] != '') {
            $id = $_GET['id'];
            $query .= " AND id = $id";
        }
        
        if (isset($_GET['order']) && $_GET['order'] != '') {
            $order = $_GET['order'];
            $query .= " ORDER BY $order";
        } else {
            $query .= " ORDER BY id";
        }
        
        echo "<div class='debug'><strong>SQL Query:</strong><br>" . htmlspecialchars($query) . "</div>";
        
        $result = mysqli_query($conn, $query);
        
        if ($result) {
            $num_rows = mysqli_num_rows($result);
            echo "<p>Total users found: <strong>$num_rows</strong></p>";
            
            if ($num_rows > 0) {
                echo "<table>";
                echo "<tr><th>ID</th><th>Username</th><th>Password</th><th>Email</th><th>Role</th><th>Created At</th></tr>";
                
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['password']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                    echo "</tr>";
                }
                
                echo "</table>";
            } else {
                echo "<p>No users found matching the criteria.</p>";
            }
        } else {
            echo "<div class='error'><strong>SQL Error:</strong> " . mysqli_error($conn) . "</div>";
        }
        ?>

        <div style="margin-top: 20px;">
            <a href="index.php" class="back-link">← Back to Home</a>
        </div>
    </div>
</body>
</html>
