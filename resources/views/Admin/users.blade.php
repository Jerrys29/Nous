@extends('templates.admin')
@section('document')
  <main class="main-content position-relative border-radius-lg ">
    
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Visiteurs Karaoke</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-20">Nom Complet</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-20 ps-2">Numéro</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-20 ps-2">Date & heure visite</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-20">Provenance</th>

                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $user->numero }}</p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $user->created_at }}</p>
                        </td>
                       
                       
                        <td class="align-middle text-center text-sm">
                            <p class="text-xs font-weight-bold mb-0">{{ $user->role }}</p>
                        </td>
                    
                    </tr>
                @endforeach
            </tbody>
        </table>
              </div>
            </div>
          </div>
        </div>
      </div>
   
    
    </div>
  </main>
  <script>
        var inactivityTimeout = 30 * 60 * 1000;

        var timeout;

        function resetTimer() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
              window.location.href = "{{ route('login') }}";
            }, inactivityTimeout);
        }

        document.addEventListener('mousemove', resetTimer);
        document.addEventListener('keypress', resetTimer);
        document.addEventListener('scroll', resetTimer);

        resetTimer(); // Initialise le minuteur lors du chargement de la page
    </script>
 
  
@endsection