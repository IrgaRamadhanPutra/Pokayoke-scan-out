<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ekanban_Admout_tbl;
use Yajra\DataTables\Facades\DataTables;
use App\Models\db_tbs\GohinEntry as Db_tbsGohinEntry;
use App\Models\Ekanban_Admouttbl;

class DnController extends Controller
{
    public function index()
    {
        return view('pokayoke.ADM.Dn_no.index');
    }
    public function tampil(Request $request)
    {
        //ke satu

        $dn_no = $request->dn_no;
        $part_no = DB::table('db_tbs.gohin_adm as a')
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

        // dd($data);
        return response()->json($data);
    }
}
