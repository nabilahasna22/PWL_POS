<?php
namespace App\Http\Controllers;
use App\Models\BarangModel;
use App\Models\DetailModel;
use App\Models\PenjualanModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
class DetailController extends Controller
{
    public function index()
    {
        $activeMenu = 'penjualan';
        $breadcrumb = (object) [
            'title' => 'Data Detail Penjualan',
            'list' => ['Home', 'Penjualan']
        ];
        $page = (object) [
            'title' => 'Daftar Detail Penjualan yang terdaftar dalam sistem'
        ];
        $penjualan = PenjualanModel::all();
        $detail = DetailModel::all();
        $barang = BarangModel::all();
        return view('penjualan.detail', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'penjualan' => $penjualan,
            'detail' => $detail,
            'barang' => $barang,
            'page'=> $page
        ]);
    }
    public function list(Request $request)
    {
        $detail = DetailModel::select('detail_id', 'penjualan_id', 'barang_id', 'harga', 'jumlah')
            ->with('barang')
            ->with('penjualan');
        if ($request->barang_id) {
            $detail->where('barang_id', $request->barang_id);
        }
        return DataTables::of($detail)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($detail) { // menambahkan kolom aksi 
                $btn = '<a href="' . url('/detail/' . $detail->detail_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<button onclick="modalAction(\'' . url('/detail/' . $detail->detail_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<a onclick="modalAction(\'' . url('/detail/' . $detail->detail_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/detail/' . $detail->detail_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }
    public function show(string $id)
    {
        $detail = DetailModel::with('barang')->find($id);
        $breadcrumb = (object) ['title' => 'Detail detail', 'list' => ['Home', 'detail', 'Detail']];
        $page = (object) ['title' => 'Detail detail'];
        $activeMenu = 'detail'; // set menu yang sedang aktif
        return view('detail.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'detail' => $detail, 'activeMenu' => $activeMenu]);
    }
    public function create_ajax()
    {
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $penjualan = PenjualanModel::select('penjualan_id', 'penjualan_kode')->get();
        return view('detail.create_ajax')
            ->with('barang', $barang)
            ->with('penjualan', $penjualan);
    }
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_id'  => 'required|integer',
                'barang_id'     => 'required|integer',
                'harga'         => 'required|string|min:3',
                'jumlah'        => 'required|string|min:1'
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            DetailModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data barang berhasil disimpan'
            ]);
        }
        redirect('/');
    }
    public function edit_ajax(string $id)
    {
        $detail = DetailModel::find($id);
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $penjualan = PenjualanModel::select('penjualan_id', 'penjualan_kode')->get();
        return view('detail.edit_ajax', ['detail' => $detail, 'barang' => $barang, 'penjualan' => $penjualan]);
    }
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_id'  => 'required|integer',
                'barang_id'     => 'required|integer',
                'harga'         => 'required|string|min:3',
                'jumlah'        => 'required|string|min:1'
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            $check = DetailModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
    public function confirm_ajax(string $id)
    {
        $detail = DetailModel::find($id);
        return view('detail.confirm_ajax', ['detail' => $detail]);
    }
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $detail = DetailModel::find($id);
            if ($detail) {
                $detail->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
    public function import()
    {
        return view('detail.import');
    }
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_detail' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_detail'); // ambil file dari request
            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
            $data = $sheet->toArray(null, false, true, true); // ambil data excel
            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'penjualan_id'  => $value['A'],
                            'barang_id'     => $value['B'],
                            'harga'         => $value['C'],
                            'jumlah'        => $value['D'],
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    DetailModel::insertOrIgnore($insert);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/');
    }
    public function export_excel()
    {
        // ambil data barang yang akan di export
        $detail = DetailModel::select('detail_id', 'penjualan_id', 'barang_id', 'harga', 'jumlah')
            ->orderBy('detail_id')
            ->with('barang')
            ->get();
        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Penjualan');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Harga');
        $sheet->setCellValue('E1', 'Jumlah');
        $sheet->getStyle('A1:E1')->getFont()->setBold(true); // bold header
        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($detail as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->penjualan->penjualan_kode);
            $sheet->setCellValue('D' . $baris, $value->barang->barang_nama);
            $sheet->setCellValue('C' . $baris, $value->harga);
            $sheet->setCellValue('E' . $baris, $value->jumlah);
            $baris++;
            $no++;
        }
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }
        $sheet->setTitle('Data Detail Penjualan'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data detail Penjualan ' . date('Y-m-d H:i:s') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified:' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer->save('php://output');
        exit;
    } // end function export_excel
    public function export_pdf()
    {
        $detail = DetailModel::select('detail_id', 'penjualan_id', 'barang_id', 'harga', 'jumlah')
            ->orderBy('detail_id')
            ->with('barang')
            ->get();
        $pdf = Pdf::loadView('detail.export_pdf', ['detail' => $detail]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream('Data Detail Penjualan ' . date('Y-m-d H:i:s') . '.pdf');
    }
}