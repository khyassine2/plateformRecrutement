<?php

namespace App\Imports;

use App\Models\Entreprise;
use App\Models\SecteurActiviter;
use App\Models\ville;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EntrepriseImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row['nomentreprise'],$row['secteur']);
        // Vérifier si l'entreprise existe déjà dans la base de données
        $entreprise = Entreprise::where('nomEntreprise', $row['nomentreprise'])->first();
        $ville=ville::where('nomVille',$row['ville'])->first();
        // Si l'entreprise n'existe pas, la créer
        if (!$entreprise) {
            $entreprise = new Entreprise([
                'nomEntreprise' => $row['nomentreprise'],
                'emailEntreprise' => $row['email'],
                'password' =>Hash::make($row['password']),
                'adresseEntreprise' =>$row['adresseentreprise'],
                'siteWebEntreprise' =>$row['sitewebentreprise'],
                'telephone' =>$row['telephone'],
                'ville' =>$ville->id??'',
            ]);
            $entreprise->save();
        }
        // Ajouter les secteurs de l'entreprise
        $secteurs = explode(',', $row["secteur"]);
        foreach ($secteurs as $secteur) {
            $secteurActiviter = SecteurActiviter::where('nomSecteurActiviter', trim($secteur))->first();
            if ($secteurActiviter && !$entreprise->secteurs()->exists($secteurActiviter->id)) {
                $entreprise->secteurs()->attach($secteurActiviter);
            }
        }
        
    }
}
