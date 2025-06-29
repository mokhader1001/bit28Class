<?= $this->extend('index'); ?>
<?= $this->section('content'); ?>

<div class="container py-5">
    <h3 class="mb-4 text-primary"><i class="fas fa-tools me-2"></i> Damage Charges</h3>

    <div class="table-responsive">
        <table id="chargeTable" class="table table-bordered table-striped w-100">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Book Title</th>
                    <th>Author</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Photo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- SweetAlert2 + jQuery (if not included globally) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const base_url = "<?= base_url(); ?>";

    $(document).ready(function () {
        $('#chargeTable').DataTable({
            ajax: {
                url: base_url + 'charges/fetch_damage_charges',
                dataSrc: 'data'
            },
            columns: [
                null, null, null, null, null,
                null, null, null, null, null
            ]
        });
    });
$(document).on('click', '.btn-cancel', function () {
    const chargeId = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to delete this charge.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(base_url + 'charges/delete_damage_charge', { charge_id: chargeId }, function (response) {
                if (response.success) {
                    Swal.fire('Deleted!', response.message, 'success');
                    $('#chargeTable').DataTable().ajax.reload(null, false);
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }, 'json');
        }
    });
});

</script>

<?= $this->endSection(); ?>
