@extends('layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Subject</h1>
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
                            <form action="{{ url('admin/subject/edit/'.$subject->id) }}" method="post">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ $subject->name }}" placeholder="Enter name">
                                    </div>
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select name="type" class="form-control">
                                            <option value="">---Select One---</option>
                                            <option value="0" {{ ($subject->type == 'THEORY') ? 'selected' : '' }}>Theory</option>
                                            <option value="1" {{ ($subject->type == 'PRACTICAL') ? 'selected' : '' }}>Practical</option>
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
