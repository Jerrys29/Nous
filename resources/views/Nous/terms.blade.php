@extends('templates.app')

@section('document')
<main id="main">

  <div class="container">
    <div class="row topspace">
      <div class="col-sm-8 col-sm-offset-2">

        <article class="">
          <header class="entry-header">

            <h1 class="entry-title"><a href="single.html" rel="bookmark"><b>Règle de confidentialité</b></a></h1>
          </header>
          <h2>Collecte des données</h2>
          <div class="entry-content">
            <p style="text-align: justify;">

              NOUS recueille des données personnelles pendant <a href="{{('register')}}">l'inscription</a> de l'utilisateur ou lorsque ce dernier fournit ces informations de sa propre initiative.
              Chaque utilisateur s'engage à communiquer des informations exactes et à les mettre à jour.
              NOUS prend toutes les mesures propres à assurer la protection, l'intégrité et la confidentialité des données à caractère personnel que NOUS détient et traite.
              Certaines données communiquées par les utilisateurs de leur propre initiative peuvent notamment permettre d'identifier leur origine ethnique, leur nationalité, leur religion et/ou leurs orientations sexuelles.
              En fournissant son orientation sexuelle, nécessaire au fonctionnement du service, et en acceptant les conditions générales, l'utilisateur concerné donne son consentement exprès et spécifique en vue du traitement et de l'utilisation de ces données par
              NOUS pour la durée et pour les finalités définies.
              De même, en fournissant des photos de soi-même, chaque utilisateur donne son consentement exprès et spécifique en vue de l'utilisation de ses photos par NOUS pour la durée et pour les finalités définies.
              NOUS se réserve la possibilité d'enregistrer, à chaque fois que l'utilisateur se connecte au site ou fait appel à ses services, des informations telles que l'URL, l'adresse IP, le type et la langue du navigateur, ainsi que la date et l'heure de la connexion, ce qui est expressément accepté par l'utilisateur.
            </p>
            <p style="text-align: justify;">
              Les photos et toutes autres données personnelles communiquées par les utilisateurs et recueillies par NOUS peuvent être utilisées :
            <ul>
              <li style="text-align: justify;">Afin de permettre à NOUS de fournir les services demandés, y compris ceux
                qui entraînent l'affichage de contenus et publicités personnalisés.</li>
              <li style="text-align: justify;">A des fins d'audit, de recherches, de statistiques et d'analyse, afin d'optimiser
                les services rendus par NOUS.</li>
              <li style="text-align: justify;"> Le consentement ainsi donné par les utilisateurs emporte autorisation à NOUS de recourir à des tiers pour le traitement des données personnelles et des photos ainsi recueillies, à condition que le tiers ainsi choisi par NOUS respecte toutes les mesures de confidentialité et de sécurité appropriées.</p>
              </li>
            </ul>

            <p style="text-align: justify;">Il est précisé que NOUS utilise d'autres technologies, afin de faciliter l'accès des utilisateurs aux services proposés, afin d'étudier l'usage qui en est fait et plus généralement afin d'améliorer ses prestations. Ces technologies évitent notamment aux utilisateurs d'avoir à répéter la saisie d'informations à chaque visite sur le Site. Les utilisateurs ont cependant le droit de modifier les paramètres et options de leur logiciel de navigation sur internet pour empêcher l'utilisation des cookies. Toutefois, cela peut perturber le fonctionnement de certains services ou fonctions
              Les partenaires de NOUS destinataires de certaines des informations personnelles figurent dans la liste ci-dessous
              Statistiques d'audience :
            <ul>
              <li>Google Analvtics</li>
              Réseaux sociaux :
              <li>Facebook</li>
              <li>Google plus</li>
              Les cookies publicitaires
              <li>Google</li>
            </ul>

            NOUS pourra conserver pour une durée maximale de 12 mois à compter de la résiliation des services les données à caractère personnel relatives aux utilisateurs.
            Le membre peut désactiver son profil, afin de conserver son profil sans qu'il soit visible sur le site. En cas d'inactivité pendant plus de 3 ans, le profil ne sera plus visible sur le service, et le compte sera supprimé 12 mois plus tard.
            En outre, chaque utilisateur peut à tout moment accéder, rectifier et supprimer tout ou partie de ses informations personnelles en allant sur le site : « Paramètres / Supprimer mon compte »
            NOUS communiquera des informations nominatives concernant un utilisateur en cas de réquisition judiciaire et à toute autorité qui effectuerait des vérifications ou enquêtes en relation avec des contenus et/ou services illicites accessibles via le réseau Internet ou téléphonique ou avec des activités illégales.
            En tant que membre de NOUS, l'utilisateur peut recevoir des emails à l'adresse email qu'il aura donné à son inscription.</p>

            <p style="text-align: justify;">
              Pour tous les emails dits d'« alerte » l'informant sur :
            <ul>
              <li>Demande de contact </li>
              <li> De nouveaux messages dans sa messagerie</li>
              <li>Visites du profil par les membres du site</li>
              <li>Flash fan envoyé par les membres du site</li>
            </ul>
            L'utilisateur peut se désinscrire en allant sur le Site sur la rubrique : « Paramètres ».
            Pour les emails ponctuels :
            Newsletter hebdomadaire

            L'utilisateur peut être supprimé des bases de diffusion depuis un lien de
            désinscription présent sur chaque email envoyé ou bien en contactant via notre
            formulaire de contact.</p>

            <h2>Inscription</h2>
            <p style="text-align: justify;">NOUS est seul propriétaire des données d'identification des utilisateurs et se donne
              le devoir de ne pas les divulguées à la demande d'un tiers ou d'un autre utilisateur
              du site sous aucun prétexte. Par ailleurs il est à notifier que l'accès aux utilisateurs
              du site est soumis à une souscription minimum en guise de soutient aux
              engagements techniques de ce dernier. Pendant ce temps les données liées à la
              création d'un profil utilisateur seront disponibles dans la rubrique «consulter le
              profil» pour tous les utilisateurs ; ceci permettra à l'un comme à l'autre de savoir un
              peu plus sur le type de personne avant une demande de prise de contact.
              En outre, notre espace karaoké est dénié de toute authentification quand bien même
              que des données personnelles seront recueillies pour un traitement analytique par le
              site et strictement inaccessible à toute personnes n'ayant pas les autorisations
              nécessaires pour y accéder. Par ailleurs, il sera disponible dans ce même espace la
              rubrique « discuter avec un modérateur», une messagerie libre et gratuite pour
              tenter de signaler et dénoncer les éventuelles tentatives d'intimidation ou
              d'escroquerie.
              Dans un autre cas, NOUS ne sera en aucun cas responsable des différentes clauses
              conclus en dehors du site entre deux utilisateurs à des fins personnelles</p>
          </div>
        </article>
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
<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="assets/js/template.js"></script>
@endsection