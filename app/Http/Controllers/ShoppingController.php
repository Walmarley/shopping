<?php

namespace App\Http\Controllers;

use App\Models\Shopping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $shoppings = Shopping::all()->where('user_id', $user->id);

        return view('shoppings.listShopping')->with('shoppings', $shoppings);
    }

    public function routeAddShopping()
    {
        return view('shopping.addShopping');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'nome',
            'RazaoSocial',
            'CNPJ',
            'endereco',
        ]);
        $data['user_id'] = Auth::user()->id;

        $validador = Validator::make($request->all(),[
            'nome' => 'required|max:20',
            'RazaoSocial' => 'required|max:20',
            'CNPJ' => 'required|min:4',
            'endereco' => 'required|max:20',
        ]);

        if($validador->fails()){
            return response()->json(['message' => $validador->messages()]);
        }

        Shopping::create($data);

        return redirect(route('shoppings.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::id() != Shopping::find($id)->user_id){
            return response()->json(['message' => 'Usuario Não autorizado'], 401);
        }

        $shopping = Shopping::find($id);

        return response()->json(['data'=> $shopping]);
    }

    public function routeEditShopping()
    {
        return view('shoppings.editShopping');
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
        $data = $request->only([
            'nome',
            'RazaoSocial',
            'CNPJ',
            'endereco',
        ]);

        $validador = Validator::make($request->all(),[
            'nome' => 'required|max:20',
            'RazaoSocial' => 'required|max:20',
            'CNPJ' => 'required|min:4',
            'endereco' => 'required|max:20',
        ]);

        if($validador->fails()){
            return response()->json(['message' => $validador->messages()]);
        }

        Shopping::find($id)->update($data);

        return response()->json(['message' => 'Shopping ' .$request->model. ' cadastrado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::id() != Shopping::find($id)->user_id){
            return response()->json(['message' => 'Usuario Não autorizado'], 401);
        }

        Shopping::find($id)->delete();

        return redirect(route('shoppings.index'));
    }
}
