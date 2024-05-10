<div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h4>School Years</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>School Year ID</th>
                                    <th>School Year Name</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schoolYears as $schoolYear)
                                    <tr>
                                        <td>{{ $schoolYear->sy_id }}</td>
                                        <td>{{ $schoolYear->sy_name }}</td>
                                        <td>{{ $schoolYear->is_active ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                            @if (!$schoolYear->is_active)
                                                <form action="{{ route('school-year.activate', $schoolYear->sy_id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary">Activate</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>