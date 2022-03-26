<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\User;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    use ApiResponser;
    public function addAnswer(Request $request){

        $validator = Validator::make($request->all(), [
            'answer' => 'required'
        ]);

        if($validator->fails()){
            return $this->error('Whoops! Something went wrong. Failed to submit answers.', $validator->errors() , 'null', 400);
        }else{

            foreach($request->answer as $key => $item){
                $data['question_id'] = $key + 1;
                $data['answer'] = $item;
                $data['created_at'] = Carbon::now();
                $data['updated_at'] = Carbon::now();
                $insertData[] = $data;
            }

            Answer::insert($insertData);
            User::where('id', auth('sanctum')->user()->id)->where('role', 2)->update([
                'is_questions_answered' => 1
            ]);
            return $this->success('Answer submitted successfully.', null, 'null', 201);
        }    
    }
}
