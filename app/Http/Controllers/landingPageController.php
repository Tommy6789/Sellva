<?php

namespace App\Http\Controllers;

use App\Models\produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class landingPageController extends Controller
{
    public function home()
    {
        return view('landingPage.home');
    }

    public function shop()
    {
        // $data = produk::all();
        if(Auth::check())
        {
            $data = DB::table('produks')
            ->Leftjoin('keranjangs', 'produks.id', '=', 'keranjangs.id_produk')
            ->select('produks.*', 'keranjangs.quantity')
            ->get();
        }else{
            $data = produk::all();
        }
        return view('landingPage.shop', compact('data'));
    }
}
