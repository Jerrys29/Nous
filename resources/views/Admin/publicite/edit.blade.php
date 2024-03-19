@extends('templates.admin')

@section('document')
<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div>
                    <h5 class="modal-title">Modifier</h5>
                    <hr>
                </div>
                <div class="card card-body">
                    <form class="form handleSubmit" action="{{ route('publicites.update', $publicite->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-control-label">Nom de l'entreprise</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nom de la formation" value="{{ $publicite->name}}" required>
                        </div>
                        <div class="form-group">
                            <label for="offre" class="form-control-label">Titre de l'offre</label>
                            <input type="text" class="form-control" id="offre" name="offre" placeholder="Titre de la formation" value="{{ $publicite->offre }}" required>
                        </div>
                        <div class="form-group">
                            <label for="detail" class="form-control-label">Details</label>
                            <textarea class="form-control" id="detail" name="detail" placeholder="Details" required>{{(strip_tags($publicite->detail)) }}</textarea>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="logo" class="form-control-label">Logo de l'entreprise</label>
                                <input type="file" class="form-control" id="logo" name="logo" accept="image/*" placeholder="Logo">
                            </div>
                        </div>
                        <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">
                            Enregistrer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
