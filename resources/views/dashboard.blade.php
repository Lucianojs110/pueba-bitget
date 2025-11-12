@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    <div class="space-y-6">
        <div class="bg-white border rounded-lg shadow-sm p-6">
            <h1 class="text-2xl font-semibold text-[#0a2d6b] mb-4">
                Bienvenido, {{ auth()->user()->name }} 👋
            </h1>
            <p>Este es tu panel principal de </p>
            <p class="mt-2 text-gray-600 text-sm">
                Desde aquí vas a poder gestionar tu cuenta Bidget
            </p>
            </p>
        </div>

    </div>
@endsection
