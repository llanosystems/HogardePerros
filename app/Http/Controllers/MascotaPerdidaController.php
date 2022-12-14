<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Especie;
use App\Models\Estado;
use App\Models\MascotaPerdida;
use App\Models\Mascota;
use App\Models\Raza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MascotaPerdidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $MascotasPerdidas = MascotaPerdida::paginate(6);
        $razas = Raza::all();
        $colores = Color::all();
        $especies = Especie::all();
        $estados = Estado::all();
        return view('HomeFundacion.MascotasPerdidas.index', compact('MascotasPerdidas', 'razas', 'colores', 'especies', 'estados'));
    }

    public function indexEncuentrameCliente()
    {
        $MascotasPerdidas = Mascota::paginate(12);
        $colores = Color::all();
        $especies = Especie::all();
        $razas = Raza::all();
        $estados = Estado::all();
        return view('Home.Encuentrame', compact('MascotasPerdidas', 'colores', 'especies','razas','estados'));
    }

    public function publicacionUsuario()
    {
        $id_user = auth()->user()->id;
        $MascotasPerdidas = MascotaPerdida::where('id_user', 'like', "%$id_user%")->paginate(5);
        $colores = Color::all();
        $especies = Especie::all();
        $razas = Raza::all();
        $estados = Estado::all();
        return view('Home.PublicacionesEncuentrame', compact('MascotasPerdidas', 'colores', 'especies','razas','estados' ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $razas = Raza::all();
        $colores = Color::all();
        $especies = Especie::all();
        return view('HomeFundacion.MascotasPerdidas.crear', compact('razas', 'colores', 'especies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validaciendo de los campos enviados desde la vista crear
        request()->validate([
            'nombre_mascota' => 'required',
            'descripcion' => 'required',
            'raza' => 'required',
            'color' => 'required',
            'tamanio' => 'required',
            'especie' => 'required',
            'imagen_mascota' => 'required',
        ]);
        $profileImage = time() . '.' . $request->file('imagen_mascota')->getClientOriginalExtension();
        Storage::disk('public')->put($profileImage,file_get_contents($request->file('imagen_mascota')->getPathName()) );
        $mascota = new MascotaPerdida();
        $mascota->nombre_mascota = request()->nombre_mascota;
        $mascota->descripcion = request()->descripcion;
        $mascota->raza = request()->raza;
        $mascota->color = request()->color;
        $mascota->estado = 4;
        $mascota->tamanio = request()->tamanio;
        $mascota->especie = request()->especie;
        $mascota->imagen_mascota = $profileImage;
        $mascota->id_user = Auth::user()->id;
        $mascota->save();
        return redirect()->route('MascotasPerdidas.index');
    }

    public function storeUsuario(Request $request)
    {
        //Validaciendo de los campos enviados desde la vista crear
        request()->validate([
            'nombre_mascota' => 'required',
            'descripcion' => 'required',
            'raza' => 'required',
            'color' => 'required',
            'tamanio' => 'required',
            'especie' => 'required',
            'imagen_mascota' => 'required',
        ]);
        $profileImage = time() . '.' . $request->file('imagen_mascota')->getClientOriginalExtension();
        Storage::disk('public')->put($profileImage,file_get_contents($request->file('imagen_mascota')->getPathName()) );
        $mascota = new MascotaPerdida();
        $mascota->nombre_mascota = request()->nombre_mascota;
        $mascota->descripcion = request()->descripcion;
        $mascota->raza = request()->raza;
        $mascota->color = request()->color;
        $mascota->estado = 4;
        $mascota->tamanio = request()->tamanio;
        $mascota->especie = request()->especie;
        $mascota->imagen_mascota = $profileImage;
        $mascota->id_user = Auth::user()->id;
        $mascota->save();
        return redirect()->route('Publicaciones');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MascotaPerdida  $mascotaPerdida
     * @return \Illuminate\Http\Response
     */
    public function show(MascotaPerdida $mascotaPerdida)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MascotaPerdida  $mascotaPerdida
     * @return \Illuminate\Http\Response
     */
    public function edit(MascotaPerdida $MascotasPerdida)
    {
        $razas = Raza::all();
        $colores = Color::all();
        $estados = Estado::all();
        $especies = Especie::all();

        return view('HomeFundacion.MascotasPerdidas.editar', compact('MascotasPerdida', 'razas', 'colores', 'estados', 'especies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MascotaPerdida  $mascotaPerdida
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MascotaPerdida $MascotasPerdida)
    {
        //Validaciendo de los campos enviados desde la vista crear
        request()->validate([
            'nombre_mascota' => 'required',
            'descripcion' => 'required',
            'raza' => 'required',
            'color' => 'required',
            'tamanio' => 'required',
            'especie' => 'required',
        ]);
        //Recibiendo un archivo de tipo imagen y tranformadolo en una ruta para as?? guardarlo en la base de datos
        if ($request->has('imagen_mascota')){
            $profileImage = time() . '.' . $request->file('imagen_mascota')->getClientOriginalExtension();
            Storage::disk('public')->put($profileImage,file_get_contents($request->file('imagen_mascota')->getPathName()) );
            $MascotasPerdida->imagen_mascota = $profileImage;
        }
        //operador ternario, siempre preguntar?? si le llega algo de ese dato, de ser as?? reemplacelo, sino, deje el anterior
        $MascotasPerdida->nombre_mascota = $request->has('nombre_mascota') ?  $request->nombre_mascota : $MascotasPerdida->nombre_mascota;
        $MascotasPerdida->descripcion = $request->has('descripcion') ?  $request->descripcion : $MascotasPerdida->descripcion;
        $MascotasPerdida->raza = $request->has('raza') ?  $request->raza : $MascotasPerdida->raza;
        $MascotasPerdida->color = $request->has('color') ?  $request->color : $MascotasPerdida->color;
        $MascotasPerdida->estado = $request->has('estado') ?  $request->estado : $MascotasPerdida->estado;
        $MascotasPerdida->tamanio = $request->has('tamanio') ?  $request->tamanio : $MascotasPerdida->tamanio;
        $MascotasPerdida->especie = $request->has('especie') ?  $request->especie : $MascotasPerdida->especie;
        $MascotasPerdida->save();

        return redirect()->route('MascotasPerdidas.index');
    }

    public function updateUsuario(Request $request)
    {
        $MascotasPerdida = MascotaPerdida::find($request->mascot);
        //Validaciendo de los campos enviados desde la vista crear
        request()->validate([
            'nombre_mascota' => 'required',
            'descripcion' => 'required',
            'raza' => 'required',
            'color' => 'required',
            'tamanio' => 'required',
            'especie' => 'required',
        ]);
        //Recibiendo un archivo de tipo imagen y tranformadolo en una ruta para as?? guardarlo en la base de datos
        if ($request->has('imagen_mascota')){
            $profileImage = time() . '.' . $request->file('imagen_mascota')->getClientOriginalExtension();
            Storage::disk('public')->put($profileImage,file_get_contents($request->file('imagen_mascota')->getPathName()) );
            $MascotasPerdida->imagen_mascota = $profileImage;
        }
        //operador ternario, siempre preguntar?? si le llega algo de ese dato, de ser as?? reemplacelo, sino, deje el anterior
        $MascotasPerdida->nombre_mascota = $request->has('nombre_mascota') ?  $request->nombre_mascota : $MascotasPerdida->nombre_mascota;
        $MascotasPerdida->descripcion = $request->has('descripcion') ?  $request->descripcion : $MascotasPerdida->descripcion;
        $MascotasPerdida->raza = $request->has('raza') ?  $request->raza : $MascotasPerdida->raza;
        $MascotasPerdida->color = $request->has('color') ?  $request->color : $MascotasPerdida->color;
        $MascotasPerdida->estado = $request->has('estado') ?  $request->estado : $MascotasPerdida->estado;
        $MascotasPerdida->tamanio = $request->has('tamanio') ?  $request->tamanio : $MascotasPerdida->tamanio;
        $MascotasPerdida->especie = $request->has('especie') ?  $request->especie : $MascotasPerdida->especie;
        $MascotasPerdida->save();

        return redirect()->route('Publicaciones');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MascotaPerdida  $mascotaPerdida
     * @return \Illuminate\Http\Response
     */
    public function destroy(MascotaPerdida $MascotasPerdida)
    {
        $MascotasPerdida->delete();
        return redirect()->route('MascotasPerdidas.index');
    }

    public function destroyUsuario(Request $request)
    {
        $MascotasPerdida = MascotaPerdida::find($request->mascot);
        $MascotasPerdida->delete();
        return redirect()->route('Publicaciones');
    }

    public function search(Request $request)
    {
        $especie = $request->especie;
        $raza = $request->raza;
        $color = $request->color;
        $tama??o = $request->tama??o;

        //trae todas las mascotas
        if ($especie == '0' && $raza == '0' && $color == '0' && $tama??o == '0') {
            $result = MascotaPerdida::JoinRazaColor()->paginate(12);
        }
        //filtra las Mascotas Perdidas solo por especie
        if ($especie != '0' && $raza == '0' && $color == '0' && $tama??o == '0') {
            $result = MascotaPerdida::JoinRazaColor()->Especie($especie)->paginate(12);
        }
        //filtra las Mascotas Perdidas solo por color
        if ($especie == '0' && $raza == '0' && $color != '0' && $tama??o == '0') {
            $result = MascotaPerdida::JoinRazaColor()->Color($color)->paginate(12);
        }
        //filtra las Mascotas Perdidas solo por tama??o
        if ($especie == '0' && $raza == '0' && $color == '0' && $tama??o != '0') {
            $result = MascotaPerdida::JoinRazaColor()->Tama??o($tama??o)->paginate(12);
        }
        //filtra las Mascotas Perdidas por especie y raza
        if ($especie != '0' && $raza != '0' && $color == '0' && $tama??o == '0') {
            $result = MascotaPerdida::JoinRazaColor()->Especie($especie)->Raza($raza)->paginate(12);
        }
        //filtra las Mascotas Perdidas por especie y color
        if ($especie != '0' && $raza == '0' && $color != '0' && $tama??o == '0') {
            $result = MascotaPerdida::JoinRazaColor()->Especie($especie)->Color($color)->paginate(12);
        }
        //filtra las Mascotas Perdidas por especie y tama??o
        if ($especie != '0' && $raza == '0' && $color == '0' && $tama??o != '0') {
            $result = MascotaPerdida::JoinRazaColor()->Especie($especie)->Tama??o($tama??o)->paginate(12);
        }
        //filtra las Mascotas Perdidas por color y tama??o
        if ($especie == '0' && $raza == '0' && $color != '0' && $tama??o != '0') {
            $result = MascotaPerdida::JoinRazaColor()->where('color', 'like', "%$raza%")->Tama??o($tama??o)->paginate(12);
        }
        //filtra las Mascotas Perdidas por especie,raza y color
        if ($especie != '0' && $raza != '0' && $color != '0' && $tama??o == '0') {
            $result = MascotaPerdida::JoinRazaColor()->Especie($especie)->Raza($raza)->Color($color)->paginate(12);
        }
        //filtra las Mascotas Perdidas por especie,raza y tama??o
        if ($especie != '0' && $raza != '0' && $color == '0' && $tama??o != '0') {
            $result = MascotaPerdida::JoinRazaColor()->Especie($especie)->Raza($raza)->Tama??o($tama??o)->paginate(12);
        }
        //filtra las Mascotas Perdidas por especie,color y tama??o
        if ($especie != '0' && $raza == '0' && $color != '0' && $tama??o != '0') {
            $result = MascotaPerdida::JoinRazaColor()->Especie($especie)->Color($color)->Tama??o($tama??o)->paginate(12);
        }
        //filtra las Mascotas Perdidas por especie,raza,color y tama??o
        if ($especie != '0' && $raza != '0' && $color != '0' && $tama??o != '0') {
            $result = MascotaPerdida::JoinRazaColor()->Especie($especie)->Raza($raza)->Color($color)->Tama??o($tama??o)->paginate(12);
        }

        return response()->json($result);
    }

}
