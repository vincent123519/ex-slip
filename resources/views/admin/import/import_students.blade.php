@extends('components.admin')
@section('content')
<div class="import-data-stud">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Import Students') }}</div>

                <div class="card-body">
                    @if (session('success_students'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success_students') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.import.students') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Choose CSV File:</label>
                            <input type="file" class="form-control-file" id="file" name="file" accept=".csv">
                        </div>
                            <button type="submit" class="import-button">Import Students</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


</div>
    <div class="import-data-stud">
    <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Import Teachers') }}</div>

                    <div class="card-body">
                        @if (session('success_teachers'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success_teachers') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.import.teachers') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="file">Choose CSV File:</label>
                                <input type="file" class="form-control-file" id="file" name="file" accept=".csv">
                            </div>
                            <button type="submit" class="import-button">Import Teachers</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   


<div class="import-data-stud">

    <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Import Courses') }}</div>

                    <div class="card-body">
                        @if (session('success_courses'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success_courses') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.import.courses') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="file">Choose CSV File:</label>
                                <input type="file" class="form-control-file" id="file" name="file" accept=".csv">
                            </div>
                            <button type="submit" class="import-button">Import Courses</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>


<div class="import-data-stud">

<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Import Course Offerings') }}</div>

                <div class="card-body">
                    @if (session('success_offercode'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success_offercode') }}
                        </div>
                    @endif

                    <form action="{{ route('import.course.offerings.form') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">Choose CSV File:</label>
                        <input type="file" class="form-control-file" id="file" name="file" accept=".csv">
                    </div>
                    <button type="submit" class="import-button">Import Course Offerings</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="import-data-stud">

    <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Import Studyload') }}</div>

                    <div class="card-body">
                        @if (session('success_studyload'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success_studyload') }}
                            </div>
                        @endif

                        <form action="{{ route('import.studyload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Select CSV file:</label>
                            <input type="file" class="form-control-file" id="file" name="file" accept=".csv">
                        </div>
                        <button type="submit" class="import-button">Upload</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
</div>


<!-- <div class="import-data-stud">

    <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Import Profile images') }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('upload.user.images') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <label for="csv_file">CSV File:</label>
                        <input type="file" name="csv_file" id="csv_file">
                        <br>
                        <button type="submit" class="import-button">Upload</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
</div>   -->

<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="errorModalBody">
                <!-- Error message will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>


    <div id="errorModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h5>Error Importing</h5>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body" id="errorModalBody">
            <!-- Error message will be inserted here -->
        </div>
        <div class="modal-footer">
            <button id="closeModal" class="btn">Close</button>
        </div>
    </div>
</div>

@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        var errorMessage = @json(session('error'));
        if (errorMessage) {
            $('#errorModalBody').text(errorMessage);
            $('#errorModal').modal('show');
        }
    });
</script>


<style>
.import-button{
    display: inline-block;
  
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  color: #fff;
  background-color: #04AA6D;
  border: none;
  border-radius: 15px;
  box-shadow: 0 9px #999;

}

.import-data-stud
{
    padding: 20px;
    position: relative;
    width: 80%;
    margin: 20px auto;
    margin-right: auto;
    margin-right: 300px;
    font-family: 'Montserrat', sans-serif;
    font-weight: bold;
    line-height: 1.5;



}

body {
    font-family: Arial, sans-serif;
}

.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1000; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.7); /* Black w/ opacity */
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h5 {
    margin: 0;
}

.close {
    color: #aaa;
    cursor: pointer;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
}

.btn {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

.btn:hover {
    background-color: #0056b3;
}
</style>

