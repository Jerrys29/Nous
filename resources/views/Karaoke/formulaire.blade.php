@extends('templates.karaoke')

@section('document')
    <main id="main">
        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container">
                <div class="row" data-aos="fade-up">
                    <div class="col-lg-6 mx-auto">
                        <div class="text-center">
                            VOS INFORMATIONS NE SERONT PAS DIVULGUÉES
                        </div>
                        <form action="{{ route('paiementV', ['id' => $userId]) }}" method="POST" class="p-4 p-md-5 border rounded">
                            @csrf
                            ENREGISTRER VOUS POUR DISCUTER
                            <div class="form-group">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Entrez votre nom complet" required>
                            </div>
                            <div class="form-group">
                                <label for="numero" class="form-label">Numéro</label>
                                <input type="text" name="numero" class="form-control" id="numero" placeholder="Entrez votre numéro" required>
                            </div>
                            <button type="submit" id="submitBtn" class="btn btn-primary">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>
        </section><!-- End Contact Section -->

        
    </main><!-- End #main -->

    
@endsection
