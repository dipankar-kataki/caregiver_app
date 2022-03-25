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
            'question_id' => 'required',
            'answer' => 'required'
        ]);

        if($validator->fails()){
            return $this->error('Whoops! Something went wrong. Failed to submit answers.', $validator->errors() , 'null', 400);
        }else{

            foreach($request->question_id as $key =>  $item){
                foreach($request->answer as $key1 => $item2){
                    if($key == $key1){
                        $data['question_id'] = $item;
                        $data['answer'] = $item2;
                        $data['created_at'] = Carbon::now();
                        $data['updated_at'] = Carbon::now();
                        $insertData[] = $data;
                    }
                }
            }
            Answer::insert($insertData);
            User::where('id', auth('sanctum')->user()->id)->where('role', 2)->update([
                'is_questions_answered' => 1
            ]);
            return $this->success('Answer submitted successfully.', null, 'null', 201);
        }    
    }
}
