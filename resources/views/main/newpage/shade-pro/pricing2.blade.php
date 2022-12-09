@extends('layouts.newpage.app')

@section('content')
<!-- navbar- -->
<div style="overflow-y: auto !important;">
    <div class="inner-banner pt-29 pt-lg-30 pb-9 pb-lg-12 bg-default-6">
        <div class="container">
            <div class="row  justify-content-center pt-5">
                <div class="col-xl-8 col-lg-9">
                    <div class="px-md-15 text-center">
                        <h2 class="title gr-text-2 mb-8 mb-lg-10">Pricing</h2>
                        {{-- <p class="gr-text-7 mb-0 mb-lg-13">Full Time, Remote</p> --}}
                    </div>
                </div>

                <div class="col-12">
                    <table class="table table-striped table-bordered">

                        <tbody>
                            <tr>
                                <td>
                                    <p class="gr-text-7 font-weight-bold mb-9">Select Country</p>

                                    <select name="country" id="pricing_country2" class="form-control" style="overflow-y: auto">
                                        <option value="">Select Country</option>
                                        @foreach ($data['activecountries'] as $country)
                                        <option value="{{ $country->name }}" {{ $country->name == Request::get('country') ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="main-block pb-6 pb-lg-17 bg-default-6">
        <div class="container">
            <div class="row justify-content-center">

                <div class="table table-responsive">


                </div>
                <div class="table table-responsive">
                    <table class="table table-striped table-bordered">
                        <tbody>

                            <tr>
                                <td>
                                    <p class="gr-text-6 font-weight-bold mb-9"></p>
                                </td>

                                <td align="center">
                                    <p class="gr-text-6 font-weight-bold mb-9">Freemium</p>
                                    <p class="text-danger"></p>
                                </td>
                                
                                <td align="center">
                                    <p class="gr-text-6 font-weight-bold mb-9">Basic</p>
                                    <p class="text-danger">{{ $data['currency'] . '0.00' }} Fee</p>
                                </td>


                                @if ($thisprices = \App\TransactionCost::where('country', $data['country'])->where('structure', 'Merchant Monthly Subscription')->first())

                                @php
                                $monthlyBased = $thisprices->fixed;
                                $yearlyBased = $thisprices->fixed * 10;
                                @endphp

                                @else
                                @php
                                $monthlyBased = 0;
                                $yearlyBased = 0;
                                @endphp
                                @endif

                                <td align="center">
                                    <p class="gr-text-6 font-weight-bold mb-9">Classic</p>
                                    <p class="text-danger">
                                        
                                        {{ $data['currency'] . number_format($monthlyBased, 2) }}
                                        Monthly
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="gr-text-7 mb-0 ">
                                        <strong>Receive Payment from Customers</strong>
                                    </p>
                                </td>
                                <td align="center"> 
                                </td>
                                <td align="center">
                                 
                                </td>
                                <td align="center">
                                
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">QR Code</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" /> 
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">Payment Links</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">Online Payment</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" /> 
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <p class="gr-text-7 mb-0"><strong>Invoicing System</strong></p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="gr-text-7 mb-0"><strong>PaySprint eStore</strong></p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                            </tr>

                            @if (Request::get('country') == 'Canada' || Request::get('country') == 'United States')

                            <tr>
                                <td>
                                    <p class="gr-text-7 mb-0"><strong>Rental Property Management</strong></p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                            </tr>

                            @endif



                            @if (Request::get('country') == 'Canada' || Request::get('country') == 'United States')

                            <tr>
                                <td>
                                    <p class="gr-text-7 mb-0"><strong>Merchants Cash Advance</strong></p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                            </tr>

                            @endif

                            <tr>
                                <td>
                                    <p class="gr-text-7 mb-0"><strong>PaySprint - Working Capital Support</strong></p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <p class="gr-text-7 mb-0"><strong>PaySprint FX</strong></p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <p class="gr-text-7 mb-0"><strong>Transfer</strong> </p>
                                </td>
                                <td align="center">
                                    

                                </td>
                                <td align="center">
                                   

                                </td>
                                <td align="center">
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">Local(PaySprint User)</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">Local(Non-PaySprint User)</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">International(PaySprint User)</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">International(Non-PaySprint User)</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="gr-text-7 mb-0"><strong>Pay Invoice</strong></p>
                                </td>
                                <td align="center">
                                  

                                </td>
                                <td align="center">
                                 

                                </td>
                                <td align="center">
                                  
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">PaySprint Merchant(Local)</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">PaySprint Merchant(International)</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">Non-PaySprint Merchant(Local)</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">Non-PaySprint Merchant(International)</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="gr-text-7 mb-0"><strong>Bill Payment</strong></p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0 text-danger">Minimum balance of {{ $data['currency'] . number_format($monthlyBased, 2) }} in Wallet Applies.</p>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <p class="text-center text-danger">7days Free Subscription. Cancel Subscription at any time.</p>
                                </td>
                                 <td></td>
                                {{-- <td></td> --}}
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <p class="text-center text-danger">Where PaySprint has no office, Partner fee may apply.</p>
                                </td>
                                 <td></td>
                                {{-- <td></td> --}}
                            </tr>

                        </tbody>


                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection