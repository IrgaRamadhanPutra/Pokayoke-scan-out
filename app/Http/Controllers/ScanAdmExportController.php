<?php

namespace App\Http\Controllers;

use App\GohinEntry;
use App\Models\db_tbs\GohinAdmEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScanAdmExportController extends Controller
{
    //
    public function index()
    {
        return view('pokayoke.ADM.scan-export.index');
    }
    public function validasi_gohin(Request $request)
    {
        //cek data

        $validasi = GohinAdmEntry::where('dn_no', $request->modulNo)
            ->where('part_no', $request->partNo)
            ->select('dn_no', 'job_no', 'part_no')
            ->first();
        // dd($validasi);
        $data = !empty($validasi) ? $validasi : '-';


        // dd($data);
        return response()->json($data);
        // dd($data);
        // return response()->json($data);
    }

    public static function getEkanbanAdmoutSp1Export(Request $request)
    {
        $dn_no = $request->dn_no;
        $job_no = $request->job_no;
        $input2 = $request->input2;

        // Memecah input2 yang dipisahkan koma menjadi array
        $price = explode(",", $input2);

        // Mendapatkan nilai dari array input
        $kanban_no = $price[0];      // Nilai kanban_no
        $squence = $price[1];        // Nilai seq
        $part_no = $price[2];        // Nilai part_no
        $itemcode = $price[3];       // Nilai item_code
        $qty = $price[4];            // Nilai qty
        $AO1 = $price[5];            // Nilai customer_code (AO1)

        // Variabel tambahan
        $user = null;                 // Gunakan NULL jika kosong
        $str_date = null;             // Gunakan NULL jika kosong
        $kosong = null;               // Kosongkan dengan NULL
        $date = Carbon::now()->format('d');  // Mendapatkan tanggal sekarang

        // Nilai yang akan dikirim ke stored procedure sesuai dengan urutannya
        $values = [
            $kanban_no,  // ekaban_no_i (kanban_no)
            $dn_no,      // dn_no_i
            $squence,    // seq_i
            $user,       // uid_i (NULL)
            $qty,        // qty_i
            $itemcode,   // item_code_i
            $str_date,   // str_user_i (NULL)
            $date,       // mpname_1 (tanggal sekarang)
            $kosong,     // NULL
            $part_no,    // part_no_i
            $AO1,        // customer_code
            $job_no      // job_no_i (username_i)
        ];

        // Debug array values jika diperlukan
        // dd($values);

        try {
            // Eksekusi prosedur tersimpan dengan parameter yang sudah disesuaikan
            $query = DB::connection('ekanban')->select("CALL ekanban_admout_sp_1(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $values);

            // Mengambil data hasil output dari stored procedure (jika ada output seperti retval)
            $ambildata = $query[0]->retval ?? null;

            // Mengembalikan response dalam format JSON
            return response()->json(['data' => $ambildata]);

        } catch (\Exception $e) {
            // Menangani error dan mengembalikan response dalam format JSON
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
    // {
    //     $dn_no = $request->dn_no;
    //     $job_no = $request->job_no;
    //     $input2 = $request->input2;
    //     $price = explode(",", $input2);

    //     // Menyesuaikan parameter di prosedur
    //     $ekanban_no = $price[0]; // menggantikan 'ekanban_no_i'
    //     $seq = $price[1];        // menggantikan 'seq_i'
    //     $part_no = $price[2];    // menggantikan 'part_no_i'
    //     $item_code = $price[3];  // menggantikan 'item_code_i'
    //     $qty = intval($price[4]); // menggantikan 'qty_i'
    //     $username = Auth::user()->user; // menggantikan 'username_i'
    //     $str_date = '';          // menggantikan 'str_date_i'
    //     $mpname = Carbon::now()->format('m-Y'); // menggantikan 'mpname_i'
    //     $str_kanban_no = '';     // menggantikan 'str_kanban_no_i'
    //     $cust = $price[5];       // menggantikan 'str_user_i'

    //     // Mengatur nilai untuk prosedur tersimpan
    //     $values = [
    //         $ekanban_no,
    //         $dn_no,
    //         $seq,
    //         $part_no,
    //         $qty,
    //         $job_no,
    //         $username,
    //         $item_code,
    //         $cust,
    //         $mpname,
    //         $str_kanban_no,
    //         $str_date
    //     ];

    //     try {
    //         // Eksekusi prosedur tersimpan
    //         $query = DB::connection('ekanban')->select("CALL ekanban_admout_sp_1(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $values);
    //         $ambildata = $query[0]->retval ?? null;

    //         return response()->json(['data' => $ambildata]);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }
    // {
    //     try {
    //         // Data yang akan dikirim ke stored procedure sesuai urutan
    //         $values = [
    //             "ED.0821",                     // dn_no_i
    //             "M94-TCH-10101-00",            // part_no_i
    //             "240815005",                   // kanban_no_i
    //             "",                            // seq_i
    //             "5",                           // qty_i
    //             "1.A01.23.005.2",              // item_code_i
    //             "",                            // uid_i
    //             "26",                          // usercode_i
    //             "",                            // customer_i
    //             "51569-BZ050-00-KZ",           // part_no_cust
    //             "A01",                         // customer_code
    //             "GT-0002",                     // username_i (this parameter might be missing in your query)
    //         ];

    //         // Eksekusi stored procedure dengan 12 parameter
    //         $query = DB::connection('ekanban')->select("CALL ekanban_admout_sp_1(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $values);

    //         // Ambil data hasil output stored procedure (misalnya 'retval' jika ada)
    //         $ambildata = $query[0]->retval ?? null;

    //         // Return response dalam format JSON
    //         return response()->json(['data' => $ambildata]);

    //     } catch (\Exception $e) {
    //         // Tangani error dengan mengembalikan pesan error dalam format JSON
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }
}
