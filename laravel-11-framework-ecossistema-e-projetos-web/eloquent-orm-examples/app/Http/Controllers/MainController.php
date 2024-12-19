<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Phone;
use App\Models\Product;

class MainController extends Controller
{
    public function index() {}

    public function one_to_one()
    {
        // phones for a client
        // $client = Client::findOrFail(12)->phone;
        $client = Client::with('phone')->findOrFail(12);

        return response()->json($client);
    }

    public function one_to_many()
    {
        // in this case, "phones" is an array of phone (Phone::class)
        $client = Client::with('phones')->findOrFail(1);

        return response()->json($client);
    }

    public function belongs_to()
    {
        $response = Phone::with('client')->find(1);

        return response()->json($response);
    }

    public function many_to_many()
    {
        // all products by client 1
        $productsByClient = Client::with('products')->find(1);

        // all clients for product 2
        $clientsByProduct = Product::with('clients')->find(2);

        return response()->json($productsByClient);
        // return response()->json($clientsByProduct);
    }


    public function collections()
    {
        // take first 5 
        $response = Client::take(5)->get()->setHidden(['id']);

        return response()->json($response);
    }
}
