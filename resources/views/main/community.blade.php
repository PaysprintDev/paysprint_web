@extends('layouts.app')


@section('content')
    

    

    <!-- All contact Info -->
    <section class="all_contact_info">
        <div class="container">
            <div class="row contact_row">
                <div class="col-sm-6 contact_info">
                    <h2>Contact</h2>
                    {{-- <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p> --}}
                    <div class="location">
                        <div class="location_laft">
                            <a class="f_location" href="#">location</a>
                            <a href="#">email</a>
                        </div>
                        <div class="address">
                            <a href="#">PaySprint by Express Ca Corp, <br>10 George St. North, Brampton. ON. L6X1R2. Canada </a>

                            @if ($data['continent'] != "Africa")
                                
                            <a href="#">info@paysprint.ca</a>

                            @else
                            
                            <a href="#">customerserviceafrica@paysprint.ca</a>
                                
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 contact_info send_message">
                    <h2>Send Us a Message</h2>
                    <form class="form-inline contact_box">
                        <label for="name"><span style="color: red !important; display: inline; float: none;">*</span> Name</label>
                        <input id="name" type="text" class="form-control input_box" @if($name != "") value="{{ $name }}" readonly @else placeholder="Name *" @endif>
                        <label for="email"><span style="color: red !important; display: inline; float: none;">*</span> Email</label>
                        <input id="email" type="text" class="form-control input_box" @if($email != "") value="{{ $email }}" readonly @else placeholder="Your Email *" @endif>
                        <label for="subject">Subject</label>
                        <input id="subject" type="text" class="form-control input_box" placeholder="Subject">
                        <label for="website"><span style="color: red !important; display: inline; float: none;">*</span> Website</label>
                        <input id="website" type="text" class="form-control input_box" placeholder="Your Website">
                        <label for="country"><span style="color: red !important; display: inline; float: none;">*</span> Country</label>

                        
            </select>
                        <label for="message"><span style="color: red !important; display: inline; float: none;">*</span> Message</label>
                        <textarea id="message" class="form-control input_box" placeholder="Message"></textarea>

                            {!! htmlFormSnippet() !!}
                            <br>
                        <button type="button" class="btn btn-default"  id="contactBtn">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- End All contact Info -->
@endsection
