@extends('templates.karaoke')

@section('document')
<main id="main">
  <section id="about" class="about">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="row">
            @foreach ($users as $user)
            <div class="col-lg-4 mb-3">
              <a href="{{ url('/Karaokeprofils/' . $user->id) }}" style="text-decoration: none; color: inherit; cursor: auto;">
                <div class="card">
                  <div style="width: 100%; height: 200px; overflow: hidden;">
                    <img src="{{ asset('storage/' . $user->photo1) }}" class="card-img-top" style="object-fit: cover; width: 100%; height: 100%;" alt="Profile Image {{ $user->id }}">
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">{{ $user->pseudo }}</h5>
                    <div class="like-container">
                      @if (auth()->user() && auth()->user()->paiement == 0)
                       <a href="{{ url('/visiteur/' . $user->id) }}" target="_blank">
                        <button type="button" class="btn btn-success">
                        <i class="bi bi-whatsapp whatsapp-icon launch"></i> Discuter
                        </button>
                      </a> 
                      <div class="modal fade" id="staticBackdrop" data-backdrop="false" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <!-- ... (rest of your modal code) ... -->
                      </div>
                      @else
                       <a href="{{ url('/visiteur/' . $user->id) }}" target="_blank">
                        <button type="button" class="btn btn-success">
                        <i class="bi bi-whatsapp whatsapp-icon launch"></i> Discuter
                        </button>
                      </a> 
                      @endif
                    </div>
                  </div>
                </div>
              </a>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
