<?php
// update_appointment.php
include 'config.php';

// Get client data
if (isset($_GET['id'])) {
    $client_id = $_GET['id'];

    $client_query = $conn->prepare("SELECT * FROM clients WHERE id = ?");
    $client_query->bind_param("i", $client_id);
    $client_query->execute();
    $client_result = $client_query->get_result();
    $client = $client_result->fetch_assoc();

    if (!$client) {
        echo "Client not found.";
        exit;
    }
}

// Update appointment data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment_date = $_POST['appointment_date'];
    $mechanic_id = $_POST['mechanic_id'];

    // Check if mechanic has available slots
    $slots_query = $conn->prepare("SELECT (4 - current_appointments) AS slots FROM mechanics WHERE id = ?");
    $slots_query->bind_param("i", $mechanic_id);
    $slots_query->execute();
    $slots_result = $slots_query->get_result();
    $slots_row = $slots_result->fetch_assoc();

    if ($slots_row['slots'] <= 0) {
        echo "Selected mechanic is fully booked.";
        exit;
    }

    // Update appointment
    $update_query = $conn->prepare("UPDATE clients SET appointment_date = ?, mechanic_id = ? WHERE id = ?");
    $update_query->bind_param("sii", $appointment_date, $mechanic_id, $client_id);
    $update_query->execute();

    // Adjust mechanics' current_appointments
    $old_mechanic_id = $client['mechanic_id'];
    if ($mechanic_id != $old_mechanic_id) {
        $decrement_old = $conn->prepare("UPDATE mechanics SET current_appointments = current_appointments - 1 WHERE id = ?");
        $decrement_old->bind_param("i", $old_mechanic_id);
        $decrement_old->execute();

        $increment_new = $conn->prepare("UPDATE mechanics SET current_appointments = current_appointments + 1 WHERE id = ?");
        $increment_new->bind_param("i", $mechanic_id);
        $increment_new->execute();
    }

    echo "Appointment updated successfully.";
    header("Location: admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Appointment | ARS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Update Appointment</h1>
    </header>
    <main>
        <form method="POST">
            <label>Appointment Date:</label>
            <input type="date" name="appointment_date" value="<?= htmlspecialchars($client['appointment_date']) ?>" required><br>

            <label>Select Mechanic:</label>
            <select name="mechanic_id" required>
                <?php
                $mechanic_query = $conn->query("SELECT id, name, (4 - current_appointments) AS slots FROM mechanics");
                while ($row = $mechanic_query->fetch_assoc()) {
                    $selected = ($row['id'] == $client['mechanic_id']) ? "selected" : "";
                    echo "<option value='{$row['id']}' $selected>{$row['name']} ({$row['slots']} slots left)</option>";
                }
                ?>
            </select><br>

            <button type="submit">Update</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Car Workshop</p>
    </footer>
</body>
</html>
