@extends('principal')
@section('contenido')
    <template v-if="menu==0">
        {{-- <acerca-de></acerca-de> --}}
        <dashboard></dashboard>
    </template>

    <template v-if="menu==1">
        <user></user>
    </template>

    <template v-if="menu==2">
        <rol></rol>
    </template>

    <template v-if="menu==3">
        <alumno></alumno>
    </template>

    <template v-if="menu==4">
        <matricula></matricula>
    </template>

    <template v-if="menu==5">
        <carrera></carrera>
    </template>

    <template v-if="menu==6">
        <tabla-avisos></tabla-avisos>
    </template>

    <template v-if="menu==7">
        <aviso></aviso>
    </template>

    <template v-if="menu==8">
        <h1>...........................Componente Ayuda</h1>
    </template>

    <template v-if="menu==9">
        <acerca-de></acerca-de>
    </template>

    <template v-if="menu==10">
        <perfil-usuario></perfil-usuario>
    </template>
    
@endsection