<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Especie;
use App\Models\Estado;
use App\Models\Fundacion;
use App\Models\Mascota;
use App\Models\Raza;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MascotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAdopcionCliente()
    {
        $Mascotas = Mascota::paginate(12);
        $Colores = Color::all();
        $Especies = Especie::all();
        return view('Home.Adopcion', compact('Mascotas', 'Colores', 'Especies'));
    }

    public function indexHome()
    {
        $Mascotas = Mascota::inRandomOrder()->limit(6)->get();
        return view('welcome', compact('Mascotas'));
    }

    public function index()
    {
        $mascotas = Mascota::paginate(6);
        $razas = Raza::all();
        $colores = Color::all();
        $especies = Especie::all();
        $estados = Estado::all();
        return view('HomeFundacion.Mascotas.index', compact('mascotas', 'razas', 'colores', 'especies', 'estados'));
    }

    public function indexFiltro(Request $request)
    {
        $mascotaurl = $request->mascota;
        if($mascotaurl == 0){
            $mascotas = Mascota::paginate(6);
        }
        if($mascotaurl == 1){
            $mascotas = Mascota::where('especie', 'like', "1")->paginate(6);
        }
        if($mascotaurl == 2){
            $mascotas = Mascota::where('especie', 'like', "2")->paginate(6);
        }

        $razas = Raza::all();
        $colores = Color::all();
        $especies = Especie::all();
        $estados = Estado::all();
        return view('HomeFundacion.Mascotas.index', compact('mascotas', 'razas', 'colores', 'especies', 'estados'));
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
        return view('HomeFundacion.Mascotas.crear', compact('razas', 'colores', 'especies'));
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
            'edad' => 'required',
            'imagen_mascota' => 'required',
        ]);
        $profileImage = time() . '.' . $request->file('imagen_mascota')->getClientOriginalExtension();
        Storage::disk('public')->put($profileImage,file_get_contents($request->file('imagen_mascota')->getPathName()) );
        $mascota = new Mascota();
        $mascota->nombre_mascota = request()->nombre_mascota;
        $mascota->descripcion = request()->descripcion;
        $mascota->raza = request()->raza;
        $mascota->color = request()->color;
        $mascota->estado = 2;
        $mascota->tamanio = request()->tamanio;
        $mascota->especie = request()->especie;
        $mascota->edad = request()->edad;
        $mascota->imagen_mascota = $profileImage;
        $mascota->id_fundacion = 1;
        $mascota->save();
        return redirect()->route('Mascotas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mascota  $mascota
     * @return \Illuminate\Http\Response
     */
    public function show(Mascota $mascota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mascota  $mascota
     * @return \Illuminate\Http\Response
     */
    public function edit(Mascota $Mascota)
    {
        $razas = Raza::all();
        $colores = Color::all();
        $estados = Estado::all();
        $especies = Especie::all();

        return view('HomeFundacion.Mascotas.editar', compact('Mascota', 'razas', 'colores', 'estados', 'especies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mascota  $mascota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mascota $Mascota)
    {
        //Validaciendo de los campos enviados desde la vista crear
        request()->validate([
            'nombre_mascota' => 'required',
            'descripcion' => 'required',
            'raza' => 'required',
            'color' => 'required',
            'tamanio' => 'required',
            'especie' => 'required',
            'edad' => 'required',
            'estado' => 'required'
        ]);
        //Recibiendo un archivo de tipo imagen y tranformadolo en una ruta para as?? guardarlo en la base de datos
        if ($request->has('imagen_mascota')){
            $profileImage = time() . '.' . $request->file('imagen_mascota')->getClientOriginalExtension();
            Storage::disk('public')->put($profileImage,file_get_contents($request->file('imagen_mascota')->getPathName()) );
            $Mascota->imagen_mascota = $profileImage;
        }
        //operador ternario, siempre preguntar?? si le llega algo de ese dato, de ser as?? reemplacelo, sino, deje el anterior
        $Mascota->nombre_mascota = $request->has('nombre_mascota') ?  $request->nombre_mascota : $Mascota->nombre_mascota;
        $Mascota->descripcion = $request->has('descripcion') ?  $request->descripcion : $Mascota->descripcion;
        $Mascota->raza = $request->has('raza') ?  $request->raza : $Mascota->raza;
        $Mascota->color = $request->has('color') ?  $request->color : $Mascota->color;
        $Mascota->estado = $request->has('estado') ?  $request->estado : $Mascota->estado;
        $Mascota->tamanio = $request->has('tamanio') ?  $request->tamanio : $Mascota->tamanio;
        $Mascota->especie = $request->has('especie') ?  $request->especie : $Mascota->especie;
        $Mascota->edad = $request->has('edad') ?  $request->edad : $Mascota->edad;
        //$mascota->id_fundacion = $request->has('id_fundacion') ?  $request->id_fundacion : $mascota->id_fundacion;
        $Mascota->save();

        return redirect()->route('Mascotas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mascota  $mascota
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mascota $Mascota)
    {
        $Mascota->delete();
        return redirect()->route('Mascotas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mascota  $mascota
     * @return \Illuminate\Http\Response
     */
    public function chageLogo(Request $request)
    {
        $profileImage = time() . '.' . $request->file('logo_fundacion')->getClientOriginalExtension();
        Storage::disk('public')->put($profileImage,file_get_contents($request->file('logo_fundacion')->getPathName()));
        Fundacion::where('id', Auth::user()->id_fundacion)->update(['logo' => $profileImage]);

        return redirect()->route('fundacion.home');
    }

    public function search(Request $request)
    {
        $especie = $request->especie;
        $raza = $request->raza;
        $color = $request->color;
        $tama??o = $request->tama??o;
        $edad = $request->edad;
        //trae todas las mascotas
        if ($especie == '0' && $raza == '0' && $color == '0' && $tama??o == '0' && $edad == '0') {
            $result = Mascota::JoinRazaColor()->paginate(12);
        }
        //filtra las mascotas solo por especie
        if ($especie != '0' && $raza == '0' && $color == '0' && $tama??o == '0' && $edad == '0') {
            $result = Mascota::JoinRazaColor()->Especie($especie)->paginate(12);
        }
        //filtra las mascotas solo por color
        if ($especie == '0' && $raza == '0' && $color != '0' && $tama??o == '0' && $edad == '0') {
            $result = Mascota::JoinRazaColor()->Color($color)->paginate(12);
        }
        //filtra las mascotas solo por tama??o
        if ($especie == '0' && $raza == '0' && $color == '0' && $tama??o != '0' && $edad == '0') {
            $result = Mascota::JoinRazaColor()->Tama??o($tama??o)->paginate(12);
        }
        //filtra las mascotas solo por edad
        if ($especie == '0' && $raza == '0' && $color == '0' && $tama??o == '0' && $edad != '0') {
            $result = Mascota::JoinRazaColor()->Edad($edad)->paginate(12);
        }
        //filtra las mascotas por especie y raza
        if ($especie != '0' && $raza != '0' && $color == '0' && $tama??o == '0' && $edad == '0') {
            $result = Mascota::JoinRazaColor()->Especie($especie)->Raza($raza)->paginate(12);
        }
        //filtra las mascotas por especie y color
        if ($especie != '0' && $raza == '0' && $color != '0' && $tama??o == '0' && $edad == '0') {
            $result = Mascota::JoinRazaColor()->Especie($especie)->Color($color)->paginate(12);
        }
        //filtra las mascotas por especie y tama??o
        if ($especie != '0' && $raza == '0' && $color == '0' && $tama??o != '0' && $edad == '0') {
            $result = Mascota::JoinRazaColor()->Especie($especie)->Tama??o($tama??o)->paginate(12);
        }
        //filtra las mascotas por especie y edad
        if ($especie != '0' && $raza == '0' && $color == '0' && $tama??o == '0' && $edad != '0') {
            $result = Mascota::JoinRazaColor()->Especie($especie)->Edad($edad)->paginate(12);
        }
        //filtra las mascotas por color y tama??o
        if ($especie == '0' && $raza == '0' && $color != '0' && $tama??o != '0' && $edad == '0') {
            $result = Mascota::JoinRazaColor()->Color($color)->Tama??o($tama??o)->paginate(12);
        }
        //filtra las mascotas por color y edad
        if ($especie == '0' && $raza == '0' && $color != '0' && $tama??o == '0' && $edad != '0') {
            $result = Mascota::JoinRazaColor()->Color($color)->Edad($edad)->paginate(12);
        }
        //filtra las mascotas por tama??o y edad
        if ($especie == '0' && $raza == '0' && $color == '0' && $tama??o != '0' && $edad != '0') {
            $result = Mascota::JoinRazaColor()->Tama??o($tama??o)->Edad($edad)->paginate(12);
        }
        //filtra las mascotas por especie,raza y color
        if ($especie != '0' && $raza != '0' && $color != '0' && $tama??o == '0' && $edad == '0') {
            $result = Mascota::JoinRazaColor()->Especie($especie)->Raza($raza)->Color($color)->paginate(12);
        }
        //filtra las mascotas por especie,raza y tama??o
        if ($especie != '0' && $raza != '0' && $color == '0' && $tama??o != '0' && $edad == '0') {
            $result = Mascota::JoinRazaColor()->Especie($especie)->Raza($raza)->Tama??o($tama??o)->paginate(12);
        }
        //filtra las mascotas por especie,raza y edad
        if ($especie != '0' && $raza != '0' && $color == '0' && $tama??o == '0' && $edad != '0') {
            $result = Mascota::JoinRazaColor()->Especie($especie)->Raza($raza)->Edad($edad)->paginate(12);
        }
        //filtra las mascotas por especie,color y tama??o
        if ($especie != '0' && $raza == '0' && $color != '0' && $tama??o != '0' && $edad == '0') {
            $result = Mascota::JoinRazaColor()->Especie($especie)->Color($color)->Tama??o($tama??o)->paginate(12);
        }
        //filtra las mascotas por especie,color y edad
        if ($especie != '0' && $raza == '0' && $color != '0' && $tama??o == '0' && $edad != '0') {
            $result = Mascota::JoinRazaColor()->Especie($especie)->Color($color)->Edad($edad)->paginate(12);
        }
        //filtra las mascotas por especie,tama??o y edad
        if ($especie != '0' && $raza == '0' && $color == '0' && $tama??o != '0' && $edad != '0') {
            $result = Mascota::JoinRazaColor()->Especie($especie)->Tama??o($tama??o)->Edad($edad)->paginate(12);
        }
        //filtra las mascotas por color,tama??o y edad
        if ($especie == '0' && $raza == '0' && $color != '0' && $tama??o != '0' && $edad != '0') {
            $result = Mascota::JoinRazaColor()->Color($color)->Tama??o($tama??o)->Edad($edad)->paginate(12);
        }
        //filtra las mascotas por especie,raza,color y tama??o
        if ($especie != '0' && $raza != '0' && $color != '0' && $tama??o != '0' && $edad == '0') {
            $result = Mascota::JoinRazaColor()->Especie($especie)->Raza($raza)->Color($color)->Tama??o($tama??o)->paginate(12);
        }
        //filtra las mascotas por especie,raza,color y edad
        if ($especie != '0' && $raza != '0' && $color != '0' && $tama??o != '0' && $edad == '0') {
            $result = Mascota::JoinRazaColor()->Especie($especie)->Raza($raza)->Color($color)->Edad($edad)->paginate(12);
        }
        //filtra las mascotas por especie,raza,tama??o y edad
        if ($especie != '0' && $raza != '0' && $color != '0' && $tama??o != '0' && $edad == '0') {
            $result = Mascota::JoinRazaColor()->Especie($especie)->Raza($raza)->Tama??o($tama??o)->Edad($edad)->paginate(12);
        }
        //filtra las mascotas por especie,raza,color,tama??o y edad
        if ($especie != '0' && $raza != '0' && $color != '0' && $tama??o != '0' && $edad != '0') {
            $result = Mascota::JoinRazaColor()->Especie($especie)->Raza($raza)->Color($color)->Tama??o($tama??o)->Edad($edad)->paginate(12);
        }
        return response()->json($result);
}
}
