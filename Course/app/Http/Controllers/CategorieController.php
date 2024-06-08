<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Coureur;
use App\Models\TypeCoureur;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategorieController extends Controller
{
    //

    public function generate(){

        $courreur = Coureur::all();

        foreach ($courreur as $cour){
            $birthdate = new DateTime($cour->datanaissance);
            $today = new DateTime('today');
            $age = $birthdate->diff($today)->y;
            $cat = DB::select('select id from categorie where marge > ? limit 1', [$age]);

            $typeCoureur = TypeCoureur::where('idcoureur', $cour->id)->first();
            if ($typeCoureur) {
                $typeCoureur->idcategorie = $cat[0]->id;
                $typeCoureur->save();
            } else {
                TypeCoureur::create([
                    'idcoureur' => $cour->id,
                    'idcategorie' => $cat[0]->id
                ]);
            }
        }
        return redirect()->back();
    }
}
