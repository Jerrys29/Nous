  @extends('templates.admin')
@section('document')
  <main class="main-content position-relative border-radius-lg ">
   
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Comptes des utilisateurs Karaoke</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nom Complet</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Numéro</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pseudo</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ville</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Etat</th>
                    <th class="text-secondary opacity-7">Actions</th>
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
                            <p class="text-xs font-weight-bold mb-0">{{ $user->pseudo }}</p>
                        </td>
                        <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">{{ $user->town }}</span>
                        </td>
                        <td class="align-middle text-center text-sm">
                            <span class="badge badge-sm {{ $user->active ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
                                {{ $user->active ? 'Activé' : 'Désactivé' }}
                            </span>
                        </td>
                        <td class="align-middle">
                            <form method="post" action="{{ route('block.user', ['id' => $user->id, 'redirect' => 'KaraokeUsers']) }}">
                                @csrf
                                @method('POST')
                                @if($user->active)
                                    <button type="submit" class="btn btn-danger btn-sm">Bloquer</button>
                                @else
                                    <button type="button" class="btn btn-danger btn-sm" disabled>Bloquer</button>
                                @endif
                            </form>
                            <form method="post" action="{{ route('unblock.user', ['id' => $user->id, 'redirect' => 'KaraokeUsers']) }}">
                                @csrf
                                @method('POST')
                                @if(!$user->active)
                                    <button type="submit" class="btn btn-success btn-sm">Débloquer</button>
                                @else
                                    <button type="button" class="btn btn-success btn-sm" disabled>Débloquer</button>
                                @endif
                            </form>
                            <form id="delete-form-{{ $user->id }}" method="post" action="{{ route('delete.user', ['id' => $user->id, 'redirect' => 'KaraokeUsers']) }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="button" class="btn btn-primary btn-sm" onclick="confirmDelete({{ $user->id }})">Supprimer</button>
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
    <script>
            function confirmDelete(userId) {
                if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) {
                    document.getElementById('delete-form-' + userId).submit();
                }
            }
    </script>


@endsection