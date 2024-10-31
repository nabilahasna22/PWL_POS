<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use Illuminate\Http\Request;
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
        $barang = BarangModel::create($request->all());
        return response()->json($barang,201);
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