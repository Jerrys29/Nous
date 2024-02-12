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
                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-3 text-sm">Oliver Liam</h6>
                                    <span class="mb-2 text-xs">Message: <span class="text-dark font-weight-bold ms-sm-2">Viking Burritooooooooooooooooooooooo
                                            ooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo
                                            oooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo</span></span>

                                </div>
                                <a href="{{route('detail')}}">
                                    <button id="toggleChat" class="btn btn-danger" style="margin-bottom: 40px;margin-top: 40px;">Répondre</button>
                                </a>



                            </li>

                        </ul>
                    </div>



                </div>
            </div>

        </div>
    </div>

</main>
@endsection