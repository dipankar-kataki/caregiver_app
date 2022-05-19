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


    public function index(){
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
            return $this->error('Documents upload failed '.$validator->errors()->first(), null, 'null', 400);
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
                    'name' => $document->getClientOriginalName(),
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($documentCategory == 'childAbuse'){
                ChildAbuse::create([
                    'type' => $type,
                    'name' => $document->getClientOriginalName(),
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($documentCategory == 'criminal'){
                Criminal::create([
                    'type' => $type,
                    'name' => $document->getClientOriginalName(),
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($documentCategory == 'driving'){
                Driving::create([
                    'type' => $type,
                    'name' => $document->getClientOriginalName(),
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($documentCategory == 'employment'){
                EmploymentEligibility::create([
                    'type' => $type,
                    'name' => $document->getClientOriginalName(),
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($documentCategory == 'identification'){
                Identification::create([
                    'type' => $type,
                    'name' => $document->getClientOriginalName(),
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($documentCategory == 'tuberculosis'){
                Tuberculosis::create([
                    'type' => $type,
                    'name' => $document->getClientOriginalName(),
                    'image' => $file,
                    'user_id' => auth('sanctum')->user()->id
                ]);
            }else if($documentCategory == 'w_4_form'){
                w_4_form::create([
                    'type' => $type,
                    'name' => $document->getClientOriginalName(),
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

    public function documentCount(Request $request){
        $details = User::where('id', auth('sanctum')->user()->id)->with('covid','childAbuse','criminal','driving','employment','identification','tuberculosis','w_4_form')->first();
        $documents_count = [
            'covid' => $details->covid->count(),
            'childAbuse' => $details->childAbuse->count(),
            'criminal' => $details->criminal->count(),
            'driving' => $details->driving->count(),
            'employment' => $details->employment->count(),
            'identification' => $details->identification->count(),
            'tuberculosis' => $details->tuberculosis->count(),
            'w_4_form' => $details->w_4_form->count(),
            'is_document_uploaded' => $details->is_documents_uploaded

        ];
        return $this->success('Document count fetched successfully.',  $documents_count, 'null', 200);
    }

    public function isDocumentUploaded(){
        $details = User::where('id', auth('sanctum')->user()->id)->with('covid','childAbuse','criminal','driving','employment','identification','tuberculosis','w_4_form')->first();
        if( !(($details->covid->count() == 0) && ($details->childAbuse->count() == 0) && ($details->criminal->count() == 0) && ($details->driving->count() == 0) && ($details->employment->count() == 0) && ($details->identification->count() == 0) && ($details->tuberculosis->count() == 0) && ( $details->w_4_form->count() == 0)) ){
            $update = User::where('id', auth('sanctum')->user()->id)->where('role', 2)->update([
                'is_documents_uploaded' => 1
            ]);

            if($update){
                return $this->success('Document status updated.',  null, 'null', 201);
            }else{
                return $this->error('Whoops! Something went wrong. Failed to update document status.',  null, 'null', 500);
            }
        }else{
            return $this->error('Whoops! Something went wrong. Failed to update document status.',  null, 'null', 500);
        }
    }


    public function deleteDocument(Request $request){

        $validator = Validator::make($request->all(),[
            'documentCategory' => 'required',
            'id' => 'required'
        ]);
        if($validator->fails()){
            return $this->error('Whoops!, Failed to remove document '.$validator->errors()->first(), null, 'null', 400);
        }else{
            $documentCategory = $request->documentCategory;
            $id = $request->id;

            if($documentCategory == 'covid'){
                Covid::where('id', $id)->delete();
                $doc_count = User::where('id', auth('sanctum')->user()->id)->with('covid')->first();
                if($doc_count->covid->count() == 0 ){
                    User::where('id', auth('sanctum')->user()->id)->update([
                        'is_documents_uploaded' => 0
                    ]);
                }
                return $this->success('Document removed successfully.',  null, 'null', 200);
            }else if($documentCategory == 'childAbuse'){
                ChildAbuse::where('id', $id)->delete();
                $doc_count = User::where('id', auth('sanctum')->user()->id)->with('childAbuse')->first();
                if($doc_count->childAbuse->count() == 0){
                    User::where('id', auth('sanctum')->user()->id)->update([
                        'is_documents_uploaded' => 0
                    ]);
                }
                return $this->success('Document removed successfully.',  null, 'null', 200);
            }else if($documentCategory == 'criminal'){
                Criminal::where('id', $id)->delete();
                $doc_count = User::where('id', auth('sanctum')->user()->id)->with('criminal')->first();
                if($doc_count->criminal->count() == 0){
                    User::where('id', auth('sanctum')->user()->id)->update([
                        'is_documents_uploaded' => 0
                    ]);
                }
                return $this->success('Document removed successfully.',  null, 'null', 200);
            }else if($documentCategory == 'driving'){
                Driving::where('id', $id)->delete();
                $doc_count = User::where('id', auth('sanctum')->user()->id)->with('driving')->first();
                if($doc_count->driving->count() == 0){
                    User::where('id', auth('sanctum')->user()->id)->update([
                        'is_documents_uploaded' => 0
                    ]);
                }
                return $this->success('Document removed successfully.',  null, 'null', 200);
            }else if($documentCategory == 'employment'){
                EmploymentEligibility::where('id', $id)->delete();
                $doc_count = User::where('id', auth('sanctum')->user()->id)->with('employment')->first();
                if($doc_count->employment->count() == 0){
                    User::where('id', auth('sanctum')->user()->id)->update([
                        'is_documents_uploaded' => 0
                    ]);
                }
                return $this->success('Document removed successfully.',  null, 'null', 200);
            }else if($documentCategory == 'identification'){
                Identification::where('id', $id)->delete();
                $doc_count = User::where('id', auth('sanctum')->user()->id)->with('identification')->first();
                if($doc_count->identification->count() == 0){
                    User::where('id', auth('sanctum')->user()->id)->update([
                        'is_documents_uploaded' => 0
                    ]);
                }
                return $this->success('Document removed successfully.',  null, 'null', 200);
            }else if($documentCategory == 'tuberculosis'){
                Tuberculosis::where('id', $id)->delete();
                $doc_count = User::where('id', auth('sanctum')->user()->id)->with('tuberculosis')->first();
                if($doc_count->tuberculosis->count() == 0){
                    User::where('id', auth('sanctum')->user()->id)->update([
                        'is_documents_uploaded' => 0
                    ]);
                }
                return $this->success('Document removed successfully.',  null, 'null', 200);
            }else if($documentCategory == 'w_4_form'){
                w_4_form::where('id', $id)->delete();
                $doc_count = User::where('id', auth('sanctum')->user()->id)->with('w_4_form')->first();
                if($doc_count->w_4_form->count() == 0){
                    User::where('id', auth('sanctum')->user()->id)->update([
                        'is_documents_uploaded' => 0
                    ]);
                }
                return $this->success('Document removed successfully.',  null, 'null', 200);
            }else {
                return $this->error('Whoops!, Failed to remove document', null, 'null', 400);
            }

            
        }
      
    }
}
