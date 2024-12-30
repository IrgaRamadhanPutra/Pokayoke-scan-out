<?php

namespace App\Http\Controllers;

use App\Models\db_tbs\GohinYamahaEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DnYamahaController extends Controller
{
    //
    public function getindex()
    {
        return view('pokayoke.YAMAHA.CHECK-DN.index');
    }
    public function tampil_yamaha(Request $request)
    {
        // dd($request);
        // $part_no = $request->part_no;
        $part_no = DB::connection('db_tbs')->table('gohin_yamaha')
            ->where('part_no', $request->part_no)
            // ->where('job_no', $request->job_no)
            ->select('dn_no', 'part_no')
            ->first();
        // dd($part_no);
        $data  = [
            empty($part_no) ? '-' : $part_no,

        ];
        return response()->json($data);
    }
    public function GetDnYamaha(Request $request)
    {
        $dn_no = $request->dn_no;
        // dd($dn_no);
        $part_no = DB::table('db_tbs.gohin_yamaha as a')

            ->select('a.dn_no', 'a.part_no', 'a.quantity')
            ->select('a.dn_no', 'a.part_no', 'a.quantity', DB::raw('IFNULL(SUM(b.ekanban_qty), 0) as qty'))
            ->leftjoin('ekanban.ekanban_admout_tbl as b', function ($join) {
                $join->on('a.part_no', '=', 'b.part_no')
                    ->on('a.dn_no', '=', 'b.dn_no');
            })
            // ->where('b.customer', 'A01')
            ->where('a.dn_no', $dn_no)
            ->groupBy('a.dn_no', 'a.part_no')
            ->get();
        // dd($part_no);
        $data  = [
            empty($part_no) ? '-' : $part_no,

        ];
        return response()->json($data);
    }
}
