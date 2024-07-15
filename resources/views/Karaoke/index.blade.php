@extends('templates.karaoke')

@section('document')
<main id="main">
  <section id="about" class="about">
    <div class="container">
      <div class="row">
        @foreach ($users as $user)
          <div class="col-lg-3 mb-4">
            <a href="{{ url('/Karaokeprofils/' . $user->id) }}" style="text-decoration: none; color: inherit;">
              <div class="card h-100 custom-card d-flex justify-content-center align-items-center">
                <div style="width: 100%; height: 18rem; overflow: hidden;">
                  <!-- Vérifie les cinq champs de photos et affiche la première photo valide -->
                  @if ($user->photo1 && Storage::disk('public')->exists($user->photo1))
                    <img src="{{ asset('storage/' . $user->photo1) }}" class="card-img-top" style="object-fit: cover; width: 100%; height: 100%;" alt="Profile Image {{ $user->id }}">
                  @elseif ($user->photo2 && Storage::disk('public')->exists($user->photo2))
                    <img src="{{ asset('storage/' . $user->photo2) }}" class="card-img-top" style="object-fit: cover; width: 100%; height: 100%;" alt="Profile Image {{ $user->id }}">
                  @elseif ($user->photo3 && Storage::disk('public')->exists($user->photo3))
                    <img src="{{ asset('storage/' . $user->photo3) }}" class="card-img-top" style="object-fit: cover; width: 100%; height: 100%;" alt="Profile Image {{ $user->id }}">
                  @elseif ($user->photo4 && Storage::disk('public')->exists($user->photo4))
                    <img src="{{ asset('storage/' . $user->photo4) }}" class="card-img-top" style="object-fit: cover; width: 100%; height: 100%;" alt="Profile Image {{ $user->id }}">
                  @elseif ($user->photo5 && Storage::disk('public')->exists($user->photo5))
                    <img src="{{ asset('storage/' . $user->photo5) }}" class="card-img-top" style="object-fit: cover; width: 100%; height: 100%;" alt="Profile Image {{ $user->id }}">
                  @else
                    <!-- Icône d'utilisateur par défaut si aucune photo n'est trouvée -->
                    <i class="bi bi-person-fill" style="font-size: 15rem;"></i>
                  @endif
                </div>
                <div class="card-body text-center">
                  <h5 class="card-title">{{ $user->pseudo }}</h5>
                  <!-- Affiche la ville de l'utilisateur -->
                  <p class="card-text">{{ $user->town }}</p>
                  <div class="like-container">
                    @if (auth()->user() && auth()->user()->paiement == 0)
                      <a href="{{ url('/visiteur/' . $user->id) }}" target="_blank">
                        <button type="button" class="btn btn-success">
                          <i class="bi bi-whatsapp whatsapp-icon launch"></i> Discuter
                        </button>
                      </a> 
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
  </section>
</main>
<style>
  /* Custom CSS for cards */
.custom-card {
  border: 1px solid #dee2e6;
  border-radius: 10px;
  transition: transform 0.3s ease-in-out;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.custom-card:hover {
  transform: translateY(-5px);
}

.custom-card .card-img-top {
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}

.custom-card .card-title {
  font-size: 18px;
  margin-bottom: 10px;
}

.custom-card .card-text {
  font-size: 14px;
  color: #6c757d;
  margin-bottom: 10px;
}

.custom-card .btn {
  width: 100%;
}
</style>

@endsection