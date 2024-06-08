<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Etape;
use App\Models\Finalsetape;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{

    public function insert_courreur(Request $request){

        $etapeId = $request->input('etape_id');
        $courreurs = $request->input('courreurs');
        $courreur = $request->input('courreur');
        $max = $request->input('max');

        $courreursUnique = array_unique($courreurs);
        $userId = auth()->id();

        $count = DB::table('get_course_coureur')
            ->where(['idetape' => $etapeId, 'iduser' => $userId])
            ->count();

        $existingCoureurs = DB::table('get_course_coureur')
            ->where('idetape', $etapeId)
            ->whereIn('idcoureur', array_merge($courreursUnique, [$courreur]))
            ->pluck('idcoureur')
            ->toArray();
        $allCoureurs = $courreurs;
        if (!empty($courreur)) {
            $allCoureurs[] = $courreur;
        }
        $submittedCount = count($allCoureurs);
        $nb_coureure = $count + $submittedCount;

        if ($nb_coureure > $max) {
            return response()->json(['error' => 'Vous ne pouvez pas ajouter plus de ' . 2 . ' coureurs pour cette étape.']);
        }
        if (!empty($existingCoureurs)) {
            return response()->json(['error' => 'Certains coureurs sont déjà enregistrés pour cette étape.']);
        }

        if (count($courreurs) !== count($courreursUnique) || in_array($courreur, $courreursUnique)) {
            return response()->json(['error' => 'Les coureurs ne doivent pas se répéter.']);
        }

        $allCoureurs = $courreurs;
        if (!empty($courreur)) {
            $allCoureurs[] = $courreur;
        }

        foreach ($allCoureurs as $courreur) {
            Course::create([
                'idetape' => $etapeId,
                'idcoureur' => $courreur,
                'etat' => 0
            ]);
        }

        return response()->json(['message' => 'Les coureurs ont été ajoutés avec succès.']);

    }

    public function insert_time(Request $request){

        $depart = $request->input('depart');
        $id =$request->input('id_courreur');
        $arrivee = $request->input('arrivee');

        if (!is_string($depart) ||!is_string($arrivee)) {
            return response()->json(['error' => 'Les valeurs de départ et/ou d\'arrivée doivent être des chaînes de caractères représentant des dates/temps valides.']);
        }

        $dateDepart = new DateTime($depart);
        $dateArrivee = new DateTime($arrivee);

        if ($dateArrivee <= $dateDepart) {
            return response()->json(['error' => 'Le temps d\'arrivée doit être supérieur au temps de départ.']);
        }

        DB::beginTransaction();

        try {
            Finalsetape::create([
                'idcourse' => $id,
                'depart' => $depart,
                'arrivee' => $arrivee
            ],['ignoreErrors' => true]);

            $update = Course::find($id);
            $update->etat = 10;
            $update->save();

            DB::commit();

            return response()->json(['message' => 'Le temps du coureur a été ajouté avec succès']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Une erreur est survenue. Veuillez réessayer.']);
        }
    }
}
