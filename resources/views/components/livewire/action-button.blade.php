<div class="flex gap-1">
    @if (!empty($edit))
    <a
      href="{{ $route.$id.$routeedit }}"
      type="button"
      class="button text-white bg-theme-9 inline shadow-md"
      title="Edit Data"
    >
      {{-- <span class="fas fa-edit"></span> --}}
      <i data-feather="edit-2" class=" w-4 h-4 font-bold"></i>
    </a>
    @endif

    @if (!empty($detail))
    <a
      href="{{ $route.$id }}"
      type="button"
      class="button text-white bg-theme-1 inline shadow-md"
      title="Detail Data"
    >
      {{-- <span class="fas fa-eye"></span> --}}
      <i data-feather="eye" class=" w-4 h-4 font-bold"></i>
    </a>
    @endif


    @if (!empty($delete))
    <form action="{{ $route.$id }}" id="form_nya{{ $id }}" class="d-inline" method="POST">
      @csrf
      @method('DELETE')
      <button
        type="button"
        id="deleteButton{{ $id }}"
        class="button text-white bg-theme-6 inline shadow-md delete_confirm"
        title="Delete Data"
      >
        {{-- <span class="fas fa-trash"></span> --}}
        <i data-feather="trash-2" class=" w-4 h-4 font-bold"></i>
      </button>
    </form>

    <script>
      var id = @json($id);

      button = document.getElementById('deleteButton'+id)
      button.addEventListener('click', function() {
          var form = document.getElementById('form_nya'+id)
          event.preventDefault();
          Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data yang anda hapus tidak dapat kembali lagi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iya, hapus!'
          }).then((result) => {
            if (result.isConfirmed) {
              form.submit();
              Swal.fire(
                'Berhasil!',
              'data berhasil dihapus.',
              'success'
            )
          }
        })
      });

    </script>
    @endif
</div>
