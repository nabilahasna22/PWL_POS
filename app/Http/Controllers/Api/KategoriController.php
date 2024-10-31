<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return KategoriModel::all();
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
        $kategori = KategoriModel::create($request->all());
        return response()->json($kategori,201);
    }
    /**
     * Display the specified resource.
     */
    public function show(KategoriModel $kategori)
    {
        return KategoriModel::find($kategori);
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
    public function update(Request $request, KategoriModel $kategori)
    {
        $kategori->update($request->all());
        return KategoriModel::find($kategori);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriModel $kategori)
    {
        $kategori->delete();
        return response()->json([
            'success'   => true,
            'message'   => 'Data Terhapus',
        ]);
    }
}