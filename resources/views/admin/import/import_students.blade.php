@extends('components.admin')
@section('content')
    <div class="import-data-stud">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Import Students') }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.import.students') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="file">Choose CSV File:</label>
                                <input type="file" class="form-control-file" id="file" name="file" accept=".csv">
                            </div>
                            <button type="submit" class="btn btn-primary">Import Students</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="import-data-stud">

@endsection


<style>.import-data-stud
{
  padding: 20px;
  position: relative;
  border: 1px solid #ccc;
  border-radius: 10px;
  width: 80%;
  margin: 20px auto;
    margin-right: auto;
  margin-right: 30px;
  font-family: 'Montserrat', sans-serif;
}</style>