@extends('layouts.home.app-home')
@section('content')
    <div class="container-fluid mb-4">
        @include('layouts.alert')
    </div>
    <div class="container-fluid">
        <div class="row g-0 vh-lg-auto">
            <div class="card shadow mt-4 mb-4">
                <div class="card-header py-3">
                    <h5 class="card-title">Order List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered table-hover table-striped py-2">
                            <thead>
                                <tr>
                                    <th>no</th>
                                    <th>kode</th>
                                    <th>grand total</th>
                                    <th>status</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>Rp. {{ $item->grand_total }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            <form action="{{ route('orderinfo', $item->id) }}">
                                                <button type="submit" class="btn btn-primary btn-sm">show</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
@endpush
