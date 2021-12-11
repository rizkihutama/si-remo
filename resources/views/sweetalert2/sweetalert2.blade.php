<script>
  //* const for instance sweetalert2 with bootstrap
  const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
      confirmButton: 'btn btn-success btn-lg',
      cancelButton: 'btn btn-danger btn-lg mr-3'
  },
  buttonsStyling: false
  })

  //* function for alert delete data in dataTable
  function deleteAlert(e) {

    e.preventDefault();
    const form = $('.delete-form');

    swalWithBootstrapButtons.fire({
        title: 'Hapus?',
        text: "Data akan hilang selamanya!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus'
    }).then((result) => {

        if (result.isConfirmed) {
        form.submit();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire({
            title: 'Batal',
            text: "Data batal dihapus!",
            icon: 'error',
        });
        }

    });

    }
</script>
<script>

</script>

@if (Session::has('success'))
<script>
  $(document).ready(function() {
    swalWithBootstrapButtons.fire({
        icon: 'success',
        title: 'Berhasil',
        text: "{{ Session::get('success') }}",
      });
    });
</script>
@endif

@if (Session::has('info'))
<script>
  $(document).ready(function() {
    swalWithBootstrapButtons.fire({
        icon: 'info',
        title: 'Berhasil',
        text: "{{ Session::get('info') }}",
      });
    });
</script>
@endif

@if (Session::has('warning'))
<script>
  $(document).ready(function() {
    swalWithBootstrapButtons.fire({
        icon: 'warning',
        title: 'Penting',
        text: "{{ Session::get('warning') }}",
      });
    });
</script>
@endif

@if (Session::has('error'))
<script>
  $(document).ready(function() {
    swalWithBootstrapButtons.fire({
        icon: 'error',
        title: 'Error',
        text: "{{ Session::get('error') }}",
      });
    });
</script>
@endif