<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BarangModel::all();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_id'   => 'required|integer',
            'barang_kode'   => 'required|string|min:3|unique:m_barang,barang_kode',
            'barang_nama'   => 'required|string|max:100', //nama harus diisi, berupa string, dan maksimal 100 karakter
            'harga_beli'    => 'required|integer', //nama harus diisi, berupa string, dan maksimal 100 karakter
            'harga_jual'    => 'required|integer',
            'image'         => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $image = $request->image;
        $barang = BarangModel::create([
            'kategori_id'   => $request->kategori_id,
            'barang_kode'   => $request->barang_kode,
            'barang_nama'   => $request->barang_nama,
            'harga_beli'    => $request->harga_beli,
            'harga_jual'    => $request->harga_jual,
            'image'         => $image->hashName()
        ]);
        if ($barang) {
            return response()->json([
                'success'   => true,
                'barang'      => $barang,
            ],201);
        }
        return response()->json([
            'success'   => false,
        ],409);
    }
    /**
     * Display the specified resource.
     */
    public function show(BarangModel $barang)
    {
        return BarangModel::find($barang);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BarangModel $barang)
    {
        $barang->update($request->all());
        return BarangModel::find($barang);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarangModel $barang)
    {
        $barang->delete();
        return response()->json([
            'success'   => true,
            'message'   => 'Data Terhapus',
        ]);
    }
}