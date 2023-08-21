<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use stdClass;

class UsersExport implements FromQuery,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function query()
    {
        return $data=User
            ::select('utilisateur.nomUtilisateur', 'utilisateur.prenomUtilisateur', 'utilisateur.email', 'utilisateur.telephone','utilisateur.dateNaissance','utilisateur.photo','roles.nomRole as role','level_sites.nomLevelSite as levelSite','utilisateur.ville')
            ->join('roles', 'utilisateur.role_id', '=', 'roles.idRole')
            ->leftJoin('level_sites', 'level_sites.idLevelSite', '=', 'utilisateur.levelsite_id')
            ->where(function($query) {
                $query->whereNull('level_sites.nomLevelSite')
                      ->orWhereNotNull('level_sites.nomLevelSite');
            })
            ->orderBy('utilisateur.nomUtilisateur', 'asc');
    }
    public function headings(): array
    {
        return [
            'Nom Utilisateur',
            'Prenom Utilisateur',
            'Email Utilisateur',
            'numero Utilisateur',
            'Date Naissance Utilisateur',
            'photo Utilisateur',
            'Role Utilisateur',
            'levelSite Utilisateur',
            'Ville Utilisateur'
            // Ajoutez d'autres colonnes si nécessaire
        ];
    }
}
