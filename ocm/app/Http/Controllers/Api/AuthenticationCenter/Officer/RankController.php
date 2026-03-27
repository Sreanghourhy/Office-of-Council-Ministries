<?php

namespace App\Http\Controllers\Api\AuthenticationCenter\Officer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Officer\Rank as RecordModel;
use App\Models\Officer\Officer;
use App\Models\Officer\OfficerRankByWorking;
use App\Http\Controllers\CrudController;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use FilippoToso\PdfWatermarker\Facades\ImageWatermarker;
use FilippoToso\PdfWatermarker\Support\Pdf;
use FilippoToso\PdfWatermarker\Watermarks\ImageWatermark;
use FilippoToso\PdfWatermarker\PdfWatermarker;
use FilippoToso\PdfWatermarker\Support\Position;

class RankController extends Controller
{
    private $selectFields = [
        'id' ,
        'ank' , 
        'krobkhan' , 
        'krobkhan_name' , 
        'rank' , 
        'thnak' , 
        'name' , 
        'desp' , 
        'tpid' , 
        'pid' , 
        'cids' , 
        'image' , 
        'record_index' , 
        'active' , 
        'prefix' , 
        'created_at' , 
        'updated_at' ,
        'created_by' , 
        'updated_by'
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

        $queryString = [
            "where" => [
                // 'default' => [
                //     $officer == null ? [] 
                //     : [
                //         'field' => 'officer_id' ,
                //         'value' => $officer->id
                //     ]
                // ],
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
                // 'not' => [
                //     count( $weddingCertificateIds )
                //         ?[ 
                //             'field' => 'wedding_certificate_id' ,
                //             'value' => $weddingCertificateIds
                //         ]
                //         : []
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
                    'ank' , 
                    'krobkhan' , 
                    'rank' , 
                    'name' , 
                    'desp' , 
                ]
            ],
            "order" => [
                'field' => 'id' ,
                'by' => 'asc'
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

        // return response()->json([ 
        //     'time' => microtime()
        // ]);

        // $crud->setRelationshipFunctions([
        //     /** relationship name => [ array of fields name to be selected ] */
        //     'officers' => [
        //         'code',
        //         'official_date' ,
        //         'unofficial_date',
        //         'public_key',
        //         'user_id' ,
        //         'people_id' ,
        //         'email',
        //         'phone',
        //         'countesy_id' ,
        //         // Optional
        //         'organization_id' ,
        //         'position_id' ,
        //         'rank_id' ,
        //         'leader' ,
        //         'image' ,
        //         'pdf',
        //         'passport' ,
        //         'people' => [ 'id' , 'firstname' ,'lastname' , 'enfirstname' , 'enlastname' ]
        //     ]
        // ]);

        $builder = $crud->getListBuilder();

        $responseData = $crud->pagination(true, $builder);
        $responseData['message'] = __("crud.read.success");
        $responseData['ok'] = true ;
        // $responseData['server'] = $_SERVER ;
        return response()->json($responseData, 200);
    }

    public function create(Request $request)
    {
        return $this->saveOfficerRank($request, true);
    }

    public function update(Request $request)
    {
        return $this->saveOfficerRank($request, false);
    }

    private function saveOfficerRank(Request $request, bool $isCreate)
    {
        $validated = $request->validate([
            'officer_id' => ['required', 'integer', 'exists:officers,id'],
            'rank_id' => ['nullable', 'integer', 'exists:ranks,id'],
            'ank' => ['nullable', 'string'],
            'krobkhan' => ['nullable', 'string'],
            'rank' => ['nullable', 'string'],
            'thnak' => ['nullable', 'string'],
            'salary_rank' => ['nullable', 'string'],
            'officer_type' => ['nullable', 'string'],
            'official_date' => ['nullable', 'date'],
            'unofficial_date' => ['nullable', 'date'],
        ]);

        $rankRecord = $this->resolveRankRecord($request);
        if ($rankRecord == null) {
            return response()->json([
                'ok' => false,
                'message' => 'Rank record not found.'
            ], 422);
        }

        $officer = Officer::find($validated['officer_id']);
        if ($officer == null) {
            return response()->json([
                'ok' => false,
                'message' => 'Officer not found.'
            ], 404);
        }

        $workingHistories = $this->extractWorkingHistories($request);
        $userId = optional(\Auth::user())->id ?? 0;

        DB::transaction(function () use ($request, $officer, $rankRecord, $workingHistories, $userId) {
            $officer->rank_id = $rankRecord->id;
            $officer->officer_type = $request->officer_type ?? $request->krobkhan ?? $rankRecord->krobkhan;
            $officer->salary_rank = $request->salary_rank ?? ($rankRecord->krobkhan . '.' . $rankRecord->rank . '.' . $rankRecord->thnak);
            $officer->official_date = $this->normalizeDate($request->official_date);
            $officer->unofficial_date = $this->normalizeDate($request->unofficial_date);
            $officer->updated_by = $userId;
            $officer->updated_at = Carbon::now()->format('Y-m-d H:i:s');
            $officer->save();

            if ($workingHistories !== null) {
                $this->upsertWorkingHistories($officer, $workingHistories, $userId, $rankRecord->id);
            }
        });

        $officer->refresh();
        $officer->rank;
        $officer->ranking_by_workings = $officer->rankingByWorkings()->orderBy('date', 'desc')->get()->map(function ($rank) {
            $rank->rank;
            $rank->previousRank;
            return $rank;
        });

        return response()->json([
            'ok' => true,
            'message' => $isCreate ? 'Officer rank saved successfully.' : 'Officer rank updated successfully.',
            'record' => [
                'officer_id' => $officer->id,
                'rank_id' => $officer->rank_id,
                'ank' => optional($officer->rank)->ank,
                'krobkhan' => optional($officer->rank)->krobkhan,
                'rank' => optional($officer->rank)->rank,
                'thnak' => optional($officer->rank)->thnak,
                'prefix' => optional($officer->rank)->prefix,
                'current_rank_ank' => optional($officer->rank)->ank,
                'current_salary_rank' => optional($officer->rank)->prefix,
                'officer_type' => $officer->officer_type,
                'salary_rank' => $officer->salary_rank,
                'unofficial_date' => $officer->unofficial_date,
                'official_date' => $officer->official_date,
                'ranking_by_workings' => $officer->ranking_by_workings,
            ]
        ], 200);
    }

    private function resolveRankRecord(Request $request): ?RecordModel
    {
        $rankId = intval($request->rank_id ?? 0);
        if ($rankId > 0) {
            return RecordModel::find($rankId);
        }

        $ank = trim((string) ($request->ank ?? ''));
        $krobkhan = trim((string) ($request->krobkhan ?? ''));
        $rank = trim((string) ($request->rank ?? ''));
        $thnak = trim((string) ($request->thnak ?? ''));

        if ($ank === '' || $krobkhan === '' || $rank === '' || $thnak === '') {
            return null;
        }

        return RecordModel::where('ank', $ank)
            ->where('krobkhan', $krobkhan)
            ->where('rank', $rank)
            ->where('thnak', $thnak)
            ->first();
    }

    private function extractWorkingHistories(Request $request): ?array
    {
        $workingHistories = $request->input('ranking_by_workings', $request->input('rankingByWorkings'));

        if ($workingHistories === null) {
            return null;
        }

        if (is_string($workingHistories)) {
            $decoded = json_decode($workingHistories, true);
            return is_array($decoded) ? $decoded : null;
        }

        return is_array($workingHistories) ? $workingHistories : null;
    }

    private function upsertWorkingHistories(Officer $officer, array $workingHistories, int $userId, int $fallbackRankId): void
    {
        foreach ($workingHistories as $history) {
            if (!is_array($history)) {
                continue;
            }

            $recordId = intval($history['id'] ?? 0);
            $shouldDelete = filter_var($history['_delete'] ?? $history['deleted'] ?? false, FILTER_VALIDATE_BOOLEAN);

            if ($shouldDelete) {
                if ($recordId > 0) {
                    $record = OfficerRankByWorking::where('officer_id', $officer->id)->find($recordId);
                    if ($record != null) {
                        $record->deleted_by = $userId;
                        $record->save();
                        $record->delete();
                    }
                }
                continue;
            }

            $rankId = $this->resolveNestedRankId($history, ['rank_id'], ['rank']) ?: $fallbackRankId;
            $previousRankId = $this->resolveNestedRankId($history, ['previous_rank_id'], ['previous_rank', 'previousRank']) ?: 0;

            $payload = [
                'officer_id' => $officer->id,
                'organization' => $history['organization'] ?? '',
                'sub_organization' => $history['sub_organization'] ?? '',
                'sub_sub_organization' => $history['sub_sub_organization'] ?? '',
                'date' => $this->normalizeRequiredDate($history['date'] ?? null),
                'rank_id' => $rankId,
                'previous_rank_id' => $previousRankId,
                'changing_type' => isset($history['changing_type']) ? (string) $history['changing_type'] : null,
                'desp' => $history['desp'] ?? null,
                'updated_by' => $userId,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ];

            if ($recordId > 0) {
                $record = OfficerRankByWorking::where('officer_id', $officer->id)->find($recordId);
                if ($record != null) {
                    $record->update($payload);
                    continue;
                }
            }

            $payload['created_by'] = $userId;
            $payload['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $payload['pdf'] = $history['pdf'] ?? '';
            OfficerRankByWorking::create($payload);
        }
    }

    private function resolveNestedRankId(array $history, array $idKeys, array $objectKeys): ?int
    {
        foreach ($idKeys as $idKey) {
            $rankId = intval($history[$idKey] ?? 0);
            if ($rankId > 0) {
                return RecordModel::where('id', $rankId)->exists() ? $rankId : null;
            }
        }

        $rankObject = null;
        foreach ($objectKeys as $objectKey) {
            if (isset($history[$objectKey]) && is_array($history[$objectKey])) {
                $rankObject = $history[$objectKey];
                break;
            }
        }
        if (!is_array($rankObject)) {
            return null;
        }

        $ank = trim((string) ($rankObject['ank'] ?? ''));
        $krobkhan = trim((string) ($rankObject['krobkhan'] ?? ''));
        $rank = trim((string) ($rankObject['rank'] ?? ''));
        $thnak = trim((string) ($rankObject['thnak'] ?? ''));

        if ($ank === '' || $krobkhan === '' || $rank === '' || $thnak === '') {
            return null;
        }

        return optional(
            RecordModel::where('ank', $ank)
                ->where('krobkhan', $krobkhan)
                ->where('rank', $rank)
                ->where('thnak', $thnak)
                ->first()
        )->id;
    }

    private function normalizeDate($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $date = trim((string) $value);
        if ($date === '') {
            return null;
        }

        return Carbon::parse($date)->format('Y-m-d');
    }

    private function normalizeRequiredDate($value): string
    {
        return $this->normalizeDate($value) ?? '';
    }

    public function structure(Request $request){
        return response()->json([
            'ok' => true ,
            'message' => 'រួចរាល់' ,
            'records' => \App\Models\Officer\Rank::select('ank')->groupby(['ank'])->orderby('ank')->get()->map(function($record) {
                return [
                    'ank' => $record->ank ,
                    'krobkhans' => \App\Models\Officer\Rank::select('ank','krobkhan','krobkhan_name')->where('ank',$record->ank)->groupby(['ank','krobkhan','krobkhan_name'])->orderby('krobkhan')->get()->map(function($record) {
                        return [
                            'krobkhan' => $record->krobkhan ,
                            'krobkhan_name' => $record->krobkhan_name ,
                            'ranks' => \App\Models\Officer\Rank::select('rank','krobkhan','ank','krobkhan_name','name')
                                ->where([
                                    'ank' => $record->ank ,
                                    'krobkhan' => $record->krobkhan ,
                                    'krobkhan_name' => $record->krobkhan_name ,
                                ])
                                ->groupby(['ank','krobkhan','krobkhan_name','rank','name'])
                                ->orderby('rank')->get()->map(function($record){
                                    return [
                                        'rank' => $record->rank ,
                                        'krobkhan' => $record->krobkhan ,
                                        'krobkhan_name' => $record->krobkhan_name ,
                                        'name' => $record->name ,
                                        'thnaks' => \App\Models\Officer\Rank::select('thnak')
                                            ->where([
                                                'ank' => $record->ank ,
                                                'krobkhan' => $record->krobkhan ,
                                                'krobkhan_name' => $record->krobkhan_name ,
                                                'rank' => $record->rank
                                            ])->orderby('thnak')->get()
                                    ];
                                })
                            // , 'rank' => $record->rank ,
                            // 'thnaks' => \App\Models\Officer\Rank::select('thnak')->where('krobkhan',$record->krobkhan)->where('rank',$record->rank)->orderby('thnak')->get()
                        ];
                    }) ,
                ];
            })
        ], 200);
    }

    /**
     * View the pdf file
     */
    public function pdf(Request $request)
    {
        $certificate = RecordModel::findOrFail($request->id);
        if($certificate) {
            $pathPdf = storage_path('data') . '/certificates/' . $certificate->pdf ;
            $ext = pathinfo($pathPdf);
            $filename = $certificate->id . '-' .$certificate->field_name . "." . $ext['extension'];
        
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

    public function uploadpdfsalary(Request $request)
    {
        // Validate the request
        $request->validate([
            'id' => 'required|integer|exists:officer_ranks,id',
            'pdf' => 'required|file|mimes:pdf|max:10240', // max 10MB
        ]);

        try {
            // Find the officer_ranks record by id
            $officerRank = RecordModel::findOrFail($request->id);
            
            if ($request->hasFile('pdf')) {
                $file = $request->file('pdf');
                
                // Generate unique filename
                $filename = 'salary_' . $officerRank->id . '_' . time() . '.pdf';
                
                // Store the file in 'ranks' folder
                $path = $file->storeAs('ranks', $filename, 'certificate');
                
                // Optional: Delete old PDF if exists
                if (!empty($officerRank->pdf) && \Storage::disk('certificate')->exists($officerRank->pdf)) {
                    \Storage::disk('certificate')->delete($officerRank->pdf);
                }
                
                // Update the pdf column
                $officerRank->pdf = $path;
                
                // Set updated_by if authenticated
                if (auth()->check()) {
                    $officerRank->updated_by = auth()->id();
                }
                
                $officerRank->save();
                
                return response()->json([
                    'ok' => true,
                    'message' => 'PDF uploaded successfully',
                    'data' => [
                        'id' => $officerRank->id,
                        'pdf' => $path,
                        'filename' => $filename
                    ]
                ], 200);
            }
            
            return response()->json([
                'ok' => false,
                'message' => 'No PDF file provided'
            ], 400);
            
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
