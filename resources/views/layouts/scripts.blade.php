<!-- BEGIN: JS Assets-->
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=["your-google-map-api"]&libraries=places"></script>
<script src="{{ asset('dist/js/app.js') }}"></script>
<script src="{{ asset('dist/js/iziToast.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
<!-- END: JS Assets-->
