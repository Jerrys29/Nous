<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Mot de passe oublié</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #f0f0f0; /* Une couleur de fond pour mieux voir le centrage */
    }
    .subscribe {
      position: relative;
      height: 140px;
      width: 290pxpx;
      padding: 20px;
      background-color: #FFF;
      border-radius: 4px;
      color: #333;
      box-shadow: 0px 0px 60px 5px rgba(0, 0, 0, 0.4);
    }
    .subscribe:after {
      position: absolute;
      content: "";
      right: -10px;
      bottom: 18px;
      width: 0;
      height: 0;
      border-left: 0px solid transparent;
      border-right: 10px solid transparent;
      border-bottom: 10px solid #1a044e;
    }
    .subscribe p {
      text-align: center;
      font-size: 20px;
      font-weight: bold;
      letter-spacing: 4px;
      line-height: 28px;
    }
    .subscribe input {
      position: absolute;
      bottom: 30px;
      border: none;
      border-bottom: 1px solid #d4d4d4;
      padding: 10px;
      width: 82%;
      background: transparent;
      transition: all .25s ease;
    }
    .subscribe input:focus {
      outline: none;
      border-bottom: 1px solid #0d095e;
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', 'sans-serif';
    }
    .subscribe .submit-btn {
      position: absolute;
      border-radius: 30px;
      border-bottom-right-radius: 0;
      border-top-right-radius: 0;
      background-color: #2009f0;
      color: #FFF;
      padding: 12px 25px;
      display: inline-block;
      font-size: 12px;
      font-weight: bold;
      letter-spacing: 5px;
      right: -10px;
      bottom: -20px;
      cursor: pointer;
      transition: all .25s ease;
      box-shadow: -5px 6px 20px 0px rgba(26, 26, 26, 0.4);
    }
    .subscribe .submit-btn:hover {
      background-color: #1d08da;
      box-shadow: -5px 6px 20px 0px rgba(88, 88, 88, 0.569);
    }
  </style>
</head>
<body>
  <form  method="get" action="{{route('check')}}" >
    @csrf
  <div class="subscribe">
    <p>Mot de passe oublié ? </p>
    <div>
        <label for="numero"> <h4>Entrez votre numéro d'inscription</h4></label>
    </div>
    <input placeholder="Numéro whatsapp " class="subscribe-input" name="numero" id="numero" type="tel" >
    <br>
    {{-- <div class="submit-btn">Enrégistrer</div>  --}}
    <button type="submit" class="submit-btn"> Valider</button>
  </div>
</form>
</body>
</html>
