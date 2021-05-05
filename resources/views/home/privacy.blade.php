<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Privacy') }} | {{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom-home.min.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="/favicon.png"/>

</head>

<body>
<nav class="navbar navbar-expand-lg py-0 navbar-dark" style="background-color: #0bb783bd;">
    <div class="container">
        <a class="navbar-brand px-1 py-1 my-0 mx-0" href="#"><img src="/img/logo-white.png" class="header-logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07">
            <ul class="navbar-nav ml-auto mr-0">
                @auth
                    <li class="nav-item dropdown">
                        <p aria-haspopup="true" class="small text-white nav-link"><i class="far fa-user"></i>&nbsp;Mon compte</p>
                        <ul class="dropdown" aria-label="submenu">
                            <li><i class="fas fa-tachometer-alt"></i>&nbsp;<a class="text-white small mb-2" href="/customer">Panel</a></li>
                            <li><i class="fas fa-sign-out-alt"></i>&nbsp;<a class="text-white small mb-2" href="{{ route('logout') }}">Déconnexion</a></li>
                        </ul>
                    </li>
                @endauth
                <li class="nav-item">
                    <a class="nav-link small text-white" href="#"><i class="fas fa-envelope"></i>&nbsp;contact@navetteclub.com</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link small text-white" href="#"><i class="fa fa-phone"></i>&nbsp;+33 1 23 45 67 89</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link small text-white" href="#"><i class="fas fa-clock"></i>&nbsp;07h30 - 20h30</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="main">
    <div class="container" style="margin-top: 100px;">
        <div class="content">
            <h1> Politique de confidentialité </h1>
            <p> Dernière mise à jour: 4 mai 2021 </p>
            <p> Cette politique de confidentialité décrit nos politiques et procédures sur la collecte, l'utilisation et la divulgation de vos informations lorsque vous utilisez le service et vous informe de vos droits à la confidentialité et de la manière dont la loi vous protège. </p>
            <p> Nous utilisons vos données personnelles pour fournir et améliorer le service. En utilisant le Service, vous acceptez la collecte et l'utilisation d'informations conformément à la présente politique de confidentialité. Cette politique de confidentialité a été créée à l'aide du <a href="https://www.termsfeed.com/privacy-policy-generator/" target="_blank"> générateur de politique de confidentialité </a>. </ P >
            <h1> Interprétation et définitions </h1>
            <h2> Interprétation </h2>
            <p> Les mots dont la lettre initiale est en majuscule ont des significations définies dans les conditions suivantes. Les définitions suivantes auront la même signification, qu’elles apparaissent au singulier ou au pluriel. </p>
            <h2> Définitions </h2>
            <p> Aux fins de cette politique de confidentialité: </p>
            <ul>
                <li>
                    <p> <strong> Compte </strong> désigne un compte unique créé pour que vous puissiez accéder à notre service ou à certaines parties de notre service. </p>
                </li>
                <li>
                    <p> <strong> Société </strong> (dénommée soit "la Société", "Nous", "Nous" ou "Notre" dans le présent Contrat) fait référence au Navette Club. </p>
                </li>
                <li>
                    <p> Les <strong> cookies </strong> sont de petits fichiers placés sur votre ordinateur, appareil mobile ou tout autre appareil par un site Web, contenant les détails de votre historique de navigation sur ce site Web parmi ses nombreuses utilisations. </p>
                </li>
                <li>
                    <p> <strong> Pays </strong> fait référence à: France </p>
                </li>
                <li>
                    <p> <strong> Appareil </strong> désigne tout appareil pouvant accéder au Service tel qu'un ordinateur, un téléphone portable ou une tablette numérique. </p>
                </li>
                <li>
                    <p> Les <strong> données personnelles </strong> sont toute information relative à une personne identifiée ou identifiable. </p>
                </li>
                <li>
                    <p> <strong> Service </strong> fait référence au site Web. </p>
                </li>
                <li>
                    <p> <strong> Prestataire de services </strong> désigne toute personne physique ou morale qui traite les données pour le compte de la Société. Il se réfère à des sociétés tierces ou à des personnes employées par la Société pour faciliter le Service, pour fournir le Service au nom de la Société, pour exécuter des services liés au Service ou pour aider la Société à analyser la manière dont le Service est utilisé. </ p>
                </li>
                <li>
                    <p> Les <strong> Données d'utilisation </strong> font référence aux données collectées automatiquement, soit générées par l'utilisation du Service, soit à partir de l'infrastructure du Service elle-même (par exemple, la durée d'une visite de page). </p>
                </li>
                <li>
                    <p> <strong> Le site Web </strong> fait référence au Navette Club, accessible depuis <a href="https://navetteclub.com/" rel="external nofollow noopener" target="_blank"> https: // navetteclub .com / </a> </p>
                </li>
                <li>
                    <p> <strong> Vous </strong> désigne la personne qui accède ou utilise le Service, ou la société, ou toute autre entité juridique au nom de laquelle cette personne accède ou utilise le Service, selon le cas. </p>
                </li>
            </ul>
            <h1> Collecte et utilisation de vos données personnelles </h1>
            <h2> Types de données collectées </h2>
            <h3> Données personnelles </h3>
            <p> Lors de l'utilisation de notre service, nous pouvons vous demander de nous fournir certaines informations personnellement identifiables qui peuvent être utilisées pour vous contacter ou vous identifier. Les informations personnellement identifiables peuvent inclure, mais sans s'y limiter: </p>
            <ul>
                <li>
                    <p> Adresse e-mail </p>
                </li>
                <li>
                    <p> Prénom et nom </p>
                </li>
                <li>
                    <p> Numéro de téléphone </p>
                </li>
                <li>
                    <p> Adresse, État, Province, ZIP / Code postal, Ville </p>
                </li>
                <li>
                    <p> Données d'utilisation </p>
                </li>
            </ul>
            <h3> Données d'utilisation </h3>
            <p> Les données d'utilisation sont collectées automatiquement lors de l'utilisation du service. </p>
            <p> Les données d'utilisation peuvent inclure des informations telles que l'adresse de protocole Internet de votre appareil (par exemple, l'adresse IP), le type de navigateur, la version du navigateur, les pages de notre service que vous visitez, l'heure et la date de votre visite, le temps passé sur ces pages. , des identifiants d'appareil uniques et d'autres données de diagnostic. </p>
            <p> Lorsque vous accédez au service par ou via un appareil mobile, nous pouvons collecter certaines informations automatiquement, y compris, mais sans s'y limiter, le type d'appareil mobile que vous utilisez, l'identifiant unique de votre appareil mobile, l'adresse IP de votre appareil mobile , Votre système d'exploitation mobile, le type de navigateur Internet mobile que vous utilisez, les identifiants uniques de l'appareil et d'autres données de diagnostic. </p>
            <p> Nous pouvons également collecter des informations que votre navigateur envoie chaque fois que vous visitez notre service ou lorsque vous accédez au service par ou via un appareil mobile. </p>
            <h3> Technologies de suivi et cookies </h3>
            <p> Nous utilisons des cookies et des technologies de suivi similaires pour suivre l'activité sur notre service et stocker certaines informations. Les technologies de suivi utilisées sont des balises, des balises et des scripts pour collecter et suivre des informations et pour améliorer et analyser notre service. Les technologies que nous utilisons peuvent inclure: </p>
            <ul>
                <li> <strong> Cookies ou cookies de navigateur. </strong> Un cookie est un petit fichier placé sur votre appareil. Vous pouvez demander à votre navigateur de refuser tous les cookies ou d'indiquer quand un cookie est envoyé. Cependant, si vous n'acceptez pas les cookies, il se peut que vous ne puissiez pas utiliser certaines parties de notre service. Sauf si vous avez ajusté les paramètres de votre navigateur afin qu'il refuse les cookies, notre service peut utiliser des cookies. </li>
                <li> <strong> Cookies Flash. </strong> Certaines fonctionnalités de notre Service peuvent utiliser des objets stockés localement (ou cookies Flash) pour collecter et stocker des informations sur Vos préférences ou Votre activité sur notre Service. Les cookies Flash ne sont pas gérés par les mêmes paramètres de navigateur que ceux utilisés pour les cookies de navigateur. Pour plus d'informations sur la manière de supprimer les cookies Flash, veuillez lire "Où puis-je modifier les paramètres de désactivation ou de suppression des objets partagés locaux?" disponible à <a href="https://helpx.adobe.com/flash-player/kb/disable-local-shared-objects-flash.html#main_Where_can_I_change_the_settings_for_disabling__or_deleting_local_shared_objects_" rel="external nofollow noopener" target="_blank"> https://helpx.adobe.com/flash-player/kb/disable-local-shared-objects-flash.html#main_Where_can_I_change_the_settings_for_disabling__or_deleting_local_shared_objects_ </a> </li>
                <li> <strong> Balises Web. </strong> Certaines sections de notre Service et de nos e-mails peuvent contenir de petits fichiers électroniques appelés balises Web (également appelés gifs clairs, pixels invisibles et gifs à pixel unique) qui permettent le Société, par exemple, pour compter les utilisateurs qui ont visité ces pages ou ouvert un e-mail et pour d'autres statistiques de site Web connexes (par exemple, enregistrer la popularité d'une certaine section et vérifier l'intégrité du système et du serveur). </li>
            </ul>
            <p> Les cookies peuvent être "persistants" ou & quot; Session & quot; Biscuits. Les cookies persistants restent sur votre ordinateur personnel ou appareil mobile lorsque vous vous déconnectez, tandis que les cookies de session sont supprimés dès que vous fermez votre navigateur Web. Vous pouvez en savoir plus sur les cookies ici: <a href="https://www.termsfeed.com/blog/cookies/" target="_blank"> Tout sur les cookies par TermsFeed </a>. </p>
            <p> Nous utilisons à la fois des cookies de session et des cookies persistants aux fins décrites ci-dessous: </p>
            <ul>
                <li>
                    <p> <strong> Cookies nécessaires / essentiels </strong> </p>
                    <p> Type: cookies de session </p>
                    <p> Administré par: Nous </p>
                    <p> Objectif: ces cookies sont essentiels pour vous fournir les services disponibles sur le site Web et pour vous permettre d'utiliser certaines de ses fonctionnalités. Ils aident à authentifier les utilisateurs et à empêcher l'utilisation frauduleuse des comptes d'utilisateurs. Sans ces cookies, les services que vous avez demandés ne peuvent pas être fournis, et nous n'utilisons ces cookies que pour vous fournir ces services. </p>
                </li>
                <li>
                    <p> <strong> Politique de cookies / Cookies d'acceptation d'avis </strong> </p>
                    <p> Type: cookies persistants </p>
                    <p> Administré par: Nous </p>
                    <p> Objectif: ces cookies identifient si les utilisateurs ont accepté l'utilisation de cookies sur le site Web. </p>
                </li>
                <li>
                    <p> <strong> Cookies de fonctionnalité </strong> </p>
                    <p> Type: cookies persistants </p>
                    <p> Administré par: Nous </p>
                    <p> Objectif: ces cookies nous permettent de nous souvenir des choix que vous faites lorsque vous utilisez le site Web, tels que la mémorisation de vos informations de connexion ou de votre préférence linguistique. Le but de ces cookies est de vous offrir une expérience plus personnelle et de vous éviter d'avoir à ressaisir vos préférences chaque fois que vous utilisez le site Web. </p>
                </li>
            </ul>
            <p> Pour plus d'informations sur les cookies que nous utilisons et vos choix concernant les cookies, veuillez visiter notre Politique de cookies ou la section Cookies de notre Politique de confidentialité. </p>
            <h2> Utilisation de vos données personnelles </h2>
            <p> La Société peut utiliser les Données Personnelles aux fins suivantes: </p>
            <ul>
                <li>
                    <p> <strong> Pour fournir et maintenir notre service </strong>, y compris pour surveiller l'utilisation de notre service. </p>
                </li>
                <li>
                    <p> <strong> Pour gérer votre compte: </strong> pour gérer votre inscription en tant qu'utilisateur du service. Les données personnelles que vous fournissez peuvent vous donner accès à différentes fonctionnalités du service qui vous sont disponibles en tant qu'utilisateur enregistré. </p>
                </li>
                <li>
                    <p> <strong> Pour l'exécution d'un contrat: </strong> le développement, la conformité et l'engagement du contrat d'achat pour les produits, articles ou services que vous avez achetés ou de tout autre contrat avec nous via le service. </ p>
                </li>
                <li>
                    <p> <strong> Pour vous contacter: </strong> Pour vous contacter par e-mail, appels téléphoniques, SMS ou autres formes équivalentes de communication électronique, telles que les notifications push d'une application mobile concernant les mises à jour ou les communications informatives liées aux fonctionnalités, produits ou services sous contrat, y compris les mises à jour de sécurité, lorsque cela est nécessaire ou raisonnable pour leur mise en œuvre. </p>
                </li>
                <li>
                    <p> <strong> Pour vous fournir </strong> des actualités, des offres spéciales et des informations générales sur d'autres biens, services et événements que nous proposons et similaires à ceux que vous avez déjà achetés ou sur lesquels vous vous êtes renseigné, sauf si vous avez choisi de ne pas le faire recevoir de telles informations. </p>
                </li>
                <li>
                    <p> <strong> Pour gérer vos demandes: </strong> pour participer et gérer vos demandes. </p>
                </li>
                <li>
                    <p> <strong> Pour les transferts d'entreprise: </strong> Nous pouvons utiliser vos informations pour évaluer ou mener une fusion, un désinvestissement, une restructuration, une réorganisation, une dissolution ou toute autre vente ou transfert de tout ou partie de nos actifs, que ce soit en tant que en cours de fonctionnement ou dans le cadre d'une faillite, d'une liquidation ou d'une procédure similaire, dans laquelle les données personnelles que nous détenons sur les utilisateurs de nos services font partie des actifs transférés. </p>
                </li>
                <li>
                    <p> <strong> À d'autres fins </strong>: nous pouvons utiliser vos informations à d'autres fins, telles que l'analyse des données, l'identification des tendances d'utilisation, la détermination de l'efficacité de nos campagnes promotionnelles et pour évaluer et améliorer notre service, nos produits et nos services. , marketing et votre expérience. </p>
                </li>
            </ul>
            <p> Nous pouvons partager vos informations personnelles dans les situations suivantes: </p>
            <ul>
                <li> <strong> Avec les fournisseurs de services: </strong> nous pouvons partager vos informations personnelles avec les fournisseurs de services pour surveiller et analyser l'utilisation de notre service, pour vous contacter. </li>
                <li> <strong> Pour les transferts d'entreprise: </strong> Nous pouvons partager ou transférer vos informations personnelles dans le cadre ou pendant les négociations de toute fusion, vente d'actifs de la société, financement ou acquisition de tout ou partie de notre entreprise à une autre entreprise. </li>
                <li> <strong> Avec les affiliés: </strong> nous pouvons partager vos informations avec nos affiliés, auquel cas nous demanderons à ces affiliés d'honorer cette politique de confidentialité. Les affiliés incluent notre société mère et toutes autres filiales, partenaires de coentreprise ou autres sociétés que nous contrôlons ou qui sont sous contrôle commun avec nous. </li>
                <li> <strong> Avec des partenaires commerciaux: </strong> nous pouvons partager vos informations avec nos partenaires commerciaux pour vous proposer certains produits, services ou promotions. </li>
                <li> <strong> Avec d'autres utilisateurs: </strong> lorsque vous partagez des informations personnelles ou interagissez d'une autre manière dans les zones publiques avec d'autres utilisateurs, ces informations peuvent être vues par tous les utilisateurs et peuvent être diffusées publiquement à l'extérieur. </li>
                <li> <strong> Avec votre consentement </strong>: nous pouvons divulguer vos informations personnelles à toute autre fin avec votre consentement. </li>
            </ul>
            <h2> Conservation de vos données personnelles </h2>
            <p> La Société ne conservera vos données personnelles que le temps nécessaire aux fins énoncées dans la présente politique de confidentialité. Nous conserverons et utiliserons vos données personnelles dans la mesure nécessaire pour nous conformer à nos obligations légales (par exemple, si nous sommes tenus de conserver vos données pour nous conformer aux lois applicables), résoudre les litiges et appliquer nos accords et politiques juridiques. </ p>
            <p> La Société conservera également les données d'utilisation à des fins d'analyse interne. Les données d'utilisation sont généralement conservées pendant une période plus courte, sauf lorsque ces données sont utilisées pour renforcer la sécurité ou pour améliorer la fonctionnalité de notre service, ou nous sommes légalement obligés de conserver ces données pendant des périodes plus longues. </p>
            <h2> Transfert de vos données personnelles </h2>
            <p> Vos informations, y compris les données personnelles, sont traitées dans les bureaux d'exploitation de la société et dans tout autre endroit où se trouvent les parties impliquées dans le traitement. Cela signifie que ces informations peuvent être transférées et conservées sur des ordinateurs situés en dehors de votre état, province, pays ou autre juridiction gouvernementale où les lois sur la protection des données peuvent différer de celles de votre juridiction. </p>
            <p> Votre consentement à cette politique de confidentialité suivi de la soumission de ces informations représente votre accord à ce transfert. </p>
            <p> La Société prendra toutes les mesures raisonnablement nécessaires pour garantir que vos données sont traitées en toute sécurité et conformément à la présente politique de confidentialité et aucun transfert de vos données personnelles n'aura lieu à une organisation ou à un pays à moins que des contrôles adéquats soient en place, notamment la sécurité de vos données et autres informations personnelles. </p>
            <h2> Divulgation de vos données personnelles </h2>
            <h3> Transactions commerciales </h3>
            <p> Si la société est impliquée dans une fusion, une acquisition ou une vente d'actifs, vos données personnelles peuvent être transférées. Nous vous informerons avant que vos données personnelles ne soient transférées et deviennent soumises à une politique de confidentialité différente. </p>
            <h3> Application de la loi </h3>
            <p> Dans certaines circonstances, la Société peut être tenue de divulguer vos données personnelles si la loi l'exige ou en réponse à des demandes valides des autorités publiques (par exemple, un tribunal ou une agence gouvernementale). </p>
            <h3> Autres obligations légales </h3>
            <p> La Société peut divulguer vos données personnelles en croyant de bonne foi qu'une telle action est nécessaire pour: </p>
            <ul>
                <li> Se conformer à une obligation légale </li>
                <li> Protéger et défendre les droits ou la propriété de l'entreprise </li>
                <li> Prévenir ou enquêter sur d'éventuels actes répréhensibles en relation avec le Service </li>
                <li> Protéger la sécurité personnelle des Utilisateurs du Service ou du public </li>
                <li> Protéger contre la responsabilité légale </li>
            </ul>
            <h2> Sécurité de vos données personnelles </h2>
            <p> La sécurité de vos données personnelles est importante pour nous, mais rappelez-vous qu'aucune méthode de transmission sur Internet ou méthode de stockage électronique n'est sécurisée à 100%. Bien que nous nous efforcions d'utiliser des moyens commercialement acceptables pour protéger vos données personnelles, nous ne pouvons garantir leur sécurité absolue. </p>
            <h1> Informations détaillées sur le traitement de vos données personnelles </h1>
            <p> Les fournisseurs de services que nous utilisons peuvent avoir accès à vos données personnelles. Ces fournisseurs tiers collectent, stockent, utilisent, traitent et transfèrent des informations sur votre activité sur notre service conformément à leurs politiques de confidentialité. </p>
            <h2> Utilisation, performances et divers </h2>
            <p> Nous pouvons utiliser des fournisseurs de services tiers pour améliorer notre service. </p>
            <ul>
                <li>
                    <p> <strong> Google Adresses </strong> </p>
                    <p> Google Places est un service qui renvoie des informations sur les lieux à l'aide de requêtes HTTP. Il est exploité par Google </p>
                    <p> Le service Google Adresses peut collecter des informations sur vous et sur votre appareil à des fins de sécurité. </p>
                    <p> Les informations recueillies par Google Places sont conservées conformément à la politique de confidentialité de Google: <a href = "https://www.google.com/intl/en/policies/privacy/" rel = "external nofollow noopener "target =" _blank "> https://www.google.com/intl/en/policies/privacy/ </a> </p>
                </li>
            </ul>
            <h1> Confidentialité des enfants </h1>
            <p> Notre service ne s'adresse à personne de moins de 13 ans. Nous ne collectons pas sciemment d'informations personnellement identifiables de toute personne de moins de 13 ans. Si vous êtes un parent ou un tuteur et que vous savez que votre enfant nous a fourni des informations personnelles Données, veuillez nous contacter. Si nous apprenons que nous avons collecté des données personnelles de toute personne de moins de 13 ans sans vérification du consentement parental, nous prenons des mesures pour supprimer ces informations de nos serveurs. </p>
            <p> Si nous devons nous fier au consentement comme base légale pour le traitement de vos informations et que votre pays requiert le consentement d'un parent, nous pouvons exiger le consentement de vos parents avant de collecter et d'utiliser ces informations. </p>
            <h1> Liens vers d'autres sites Web </h1>
            <p> Notre service peut contenir des liens vers d'autres sites Web qui ne sont pas exploités par nous. Si vous cliquez sur un lien tiers, vous serez dirigé vers le site de ce tiers. Nous vous conseillons vivement de consulter la politique de confidentialité de chaque site que vous visitez. </p>
            <p> Nous n'avons aucun contrôle et n'assumons aucune responsabilité pour le contenu, les politiques de confidentialité ou les pratiques de tout site ou service tiers. </p>
            <h1> Modifications de cette politique de confidentialité </h1>
            <p> Nous pouvons mettre à jour notre politique de confidentialité de temps à autre. Nous vous informerons de tout changement en publiant la nouvelle politique de confidentialité sur cette page. </p>
            <p> Nous Vous informerons par e-mail et / ou par un avis visible sur Notre Service, avant que la modification ne devienne effective et nous mettrons à jour la "Dernière mise à jour". date en haut de cette politique de confidentialité. </p>
            <p> Il vous est conseillé de consulter périodiquement cette politique de confidentialité pour tout changement. Les modifications apportées à cette politique de confidentialité sont effectives lorsqu'elles sont publiées sur cette page. </p>
            <h1> Contactez-nous </h1>
            <p> Si vous avez des questions sur cette politique de confidentialité, vous pouvez nous contacter: </p>
            <ul>
                <li> En visitant cette page sur notre site Web: <a href="https://navetteclub.com/" rel="external nofollow noopener" target="_blank"> https://navetteclub.com/ </a> </li>
            </ul>
        </div>
    </div>

    <div class="footer" style="text-align:center;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <small>Suivez-nous sur notre <a href="#">page&nbsp;<i class="fab fa-facebook-f"></i>acebook</a></small>
                </div>
                <div class="col-md-6">
                    <small>Création de L&M - tous droits réservés &copy; {{ date('Y') }}</small>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>
