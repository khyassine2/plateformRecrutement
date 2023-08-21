<!DOCTYPE html>
<html>
<head>
	<title>Liste des offres ajoutées Recement</title>
</head>
<body>
	<div id="container" style="width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; background: linear-gradient(to right, #178085, #BEED89, #6BE0E7);; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <div id="logo">
            <img src="{{ url('images/logoUmge.png') }}" alt="UgmeOffre">
        </div>
        <h1 style="font-size: 24px; margin-bottom: 20px;">Liste des offres ajoutées</h1>
        @if (count($offre) > 0)
            @foreach ($offre as $offers)
                <a style='text-decoration: none;color: #000000' href={{route('alloffresid', ['op' => 'offre6', 'id2' => $offers->idOffre]) }}>
                    <div id="card" style="padding: 20px; margin-bottom: 20px; background-color: #fff; border-radius: 4px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                        <div id="card-title" style="font-size: 20px; margin-bottom: 10px;text-decoration: underline">{{ $offers->titreOffre }}</div>
                        <div id="card-body" style="font-size: 14px; line-height: 1.5;">{{ $offers->entreprise->villes->nomVille }}</div>    
                        <div id="card-body" style="font-size: 14px; line-height: 1.5; margin-bottom: 10px;">{{ $offers->descriptionOffre }}</div>
                        <div id="card-footer" style="font-size: 14px; color: #999;">Date de Publie :  {{ strftime('%d/%m/%Y %H:%M', strtotime($offers->created_at)) }}</div>
                    </div>
                </a>
            @endforeach
        @else
            <p style="font-size: 16px;">Aucune offre n'a été ajoutée pour le moment.</p>
        @endif
        <p style="font-size: 14px; color: #333;">Cordialement,<br>L'équipe du site</p>
    </div>
    
    
</body>
</html>
