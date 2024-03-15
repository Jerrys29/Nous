@extends('templates.admin')
@section('document')
<main class="main-content position-relative border-radius-lg ">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header pb-0 px-3">
                        <h6 class="mb-0">Conversations</h6>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <ul class="list-group">
                            <ul class="list-group">
                                @foreach($derniersMessages as $message)
                                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-3 text-sm">{{ $message->name_sender }}</h6>
                                        <span class="mb-2 text-xs">Message: <span class="text-dark font-weight-bold ms-sm-2">{{ $message->message }}</span></span>
                                    </div>
                                    <div class="row">
                                        <div class="col-10"></div>
                                        <div class="col-2">
                                            <a href="/detail/{{ $message->name_sender }}/{{ $message->numero }}">
                                                <button class="btn btn-danger">Répondre</button>
                                            </a>

                                        </div>
                                    </div>
                                </li>
                                @endforeach

                            </ul>

                        </ul>
                    </div>



                </div>
            </div>

        </div>
    </div>

</main>
@endsection