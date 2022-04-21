@extends('layouts.dashboard')

@section('dashContent')
    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\AddCard; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Investors Post
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"> Money Sent</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <br>
            <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go
                back</button>
            <br>

            <div class="row">
                <div class="col-xs-12">
                    {!! session('msg') !!}
                    <div class="box">

                        @if (count($data['posts']) > 0)
                            @foreach ($data['posts'] as $value)
                                <div class="box-body">

                                    <table class="table table-bordered table-striped" id="example3">

                                        <tbody>


                                            <tr>
                                                <td>Reference Code:</td>
                                                <td>{{ $value['ref_code'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>Title:</td>
                                                <td>{!! $value['post_title'] !!}</td>
                                            </tr>
                                            <tr>
                                                <td>Description:</td>
                                                <td>{!! $value['description'] !!}</td>
                                            </tr>
                                            <tr>
                                                <td>Minimum Amount</td>
                                                <td>{{ $value['minimum_acount'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>Locked _in_Return</td>
                                                <td>{{ $value['locked_in_return'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>Term</td>
                                                <td>{{ $value['term'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>Liquidation Amount</td>
                                                <td>{{ $value['liquidation_amouunt'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>Offer Open Date:</td>
                                                <td>{{ $value['offer_open_date'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>Offer End Date:</td>
                                                <td>{{ $value['offer_end_date'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>Activate Post:</td>
                                                <td>{{ $value['activate_post'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>Investment Activation Date:</td>
                                                <td>{{ $value['investment_activation_date'] }}</td>
                                            </tr>



                                        </tbody>


                                    </table>
                                    <form action="{{ route('delete investor post', $value['id']) }}" method="post"
                                        id="delete" style="visibility: hidden">
                                        @csrf
                                    </form>
                                    <button href="javascript:void(0)" onclick="deleteInvestorPost()"
                                        class="ms-2 btn btn-danger">Delete</button>
                                    <a href="{{ route('edit investor post', $value->id) }}" alt=""
                                        class="btn btn-primary">Edit</a>
                                    <button class=" btn btn-success ms-4">Activate</button>
                                </div>
                            @endforeach
                        @endif
                    </div>


                    <nav aria-label="...">
                        <ul class="pagination pagination-lg">

                            <li class="page-item">
                                {{ $data['posts']->links() }}
                            </li>
                        </ul>
                    </nav>

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
