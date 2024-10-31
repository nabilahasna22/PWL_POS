<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserModel::all();
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
        $user = UserModel::create($request->all());
        return response()->json($user,201);
    }
    /**
     * Display the specified resource.
     */
    public function show(UserModel $user)
    {
        return UserModel::find($user);
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
    public function update(Request $request, UserModel $user)
    {
        $user->update($request->all());
        return UserModel::find($user);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserModel $user)
    {
        $user->delete();
        return response()->json([
            'success'   => true,
            'message'   => 'Data Terhapus',
        ]);
    }
}