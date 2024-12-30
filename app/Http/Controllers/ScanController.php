<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\db_tbs\GohinAdmEntry;

class ScanController extends Controller
{
    public function index()
    {
        return view('pokayoke.ADM.scan.inputdata');
    }

    public function validasi(Request $request)
    {
        //cek data
        // $dn_no = $request->dn_no;
        // $job_no = $request->dn_no;

        $part_no = DB::connection('db_tbs')->table('gohin_adm')
            ->where('dn_no', $request->dn_no)
            ->where('job_no', $request->job_no)
            ->select('dn_no', 'job_no', 'part_no')
            ->first();
        // dd($part_no);
        $data  = [
            empty($part_no) ? '-' : $part_no,

        ];

        // dd($data);
        return response()->json($data);
        // dd($data);
        // return response()->json($data);
    }
    public static function getEkanbanAdmoutSp1(Request $request)
    {
        // dd($request);
        // $value = $request->name;
        // dd($value);
        $dn_no = $request->dn_no;
        $job_no = $request->job_no;
        $input2 = $request->input2;
        $price = explode(",", $input2);
        // dd($price);
        $kanban_no = $price[0];
        $squence = $price[1];
        $part_no = $price[2];
        $itemcode = $price[3];
        $qty = $price[4];
        $AO1 = $price[5];
        $user = '';
        $str_date = '';
        $kosong = '';
        $date =  Carbon::now()->format('d');
        $value = [
            $kanban_no, $dn_no, $squence, $user, $qty, $itemcode, $str_date, $date, $kosong, $part_no, $AO1, $job_no

        ];

        $query = DB::connection('ekanban')
            ->select("call ekanban_admout_sp_1(?,?,?,?,?,?,?,?,?,?,?,?)", $value);
        // dd($query);
        $ambildata = $query[0]->retval;
        // dd($ambildata);
        return response()->json($ambildata);

        // $query = DB::connection('ekanban')
        // ->select("call ekanban_admout_sp_1(?,?,?,?,?,?,?,?,?,?,?,?)"
    }
}
