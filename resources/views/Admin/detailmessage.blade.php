@extends('templates.admin')
@section('document')
<section class="chatbox">
    <div class="container d-flex justify-content-center">
        <div class="card mt-5">
            <div class="d-flex flex-row justify-content-between p-3 adiv text-white">
                <i class="fas fa-chevron-left"></i>
                <span class="pb-3">Répondre...</span>
                <i class="fas fa-times"></i>
            </div>
            <div class="conversation overflow-auto" id="conversation">
                @foreach($sortedMessages as $message)
                <div class="d-flex flex-row p-3">
                    @if($message instanceof \App\Models\Discussion)
                    <img src="https://img.icons8.com/color/48/000000/circled-user-female-skin-type-7.png" width="30" height="30">
                    <div class="chat ml-2 p-3">{{ $message->message }}</div>
                    @elseif($message instanceof \App\Models\Reponse)
                    <div class="bg-white mr-2 p-3"><span class="text-muted">{{ $message->contenu }}</span></div>
                    <img src="https://img.icons8.com/color/48/000000/circled-user-male-skin-type-7.png" width="30" height="30">
                    @endif
                </div>
                @endforeach
            </div>

            <div class="form-group px-3 ">
                <form class="chat-input" id="chat-form" action="{{ route('envoyerMessage') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_discussion" value="{{ $dernierMessage->id }}">
                    <textarea class="form-control" rows="5" placeholder="Type your message" id="message" name="contenu" required></textarea>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        // Mettre à jour la conversation toutes les 5 secondes (5000 millisecondes)
        setInterval(updateConversation, 5000);

        $('#chat-form').submit(function(event) {
            event.preventDefault();

            var message = $('#message').val();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: {
                    _token: $('input[name="_token"]').val(),
                    message: message
                },
                success: function(response) {
                    // Réinitialiser le champ de message après l'envoi
                    $('#message').val('');

                    // Si vous souhaitez mettre à jour la conversation après l'envoi du message,
                    // vous pouvez appeler la fonction updateConversation() ici aussi
                    // updateConversation();
                },
                error: function(xhr, status, error) {
                    // Gérer les erreurs
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#chat-form').submit(function(event) {
            event.preventDefault();

            var message = $('#message').val();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: {
                    _token: $('input[name="_token"]').val(),
                    message: message
                },
                success: function(response) {
                    // Gérer la réponse si nécessaire
                },
                error: function(xhr, status, error) {
                    // Gérer les erreurs
                }
            });
        });
    });
</script>


<style>
    .card {
        width: 800px;
        height: 500px;
        border: none;
        border-radius: 15px;
    }

    .adiv {
        background: #04CB28;
        border-radius: 15px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        font-size: 12px;
        height: 46px;
    }

    .chat {
        border: none;
        background: #E2FFE8;
        font-size: 10px;
        border-radius: 20px;
    }

    .bg-white {
        border: 1px solid #E7E7E9;
        font-size: 10px;
        border-radius: 20px;
    }

    .myvideo img {
        border-radius: 20px
    }

    .dot {
        font-weight: bold;
    }

    .form-control {
        border-radius: 12px;
        border: 1px solid #F0F0F0;
        font-size: 8px;
    }

    .form-control:focus {
        box-shadow: none;
    }

    .form-control::placeholder {
        font-size: 8px;
        color: #C4C4C4;
    }
</style>

@endsection