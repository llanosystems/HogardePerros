@extends('layouts.HomeFundacion.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Servicios Veterinarios</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="controles Cont_serviciosVeterinarios">
                        <div>
                            <a class="btn btn-warning" href="#modalsCreateServicios">Nuevo</a>
                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="services">

                        @foreach($servicios as $servicio)

                        <div class="cards">
                            <div class="cards1">
                                <div class="picture">
                                    <img src="{{ asset("storage/$servicio->imagen_servicio") }}" alt="" />
                                </div>
                                <div class="description">
                                    <h1>{{ $servicio->nombre_serviciio }}</h1>
                                    <a style="display: none;">{{ $servicio->id }}</a>
                                    <div class="opcionesAdmin">
                                        <form action="{{ route('Servicios.destroy', $servicio) }}" method="POST">
                                            <a href="#modalsEditServicios{{ $servicio }}"><img
                                                    src="{{ asset('img/Home/edit.png') }}" alt="" /></a>
                                            @csrf
                                            @method('DELETE')
                                            <a><button type="submit" style="background:none; border: none;"><img
                                                        src="{{ asset('img/Home/delete.png') }}" alt="" /></button></a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <tr>
                                <td style="display: none;">{{ $servicio->id }}</td>
                                <td>{{ $servicio->nombre_serviciio }}</td>
                                <td>{{ $servicio->descripcion }}</td>
                                <td><img src="{{ asset("storage/$servicio->imagen_servicio") }}" width="70px" height="70px"></td>
                                <td WIDTH="200px">
                                    <form action="{{ route('Servicios.destroy', $servicio) }}" method="POST">
                                        <a class="btn btn-info" href="{{ route('Servicios.edit', $servicio) }}">Editar</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" >Borrar</button>
                                    </form>
                                </td>
                            </tr> -->
                            @include('HomeFundacion.Servicios.editar')


                        @endforeach

                        @include('HomeFundacion.Servicios.crear')

                        <!-- Centramos la paginación a la derecha-->
                        <div class="pagination justify-content-end">
                            {!! $servicios->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection