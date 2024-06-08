<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Classement;
use App\Models\Coureur;
use App\Models\Etape;
use App\Models\Finalsetape;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EtapeController extends Controller
{
    //
    public function index(){
//        $data = Etape::orderBy('rang', 'asc')->get();
        $id = auth()->id();
        $courreur = DB::table('coureur')->where('iduser', $id)->get();


        $data = Etape::with(['chrono' => function($query) use ($id) {
            $query->where('iduser', $id);
        }])->orderby('rang')->get();

//        dd($data);
        return view('etape.index' , ['data' => $data, 'courreur' => $courreur]);
    }

    public function etape(){
        $data = Etape::orderBy('rang', 'asc')->get();
        return view('etape.liste' , ['data' => $data]);
    }

    public function getListeCourreurEtape($id){

        $data = DB::table('get_course_coureur')->where(['idetape'=> $id ,'etat' => 0])->get();
        $etape = Etape::where('id', $id)->first();
        $date_depart = DB::table('ensemble_detail_classement')
            ->where('idetape', $etape->id)
            ->first();

        return view('etape.listecourreur' , ['data' => $data, 'id' => $id, 'nom_etape' => $etape, 'depart' => $date_depart->depart]);

    }

    public function addPage()
    {
       return view('etape.addEtape');
    }

    public function insertNewEtape(Request $request){
        $request->validate([
            'longueur' => 'required|numeric',
        ], [
            'longueur.required' => 'Le champ longueur est obligatoire.',
            'longueur.numeric' => 'Le champ longueur doit être un nombre.',
        ]);


        $nom = $request->input('nom');
        $longueur = $request->input('longueur');
        $nb_courreur = $request->input('nb_courreur');
        $rang = $request->input('rang');


        try {
            $etape = Etape::firstOrNew([
                'rang' => $rang
            ]);

            if (!$etape->exists) {
                $etape->nom = $nom;
                $etape->longeur = $longueur;
                $etape->nb_coureur = $nb_courreur;
                $etape->save();
                return redirect(route('etape.liste'));
            } else {
                return redirect()->back()->with('error', 'Le rang est en double.');
            }
        } catch (\Exception $e) {
            Flash::error('Une erreur est survenue. Veuillez réessayer.');
            return redirect()->back();
        }

    }

    public function courreur_chrono($id){
        $id_user = auth()->id();
        $data = DB::table('ensemble_detail_classement')->where(['idetape' => $id, 'id_equipe' => $id_user])->get();
        $etape = Etape::where('id', $id)->first();
        return view('courreur.courreurChrono' , ['data' => $data, 'nom_etape' => $etape]);

    }
}
