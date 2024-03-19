<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CommonController extends Controller
{
    function getUserData()
    {
        $userData = User::all();
        return  view('dashboard', compact('userData'));
    }
    function fileUpload(Request $request)
    {
        set_time_limit(1800);
        ini_set('memory_limit', '1200M');
        try {
            if ($csvData = $request->input('csvData')) {
                $chunkIndex = $request->input('chunkIndex');
                $totalChunks = $request->input('totalChunks');
                $lines = explode(PHP_EOL, $csvData);

                foreach ($lines as $line) {
                    $chunk = str_getcsv($line);

                    $com_id = isset($chunk[0]) ? $chunk[0] :
                        0;
                    $name = isset($chunk[1]) ? $chunk[1] : NULL;
                    $domain = isset($chunk[2]) ? $chunk[2] : NULL;
                    $year_of_foudation = isset($chunk[3]) ? $chunk[3] : NULL;
                    $industry = isset($chunk[4]) ? $chunk[4] : NULL;
                    $size_range = isset($chunk[5]) ? $chunk[5] : NULL;
                    $locality = isset($chunk[6]) ? $chunk[6] : NULL;
                    $country = isset($chunk[7]) ? $chunk[7] : NULL;
                    $linkedin_url = isset($chunk[8]) ? $chunk[8] : NULL;
                    $curr_emp = isset($chunk[9]) ? $chunk[9] : NULL;
                    $estim_emp = isset($chunk[10]) ? $chunk[10] : NULL;



                    DB::table('file_records')->insert([
                        'company_id' => $com_id,
                        'name' => $name,
                        'domain' => $domain,
                        'year_of_foudation' => $year_of_foudation,
                        'industry' => $industry,
                        'size_range' => $size_range,
                        'locality' => $locality,
                        'country' => $country,
                        'linkedin_url' => $linkedin_url,
                        'curr_emp' => $curr_emp,
                        'estim_emp' => $estim_emp,
                    ]);
                }
            }
            return response()->json(['success' => true, 'message' => 'CSV chunk processed successfully'], 200);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }
    function fileRecords()
    {
        $fileRecords = DB::table('file_records')->paginate(10);
        return  view('file-records', compact('fileRecords'));
    }
}