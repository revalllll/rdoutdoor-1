{{-- filepath: resources/views/admin/users/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')
<div class="col-lg-6 mx-auto">
    <h1 class="h4 mb-4">Detail User</h1>
    <div class="mb-3">
        <strong>Nama:</strong> {{ $user->name }}
    </div>
    <div class="mb-3">
        <strong>Email:</strong> {{ $user->email }}
    </div>
    <div class="mb-3">
        <strong>Role:</strong> {{ $user->role ? $user->role->role_name : '-' }}
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection