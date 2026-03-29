<?php

namespace App\Http\Controllers\Api\AuthenticationCenter\People;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\People\BirthCertificate as RecordModel;
use App\Http\Controllers\CrudController;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use FilippoToso\PdfWatermarker\Facades\ImageWatermarker;
use FilippoToso\PdfWatermarker\Support\Pdf;
use FilippoToso\PdfWatermarker\Watermarks\ImageWatermark;
use FilippoToso\PdfWatermarker\PdfWatermarker;
use FilippoToso\PdfWatermarker\Support\Position;


class BirthCertificateController extends Controller
{
    private $selectFields = [
        'id' ,
        'people_id' ,
        'birth_number' ,
        'book_number' ,
        'year' ,
        'province_id' ,
        'district_id' ,
        'commune_id' ,
        'firstname' ,
        'lastname' ,
        'profession' , 
        'organization' ,
        'enfirstname' ,
        'enlastname' ,
        'dob' ,
        'gender' ,
        'nationality' ,
        'national' ,
        'pob' ,
        'issued_date' ,
        // 'issued_location' ,
        // 'signed_name' ,
        'wedding_certificate_id' ,
        'pdf' ,
        'created_by' ,
        'updated_by' ,
        'created_at' ,
        'updated_at' ,
        // 'father_firstname' ,
        // 'father_lastname'  ,
        // 'father_enfirstname' ,
        // 'father_enlastname' ,
        // 'father_dob' ,
        // 'father_nationality' ,
        // 'father_pob' ,

        // 'mother_firstname' ,
        // 'mother_lastname' ,
        // 'mother_enfirstname' ,
        // 'mother_enlastname' ,
        // 'mother_dob' ,
        // 'mother_nationality' ,
        // 'mother_pob'
    ];
        
    /**
     * Listing function
     */
    public function index(Request $request){
        $user = \Auth::user() != null ? \Auth::user() : false ;

        /** Format from query string */
        $search = isset( $request->search ) && $request->serach !== "" ? $request->search : false ;
        $perPage = isset( $request->perPage ) && $request->perPage !== "" ? $request->perPage : 10 ;
        $page = isset( $request->page ) && $request->page !== "" ? $request->page : 1 ;

        $people = intval( $request->people_id ) > 0 ? \App\Models\People\People::find( intval( $request->people_id ) ) : null ;

        $weddingCertificateIds = false ;
        if( $people != null && $people->weddingCertificates != null && count( $people->weddingCertificates ) >= 0 ){
            $weddingCertificateIds = $people->weddingCertificates->pluck('id');
            // return response()->json($people->weddingCertificates->pluck('id'));
        }
        
        $queryString = [
            "where" => [
                'default' => [
                    $people == null ? [] 
                    : [
                        'field' => 'people_id' ,
                        'value' => $people->id
                    ]
                ],
                // 'in' => [
                //     $user->roles()->pluck('name')->filter( function( $val , $key ) {
                //         return $val == 'backend' ;
                //     } )->count()
                //         ?[ 
                //             'field' => 'created_by' ,
                //             'value' => [$user->id] 
                //         ]
                //         : []
                //     // ,
                //     // [
                //     //     'field' => 'active' ,
                //     //     'value' => 1
                //     // ] ,
                //     // [
                //     //     'field' => 'publish' ,
                //     //     'value' => 1
                //     // ] ,
                //     // [
                //     //     'field' => 'accessibility' ,
                //     //     'value' => [ 1,2,3,4 ]
                //     // ]
                // ] ,
                'not' => [
                    count( $weddingCertificateIds )
                        ?[ 
                            'field' => 'wedding_certificate_id' ,
                            'value' => $weddingCertificateIds
                        ]
                        : []
                ] ,
                // 'like' => [
                //     [
                //         'field' => 'fid' ,
                //         'value' => $fid === false ? "" : $fid
                //     ],
                //     [
                //         'field' => 'year' ,
                //         'value' => $date === false ? "" : $date
                //     ]
                // ] ,
            ] ,
            // "pivots" => [
            //     $types ?
            //     [
            //         "relationship" => 'type',
            //         "where" => [
            //             "in" => [
            //                 "field" => "document_type",
            //                 "value" => $types
            //             ],
            //         ]
            //     ]
            //     : [] ,
            // ],
            "pagination" => [
                'perPage' => $perPage,
                'page' => $page
            ],
            "search" => $search === false ? [] : [
                'value' => $search ,
                'fields' => [
                    'birth_number' ,
                    'book_number' ,
                    'year' ,
                    'firstname' ,
                    'lastname' ,
                    'enfirstname' ,
                    'enlastname'
                ]
            ],
            "order" => [
                'field' => 'birth_number' ,
                'by' => 'desc'
            ],
        ];

        $request->merge( $queryString );

        $crud = new CrudController(new RecordModel(), $request, $this->selectFields,[
            /**
             * custom the value of the field
             */
            'pdf' => function($record){
                $record->pdf = ( strlen( $record->pdf ) > 0 && \Storage::disk('certificate')->exists( $record->pdf ) )
                ? true
                // \Storage::disk('regulator')->url( $pdf ) 
                : false ;
                return $record->pdf ;
            }
        ]);

        $crud->setRelationshipFunctions([
            /** relationship name => [ array of fields name to be selected ] */
            'people' => [ 'id' , 'firstname' ,'lastname' , 'enfirstname' , 'enlastname' ,
                'weddingCertificates' => [ 
                    'id' ,
                    'wedding_number' ,
                    'book_number' ,
                    'year' ,
                    'province_id' ,
                    'district_id' ,
                    'commune_id' ,
                    'issued_date' ,
                    'issued_location' ,
                    'signed_name' ,
                    'pdf' ,
                    // Husband
                    'spouse_id' ,
                    'spouse_firstname' ,
                    'spouse_lastname' ,
                    'spouse_enlastname' ,
                    'spouse_enfirstname' ,
                    'spouse_profession' ,
                    'spouse_dob' ,
                    'spouse_pob' ,
                    'spouse_address' ,
                    'spouse_nationality' ,
                    'spouse_national' ,
                    // Husband father
                    'spouse_father_firstname' ,
                    'spouse_father_lastname'  ,
                    'spouse_father_enfirstname' ,
                    'spouse_father_enlastname' ,
                    'spouse_father_dob' ,
                    'spouse_father_nationality' ,
                    'spouse_father_pob' ,
                    // Husband mother
                    'spouse_mother_firstname' ,
                    'spouse_mother_lastname' ,
                    'spouse_mother_enfirstname' ,
                    'spouse_mother_enlastname' ,
                    'spouse_mother_dob' ,
                    'spouse_mother_nationality' ,
                    'spouse_mother_pob'
                ]
            ] ,
            'province' => [ 'id' , 'name_en' , 'name_kh' , 'code' ] ,
            'district' => [ 'id' , 'name_en' , 'name_kh' , 'code' ] ,
            'commune' => [ 'id' , 'name_en' , 'name_kh' , 'code' ]
        ]);

        $builder = $crud->getListBuilder();

        $responseData = $crud->pagination(true, $builder);
        $responseData['records'] = $responseData['records']->map(function($record){
            $people = intval( $record['people_id'] ) > 0 ? \App\Models\People\People::find( intval( $record['people_id'] ) ) : null ;
            if( $people != null ){
                $record['people']['weddingCertificates'] = $people->weddingCertificates == null ? [] :
                $people->weddingCertificates->map(function( $wc ){
                    $wc->birthCertificates;
                    return $wc ;
                });
            }else {
                $record['people'] = null ;
            }
            return $record ;
        });
        $responseData['message'] = __("crud.read.success");
        $responseData['ok'] = true ;
        // $responseData['server'] = $_SERVER ;
        return response()->json($responseData, 200);
    }
    /**
     * Listing Child Birth Date
     */
    public function listChildren(Request $request){
        $user = \Auth::user() != null ? \Auth::user() : false ;

        /** Format from query string */
        $search = isset( $request->search ) && $request->serach !== "" ? $request->search : false ;
        $perPage = isset( $request->perPage ) && $request->perPage !== "" ? $request->perPage : 10 ;
        $page = isset( $request->page ) && $request->page !== "" ? $request->page : 1 ;

        $people = intval( $request->people_id ) > 0 ? \App\Models\People\People::find( intval( $request->people_id ) ) : null ;

        if( $people == null ){
            return response()->json([
                'ok' => false ,
                'message' => 'លេខសម្គាល់ ឪពុក ម្ដាយ មិនត្រឹមត្រូវ។'
            ],500);
        }
        if( $people->weddingCertificates == null || ( $people->weddingCertificates != null && count( $people->weddingCertificates ) <= 0 ) ){
            return response()->json([
                'ok' => false ,
                'message' => 'មិនមានលិខិតអាពាហ៍ពិពាហ៍ឡើយ។'
            ],500);
        }

        $weddingCertificateIds = $people->weddingCertificates->pluck('id');

        $queryString = [
            "where" => [
                'default' => [
                    $people == null ? [] 
                    : [
                        'field' => 'people_id' ,
                        'value' => $people->id
                    ]
                ],
                'in' => [
                    count( $weddingCertificateIds )
                        ?[ 
                            'field' => 'wedding_certificate_id' ,
                            'value' => $weddingCertificateIds
                        ]
                        : []
                    // ,
                    // [
                    //     'field' => 'active' ,
                    //     'value' => 1
                    // ] ,
                    // [
                    //     'field' => 'publish' ,
                    //     'value' => 1
                    // ] ,
                    // [
                    //     'field' => 'accessibility' ,
                    //     'value' => [ 1,2,3,4 ]
                    // ]
                ] ,
                // 'not' => [
                //     [
                //         'field' => 'type' ,
                //         'value' => [4]
                //     ]
                // ] ,
                // 'like' => [
                //     [
                //         'field' => 'fid' ,
                //         'value' => $fid === false ? "" : $fid
                //     ],
                //     [
                //         'field' => 'year' ,
                //         'value' => $date === false ? "" : $date
                //     ]
                // ] ,
            ] ,
            // "pivots" => [
            //     $types ?
            //     [
            //         "relationship" => 'type',
            //         "where" => [
            //             "in" => [
            //                 "field" => "document_type",
            //                 "value" => $types
            //             ],
            //         ]
            //     ]
            //     : [] ,
            // ],
            "pagination" => [
                'perPage' => $perPage,
                'page' => $page
            ],
            "search" => $search === false ? [] : [
                'value' => $search ,
                'fields' => [
                    'birth_number' ,
                    'book_number' ,
                    'year' ,
                    'firstname' ,
                    'lastname' ,
                    'enfirstname' ,
                    'enlastname'
                ]
            ],
            "order" => [
                'field' => 'birth_number' ,
                'by' => 'desc'
            ],
        ];

        $request->merge( $queryString );

        $crud = new CrudController(new RecordModel(), $request, $this->selectFields,[
            /**
             * custom the value of the field
             */
            'pdf' => function($record){
                $record->pdf = ( strlen( $record->pdf ) > 0 && \Storage::disk('certificate')->exists( $record->pdf ) )
                ? true
                // \Storage::disk('regulator')->url( $pdf ) 
                : false ;
                return $record->pdf ;
            }
        ]);

        $crud->setRelationshipFunctions([
            /** relationship name => [ array of fields name to be selected ] */
            'people' => [ 'id' , 'firstname' ,'lastname' , 'enfirstname' , 'enlastname' 
                // , 'weddingCertificates' => [ 
                //     'id' ,
                //     'wedding_number' ,
                //     'book_number' ,
                //     'year' ,
                //     'province_id' ,
                //     'district_id' ,
                //     'commune_id' ,
                //     'issued_date' ,
                //     'issued_location' ,
                //     'signed_name' ,
                //     'pdf' ,
                //     // Husband
                //     'spouse_id' ,
                //     'spouse_firstname' ,
                //     'spouse_lastname' ,
                //     'spouse_enlastname' ,
                //     'spouse_enfirstname' ,
                //     'spouse_profession' ,
                //     'spouse_dob' ,
                //     'spouse_pob' ,
                //     'spouse_address' ,
                //     'spouse_nationality' ,
                //     'spouse_national' ,
                //     // Husband father
                //     'spouse_father_firstname' ,
                //     'spouse_father_lastname'  ,
                //     'spouse_father_enfirstname' ,
                //     'spouse_father_enlastname' ,
                //     'spouse_father_dob' ,
                //     'spouse_father_nationality' ,
                //     'spouse_father_pob' ,
                //     // Husband mother
                //     'spouse_mother_firstname' ,
                //     'spouse_mother_lastname' ,
                //     'spouse_mother_enfirstname' ,
                //     'spouse_mother_enlastname' ,
                //     'spouse_mother_dob' ,
                //     'spouse_mother_nationality' ,
                //     'spouse_mother_pob' ,
                // ]
            ] ,
            'province' => [ 'id' , 'name_kh' , 'name_en' , 'code' ] ,
            'district' => [ 'id' , 'name_kh' , 'name_en' , 'code' ] ,
            'commune' => [ 'id' , 'name_kh' , 'name_en' , 'code' ]
        ]);

        $builder = $crud->getListBuilder();

        $responseData = $crud->pagination(true, $builder);
        // $responseData['records'] = $responseData['records']->map(function($record){
        //     $people = intval( $record['people_id'] ) > 0 ? \App\Models\People\People::find( intval( $record['people_id'] ) ) : null ;
        //     if( $people != null ){
        //         $record['people']['weddingCertificates'] = $people->weddingCertificates == null ? [] :
        //         $people->weddingCertificates->map(function( $wc ){
        //             $wc->birthCertificates;
        //             return $wc ;
        //         });
        //     }else {
        //         $record['people'] = null ;
        //     }
        //     return $record ;
        // });
        $responseData['message'] = __("crud.read.success");
        $responseData['ok'] = true ;
        // $responseData['server'] = $_SERVER ;
        return response()->json($responseData, 200);
    }
    /**
     * View the pdf file
     */
    public function pdf(Request $request)
    {
        $certificate = RecordModel::findOrFail($request->id);
        if($certificate) {
            $pathPdf = storage_path('data') . '/certificates/' . $certificate->pdf ;
            $filename = $this->resolveDownloadFilename( $certificate );
        
            /**   Log the access of the user */
            // $user = \Auth::user() != null ? \Auth::user() : auth('api')->user() ;
            // if( $user != null ){
            //     \App\Models\Log\Log::regulator([
            //         'system' => 'client' ,
            //         'user_id' => $user->id ,
            //         'regulator_id' => $document->id
            //     ]);
            // }

            if(file_exists( $pathPdf ) && is_file($pathPdf)) {
                $pdfBase64 = base64_encode( file_get_contents( $pathPdf ) );
                return response([
                    'serial' => $certificate->pdf ,
                    "pdf" => 'data:application/pdf;base64,' . $pdfBase64 ,
                    "filename" => $filename,
                    "ok" => true 
                ],200);
            }else
            {
                return response([
                    'message' => 'មានបញ្ហាក្នុងការអានឯកសារ !' ,
                    'path' => $pathPdf
                ],500 );
            }
        }
    }
    public function upload(Request $request){
        $user = \Auth::user();
        if( $user ){
            $phpFileUploadErrors = [
                0 => 'មិនមានបញ្ហាជាមួយឯកសារឡើយ។',
                1 => "ទំហំឯកសារធំហួសកំណត់ " . ini_get("upload_max_filesize"),
                2 => 'ទំហំឯកសារធំហួសកំណត់នៃទំរង់បញ្ចូលទិន្នន័យ ' . ini_get('post_max_size'),
                3 => 'The uploaded file was only partially uploaded',
                4 => 'No file was uploaded',
                6 => 'Missing a temporary folder',
                7 => 'Failed to write file to disk.',
                8 => 'A PHP extension stopped the file upload.',
            ];
            
            if( isset( $_FILES['file'] ) && $_FILES['file']['error'] > 0 ){
                return response()->json([
                    'ok' => false ,
                    'message' => $phpFileUploadErrors[ $_FILES['file']['error'] ]
                ],403);
            }

            $kbFilesize = round( filesize( $_FILES['file']['tmp_name'] ) / 1024 , 4 );
            $mbFilesize = round( $kbFilesize / 1024 , 4 );
            if( ( $certificate = RecordModel::find($request->id) ) !== null ){
                $uploadedFile = $request->file('file');
                $originalFileName = $uploadedFile != null
                    ? $uploadedFile->getClientOriginalName()
                    : ( $_FILES['file']['name'] ?? 'birth-certificate.pdf' );
                $storedFileName = $this->buildStoredPdfFileName( $certificate , $originalFileName );

                if(
                    strlen( (string) $certificate->pdf ) > 0
                    && $certificate->pdf !== $storedFileName
                    && Storage::disk('certificate')->exists( $certificate->pdf )
                ){
                    Storage::disk('certificate')->delete( $certificate->pdf );
                }

                Storage::disk('certificate')->putFileAs( '' , new File( $_FILES['file']['tmp_name'] ) , $storedFileName );
                $certificate->pdf = $storedFileName ;
                $certificate->save();
                if( Storage::disk('certificate')->exists( $certificate->pdf ) ){
                    $certificate->download_filename = $this->resolveDownloadFilename( $certificate );
                    $certificate->pdf = Storage::disk("certificate")->url( $certificate->pdf  );
                    return response([
                        'record' => $certificate ,
                        'filename' => $certificate->download_filename ,
                        'message' => 'ជោគជ័យក្នុងការបញ្ចូលឯកសារយោង។'
                    ],200);
                }else{
                    return response([
                        'record' => $certificate ,
                        'message' => 'មិនមានឯកសារយោងដែលស្វែងរកឡើយ។'
                    ],403);
                }
            }else{
                return response([
                    'message' => 'សូមបញ្ជាក់អំពីលេខសម្គាល់របស់ឯកសារយោង។'
                ],403);
            }
        }else{
            return response([
                'message' => 'សូមចូលប្រព័ន្ធជាមុនសិន។'
            ],403);
        }
    }
    private function buildStoredPdfFileName( $certificate , $originalFileName ){
        $originalValue = trim( str_replace( "\0" , '' , (string) $originalFileName ) );
        $baseFileName = basename( $originalValue );

        if( strlen( $baseFileName ) == 0 ){
            $baseFileName = 'birth-certificate.pdf';
        }
        if( strlen( pathinfo( $baseFileName , PATHINFO_EXTENSION ) ) == 0 ){
            $baseFileName .= '.pdf';
        }

        return $certificate->id . '-' . rawurlencode( $baseFileName );
    }
    private function resolveDownloadFilename( $certificate ){
        $storedName = basename( (string) $certificate->pdf );
        $extension = pathinfo( $storedName , PATHINFO_EXTENSION );
        $baseName = pathinfo( $storedName , PATHINFO_FILENAME );

        if( preg_match('/^\d+-(.+)$/', $baseName , $matches ) ){
            $decodedBaseName = rawurldecode( $matches[1] );
            if( strlen( trim( $decodedBaseName ) ) > 0 ){
                return $decodedBaseName . ( strlen( $extension ) > 0 && !str_ends_with( strtolower( $decodedBaseName ) , '.' . strtolower( $extension ) ) ? '.' . $extension : '' );
            }
        }

        if( isset( $certificate->field_name ) && is_string( $certificate->field_name ) && strlen( trim( $certificate->field_name ) ) > 0 ){
            $fieldName = trim( $certificate->field_name );
            $lowerFieldName = strtolower( $fieldName );
            $extensionSuffix = strlen( $extension ) > 0 ? '.' . strtolower( $extension ) : '';
            return $extensionSuffix !== '' && !str_ends_with( $lowerFieldName , $extensionSuffix )
                ? $fieldName . '.' . $extension
                : $fieldName;
        }

        return strlen( $storedName ) > 0 ? $storedName : 'birth-certificate.pdf';
    }
    private function getExistingBirthCertificate( $peopleId , $weddingCertificateId = 0 ){
        $query = RecordModel::where('people_id', intval( $peopleId ) );

        if( intval( $weddingCertificateId ) > 0 ){
            $query->where('wedding_certificate_id', intval( $weddingCertificateId ) );
        }else{
            $query->where(function( $innerQuery ){
                $innerQuery->whereNull('wedding_certificate_id')
                ->orWhere('wedding_certificate_id',0);
            });
        }

        return $query->orderBy('id','desc')->first();
    }
    private function syncPrimaryKeySequence(){
        if( DB::getDriverName() !== 'pgsql' ){
            return;
        }

        $maxId = RecordModel::withTrashed()->max('id');
        if( intval( $maxId ) > 0 ){
            DB::select(
                "SELECT setval(pg_get_serial_sequence('birth_certificates', 'id'), ?, true)",
                [ intval( $maxId ) ]
            );
        }
    }
    public function create(Request $request){
        /**
         * Save information of the regulator and its related information
         */
        $people = intval( $request->people_id ) > 0 ? \App\Models\People\People::find( intval( $request->people_id ) ) : null ;
        if( $people == null ){
            return response()->json([
                'ok' => false ,
                'message' => 'សូមបញ្ជាក់ម្ចាស់ឯកសារ'
            ],500);
        }
        $weddingCertificateId = intval( $request->wedding_certificate_id ) > 0 ? intval( $request->wedding_certificate_id ) : 0 ;
        $existingRecord = $this->getExistingBirthCertificate( $people->id , $weddingCertificateId );
        if( $existingRecord != null ){
            $request->merge([
                'id' => $existingRecord->id ,
                'people_id' => $people->id ,
                'wedding_certificate_id' => $weddingCertificateId
            ]);
            return $this->update( $request );
        }

        $normalizeDigits = function( $value ){
            return preg_replace('/\D+/', '', \App\Utils\Helper::toLnumber( (string) $value ) );
        };
        $normalizeLocationId = function( $value ){
            return intval( $value ) > 0 ? intval( $value ) : 0;
        };

        $provinceId = $normalizeLocationId( $request->province_id ?? 0 );
        $districtId = $normalizeLocationId( $request->district_id ?? 0 );
        $communeId = $normalizeLocationId( $request->commune_id ?? 0 );
        if( $districtId > 0 ){
            $district = \App\Models\Location\District::find( $districtId );
            if( $district == null || $provinceId <= 0 || intval( $district->province_id ) !== $provinceId ){
                return response()->json([
                    'ok' => false ,
                    'message' => 'Selected district does not belong to the selected province.'
                ], 422);
            }
        }
        if( $communeId > 0 ){
            $commune = \App\Models\Location\Commune::find( $communeId );
            if( $commune == null || $districtId <= 0 || intval( $commune->district_id ) !== $districtId ){
                return response()->json([
                    'ok' => false ,
                    'message' => 'Selected commune does not belong to the selected district.'
                ], 422);
            }
        }

        $this->syncPrimaryKeySequence();
        $record = RecordModel::create([
            'people_id' => $people->id ,
            'birth_number' => $normalizeDigits( $request->birth_number ?? '' ) ,
            'book_number' => $normalizeDigits( $request->book_number ?? '' ) ,
            'year' => isset( $request->year ) && strlen( $request->year ) ? $request->year : \Carbon\Carbon::now()->format('Y') ,
            'province_id' => $provinceId ,
            'district_id' => $districtId ,
            'commune_id' => $communeId ,
            'profession' => $request->profession??'' ,
            'organization' => $request->organization??'' ,
            'firstname' => $request->firstname?? '' ,
            'lastname' => $request->lastname?? '' ,
            'enfirstname' => $request->enfirstname?? '' ,
            'enlastname' => $request->enlastname?? '' ,
            'dob' => isset( $request->dob ) && strlen( $request->dob ) ? \Carbon\Carbon::parse( $request->dob )->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') ,
            'gender' => $request->gender?? 'male' ,
            'nationality' => $request->nationality?? 'ខ្មែរ' ,
            'national' => $request->national?? 'ខ្មែរ' ,
            'pob' => $request->pob?? '' ,
            'issued_date' => isset( $request->issued_date ) && strlen( $request->issued_date ) ? \Carbon\Carbon::parse( $request->issued_date )->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') ,
            'issued_location' => $request->issued_location?? '' ,
            // 'signed_name' => $request->signed_name?? '' ,
            'wedding_certificate_id' => $weddingCertificateId ,
            'pdf' => '' ,
            
            // 'father_firstname' => $request->father_firstname?? '' ,
            // 'father_lastname' => $request->father_lastname?? '' ,
            // 'father_enfirstname' => $request->father_enfirstname?? '' ,
            // 'father_enlastname' => $request->father_enlastname?? '' ,
            // 'father_dob' => strlen( $request->father_dob ) ? \Carbon\Carbon::parse( $request->father_dob )->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') ,
            // 'father_nationality' => $request->father_nationality?? 'ខ្មែរ' ,
            // 'father_pob' => $request->father_pob?? '' ,

            // 'mother_firstname' => $request->mother_firstname?? '' ,
            // 'mother_lastname' => $request->mother_lastname?? '' ,
            // 'mother_enfirstname' => $request->mother_enfirstname?? '' ,
            // 'mother_enlastname' => $request->mother_enlastname?? '' ,
            // 'mother_dob' => strlen( $request->mother_dob ) ? \Carbon\Carbon::parse( $request->mother_dob )->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') ,
            // 'mother_nationality' => $request->mother_nationality?? 'ខ្មែរ' ,
            // 'mother_pob' => $request->mother_pob?? '' ,

            'created_by' => \Auth::user()->id ,
            'updated_by' => \Auth::user()->id ,
            'created_at' => \Carbon\Carbon::now()->format('Y-m-d') ,
            'updated_at' => \Carbon\Carbon::now()->format('Y-m-d')
        ]);
        
        $responseData['message'] = __("crud.read.success");
        $responseData['ok'] = true ;
        $responseData['record'] = $record ;
        return response()->json($responseData, 200);
    }
    public function update(Request $request){
        if( !isset( $request->id ) || intval( $request->id ) <= 0 ){
            return response()->json([
                'ok' => false ,
                'message' => 'Birth certificate id is required.'
            ], 422);
        }

        $record = RecordModel::find( intval( $request->id ) );
        if( $record == null ){
            return response()->json([
                'ok' => false ,
                'message' => 'Birth certificate not found.'
            ], 404);
        }

        $people = intval( $request->people_id ) > 0 ? \App\Models\People\People::find( intval( $request->people_id ) ) : $record->people ;
        if( $people == null ){
            return response()->json([
                'ok' => false ,
                'message' => 'Invalid birth certificate owner.'
            ], 422);
        }

        $weddingCertificateId = $request->has('wedding_certificate_id')
            ? ( intval( $request->wedding_certificate_id ) > 0 ? intval( $request->wedding_certificate_id ) : 0 )
            : $record->wedding_certificate_id ;

        $normalizeDigits = function( $value ){
            return preg_replace('/\D+/', '', \App\Utils\Helper::toLnumber( (string) $value ) );
        };
        $normalizeLocationId = function( $value ){
            return intval( $value ) > 0 ? intval( $value ) : 0;
        };

        $provinceId = $request->has('province_id')
            ? $normalizeLocationId( $request->province_id ?? 0 )
            : intval( $record->province_id ?? 0 );
        $districtId = $request->has('district_id')
            ? $normalizeLocationId( $request->district_id ?? 0 )
            : intval( $record->district_id ?? 0 );
        $communeId = $request->has('commune_id')
            ? $normalizeLocationId( $request->commune_id ?? 0 )
            : intval( $record->commune_id ?? 0 );

        if( $districtId > 0 ){
            $district = \App\Models\Location\District::find( $districtId );
            if( $district == null || $provinceId <= 0 || intval( $district->province_id ) !== $provinceId ){
                return response()->json([
                    'ok' => false ,
                    'message' => 'Selected district does not belong to the selected province.'
                ], 422);
            }
        }
        if( $communeId > 0 ){
            $commune = \App\Models\Location\Commune::find( $communeId );
            if( $commune == null || $districtId <= 0 || intval( $commune->district_id ) !== $districtId ){
                return response()->json([
                    'ok' => false ,
                    'message' => 'Selected commune does not belong to the selected district.'
                ], 422);
            }
        }

        $updateData = [
            'birth_number' => $request->has('birth_number') ? $normalizeDigits( $request->birth_number ?? '' ) : $record->birth_number ,
            'book_number' => $request->has('book_number') ? $normalizeDigits( $request->book_number ?? '' ) : $record->book_number ,
            'year' => $request->has('year') ? ( ( isset( $request->year ) && strlen( $request->year ) > 0 ) ? $request->year : \Carbon\Carbon::now()->format('Y') ) : $record->year ,
            'province_id' => $provinceId ,
            'district_id' => $districtId ,
            'commune_id' => $communeId ,
            'profession' => $request->has('profession') ? ( $request->profession ?? '' ) : $record->profession ,
            'organization' => $request->has('organization') ? ( $request->organization ?? '' ) : $record->organization ,
            'firstname' => $request->has('firstname') ? ( $request->firstname ?? '' ) : $record->firstname ,
            'lastname' => $request->has('lastname') ? ( $request->lastname ?? '' ) : $record->lastname ,
            'enfirstname' => $request->has('enfirstname') ? ( $request->enfirstname ?? '' ) : $record->enfirstname ,
            'enlastname' => $request->has('enlastname') ? ( $request->enlastname ?? '' ) : $record->enlastname ,
            'dob' => $request->has('dob')
                ? ( ( isset( $request->dob ) && strlen( $request->dob ) > 0 ) ? \Carbon\Carbon::parse( $request->dob )->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') )
                : $record->dob ,
            'gender' => $request->has('gender') ? ( $request->gender ?? 'male' ) : $record->gender ,
            'nationality' => $request->has('nationality') ? ( $request->nationality ?? $record->nationality ) : $record->nationality ,
            'national' => $request->has('national') ? ( $request->national ?? $record->national ) : $record->national ,
            'pob' => $request->has('pob') ? ( $request->pob ?? '' ) : $record->pob ,
            'issued_date' => $request->has('issued_date')
                ? ( ( isset( $request->issued_date ) && strlen( $request->issued_date ) > 0 ) ? \Carbon\Carbon::parse( $request->issued_date )->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') )
                : $record->issued_date ,
            'wedding_certificate_id' => $weddingCertificateId ,
            'updated_by' => \Auth::user()->id ,
            'updated_at' => \Carbon\Carbon::now()->format('Y-m-d')
        ];

        if( !$record->update( $updateData ) ){
            return response()->json([
                'ok' => false ,
                'message' => 'Unable to save birth certificate.'
            ], 403);
        }

        $record = $record->fresh();
        $record->province;
        $record->district;
        $record->commune;
        $record->people;

        $responseData['message'] = __("crud.read.success");
        $responseData['ok'] = true ;
        $responseData['record'] = $record ;
        return response()->json($responseData, 200);
    }
    public function updateLegacy(Request $request){
        if( isset( $request->id ) && $request->id > 0 && ( $record = RecordModel::find($request->id) ) !== null ){
            $people = intval( $request->people_id ) > 0 ? \App\Models\People\People::find( intval( $request->people_id ) ) : $record->people ;
            if( $people == null ){
                return response()->json([
                    'ok' => false ,
                    'message' => 'សូមបញ្ជាក់ម្ចាស់ឯកសារ'
                ],500);
            }
            $weddingCertificateId = $request->has('wedding_certificate_id')
                ? ( intval( $request->wedding_certificate_id ) > 0 ? intval( $request->wedding_certificate_id ) : 0 )
                : $record->wedding_certificate_id ;
            /**
             * Save information of the regulator and its related information
             */
            if( $record->update([
                'birth_number' => $request->has('birth_number') ? preg_replace('/\D+/', '', \App\Utils\Helper::toLnumber( (string) ( $request->birth_number ?? '' ) ) ) : $record->birth_number ,
                'book_number' => $request->has('book_number') ? preg_replace('/\D+/', '', \App\Utils\Helper::toLnumber( (string) ( $request->book_number ?? '' ) ) ) : $record->book_number ,
                'year' => $request->has('year') ? ( ( isset( $request->year ) && strlen( $request->year ) > 0 ) ? $request->year : \Carbon\Carbon::now()->format('Y') ) : $record->year ,
                'province_id' => $request->has('province_id') ? ( $request->province_id ?? 0 ) : $record->province_id ,
                'district_id' => $request->has('district_id') ? ( $request->district_id ?? 0 ) : $record->district_id ,
                'commune_id' => $request->has('commune_id') ? ( $request->commune_id ?? 0 ) : $record->commune_id ,
                'profession' => $request->has('profession') ? ( $request->profession ?? '' ) : $record->profession ,
                'organization' => $request->has('organization') ? ( $request->organization ?? '' ) : $record->organization ,
                'firstname' => $request->has('firstname') ? ( $request->firstname ?? '' ) : $record->firstname ,
                'lastname' => $request->has('lastname') ? ( $request->lastname ?? '' ) : $record->lastname ,
                'enfirstname' => $request->has('enfirstname') ? ( $request->enfirstname ?? '' ) : $record->enfirstname ,
                'enlastname' => $request->has('enlastname') ? ( $request->enlastname ?? '' ) : $record->enlastname ,
                'dob' => $request->has('dob') ? ( ( isset( $request->dob ) && strlen( $request->dob ) ) ? \Carbon\Carbon::parse( $request->dob )->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') ) : $record->dob ,
                'gender' => $request->has('gender') ? ( $request->gender ?? 'male' ) : $record->gender ,
                'nationality' => $request->nationality?? 'ខ្មែរ' ,
                'national' => $request->national?? 'ខ្មែរ' ,
                'pob' => $request->pob?? '' ,
                'issued_date' => strlen( $request->issued_date ) ? \Carbon\Carbon::parse( $request->issued_date )->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') ,
                // 'issued_location' => $request->issued_location?? '' ,
                // 'signed_name' => $request->signed_name?? '' ,

                // 'father_firstname' => $request->father_firstname?? '' ,
                // 'father_lastname' => $request->father_lastname?? '' ,
                // 'father_enfirstname' => $request->father_enfirstname?? '' ,
                // 'father_enlastname' => $request->father_enlastname?? '' ,
                // 'father_dob' => strlen( $request->father_dob ) ? \Carbon\Carbon::parse( $request->father_dob )->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') ,
                // 'father_nationality' => $request->father_nationality?? 'ខ្មែរ' ,
                // 'father_pob' => $request->father_pob?? '' ,

                // 'mother_firstname' => $request->mother_firstname?? '' ,
                // 'mother_lastname' => $request->mother_lastname?? '' ,
                // 'mother_enfirstname' => $request->mother_enfirstname?? '' ,
                // 'mother_enlastname' => $request->mother_enlastname?? '' ,
                // 'mother_dob' => strlen( $request->mother_dob ) ? \Carbon\Carbon::parse( $request->mother_dob )->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') ,
                // 'mother_nationality' => $request->mother_nationality?? 'ខ្មែរ' ,
                // 'mother_pob' => $request->mother_pob?? '' ,
                
                'wedding_certificate_id' => $request->wedding_certificate_id ?? 0 ,
                'updated_by' => \Auth::user()->id ,
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d')
            ]) ){
                $record->with('people');
                $responseData['message'] = __("crud.read.success");
                $responseData['ok'] = true ;
                $responseData['record'] = $record ;
                return response()->json($responseData, 200);
            }else{
                return response()->json([
                    'message' => 'មានបញ្ហាក្នុងការរក្សារព័ត៌មានឯកសារ។'
                ], 403);    
            }
        }else{
            return response()->json([
                'message' => 'សូមបញ្ជាក់លេខសម្គាល់ឯកសារ។'
            ], 403);
        }
    }
    public function read(Request $request){
        if( !isset( $request->id ) || $request->id < 0 ){
            return response()->json([
                'ok' => false ,
                'message' => 'សូមបញ្ជាក់អំពីលេខសម្គាល់ឯកសារ។'
            ],201);
        }
        $certificate = RecordModel::find($request->id);
        if( $certificate == null ){
            return response()->json([
                'ok' => false ,
                'message' => 'ឯកសារដែលអ្នកត្រូវការមិនមានឡើយ។'
            ],201);
        }
        $certificate->with('people');
        return response()->json([
            'record' => $certificate ,
            'ok' => true ,
            'message' => 'រួចរាល់។'
        ],200);
    }

    public function destroy(Request $request){
        if( !isset( $request->id ) || $request->id < 0 ){
            return response()->json([
                'ok' => false ,
                'message' => 'សូមបញ្ជាក់អំពីលេខសម្គាល់ឯកសារ។'
            ],201);
        }
        $certificate = RecordModel::find($request->id);
        if( $certificate == null ){
            return response()->json([
                'ok' => false ,
                'message' => 'ឯកសារស្វែករកបានជោគជ័យ។'
            ],201);
        }
        $certificate->with('people');
        $tempRecord = $certificate;
        if( $certificate->delete() ){
            /**
             * Delete all the related documents own by this regulator
             */
            // if( $tempRecord->pdf !== null && $tempRecord->pdf !=="" && Storage::disk('certificate')->exists( $tempRecord->pdf ) ){
            //     Storage::disk("certificate")->delete( $tempRecord->pdf  );
            // }
            return response()->json([
                'record' => $tempRecord ,
                'ok' => true ,
                'message' => 'លុបទិន្នបានជោគជ័យ។'
            ],200);
        }
        return response()->json([
            'record' => $tempRecord ,
            'ok' => false ,
            'message' => 'មានបញ្ហាក្នុងការលុបទិន្ន័យ។'
        ],201);
    }
}
