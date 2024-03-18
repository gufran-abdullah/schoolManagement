@extends('layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Assigned Subjects List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('admin/assign-subject/add') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Assign Subjects</a>
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
                        <table id="admin_list_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr. #</th>
                                    <th>ID</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Subject Type</th>
                                    <th>Status</th>                                     
                                    <th>Created By</th>                                   
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assign_subject_list as $subject)    
                                <tr>                   
                                    <td>{{ $loop->index+1 }}</td>              
                                    <td>{{ $subject->id }}</td>
                                    <td>{{ $subject->class_name }}</td>
                                    <td>{{ $subject->subject_name }}</td>
                                    <td>{{ $subject->subject_type }}</td>
                                    <td>{{ ($subject->is_active == 1) ? 'Active' : 'In-active' }}</td>                                    
                                    <td>{{ $subject->user_name }}</td>
                                    <td>{{ date('d M Y h:ia', strtotime($subject->created_at. '+5 hours')) }}</td>
                                    <td>
                                        <a href="{{ url('admin/assign-subject/edit/'.$subject->id) }}" class="btn btn-primary btn-sm" title="Bulk subjects assign"><i class="fas fa-edit"></i></a>
                                        <a href="{{ url('admin/assign-subject/edit-single/'.$subject->id) }}" class="btn btn-info btn-sm" title="Single subject update"><i class="fas fa-edit"></i></a>
                                        <a href="{{ url('admin/assign-subject/delete/'.$subject->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
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
            $("#admin_list_table").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "buttons": ["excel", "pdf"]
            }).buttons().container().appendTo('#admin_list_table_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
