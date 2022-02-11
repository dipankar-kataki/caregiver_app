<?php

namespace App\Http\Controllers\CaregiverApp;

use App\Http\Controllers\Controller;
use App\Models\ChildAbuse;
use App\Models\Covid;
use App\Models\Criminal;
use App\Models\Document;
use App\Models\Driving;
use App\Models\EmploymentEligibility;
use App\Models\Identification;
use App\Models\Tuberculosis;
use App\Models\User;
use App\Models\w_4_form;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    use ApiResponser;


    public function index(Request $request){
        $details = User::where('id', auth('sanctum')->user()->id)->with('covid','childAbuse','criminal','driving','employment','identification','tuberculosis','w_4_form')->first();
        return $this->success('Document fetched successfully.',  $details, 'null', 200);
    }

    public function uploadDocument(Request $request){

        $validator = Validator::make($request->all(),[
            'documentCategory' => 'required',
            'document' => 'required|mimes:jpg,png,jpeg,pdf|max:2048'
        ],[
            'documentCategory.required' => 'Document category is required',
            'document.required' => 'Document is required'
        ]);

        if($validator->fails()){
            return $this->error('Documents upload failed', $validator->errors(), 'null', 400);
        }else{

            $documentCategory = $request->documentCategory;
            $extension = $request->file('document')->extension();
            $document = $request->document;

            // Upload file to folder
            $new_name = date('d-m-Y-H-i-s') . '_' . $document->getClientOriginalName();
            $document->move(public_path('caregiver-app/documents/'), $new_name);
            $file = 'caregiver-app/documents/' . $new_name;

            $type = '';

            if(($extension == 'png') || ($extension == 'jpg') || ($extension == 'jpeg')){
                $type = 'image';
            }else{
                $type = 'pdf';
            }

            if($documentCategory == 'covid'){
                Covid::create([
                    'type' => $type,
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($documentCategory == 'childAbuse'){
                ChildAbuse::create([
                    'type' => $type,
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($documentCategory == 'criminal'){
                Criminal::create([
                    'type' => $type,
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($documentCategory == 'driving'){
                Driving::create([
                    'type' => $type,
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($documentCategory == 'employment'){
                EmploymentEligibility::create([
                    'type' => $type,
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($documentCategory == 'identification'){
                Identification::create([
                    'type' => $type,
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($documentCategory == 'tuberculosis'){
                Tuberculosis::create([
                    'type' => $type,
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($documentCategory == 'w_4_form'){
                w_4_form::create([
                    'type' => $type,
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else {
                return $this->error('Whoops!, Documents upload failed', null, 'null', 400);
            }
            
            $details = User::where('id', auth('sanctum')->user()->id)->with('covid','childAbuse','criminal','driving','employment','identification','tuberculosis','w_4_form')->first();


        //     // Below code is for base 64 image

        //     // $extension = explode('/', explode(':', substr($imageFile, 0, strpos($imageFile, ';')))[1])[1];   // .jpg .png .pdf
        //     // $replace = substr($imageFile, 0, strpos($imageFile, ',')+1); 
            
        //     // $image = str_replace($replace, '', $imageFile); 
        //     // $image = str_replace(' ', '+', $image); 
        //     // $imageName = $type.'-'.time().'.'.$extension;
            
        //     // Storage::disk('public')->put($imageName, base64_decode($image));
        //     // $path = Storage::url($imageName);
            return $this->success('Document uploaded successfully.',  $details, 'null', 201);
           
        }
       
    }
}
