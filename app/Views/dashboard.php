<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Webhook Message Log</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container py-4">
    <h3 class="mb-3">📋 Webhook Message Log</h3>
    <table class="table table-bordered table-striped table-sm">
        <thead class="table-dark">
            <tr>
                <th>Timestamp</th>
                <th>Message ID</th>
                <th>Status</th>
                <th>Phone</th>
                <th>Device</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($messages)): ?>
                <?php foreach ($messages as $msg): ?>
                    <tr>
                        <td><?= esc($msg->created_at) ?></td>
                        <td><?= esc($msg->message_id) ?></td>
                        <td><?= esc($msg->status) ?></td>
                        <td><?= esc($msg->phone) ?></td>
                        <td><?= esc($msg->device) ?></td>
                        <td><?= esc($msg->note) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" class="text-center text-muted">No data yet</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
