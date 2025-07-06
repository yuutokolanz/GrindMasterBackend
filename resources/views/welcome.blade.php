@extends('layouts.public')

@section('content')

<h1 class="title-font mb-4 text-3xl font-medium text-white sm:text-4xl">{{ env('APP_NAME') }}</h1>


<div class="flex justify-center">

    <a class="inline-flex rounded border-0 bg-emerald-500 px-6 py-2 text-lg text-white hover:bg-emerald-600 focus:outline-none"
        href="{{ route('login') }}">Entrar</a>


    <a class="ml-4 inline-flex rounded border-0 bg-gray-600 px-6 py-2 text-lg text-slate-100 hover:bg-gray-200 focus:outline-none"
        href="#">Registre-se</a>

    @endsection