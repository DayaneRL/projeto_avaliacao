<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\{Hash, Storage, Auth};
use App\Models\UserHeader;
use App\Services\HeaderService;
use App\Http\Requests\HeaderRequest;

class HeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $headers = UserHeader::all();
        return view('headers.index', compact('headers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('headers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HeaderRequest $request)
    {
        try{
            DB::beginTransaction();

            $request->validated();
            $header = HeaderService::storeHeader(
                $request,
                Auth::user()
            );

            DB::commit();
            return redirect()->route('headers.index')->with('success', "Cabeçalho cadastrado com sucesso" );

        }catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput($request->input())->with('warning', "Algo deu errado" );;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('headers.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $header = UserHeader::findOrFail($id);
        return view('headers.create', compact('header'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HeaderRequest $request, $id)
    {
        try{
            DB::beginTransaction();
            $header = UserHeader::findOrFail($id);
            $request->validated();
            $update = HeaderService::updateHeader(
                $request,
                $header
            );

            DB::commit();
            return redirect()->route('headers.index')->with('success', "Cabeçalho atualizado com sucesso" );

        }catch (\Throwable $e) {
            return $e->getMessage();
            DB::rollBack();
            return back()->withInput($request->input())->with('warning', "Algo deu errado" );;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $header = UserHeader::findOrFail($id);
            HeaderService::deleteHeader($header);
            DB::commit();
            return response()->json([
                'msg'  => 'Cabeçalho excluída com sucesso!'
            ], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'msg'  => 'Não foi possível excluir o cabeçalho.'
            ], 500);
        }
    }

    public function find($id){
        try{
            $header = UserHeader::findOrFail($id);
            $header['date'] =  $header->created_at->format('d/m/Y');

            return response()->json([
                'header'      => $header,
            ], 200);
        }catch (\Exception $ex) {
            return response()->json([
                'data'  => 'Algo deu errado.'
            ], 500);
        }
    }

    public function updateLogo(Request $request){
        try{
            $header = UserHeader::findOrFail($request['id']);
            HeaderService::updateOnlyLogo($request['logo'], $header);

            return response()->json([
                'header'      => $header,
            ], 200);
        }catch (\Exception $ex) {
            return response()->json([
                'data'  => 'Algo deu errado.'
            ], 500);
        }
    }
}
