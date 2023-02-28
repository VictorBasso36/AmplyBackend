<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClienteController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::all();
        return response()->json($clientes);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Verifica se o usuário atual tem permissão para criar clientes
        if (!$request->user()->can_create_clients) {
            return response()->json(['error' => 'Você não tem permissão para criar clientes'], 403);
        }

        // Valida os dados enviados pelo usuário
        $validatedData = $request->validate([
            'domain' => 'required|string|unique:clientes',
            'permissions' => 'required|json',
            'database_name' => 'required|string|unique:clientes',
            'db_host' => 'required|string',
            'db_port' => 'required|integer',
            'db_database' => 'required|string',
            'db_username' => 'required|string',
            'db_password' => 'required|string',
        ]);

        // Cria o novo cliente
        $cliente = Cliente::create([
            'domain' => $validatedData['domain'],
            'permissions' => $validatedData['permissions'],
            'database_name' => $validatedData['database_name'],
            'db_host' => hash('sha256', $validatedData['db_host']),
            'db_port' => hash('sha256', $validatedData['db_port']),
            'db_database' => hash('sha256', $validatedData['db_database']),
            'db_username' => hash('sha256', $validatedData['db_username']),
            'db_password' => hash('sha256', $validatedData['db_password']),
        ]);

        // Retorna a resposta
        return response()->json($cliente, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        // Verifica se o usuário tem permissão para atualizar um cliente
    if (!$request->user()->can_create_clients) {
        return response()->json(['error' => 'Você não tem permissão para atualizar clientes'], 403);
    }

    // Valida os dados recebidos
    $validatedData = $request->validate([
        'domain' => 'required|string|unique:clientes,domain,'.$cliente->id,
        'permissions' => 'required|json',
        'database_name' => 'required|string|unique:clientes,database_name,'.$cliente->id,
        'db_host' => 'required|string',
        'db_port' => 'required|integer',
        'db_database' => 'required|string',
        'db_username' => 'required|string',
        'db_password' => 'required|string',
    ]);

    // Atualiza o registro do cliente no banco de dados
    $cliente->update($validatedData);

    // Retorna a resposta
    return response()->json($cliente, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
