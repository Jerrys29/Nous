    @extends('templates.app')

    @section('document')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    
                    <div class="card-header">
                        <h2>Formulaire d'Avis Clients</h2>
                        <p>Nous serions ravis de connaître votre avis pour nous aider à améliorer notre service !</p>
                    </div>

                    <hr style="margin-top: 0; margin-bottom: 1rem;">

                    <div class="card-body">
                    @if(session('success'))
				<div id="alert-message" class="alert alert-success">
					{{ session('success') }}
				</div>
			@endif
                        <form method="POST" action="{{ route('avis.save') }}">
                            @csrf

                            <div class="form-group" style="margin-bottom: 5rem;">
                                <label for="name">Nom complet</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="form-group" style="margin-bottom: 5rem;">
                                <label for="phone">Numéro de téléphone</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>

                            <div class="form-group">
                                <label for="comment">Votre avis</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Envoyer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

         //Mon code JavaScript pour masquer le message après 15 secondes
    setTimeout(function(){
        document.getElementById('alert-message').style.display = 'none';
    }, 5000);
    </script>
    @endsection
