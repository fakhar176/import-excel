@extends('layouts.app')

@section('content')

  <div class="result-container">


    <div class="file-details-section">
        <h1>Uploaded File Details</h1>
        <p>File Name: <span style="color: red;">{{ $uploadedFile->original_name }}</span> </p>
        <p>Uploaded At: {{ $uploadedFile->created_at }}</p>
    </div>

<div>

    <h2>Associated Data with Data Type</h2>

    <table  class="table">
        <thead>
        <tr>
            @foreach ($pivotData->keys() as $column)
                <th>{{ $column }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>

        @php
            $rowCount = $pivotData->values()->first()->count();
        @endphp

        @for ($i = 0; $i < $rowCount; $i++)
            <tr>
                @foreach ($pivotData->keys() as $column)
                    <td>

                        {{ $pivotData[$column][$i]['value'] ?? '' }}

                        @if(isset( $pivotData[$column][$i]['value']) && !empty($pivotData[$column][$i]['value']) && $pivotData[$column][$i]['value']!==" ")
                         <span class="data-cell {{ $pivotData[$column][$i]['data_type']??"" }}">{{ $pivotData[$column][$i]['data_type'] ?? "" }}</span>
                        @endif
                    </td>
                @endforeach
            </tr>
        @endfor
        </tbody>
    </table>
</div>

  </div>

@endsection
