@extends('templates.karaoke')

@section('document')
<main id="main">
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container">
            <div class="row justify-content-center" data-aos="fade-up">
                <div class="col-lg-6">
                    <form action="" method="POST" class="p-4 p-md-5 border rounded">
                        @csrf
                        <h2 class="text-center mb-4">Paiement</h2>
                        <div class="text-center mb-4">
                            <p>Votre paiement est irrécupérable.(1000FCFA)</p>
                        </div>
                        <div class="text-center mb-4">
                            <kkiapay-widget amount="981" key="de9c4e671f1c676a8613e0a567252e182c8fc52c"
                                callback="https://wa.me/{{ $user->numero}}?text=Un%20utilisateur%20de%20l%27espace%20karaok%C3%A9%20vous%20a%20contact%C3%A9." />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section><!-- End Contact Section -->
</main><!-- End #main -->

@endsection
