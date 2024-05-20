@extends('layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Student List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('admin/student/add') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New Student</a>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @include('message')
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="student_list_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr. #</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>                                    
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($student_list as $student)    
                                <tr>                   
                                    <td>{{ $loop->index+1 }}</td>              
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>                                    
                                    <td>{{ date('d M Y h:ia', strtotime($student->created_at. '+5 hours')) }}</td>
                                    <td>
                                        <a href="{{ url('admin/student/edit/'.$student->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                        <a href="{{ url('admin/student/delete/'.$student->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                    </td>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <script>
        $(function() {
            $("#student_list_table").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "buttons": ["excel", "pdf"]
            }).buttons().container().appendTo('#student_list_table_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
