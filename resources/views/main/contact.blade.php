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
                        <!-- <a href="#">email</a> -->
                    </div>
                    <div class="address">
                        <a href="#">PaySprint International<br>10 George St. North, <br> Brampton. ON. L6X1R2. Canada
                        </a>

                        <!-- @if ($data['continent'] != 'Africa')
                        <a href="#">info@paysprint.ca</a>
                        @else
                        <a href="#">customerserviceafrica@paysprint.ca</a>
                        @endif -->

                    </div>
                </div>
            </div>
            <div class="col-sm-6 contact_info send_message">

                <h2 class='zcwf_title'>Send Us a Message</h2>


                <!-- Note :
                           - You can modify the font style and form style to suit your website.
                           - Code lines with comments Do not remove this code are required for the form to work properly, make sure that you do not remove these lines of code.
                           - The Mandatory check script can modified as to suit your business needs.
                           - It is important that you test the modified form before going live.
                           - Do not remove captcha and other form elements that are necessary for the form to work.  -->
                <div id='crmWebToEntityForm' class='zcwf_lblLeft crmWebToEntityForm' style='background-color: white;color: black;max-width: 600px;'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <META HTTP-EQUIV='content-type' CONTENT='text/html;charset=UTF-8'>
                    <form action='https://crm.zoho.com/crm/WebToLeadForm' name=WebToLeads3264094000003951005 method='POST' onSubmit='javascript:document.charset="UTF-8"; return checkMandatory3264094000003951005()' accept-charset='UTF-8'>
                        <input type='text' style='display:none;' name='xnQsjsdp' value='e8a3ad69df258ca810f448198a40c5f49ec7b96fc72f3f356f1e05ba5c8270ce'></input>
                        <input type='hidden' name='zc_gad' id='zc_gad' value=''></input>
                        <input type='text' style='display:none;' name='xmIwtLD' value='b7676fb486c62b9e48e985479454d494e8f5b69c5eb1610f2599f52edfa654f5'></input>
                        <input type='text' style='display:none;' name='actionType' value='TGVhZHM='></input>
                        <input type='text' style='display:none;' name='returnURL' value='https&#x3a;&#x2f;&#x2f;paysprint.ca'> </input>
                        <!-- Do not remove this code. -->
                        <input type='text' style='display:none;' id='ldeskuid' name='ldeskuid'></input>
                        <input type='text' style='display:none;' id='LDTuvid' name='LDTuvid'></input>
                        <!-- Do not remove this code. -->
                        <style>
                            html,
                            body {
                                margin: 0px;
                            }

                            #crmWebToEntityForm.zcwf_lblLeft {
                                width: 100%;
                                padding: 25px;
                                margin: 0 auto;
                                box-sizing: border-box;
                            }

                            #crmWebToEntityForm.zcwf_lblLeft * {
                                box-sizing: border-box;
                            }

                            #crmWebToEntityForm {
                                text-align: left;
                            }

                            #crmWebToEntityForm * {
                                direction: ltr;
                            }

                            .zcwf_lblLeft .zcwf_title {
                                word-wrap: break-word;
                                padding: 0px 6px 10px;
                                font-weight: bold;
                            }

                            .zcwf_lblLeft .zcwf_col_fld input[type=text],
                            .zcwf_lblLeft .zcwf_col_fld textarea {
                                width: 60%;
                                border: 1px solid #ccc !important;
                                resize: vertical;
                                border-radius: 2px;
                                float: left;
                            }

                            .zcwf_lblLeft .zcwf_col_lab {
                                width: 30%;
                                word-break: break-word;
                                padding: 0px 6px 0px;
                                margin-right: 10px;
                                margin-top: 5px;
                                float: left;
                                min-height: 1px;
                            }

                            .zcwf_lblLeft .zcwf_col_fld {
                                float: left;
                                width: 68%;
                                padding: 0px 6px 0px;
                                position: relative;
                                margin-top: 5px;
                            }

                            .zcwf_lblLeft .zcwf_privacy {
                                padding: 6px;
                            }

                            .zcwf_lblLeft .wfrm_fld_dpNn {
                                display: none;
                            }

                            .dIB {
                                display: inline-block;
                            }

                            .zcwf_lblLeft .zcwf_col_fld_slt {
                                width: 60%;
                                border: 1px solid #ccc;
                                background: #fff;
                                border-radius: 4px;
                                font-size: 12px;
                                float: left;
                                resize: vertical;
                            }

                            .zcwf_lblLeft .zcwf_row:after,
                            .zcwf_lblLeft .zcwf_col_fld:after {
                                content: '';
                                display: table;
                                clear: both;
                            }

                            .zcwf_lblLeft .zcwf_col_help {
                                float: left;
                                margin-left: 7px;
                                font-size: 12px;
                                max-width: 35%;
                                word-break: break-word;
                            }

                            .zcwf_lblLeft .zcwf_help_icon {
                                cursor: pointer;
                                width: 16px;
                                height: 16px;
                                display: inline-block;
                                background: #fff;
                                border: 1px solid #ccc;
                                color: #ccc;
                                text-align: center;
                                font-size: 11px;
                                line-height: 16px;
                                font-weight: bold;
                                border-radius: 50%;
                            }

                            .zcwf_lblLeft .zcwf_row {
                                margin: 15px 0px;
                            }

                            .zcwf_lblLeft .formsubmit {
                                margin-right: 5px;
                                cursor: pointer;
                                color: #333;
                                font-size: 12px;
                            }

                            .zcwf_lblLeft .zcwf_privacy_txt {
                                width: 90%;
                                color: rgb(0, 0, 0);
                                font-size: 12px;
                                font-family: Arial;
                                display: inline-block;
                                vertical-align: top;
                                color: #333;
                                padding-top: 2px;
                                margin-left: 6px;
                            }

                            .zcwf_lblLeft .zcwf_button {
                                font-size: 12px;
                                color: #333;
                                border: 1px solid #ccc;
                                padding: 3px 9px;
                                border-radius: 4px;
                                cursor: pointer;
                                max-width: 120px;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;
                            }

                            .zcwf_lblLeft .zcwf_tooltip_over {
                                position: relative;
                            }

                            .zcwf_lblLeft .zcwf_tooltip_ctn {
                                position: absolute;
                                background: #dedede;
                                padding: 3px 6px;
                                top: 3px;
                                border-radius: 4px;
                                word-break: break-all;
                                min-width: 50px;
                                max-width: 150px;
                                color: #333;
                            }

                            .zcwf_lblLeft .zcwf_ckbox {
                                float: left;
                            }

                            .zcwf_lblLeft .zcwf_file {
                                width: 55%;
                                box-sizing: border-box;
                                float: left;
                            }

                            .clearB:after {
                                content: '';
                                display: block;
                                clear: both;
                            }

                            @media all and (max-width: 600px) {

                                .zcwf_lblLeft .zcwf_col_lab,
                                .zcwf_lblLeft .zcwf_col_fld {
                                    width: auto;
                                    float: none !important;
                                }

                                .zcwf_lblLeft .zcwf_col_help {
                                    width: 40%;
                                }
                            }
                        </style>
                        <div class='zcwf_row'>
                            <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Last_Name'>Last Name<span style='color:red;'>*</span></label></div>
                            <div class='zcwf_col_fld'><input type='text' id='Last_Name' name='Last Name' maxlength='80' class='form-control'></input>
                                <div class='zcwf_col_help'></div>
                            </div>
                        </div>
                        <div class='zcwf_row'>
                            <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='First_Name'>First Name<span style='color:red;'>*</span></label></div>
                            <div class='zcwf_col_fld'><input type='text' id='First_Name' name='First Name' maxlength='40' class='form-control'></input>
                                <div class='zcwf_col_help'></div>
                            </div>
                        </div>
                        <div class='zcwf_row'>
                            <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Email'>Email<span style='color:red;'>*</span></label></div>
                            <div class='zcwf_col_fld'><input type='text' ftype='email' id='Email' name='Email' maxlength='100' class='form-control'></input>
                                <div class='zcwf_col_help'></div>
                            </div>
                        </div>
                        <div class='zcwf_row'>
                            <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Phone'>Phone<span style='color:red;'>*</span></label></div>
                            <div class='zcwf_col_fld'><input type='text' id='Phone' name='Phone' maxlength='30' class='form-control'></input>
                                <div class='zcwf_col_help'></div>
                            </div>
                        </div>
                        <div class='zcwf_row'>
                            <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Company'>Company</label></div>
                            <div class='zcwf_col_fld'><input type='text' id='Company' name='Company' maxlength='200' class='form-control'></input>
                                <div class='zcwf_col_help'></div>
                            </div>
                        </div>
                        <div class="zcwf_row">
                            <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Company'>Subject<span style='color:red;'>*</span></label>
                            </div>
                            <div class='zcwf_col_fld'>
                                <select class='form-control' name='subject' required>
                                    <option name="idv">Identity Verification</option>
                                    <option name="">Technical Support</option>
                                    <option></option>
                                </select>
                                <div class='zcwf_col_help'></div>
                            </div>

                        </div>
                        <div class='zcwf_row'>
                            <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Description'>Description<span style='color:red;'>*</span></label></div>
                            <div class='zcwf_col_fld'>
                                <textarea id='Description' name='Description' class='form-control'></textarea>
                                <div class='zcwf_col_help'></div>
                            </div>
                        </div>

                        <div class='zcwf_row'>
                            <div class='zcwf_col_lab'></div>
                            <div class='zcwf_col_fld'><img id='imgid3264094000003951005' src='https://crm.zoho.com/crm/CaptchaServlet?formId=b7676fb486c62b9e48e985479454d494e8f5b69c5eb1610f2599f52edfa654f5&grpid=e8a3ad69df258ca810f448198a40c5f49ec7b96fc72f3f356f1e05ba5c8270ce'>
                                <a href='javascript:;' onclick='reloadImg3264094000003951005();'>Reload</a>
                            </div>
                            <div class=''></div>
                        </div>
                        <div class='zcwf_row'>
                            <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'>Enter the Captcha
                            </div>
                            <div class='zcwf_col_fld'><input type='text' maxlength='10' name='enterdigest' class='form-control' /></div>


                        </div>
                        <!-- Do not remove this code. -->



                        <div class='zcwf_row'>
                            <div class='zcwf_col_lab'></div>
                            <div class='zcwf_col_fld'><input type='submit' id='formsubmit' class='formsubmit zcwf_button' value='Submit' title='Submit'><input type='reset' class='zcwf_button' name='reset' value='Reset' title='Reset'></div>
                        </div>
                        <script>
                            /* Do not remove this code. */
                            function reloadImg3264094000003951005() {
                                var captcha = document.getElementById('imgid3264094000003951005');
                                if (captcha.src.indexOf('&d') !== -1) {
                                    captcha.src = captcha.src.substring(0, captcha.src.indexOf('&d')) + '&d' + new Date().getTime();
                                } else {
                                    captcha.src = captcha.src + '&d' + new Date().getTime();
                                }
                            }

                            function validateEmail3264094000003951005() {
                                var form = document.forms['WebToLeads3264094000003951005'];
                                var emailFld = form.querySelectorAll('[ftype=email]');
                                var i;
                                for (i = 0; i < emailFld.length; i++) {
                                    var emailVal = emailFld[i].value;
                                    if ((emailVal.replace(/^\s+|\s+$/g, '')).length != 0) {
                                        var atpos = emailVal.indexOf('@');
                                        var dotpos = emailVal.lastIndexOf('.');
                                        if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= emailVal.length) {
                                            alert('Please enter a valid email address. ');
                                            emailFld[i].focus();
                                            return false;
                                        }
                                    }
                                }
                                return true;
                            }

                            function checkMandatory3264094000003951005() {
                                var mndFileds = new Array('First Name', 'Last Name', 'Email', 'Phone', 'Description');
                                var fldLangVal = new Array('First\x20Name', 'Last\x20Name', 'Email', 'Phone', 'Description');
                                for (i = 0; i < mndFileds.length; i++) {
                                    var fieldObj = document.forms['WebToLeads3264094000003951005'][mndFileds[i]];
                                    if (fieldObj) {
                                        if (((fieldObj.value).replace(/^\s+|\s+$/g, '')).length == 0) {
                                            if (fieldObj.type == 'file') {
                                                alert('Please select a file to upload.');
                                                fieldObj.focus();
                                                return false;
                                            }
                                            alert(fldLangVal[i] + ' cannot be empty.');
                                            fieldObj.focus();
                                            return false;
                                        } else if (fieldObj.nodeName == 'SELECT') {
                                            if (fieldObj.options[fieldObj.selectedIndex].value == '-None-') {
                                                alert(fldLangVal[i] + ' cannot be none.');
                                                fieldObj.focus();
                                                return false;
                                            }
                                        } else if (fieldObj.type == 'checkbox') {
                                            if (fieldObj.checked == false) {
                                                alert('Please accept  ' + fldLangVal[i]);
                                                fieldObj.focus();
                                                return false;
                                            }
                                        }
                                        try {
                                            if (fieldObj.name == 'Last Name') {
                                                name = fieldObj.value;
                                            }
                                        } catch (e) {}
                                    }
                                }
                                trackVisitor3264094000003951005();
                                if (!validateEmail3264094000003951005()) {
                                    return false;
                                }
                                document.querySelector('.crmWebToEntityForm .formsubmit').setAttribute('disabled', true);
                            }

                            function tooltipShow3264094000003951005(el) {
                                var tooltip = el.nextElementSibling;
                                var tooltipDisplay = tooltip.style.display;
                                if (tooltipDisplay == 'none') {
                                    var allTooltip = document.getElementsByClassName('zcwf_tooltip_over');
                                    for (i = 0; i < allTooltip.length; i++) {
                                        allTooltip[i].style.display = 'none';
                                    }
                                    tooltip.style.display = 'block';
                                } else {
                                    tooltip.style.display = 'none';
                                }
                            }
                        </script>
                        <script type='text/javascript' id='VisitorTracking'>
                            var $zoho = $zoho || {};
                            $zoho.salesiq = $zoho.salesiq || {
                                widgetcode: 'a7ffa31136f6ab021392ea01a2816af0033ebbc69fda5e9fa38407829c8ee302',
                                values: {},
                                ready: function() {}
                            };
                            var d = document;
                            s = d.createElement('script');
                            s.type = 'text/javascript';
                            s.id = 'zsiqscript';
                            s.defer = true;
                            s.src = 'https://salesiq.zoho.com/widget';
                            t = d.getElementsByTagName('script')[0];
                            t.parentNode.insertBefore(s, t);

                            function trackVisitor3264094000003951005() {
                                try {
                                    if ($zoho) {
                                        var LDTuvidObj = document.forms['WebToLeads3264094000003951005']['LDTuvid'];
                                        if (LDTuvidObj) {
                                            LDTuvidObj.value = $zoho.salesiq.visitor.uniqueid();
                                        }
                                        var firstnameObj = document.forms['WebToLeads3264094000003951005']['First Name'];
                                        if (firstnameObj) {
                                            name = firstnameObj.value + ' ' + name;
                                        }
                                        $zoho.salesiq.visitor.name(name);
                                        var emailObj = document.forms['WebToLeads3264094000003951005']['Email'];
                                        if (emailObj) {
                                            email = emailObj.value;
                                            $zoho.salesiq.visitor.email(email);
                                        }
                                    }
                                } catch (e) {}
                            }
                        </script>
                    </form>
                    <!-- Do not remove this code. -->
                    <iframe name='captchaFrame' style='display:none;'></iframe>
                </div>




                <form class="form-inline contact_box disp-0">
                    <label for="name"><span style="color: red !important; display: inline; float: none;">*</span>
                        Name</label>
                    <input id="name" type="text" class="form-control input_box" @if ($name !='' ) value="{{ $name }}" readonly @else placeholder="Name *" @endif>
                    <label for="email"><span style="color: red !important; display: inline; float: none;">*</span>
                        Email</label>
                    <input id="email" type="text" class="form-control input_box" @if ($email !='' ) value="{{ $email }}" readonly @else placeholder="Your Email *" @endif>
                    <label for="subject">Subject</label>
                    <input id="subject" type="text" class="form-control input_box" placeholder="Subject">
                    <label for="website"><span style="color: red !important; display: inline; float: none;">*</span>
                        Website</label>
                    <input id="website" type="text" class="form-control input_box" placeholder="Your Website">
                    <label for="country"><span style="color: red !important; display: inline; float: none;">*</span>
                        Country</label>

                    <select id="country" name="country" class="form-control input_box">
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
                        <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The
                        </option>
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
                        <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
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
                        <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of
                        </option>
                        <option value="Korea, Republic of">Korea, Republic of</option>
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
                        <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav
                            Republic of</option>
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
                        <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
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
                        <option value="South Georgia and The South Sandwich Islands">South Georgia and The South
                            Sandwich Islands</option>
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
                        <option value="United States Minor Outlying Islands">United States Minor Outlying Islands
                        </option>
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
                    <label for="message"><span style="color: red !important; display: inline; float: none;">*</span>
                        Message</label>
                    <textarea id="message" class="form-control input_box" placeholder="Message"></textarea>

                    {!! htmlFormSnippet() !!}
                    <br>
                    <button type="button" class="btn btn-default" onclick="contactUs()" id="contactBtn">Send
                        Message</button>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- End All contact Info -->
@endsection