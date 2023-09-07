<?php

namespace App\Http\Controllers;

use App\Imports\DynamicDataImport;
use App\Models\DynamicData;
use App\Models\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
//use Maatwebsite\Excel\Facades\Excel;

use PhpOffice\PhpSpreadsheet\IOFactory;


class ExcelImportController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $uploadedFiles = UploadedFile::all();


        return view('home', compact('uploadedFiles'));

    }

    public function viewUploadedFile($id)
    {
        $uploadedFile = UploadedFile::findOrFail($id);
        $fileData = DynamicData::where('uploaded_file_id', $id)->get();

        $pivotData = $this->pivotData($fileData);

        return view('results', compact('uploadedFile', 'pivotData'));
    }


    private function pivotData($data)
    {
        $pivotData = collect();

        foreach ($data as $row) {
            $columnName = $row->column_name??"";
            $cellValue = $row->cell_value??"";
            $dataType = $row->data_type??"";

            // Initialize the collection for the column if not already created
            if (!$pivotData->has($columnName)) {
                $pivotData->put($columnName, collect());
            }

            // Push the value and data type to the respective collections
            $valueWithHtmlEntities = is_string($cellValue) ? htmlspecialchars($cellValue) : $cellValue;

            $pivotData[$columnName]->push(['value' => $valueWithHtmlEntities, 'data_type' => $dataType]);
        }

        return $pivotData;
    }

    public function uploadForm()
    {
        return view('upload');
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $filePath = $file->store('uploads');

        // Store file information in the database
        $uploadedFile = UploadedFile::create([
            'original_name' => $originalName,
            'file_path' => $filePath,
        ]);

        // Save the uploaded file to the storage folder
        $file->storeAs('uploads', $originalName);

        // Process the Excel file and store the data in the database
        $data = $this->readExcelFile(storage_path('app/uploads/' . $originalName));
        $columns = $this->getExcelColumns(storage_path('app/uploads/' . $originalName));

        $this->storeExcelData($data,$columns,$uploadedFile->id);

        return redirect()->route('uploaded-file.view', ['id' => $uploadedFile->id]);
    }

    private function getExcelColumns($filePath)
    {
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $columns = [];
        // Assuming the first row contains column headers
        $firstRow = $worksheet->getRowIterator(1)->current();
        if ($firstRow !== null) {
            foreach ($firstRow->getCellIterator() as $cell) {
                $columns[] = $cell->getValue()??" ";
            }
        }
        return $columns;
    }

    private function readExcelFile($filePath)
    {
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = [];
        foreach ($worksheet->toArray() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    private function storeExcelData($data,$columns,$uploadedFile_id)
    {

        foreach ($data as $row) {
            foreach ($columns as $index => $column) {
                $cellValue = $row[$index];
                $dataType = $this->determineDataType($cellValue);
                DynamicData::create([
                    'uploaded_file_id' => $uploadedFile_id,
                    'column_name' => $column,
                    'data_type' => $dataType,
                    'cell_value' => $cellValue??" ",
                ]);
            }
        }

    }


    private function determineDataType($value)
    {
        if (is_numeric($value)) {
            return is_float($value) ? 'float' : 'integer';
        } elseif (strtotime($value) !== false) {
            return 'date';
        } elseif (filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null) {
            return 'boolean';
        }
        return 'text';
    }


}
