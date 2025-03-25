<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Order History</h2>
        
        <?php if ($orders->isEmpty()): ?>
            <p>You have no past orders.</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= $order->id ?></td>
                            <td><?= date('d M Y', strtotime($order->created_at)) ?></td>
                            <td><?= ucfirst($order->status) ?></td>
                            <td>$<?= number_format($order->total_price, 2) ?></td>
                            <td>
                                <a href="<?= route('order.show', $order->id) ?>" class="btn btn-primary btn-sm">View</a>
                                <a href="<?= route('order.feedback', $order->id) ?>" class="btn btn-warning btn-sm">Feedback</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
