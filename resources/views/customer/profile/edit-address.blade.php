@extends('layouts.home.app-home')
@push('script')
    <script>
        $(function() {
            $('#province').on('change', function() {
                let id_province = $('#province').val();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('selectprovinsi') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_province: id_province
                    },
                    cache: false,

                    success: function(msg) {
                        $('#destination').html(msg);
                    },
                    error: function(data) {
                        console.log('error:', data)
                    },
                })
            })
        })
    </script>
@endpush
@section('content')
    <div class="container-fluid mb-4">
        @include('layouts.alert')
    </div>
    <section class="vh-lg-auto">
        <!-- Page Content Goes Here -->
        <div class="container">
            <div class="row g-0 vh-lg-auto">
                <div class="col-12 col-lg-7">
                    <div class="pe-lg-5">
                        <form action="{{ route('updateAddress', $address->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <h3 class="fs-5 fw-bolder mb-4 border-bottom pb-4">Edit Address</h3>
                            <div class="row">
                                <!-- Name-->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="nama_depan" class="form-label">Nama Depan</label>
                                        <input type="text" class="form-control" id="nama_depan" name="nama_depan"
                                            placeholder="" value="{{ $address->nama_depan }}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="nama_belakang" class="form-label">Nama Belakang</label>
                                        <input type="text" class="form-control" id="nama_belakang" name="nama_belakang"
                                            placeholder="" value="{{ $address->nama_belakang }}" required>
                                    </div>
                                </div>

                                <!-- Address-->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="alamat_detail" class="form-label">Alamat Lengkap</label>
                                        <input type="text" class="form-control" id="alamat_detail" placeholder=""
                                            required name="alamat_detail" value="{{ $address->alamat_detail }}">
                                    </div>
                                </div>

                                <!-- Provinsi-->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="provinsi" class="form-label">Provinsi</label>
                                        <select class="form-select" name="province_id" id="province">
                                            <option selected disabled>Pilih Provinsi</option>
                                            <option selected value="{{ $address->province_id }}">
                                                {{ $address->Provinces->title }}</option>
                                            @foreach ($provinces as $item)
                                                <option value="{{ $item->id }}">{{ $item->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- kota-->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="kota" class="form-label">Kota/Kabupaten</label>
                                        <select class="form-select" id="destination" name="city_id">
                                            <option selected value="{{ $address->city_id }}">
                                                {{ $address->cities->title }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Post Code-->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="kode_pos" class="form-label">kode</label>
                                        <input type="text" class="form-control" id="kode_pos" name="kode_pos"
                                            placeholder="" value="{{ $address->kode_pos }}">
                                    </div>
                                </div>
                            </div>
                            <div class="pt-2 mt-2 pb-5 border-top d-flex justify-content-md-start align-items-center">
                                <button type="submit" class="btn btn-primary w-md-auto" role="button">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </section>
@endsection
