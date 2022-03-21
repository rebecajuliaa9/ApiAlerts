<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Alert;
use App\Http\Requests\StoreAlertRequest;
use App\Http\Requests\UpdateAlertRequest;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alerts =  Alert::orderBy('created_at', 'desc')->get();

        //se alerts não existir
        if(count($alerts) === 0) 
            return response()->json(['message' => 'Você ainda não possui alertas']);

        return response()->json([$alerts], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAlertRequest $request)
    {   
        //to pegando tudo que vem da requisição
        $attribuites = $request->all();
        //crio um alerta com tudo que veio da requisição
        $alert = Alert::create($attribuites);
        //salvo o alerta criado 
        $alert->save();

        //se houver alert ele retorna 
        if($alert)
            return response()->json([
                $alert
            ], 200);
        else
            return responde()->json(['message', 'Não foi possivel criar o alerta'], 500);
            

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $alert =  Alert::where('id', $id)->get();

        //se não houver alerta já retorna a mensagem 
        if(count($alert) === 0)
            return response()->json(['message' => 'Não conseguimos encontrar esse alerta'], 404);
        
        return response()->json([$alert], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAlertRequest $request, $id)
    {
        //to recebendo o que foi enviado na requisição
        $title          =   $request->input('title');
        $description    =   $request->input('description');
        //to buscando as infos do alerta em especifico
        $alert = Alert::find($id);

        //se não houver alerta ele já lanca a mensagem de erro.
        if(!$alert)
            return response()->json(['message' => 'Não foi possivel encontrar esse alerta.'], 404);
        
        //verificar se existe alerta
        if($alert){
            if($title){
                $alert->title = $title;
            }
            if($description){
                $alert->description = $description;
            }
            if($alert->save()){
                return response()->json([$alert], 200);
            }
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
        //busca o alerta com o id
        $alert = Alert::find($id);

        if(!$alert)
            return response()->json([
                'message' => 'Não foi possivel encontrar o alerta'
            ], 404);
        
        $alert->delete();

        return response()->json([
            'message' => 'O alerta foi excluído com sucesso'
        ], 200);
    
    }
}
