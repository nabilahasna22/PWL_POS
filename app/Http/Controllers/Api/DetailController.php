<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetailController extends Controller
{
    public function __invoke(Request $request)
    {
        $action = $request->get('action', 'index');
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
        $details = DetailModel::all();
        return response()->json($details, 200);
    }

    protected function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penjualan_id' => 'required|integer|exists:t_penjualan,penjualan_id',
            'barang_id'    => 'required|integer|exists:m_barang,barang_id',
            'harga'        => 'required|numeric',
            'jumlah'       => 'required|integer',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk gambar
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

        $detail = DetailModel::create([
            'penjualan_id' => $request->penjualan_id,
            'barang_id'    => $request->barang_id,
            'harga'        => $request->harga,
            'jumlah'       => $request->jumlah,
            'image'        => $imageName, // Simpan path gambar
        ]);

        return response()->json([
            'success' => true,
            'data' => $detail,
        ], 201);
    }

    protected function show($id)
    {
        $detail = DetailModel::find($id);
        if (!$detail) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
        return response()->json($detail, 200);
    }

    protected function update(Request $request, $id)
    {
        $detail = DetailModel::find($id);
        if (!$detail) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'penjualan_id' => 'sometimes|required|integer|exists:t_penjualan,penjualan_id',
            'barang_id'    => 'sometimes|required|integer|exists:m_barang,barang_id',
            'harga'        => 'sometimes|required|numeric',
            'jumlah'       => 'sometimes|required|integer',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('image')) {
            if ($detail->image && file_exists(public_path('images/' . $detail->image))) {
                unlink(public_path('images/' . $detail->image));
            }
            $image = $request->file('image');
            $imageName = $image->hashName();
            $image->move(public_path('images'), $imageName);
            $detail->image = $imageName;
        }

        $detail->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $detail,
        ], 200);
    }

    protected function destroy($id)
    {
        $detail = DetailModel::find($id);
        if (!$detail) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        if ($detail->image && file_exists(public_path('images/' . $detail->image))) {
            unlink(public_path('images/' . $detail->image));
        }

        $detail->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Terhapus',
        ], 200);
    }
}
