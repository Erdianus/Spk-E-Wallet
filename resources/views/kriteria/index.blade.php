@extends('layouts.app')
@section('title')
    SPK-E-Wallet | Data Kriteria
@endsection
@section('content')
    <div class="card">
        <div class="card-header py-3">
            <h6>Data Kriteria E-Wallet</h6>
        </div>
        <div class="table-responsive p-2">
            {{-- <div class="d-flex justify-content-end">
                <button type="button" data-bs-toggle="modal" data-bs-target="#createForm" class="btn btn-primary my-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                    </svg>
                    Tambah
                </button>
            </div> --}}
            <table class="table text-start mb-0" id="table">
                <thead>
                    <tr>
                        <th scope="col" class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">No
                        </th>
                        <th scope="col" class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Kode
                        </th>
                        <th scope="col" class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Nama
                        </th>
                        <th scope="col" class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Jenis
                            Kriteria
                        </th>
                        <th scope="col" class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                            Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kriteria as $item)
                        <tr>
                            <td class="text-start">{{ $loop->iteration }}</td>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->type_of_criteria }}</td>
                            <td>
                                <button id="buttonEdit" type="button" data-bs-toggle="modal" data-bs-target="#editForm"
                                    class="btn btn-warning" data-id="{{ $item->id }}" data-code="{{ $item->code }}"
                                    data-name="{{ $item->name }}" data-type="{{ $item->type_of_criteria }}">Edit</button>
                                {{-- <button id="button-delete-{{ $item->id }}"
                                    data-route="{{ route('kriteria.delete', $item->id) }}"
                                    onclick="delete_data({{ $item->id }})" type="button"
                                    class="btn btn-danger">Delete</button> --}}
                                <a href="{{ route('sub-kriteria.index', $item->id) }}" id="sub-kriteria" type="button"
                                    class="btn btn-success">Sub
                                    Kriteria</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('kriteria.modal')
@endsection

@section('javascript')
    <script>
        // --------------------Create Alternatif-----------------------
        $('#formCreate').on('submit', function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            var url = $(this).attr('action');
            //console.log(url);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: url,
                dataType: 'JSON',
                data: data,
                success: function(res) {
                    if (res.status == true) {
                        Swal.fire({
                            title: "Created!",
                            text: "Kriteria has been created.",
                            icon: "success"
                        }).then((result) => {
                            $('#createForm').modal('hide');
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Sepertinya ada kesalahan..."
                        });
                    }
                }
            })
        });

        //--------------------------Update User------------------------------------
        $(document).on('click', '#buttonEdit', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#id').val(id);
            $('#updateName').val($(this).data('name'));
            $('#updateCode').val($(this).data('code'));
            $('#updateType').val($(this).data('type'));
        })

        $('#updateKriteria').on('submit', function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            var url = $(this).attr('action');
            var method = $(this).attr('method');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'PUT',
                url: url,
                data: data,
                dataType: 'JSON',
                success: function(res) {
                    if (res.status == true) {
                        Swal.fire({
                            title: "Updated!",
                            text: "Criteria has been Updated.",
                            icon: "success"
                        }).then((result) => {
                            window.location.reload();
                        });
                    } else {
                        $('#editForm').modal('hide');
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Kode Sudah digunakan..."
                        })
                    }
                },
                error: function(res) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Sepertinya ada kesalahan...."
                    })
                }
            })
        });

        function delete_data(id) {
            var formUrl = $('#button-delete-' + id).data('route');
            Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            url: formUrl,
                            dataType: 'JSON',
                            data: {
                                '_token': '{{ csrf_token() }}',
                                '_method': 'DELETE',
                                'id': id,
                            },
                            success: function(res) {
                                if (res.status == true) {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Criteria has been deleted.",
                                        icon: "success"
                                    }).then((result) => {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        text: "Something went wrong!",
                                    });
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Something went wrong!",
                                });
                            }
                        });
                    }
                });
        }
    </script>
@endsection
