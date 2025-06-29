<?= $this->extend('index'); ?>
<?= $this->section('content'); ?>
<br><br>
<br><br>

<div class="container mt-4">
    <h3 class="mb-3">Library Payment Report</h3>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Card Tag</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Payment Method</th>
                <th>Payment Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($payments)) : ?>
                <?php foreach ($payments as $index => $row) : ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($row['username']) ?></td>
                        <td><?= esc($row['card_tag']) ?></td>
                        <td>$<?= esc($row['price']) ?></td>
                        <td><?= esc($row['desriptions']) ?></td>
                        <td><?= esc($row['payment_method']) ?></td>
                        <td><?= esc($row['payment_date']) ?></td>
                        <td><?= esc($row['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8" class="text-center">No payments found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>
