<?php
require('vendor/autoload.php'); // Include DOMPDF library

use Dompdf\Dompdf;

if (isset($_GET['booking_id']) && isset($_GET['menu_id'])) {
    $booking_id = $_GET['booking_id'];
    $menu_id = $_GET['menu_id'];

    // Database connection
    $dbconnect = mysqli_connect("localhost", "root", "", "caterease");

    if (!$dbconnect) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch booking details
    $query = "
        SELECT booking_id, total_price, advance_payment, event_date, csp_id
        FROM bookings
        WHERE booking_id = '$booking_id'";
    
    $result = mysqli_query($dbconnect, $query);
    
    if (!$result || mysqli_num_rows($result) == 0) {
        die('Booking not found!');
    }
    
    $booking_data = mysqli_fetch_assoc($result);

    // Fetch CSP details using the csp_id from the previous query
    $csp_id = $booking_data['csp_id'];
    $csp_query = "SELECT csp_name FROM csp_table WHERE csp_id = '$csp_id'";
    $csp_result = mysqli_query($dbconnect, $csp_query);
    
    if (!$csp_result || mysqli_num_rows($csp_result) == 0) {
        die('CSP not found!');
    }
    
    $csp_data = mysqli_fetch_assoc($csp_result);

    // Fetch CSP contact information from the user table
    $user_query = "SELECT phno, email FROM user WHERE userid = (SELECT userid FROM csp_table WHERE csp_id = '$csp_id')";
    $user_result = mysqli_query($dbconnect, $user_query);
    
    if (!$user_result || mysqli_num_rows($user_result) == 0) {
        die('CSP contact information not found!');
    }
    
    $user_data = mysqli_fetch_assoc($user_result);

    // Fetch ordered menu items for this booking
    // Fetch ordered menu items for this booking
$menu_query = "
SELECT m.menu_name, m.price, b.quantity 
FROM menu m 
JOIN bookings b ON m.menu_id = b.menu_id 
WHERE b.booking_id = '$booking_id' AND m.menu_id = '$menu_id'";

$menu_result = mysqli_query($dbconnect, $menu_query);

if (!$menu_result || mysqli_num_rows($menu_result) == 0) {
die('Menu items not found!');
}

// Create the HTML content for the PDF
$html = "
<h1 style='text-align:center;'>CaterEase Invoice</h1>
<h3>Catering Service Provider:</h3>
<p>CSP Name: {$csp_data['csp_name']}</p>
<p>Contact: {$user_data['phno']}</p>
<p>Email: {$user_data['email']}</p>
<br>
<h3>Booking Details:</h3>
<p>Booking ID: {$booking_data['booking_id']}</p>
<p>Event Date: {$booking_data['event_date']}</p>
<br>
<h3>Ordered Menu Items:</h3>
<table border='1' cellpadding='5' cellspacing='0' width='100%'>
<tr>
    <th>Menu Item</th>
    <th>Quantity</th>
    <th>Price</th>
</tr>";

$total = 0;
$grand_total_quantity = 0; // To keep track of total quantity

while ($menu_row = mysqli_fetch_assoc($menu_result)) {
// Calculate total quantity for service charge calculation
$grand_total_quantity += $menu_row['quantity'];

// Calculate the item price (we can leave out the service charge here)
$item_total = $menu_row['price'] * $menu_row['quantity'];

$html .= "
<tr>
    <td>{$menu_row['menu_name']}</td>
    <td style='text-align:center;'>{$menu_row['quantity']}</td>
    <td style='text-align:right;'>" . number_format($item_total, 2) . "</td>
</tr>";

$total += $item_total;
}

// Service charge logic based on total quantity
if ($grand_total_quantity > 1000) {
$service_charge = 6000;
} elseif ($grand_total_quantity > 500) {
$service_charge = 3000;
} else {
$service_charge = 1000;
}

$total += $service_charge;

$paid_amount = $booking_data['advance_payment'];
$balance = $total - $paid_amount;

$html .= "
</table>
<br>
<h3>Payment Summary:</h3>
<p>Service Charge: " . number_format($service_charge, 2) . "</p>
<p>Total Amount: " . number_format($total, 2) . "</p>
<p>Paid Amount: " . number_format($paid_amount, 2) . "</p>
<p>Balance to be Paid: " . number_format($balance, 2) . "</p>";

// Initialize DOMPDF and generate the PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("invoice_{$booking_data['booking_id']}.pdf", array("Attachment" => false));
} else {
    die('Booking ID or Menu ID not set.');
}
?>
