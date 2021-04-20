@extends('layouts.app')


@section('content')
    <!-- Banner area -->
    <section class="banner_area" data-stellar-background-ratio="0.5">
        <h2>Contact Us</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('contact') }}" class="active">Contact Us</a></li>
        </ol>
    </section>
    <!-- End Banner area -->

    <!-- Map -->
    <div class="contact_map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11540.856121918176!2d-79.76125808993915!3d43.68531360041938!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882b1597c120173b%3A0x8c0309afa99d74d2!2s10%20George%20St%20N%2C%20Brampton%2C%20ON%20L6X%201R2%2C%20Canada!5e0!3m2!1sen!2sng!4v1570213666176!5m2!1sen!2sng" width="1300" height="600" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
    </div>
    <!-- End Map -->

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
                            <a href="#">info@paysprint.net</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 contact_info send_message">
                    <h2>Send Us a Message</h2>
                    <form class="form-inline contact_box">
                        <label for="name">Name</label>
                        <input id="name" type="text" class="form-control input_box" @if($name != "") value="{{ $name }}" readonly @else placeholder="Name *" @endif>
                        <label for="email">Email</label>
                        <input id="email" type="text" class="form-control input_box" @if($email != "") value="{{ $email }}" readonly @else placeholder="Your Email *" @endif>
                        <label for="subject">Subject</label>
                        <input id="subject" type="text" class="form-control input_box" placeholder="Subject">
                        <label for="website">Website</label>
                        <input id="website" type="text" class="form-control input_box" placeholder="Your Website">
                        <label for="message">Message</label>
                        <textarea id="message" class="form-control input_box" placeholder="Message"></textarea>

                            {!! htmlFormSnippet() !!}
                            <br>
                        <button type="button" class="btn btn-default" onclick="contactUs()">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- End All contact Info -->
@endsection
