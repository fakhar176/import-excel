@extends('layouts.app')

@section('content')


    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="jumbotron text-center">
                    <h1>Welcome to Our Beautiful Home</h1>
                    <p>Discover comfort, style, and elegance in every corner.</p>
                    <a href="{{ route('upload.form') }}" class="btn btn-primary">Upload Excel</a>
                </div>
            </div>
        </div>





        <div class="file-list">
            <h2>List of Uploaded Files</h2>

            @if ($uploadedFiles->isEmpty())
                <p>No files have been uploaded yet.</p>
            @else
                <ul class="uploaded-files-list">
                    @foreach ($uploadedFiles as $file)
                        <li>
                            <a href="{{ route('uploaded-file.view', ['id' => $file->id]) }}">
                                {{ $file->original_name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

    </div>
@endsection

