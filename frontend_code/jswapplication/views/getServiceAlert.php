<?php
require_once APPPATH . 'libraries/Connection.php'; // APPPATH = jswapplication/

$pdo = Connection::getConnection();

$sql = "
    SELECT 
        REPLACE(TRACKID, 'TORPEDO', 'TRACK') AS trackno,
        DATE_FORMAT(INSERT_DT, '%d-%m-%Y %H:%i:%s') AS TIME
    FROM TLC_GPS_LATEST
    GROUP BY INSERT_DT
    ORDER BY INSERT_DT DESC
    LIMIT 6
";

$rows = [];
try {
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll();
} catch (PDOException $e) {
    // In production, log this instead of echoing
    // log_message('error', 'DB error: '.$e->getMessage());
}
?>
<h4 class="text-danger">Empty Torpedo Signal Alerts:</h4>
<?php if (!empty($rows)): ?>
    <?php foreach ($rows as $row): ?>
        <p id="shake_text" style="width:100% !important;">
            <strong>Empty Torpedo Signal for TrackID :</strong>
            <span class="text-danger"><strong><?php echo htmlspecialchars($row['trackno'], ENT_QUOTES, 'UTF-8'); ?></strong></span>
            <strong> Ready to Go.. Time @ <?php echo htmlspecialchars($row['TIME'], ENT_QUOTES, 'UTF-8'); ?></strong>
        </p>
    <?php endforeach; ?>
<?php else: ?>
    <p id="shake_text" style="width:100% !important;"><strong>No recent torpedo signals.</strong></p>
<?php endif; ?>
