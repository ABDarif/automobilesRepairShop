<?php
// process_appointment.php
include 'config.php';

$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$car_license = $_POST['car_license'];
$car_engine = $_POST['car_engine'];
$appointment_date = $_POST['appointment_date'];
$mechanic_id = $_POST['mechanic_id'];

// Check if the client already has an appointment on the same date
$check_query = $conn->prepare("SELECT * FROM clients WHERE name = ?");
$check_query->execute([$name]);
$check_result = $check_query->get_result();
$check_query2 = $conn->prepare("SELECT * FROM clients WHERE appointment_date = ?");
$check_query2->execute([$appointment_date]);
$check_result2 = $check_query2->get_result();
if ($check_result->num_rows > 0 and $check_result2->num_rows > 0) {
    echo "You already have an appointment on this date.";
    exit;
}

// Check if mechanic has available slots
$slots_query = $conn->prepare("SELECT (4 - current_appointments) AS slots FROM Mechanics WHERE id = ?");
$slots_query->bind_param("i", $mechanic_id);
$slots_query->execute();
$slots_result = $slots_query->get_result();
$row = $slots_result->fetch_assoc();
if ($row['slots'] <= 0) {
    echo "Selected mechanic is fully booked.";
    exit;
}

// Add client and appointment to database
$client_query = $conn->prepare("INSERT INTO Clients (name, address, phone, car_license, car_engine, appointment_date, mechanic_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
$client_query->bind_param("sssssss", $name, $address, $phone, $car_license, $car_engine, $appointment_date, $mechanic_id);
$client_query->execute();
$client_id = $conn->insert_id;

$update_mechanic = $conn->prepare("UPDATE Mechanics SET current_appointments = current_appointments + 1 WHERE id = ?");
$update_mechanic->bind_param("i", $mechanic_id);
$update_mechanic->execute();

echo "Appointment successfully booked.";
?>