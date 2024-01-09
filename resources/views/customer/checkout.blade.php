@extends('layouts.home.app-home')
@section('content')
    <!-- Main Section-->
    <div class="container-fluid mb-4">
        @include('layouts.alert')
    </div>
    <section class="vh-lg-auto">
        <!-- Page Content Goes Here -->
        <div class="container-fluid">
            <div class="row g-0 vh-lg-auto">
                <div class="col-12 col-lg-7 pt-lg-5 pb-lg-5 bg-light">
                    <div class="p-4 py-lg-0 pe-lg-5 ps-lg-5">
                        <!-- Checkout Panel Information-->
                        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-4">
                            <h3 class="fs-5 fw-bolder m-0 lh-1">Contact Information</h3>
                        </div>
                        <!-- Name-->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="firstNameBilling" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="firstNameBilling" placeholder=""
                                    value="{{ $nama }}" required name="nama" readonly>
                            </div>
                        </div>

                        <!-- Email-->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="" name="email"
                                    value="{{ $email }}" readonly>
                            </div>
                        </div>

                        <!-- Phone-->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="phone" class="form-control" id="phone" placeholder="" name="phone"
                                    value="{{ $phone }}" readonly>
                            </div>
                        </div>
                        <h3 class="fs-5 mt-5 fw-bolder mb-4 border-bottom pb-4">Address</h3>
                        @if (!$address)
                            <a href="{{ route('profil') }}" type="button" class="btn btn-primary w-md-auto"
                                role="button">Create Address
                            </a>
                        @else
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
                                        <input type="text" class="form-control" id="alamat_detail" placeholder=""
                                            required name="alamat_detail"
                                            @if ($address) value="{{ $address->alamat_detail }}" readonly @endif>
                                    </div>
                                </div>

                                <!-- Provinsi-->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="province" class="form-label">Provinsi</label>
                                        @if ($address)
                                            <input type="text" class="form-control" id="province_id" placeholder=""
                                                required name="province_id" readonly
                                                value="{{ $address->Provinces->title }}">
                                        @endif
                                    </div>
                                </div>

                                <!-- kota-->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="kota" class="form-label">Kota/Kabupaten</label>
                                        @if ($address)
                                            <input type="text" class="form-control" id="city_id" placeholder=""
                                                required name="city_id" readonly value="{{ $address->Cities->title }}">
                                        @endif
                                    </div>
                                </div>

                                <!-- Post Code-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kode_pos" class="form-label">Kode Pos</label>
                                        <input type="text" class="form-control" id="kode_pos" name="kode_pos"
                                            placeholder=""
                                            @if ($address) value="{{ $address->kode_pos }}" readonly @endif
                                            required>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('editAddress', $address->id) }}" type="button"
                                        class="btn btn-primary w-md-auto" role="button">Edit Address
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-lg-5 bg-light pt-lg-5 aside-checkout pb-5 pb-lg-0 my-5 my-lg-0">
                    <div class="p-4 py-lg-0 pe-lg-0 ps-lg-5">
                        <div class="pb-3">
                            <!-- Cart Item-->
                            @foreach ($orderdetail as $orders)
                                <div class="row mx-0 py-4 g-0 border-bottom">
                                    <div class="col-2 position-relative">
                                        <picture class="d-block border">
                                            <img class="img-fluid" src="/uploads/{{ $orders->products->gambar }}"
                                                alt="HTML Bootstrap Template by Pixel Rocket">
                                        </picture>
                                    </div>
                                    <div class="col-9 offset-1">
                                        <div>
                                            <h6 class="justify-content-between d-flex align-items-start mb-2">
                                                {{ $orders->products->nama }}
                                                {{-- <form action="{{ route('deleteproduct', $orders->id) }}" type="button"
                                                    method="post" onsubmit="return confirm('Yakin akan dihapus?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm">
                                                        <i class="ri-close-line"></i>
                                                    </button>
                                                </form> --}}
                                            </h6>
                                            <span class="d-block text-muted fw-bolder text-uppercase fs-10">
                                                Qty : {{ $orders->qty }}
                                            </span>
                                        </div>
                                        <p class="fw-bolder text-end text-muted m-0">Rp.
                                            {{ $orders->jumlah_harga }}
                                        </p>
                                    </div>
                                </div> <!-- / Cart Item-->
                            @endforeach
                        </div>
                        <form action="{{ route('placeorder') }}" method="post">
                            @csrf
                            <div class="pb-4 border-bottom">
                                <div class="col-md-12">
                                    <label for="service" class="form-label">Tipe</label>
                                    <select class="form-control" name="service" id="service">
                                        <option selected disabled value="">Pilih Kurir</option>
                                        @foreach ($results as $courier => $courierResults)
                                            <optgroup label="{{ strtoupper($courier) }}">
                                                @foreach ($courierResults as $result)
                                                    <option
                                                        value="{{ $courier }}|{{ $result['service'] }}|{{ $result['cost'][0]['value'] }}">
                                                        {{ strtoupper($courier) }} | {{ $result['service'] }} -
                                                        {{ $result['description'] }}
                                                        ({{ $result['cost'][0]['value'] }}
                                                        {{ $result['cost'][0]['etd'] }})
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="py-4 border-bottom">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <p class="m-0 fw-bolder fs-6">Total Harga Produk</p>
                                    <p class="m-0 fs-6 fw-bolder">Rp. {{ $order->total_harga }}</p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center ">
                                    <p class="m-0 fw-bolder fs-6">Ongkos Kirim</p>
                                    <p id="shipping-cost" class="m-0 fs-6 fw-bolder"></p>
                                </div>
                            </div>
                            <div class="py-4 border-bottom">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="m-0 fw-bold fs-5">Grand Total</p>
                                        {{-- <span class="text-muted small">Inc $45.89 sales tax</span> --}}
                                    </div>
                                    <p id="grand-total" class="m-0 fs-5 fw-bold">Rp. {{ $order->grand_total }}</p>
                                </div>
                            </div>
                            <div class="py-4">
                                <button type="submit" class="btn btn-dark">Place Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </section>
    <!-- / Main Section-->
@endsection
{{-- @push('script')
    <script>
        $(function() {
            $('#kurir').on('change', function() {
                let id_kurir = $('#kurir').val();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('getcost') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_kurir: id_kurir
                    },
                    cache: false,

                    success: function(msg) {
                        $('#service').html(msg);
                    },
                    error: function(data) {
                        console.log('error:', data)
                    },
                })
            })
        })
    </script>
@endpush --}}
@push('script')
    <script>
        $(document).ready(function() {
            $('#service').change(function() {
                var selectedCost = $(this).val();
                var ongkir = getOngkirValue(selectedCost);
                updateShippingCost(ongkir);
                updateGrandTotal(ongkir);
            });

            function getOngkirValue(selectedCost) {
                // Menggunakan split untuk mendapatkan nilai ongkir dari string 'courier|service|ongkir'
                var ongkirArray = selectedCost.split('|');
                var ongkir = ongkirArray[2];

                return ongkir;
            }

            function updateShippingCost(cost) {
                $('#shipping-cost').text('Rp. ' + cost);
            }

            function updateGrandTotal(cost) {
                var totalHarga = {{ $order->total_harga }};
                var grandTotal = totalHarga + parseFloat(cost);
                $('#grand-total').text('Rp. ' + grandTotal);
            }
        });
    </script>
@endpush
