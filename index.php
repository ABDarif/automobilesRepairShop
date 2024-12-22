<!-- User Panel: index.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User | Automobiles Workshop</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <div class="container">
                <h1>Car Workshop</h1>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <section id="appointment">
            <h1>Book an Appointment</h1>
            <form action="process_appointment.php" method="POST">
                <label>Name:</label><input type="text" name="name" required><br>
                <label>Address:</label><textarea name="address" required></textarea><br>
                <label>Phone:</label><input type="text" name="phone" required><br>
                <label>Car License:</label><input type="text" name="car_license" required><br>
                <label>Car Engine Number:</label><input type="text" name="car_engine" required><br>
                <label>Appointment Date:</label><input type="date" name="appointment_date" required><br>
                <label>Select Mechanic:</label>
                <select name="mechanic_id" required>
                    <?php
                    include('config.php');
                    $result = mysqli_query($conn, "Select id, name, max_appointments-current_appointments as slots from mechanics");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['name']} ({$row['slots']} slots left)</option>";
                    }
                    ?>
                </select><br>
                <button type="submit">Submit</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Car Workshop</p>
    </footer>
    <script src="scripts.js"></script>
</body>
</html>