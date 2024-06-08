<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Etape;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassementController extends Controller
{
    //
    public function index(){
        $global = DB::select('select * from classement_global');
        $etape = Etape::orderBy('rang', 'asc')->get();
        $genre = Genre::all();
        $cate = Categorie::all();
        $trie = null;
        return view('classement.liste', ['global'=> $global, 'etape'=>$etape, 'genre'=>$genre, 'cate'=>$cate, 'trie'=>$trie]);
    }

    public function classementEtape($id){
        $data = DB::table('ensemble_detail_classement')
            ->where('idetape', $id)
            ->orderBy('rang_coureur')
            ->paginate(10);

//        dd($data);
        $genre = Genre::all();
        $cate = Categorie::all();
        $etape = Etape::where('id', $id)->first();
        $trie = null;

        return view('classement.listeetape', ['etape' => $data, 'nom_etape'=>$etape, 'genre'=>$genre, 'cate'=>$cate, 'trie'=>$trie]);
    }

    public function trieEtape(Request $request)
    {
        $trie = $request->input('trie');
        $categorie = $request->input('categorie');
//        dd($categorie, $trie);
        $results = DB::select('
        SELECT *
        FROM get_ranked_trie_etape(?,?)
        ', [$trie, $categorie]);

        $genre = Genre::all();
        $cate = Categorie::all();
        $etape = Etape::where('id', $categorie)->first();
        $trie = null;


        return view('classement.listeetape', ['etape' => $results, 'nom_etape'=>$etape, 'genre'=>$genre, 'cate'=>$cate, 'trie'=>$trie]);


    }

    public function trieCategorie(Request $request) {
        $trie = $request->input('trie');
        $data = DB::select('
        SELECT
            nom_equipe,id_equipe as idequipe,
            SUM(points) AS points_equipe,
            RANK() OVER (ORDER BY SUM(points) DESC) AS rang_equipe
        FROM get_ranked_trie(?)
        GROUP BY nom_equipe, id_equipe
        ORDER BY rang_equipe
        ', [$trie]);

        $etape = Etape::orderBy('rang', 'asc')->get();
        $genre = Genre::all();
        $cate = Categorie::all();

        return view('classement.liste', ['global'=> $data, 'etape'=>$etape, 'genre'=>$genre, 'cate'=>$cate, 'trie'=>$trie]);
    }

    public function get_courreur_etape($id)
    {
        $data = DB::select('select nom ,nom_equipe ,sum(points_attribues) as point_total
            from ensemble_detail_classement
             where id_equipe = ?
            group by idcoureur, nom,nom_equipe', [$id]);

        return view('classement.detail', ['data'=> $data]);

    }


}
