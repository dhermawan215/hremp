<script src="<?= $url ?>/vendor/adminkit/static/js/app.js"></script>
<script src="<?= $url ?>/public/jQuery-3.6.0/jquery-3.6.0.min.js"></script>
<script src="<?= $url ?>/public/datatable/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var url = 'http://localhost:3000/';
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {
        $('.logout').click(function(e) {
            const form = $(this).closest("form");
            const name = $(this).data("name");
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to exit?',
                text: "last chance to back out",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Good bye'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })

        });
        getLimit();

        function getLimit() {
            const csrf_token = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                type: "post",
                url: url + 'app/flexy-allowance/limit-statistik.php',
                data: {
                    _token: csrf_token,
                },
                dataType: "json",
                success: function(response) {
                    $('#balance-limit').html(response.saldo_sisa);
                    $('#limit-user').html(response.saldo_awal);
                }
            });
        }
    });
</script>