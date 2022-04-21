@extends('layouts.app')

@section('text/css')
<style>
    .headings{
        margin-bottom: 10px;
        padding: 15px 25px;
        text-align: center;
    }
    .ticketsBox{
        height: 140vh; overflow-y: auto;
    }
    .ticketsBox::-webkit-scrollbar {
  width: 6px;
}

/* Track */
.ticketsBox::-webkit-scrollbar-track {
  background: #f1f1f1; 
}

/* Handle */
.ticketsBox::-webkit-scrollbar-thumb {
  background: #f6b60b; 
}

/* Handle on hover */
.ticketsBox::-webkit-scrollbar-thumb:hover {
  background: #f6b60b; 
}
</style>
@show
@section('content')

    <!-- Banner area -->
    <section class="banner_area" data-stellar-background-ratio="0.5">
        <h2>{{ $pages }}</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('ticket') }}" class="active">Create a Ticket</a></li>
        </ol>
    </section>
    <!-- End Banner area -->

    <!-- blog area -->
    <section class="blog_all">
        <div class="container">
            <div class="row m0 blog_row">
{{--                 <div class="row headings">
                    <div class="col-md-6">
                        <h2  align="left">&nbsp;</h2>
                    </div>
                    <div class="col-md-6" align="center">
                        <button class="btn">Cancel</button>
                        <button class="btn" onclick="creatEvent('{{ uniqid().'_'.time() }}', 'ticket')">Save</button>
                        <img src="https://cdn.dribbble.com/users/608059/screenshots/2032455/spinner.gif" class="spinner disp-0" style="width: auto; height: 50px;">
                    </div>
                </div> --}}
                <div class="col-sm-8 main_blog">
                    <div class="post_comment">
                        <h1>1. Event Detail</h1> <hr>
                        <!-- Button trigger modal -->

                        <form class="comment_box">
                            <div class="col-md-12">
                                <h4>Event title <span style="color: tomato;">*</span></h4>
                                <input type="hidden" name="user_id" id="user_id" value="{{ $email }}">
                                <input type="text" name="ticket_title" id="ticket_title" class="form-control input_box" placeholder="Give it a short distinct name">
                            </div>

                            <div class="col-md-12">
                                <h4>Location <span style="color: tomato;">*</span></h4>
                                <input type="text" name="ticket_location" id="ticket_location" class="form-control input_box" placeholder="Search for a location">
                            </div>

                           <div class="col-md-3">
                               <h4>Starts <span style="color: tomato;">*</span></h4>
                               <input type="date" class="form-control input_box" name="ticket_dateStarts" id="ticket_dateStarts" placeholder="">
                           </div>
                           <div class="col-md-3">
                               <h4>&nbsp;</h4>
                               <input type="time" class="form-control input_box" name="ticket_timeStarts" id="ticket_timeStarts" placeholder="">
                           </div>
                           <div class="col-md-3">
                               <h4>Ends <span style="color: tomato;">*</span></h4>
                               <input type="date" class="form-control input_box" name="ticket_dateEnds" id="ticket_dateEnds" placeholder="">
                           </div>
                           <div class="col-md-3">
                               <h4>&nbsp;</h4>
                               <input type="time" class="form-control input_box" name="ticket_timeEnds" id="ticket_timeEnds" placeholder="">
                           </div>
                           <div class="col-md-12">
                               <h4>Upload image</h4>
                               <input type="file" name="ticket_image" class="form-control input_box" id="ticket_image">
                               <caption><small style="color: darkblue;">We recommend uploading image that's no larger than 10MB.</small></caption>
                               {{-- <button type="button">Post Comment</button> --}}
                           </div>

                           <div class="col-md-12">
                               <h4>Event description</h4>
                               <textarea type="text" name="ticket_description" id="ticket_description" class="form-control input_box" placeholder=""></textarea>
                               <hr>
                           </div>
                           
                           <h1>2. Create Tickets</h1> <hr>

                           <div class="col-md-12">

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Ticket name <span style="color: tomato;">*</span></th>
                                            <th>Quantity available <span style="color: tomato;">*</span></th>
                                            <th>Price</th>
                                            <th align="center">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr class="freeTicket disp-0">
                                            <td>
                                                <input type="text" name="ticket_free_name" id="ticket_free_name" class="form-control input_box" placeholder="RSVP">
                                            </td>
                                            <td>
                                                <input title="Enter the total number of tickets available for this ticket type" type="text" name="ticket_free_qty" id="ticket_free_qty" class="form-control input_box" placeholder="100">
                                            </td>
                                            <td>
                                                <input type="hidden" name="ticket_free_price" id="ticket_free_price" value="Free">
                                                FREE
                                            </td>
                                            <td align="center">
                                                <hr style="margin-top: -10px;">
                                                <a type="button" id="savefreeTicket" style="cursor: pointer;"><i class="fa fa-save" style="font-size: 20px; color: #7181bf;"></i></a>
                                                <a type="button" style="cursor: pointer;" onclick="$('.launchModal').click()"><i title="cancel" class="fa fa-trash" style="font-size: 20px; color: #d8533b;"></i></a>
                                            </td>
                                        </tr>

                                        <tr class="paidTicket disp-0">
                                            <td>
                                                <input type="text" name="ticket_paid_name" id="ticket_paid_name" class="form-control input_box" placeholder="RSVP">
                                            </td>
                                            <td>
                                                <input title="Enter the total number of tickets available for this ticket type" type="text" name="ticket_paid_qty" id="ticket_paid_qty" class="form-control input_box" placeholder="100">
                                            </td>
                                            <td>
                                                <input title="Set your ticket price" class="form-control input_box" placeholder="15.00" name="ticket_paid_price" id="ticket_paid_price">
                                            </td>
                                            <td align="center">
                                                <hr style="margin-top: -10px;">
                                                <a type="button" id="savepaidTicket" style="cursor: pointer;"><i class="fa fa-save" style="font-size: 20px; color: #7181bf;"></i></a>
                                                <a type="button" style="cursor: pointer;" onclick="$('.launchModal').click()"><i title="cancel" class="fa fa-trash" style="font-size: 20px; color: #d8533b;"></i></a>
                                            </td>
                                        </tr>

                                        <tr class="donateTicket disp-0">
                                            <td>
                                                <input type="text" name="ticket_donate_name" id="ticket_donate_name" class="form-control input_box" placeholder="RSVP">
                                            </td>
                                            <td>
                                                <input title="Enter the total number of tickets available for this ticket type" type="text" name="ticket_donate_qty" id="ticket_donate_qty" class="form-control input_box" placeholder="100">
                                            </td>
                                            <td>
                                                <input title="Set your ticket price" class="form-control input_box" placeholder="15.00" name="ticket_donate_price" id="ticket_donate_price">
                                            </td>
                                            <td align="center">
                                                <hr style="margin-top: -10px;">
                                                <a type="button" id="savedonateTicket" style="cursor: pointer;"><i class="fa fa-save" style="font-size: 20px; color: #7181bf;"></i></a>
                                                <a type="button" style="cursor: pointer;" onclick="$('.launchModal').click()"><i title="cancel" class="fa fa-trash" style="font-size: 20px; color: #d8533b;"></i></a>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                              <center> 
                                <h4>What type of ticket would you like to start with?</h4>
                               <p>
                                   <button type="button" onclick="opennewTicket('free')"><i class="fa fa-plus-circle"></i> Free Ticket</button>
                                   <button type="button" onclick="opennewTicket('paid')"><i class="fa fa-plus-circle"></i> Paid Ticket</button>
                                   <button type="button" onclick="opennewTicket('donate')"><i class="fa fa-plus-circle"></i> Donation</button>
                               </p>
                           </center>
                           </div>

                        </form>
                    </div>

                    <div class="row headings">
                    <div class="col-md-6">
                        <h2  align="left">&nbsp;</h2>
                    </div>
                    <div class="col-md-6" align="right">
                        <button class="btn">Cancel</button>
                        <button class="btn" onclick="creatEvent('{{ uniqid().'_'.time() }}', 'ticket')">Save</button>
                        <img src="https://cdn.dribbble.com/users/608059/screenshots/2032455/spinner.gif" class="spinner disp-0" style="width: auto; height: 50px;">
                    </div>
                </div>
                </div>

                <div class="col-sm-4 widget_area">

                    

                    <div class="resent">
                        <h2 style="text-align: center;">RECENT EVENT</h2>
                        <div class="ticketsBox">
                        @if(count($getTickets) > 0)

                    @foreach($getTickets as $getTicket)

                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="http://screenvariety.info/wp-content/uploads/revslider/fightings1/Golden-Ticket.png" alt="" style="width: 50px; height: 50px;">
                            </a>
                        </div>
                        <div class="media-body table-responsive">
                            <table class="table table striped">
                                <tbody style="font-size: 12px;">
                                    <tr>
                                        <td>Title:</td>
                                        <td colspan="5" align="center"><b>{{ $getTicket->event_title }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Location:</td>
                                        <td colspan="5" align="center">{{ $getTicket->event_location }}</td>
                                    </tr>

                                    <tr>
                                        <td>Start:</td>
                                        <td>{{ date('d/M/Y', strtotime($getTicket->event_start_date)) }}</td>
                                        <td>End:</td>
                                        <td>{{ date('d/M/Y', strtotime($getTicket->event_end_date)) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            {{-- <a href="">Get informed about construction industry trends &amp; development.</a>
                            <h6>Oct 19, 2016</h6> --}}
                        </div>
                    </div>

                    @endforeach

                    @else
                    <p style="text-align: center; color: darkblue; margin-top: 10px;">You have not created any event</p>

                    @endif
                    </div>

                        

                    </div>

                </div>

            </div>
        </div>
    </section>
    <!-- End blog area -->
@endsection
