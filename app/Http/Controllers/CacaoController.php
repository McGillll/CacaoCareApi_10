<?php

namespace App\Http\Controllers;

use App\Http\Requests\CacaoStoreRequest;
use App\Models\Cacao;

class CacaoController
{
    //Create
    public function store(CacaoStoreRequest $request)
    {
        $path="cacao-photos/";
        $cacao = new Cacao();
        $cacao->label = $request->label;
        $cacao->confidence = $request->confidence;
        switch($cacao->label){
            case 'Healthy Pod': $path = $path."healthy-pod";
                break;
            case 'Black Pod Rot': $path = $path."black-pod";
                break;
            case 'Frosty Pod Rot': $path = $path."frosty-pod";
                break;
        }
        $cacao->photo = $request->file('file')->store($path);
        $cacao->UploaderId = $request->UploaderId;

        $cacao->save();

        return response()->json(['message' => 'Cacao entry created successfully!', 'data' => $cacao], 201);
    }

    //Retrieve
    //getMany
    public function index()
    {
        $cacao = Cacao::all();
        return response()->json([
            'data' => $cacao
        ], 200);
    }

    //getOne
    public function show(string $id)
    {
        $cacao = Cacao::where('id', $id)->first();
        if(!$cacao){
            return response()->json([], 404);
        }
        return response()->json([
            'data' => $cacao
        ],200);
    }

    //Delete
    public function destroy(Cacao $cacao)
    {
        //
    }
}
