<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UserController extends Controller
{
   //Menampilkan halaman awal user
   public function index()
   {
        $activeMenu = 'user'; // set menu yang sedang aktif
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];
        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];
        $level = LevelModel::all(); //ambil data level untuk filter
        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
   }

   // Ambil data user dalam bentuk json untuk datatables
   public function list(Request $request)
   {
       $user = UserModel::select('user_id', 'username', 'nama','foto', 'level_id')
           ->with('level');

        // filter data user berdasarkan level_id
        if ($request->level_id) {
            $user->where('level_id', $request->level_id);
        }

       return DataTables::of($user)
           // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
           ->addIndexColumn()
           ->addColumn('aksi', function ($user) { // menambahkan kolom aksi              
                $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<button onclick="modalAction(\''.url('/user/'. $user->user_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button>';
                $btn .= '<button onclick="modalAction(\''.url('/user/'. $user->user_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button>';
                   
                return $btn;               
           })
           ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
           ->make(true);
   }

    // Menampilkan halaman form tambah user 
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah user baru'
        ];
        $level = LevelModel::all(); // ambil data level untuk ditampilkan di form
        $activeMenu = 'user'; // set menu yang sedang aktif
        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }
    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('user.create_ajax')
            ->with('level', $level);
    }
    // Menyimpan data user baru
    public function store(Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username
            'username'  => 'required|string|min:3|unique:m_user,username',
            'nama'      => 'required|string|max: 100', //nama harus diisi, berupa string, dan maksimal 100 karakter
            'password'  => 'required|min:5', // password harus diisi dan minimal 5 karakter
            'level_id'  => 'required|integer' // level_id harus diisi dan berupa angka
        ]);
        UserModel::create([
            'username'  => $request->username,
            'nama'      => $request->nama,
            'password'  => bcrypt($request->password), // password dienkripsi sebelum disimpan
            'level_id'  => $request->level_id
        ]);
        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    // Menampilkan detail user
    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);
        $breadcrumb = (object) ['title' => 'Detail User', 'list' => ['Home', 'User', 'Detail']];
        $page = (object) ['title' => 'Detail user'];
        $activeMenu = 'user'; // set menu yang sedang aktif
        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit user 
    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            "title" => 'Edit user'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif
        return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit user ajax
    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    // Menyimpan perubahan data user
    public function update(Request $request, string $id)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter,
            // dan bernilai unik di tabel_user kolom username kecuali untuk user dengan id yang sedang diedit
            'username'  => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama'      => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
            'password'  => 'nullable|min:5', // password bisa diisi (minimal 5 karakter) dan bisa tidak diisi
            'level_id'  => 'required|integer' //level_id harus diisi dan berupa angka
        ]);
        UserModel::find($id)->update([
            'username'  => $request->username,
            'nama'      => $request->nama,
            'password'  => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'level_id'  => $request->level_id
        ]);
        return redirect('/user')->with("success", "Data user berhasil diubah");
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id'  => 'required|integer',
                'username'  => 'required|string|min:3|unique:m_user,username',
                'nama'      => 'required|string|max:100',
                'password'  => 'required|min:6',
                'foto'      => 'nullable|mimes:jpeg,png,jpg|max:2408'
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'    => false, // response status, false: error/gagal, true: berhasil
                    'message'   => 'Validasi Gagal',
                    'msgField'  => $validator->errors(), // pesan error validasi
                ]);
            }
            if ($request->has('foto')) {
                $file = $request->file('foto');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $path = 'image/profile/';
                $file->move($path, $filename);
            }
            UserModel::create([
                'username'  => $request->username,
                'nama'      => $request->nama,
                'password'  => bcrypt($request->password),
                'level_id'  => $request->level_id,
                'foto'      => $path . $filename
            ]);
            return response()->json([
                'status'    => true,
                'message'   => 'Data user berhasil disimpan'
            ]);
        }
        redirect('/');
    }
    //Update Ajax
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'nama' => 'required|max:100',
                'password' => 'nullable|min:6|max:20',
                'foto'      => 'nullable|mimes:jpeg,png,jpg|max:2408'

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
            $check = UserModel::find($id);
            if ($check) {
                if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('password');
                }
                if (isset($check->foto)) {
                    $fileold = $check->foto;
                    if (Storage::disk('public')->exists($fileold)) {
                        Storage::disk('public')->delete($fileold);
                    }
                    $file = $request->file('foto');
                    $filename = $check->foto;
                    $path = 'image/profile/';
                    $file->move($path, $filename);
                    $pathname = $filename;
                } else {
                        $file = $request->file('foto');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $path = 'image/profile/';
                        $file->move($path, $filename);
                        $pathname = $path . $filename;
                }
                if (!$request->filled('foto')) { // jika password tidak diisi, maka hapus dari request 
                    $request->request->remove('foto');
                }
                $check->update([
                    'username'  => $request->username,
                    'nama'      => $request->nama,
                    'password'  => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
                    'level_id'  => $request->level_id,
                    'foto'      => $pathname
                ]);
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

    //Confirm Ajax
    public function confirm_ajax(string $id)
    {
        $user = UserModel::find($id);
        return view('user.confirm_ajax', ['user' => $user]);
    }

    //Delete Ajax
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if ($user) {
                $user->delete();
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

    // Menghapus data user 
    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        if (!$check) {      // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }
        try {
            UserModel::destroy($id); // Hapus data level
            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function import() 
    { 
        return view('user.import'); 
    }
    public function import_ajax(Request $request) 
    { 
        if($request->ajax() || $request->wantsJson()){ 
            $rules = [ 
                // validasi file harus xls atau xlsx, max 1MB 
                'file_user' => ['required', 'mimes:xlsx', 'max:1024'] 
            ]; 
 
            $validator = Validator::make($request->all(), $rules); 
            if($validator->fails()){ 
                return response()->json([ 
                    'status' => false, 
                    'message' => 'Validasi Gagal', 
                    'msgField' => $validator->errors() 
                ]); 
            } 
 
            $file = $request->file('file_user');  // ambil file dari request 
 
            $reader = IOFactory::createReader('Xlsx');  // load reader file excel 
            $reader->setReadDataOnly(true);             // hanya membaca data 
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel 
            $sheet = $spreadsheet->getActiveSheet();    // ambil sheet yang aktif 
 
            $data = $sheet->toArray(null, false, true, true);   // ambil data excel 
 
            $insert = []; 
            if(count($data) > 1){ // jika data lebih dari 1 baris 
                foreach ($data as $baris => $value) { 
                    if($baris > 1){ // baris ke 1 adalah header, maka lewati 
                        $insert[] = [ 
                            'level_id' => $value['A'],
                            'username' =>  $value['B'], 
                            'nama' =>  $value['C'],
                            'password' =>  $value['D'],
                            'created_at' => now(), 
                        ]; 
                    } 
                } 
 
                if(count($insert) > 0){ 
                    // insert data ke database, jika data sudah ada, maka diabaikan 
                    UserModel::insertOrIgnore($insert);    
                } 
 
                return response()->json([ 
                    'status' => true, 
                    'message' => 'Data berhasil diimport' 
                ]); 
            }else{ 
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
        //ambil data user yang akan di export
        $user = UserModel::select('level_id', 'username', 'nama', 'password')
            ->orderBy('level_id')
            ->with('level')
            ->get();
        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Username');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Level Pengguna');
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);  //bold header
        $no = 1;    //nomor data dimulai dari 1
        $baris = 2; //baris data dimulai dari baris 2
        foreach ($user as $key => $value){
            $sheet->setCellValue('A'.$baris, $value->username);
            $sheet->setCellValue('B'.$baris, $value->nama);
            $sheet->setCellValue('C'.$baris, $value->level->level_nama);
            $baris++;
            $no++;
        }
        foreach(range('A','C') as $columnID){
            $sheet->getColumnDimension($columnID)->setAutoSize(true);   //set auto size untuk kolom
        }

        $sheet->setTitle('Data User'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data User ' . date('Y-m-d H:i:s') . '.xlsx';
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
    }
    public function export_pdf()
    {
        $user = UserModel::select('level_id', 'username', 'nama', 'password')
        ->orderBy('level_id')
        ->with('level')
        ->get();
        // use Barryvdh\DomPDF\Facade\Pdf
        $pdf = Pdf::loadView('user.export_pdf', ['user' => $user]);
        $pdf->setPaper('a4', 'portrait'); //set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render();
        return $pdf->stream('Data User '.date('Y-m-d H:i:s').'.pdf');
    }


}
