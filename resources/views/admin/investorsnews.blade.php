@extends('layouts.dashboard')

@section('dashContent')

    <?php use \Illuminate\Support\Str; ?>
    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\AddCard; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Investor News Posts
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Investor News Posts</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <br>
            <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go
                back</button>
            <br>
                {!! session('msg') !!}
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">

                        <div class="box-body">


                            <table class="table table-bordered table-striped" id="example3">
                                <thead>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3 id="period_start"></h3>
                                        </div>
                                        <div class="col-md-6">
                                            <h3 id="period_stop"></h3>
                                        </div>
                                    </div>

                                    <tr>

                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>File</th>
                                        <th>Date created</th>
                                        <th>Action</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data['posts']) > 0)
                                        @php
                                            $i = 1;
                                        @endphp

                                        @foreach ($data['posts'] as $theposts)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $theposts->title }}</td>
                                                <td>{!! str::limit($theposts->description, 400) !!}</td>
                                                <td>
                                                    <a
                                                        href="{{ $theposts->file != null ? $theposts->file : 'javascript:void()' }}">{{ $theposts->file != null ? 'Open file' : 'NILL' }}</a>
                                                </td>
                                                <td>{{ date('d/m/Y', strtotime($theposts->created_at)) }}</td>
                                                <td>
                                                    <a href="{{ route('edit investor news',$theposts->id)}}" class="btn btn-primary">Edit</a>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger" id="btns"
                                                    onclick="deleteInvestorNews('{{ $theposts->id }}');">Delete</button>
                                                <form action="{{ route('delete investor news', $theposts->id) }}"
                                                    method="post" style="visibility: hidden"
                                                    id="deletenews{{ $theposts->id }}">
                                                    @csrf
                                                    <input type="hidden" name="postid"
                                                        value="{{ $theposts->id }}">
                                                </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" align="center">No record found</td>
                                        </tr>
                                    @endif




                            </table>

                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
    </div>
    <!-- /.row -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
