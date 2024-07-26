@extends('layouts.home.app-home')
@section('content')
    <div class="container-fluid mb-4">
        @include('layouts.alert')
    </div>
    <div class="container-fluid">
        <div class="row g-0 vh-lg-auto">
            <div class="col-12 col-lg-7 pt-lg-5 pb-lg-5">
                <div class="p-4 py-lg-0 pe-lg-5 ps-lg-5">
                    <!-- Checkout Panel Information-->
                    <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-3">
                        <h3 class="fs-5 fw-bolder m-0 lh-1">shipment information</h3>
                    </div>
                    <div class="px-4">
                        <table>
                            <tr>
                                <td class="fw-bold">Nama</td>
                                <td>: {{ $address->users->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Email</td>
                                <td>: {{ $address->users->email }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Address</td>
                                <td>: {{ $order->alamat_detail }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Phone</td>
                                <td>: {{ $address->users->no_hp }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-7 pb-lg-5">
                <div class="p-4 py-lg-0 pe-lg-5 ps-lg-5">
                    <!-- Checkout Panel Information-->
                    <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-3">
                        <h3 class="fs-5 fw-bolder m-0 lh-1">order information</h3>
                    </div>
                    <div class="row mx-0 py-4 g-0">
                        <div class="col-2 position-relative">
                            <h6 class="justify-content-between d-flex align-items-start mb-2">
                                Invoice
                            </h6>
                        </div>
                        <div class="col-9 offset-1">
                            <p class="fw-bolder text-end m-0">
                                {{ $order->kode }}
                            </p>
                        </div>
                    </div>
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
                    <div class="row mx-0 pt-4 g-0">
                        <div class="col-2 position-relative">
                            <h6 class="justify-content-between d-flex align-items-start mb-2">
                                Product Total
                            </h6>
                        </div>
                        <div class="col-9 offset-1">
                            <p class="fw-bolder text-end text-muted m-0">: Rp.
                                {{ $order->total_harga }}
                            </p>
                        </div>
                    </div>
                    <div class="row mx-0 g-0">
                        <div class="col-2 position-relative">
                            <h6 class="justify-content-between d-flex align-items-start mb-2">
                                shippment cost
                            </h6>
                        </div>
                        <div class="col-9 offset-1">
                            <p class="fw-bolder text-end text-muted m-0">: Rp.
                                {{ $order->ongkir }}
                            </p>
                        </div>
                    </div>
                    <div class="row mx-0 g-0">
                        <div class="col-2 position-relative">
                            <h6 class="justify-content-between d-flex align-items-start mb-2">
                                Grand Total
                            </h6>
                        </div>
                        <div class="col-9 offset-1">
                            <p class="fw-bolder text-end text-muted m-0">: Rp.
                                {{ $order->grand_total }}
                            </p>
                        </div>
                    </div>
                    <form action="{{ $redirect }}" target="_blank">
                        {{-- @csrf --}}
                        <div class="mt-4">
                            <button id="pay-button" class="btn btn-dark">Pay Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- @push('script')
<script type="text/javascript">
    // For example trigger on button clicked, or any time you need
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
      // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
      window.snap.pay('{{$redirect}}', {
        onSuccess: function(result){
          /* You may add your own implementation here */
          alert("payment success!"); console.log(result);
        },
        onPending: function(result){
          /* You may add your own implementation here */
          alert("wating your payment!"); console.log(result);
        },
        onError: function(result){
          /* You may add your own implementation here */
          alert("payment failed!"); console.log(result);
        },
        onClose: function(){
          /* You may add your own implementation here */
          alert('you closed the popup without finishing the payment');
        }
      })
    });
  </script>
@endpush --}}
