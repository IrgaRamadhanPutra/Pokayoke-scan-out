<?php

namespace App\Http\Controllers;

use App\Models\db_tbs\GohinYamahaEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ScanYamahaController extends Controller
{
    public function index()
    {
        return view('pokayoke.YAMAHA.SCAN.index');
    }

    public function validasi_yamaha(Request $request)
    {
        // dd($request);
        $part_no = GohinYamahaEntry::where('part_no', $request->part_no)
            // ->where('job_no', $request->job_no)
            ->select('part_no', 'dn_no', 'quantity')
            ->first();
        // dd($part_no);
        $data  = [
            empty($part_no) ? '-' : $part_no,

        ];
        return response()->json($data);
    }

    public static function getEkanban(Request $request)

    {

        $str_dn_no_i = $request->dn_no;
        $str_pn_yamaha_i = $request->part_no;
        $dbl_qty_yamaha_i = $request->qty;
        $input2 = $request->input2;

        // Parse input2 value to extract relevant values
        $price = explode(",", $input2);
        // dd($price);
        // $str_pn_yamaha_i = $price[0];
        $str_ekanban_no_i = $price[1];
        $int_seq_i = $price[2];
        $str_pn_i = $price[3];
        $str_pn_ori_i = $price[3];

        // $str_pn_yamaha_i = $price[3];
        $str_itemcode_i = $price[4];
        $int_qty_i = $price[5];
        $str_cust_i = $price[6];

        // Set default values for unused arguments
        $str_user_i = '';
        $str_day_i = '';
        $str_uid_i = '';
        $str_job_no_i = '';

        // Build array of stored procedure arguments
        $str_year_month_i = Carbon::now()->toDateTimeString(); // format date as datetime string
        $value = [

            $str_pn_yamaha_i, $dbl_qty_yamaha_i, $str_pn_i, $int_qty_i, $str_pn_ori_i, $str_ekanban_no_i,
            $str_dn_no_i, $int_seq_i, $str_user_i, $str_day_i, $str_year_month_i, $str_itemcode_i,
            $str_uid_i, $str_job_no_i, $str_cust_i
        ];

        // Call stored procedure and retrieve result
        $query = DB::connection('ekanban')
            ->select("call ekanban_admout_sp_2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", $value);
        $ambildata = $query[0]->retval;

        // Return result as JSON response
        return response()->json($ambildata);
    }
}
