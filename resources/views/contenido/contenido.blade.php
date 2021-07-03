@extends('principal')
@section('contenido')

@if(Auth::check())
    @if(Auth::user()->id_rol == 1)
        {{-- Sección Escritorio --}}
        <template v-if="menu==0">
            {{-- <registro></registro> --}}
            <dashboard></dashboard>
        </template>

        {{-- Sección Accesos --}}
        <template v-if="menu==1">
            <user></user>
        </template>
        <template v-if="menu==2">
            <rol></rol>
        </template>

        {{-- Sección Alumnos --}}
        <template v-if="menu==3">
            <alumno></alumno>
        </template>
        <template v-if="menu==4">
            <matricula></matricula>
        </template>

        {{-- Sección Carreras --}}
        <template v-if="menu==5">
            <carrera></carrera>
        </template>

        {{-- Sección Avisos --}}
        <template v-if="menu==6">
            <tabla-avisos></tabla-avisos>
        </template>
        <template v-if="menu==7">
            <aviso></aviso>
        </template>

        {{-- Sección Ayuda --}}
        <template v-if="menu==8">
            <h1>...........................Componente Ayuda</h1>
        </template>

        {{-- Sección Acerca de... --}}
        <template v-if="menu==9">
            <acerca-de></acerca-de>
        </template>

        {{-- Sección Perfil --}}
        <template v-if="menu==10">
            <perfil-usuario></perfil-usuario>
        </template>

    @elseif(Auth::user()->id_rol == 2)
        {{-- Sección Escritorio --}}
        <template v-if="menu==0">
            <dashboard></dashboard>
        </template>

        {{-- Sección Accesos --}}
        <template v-if="menu==1">
            <user></user>
        </template>
        <template v-if="menu==2">
            <rol></rol>
        </template>

        {{-- Sección Alumnos --}}
        <template v-if="menu==3">
            <alumno></alumno>
        </template>
        <template v-if="menu==4">
            <matricula></matricula>
        </template>

        {{-- Sección Avisos --}}
        <template v-if="menu==6">
            <tabla-avisos></tabla-avisos>
        </template>
        <template v-if="menu==7">
            <aviso></aviso>
        </template>

        {{-- Sección Ayuda --}}
        <template v-if="menu==8">
            <h1>...........................Componente Ayuda</h1>
        </template>

        {{-- Sección Acerca de... --}}
        <template v-if="menu==9">
            <acerca-de></acerca-de>
        </template>

        {{-- Sección Perfil --}}
        <template v-if="menu==10">
            <perfil-usuario></perfil-usuario>
        </template>    

    @elseif(Auth::user()->id_rol == 3)
        {{-- Sección Escritorio --}}
        <template v-if="menu==0">
            <dashboard></dashboard>
        </template>

        {{-- Sección Alumnos --}}
        <template v-if="menu==3">
            <alumno></alumno>
        </template>
        <template v-if="menu==4">
            <matricula></matricula>
        </template>

        {{-- Sección Avisos --}}
        <template v-if="menu==6">
            <tabla-avisos></tabla-avisos>
        </template>
        <template v-if="menu==7">
            <aviso></aviso>
        </template>

        {{-- Sección Ayuda --}}
        <template v-if="menu==8">
            <h1>...........................Componente Ayuda</h1>
        </template>

        {{-- Sección Acerca de... --}}
        <template v-if="menu==9">
            <acerca-de></acerca-de>
        </template>

        {{-- Sección Perfil --}}
        <template v-if="menu==10">
            <perfil-usuario></perfil-usuario>
        </template>    

    @elseif(Auth::user()->id_rol == 4)
        {{-- Sección Escritorio --}}
        <template v-if="menu==0">
            <dashboard></dashboard>
        </template>

        {{-- Sección Alumnos --}}
        <template v-if="menu==3">
            <alumno-docente></alumno-docente>
        </template>

        {{-- Sección Avisos --}}
        <template v-if="menu==6">
            <tabla-avisos></tabla-avisos>
        </template>
        <template v-if="menu==7">
            <aviso></aviso>
        </template>

        {{-- Sección Ayuda --}}
        <template v-if="menu==8">
            <h1>...........................Componente Ayuda</h1>
        </template>

        {{-- Sección Acerca de... --}}
        <template v-if="menu==9">
            <acerca-de></acerca-de>
        </template>

        {{-- Sección Perfil --}}
        <template v-if="menu==10">
            <perfil-usuario></perfil-usuario>
        </template>    

    @else 

    @endif
@endif




    
    
@endsection