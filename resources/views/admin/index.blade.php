@extends('layouts.app')

@section('title', 'Admin Dashboard')


@section('content')

    <div class="container">
        <h1 class="my-4">Admin Dashboard</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h2 class="my-4">Users</h2>
        <ul class="list-group">
            @foreach ($users as $user)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $user->name }}</strong> - {{ $user->email }}
                    </div>
                    <div>
                        <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        <form action="{{ route('admin.assignRole', $user->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            <div class="input-group">
                                <select name="role" class="form-control form-control-sm" required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary btn-sm">Assign Role</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>

        <h2 class="my-4">Roles</h2>
        <ul class="list-group">
            @foreach ($roles as $role)
                <li class="list-group-item">
                    <strong>{{ $role->name }}</strong>
                    <div class="mt-2">

                        <form action="{{ route('admin.deleteRole', $role->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                    <div class="mt-2">
                        <form action="{{ route('admin.assignPermissionToRole', $role->id) }}" method="POST"
                            class="d-inline-block">
                            @csrf
                            <div class="form-group">
                                <label for="permissions">Assign Permissions:</label>
                                <select name="permissions[]" multiple class="form-control form-control-sm" required>
                                    @foreach ($permissions as $permission)
                                        @if (!$role->hasPermissionTo($permission))
                                            <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Assign Permissions</button>
                        </form>
                    </div>
                    <div class="mt-2">
                        <form action="{{ route('admin.removePermissionFromRole', $role->id) }}" method="POST"
                            class="d-inline-block">
                            @csrf
                            <div class="form-group">
                                <label for="permissions">Remove Permissions:</label>
                                <select name="permissions[]" multiple class="form-control form-control-sm" required>
                                    @foreach ($role->permissions as $permission)
                                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-warning btn-sm">Remove Permissions</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>

        <h2 class="my-4">Create Role</h2>
        <form action="{{ route('admin.createRole') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Role Name" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
