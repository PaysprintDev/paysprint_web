

    @extends('layouts.newpage.app')

@section('content')
    <!-- navbar- -->
    <div class="inner-banner pt-29 pt-lg-30 pb-9 pb-lg-12 bg-default-6">
      <div class="container">
        <div class="row  justify-content-center pt-5">
          <div class="col-xl-8 col-lg-9">
            <div class="px-md-15 text-center">
              <h2 class="title gr-text-2 mb-8 mb-lg-10">{{ $pages }}</h2>
              {{-- <p class="gr-text-7 mb-0 mb-lg-13">Full Time, Remote</p> --}}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="main-block pb-6 pb-lg-17 bg-default-6">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-10 col-lg-10">
            <div class="single-block mb-12 mb-lg-15 table-responsive">
                
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Last Updated | {{ date('d/m/Y') }}</p></td>
                        </tr>
                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Definition of Keywords</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Add Money</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">Activities involving adding money to your PS Account from Credit cards, Debit VISA/Mastercard debit or Bank Accounts</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Send Money</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">Including activities involving Sending money to Families, Friends and Associates from PS Wallet</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Pay Invoice</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">Paying invoice generated and sent by a PS merchant</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Request for Refund to Wallet</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">Asking for refund of money sent to a PS user and non-PS user when the receiver is unable to access the funds</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Withdrawal</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">PS user or merchant request for funds to be deposited from PS wallet to prescribed Credit Cards, Debit VISA or Mastercard Debit or Bank Account</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local Currency</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">Local Currency is the currency of the country where the user resides</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local Transfer</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">Local transfer is the transfer of funds between users in the same country and in same currency</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">International Transfer</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">International Transfer is the transfer of funds between users living in separate countries and with different currencies</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Text/Email to Transfer</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">Text/Email to Transfer is a unique method of sending money to families, friends and associates that are not PS users</p></td>
                        </tr>
                    </tbody>
                </table>

                <hr>

                <table class="table table-striped table-bordered">
                    <tbody>

                        <tr>
                            <td colspan="3"><p class="gr-text-7 font-weight-bold mb-9">Select Country</p>
                            
                                <select name="country" id="pricing_country" class="form-control">
                                    <option value="">Select Country</option>
                                    <option value="Afghanistan">Afghanistan</option>
                                    <option value="Albania">Albania</option>
                                    <option value="Algeria">Algeria</option>
                                    <option value="American Samoa">American Samoa</option>
                                    <option value="Andorra">Andorra</option>
                                    <option value="Angola">Angola</option>
                                    <option value="Anguilla">Anguilla</option>
                                    <option value="Antigua & Barbuda">Antigua & Barbuda</option>
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
                                    <option value="Bonaire">Bonaire</option>
                                    <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                    <option value="Botswana">Botswana</option>
                                    <option value="Brazil">Brazil</option>
                                    <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                    <option value="Brunei">Brunei</option>
                                    <option value="Bulgaria">Bulgaria</option>
                                    <option value="Burkina Faso">Burkina Faso</option>
                                    <option value="Burundi">Burundi</option>
                                    <option value="Cambodia">Cambodia</option>
                                    <option value="Cameroon">Cameroon</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Canary Islands">Canary Islands</option>
                                    <option value="Cape Verde">Cape Verde</option>
                                    <option value="Cayman Islands">Cayman Islands</option>
                                    <option value="Central African Republic">Central African Republic</option>
                                    <option value="Chad">Chad</option>
                                    <option value="Channel Islands">Channel Islands</option>
                                    <option value="Chile">Chile</option>
                                    <option value="China">China</option>
                                    <option value="Christmas Island">Christmas Island</option>
                                    <option value="Cocos Island">Cocos Island</option>
                                    <option value="Colombia">Colombia</option>
                                    <option value="Comoros">Comoros</option>
                                    <option value="Congo">Congo</option>
                                    <option value="Cook Islands">Cook Islands</option>
                                    <option value="Costa Rica">Costa Rica</option>
                                    <option value="Cote DIvoire">Cote DIvoire</option>
                                    <option value="Croatia">Croatia</option>
                                    <option value="Cuba">Cuba</option>
                                    <option value="Curaco">Curacao</option>
                                    <option value="Cyprus">Cyprus</option>
                                    <option value="Czech Republic">Czech Republic</option>
                                    <option value="Denmark">Denmark</option>
                                    <option value="Djibouti">Djibouti</option>
                                    <option value="Dominica">Dominica</option>
                                    <option value="Dominican Republic">Dominican Republic</option>
                                    <option value="East Timor">East Timor</option>
                                    <option value="Ecuador">Ecuador</option>
                                    <option value="Egypt">Egypt</option>
                                    <option value="El Salvador">El Salvador</option>
                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                    <option value="Eritrea">Eritrea</option>
                                    <option value="Estonia">Estonia</option>
                                    <option value="Ethiopia">Ethiopia</option>
                                    <option value="Falkland Islands">Falkland Islands</option>
                                    <option value="Faroe Islands">Faroe Islands</option>
                                    <option value="Fiji">Fiji</option>
                                    <option value="Finland">Finland</option>
                                    <option value="France">France</option>
                                    <option value="French Guiana">French Guiana</option>
                                    <option value="French Polynesia">French Polynesia</option>
                                    <option value="French Southern Ter">French Southern Ter</option>
                                    <option value="Gabon">Gabon</option>
                                    <option value="Gambia">Gambia</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Ghana">Ghana</option>
                                    <option value="Gibraltar">Gibraltar</option>
                                    <option value="Great Britain">Great Britain</option>
                                    <option value="Greece">Greece</option>
                                    <option value="Greenland">Greenland</option>
                                    <option value="Grenada">Grenada</option>
                                    <option value="Guadeloupe">Guadeloupe</option>
                                    <option value="Guam">Guam</option>
                                    <option value="Guatemala">Guatemala</option>
                                    <option value="Guinea">Guinea</option>
                                    <option value="Guyana">Guyana</option>
                                    <option value="Haiti">Haiti</option>
                                    <option value="Hawaii">Hawaii</option>
                                    <option value="Honduras">Honduras</option>
                                    <option value="Hong Kong">Hong Kong</option>
                                    <option value="Hungary">Hungary</option>
                                    <option value="Iceland">Iceland</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="India">India</option>
                                    <option value="Iran">Iran</option>
                                    <option value="Iraq">Iraq</option>
                                    <option value="Ireland">Ireland</option>
                                    <option value="Isle of Man">Isle of Man</option>
                                    <option value="Israel">Israel</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Jamaica">Jamaica</option>
                                    <option value="Japan">Japan</option>
                                    <option value="Jordan">Jordan</option>
                                    <option value="Kazakhstan">Kazakhstan</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="Kiribati">Kiribati</option>
                                    <option value="Korea North">Korea North</option>
                                    <option value="Korea Sout">Korea South</option>
                                    <option value="Kuwait">Kuwait</option>
                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                    <option value="Laos">Laos</option>
                                    <option value="Latvia">Latvia</option>
                                    <option value="Lebanon">Lebanon</option>
                                    <option value="Lesotho">Lesotho</option>
                                    <option value="Liberia">Liberia</option>
                                    <option value="Libya">Libya</option>
                                    <option value="Liechtenstein">Liechtenstein</option>
                                    <option value="Lithuania">Lithuania</option>
                                    <option value="Luxembourg">Luxembourg</option>
                                    <option value="Macau">Macau</option>
                                    <option value="Macedonia">Macedonia</option>
                                    <option value="Madagascar">Madagascar</option>
                                    <option value="Malaysia">Malaysia</option>
                                    <option value="Malawi">Malawi</option>
                                    <option value="Maldives">Maldives</option>
                                    <option value="Mali">Mali</option>
                                    <option value="Malta">Malta</option>
                                    <option value="Marshall Islands">Marshall Islands</option>
                                    <option value="Martinique">Martinique</option>
                                    <option value="Mauritania">Mauritania</option>
                                    <option value="Mauritius">Mauritius</option>
                                    <option value="Mayotte">Mayotte</option>
                                    <option value="Mexico">Mexico</option>
                                    <option value="Midway Islands">Midway Islands</option>
                                    <option value="Moldova">Moldova</option>
                                    <option value="Monaco">Monaco</option>
                                    <option value="Mongolia">Mongolia</option>
                                    <option value="Montserrat">Montserrat</option>
                                    <option value="Morocco">Morocco</option>
                                    <option value="Mozambique">Mozambique</option>
                                    <option value="Myanmar">Myanmar</option>
                                    <option value="Nambia">Nambia</option>
                                    <option value="Nauru">Nauru</option>
                                    <option value="Nepal">Nepal</option>
                                    <option value="Netherland Antilles">Netherland Antilles</option>
                                    <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                    <option value="Nevis">Nevis</option>
                                    <option value="New Caledonia">New Caledonia</option>
                                    <option value="New Zealand">New Zealand</option>
                                    <option value="Nicaragua">Nicaragua</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="Niue">Niue</option>
                                    <option value="Norfolk Island">Norfolk Island</option>
                                    <option value="Norway">Norway</option>
                                    <option value="Oman">Oman</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Palau Island">Palau Island</option>
                                    <option value="Palestine">Palestine</option>
                                    <option value="Panama">Panama</option>
                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                    <option value="Paraguay">Paraguay</option>
                                    <option value="Peru">Peru</option>
                                    <option value="Phillipines">Philippines</option>
                                    <option value="Pitcairn Island">Pitcairn Island</option>
                                    <option value="Poland">Poland</option>
                                    <option value="Portugal">Portugal</option>
                                    <option value="Puerto Rico">Puerto Rico</option>
                                    <option value="Qatar">Qatar</option>
                                    <option value="Republic of Montenegro">Republic of Montenegro</option>
                                    <option value="Republic of Serbia">Republic of Serbia</option>
                                    <option value="Reunion">Reunion</option>
                                    <option value="Romania">Romania</option>
                                    <option value="Russia">Russia</option>
                                    <option value="Rwanda">Rwanda</option>
                                    <option value="St Barthelemy">St Barthelemy</option>
                                    <option value="St Eustatius">St Eustatius</option>
                                    <option value="St Helena">St Helena</option>
                                    <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                    <option value="St Lucia">St Lucia</option>
                                    <option value="St Maarten">St Maarten</option>
                                    <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                    <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                    <option value="Saipan">Saipan</option>
                                    <option value="Samoa">Samoa</option>
                                    <option value="Samoa American">Samoa American</option>
                                    <option value="San Marino">San Marino</option>
                                    <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="Senegal">Senegal</option>
                                    <option value="Seychelles">Seychelles</option>
                                    <option value="Sierra Leone">Sierra Leone</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Slovakia">Slovakia</option>
                                    <option value="Slovenia">Slovenia</option>
                                    <option value="Solomon Islands">Solomon Islands</option>
                                    <option value="Somalia">Somalia</option>
                                    <option value="South Africa">South Africa</option>
                                    <option value="Spain">Spain</option>
                                    <option value="Sri Lanka">Sri Lanka</option>
                                    <option value="Sudan">Sudan</option>
                                    <option value="Suriname">Suriname</option>
                                    <option value="Swaziland">Swaziland</option>
                                    <option value="Sweden">Sweden</option>
                                    <option value="Switzerland">Switzerland</option>
                                    <option value="Syria">Syria</option>
                                    <option value="Tahiti">Tahiti</option>
                                    <option value="Taiwan">Taiwan</option>
                                    <option value="Tajikistan">Tajikistan</option>
                                    <option value="Tanzania">Tanzania</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Togo">Togo</option>
                                    <option value="Tokelau">Tokelau</option>
                                    <option value="Tonga">Tonga</option>
                                    <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                                    <option value="Tunisia">Tunisia</option>
                                    <option value="Turkey">Turkey</option>
                                    <option value="Turkmenistan">Turkmenistan</option>
                                    <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                                    <option value="Tuvalu">Tuvalu</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="Ukraine">Ukraine</option>
                                    <option value="United Arab Erimates">United Arab Emirates</option>
                                    <option value="United States">United States</option>
                                    <option value="Uraguay">Uruguay</option>
                                    <option value="Uzbekistan">Uzbekistan</option>
                                    <option value="Vanuatu">Vanuatu</option>
                                    <option value="Vatican City State">Vatican City State</option>
                                    <option value="Venezuela">Venezuela</option>
                                    <option value="Vietnam">Vietnam</option>
                                    <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                    <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                    <option value="Wake Island">Wake Island</option>
                                    <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                                    <option value="Yemen">Yemen</option>
                                    <option value="Zaire">Zaire</option>
                                    <option value="Zambia">Zambia</option>
                                    <option value="Zimbabwe">Zimbabwe</option>
                                </select>

                            </td>
                        </tr>


                        <tr>
                            <td><p class="gr-text-6 font-weight-bold mb-9">1.0 Personal/Business</p></td>
                            <td><p class="gr-text-6 font-weight-bold mb-9">Fixed</p></td>
                            <td><p class="gr-text-6 font-weight-bold mb-9">Variable</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Add Money To Wallet</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->user_add_money_fixed }}</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['pricing']->user_add_money_variable }}%</p></td>
                        </tr>
                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Send Money: (Both PS User & Non-PS User)</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-Local</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['pricing']->user_send_money_local }}</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-International (for Currency Conversion)</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['pricing']->user_send_money_international }}</p></td>
                        </tr>


                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Receive Money: (Both PS User & Non-PS User)</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-Local</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['pricing']->user_receive_money_local }}</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-International</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['pricing']->user_receive_money_international }}</p></td>
                        </tr>


                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Pay Invoice (Both PS User & Non-PS User)</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-Local</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['pricing']->user_pay_invoice_local }}</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-International</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['pricing']->user_pay_invoice_international }}</p></td>
                        </tr>


                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Request for Refund to Wallet</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-Local</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['pricing']->user_refund_money_local }}</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-International</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['pricing']->user_refund_money_international }}</p></td>
                        </tr>

                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Request for Withdrawal</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">To Prepaid Card</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->user_prepaid_withdrawal_fixed }}</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['pricing']->user_prepaid_withdrawal_variable }}%</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">To Credit Card</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->user_credit_withdrawal_fixed }}</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['pricing']->user_credit_withdrawal_variable }}%</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">To Bank Account</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->user_bank_withdrawal_fixed }}</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['pricing']->user_bank_withdrawal_variable }}%</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">To Debit VISA/Mastercard</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->user_debit_withdrawal_fixed }}</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['pricing']->user_debit_withdrawal_variable }}%</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Monthly Maintenance Fee</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->maintenance_fee }}</p></td>
                        </tr>

                        <tr>
                            <td><p class="gr-text-9 mb-0">Minimum Wallet Balance</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->minimum_wallet_balance }}</p></td>
                        </tr>


                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">WITHDRAWAL LIMITS</p></td>
                        </tr>

                        <tr>
                            <td><p class="gr-text-9 mb-0">FREQUENCY</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">MAXIMUM (Up to)</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Per Transaction</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->withdrawal_per_transaction }}</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Per Day</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->withdrawal_per_day }}</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Per Week</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->withdrawal_per_week }}</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Per Month</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->withdrawal_per_month }}</p></td>
                        </tr>
                        
                    </tbody>
                </table>

                <hr>

                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td><p class="gr-text-6 font-weight-bold mb-9">2.0 Merchant (including Charity)</p></td>
                            <td><p class="gr-text-6 font-weight-bold mb-9">Fixed</p></td>
                            <td><p class="gr-text-6 font-weight-bold mb-9">Variable</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Add Money To Wallet</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->user_add_money_fixed }}</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['pricing']->user_add_money_variable }}%</p></td>
                        </tr>
                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Send Money: (Both PS User & Non-PS User)</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-Local</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['pricing']->user_send_money_local }}</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-International (for Currency Conversion)</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['pricing']->user_send_money_international }}</p></td>
                        </tr>

                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Accept Payments from PS Users</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-Local</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['pricing']->user_receive_money_local }}</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-International</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['pricing']->user_receive_money_international }}</p></td>
                        </tr>


                        


                        

                        

                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Accept Payments from Non-PS Users</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">To Prepaid Card</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">Subject to Card Issuer</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">To Credit Card</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->user_credit_withdrawal_fixed }}</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['pricing']->user_credit_withdrawal_variable }}%</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">To Bank Account</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->user_bank_withdrawal_fixed }}</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['pricing']->user_bank_withdrawal_variable }}%</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">To Debit VISA/Mastercard</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->user_debit_withdrawal_fixed }}</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['pricing']->user_debit_withdrawal_variable }}%</p></td>
                        </tr>


                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Request for Refund to Wallet</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-Local</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['pricing']->user_refund_money_local }}</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-International</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['pricing']->user_refund_money_international }}</p></td>
                        </tr>

                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Request for Withdrawal</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Into Prepaid Card</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">Subject to Card Issuer</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Into Credit Card</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->user_credit_withdrawal_fixed }}</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['pricing']->user_credit_withdrawal_variable }}%</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Into Bank Account</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->user_bank_withdrawal_fixed }}</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['pricing']->user_bank_withdrawal_variable }}%</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Into Debit VISA/Mastercard</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->user_debit_withdrawal_fixed }}</p></td>
                            <td><p class="gr-text-9 mb-0">{{ $data['pricing']->user_debit_withdrawal_variable }}%</p></td>
                        </tr>


                        <tr>
                            <td><p class="gr-text-9 mb-0">Monthly Maintenance Fee</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->maintenance_fee }}</p></td>
                        </tr>

                        <tr>
                            <td><p class="gr-text-9 mb-0">Minimum Wallet Balance</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->minimum_wallet_balance }}</p></td>
                        </tr>


                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">WITHDRAWAL LIMITS</p></td>
                        </tr>

                        <tr>
                            <td><p class="gr-text-9 mb-0">FREQUENCY</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">MAXIMUM (Up to)</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Per Transaction</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->merchant_withdrawal_per_transaction }}</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Per Day</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->merchant_withdrawal_per_day }}</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Per Week</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->merchant_withdrawal_per_week }}</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Per Month</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">{{ $data['currency'].$data['pricing']->merchant_withdrawal_per_month }}</p></td>
                        </tr>
                        
                    </tbody>
                </table>

            </div>
           
            
            
          </div>
        </div>
      </div>
    </div>
  @endsection
