@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="upload-container">
            <h2 class="upload-heading">Upload Your File</h2>

            <!-- Display validation errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="upload-form" action="{{route('import.excel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="file-input-container">
                    <div class="file_name" id="file_name"></div>
                    <input type="file" name="file" class="file-input" id="file" accept=".xlsx, .xls" onchange="document.getElementById('file_name').innerHTML=this.files[0].name;">
{{--                    <input type="file" id="file" name="file" class="file-input" accept=".xlsx, .xls, .csv" required>--}}
                    <label for="file" class="file-label">Choose a file</label>
                </div>
                <button type="submit" class="upload-button">Upload</button>
            </form>
        </div>
    </div>





@endsection



