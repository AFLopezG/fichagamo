<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Unit;
use App\Models\Tipo;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function listTicket(){
        return Ticket::whereDate('created_at','=',date('Y-m-d'))->where('estado','CREADO')->get();
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
    public function store(StoreTicketRequest $request)
    {
        //
        $unit=Unit::where('id','=',$request->unit_id)->first();
        $tipo=Unit::where('id','=',$request->tipo_id)->first();
        
        $num= Ticket::where('unit_id',$request->unit_id)
                ->where('tipo_id',$request->tipo_id)
                ->whereDate('created_at','=',date('Y-m-d'))
                ->count()+1;
        $textnum=str_pad($num, 2, '0', STR_PAD_LEFT);
        $numero=$unit->nombre.'-'.$tipo->codigo.$textnum;
        $ticket=new Ticket();
        $ticket->numero=$numero;
        $ticket->unit_id=$request->unit_id;
        $ticket->tipo_id=$request->tipo_id;
        $ticket->save();
        

        return $ticket;
    }

    public function registrar(Request $request)
    {
        //
        $unit=Unit::where('id',$request->unit_id)->first();
        $tipo=Tipo::where('id',$request->tipo_id)->first();
        
        $num= Ticket::where('unit_id','=',$request->unit_id)
                ->where('tipo_id',$request->tipo_id)
                ->whereDate('created_at','=',date('Y-m-d'))
                ->count()+1;

        $textnum=str_pad($num, 2, '0', STR_PAD_LEFT);
        $numero=$unit->abreviatura.'-'.$tipo->codigo.$textnum;
        $ticket=new Ticket();
        $ticket->numero=$numero;
        $ticket->unit_id=$request->unit_id;
        $ticket->tipo_id=$request->tipo_id;
        $ticket->save();
        
        $tick=Ticket::with('unit')->where('id',$ticket->id)->first();
        return $tick;
    }

    public function transferir(Request $request){
        $ticket=Ticket::find($request->ticket_id);        
        $ticket->estado='CREADO';
        //$ticket->unit_id=$request->unit_id;
        $ticket->user_id=$request->user_id;
        $ticket->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
