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
<section class="vh-lg-auto">
    <!-- Page Content Goes Here -->
    <div class="container-fluid mb-4">
        @include('layouts.alert')
    </div>
    <div class="container-fluid">
            <div class="row g-0 vh-lg-auto">
                <div class="col-12 col-lg-7 mb-4">
                    <div class="pe-lg-5">
                        <!-- Checkout Panel Information-->
                        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-4">
                            <h3 class="fs-5 fw-bolder m-0 lh-1">Profile</h3>
                        </div>
                        <div class="row">
                            <form action="/profil-update" method="POST">
                                @csrf
                                <!-- Name-->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="firstNameBilling" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="firstNameBilling" placeholder=""
                                            value="{{ $nama }}" required name="nama">
                                    </div>
                                </div>

                                <!-- Email-->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" placeholder=""
                                            name="email" value="{{ $email }}">
                                    </div>
                                </div>

                                <!-- Phone-->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="no_hp" class="form-label">no_hp</label>
                                        <input type="no_hp" class="form-control" id="no_hp" placeholder=""
                                            name="no_hp" value="{{ $no_hp }}">
                                    </div>
                                </div>
                                <div class="pt-2 mt-2 pb-2 border-top d-flex justify-content-md-start align-items-center">
                                    <button type="submit" class="btn btn-primary w-md-auto" role="button">Update</button>
                                    <button type="button" class="btn btn-danger ms-3 w-md-auto" data-toggle="modal"
                                        data-target="#changePasswordModal" role="button">Ubah Password</button>
                                    {{-- <a href="" type="button" class="btn btn-danger ms-3 w-md-auto"
                                        role="button"></a> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <form action="{{ route('createAddress') }}" method="POST">
                        @csrf
                        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-4">
                            <h3 class="fs-5 fw-bolder m-0 lh-1">Address</h3>
                        </div>
                        <div class="row">
                            <!-- Name-->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="nama_depan" class="form-label">Nama Depan</label>
                                    <input type="text" class="form-control" id="nama_depan" name="nama_depan"
                                        placeholder=""
                                        @if ($address) value="{{ $address->nama_depan }}" readonly @endif
                                        required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="nama_belakang" class="form-label">Nama Belakang</label>
                                    <input type="text" class="form-control" id="nama_belakang" name="nama_belakang"
                                        placeholder=""
                                        @if ($address) value="{{ $address->nama_belakang }}" readonly @endif
                                        required>
                                </div>
                            </div>

                            <!-- Address-->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="alamat_detail" class="form-label">Alamat Lengkap</label>
                                    <input type="text" class="form-control" id="alamat_detail" placeholder="" required
                                        name="alamat_detail"
                                        @if ($address) value="{{ $address->alamat_detail }}" readonly @endif>
                                </div>
                            </div>

                            <!-- Provinsi-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="province" class="form-label">Provinsi</label>
                                    @if ($address)
                                        <input type="text" class="form-control" id="province_id" placeholder="" required
                                            name="province_id" readonly value="{{ $address->Provinces->title }}">
                                    @else
                                        <select class="form-select" name="province_id" id="province">
                                            <option selected readonly>Pilih Provinsi</option>
                                            @foreach ($provinces as $item)
                                                <option value="{{ $item->id }}">{{ $item->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>

                            <!-- kota-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="kota" class="form-label">Kota/Kabupaten</label>
                                    @if ($address)
                                        <input type="text" class="form-control" id="city_id" placeholder="" required
                                            name="city_id" readonly value="{{ $address->Cities->title }}">
                                    @else
                                        <select class="form-select" id="destination" name="city_id">
                                        </select>
                                    @endif
                                </div>
                            </div>

                            <!-- Post Code-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="kode_pos" class="form-label">kode</label>
                                    <input type="text" class="form-control" id="kode_pos" name="kode_pos"
                                        placeholder=""
                                        @if ($address) value="{{ $address->kode_pos }}" readonly @endif
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="pt-2 mt-2 border-top d-flex justify-content-md-start align-items-center">
                            @if ($address)
                                <a href="{{ route('editAddress', $address->id) }}" type="button"
                                    class="btn btn-primary w-md-auto" role="button">Edit Address
                                </a>
                            @else
                                <button type="submit" class="btn btn-primary w-md-auto" role="button">Create Address
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog"
            aria-labelledby="changePasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-4">
                            <h3 class="fs-5 fw-bolder m-0 lh-1" id="changePasswordModalLabel">Ubah Password</h3>
                        </div>
                    </div>
                    <div class="modal-body">
                        <!-- Formulir untuk mengganti password -->
                        <form id="changePasswordForm" action="{{ route('updatePassword') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="current_password">Password Lama</label>
                                <input type="password" class="form-control" id="current_password"
                                    name="current_password" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">Password Baru</label>
                                <input type="password" class="form-control" id="new_password" name="new_password"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="confirm_password"
                                    name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </section>
@endsection
