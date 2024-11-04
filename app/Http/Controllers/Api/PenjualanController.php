<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Penjualan; // Pastikan Anda telah membuat model Penjualan
use App\Models\PenjualanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class PenjualanController extends Controller
{
    public function __invoke(Request $request)
    {
        $action = $request->get('action', 'index'); // Tentukan action default sebagai 'index'
        switch ($action) {
            case 'index':
                return $this->index();
            case 'store':
                return $this->store($request);
            case 'show':
                return $this->show($request->get('id'));
            case 'update':
                return $this->update($request, $request->get('id'));
            case 'destroy':
                return $this->destroy($request->get('id'));
            default:
                return response()->json(['error' => 'Aksi tidak valid'], 400);
        }
    }
    protected function index()
    {
        $penjualans = PenjualanModel::all();
        return response()->json($penjualans, 200);
    }
    protected function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'           => 'required|integer',
            'pembeli'           => 'required|string|min:3|max:100',
            'penjualan_kode'    => 'required|string|min:3|unique:t_penjualan,penjualan_kode',
            'penjualan_tanggal' => 'required|date',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk gambar
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->hashName();
            $image->move(public_path('images'), $imageName);
        }
        $penjualan = PenjualanModel::create([
            'user_id'           => $request->user_id,
            'pembeli'           => $request->pembeli,
            'penjualan_kode'    => $request->penjualan_kode,
            'penjualan_tanggal' => $request->penjualan_tanggal,
            'image'             => $imageName, // Simpan path gambar
        ]);
        return response()->json([
            'success' => true,
            'data' => $penjualan,
        ], 201);
    }
    protected function show($id)
    {
        $penjualan = PenjualanModel::find($id);
        if (!$penjualan) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
        return response()->json($penjualan, 200);
    }
    protected function update(Request $request, $id)
    {
        $penjualan = PenjualanModel::find($id);
        if (!$penjualan) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
        $validator = Validator::make($request->all(), [
            'user_id'           => 'sometimes|required|integer',
            'pembeli'           => 'sometimes|required|string|min:3|max:100',
            'penjualan_kode'    => 'sometimes|required|string|min:1|unique:t_penjualan,penjualan_kode,' . $penjualan->id,
            'penjualan_tanggal' => 'sometimes|required|date',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if ($request->hasFile('image')) {
            if ($penjualan->image && file_exists(public_path('images/' . $penjualan->image))) {
                unlink(public_path('images/' . $penjualan->image));
            }
            $image = $request->file('image');
            $imageName = $image->hashName();
            $image->move(public_path('images'), $imageName);
            $penjualan->image = $imageName;
        }
        $penjualan->update($request->all());
        return response()->json([
            'success' => true,
            'data' => $penjualan,
        ], 200);
    }
    protected function destroy($id)
    {
        $penjualan = PenjualanModel::find($id);
        if (!$penjualan) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
        if ($penjualan->image && file_exists(public_path('images/' . $penjualan->image))) {
            unlink(public_path('images/' . $penjualan->image));
        }
        $penjualan->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Terhapus',
        ], 200);
    }
}