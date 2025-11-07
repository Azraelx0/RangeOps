<?php
echo "Starting test...<br>";

include 'db_connect.php';

echo "Connected successfully!<br>";

$result = mysqli_query($conn, "SELECT * FROM users");
echo "Query executed<br>";

while($row = mysqli_fetch_assoc($result)) {
    echo "User: " . $row['username'] . "<br>";
}

echo "Test complete!";
?>
```

Save (Ctrl+X, Y, Enter)

Now access from Kali:
```
http://[UBUNTU_IP]/test_db.php
