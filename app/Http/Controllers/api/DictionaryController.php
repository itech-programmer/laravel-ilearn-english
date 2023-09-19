<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\dictionaries\Dictionaries;
use Illuminate\Support\Facades\Auth;

class DictionaryController extends Controller
{
    public function index()
    {
        $dictionaries = Dictionaries::where('active_status', 1)->get();
        $item = [];
        if (isset($dictionaries)) {
            foreach ($dictionaries as $dictionary) {
                $item[] = [
                    'id' => $dictionary->id,
                    'en_word' => $dictionary->en_word,
                    'en_definition' => $dictionary->en_definition,
                    'uz_word' => $dictionary->uz_word,
                    'uz_definition' => $dictionary->uz_definition,
                    'qr_word' => $dictionary->qr_word,
                    'qr_definition' => $dictionary->qr_definition,
                    'ru_word' => $dictionary->ru_word,
                    'ru_definition' => $dictionary->ru_definition,
                ];
            }
            $user = Auth::user();
            $total_point = 0;
            $total_point = calculate_question_score($user->id);
            if (!empty($item)) {
                return response()->json([
                    'success' => true,
                    'message' => __('Course List'),
                    'total_point' => $total_point,
                    'dictionary_list' => $item,
                ], 200);
            }else{
                return response()->json([
                    'success' =>  false,
                    'message' => __('No data found'),
                ], 200);
            }
        } else {
            return response()->json([
                'success' =>  false,
                'message' => __('No data found'),
            ], 200);
        }
    }
}
