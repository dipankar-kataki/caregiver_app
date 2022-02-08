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
    public function uploadDocument(Request $request){

        $validator = Validator::make($request->all(),[
            'type' => 'required',
            'image' => 'required'
        ],[
            'type.required' => 'Document type is required',
            'image.required' => 'Image is required'
        ]);

        if($validator->fails()){
            return $this->error('Documents upload failed', $validator->errors(), 'null', 400);
        }else{


            $type = $request->type;
            $document = $request->image;
            $file = '';
            if($request->hasFile('image')){
                $new_name = date('d-m-Y-H-i-s') . '_' . $document->getClientOriginalName();
                $document->move(public_path('caregiver-app/documents/'), $new_name);
                $file = 'caregiver-app/documents/' . $new_name;
            }

            if($type == 'covid'){
                Covid::create([
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($type == 'childAbuse'){
                ChildAbuse::create([
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($type == 'criminal'){
                Criminal::create([
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($type == 'driving'){
                Driving::create([
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($type == 'employment'){
                EmploymentEligibility::create([
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($type == 'identification'){
                Identification::create([
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($type == 'tuberculosis'){
                Tuberculosis::create([
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($type == 'w_4_form'){
                w_4_form::create([
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else {
                return $this->error('Whoops!, Documents upload failed', null, 'null', 400);
            }
            
            $details = User::where('id', auth('sanctum')->user()->id)->with('covid','childAbuse','criminal','driving','employment','identification','tuberculosis','w_4_form')->first();


            // Below code is for base 64 image

            // $extension = explode('/', explode(':', substr($imageFile, 0, strpos($imageFile, ';')))[1])[1];   // .jpg .png .pdf
            // $replace = substr($imageFile, 0, strpos($imageFile, ',')+1); 
            
            // $image = str_replace($replace, '', $imageFile); 
            // $image = str_replace(' ', '+', $image); 
            // $imageName = $type.'-'.time().'.'.$extension;
            
            // Storage::disk('public')->put($imageName, base64_decode($image));
            // $path = Storage::url($imageName);
            return $this->success('Document uploaded successfully.',  $details, 'null', 201);
           
        }
       
    }
}
