@extends('principal')
@section('contenido')
    <template v-if="menu==0">
        <registro></registro>
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
        <h1>...........................Componente de la Tabla de Avisos</h1>
    </template>

    <template v-if="menu==7">
        <aviso></aviso>
    </template>

    <template v-if="menu==8">
        <h1>...........................Componente Reporte de Avisos</h1>
    </template>

    <template v-if="menu==9">
        <h1>...........................Componente Ayuda</h1>
    </template>

    <template v-if="menu==10">
        <h1>...........................Componente Acerca de...</h1>
    </template>
    
@endsection