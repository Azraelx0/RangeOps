<?php
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Search</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
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
        .search-form {
            margin: 20px 0;
        }
        input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .result {
            margin: 10px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
        }
        .error {
            color: red;
            background-color: #ffe6e6;
            padding: 10px;
            border-radius: 4px;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Product Search</h1>
        
        <div class="search-form">
            <form method="GET" action="search.php">
                <input type="text" name="search" placeholder="Search products..." 
                       value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <?php
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            
            $query = "SELECT * FROM products WHERE name LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%'";
            
            echo "<p><strong>Query:</strong> <code>" . htmlspecialchars($query) . "</code></p>";
            
            $result = mysqli_query($conn, $query);
            
            if ($result) {
                $num_rows = mysqli_num_rows($result);
                echo "<p>Found $num_rows result(s)</p>";
                
                if ($num_rows > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='result'>";
                        echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                        echo "<p><strong>Price:</strong> $" . htmlspecialchars($row['price']) . "</p>";
                        echo "<p><strong>Category:</strong> " . htmlspecialchars($row['category']) . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No products found.</p>";
                }
            } else {
                echo "<div class='error'>";
                echo "<strong>SQL Error:</strong> " . mysqli_error($conn);
                echo "</div>";
            }
        }
        ?>

        <a href="index.php" class="back-link">← Back to Home</a>
    </div>
</body>
</html>
