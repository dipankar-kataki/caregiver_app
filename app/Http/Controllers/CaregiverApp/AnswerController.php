<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
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
            $create = Answer::create([
                'question_id' => $request->question_id,
                'answer' => $request->answer
            ]);

            if($create){
                return $this->error('Answers submitted successfully', null , 'null', 201);
            }else{
                return $this->error('Whoops! Something went wrong. Failed to submit answers.', $validator->errors() , 'null', 400);
            }
        }
    }
}
