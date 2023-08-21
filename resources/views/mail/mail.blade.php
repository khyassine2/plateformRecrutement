<h1>{{ $message1 }}</h1>
<h3>
   @if($etat==2)
    <ul>
        <li>TypeFormation : {{ $nomFormation1 }}</li>
        <li>Duree Stage : {{ $dureeStage1 }}</li>
        <li>Type Stage : {{ $typeStage1 }}</li>
        <li>niveau Etude : {{ $niveauEtude1 }}</li>
    </ul>
   @endif
</h3>
