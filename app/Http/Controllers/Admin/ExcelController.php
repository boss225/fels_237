<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\Word;
use App\Models\Option;
use Excel;

class ExcelController extends Controller
{
    public function getImport()
    {
        return view('admin.excel.import');
    }

    public function postImport()
    {
       if(Input::hasFile('file')){
			$path = Input::file('file')->getRealPath();
			$data = Excel::load($path, function($reader) {
			})->get();
			if(!empty($data) && $data->count()){
				foreach ($data as $value) {
					$insert[] = [
                        // 'category_id' => $value->category_id, 
                        // 'word' => $value->word,
                        // 'answer' => $value->answer,
                        // 'description' => $value->description,
                        'word_id' => $value->word_id,
                        'option' => $value->option,
                        'created_at' => $value->created_at,
                        'updated_at' => $value->updated_at,
                    ];
				}
				if(!empty($insert)){
					// Word::insert($insert);
					Option::insert($insert);
					return redirect()->action('Admin\ExcelController@getImport')
                        ->with('status', 'success')
                        ->with('message', trans('settings.success_message'));
				}
			}
		}
		return back();
    }

    public function export()
    {
        $export = Word::all();
        Excel::create('fels_237', function($excel) use($export){
            $excel->sheet('Sheet 1', function($sheet) use($export){
                $sheet->fromArray($export);
            });
        })->export('xlsx');
    }
}
