@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('home') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>

    <h1 class="my-4">Lista de Usuários</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Perfil</th>
                <th>Debito</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->debit }}</td>
                    <td>
                        <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Visualizar
                        </a>

                        @can('update', $user)
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                        @endcan

                        @if($user->debit > 0)
                            <form action="{{ route('users.payDebit', $user) }}" method="POST" class="d-inline-block m-0">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-success btn-sm" style="min-width: 110px;">
                                    <i class="bi bi-cash-coin"></i> Quitar Multa
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>
@endsection