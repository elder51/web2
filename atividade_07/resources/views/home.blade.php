@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <a href="{{ route('books.index') }}" class="btn btn-outline-primary d-flex flex-column justify-content-center align-items-center w-100 p-4" style="min-height: 140px;">
                                <i class="bi bi-book fs-2 mb-2"></i>
                                <span>Livros</span>
                            </a>
                        </div>

                        <div class="col-6 col-md-4">
                            <a href="{{ route('authors.index') }}" class="btn btn-outline-success d-flex flex-column justify-content-center align-items-center w-100 p-4" style="min-height: 140px;">
                                <i class="bi bi-person-badge fs-2 mb-2"></i>
                                <span>Autores</span>
                            </a>
                        </div>

                        <div class="col-6 col-md-4">
                            <a href="{{ route('categories.index') }}" class="btn btn-outline-warning d-flex flex-column justify-content-center align-items-center w-100 p-4" style="min-height: 140px;">
                                <i class="bi bi-tag fs-2 mb-2"></i>
                                <span>Categorias</span>
                            </a>
                        </div>

                        <div class="col-6 col-md-4">
                            <a href="{{ route('publishers.index') }}" class="btn btn-outline-info d-flex flex-column justify-content-center align-items-center w-100 p-4" style="min-height: 140px;">
                                <i class="bi bi-building fs-2 mb-2"></i>
                                <span>Editoras</span>
                            </a>
                        </div>

                        @can('payDebit', Auth::user())
                            <div class="col-6 col-md-4">
                                <a href="{{ route('users.withDebt') }}" class="btn btn-outline-danger d-flex flex-column justify-content-center align-items-center w-100 p-4" style="min-height: 140px;">
                                    <i class="bi bi-cash-coin fs-2 mb-2"></i>
                                    <span>Com Multa</span>
                                </a>
                            </div>
                        @endcan

                        @can('update', Auth::user())
                            <div class="col-6 col-md-4">
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary d-flex flex-column justify-content-center align-items-center w-100 p-4" style="min-height: 140px;">
                                    <i class="bi bi-people fs-2 mb-2"></i>
                                    <span>Usuários</span>
                                </a>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
