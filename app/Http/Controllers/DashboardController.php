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

        $participant = [];
        if ($request->session()->get('sessionRole') == 'ROOT_ADMIN') {
            $participant = DB::select('SELECT COUNT(id) as count FROM mt_user_reseller_new WHERE role = ?', ['PARTICIPANT']);
        } else if ($request->session()->get('sessionRole') == 'PRINCIPAL') {
            $participant = DB::select('SELECT COUNT(id) as count FROM mt_user_reseller_new WHERE role = ? AND principal_upline = ?', ['PARTICIPANT', $request->session()->get('sessionEmail')]);
        } else if ($request->session()->get('sessionRole') == 'RESELLER') {
            $participant = DB::select('SELECT COUNT(id) as count FROM mt_user_reseller_new WHERE role = ? AND reseller_upline = ?', ['PARTICIPANT', $request->session()->get('sessionEmail')]);
        }
//        $trx_today = DB::select('SELECT COUNT(message_id) as count FROM transaction_wa WHERE DATE(date) = CURDATE() and participant_email != ""');
//        $trx_all = DB::select('SELECT COUNT(message_id) as count FROM transaction_wa WHERE participant_email != ""');

        $saldoKolektif = [];
        if ($request->session()->get('sessionRole') == 'ROOT_ADMIN') {
            $saldoKolektif = DB::select('SELECT SUM(wallet) as count FROM mt_user_reseller_new', []);
        } else if ($request->session()->get('sessionRole') == 'PRINCIPAL' || $request->session()->get('sessionRole') == 'RESELLER') {
            $saldoKolektif = DB::select('SELECT wallet as count FROM mt_user_reseller_new WHERE email = ?', [$request->session()->get('sessionEmail')]);
        }

        $harini = 0;

        return view('dashboard.index', compact('title', 'description'))->with('hariini', $harini)->with('participant', $participant[0]->count)->with('saldoKolektif', $saldoKolektif[0]->count);
    }

    function walletManagement(Request $request)
    {
        $title = "Principal";
        $description = "Some description for the page";
        $user = [];

        $allUser = DB::connection('mysql')->select('SELECT * FROM mt_user_reseller_new WHERE role = ? ORDER BY nama ASC', ['PRINCIPAL']);

        foreach ($allUser as $u) {
            $res = DB::connection('mysql')->select("SELECT email, nama, phone, rekening, fee_principal, fee_reseller, fee_participant, (SELECT sum(wallet) FROM mt_user_reseller_new where principal_upline = ?) as wallet FROM mt_user_reseller_new where role = ? and email = ?", [$u->email, 'PRINCIPAL', $u->email]);
            if (count($res) > 0) {
                array_push($user, $res[0]);
            }
        }

        return view('dashboard.wallet', compact('title', 'description'))->with('user', $user);
    }

    function nodes(Request $request)
    {
        $title = "Nodes Management";
        $description = "Some description for the page";

        $nodes = DB::connection('mysql')->select('SELECT * FROM mt_device where is_active = 1 AND reseller_user_allocation != "ROOT" and pic = ?', [$request->session()->get('sessionPic')]);
        $user = DB::connection('mysql')->select('SELECT * FROM mt_user_reseller where is_admin = 0 AND is_reseller = 0 AND reseller_upline = ?', [$request->session()->get('sessionEmail')]);

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

        $alluser = [];
        $user = [];
        if ($request->session()->get('sessionRole') == 'PRINCIPAL') {
            $allUser = DB::connection('mysql')->select('SELECT * FROM mt_user_reseller_new WHERE role = ? AND principal_upline = ? ORDER BY nama ASC', ['RESELLER', $request->session()->get('sessionEmail')]);
            foreach ($allUser as $u) {
                $res = DB::connection('mysql')->select("SELECT id, email, nama, phone, rekening, (SELECT sum(wallet) FROM mt_user_reseller_new where reseller_upline = ?) as wallet, is_active FROM mt_user_reseller_new where role = ? and email = ?", [$u->email, 'RESELLER', $u->email]);
                if (count($res) > 0) {
                    array_push($user, $res[0]);
                }
            }
        } else {
            $user = DB::connection('mysql')->select("SELECT id, email, nama, phone, rekening, wallet, is_active FROM mt_user_reseller_new where role = ? and reseller_upline = ?", ['PARTICIPANT', $request->session()->get('sessionEmail')]);
        }

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
        $rek = $request->rek;

        $rawPassword = substr($phone, -6);
        $encPassword = password_hash($rawPassword, PASSWORD_DEFAULT);
        $is_active = 1;

        $res = 0;
        if ($request->session()->get('sessionRole') == 'PRINCIPAL') {
            $res = DB::connection('mysql')->insert('INSERT INTO mt_user_reseller_new(nama, email, phone, password, role, is_active, principal_upline, reseller_upline, rekening) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', [$name, $email, $phone, $encPassword, 'RESELLER', $is_active, $request->session()->get('sessionEmail'), $email, $rek]);
        } else if ($request->session()->get('sessionRole') == 'RESELLER') {
            $res = DB::connection('mysql')->insert('INSERT INTO mt_user_reseller_new(nama, email, phone, password, role, is_active, principal_upline, reseller_upline, rekening) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', [$name, $email, $phone, $encPassword, 'PARTICIPANT', $is_active, $request->session()->get('sessionPrincipalUpline'), $request->session()->get('sessionEmail'), $rek]);
        }
        if ($res == 1) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }

    function addPrincipal(Request $request)
    {
        $name = $request->nama;
        $email = $request->email;
        $phone = $request->phone;
        $feePrincipal = $request->feePrincipal;
        $feeReseller = $request->feeReseller;
        $feeParticipant = $request->feeParticipant;
        $rek = $request->rek;

        $rawPassword = substr($phone, -6);
        $encPassword = password_hash($rawPassword, PASSWORD_DEFAULT);
        $is_active = 1;

        $res = 0;
        if ($request->session()->get('sessionRole') == 'ROOT_ADMIN') {
            $res = DB::connection('mysql')->insert('INSERT INTO mt_user_reseller_new(nama, email, phone, password, role, is_active, fee_principal, fee_reseller, fee_participant, rekening, principal_upline) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$name, $email, $phone, $encPassword, 'PRINCIPAL', $is_active, $feePrincipal, $feeReseller, $feeParticipant, $rek, $email]);
        }
        if ($res == 1) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }

    function monitor(Request $request)
    {
        $title = "Nodes Monitoring";
        $description = "Some description for the page";

        $nodes = DB::connection('mysql')->select('SELECT * FROM mt_device where is_active = 1 AND reseller_user_allocation != "ROOT" and pic = ?', [$request->session()->get('sessionPic')]);
//        $user = DB::connection('mysql')->select('SELECT * FROM mt_user_reseller where is_admin = 0 AND is_reseller = 0 AND reseller_upline = ?', [$request->session()->get('sessionEmail')]);

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

        return view('dashboard.monitor', compact('title', 'description'))->with('nodes', $nodes);
    }
}
