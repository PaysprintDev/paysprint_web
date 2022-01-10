@extends('layouts.app')


@section('content')

    <!-- All contact Info -->
    <section class="all_contact_info">
        <div class="container">
            <div class="row contact_row">
                
                <div class="col-sm-6 contact_info send_message">
                    <h2>All Messages</h2>
                    <form class="form-inline contact_box">
                        <label for="subject">Subject</label>
                        <input id="subject" type="text" class="form-control input_box" placeholder="Subject">
                        <label for="email"><span style="color: red !important; display: inline; float: none;">*</span> Cartegory</label>
                        
                        <label for="message"><span style="color: red !important; display: inline; float: none;">*</span> Message</label>
                        <textarea id="message" class="form-control input_box" placeholder="Message"></textarea>

                            {!! htmlFormSnippet() !!}
                            <br>
                        <button type="button" class="btn btn-default" id="contactBtn">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- End All contact Info -->
@endsection
