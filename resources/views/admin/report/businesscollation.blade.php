@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\Statement; ?>
<?php use \App\Http\Controllers\MonthlyFee; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Business Report
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Business Report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="row">
                <div class="col-md-2 col-md-offset-0">
                <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
            </div>
            </div>

              <h3 class="box-title">&nbsp;</h3> <br>

              <form action="{{ route('get business report') }}" method="GET">
                  @csrf
            <div class="row">
                <div class="col-md-12">
                    <label for="start">Select Country</label>
                  <select id="country" name="country" class="form-control">
                <option value="">Select Country</option>
                <option value="Afghanistan">Afghanistan</option>
                <option value="Åland Islands">Åland Islands</option>
                <option value="Albania">Albania</option>
                <option value="Algeria">Algeria</option>
                <option value="American Samoa">American Samoa</option>
                <option value="Andorra">Andorra</option>
                <option value="Angola">Angola</option>
                <option value="Anguilla">Anguilla</option>
                <option value="Antarctica">Antarctica</option>
                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                <option value="Argentina">Argentina</option>
                <option value="Armenia">Armenia</option>
                <option value="Aruba">Aruba</option>
                <option value="Australia">Australia</option>
                <option value="Austria">Austria</option>
                <option value="Azerbaijan">Azerbaijan</option>
                <option value="Bahamas">Bahamas</option>
                <option value="Bahrain">Bahrain</option>
                <option value="Bangladesh">Bangladesh</option>
                <option value="Barbados">Barbados</option>
                <option value="Belarus">Belarus</option>
                <option value="Belgium">Belgium</option>
                <option value="Belize">Belize</option>
                <option value="Benin">Benin</option>
                <option value="Bermuda">Bermuda</option>
                <option value="Bhutan">Bhutan</option>
                <option value="Bolivia">Bolivia</option>
                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                <option value="Botswana">Botswana</option>
                <option value="Bouvet Island">Bouvet Island</option>
                <option value="Brazil">Brazil</option>
                <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                <option value="Brunei Darussalam">Brunei Darussalam</option>
                <option value="Bulgaria">Bulgaria</option>
                <option value="Burkina Faso">Burkina Faso</option>
                <option value="Burundi">Burundi</option>
                <option value="Cambodia">Cambodia</option>
                <option value="Cameroon">Cameroon</option>
                <option value="Canada">Canada</option>
                <option value="Cape Verde">Cape Verde</option>
                <option value="Cayman Islands">Cayman Islands</option>
                <option value="Central African Republic">Central African Republic</option>
                <option value="Chad">Chad</option>
                <option value="Chile">Chile</option>
                <option value="China">China</option>
                <option value="Christmas Island">Christmas Island</option>
                <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                <option value="Colombia">Colombia</option>
                <option value="Comoros">Comoros</option>
                <option value="Congo">Congo</option>
                <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                <option value="Cook Islands">Cook Islands</option>
                <option value="Costa Rica">Costa Rica</option>
                <option value="Cote D'ivoire">Cote D'ivoire</option>
                <option value="Croatia">Croatia</option>
                <option value="Cuba">Cuba</option>
                <option value="Cyprus">Cyprus</option>
                <option value="Czech Republic">Czech Republic</option>
                <option value="Denmark">Denmark</option>
                <option value="Djibouti">Djibouti</option>
                <option value="Dominica">Dominica</option>
                <option value="Dominican Republic">Dominican Republic</option>
                <option value="Ecuador">Ecuador</option>
                <option value="Egypt">Egypt</option>
                <option value="El Salvador">El Salvador</option>
                <option value="Equatorial Guinea">Equatorial Guinea</option>
                <option value="Eritrea">Eritrea</option>
                <option value="Estonia">Estonia</option>
                <option value="Ethiopia">Ethiopia</option>
                <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                <option value="Faroe Islands">Faroe Islands</option>
                <option value="Fiji">Fiji</option>
                <option value="Finland">Finland</option>
                <option value="France">France</option>
                <option value="French Guiana">French Guiana</option>
                <option value="French Polynesia">French Polynesia</option>
                <option value="French Southern Territories">French Southern Territories</option>
                <option value="Gabon">Gabon</option>
                <option value="Gambia">Gambia</option>
                <option value="Georgia">Georgia</option>
                <option value="Germany">Germany</option>
                <option value="Ghana">Ghana</option>
                <option value="Gibraltar">Gibraltar</option>
                <option value="Greece">Greece</option>
                <option value="Greenland">Greenland</option>
                <option value="Grenada">Grenada</option>
                <option value="Guadeloupe">Guadeloupe</option>
                <option value="Guam">Guam</option>
                <option value="Guatemala">Guatemala</option>
                <option value="Guernsey">Guernsey</option>
                <option value="Guinea">Guinea</option>
                <option value="Guinea-bissau">Guinea-bissau</option>
                <option value="Guyana">Guyana</option>
                <option value="Haiti">Haiti</option>
                <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                <option value="Honduras">Honduras</option>
                <option value="Hong Kong">Hong Kong</option>
                <option value="Hungary">Hungary</option>
                <option value="Iceland">Iceland</option>
                <option value="India">India</option>
                <option value="Indonesia">Indonesia</option>
                <option value="Iran, Islamic Republic of Iran">Iran, Islamic Republic of Iran</option>
                <option value="Iraq">Iraq</option>
                <option value="Ireland">Ireland</option>
                <option value="Isle of Man">Isle of Man</option>
                <option value="Israel">Israel</option>
                <option value="Italy">Italy</option>
                <option value="Jamaica">Jamaica</option>
                <option value="Japan">Japan</option>
                <option value="Jersey">Jersey</option>
                <option value="Jordan">Jordan</option>
                <option value="Kazakhstan">Kazakhstan</option>
                <option value="Kenya">Kenya</option>
                <option value="Kiribati">Kiribati</option>
                <option value="Korea, Democratic People's Republic of Korea">Korea, Democratic People's Republic of Korea</option>
                <option value="Korea, Republic of Korea">Korea, Republic of Korea</option>
                <option value="Kuwait">Kuwait</option>
                <option value="Kyrgyzstan">Kyrgyzstan</option>
                <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                <option value="Latvia">Latvia</option>
                <option value="Lebanon">Lebanon</option>
                <option value="Lesotho">Lesotho</option>
                <option value="Liberia">Liberia</option>
                <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                <option value="Liechtenstein">Liechtenstein</option>
                <option value="Lithuania">Lithuania</option>
                <option value="Luxembourg">Luxembourg</option>
                <option value="Macao">Macao</option>
                <option value="Macedonia, The Former Yugoslav Republic of Macedonia">Macedonia, The Former Yugoslav Republic of Macedonia</option>
                <option value="Madagascar">Madagascar</option>
                <option value="Malawi">Malawi</option>
                <option value="Malaysia">Malaysia</option>
                <option value="Maldives">Maldives</option>
                <option value="Mali">Mali</option>
                <option value="Malta">Malta</option>
                <option value="Marshall Islands">Marshall Islands</option>
                <option value="Martinique">Martinique</option>
                <option value="Mauritania">Mauritania</option>
                <option value="Mauritius">Mauritius</option>
                <option value="Mayotte">Mayotte</option>
                <option value="Mexico">Mexico</option>
                <option value="Micronesia, Federated States of Micronesia">Micronesia, Federated States of Micronesia</option>
                <option value="Moldova, Republic of">Moldova, Republic of</option>
                <option value="Monaco">Monaco</option>
                <option value="Mongolia">Mongolia</option>
                <option value="Montenegro">Montenegro</option>
                <option value="Montserrat">Montserrat</option>
                <option value="Morocco">Morocco</option>
                <option value="Mozambique">Mozambique</option>
                <option value="Myanmar">Myanmar</option>
                <option value="Namibia">Namibia</option>
                <option value="Nauru">Nauru</option>
                <option value="Nepal">Nepal</option>
                <option value="Netherlands">Netherlands</option>
                <option value="Netherlands Antilles">Netherlands Antilles</option>
                <option value="New Caledonia">New Caledonia</option>
                <option value="New Zealand">New Zealand</option>
                <option value="Nicaragua">Nicaragua</option>
                <option value="Niger">Niger</option>
                <option value="Nigeria">Nigeria</option>
                <option value="Niue">Niue</option>
                <option value="Norfolk Island">Norfolk Island</option>
                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                <option value="Norway">Norway</option>
                <option value="Oman">Oman</option>
                <option value="Pakistan">Pakistan</option>
                <option value="Palau">Palau</option>
                <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                <option value="Panama">Panama</option>
                <option value="Papua New Guinea">Papua New Guinea</option>
                <option value="Paraguay">Paraguay</option>
                <option value="Peru">Peru</option>
                <option value="Philippines">Philippines</option>
                <option value="Pitcairn">Pitcairn</option>
                <option value="Poland">Poland</option>
                <option value="Portugal">Portugal</option>
                <option value="Puerto Rico">Puerto Rico</option>
                <option value="Qatar">Qatar</option>
                <option value="Reunion">Reunion</option>
                <option value="Romania">Romania</option>
                <option value="Russian Federation">Russian Federation</option>
                <option value="Rwanda">Rwanda</option>
                <option value="Saint Helena">Saint Helena</option>
                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                <option value="Saint Lucia">Saint Lucia</option>
                <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                <option value="Samoa">Samoa</option>
                <option value="San Marino">San Marino</option>
                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                <option value="Saudi Arabia">Saudi Arabia</option>
                <option value="Senegal">Senegal</option>
                <option value="Serbia">Serbia</option>
                <option value="Seychelles">Seychelles</option>
                <option value="Sierra Leone">Sierra Leone</option>
                <option value="Singapore">Singapore</option>
                <option value="Slovakia">Slovakia</option>
                <option value="Slovenia">Slovenia</option>
                <option value="Solomon Islands">Solomon Islands</option>
                <option value="Somalia">Somalia</option>
                <option value="South Africa">South Africa</option>
                <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                <option value="Spain">Spain</option>
                <option value="Sri Lanka">Sri Lanka</option>
                <option value="Sudan">Sudan</option>
                <option value="Suriname">Suriname</option>
                <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                <option value="Swaziland">Swaziland</option>
                <option value="Sweden">Sweden</option>
                <option value="Switzerland">Switzerland</option>
                <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                <option value="Tajikistan">Tajikistan</option>
                <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                <option value="Thailand">Thailand</option>
                <option value="Timor-leste">Timor-leste</option>
                <option value="Togo">Togo</option>
                <option value="Tokelau">Tokelau</option>
                <option value="Tonga">Tonga</option>
                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                <option value="Tunisia">Tunisia</option>
                <option value="Turkey">Turkey</option>
                <option value="Turkmenistan">Turkmenistan</option>
                <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                <option value="Tuvalu">Tuvalu</option>
                <option value="Uganda">Uganda</option>
                <option value="Ukraine">Ukraine</option>
                <option value="United Arab Emirates">United Arab Emirates</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="United States">United States</option>
                <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                <option value="Uruguay">Uruguay</option>
                <option value="Uzbekistan">Uzbekistan</option>
                <option value="Vanuatu">Vanuatu</option>
                <option value="Venezuela">Venezuela</option>
                <option value="Viet Nam">Viet Nam</option>
                <option value="Virgin Islands, British">Virgin Islands, British</option>
                <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                <option value="Wallis and Futuna">Wallis and Futuna</option>
                <option value="Western Sahara">Western Sahara</option>
                <option value="Yemen">Yemen</option>
                <option value="Zambia">Zambia</option>
                <option value="Zimbabwe">Zimbabwe</option>
            </select>

            <br>
                </div>
                
                <div class="col-md-6">
                    <label for="start">Start Date</label>
                  <input type="date" name="start" class="form-control" id="start">
                </div>
                <div class="col-md-6">
                    <label for="end">End Date</label>
                  <input type="date" name="end" class="form-control" id="end">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-primary btn-block" type="submit">Submit </button>
                </div>
              </div>
              </form>
            </div>
            <!-- /.box-header -->

            <div class="box-body table table-responsive">

              <table class="table table-bordered table-striped" id="example3">

                @if($currency = \App\User::where('country', Request::get('country'))->first())
                
                    @php
                        $currency = $currency->currencyCode;
                    @endphp
                @endif

                @if (count($data['result']) > 0)

                <?php $expected = 0; $actual= 0;?>

                

                    {{-- Added Money --}}
                    @if($addedAmount = \App\Statement::where('country', Request::get('country'))->whereBetween('trans_date', [Request::get('start'), Request::get('end')])->where('activity', 'LIKE', '%Added%')->sum('credit'))
                        @php
                            $addedAmount = $addedAmount;
                        @endphp
                    @endif

                    {{-- PaySprint Gateway  --}}
                    @if($creditAmount = \App\Statement::where('country', Request::get('country'))->whereBetween('trans_date', [Request::get('start'), Request::get('end')])->where('activity', 'LIKE', '%deducted from Card%')->sum('credit'))
                        @php
                            $creditAmount = $creditAmount;
                        @endphp
                    @endif


                    @if($prepaidAmount = \App\Statement::where('country', Request::get('country'))->whereBetween('trans_date', [Request::get('start'), Request::get('end')])->where('activity', 'LIKE', '%Prepaid Card%')->sum('credit'))
                        @php
                            $prepaidAmount = $prepaidAmount;
                        @endphp
                    @endif

                    @if($bankAmount = \App\Statement::where('country', Request::get('country'))->whereBetween('trans_date', [Request::get('start'), Request::get('end')])->where('activity', 'LIKE', '%Bank%')->sum('credit'))
                        @php
                            $bankAmount = $bankAmount;
                        @endphp
                    @endif

                    {{-- @if($transferAmount = \App\Statement::where('country', Request::get('country'))->whereBetween('trans_date', [Request::get('start'), Request::get('end')])->where('activity', 'LIKE', '%in wallet for%')->where('report_status', 'Money received')->sum('credit'))
                        @php
                            $transferAmount = $transferAmount;
                        @endphp
                    @endif --}}


                    @if($chargefeeforaddedmoney = \App\Statement::where('country', Request::get('country'))->whereBetween('trans_date', [Request::get('start'), Request::get('end')])->where('activity', 'LIKE', '%to Wallet%')->sum('chargefee'))
                        @php
                            $chargefeeforaddedmoney = $chargefeeforaddedmoney;
                        @endphp
                    @endif


                    @if($creditcardchargefeeforaddedmoney = \App\Statement::where('country', Request::get('country'))->whereBetween('trans_date', [Request::get('start'), Request::get('end')])->where('activity', 'LIKE', '%deducted from Card%')->sum('chargefee'))
                        @php
                            $creditcardchargefeeforaddedmoney = $creditcardchargefeeforaddedmoney;
                        @endphp
                    @endif


                    @if($prepaidcardchargefeeforaddedmoney = \App\Statement::where('country', Request::get('country'))->whereBetween('trans_date', [Request::get('start'), Request::get('end')])->where('activity', 'LIKE', '%Prepaid Card%')->sum('chargefee'))
                        @php
                            $prepaidcardchargefeeforaddedmoney = $prepaidcardchargefeeforaddedmoney;
                        @endphp
                    @endif


                    @if($bankchargefeeforaddedmoney = \App\Statement::where('country', Request::get('country'))->whereBetween('trans_date', [Request::get('start'), Request::get('end')])->where('activity', 'LIKE', '%Bank%')->sum('chargefee'))
                        @php
                            $bankchargefeeforaddedmoney = $bankchargefeeforaddedmoney;
                        @endphp
                    @endif


                    {{-- Withdrawal Money --}}
                    @if($withdrawAmount = \App\Statement::where('country', Request::get('country'))->whereBetween('trans_date', [Request::get('start'), Request::get('end')])->where('activity', 'LIKE', '%Withdraw%')->sum('debit'))
                        @php
                            $withdrawAmount = $withdrawAmount;
                        @endphp
                    @endif


                    @if($cardwithdrawAmount = \App\Statement::where('country', Request::get('country'))->whereBetween('trans_date', [Request::get('start'), Request::get('end')])->where('activity', 'LIKE', '%from Wallet to Credit/Debit card%')->sum('debit'))
                        @php
                            $cardwithdrawAmount = $cardwithdrawAmount;
                        @endphp
                    @endif


                    @if($prepaidwithdrawAmount = \App\Statement::where('country', Request::get('country'))->whereBetween('trans_date', [Request::get('start'), Request::get('end')])->where('activity', 'LIKE', '%from Wallet to EXBC Prepaid Card%')->sum('debit'))
                        @php
                            $prepaidwithdrawAmount = $prepaidwithdrawAmount;
                        @endphp
                    @endif


                    @if($bankwithdrawAmount = \App\Statement::where('country', Request::get('country'))->whereBetween('trans_date', [Request::get('start'), Request::get('end')])->where('activity', 'LIKE', '%Bank%')->sum('debit'))
                        @php
                            $bankwithdrawAmount = $bankwithdrawAmount;
                        @endphp
                    @endif


                    @if($chargefeeforwithdrawmoney = \App\Statement::where('country', Request::get('country'))->whereBetween('trans_date', [Request::get('start'), Request::get('end')])->where('activity', 'LIKE', '%Withdraw%')->sum('chargefee'))
                        @php
                            $chargefeeforwithdrawmoney = $chargefeeforwithdrawmoney;
                        @endphp
                    @endif


                    @if($creditchargefeeforwithdrawmoney = \App\Statement::where('country', Request::get('country'))->whereBetween('trans_date', [Request::get('start'), Request::get('end')])->where('activity', 'LIKE', '%from Wallet to Credit/Debit card%')->sum('chargefee'))
                        @php
                            $creditchargefeeforwithdrawmoney = $creditchargefeeforwithdrawmoney;
                        @endphp
                    @endif


                    @if($prepaidchargefeeforwithdrawmoney = \App\Statement::where('country', Request::get('country'))->whereBetween('trans_date', [Request::get('start'), Request::get('end')])->where('activity', 'LIKE', '%from Wallet to EXBC Prepaid Card%')->sum('chargefee'))
                        @php
                            $prepaidchargefeeforwithdrawmoney = $prepaidchargefeeforwithdrawmoney;
                        @endphp
                    @endif


                    @if($bankchargefeeforwithdrawmoney = \App\Statement::where('country', Request::get('country'))->whereBetween('trans_date', [Request::get('start'), Request::get('end')])->where('activity', 'LIKE', '%Bank%')->sum('chargefee'))
                        @php
                            $bankchargefeeforwithdrawmoney = $bankchargefeeforwithdrawmoney;
                        @endphp
                    @endif


                    {{-- Wallet Maintenance --}}
                    @if($maintenacefee = \App\MonthlyFee::where('country', Request::get('country'))->whereBetween('created_at', [Request::get('start'), Request::get('end')])->sum('amount'))
                        @php
                            $maintenacefee = $maintenacefee;
                        @endphp
                    @endif


                        @php
                            $expected = $addedAmount + $chargefeeforaddedmoney - $withdrawAmount + $chargefeeforwithdrawmoney - $maintenacefee;
                            $actual = $chargefeeforaddedmoney + $chargefeeforwithdrawmoney + $maintenacefee;
                        @endphp


                        @else

                        
                        @php
                            $addedAmount = 0;
                            $creditAmount = 0;
                            // $transferAmount = 0;
                            $prepaidAmount = 0;
                            $bankAmount = 0;
                            $chargefeeforaddedmoney = 0;
                            $creditcardchargefeeforaddedmoney = 0;
                            $prepaidcardchargefeeforaddedmoney = 0;
                            $bankchargefeeforaddedmoney = 0;
                            $withdrawAmount = 0;
                            $cardwithdrawAmount = 0;
                            $prepaidwithdrawAmount = 0;
                            $bankwithdrawAmount = 0;
                            $chargefeeforwithdrawmoney = 0;
                            $creditchargefeeforwithdrawmoney = 0;
                            $prepaidchargefeeforwithdrawmoney = 0;
                            $bankchargefeeforwithdrawmoney = 0;
                            $maintenacefee = 0;
                            $expected = 0;
                            $actual = 0;
                        @endphp
                @endif

                <tbody>

                    <tr>
                        <td colspan="3" align="center"><strong style="font-size: 24px;">Country: {{ Request::get('country') }} | From: {{ date('d-m-Y', strtotime(Request::get('start'))) }} - To: {{ date('d-m-Y', strtotime(Request::get('end'))) }} </strong></td>
                    </tr>

                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    
                    <tr>
                        <td colspan="3"><strong>Added Money (Inflow)</strong></td>
                    </tr>
                    
                    <tr>
                        <td>Net Amount To Wallet by Gateway(+)</td>
                        <td style="font-weight: 900; color: green;">{{ $currency.' '.number_format($addedAmount, 2) }}</td>
                        <td><a href="{{ route('net amount to wallet', 'country='.Request::get('country').'&start='.Request::get('start').'&end='.Request::get('end')) }}" class="btn btn-primary" type="button">View details</a></td>
                    </tr>

                    
                    
                    <tr>
                        <td colspan="3"><strong>PaySprint</strong></td>
                    </tr>
                    
                    <tr>
                        <td>Credit/Debit Card</td>
                        <td style="font-weight: 900; color: green;">{{ $currency.' '.number_format($creditAmount, 2) }}</td>
                        <td><a href="#" class="btn btn-primary" type="button">View details</a></td>
                    </tr>

                    <tr>
                        <td>Prepaid Card</td>
                        <td style="font-weight: 900; color: green;">{{ $currency.' '.number_format($prepaidAmount, 2) }}</td>
                        <td><a href="#" class="btn btn-primary" type="button">View details</a></td>
                    </tr>
                    
                    <tr>
                        <td>Bank Account</td>
                        <td style="font-weight: 900; color: green;">{{ $currency.' '.number_format($bankAmount, 2) }}</td>
                        <td><a href="#" class="btn btn-primary" type="button">View details</a></td>
                    </tr>

                    {{-- <tr>
                        <td>Wallet to Wallet</td>
                        <td style="font-weight: 900; color: green;">{{ $currency.' '.number_format($transferAmount, 2) }}</td>
                        <td><a href="#" class="btn btn-primary" type="button">View details</a></td>
                    </tr> --}}
                    
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>

                    <tr>
                        <td>Charge on Add Money (+)</td>
                        <td style="font-weight: 900; color: green;">{{ $currency.' '.number_format($chargefeeforaddedmoney, 2) }}</td>
                        <td><a href="{{ route('charge on add money', 'country='.Request::get('country').'&start='.Request::get('start').'&end='.Request::get('end')) }}" class="btn btn-primary" type="button">View details</a></td>
                    </tr>


                    <tr>
                        <td colspan="3"><strong>PaySprint</strong></td>
                    </tr>
                    
                    <tr>
                        <td>Credit/Debit Card</td>
                        <td style="font-weight: 900; color: green;">{{ $currency.' '.number_format($creditcardchargefeeforaddedmoney, 2) }}</td>
                        <td><a href="#" class="btn btn-primary" type="button">View details</a></td>
                    </tr>


                    <tr>
                        <td>Prepaid Card</td>
                        <td style="font-weight: 900; color: green;">{{ $currency.' '.number_format($prepaidcardchargefeeforaddedmoney, 2) }}</td>
                        <td><a href="#" class="btn btn-primary" type="button">View details</a></td>
                    </tr>
                    
                    <tr>
                        <td>Bank Account</td>
                        <td style="font-weight: 900; color: green;">{{ $currency.' '.number_format($bankchargefeeforaddedmoney, 2) }}</td>
                        <td><a href="#" class="btn btn-primary" type="button">View details</a></td>
                    </tr>

                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>

                    <tr>
                        <td colspan="3"><strong>Withdrawal (Outflow)</strong></td>
                    </tr>
                    
                    <tr>
                        <td>Withdraw from Wallet By Gateway (-)</td>
                        <td style="font-weight: 900; color: red;">{{ $currency.' '.number_format($withdrawAmount, 2) }}</td>
                        <td><a href="{{ route('amount withdrawn from wallet', 'country='.Request::get('country').'&start='.Request::get('start').'&end='.Request::get('end')) }}" class="btn btn-primary" type="button">View details</a></td>
                    </tr>

                    <tr>
                        <td colspan="3"><strong>PaySprint</strong></td>
                    </tr>
                    
                    <tr>
                        <td>Credit/Debit Card</td>
                        <td style="font-weight: 900; color: red;">{{ $currency.' '.number_format($cardwithdrawAmount, 2) }}</td>
                        <td><a href="#" class="btn btn-primary" type="button">View details</a></td>
                    </tr>


                    <tr>
                        <td>Prepaid Card</td>
                        <td style="font-weight: 900; color: red;">{{ $currency.' '.number_format($prepaidwithdrawAmount, 2) }}</td>
                        <td><a href="#" class="btn btn-primary" type="button">View details</a></td>
                    </tr>
                    
                    <tr>
                        <td>Bank Account</td>
                        <td style="font-weight: 900; color: red;">{{ $currency.' '.number_format($bankwithdrawAmount, 2) }}</td>
                        <td><a href="#" class="btn btn-primary" type="button">View details</a></td>
                    </tr>
                    
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>

                    <tr>
                        <td>Charge on Withdrawal (+)</td>
                        <td style="font-weight: 900; color: green;">{{ $currency.' '.number_format($chargefeeforwithdrawmoney, 2) }}</td>
                        <td><a href="{{ route('charges on withdrawal', 'country='.Request::get('country').'&start='.Request::get('start').'&end='.Request::get('end')) }}" class="btn btn-primary" type="button">View details</a></td>
                    </tr>

                    <tr>
                        <td colspan="3"><strong>PaySprint</strong></td>
                    </tr>
                    
                    <tr>
                        <td>Credit/Debit Card</td>
                        <td style="font-weight: 900; color: green;">{{ $currency.' '.number_format($creditchargefeeforwithdrawmoney, 2) }}</td>
                        <td><a href="#" class="btn btn-primary" type="button">View details</a></td>
                    </tr>

                    <tr>
                        <td>Prepaid Card</td>
                        <td style="font-weight: 900; color: green;">{{ $currency.' '.number_format($prepaidchargefeeforwithdrawmoney, 2) }}</td>
                        <td><a href="#" class="btn btn-primary" type="button">View details</a></td>
                    </tr>
                    
                    <tr>
                        <td>Bank Account</td>
                        <td style="font-weight: 900; color: green;">{{ $currency.' '.number_format($bankchargefeeforwithdrawmoney, 2) }}</td>
                        <td><a href="#" class="btn btn-primary" type="button">View details</a></td>
                    </tr>


                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3"><strong>Wallet Maintenance</strong></td>
                    </tr>
                    
                    <tr>
                        <td>Maintenace Fee (-)</td>
                        <td style="font-weight: 900; color: red;">{{ $currency.' '.number_format($maintenacefee, 2) }}</td>
                        <td><a href="{{ route('wallet maintenance fee', 'country='.Request::get('country').'&start='.Request::get('start').'&end='.Request::get('end')) }}" class="btn btn-primary" type="button">View details</a></td>
                    </tr>


                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3"><strong>Expected Balance</strong></td>
                    </tr>
                    
                    <tr>
                        <td>Expected Balance (+)</td>
                        <td colspan="2" style="font-weight: 900; color: green;">{{ $currency.' '.number_format($expected, 2) }}</td>
                    </tr>


                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3"><strong>Charge Balance</strong></td>
                    </tr>
                    
                    <tr>
                        <td>Charge Balance (+)</td>
                        <td colspan="2" style="font-weight: 900; color: green;">{{ $currency.' '.number_format($actual, 2) }}</td>
                    </tr>
                    
                </tbody>

              </table>
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


