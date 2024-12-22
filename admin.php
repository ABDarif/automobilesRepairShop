<?php
// admin.php
include 'config.php';

// Fetch all appointments
$query = "SELECT clients.id, clients.name AS client_name, clients.phone, clients.car_license, 
                 clients.appointment_date, mechanics.name AS mechanic_name
          FROM clients
          JOIN mechanics ON clients.mechanic_id = mechanics.id";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Automobiles Workshop</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <h1>Admin Panel</h1>
            <ul>
                <li><a href="index.php">User Panel</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Appointment List</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Phone</th>
                    <th>Car License</th>
                    <th>Appointment Date</th>
                    <th>Mechanic</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['client_name']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['car_license']) ?></td>
                        <td><?= htmlspecialchars($row['appointment_date']) ?></td>
                        <td><?= htmlspecialchars($row['mechanic_name']) ?></td>
                        <td>
                            <a href="update_appointment.php?id=<?= $row['id'] ?>">Edit</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>&copy; 2024 Car Workshop</p>
    </footer>
</body>
</html>
