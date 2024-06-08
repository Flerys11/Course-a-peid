<?php

namespace App\Http\Controllers;

use App\Imports\IEtape;
use App\Imports\IPoints;
use App\Imports\IResultat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use function Laravel\Prompts\select;

class ImportController extends Controller
{
    //

    public function etape(Request $request)
    {
        if ($request->hasFile('file') && $request->hasFile('file2')) {
            $file = $request->file("file");
            $file2 = $request->file("file2");
            $nomFichier = Carbon::now()->format('Ymd_His') . '_' . $file->getClientOriginalName();
            $nomFichier2 = Carbon::now()->format('Ymd_His') . '_' . $file2->getClientOriginalName();
            $file->move(public_path('upload'), $nomFichier);
            $file2->move(public_path('upload'), $nomFichier2);

            Excel::import(new IEtape(), 'upload/' . $nomFichier);
            Excel::import(new IResultat(), 'upload/' . $nomFichier2);

            $equipe = DB::select("select DISTINCT (equipe)from import_resultat");

            foreach ($equipe as $equipes) {
                User::create([
                    'name' => $equipes->equipe,
                    'email' => strtolower($equipes->equipe) . '@gmail.com',
                    'password' => Hash::make(strtolower($equipes->equipe)),
                    'role' => 'equipe',
                ]);
            }
            DB::select('CALL somme_import()');
            return redirect()->back();


//            $data1 = Excel::toArray(new IEtape(), 'upload/'. $nomFichier);
//            $data2 = Excel::toArray(new IResultat(), 'upload/'. $nomFichier);
//
//            $import_etpae = DB::select('select * from import_etape');
//            $rang_import = array_map(function($item) {
//                return $item->rang;
//            }, $import_etpae);
//
//            $errors = [];
//            foreach ($data1 as $etape) {
//                for ($i = 0; $i < count($etape); $i++) {
//
//                    $rang = $etape[$i]['rang'];
//                    if (in_array($rang, $rang_import)) {
//                        $errors[] = array_merge($etape[$i], ['line' => $i + 1]);
//                    }else{
//
//                        \App\Models\ImportEtape::create([
//                            'etape' => $etape[$i]['etape'],
//                            'longueur' => $etape[$i]['longueur'],
//                            'nb_courreur' => $etape[$i]['nb_coureur'],
//                            'rang' => $etape[$i]['rang'],
//                            'depart' => $etape[$i]['date_depart'] .' ' .$etape[$i]['heure_depart']
//                        ]);
//                    }
//
//                }
//            }
//
//            Excel::import(new IResultat(), 'upload/'. $nomFichier2);
//
//            $equipe = DB::select("select DISTINCT (equipe)from import_resultat");
//
//            foreach ($equipe as $equipes) {
//                User::create([
//                    'name' => $equipes->equipe,
//                    'email' => strtolower($equipes->equipe).'@gmail.com',
//                    'password' =>Hash::make(strtolower($equipes->equipe)),
//                    'role' => 'equipe',
//                ]);
//            }
//            DB::select('CALL somme_import()');
//
//        }
//
//        return redirect()->back()->with('nonMatchingRefs', $errors);
        }
    }


    public function points(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file("file");
            $nomFichier = Carbon::now()->format('Ymd_His') . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload'), $nomFichier);
            Excel::import(new IPoints(), 'upload/' . $nomFichier);
            return redirect(route('classement.index'));
        }
    }

    public function delete_all_table()
    {
        DB::select('CALL delete_all_table()');
        return redirect()->back();
    }

}


