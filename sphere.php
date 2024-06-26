<?php
require_once 'backend/db.php'; 

if (isset($_GET['sphere_id']) && is_numeric($_GET['sphere_id'])) {
    $sphere_id = intval($_GET['sphere_id']);

    $conn = connect_db();
    
    $stmt_bookings = $conn->prepare("SELECT check_in_date, check_in_time, check_out_time FROM bookings WHERE sphere_id = ?");
    $stmt_bookings->bind_param("i", $sphere_id);
    $stmt_bookings->execute();
    $result_bookings = $stmt_bookings->get_result();

    if ($result_bookings !== false && $result_bookings->num_rows > 0) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Время бронирования сферы</title>
        </head>
        <body>
            <h1>Время бронирования сферы</h1>
            <table>
                <tr>
                    <th>Дата заезда</th>
                    <th>Время заезда</th>
                    <th>Время выезда</th>
                </tr>
                <?php while ($row = $result_bookings->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['check_in_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['check_in_time']); ?></td>
                        <td><?php echo htmlspecialchars($row['check_out_time']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </body>
        </html>
        <?php
    } else {
        echo "Нет информации о бронировании для этой сферы";
    }

    $stmt_bookings->close();
    
    $conn->close();
} else {
    echo "Неверные параметры запроса";
}
?>
