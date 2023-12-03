<!-- BEGIN: JS Assets-->
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script src="{{ asset('dist/js/app.js')}}"></script>
<script src="{{ asset('dist/js/iziToast.min.js') }}"></script>
{{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script> --}}

<!-- Sweet Alerts 2 -->
<script src="/vendor/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

{{-- Alert Logout --}}
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.show-alert-logout-box', function(event){
            var form =  $(this).closest("form");

            event.preventDefault();
            Swal.fire({
                title: "Are you sure to logout?",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "No, cancel!",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes!"
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                title: "Logout !",
                icon: "success"
                });
                form.submit();
            }
            });
        });
    });
</script>

{{-- Alert Delete : tinggal tambahkan class show-alert-delete-box di button nya! --}}
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.show-alert-delete-box', function(event){
            var form =  $(this).closest("form");

            event.preventDefault();
            Swal.fire({
                title: "Are you sure you want to delete this record?",
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                title: "Deleted!",
                text: "Your data has been deleted.",
                icon: "success"
                });
                form.submit();
            }
            });
        });
    });
</script>
<!-- END: JS Assets-->

{{-- Input Number Format Rupiah --}}
<script>
     var dengan_rupiah = document.getElementById('rupiah');
    dengan_rupiah.addEventListener('keyup', function(e)
    {
        dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
    });

    /* Fungsi */
    function formatRupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>
