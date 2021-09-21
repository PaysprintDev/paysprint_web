@extends('layouts.dashboard')


@section('dashContent')

<?php use \App\Http\Controllers\ClientInfo; ?>
<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\InvoicePayment; ?>
  <!-- Content Wrapper. Contains page content -->


  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <h1>
        PaySprint API Integration
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">API Integration</li>
      </ol>
    </div>

    <!-- Main content -->
    <div class="content body">
      
      <section id="introduction">
        <h2 class="page-header"><a href="#introduction">Introduction</a></h2>
        <p class="lead">
          <b>PaySprint</b> is the fastest and affordable method of Sending and Receiving money, Paying Invoice and Getting Paid at anytime!
        </p>
      </section><!-- /#introduction -->


      <!-- ============================================================= -->

      <section id="download">
        <div class="row">
          <div class="col-sm-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">UNIQUE API TOKEN</h3>
                <span class="label label-primary pull-right"><i class="fas fa-code"></i></span>
              </div><!-- /.box-header -->
              <div class="box-body">
                <p>Copy merchant api secrete key and send to your developer for integration on the website</p>

                <p>
                  <strong>BASE URL: </strong> <pre><strong>https://paysprint.ca/api/v1</strong></pre>
                </p>
                <p>
                  <strong>API MERCHANT KEY: </strong> <pre><strong>{{ $data['getbusinessDetail']->api_secrete_key }}</strong></pre>
                </p>

                <p><strong>RESPONSE CODE</strong></p>

                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Status</th>
                      <th>Code</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr>
                      <td align="right"><i class="fas fa-circle text-success"></i></td>
                      <td style="font-weight: 900">Success</td>
                      <td style="font-weight: 900">200</td>
                    </tr>
                    <tr>
                      <td align="right"><i class="fas fa-circle text-danger"></i></td>
                      <td style="font-weight: 900">Error</td>
                      <td style="font-weight: 900">400</td>
                    </tr>
                  </tbody>


                </table>

                <br>
                <br>


                <p><strong>FOR DEVELOPER USE</strong></p>
                <small>Share the link below with your developer</small>
                <pre>https://www.getpostman.com/collections/7135ceea9cd86961f373</pre>
                <table>
                  <tbody>
                    <tr>
                      <td>
                        <a href="https://www.getpostman.com/collections/7135ceea9cd86961f373" target="_blank" class="btn btn-primary"><i class="fas fa-book-reader"></i> View Postman Example</a>
                      </td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td style="font-weight: bold;">-</td>
                      <td style="font-weight: bold;">O</td>
                      <td style="font-weight: bold;">R</td>
                      <td style="font-weight: bold;">-</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>
                        <div class="postman-run-button"
                          data-postman-action="collection/import"
                          data-postman-var-1="7135ceea9cd86961f373"
                          data-postman-param="env%5BPaySprint%20Endpoint%5D=W3sia2V5IjoidXJsIiwidmFsdWUiOiJodHRwczovL3BheXNwcmludC5uZXQvYXBpL3YxIiwiZW5hYmxlZCI6dHJ1ZX0seyJrZXkiOiJhcHBrZXkiLCJ2YWx1ZSI6ImJhc2U2NDpKRk0rUEphV0QvcEJ5cFgrTmhYdWREckFtaWFuWmRHWVo0MXF6NFdoWEwwPSIsImVuYWJsZWQiOnRydWV9LHsia2V5IjoiYmVhcmVyIiwidmFsdWUiOiJleUowZVhBaU9pSktWMVFpTENKaGJHY2lPaUpTVXpJMU5pSXNJbXAwYVNJNkltTXdNV0UzTkdOaVpEaG1NalZtT1dVd1pXTmhaVEJsT1dNek1HUTNZVFJtTW1Sak16SmxPRFUyT0RJeU9HTXlaak5pTWpJd1l6TTRaRGhqTVROaE9URmpNVFkzWTJVM05qbGtNamhsT1dJMEluMC5leUpoZFdRaU9pSXhJaXdpYW5ScElqb2lZekF4WVRjMFkySmtPR1l5TldZNVpUQmxZMkZsTUdVNVl6TXdaRGRoTkdZeVpHTXpNbVU0TlRZNE1qSTRZekptTTJJeU1qQmpNemhrT0dNeE0yRTVNV014TmpkalpUYzJPV1F5T0dVNVlqUWlMQ0pwWVhRaU9qRTJNak15T1RVME5EZ3NJbTVpWmlJNk1UWXlNekk1TlRRME9Dd2laWGh3SWpveE5qVTBPRE14TkRRNExDSnpkV0lpT2lJeE15SXNJbk5qYjNCbGN5STZXMTE5LnJXZWZZQU5MaUJ0VTktdjNGQWJLamthWmhvV09hNWVCcEo2TVZnbG1IbUZrMmVzSG4yQlJ6a0lkNUo0ZTQ2V1daR1NucEFEdUZ3Y2NDbncwX1dDRmlsS256WGtMNnhnc243dzdhWXFzY0RZZEtfS3BHN0d6eGpmVzNNQk1LSmpSUU1mZWhxVDZoWHl4NnNDaWpMRFFDaWsxM3ZfRXNHVzZtX1UzNm5MZ3RRZWtmM0phckppakdyaXF5RHJEZkhiZlNzaU9UVzFtVjZsc2V1RXNyS0dPV3dhcWJrTzBMQ3FGU21VWGVfM2FXM0xwNzY1VmFzbGVabHVFcE5jbHNDMUk3alR0Z3pxVHdGUzVGVWNoQXYxNzB3R3l3enk5M3c4ejQ1bXEyeXVNV0owbFdYV1pWZ24tVmc3ZzhBNFU0VU1GeUxHRTd1dEVvTk1IR3k5bFJiWU9iUG84R3U4QXpEVVVUc2MwQm1HTzNKaTRsN1VyV3hBSG5uNWN2Ykx1YXA1SDdKaFpPSGJVWnpSdjhQUHc5cHBsc3huek5Zd2tpbER5Y3VXeFpHOUZjLWFPeHBYYnZMaDJlQTc1VFdna1ZSOUJqT1V6Qkp3bVE4UzhBR19OVmx5aTE2amdyb0g1Z3J1STl6eTU3bHNCd2JqdzBnV0Y5dXRqdFNmUnp4emNRS2xHNHBoc2dYUjlISDA4MVFNSGJodG92VGg2d1VvOHh2VGJQd0ZxSHlSSjVEOHJhbldWYjMyZDZGMjRNOUY2eUdYVmxWblVaTU0wSEhjdG9hWC1oVzhIQm5uV0otZkdXVFFSaEdTbXB1Uk1nMG0xaVFjRVFfMVpwaGRLVURxMzdvaHRwWnJyTlJiSXFIWm1pV1RNMFNXcV9jNHdjY2RyNkZPZHpLZVVlY1pLTUFjIiwiZW5hYmxlZCI6dHJ1ZX0seyJrZXkiOiJtZXJjaGFudGtleSIsInZhbHVlIjoiOTYyYzE2MGM4NzhlYWY4ZjY5NmUyZDdlNGIxZGZhNDAyOTA0MjAyMTE2MTk2ODk3NjUiLCJlbmFibGVkIjp0cnVlfV0="></div>
                          <script type="text/javascript">
                            (function (p,o,s,t,m,a,n) {
                              !p[s] && (p[s] = function () { (p[t] || (p[t] = [])).push(arguments); });
                              !o.getElementById(s+t) && o.getElementsByTagName("head")[0].appendChild((
                                (n = o.createElement("script")),
                                (n.id = s+t), (n.async = 1), (n.src = m), n
                              ));
                            }(window, document, "_pm", "PostmanRunObject", "https://run.pstmn.io/button.js"));
                          </script>
                      </td>
                    </tr>
                  </tbody>
                </table>

                

                

              
              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </div><!-- /.col -->
          
        </div><!-- /.row -->
        



    </div><!-- /.content -->
  </div><!-- /.content-wrapper -->

  @endsection