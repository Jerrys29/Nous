@extends('templates.app')

@section('document')
  <h2 style="text-align: center;">Trouver votre Partenanires ici</h2>
  <main id="main">

    <section id="about" class="about">
      <div class="container">
        <div class="row">
          <!-- User Profile Cards -->
          <div class="col-lg-8">
            <div class="row">
              <!-- User Profile Card 1 -->
              
                <div class="col-lg-4 mb-3">
                  <a href="{{('/profil')}}" style="text-decoration: none;color: inherit;cursor: auto;">
                  <div class="card">
                    <img src="assets\img\tabs-3.jpg" class="card-img-top" alt="Profile Image 1">
                    <div class="card-body">
                      <h5 class="card-title">Cathérine</h5>
                      <i class="bi bi-heart"></i>
                      <a href="https://wa.me/1234567890" target="_blank"><i class="bi bi-whatsapp"></i></a>
                    </div>
                  </div>
                </a>
                </div>
              
             

              <!-- User Profile Card 2 -->
         
              <div class="col-lg-4 mb-3">
                <a href="{{('/profil')}}" style="text-decoration: none;color: inherit;cursor: auto;">
                <div class="card">
                  <img src="assets\img\tabs-3.jpg" class="card-img-top" alt="Profile Image 2">
                  <div class="card-body">
                    <h5 class="card-title">Marcelle</h5>
                    <i class="bi bi-heart"></i>
                    <a href="https://wa.me/1234567890" target="_blank"><i class="bi bi-whatsapp"></i></a>
                  </div>
                </div>
              </a>
              </div>
           
              <!-- User Profile Card 3 -->
             
              <div class="col-lg-4 mb-3">
                <a href="{{('/profil')}}" style="text-decoration: none;color: inherit;cursor: auto;">
                <div class="card">
                  <img src="assets\img\tabs-3.jpg" class="card-img-top" alt="Profile Image 3">
                  <div class="card-body">
                    <h5 class="card-title">Elionor</h5>
                    <i class="bi bi-heart"></i>
                    <a href="https://wa.me/1234567890" target="_blank"><i class="bi bi-whatsapp"></i></a>
                  </div>
                </div>
              </a>
              </div>
           
            </div>
          </div>



          <!-- Search Filters Column -->
          <div class="col-lg-4">
            <div class="card fixed-card">
              <div class="card-body">
                <h5 class="card-title">Recherche</h5>
                <!-- Example Filters (Replace with your actual filters) -->
                <div class="form-group">
                  <label for="gender">Genre:</label>
                  <select class="form-control" id="gender">
                    <option value="male">Homme</option>
                    <option value="female">Femme</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="eyeColor">Couleur des yeux:</label>
                  <select class="form-control" id="eyeColor">
                    <option value="blue">Bleu</option>
                    <option value="brown">Marron</option>
                    <!-- Add more eye colors as needed -->
                  </select>
                </div>
                <div class="form-group">
                  <label for="hairColor">Couleur des cheveux:</label>
                  <select class="form-control" id="hairColor">
                    <option value="black">Noir</option>
                    <option value="blonde">Blond</option>
                    <!-- Add more hair colors as needed -->
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


  </main><!-- End #main -->

@endsection