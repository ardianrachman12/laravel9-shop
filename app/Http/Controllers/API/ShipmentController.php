<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ShipmentController extends Controller
{
    public function shipment(Request $request)
    {
        // Lakukan validasi menggunakan Validator
        $validator = Validator::make($request->all(), [
            'city_id' => 'required',
            'kurir' => 'required',
            'jumlah_berat' => 'required|numeric',
        ]);

        // Jika validasi gagal, kembalikan JSON dengan pesan error
        if ($validator->fails()) {
            $error = [
                'error' => [
                    'code' => 422,  // Kode status Unprocessable Entity
                    'message' => $validator->errors()->all()
                ]
            ];
            return response()->json($error, 422);
        }

        $origin = 419;

        $response = Http::withHeaders([
            'key' => config('rajaongkir.api_key')
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $origin,
            'destination' => $request->city_id,
            'courier' => $request->kurir,
            'weight' => $request->jumlah_berat
        ]);

        if ($response->successful()) {
            $data = $response['rajaongkir'];
            return response()->json($data);
        } else {
            // Jika respons tidak berhasil, kembalikan JSON dengan informasi kesalahan
            $error = [
                'error' => [
                    'code' => $response->status(),
                    'message' => 'Error fetching data from RajaOngkir.'
                ]
            ];
            return response()->json($error, $response->status());
        }
    }

    public function province()
    {
        $response = Http::withHeaders([
            'key' => config('rajaongkir.api_key')
        ])->get('https://api.rajaongkir.com/starter/province');
        $data = $response['rajaongkir']['results'];
        return response()->json($data);
    }
    public function city(Request $request)
    {
        $response = Http::withHeaders([
            'key' => config('rajaongkir.api_key')
        ])->get('https://api.rajaongkir.com/starter/city', [
            'province' => $request->province
        ]);

        $results = $response['rajaongkir']['results'];

        $filteredData = array_map(function ($result) {
            // Menggabungkan type dan city_name
            $cityName = $result['type'] . ' ' . $result['city_name'];

            return [
                'id' => $result['city_id'],
                'province_id' => $result['province_id'],
                'title' => $cityName,
                'postal_code' => $result['postal_code'],
            ];
        }, $results);

        return response()->json($filteredData);
    }



    public function token(Request $request)
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $itemDetails = [];

        // Check if $request->items is not null and is an array
        if (!empty($request->items) && is_array($request->items)) {
            foreach ($request->items as $item) {
                $itemDetails[] = [
                    'id' => $item['id'],
                    'price' => $item['harga'],
                    'quantity' => $item['qty'],
                    'name' => $item['nama_product'],
                ];
            }
        } else {
            // Handle the case where $request->items is null or not an array
            // You may set a default value or throw an error, depending on your requirements.
            return response()->json(['error' => 'Invalid or missing items data.'], 400);
        }

        $params = [
            'transaction_details' => [
                'order_id' => $request->kode,
                'gross_amount' => $request->grand_total,
            ],
            'customer_details' => [
                'first_name' => $request->nama_depan,
                'last_name' => $request->nama_belakang,
                'email' => $request->email,
                'phone' => $request->no_hp,
            ],
            'item_details' => $itemDetails,
        ];

        $snapToken = \Midtrans\Snap::createTransaction($params);

        return response()->json($snapToken);
    }
}
