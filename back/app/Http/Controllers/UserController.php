<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Unit;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function login(Request $request)
     {
         $validated = $request->validate([
             'cuenta' => 'required',
             'password' => 'required',
         ]);
         $user = User::with('permisos')->with('units')->where('cuenta', $request->cuenta)->first();
         if ($user) {
             if (Hash::check($request->password, $user->password)) {
                 $user = User::with('permisos')->with('units')->where('cuenta', $request->cuenta)->first();
                 $token = $user->createToken('authToken')->plainTextToken;
                 return response(['user' => $user, 'token' => $token]);
             } else {
                 return response(['message' => 'Contraseña incorrecta'],500);
             }
         } else {
             return response(['message' => 'Usuario no encontrado'],500);
         }
     }
     public function me(Request $request)
     {
         $user=User::with('permisos')
                    ->with('units')
                     ->where('id',$request->user()->id)
                     ->firstOrFail();
                 return $user;
         //return  $request->user();
     }
     public function logout(Request $request)
     {
         $request->user()->tokens()->delete();
         return response(['message' => 'Sesión cerrada']);
     }
     
     public function index(){
        return User::with('units')->with('permisos')->where('id','<>',1)->get();
     }
     
     public function listCaja(Request $request){
        return User::select('id','name','caja')
        ->with('units')
        ->where('state','ACTIVO')
        ->where('id','<>',1)
        ->where('id','<>',$request->user()->id)
        ->whereHas('units')->get();
     }

     public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:6',
        ]);
        $request['password']=Hash::make($request['password']);
        $user->update($request->all());
    }

    public function updatepermisos(Request $request,User $user){
        $permisos= array();
        foreach ($request->permisos as $permiso){
            if ($permiso['estado']==true)
                $permisos[]=$permiso['id'];
        }
        $permiso = Permiso::find($permisos);
        $user->permisos()->detach();
        $user->permisos()->attach($permiso);
    }

    public function updatecajero(Request $request,User $user){
        $unit= array();
        foreach ($request->units as $unit){
            if ($unit['estado']==true)
                $units[]=$unit['id'];
        }
        $unit = Unit::find($units);
        $user->units()->detach();
        $user->units()->attach($unit);
    }
     public function show(User $user){return $user;}
 
     public function store(Request $request)
     {
        $validated = $request->validate([
            'cuenta' => 'required|unique:users',
            'name' => 'required',
            'caja' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'state' => 'required'
        ]);
        $validated['password']=Hash::make($validated['password']);
        $user = User::create($validated);
        $permisos= array();
        foreach ($request->permisos as $permiso){
            if ($permiso['estado']==true)
                $permisos[]=$permiso['id'];
        }
        $permiso = Permiso::find($permisos);
        $user->permisos()->attach($permiso);
        
        $unidades= array();
        foreach ($request->units as $unit){
            if ($unit['estado']==true)
                $unidades[]=$unit['id'];
        }
        $unit = Permiso::find($unidades);
        $user->units()->attach($unit);
        return($user);
     }

    public function cambioEstado($id){
        $user=User::find($id);
        if($user->state=='ACTIVO')
            $user->state='INACTIVO';
        else
            $user->state='ACTIVO';
        $user->save();
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required',
            'cuenta' => 'required',
            'caja' => 'required',
        ]);
        $user->update($validated);
        return response(['user' => $user]);
    }


     public function destroy(User $user)
     {
        $user->delete();
        return response(['message' => 'Usuario eliminado']);
     }

     public function atender(Request $request){
        $user=User::with('units')->where('id',$request->user()->id)->first();
        $units=[];
        foreach ($user->units as $value) {
            # code...
            array_push($units,$value['id']);
        }
        //return $units;
        /*$ticket=Ticket::where('estado','=','CREADO')
            ->whereIN('unit_id',$units)
            ->whereDate('updated_at',date('Y-m-d'))
            ->orderBy('id','asc')
            ->first();*/
            $ticketsWithUser = Ticket::where('tickets.estado', 'CREADO')
            ->whereIn('unit_id', $units)
            ->whereDate('tickets.updated_at', date('Y-m-d'))
            ->whereNotNull('tickets.user_id') // Solo donde user_id no es null
            ->join('tipos', 'tickets.tipo_id', '=', 'tipos.id')
            ->orderBy('tipos.orden', 'asc')   
            ->orderBy('tickets.id', 'asc')
            ->select('tickets.*');
        
        // Consulta para los tickets donde user_id es null
        $ticketsWithoutUser = Ticket::where('tickets.estado', 'CREADO')
            ->whereIn('unit_id', $units)
            ->whereDate('tickets.updated_at', date('Y-m-d'))
            ->whereNull('tickets.user_id') // Solo donde user_id es null
            ->join('tipos', 'tickets.tipo_id', '=', 'tipos.id')
            ->orderBy('tipos.orden', 'asc')   
            ->orderBy('tickets.id', 'asc')
            ->select('tickets.*');
        
        // Unir ambas consultas
        $ticket = $ticketsWithUser->union($ticketsWithoutUser)
            ->first();
        //return $ticket;
//        return $ticket->numero;
   // return $ticket;
        if(isset($ticket)){
        $ticket=Ticket::find($ticket->id);
        $ticket->estado='ATENDIDO';
        $ticket->empleado=$request->nombrecaja;
        $ticket->user_id=$request->user()->id;
        $ticket->save();
        return $ticket;
    }

//        return "a";
    }

    public function ultificha(Request $request){
        $user=User::with('units')->where('id',$request->user()->id)->first();
        $units=[];
        foreach ($user->units as $value) {
            # code...
            array_push($units,$value['id']);
        }
        $ticket=Ticket::where('estado','=','ATENDIDO')
            ->whereDate('updated_at',date('Y-m-d'))
            ->whereIN('unit_id',$units)
            ->orderBy('updated_at','desc')
            ->first();
        //return $ticket;
        if(isset($ticket)){
            return Ticket::find($ticket->id);
        }
    }

    public function datosatender(Request $request){
        return Ticket::where('user_id','=',$request->user()->id)
            ->where('estado','ATENDIDO')
            ->whereDate('updated_at','=',date('Y-m-d'))
            ->orderBy('updated_at','desc')
            ->get();
    }
 }
 
