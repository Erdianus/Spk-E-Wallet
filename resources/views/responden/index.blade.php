@extends('layouts.app')
@section('title')
    SPK-E-Wallet | Data Responden
@endsection
@section('content')
    <div class="card">
        <div class="card-header py-3">
            <h3>Data Responden E-Wallet</h3>
        </div>
        <div class="table-responsive p-2">
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
                    @foreach ($respondens as $item)
                        <tr>
                            <td class="text-start">{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <button id="button-delete-{{ $item->id }}"
                                    data-route="{{ route('responden.delete', $item->id) }}"
                                    onclick="delete_data({{ $item->id }})" type="button"
                                    class="btn btn-danger">Delete</button>
                                <a href="{{ route('responden.hasil', $item->slug) }}" id="responden-hasil" type="button"
                                    class="btn btn-success">Lihat Hasil</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
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
                                        text: "Responden has been deleted.",
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
