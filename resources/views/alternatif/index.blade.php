@extends('layouts.app')
@section('title')
    SPK-E-Wallet | Data Alternatif
@endsection
@section('content')
    <div class="card">
        <div class="card-header py-3">
            <h6>Data Alternatif E-Wallet</h6>
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
                        <th scope="col" class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Nama
                        </th>
                        <th scope="col" class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                            Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alternatif as $item)
                        {{-- {{ dd($item->criteria) }} --}}
                        <tr>
                            <td class="text-start">{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <button id="buttonEdit" type="button" data-bs-toggle="modal" data-bs-target="#editForm"
                                    class="btn btn-warning" data-id="{{ $item->id }}"
                                    data-name="{{ $item->name }}">Edit</button>
                                {{-- <button id="button-delete-{{ $item->id }}"
                                    data-route="{{ route('alternatif.delete', $item->id) }}"
                                    onclick="delete_data({{ $item->id }})" type="button"
                                    class="btn btn-danger">Delete</button> --}}
                                @if ($item->criteria()->exists())
                                    <button id="buttonUpdateData" type="button" data-bs-toggle="modal"
                                        data-bs-target="#updateDataForm"
                                        @foreach ($item->criteria as $data)
                                            {{ 'data-' . $data->code . '=' . $data->criteria_value->value }} @endforeach
                                        data-id="{{ $item->id }}" class="btn btn-success">
                                        Update Data
                                    </button>
                                @else
                                    <button id="buttonInputData" type="button" data-bs-toggle="modal"
                                        data-bs-target="#inputDataForm" class="btn btn-secondary"
                                        data-id="{{ $item->id }}">Input Data</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('alternatif.modal')
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
                            text: "Alternative has been created.",
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

        //--------------------------Update Alternatif------------------------------------
        $(document).on('click', '#buttonEdit', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var updateName = $(this).data('name');
            $('#updateName').val(updateName);
            $('#id').val(id);
        })

        $('#updateAlternatif').on('submit', function(e) {
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
                    var name = res.message.name ? res.message.name : '';
                    if (res.status == true) {
                        Swal.fire({
                            title: "Updated!",
                            text: "Alternative has been Updated.",
                            icon: "success"
                        }).then((result) => {
                            $('#createForm').modal('hide');
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Sepertinya ada kesalahan...."
                        })
                    }
                }
            })
        });

        // -----------------------------Input Data Alternatif-------------------------
        $(document).on('click', '#buttonInputData', function(e) {
            e.preventDefault();
            var alternatif = $(this).data('id');
            var routeUrl = "{{ route('alternatif.input-data', ':id') }}";
            routeUrl = routeUrl.replace(':id', alternatif);
            $('#inputDataAlternatif').attr('action', routeUrl);
        })

        $('#inputDataAlternatif').on('submit', function(e) {
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
                            text: "Data Alternative has been created.",
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

        // -----------------------------Update Data Alternatif-------------------------
        $(document).on('click', '#buttonUpdateData', function(e) {
            e.preventDefault();
            var alternatif = $(this).data('id');
            // setURL
            var routeUrl = "{{ route('alternatif.update-data', ':id') }}";
            routeUrl = routeUrl.replace(':id', alternatif);
            $('#updateDataAlternatif').attr('action', routeUrl);

            var dataAlternatif = {!! json_encode($alternatif) !!}
            const singleAlternatif = dataAlternatif.find(e => e.id == alternatif)

            if (singleAlternatif) {
                singleAlternatif.criteria.forEach(element => {
                    $(`#updateData${element.code} option[value='${element.criteria_value.value}']`).prop(
                        'selected', true)
                });
            }
        })

        $('#updateDataAlternatif').on('submit', function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            var url = $(this).attr('action');
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
                            text: "Data Alternative has been updated.",
                            icon: "success"
                        }).then((result) => {
                            $('#updateDataForm').modal('hide');
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
                                        text: "Alternative has been deleted.",
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
