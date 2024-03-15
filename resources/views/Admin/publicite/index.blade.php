@extends('templates.admin')

@section('document')
<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 mb-4 d-flex align-items-center justify-content-between flex-wrap">
                        <h6>Publicité</h6>
                        <div class="buttons d-flex align-items-center">
                            <form action="{{ route('searchpub') }}" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control mx-2" placeholder="Rechercher">
                                <button class="btn btn-primary my-0 me-2" type="submit">
                                    <i class="fa fa-search me-2"></i>
                                    Filter
                                </button>
                            </form>
                            <a class="btn btn-success my-0" href="{{ route('publicite.create.view') }}">
                                <i class="fa fa-plus me-2"></i>
                                Ajouter
                            </a>
                        </div>



                    </div>
                    <div class="card-body px-2 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Nom de l'entreprise</th>
                                        <th>Titre</th>
                                        <th>Details</th>
                                        <th>Statut</th>
                                        <th>Créé le</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($publicites as $publicite)
                                    <tr>
                                        <td>{{ $publicite->name }}</td>
                                        <td>{{ Str::limit($publicite->offre, 20) }}</td>
                                        <td>{{ Str::limit($publicite->detail, 20) }}</td>

                                        <td>    
                                            <span class="badge bg-gradient-{{ $publicite->statut == 1 ? 'success' : 'danger' }}">
                                                {{ $publicite->statut == 1 ? 'Actif' : 'Inactif' }}
                                            </span>
                                        </td>

                                        <td>{{ $publicite->created_at }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">

                                                <a class="btn p-2 d-flex align-items-center me-1" href="{{ route('publicites.edit', $publicite->id) }}" title="Modifier">
                                                    <i class="fa fa-edit text-primary cursor-pointer"></i>
                                                </a>
                                                <form action="{{ route('publicites.toggle', $publicite->id) }}" method="post">
                                                    @csrf
                                                    <button class="btn p-2 d-flex align-items-center me-1" type="submit" data-bs-toggle="tooltip" title="{{ $publicite->statut == '1' ? 'Désactiver' : 'Activer' }}">
                                                        <i class="fa {{ $publicite->statut == '1' ? 'fa-times' : 'fa-check' }} text-{{ $publicite->statut == '1' ? 'danger' : 'success' }} cursor-pointer"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Aucune publicité n'a été enregistrée.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection