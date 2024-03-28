<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    /**
     * Display dashbnoard demo one of the resource.
     *
     * @return \Illuminate\View\View
     */
    function index(Request $request)
    {
        $title = "Dashboard";
        $description = "Some description for the page";

        $res = DB::select('SELECT wallet FROM mt_user_reseller WHERE email = "' . $request->session()->get('sessionEmail') . '"');

        $harini = 0;

        return view('dashboard.index', compact('title', 'description'))->with('saldo', $res[0]->wallet)->with('hariini', $harini);
    }

    function nodes(Request $request) {
        $title = "Nodes";
        $description = "Some description for the page";

        $nodes = DB::connection('mysql')->select('SELECT * FROM mt_device WHERE reseller_user_allocation = "' . $request->session()->get('sessionEmail') . '"');

        foreach ($nodes as $node) {
            $curlHandle = curl_init();
            curl_setopt($curlHandle, CURLOPT_URL, $node->url_health);
            curl_setopt($curlHandle, CURLOPT_NOBODY, true);
            curl_setopt($curlHandle, CURLOPT_HEADER, true);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($curlHandle, CURLOPT_TIMEOUT, 3); //timeout in seconds
            $response = curl_exec($curlHandle);
            preg_match('/ \d+ /', $response, $matches);
            $header_size = curl_getinfo($curlHandle, CURLINFO_HEADER_SIZE);
            $body = substr($response, $header_size);
            $node->health = isset($matches[0]) ? "yes" : "no";
            if ($matches[0] == 200) {
                $node->is_scanned = 1;
            }

            curl_close($curlHandle);
        }

//        dd($nodes);

        return view('dashboard.nodes', compact('title', 'description'))->with('nodes', $nodes);
    }

    function socket(Request $request) {

    }
}
