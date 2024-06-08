<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Etape;
use App\Models\Finalsetape;
use App\Models\HistoPenalite;
use App\Models\User;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenaliteController extends Controller
{
    //
    public function index(){

        $data = DB::select('select id, penalite as penaltie, nom_etape, nom_equipe, idetape ,iduser from
                                                            get_new_penalite where etat = 0');
        return view('penaltie.index' ,['data'=>$data]);
    }

    public function page()
    {
        $etape = Etape::orderby('rang', 'asc')->get();
        $equipe = User::select('id', 'name')->where('role', 'equipe')->orderby('name', 'asc')->get();

        return view('penaltie.inserte', ['etape'=>$etape, 'equipe'=>$equipe]);
    }

    public function insert_penaltie(Request $request){
        $equipe = $request->input('equipe');
        $etape = $request->input('etape');
        $penalite = $request->input('penalite');

        try {
            $time_equipe = DB::table('get_penaltie_equipe')->where([
                'idequipe' => $equipe,
                'idetape' => $etape
            ])->first();

            if (!$time_equipe) {
                throw new \Exception('Données de pénalité pour l\'équipe et l\'étape non trouvées.');
            }

            $penal_ancien = Carbon::createFromFormat('H:i:s', $time_equipe->penaltie);
            $penal = Carbon::createFromFormat('H:i:s', $penalite);

            $time_finals = $penal->addSeconds($penal_ancien->diffInSeconds(Carbon::createFromFormat('H:i:s', '00:00:00')))->format('H:i:s');

            $cour = DB::table('ensemble_detail_classement')->where([
                'idequipe' => $equipe,
                'idetape' => $etape
            ])->get();

            DB::transaction(function() use ($cour, $time_finals, $equipe, $etape, $penal) {
                foreach ($cour as $cours) {
                    $finals_etape = Finalsetape::where('idcourse', $cours->idcourse)->get();
                    foreach ($finals_etape as $final) {
                        $final->penaltie = $time_finals;
                        $final->save();
                    }
                }
                HistoPenalite::create([
                    'iduser' => $equipe,
                    'idetape' => $etape,
                    'penalite' => $penal
                ]);
            });

            return redirect()->back()->with('success', 'Pénalité mise à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de la pénalité : Equipe n est pas dans la course');
        }
    }

    public function delete_penalite(Request $request)
    {
        $etape = $request->get('etape');
        $equipe = $request->get('equipe');
        $id = $request->get('id');



        $cour = DB::table('ensemble_detail_classement')->where([
            'idequipe' => $equipe,
            'idetape' => $etape
        ])->get();
        $time_equipe = DB::table('get_penaltie_equipe')->where([
            'idequipe' => $equipe,
            'idetape' => $etape
        ])->first();

        $time_moins = DB::table('histo_penalite')->where([
            'id' => $id,
        ])->first();

        $mois = Carbon::createFromFormat('H:i:s', $time_moins->penalite);
        $time_equipes = Carbon::createFromFormat('H:i:s', $time_equipe->penaltie);

        $time_finals = $time_equipes->subSeconds($mois->diffInSeconds(Carbon::createFromFormat('H:i:s', '00:00:00')))->format('H:i:s');

        DB::transaction(function() use ($cour, $time_finals, $id) {

            foreach ($cour as $cours) {
                $finals_etape = Finalsetape::where('idcourse', $cours->idcourse)->get();
                foreach ($finals_etape as $final) {
                    $final->penaltie = $time_finals;
                    $final->save();
                }

            }
            $histos = HistoPenalite::where(['id' => $id])->get();
            foreach ($histos as $histo) {
                $histo->etat = 10;
                $histo->save();
            }
        });

        return redirect()->back();
    }
}
