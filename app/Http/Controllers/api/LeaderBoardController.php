<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\UserAnswers;
use App\Models\UserExerciseAnswers;
use App\Models\UserQuestionAnswers;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaderBoardController extends Controller
{
    public function index($type)
    {
        if($type == 2) {
            $questions = UserQuestionAnswers::select(
                DB::raw('SUM(point) as score, user_id'))
                ->groupBy('user_id')
                ->whereDate('created_at', Carbon::today())
                ->orderBy('score', 'DESC')
                ->get();
        } elseif($type == 3){
            $questions = UserQuestionAnswers::select(
                DB::raw('SUM(point) as score, user_id'))
                ->groupBy('user_id')
                ->where('created_at', '>=', Carbon::now()->subDays(7))
                ->orderBy('score', 'DESC')
                ->get();
        } else {
            $questions = UserQuestionAnswers::select(
                DB::raw('SUM(point) as score, user_id'))
                ->groupBy('user_id')
                ->orderBy('score', 'DESC')
                ->get();
        }

        $lists = [];

        if (isset($questions)) {
            $rank = 1;
            foreach ($questions as $item) {
                $leader_board_lists[] = [
                    'user_id' => $item->user_id,
                    'user_rank' => $rank++,
                    'full_name' => $item->user->full_name,
                    'avatar' => asset($item->user->avatar),
                    'user_score' => $item->score,
                ];
            }
            $user = Auth::user();
            $total_point = 0;
            $total_point = calculate_question_score($user->id);
            if (!empty($leader_board_lists)) {
                return response()->json([
                    'success' => true,
                    'message' => __('Leader Board List'),
                    'total_point' => $total_point,
                    'leader_board_list' => $leader_board_lists,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('No data found')
                ], 200);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => __('No data found')
            ], 200);
        }

    }

}
