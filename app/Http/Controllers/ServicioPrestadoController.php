<?php

namespace App\Http\Controllers;

use App\Models\ServicioPrestado;
use Illuminate\Http\Request;

class ServicioPrestadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('HomeFundacion.ServiciosPrestados.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServicioPrestado  $servicioPrestado
     * @return \Illuminate\Http\Response
     */
    public function show(ServicioPrestado $servicioPrestado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServicioPrestado  $servicioPrestado
     * @return \Illuminate\Http\Response
     */
    public function edit(ServicioPrestado $servicioPrestado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServicioPrestado  $servicioPrestado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServicioPrestado $servicioPrestado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServicioPrestado  $servicioPrestado
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServicioPrestado $servicioPrestado)
    {
        //
    }
}
