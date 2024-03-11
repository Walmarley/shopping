<?php

namespace App\Http\Controllers;

use App\Models\Shopping;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($shoppingId)
    {
        if (Auth::id() != Shopping::find($shoppingId)->user_id){
            return response()->json(['message' => 'Usuario Não autorizado'], 401);
        }

        $stores = Store::where('shopping_id', $shoppingId)->get();

        return view('store.listStore', ['shopping_id'=>$shoppingId, 'stores'=>$stores]);
        
        return response()->json(['data' => $stores]);
    }

    public function routeAddStore($shoppingId)
    {
        return view('store.addStore', ['shopping_id' => $shoppingId]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $shoppingId)
    {
        if (Auth::id() != Shopping::find($shoppingId)->user_id){
            return response()->json(['message' => 'Usuario Não autorizado'], 401);
        }

        $shopping = Shopping::find($shoppingId);

        $data = $request->only([
            'nome',
            'RazaoSocial',
            'CNPJ',
            'endereco',
            'classificacao',
            'responsavel',
            'numeroDaLoja',
        ]);
        $data['shopping_id'] = $shopping->id;

        $validador = Validator::make($request->all(), [
            'nome' => 'required|max:30',
            'RazaoSocial' => 'required|max:30',
            'CNPJ' => 'required|max:15',
            'endereco' => 'required|max:90',
            'classificacao' => 'required|max:30',
            'responsavel' => 'required|max:30',
            'numeroDaLoja' => 'required|max:10',
        ]);

        if($validador->fails()){
            return response()->json(['message' => $validador->messages()]);
        }

        Store::create($data);

        return redirect(route('Shoppings.index'));
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $store = Store::find($id);
        $shopping = Shopping::find($store->shopping_id);

        if (Auth::id() != $shopping->user_id){
            return response()->json(['message' => 'Usuario Não autorizado'], 401);
        }

        return response()->json(['message' => $store]);
    }


    public function routeEditStore($shoppingId)
    {
        return view('store.editStore', ['shopping_id' => $shoppingId]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $store = Store::find($id);
        $shopping = Shopping::find($store->shopping_id);

        if (Auth::id() != $shopping->user_id){
            return response()->json(['message' => 'Usuario Não autorizado'], 401);
        }

        $data = $request->only([
            'nome',
            'RazaoSocial',
            'CNPJ',
            'endereco',
            'classificacao',
            'responsavel',
            'numeroDaLoja',
        ]);

        $validador = Validator::make($request->all(), [
            'nome' => 'required|max:30',
            'RazaoSocial' => 'required|max:30',
            'CNPJ' => 'required|max:15',
            'endereco' => 'required|max:90',
            'classificacao' => 'required|max:30',
            'responsavel' => 'required|max:30',
            'numeroDaLoja' => 'required|max:10',
        ]);

        if($validador->fails()){
            return response()->json(['message' => $validador->messages()]);
        }

        Store::find($id)->update($data);

        return redirect(route('shoppings.index'));

        return response()->json(['message' => 'A Loja foi atualizada!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stores = Store::find($id);
        $shopping = Shopping::find($stores->shopping_id);

        if (Auth::id() != $shopping->user_id){
            return response()->json(['message' => 'Usuario Não autorizado'], 401);
        }
        
        Store::find($id)->delete();

        return redirect(route('shoppings.index'));

    }
}
