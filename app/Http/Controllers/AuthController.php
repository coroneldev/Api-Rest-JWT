<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Persona;
use App\Models\Cargo;
use App\Models\Reparticion;
use Illuminate\Support\Facades\DB;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */

   // public function __construct()
   // {
     //   $this->middleware('auth:api', ['except' => ['login', 'register']]);
    //}


    protected $personas;

    public function __construct(Persona $personas)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->personas = $personas;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function usuario()
    {
        return response()->json(auth()->user());

    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
            $validator->validate(),
            [ 'password' => bcrypt($request->password) ]
        ));

        return response()->json([
            'message' => 'Usuario identificado correctamente',
            'user' => $user
        ], 200);
    }

    /*Servicios*/

    /*Lista Personal*/
    public function listPersonal(Request $request)
    {
        $item = new Persona();
        $objeto = null;
        $objeto = $item->orderBy('id', 'asc')->get();
        $data = array(
            'success' => true,
            'data' => $objeto,
            'msg' => trans('messages.listed')
        );

        return response()->json($data);
    }

    /*Lista Personal Detalle*/
  /*  public function index(Request $request)
    {

        $item = DB::table('Persona')
            ->leftJoin('EstadoCivil', 'Persona.EstadoCivil', '=', 'EstadoCivil.id')
            ->leftJoin('Unidad', 'Persona.Unidad', '=', 'Unidad.id')
            ->select('Persona.*', 'EstadoCivil.EstadoCivil as NEstadoCivil', 'Unidad.Unidad as NUnidad')
            ->where('Persona.id', $request->id)
            ->first();

        $item2 = DB::table('DatosLaborales')
            ->leftJoin('EscalaSalarial', 'DatosLaborales.Puesto', 'EscalaSalarial.id')
            ->leftJoin('Cargo', 'DatosLaborales.Cargo', 'Cargo.id')
            ->leftJoin('Reparticion', 'DatosLaborales.Reparticion', 'Reparticion.id')
            ->leftJoin('TipoContrato', 'DatosLaborales.idTipoContrato', '=', 'TipoContrato.id')
            ->select('DatosLaborales.*', 'EscalaSalarial.Salario', 'Cargo.Cargo as NCargo', 'EscalaSalarial.DenominacionPuesto as NPuesto', 'TipoContrato.TipoContrato as NTipoContrato', 'Reparticion.Reparticion as NReparticion')
            ->where('DatosLaborales.idPersona', $request->id)
            ->first();

        // dd($item2);
        return response()->json([
            'success' => true,
            'data' => $item,
            'lab' => $item2,
            'msg' => trans('messages.listed')
        ]);
    }
*/

    /*Lista Cargos*/
    public function listCargos(Request $request) {
        $item = new Cargo();
        $objeto = null;

        if(isset($request->Unidad)){
            $item=$item->where('Sigla',$request->Unidad);
        }

        $objeto = $item->whereNull('deleted_at')
        ->orderBy('Sigla', 'asc')
        ->orderBy('Cargo', 'asc')
        ->orderBy('Descripcion', 'asc')
        ->get();

        $data = array(
            'success' => true,
            'data' => $objeto,
            'msg' => trans('messages.listed')
        );

        return response()->json($data);
    }

    /*Lista Reparticiones*/

    public function listReparticion(Request $request)
    {
        $item = Reparticion::where('Dependencia_padre_id', 0);
        $objeto = null;

        // if(isset($request->Unidad) && $request->Unidad>0){
        //     $item=$item->where('Unidad',$request->Unidad);
        // }

        $objeto = $item->whereNull('deleted_at')
        ->orderBy('prioridad', 'asc')
        ->get();

        $data = array(
            'success' => true,
            'data' => $objeto,
            'msg' => trans('messages.listed')
        );

        return response()->json($data);
    }

}
