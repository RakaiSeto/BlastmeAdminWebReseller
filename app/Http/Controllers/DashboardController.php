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

        $res = DB::select('SELECT COUNT(id_device) as count FROM mt_device WHERE reseller_user_allocation != "ROOT"');
        $participant = DB::select('SELECT COUNT(id) as count FROM mt_user_reseller WHERE is_admin = 0');
        $trx_today = DB::select('SELECT COUNT(message_id) as count FROM transaction_wa WHERE DATE(date) = CURDATE() and participant_email != ""');
        $trx_all = DB::select('SELECT COUNT(message_id) as count FROM transaction_wa WHERE participant_email != ""');
        if ($request->session()->get('role') == 'admin') {
            $saldoKolektif = DB::select('SELECT SUM(wallet) as count FROM mt_user_reseller WHERE reseller_upline = ?', [$request->session()->get('email')]);
        } else {
            $saldoKolektif = DB::select('SELECT SUM(wallet) as count FROM mt_user_reseller');
        }

        $harini = 0;

        return view('dashboard.index', compact('title', 'description'))->with('saldo', $res[0]->count)->with('hariini', $harini)->with('participant', $participant[0]->count)->with('trx_today', $trx_today[0]->count)->with('trx_all', $trx_all[0]->count)->with('saldoKolektif', $saldoKolektif[0]->count);
    }

    function walletManagement(Request $request)
    {
        $title = "Participant Wallet";
        $description = "Some description for the page";
        $user = [];

        $allUser = DB::connection('mysql')->select('SELECT * FROM mt_user_reseller where is_reseller = 1');

        foreach ($allUser as $u) {
            $res = DB::connection('mysql')->select("SELECT email, nama, phone, rekening, (SELECT sum(wallet) FROM mt_user_reseller where reseller_upline = ?) as wallet FROM mt_user_reseller where is_reseller = 1 and email = ?", [$u->email, $u->email]);
            array_push($user, $res[0]);
        }

        return view('dashboard.wallet', compact('title', 'description'))->with('user', $user);
    }

    function nodes(Request $request)
    {
        $title = "Nodes Management";
        $description = "Some description for the page";

        $nodes = DB::connection('mysql')->select('SELECT * FROM mt_device where is_active = 1 AND reseller_user_allocation != "ROOT"');
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

    function userManagement(Request $request)
    {
        $title = "Participant Management";
        $description = "Some description for the page";

        $user = DB::connection('mysql')->select('SELECT * FROM mt_user_reseller where reseller_upline = ?', [$request->session()->get('sessionEmail')]);

//        dd($nodes);

        return view('dashboard.participant', compact('title', 'description'))->with('user', $user);
    }

    function userToggle(Request $request)
    {
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

    function changeUser(Request $request)
    {

        $id_device = $request->id;
        $id_user = $request->email;

        $res = DB::connection('mysql')->update('UPDATE mt_device SET reseller_user_allocation = ? WHERE id_device = ?', [$id_user, $id_device]);

        if ($res == 1) {
            echo 'success';
        } else {
            echo 'failed';
        }

    }

    function addParticipant(Request $request)
    {
        $name = $request->nama;
        $email = $request->email;
        $phone = $request->phone;
        $fee = $request->fee;

        $rawPassword = substr($phone, -6);
        $encPassword = password_hash($rawPassword, PASSWORD_DEFAULT);
        $is_admin = 0;
        $is_active = 1;

        $res = DB::connection('mysql')->insert('INSERT INTO mt_user_reseller (nama, email, phone, password, is_admin, is_active, is_reseller, pic, reseller_upline, fee) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$name, $email, $phone, $encPassword, $is_admin, $is_active, 0, 0, $request->session()->get('sessionEmail'), $fee]);

        if ($res == 1) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }
}
