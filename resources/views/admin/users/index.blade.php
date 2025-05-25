{{-- filepath: resources/views/admin/users/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'User')

@section('content')
<h1 class="h4 mb-3">Daftar User</h1>
<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role ? $user->role->role_name : '-' }}</td>
                <td>
                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">Belum ada user.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection