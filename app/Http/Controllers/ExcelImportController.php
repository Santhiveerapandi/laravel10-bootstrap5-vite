<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Jobs\ProcessCsv;
use Illuminate\Support\Facades\Bus;

class ExcelImportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('uploader.upload');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->file('excelfile'));
        //validation data
        /* kilobytes 2048 =2MB*100 */
        $request->validate([
            'excelfile' => 'required|file|mimes:csv,xlsx|max:204800',
        ],[
            'required'=>'Please Select a Csv File.'
        ]);
        
        $message= "CSV Uploaded/ imported added on queue";
        //File chunk data import into db
        // if($request->has('excelfile')){
            $exceldata = file($request->excelfile);
            // dd(count($exceldata)); Actual data validation inside excel/csv
            if(is_array($exceldata) && count($exceldata)>0){
                $chuncklength=count($exceldata);
                $chunks = array_chunk($exceldata, (($chuncklength>500)? 500: $chuncklength) );
                $header = [];
                $batch = Bus::batch([])->dispatch();
                foreach ($chunks as $key => $chunk) {
                    $data = array_map('str_getcsv', $chunk);
                    if($key==0){
                        $header = $data[0];
                        unset($data[0]);
                    }
                    // dump($header);
                    // dd($data);
                    $batch->add(new ProcessCsv($data, $header));
                }
            }
            
            //File Upload
            // $path=$request->file('excelfile')->store('Excel');            
            return redirect()->route('uploader.index')->with('success', $message);
        // }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
