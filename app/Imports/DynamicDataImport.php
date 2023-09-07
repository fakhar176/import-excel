<?php

namespace App\Imports;
use Illuminate\Support\Collection;
//use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\DynamicData;
use Maatwebsite\Excel\Facades\Excel;

class DynamicDataImport
{
    private $uploadedFileId;

    public function __construct($uploadedFileId)
    {
        $this->uploadedFileId = $uploadedFileId;
    }
    public function collection(Collection $rows)
    {
        // Dynamically determine the structure of the Excel file
//        $columns = $rows->shift()->toArray();
        $data = Excel::toArray([], $rows)[0];
        $columns = array_shift($data);


        // Save each row to the dynamic_data table
        foreach ($rows as $row) {
            foreach ($columns as $index => $column) {
                $cellValue = $row[$index];
                $dataType = $this->determineDataType($cellValue);
                DynamicData::create([
                    'uploaded_file_id' => $this->uploadedFileId,
                    'column_name' => $column,
                    'data_type' => $dataType,
                    'cell_value' => $cellValue,
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
