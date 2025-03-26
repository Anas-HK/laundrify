<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Feedback</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Give Feedback for Order #<?= $order->id ?></h2>

        <?php if ($order->feedback): ?>
            <div class="alert alert-danger">
                You have already submitted feedback for this order.
            </div>
        <?php else: ?>
            <form action="<?= route('order.feedback.submit', $order->id) ?>" method="POST">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="feedback" class="form-label">Your Feedback</label>
                    <textarea class="form-control" id="feedback" name="feedback" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit Feedback</button>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>
