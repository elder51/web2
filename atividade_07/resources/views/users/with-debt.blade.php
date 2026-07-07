@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('home') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>

    <h1 class="my-4">Usuários com Multa</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($users->isEmpty())
        <div class="alert alert-info">
            Nenhum usuário com multa pendente.
        </div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Multa</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>R$ {{ number_format($user->debit, 2, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i> Visualizar
                            </a>

                            @can('payDebit', $user)
                                <form action="{{ route('users.payDebit', $user) }}" method="POST" class="d-inline-block m-0">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-success btn-sm" style="min-width: 110px;">
                                        <i class="bi bi-cash-coin"></i> Quitar Multa
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
