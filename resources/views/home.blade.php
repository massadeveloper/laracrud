@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row ">

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Genera Component</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="namespacemodel">Namespace Model</label>
                            <input type="text" class="form-control" id="namespacemodel" name="namespacemodel" aria-describedby="nome del model">
                            <small id="emailHelp" class="form-text text-muted">Genera Namespace per il model.</small>
                        </div>

                        <div class="form-group">
                            <label for="nomemodel">Nome Model</label>
                            <input type="text" class="form-control" id="nomemodel" name="nomemodel" aria-describedby="nome del model">
                            <small id="emailHelp" class="form-text text-muted">Genera model.</small>
                        </div>

                        <div class="form-group">
                            <label for="nomemodel"><b>Nome Tabella nel DB</b></label>
                            <input type="text" class="form-control" id="nometabelladb" name="nometabelladb" aria-describedby="nome della tbl nel DB">
                            <small id="emailHelp" class="form-text text-muted">Nome della tabella nel DB.</small>
                        </div>

                        <div class="form-group">
                            <label for="namespacecontroller">Namespace Controller</label>
                            <input type="text" class="form-control" id="namespacecontroller" name="namespacecontroller" aria-describedby="namespace per il controller">
                            <small id="emailHelp" class="form-text text-muted">Genera classi/controller e component con return json.</small>
                        </div>
                        <div class="form-group">
                            <label for="nomecontroller">Nome Controller</label>
                            <input type="text" class="form-control" id="nomecontroller" name="nomecontroller" aria-describedby="nome controller">
                            <small id="emailHelp" class="form-text text-muted">Genera classi/controller e component con return json.</small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">Genera</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
