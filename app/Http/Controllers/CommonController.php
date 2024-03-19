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
                        'NA';
                    $name = isset($chunk[1]) ? $chunk[1] : 'NA';
                    $domain = isset($chunk[2]) ? $chunk[2] : 'NA';
                    $industry = isset($chunk[3]) ? $chunk[3] : 'NA';
                    $size_range = isset($chunk[4]) ? $chunk[4] : 'NA';
                    $locality = isset($chunk[5]) ? $chunk[5] : 'NA';
                    $country = isset($chunk[6]) ? $chunk[6] : 'NA';
                    $linkedin_url = isset($chunk[7]) ? $chunk[7] : 'NA';
                    $curr_emp = isset($chunk[8]) ? $chunk[8] : 'NA';
                    $estim_emp = isset($chunk[9]) ? $chunk[9] : 'NA';



                    DB::table('file_records')->insert([
                        'company_id' => $com_id,
                        'name' => $name,
                        'domain' => $domain,
                        'industry' => $industry,
                        'size_range' => $size_range,
                        'locality' => $locality,
                        'country' => $country,
                        'linkedin_url' => $linkedin_url,
                        'curr_emp' => $curr_emp,
                        'estim_emp' => $estim_emp,
                    ]);
                }
                return response()->json(['success' => true, 'message' => 'CSV chunk processed successfully'], 200);
            } else {
                return response()->json(['success' => false, 'error' => 'CSV data is missing'], 400);
            }
        } catch (\Exception $e) {

            echo $e;
            return response()->json(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }
}