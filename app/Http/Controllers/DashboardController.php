<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Thread;

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

        $res = DB::select('SELECT COUNT(id_device) as count FROM mt_device WHERE reseller_user_allocation != "ROOT"');
        $participant = DB::select('SELECT COUNT(id) as count FROM mt_user_reseller WHERE is_admin = 0');
        $trx_today = DB::select('SELECT COUNT(message_id) as count FROM transaction_wa WHERE DATE(date) = CURDATE() and participant_email != ""');
        $trx_all = DB::select('SELECT COUNT(message_id) as count FROM transaction_wa WHERE participant_email != ""');


        $harini = 0;

        return view('dashboard.index', compact('title', 'description'))->with('saldo', $res[0]->count)->with('hariini', $harini)->with('participant', $participant[0]->count)->with('trx_today', $trx_today[0]->count)->with('trx_all', $trx_all[0]->count);
    }

    function nodes(Request $request) {
        $title = "Nodes Management";
        $description = "Some description for the page";

        $nodes = DB::connection('mysql')->select('SELECT * FROM mt_device where is_active = 1');
        $user = DB::connection('mysql')->select('SELECT * FROM mt_user_reseller where is_admin = 0');

        foreach ($nodes as $node) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $node->url_health);
            curl_setopt($ch, CURLOPT_TIMEOUT, 200);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, false);
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                $result = curl_error($ch);
            }
            curl_close($ch);
            $node->health = $result;
        }

//        dd($nodes);

        return view('dashboard.nodes', compact('title', 'description'))->with('nodes', $nodes)->with('user', $user);
    }

    function userManagement(Request $request) {
        $title = "Participant Management";
        $description = "Some description for the page";

        $user = DB::connection('mysql')->select('SELECT * FROM mt_user_reseller where is_admin = 0');

//        dd($nodes);

        return view('dashboard.participant', compact('title', 'description'))->with('user', $user);
    }
    function userToggle(Request $request) {
        $id_email = $request->id;

        $nowStatus = DB::connection('mysql')->select('SELECT is_active FROM mt_user_reseller WHERE email = ?', [$id_email]);
        if ($nowStatus[0]->is_active == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        $res = DB::connection('mysql')->update('UPDATE mt_user_reseller SET is_active = ? WHERE email = ?', [$status, $id_email]);

        if ($res == 1) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }

    function changeUser(Request $request) {

        $id_device = $request->id;
        $id_user = $request->email;

        $res = DB::connection('mysql')->update('UPDATE mt_device SET reseller_user_allocation = ? WHERE id_device = ?', [$id_user, $id_device]);

        if ($res == 1) {
            echo 'success';
        } else {
            echo 'failed';
        }

    }
}
