@extends('layouts.app')

@section('title', 'Perfil de usuario')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="bg-white border rounded-lg shadow-sm p-6">
            <livewire:profile.update-profile-information-form />
        </div>

        <div class="bg-white border rounded-lg shadow-sm p-6">
            <livewire:profile.update-password-form />
        </div>

        <div class="bg-white border rounded-lg shadow-sm p-6">
            <livewire:profile.delete-user-form />
        </div>
    </div>
@endsection
