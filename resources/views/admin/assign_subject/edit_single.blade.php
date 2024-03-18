@extends('layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Assigned Subject</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6" style="margin: 5% auto;">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            @include('message')
                            <!-- form start -->
                            <form action="{{ url('admin/assign-subject/edit-single/'.$subject->id) }}" method="post">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Class</label>
                                        <select name="class_id" class="form-control">
                                            <option value="">---Select One---</option>
                                            @foreach ($class_data as $class)
                                                <option value="{{ $class->id }}" {{ ($class->id == $subject->class_id) ? 'selected' : '' }}>{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Subject Name</label><br>
                                        <select name="subject_id" class="form-control">
                                            @foreach ($subject_data as $subjectData)
                                                <option value="{{ $subjectData->id }}" {{ ($subjectData->id == $subject->subject_id) ? 'selected' : '' }}> {{ $subjectData->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="">---Select One---</option>
                                            <option value="0" {{ ($subject->is_active == 0) ? 'selected' : '' }}>In-active</option>
                                            <option value="1" {{ ($subject->is_active == 1) ? 'selected' : '' }}>Active</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div><!-- /.container-fluid -->
                </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
