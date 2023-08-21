<?php

namespace App\Exports;

use App\Models\Entreprise;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EntrepriseExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $entreprises = Entreprise::all();

        $data = [];
        foreach ($entreprises as $entreprise) {
            $secteurs = $entreprise->secteurs->pluck('nomSecteurActiviter')->implode(', ');
            $data[] = [
                'Nom Entreprise' => $entreprise->nomEntreprise??"",
                'Adresse Entreprise'=>$entreprise->adresseEntreprise??"",
                'Email Entreprise'=>$entreprise->emailEntreprise??"",
                'SiteWeb Entreprise'=>$entreprise->siteWebEntreprise??"",
                'Telephone Entreprise'=>$entreprise->telephone??"",
                'photo Entreprise'=>$entreprise->photo??"",
                'villeEntreprise'=>$entreprise->villes->nomVille??"",
                'Secteurs' => $secteurs,
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Nom Entreprise' ,
            'Adresse Entreprise',
            'Email Entreprise',
            'SiteWeb Entreprise',
            'Telephone Entreprise',
            'photo Entreprise',
            'villeEntreprise',
            'Secteurs'
        ];
    }
    }
