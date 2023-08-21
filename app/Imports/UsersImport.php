<?php

namespace App\Imports;

use App\Models\levelSite;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $role=Role::where('nomRole',$row[6])->first();
        $levelSite=levelSite::where('nomLevelSite',$row[7])->first();
        $user=new User([
            'nomUtilisateur'=> $row[0],
            'prenomUtilisateur'=> $row[1],
            'email'=> $row[2],
            'password'=> Hash::make($row[3]),
            'telephone'=> $row[4],
            'dateNaissance'=>$row[5],
            'Role_id'=> $role->idRole,
            'levelsite_id'=> $levelSite->nomLevelSite,
            'ville'=> $row[8],
        ]);
        return $user;
    }
}
