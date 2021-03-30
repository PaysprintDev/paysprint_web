@extends('layouts.app')

@section('content')

    <!-- Banner area -->
    <section class="banner_area" data-stellar-background-ratio="0.5">
        <h2>{{ $pages }}</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('terms of use') }}" class="active">{{ $pages }}</a></li>
        </ol>
    </section>
    <!-- End Banner area -->

    <!-- About Us Area -->
    <section class="about_us_area about_us_2 row">
        <div class="container">
            <div class="row about_row about_us2_pages">
                <div class="who_we_area col-md-8">
                    <div class="subtittle">
                        <h2>1. INTRODUCTION</h2>
                    </div>
                    <p>Thank you for using the services of PaySprint (PS). We build PS Services for individuals and merchant in order to improve the rate of meeting financial obligations and engagement.

                        <br>
                        <br>

                        These Terms of Service set out the terms that apply to your use of our Website, Mobile and Services in general. We may change these terms from time to time. If we do, we shall post a revision of these Terms at <strong><a href="{{ route('terms of use') }}">https://paysprint.net/terms-of-service</a></strong> and your continued use of Services shall be subject to such revised terms.

                        <br>
                        <br>

                        These Terms of Service apply between you and the PaySprint (PS) by Express Ca Corp (as defined) located at 10 George St. North, Brampton. ON. L6X1R2 <strong>(‘PS’, ‘EXBC, ‘Express Ca Corp’, 'we’, ‘us’, ‘our’)</strong>.

                    </p>


                    <div class="subtittle">
                        <h2>2. OUR SERVICES</h2>
                    </div>
                    <p>Our Service include:

                        <br>
                        <br>

                        Sending and receiving money, paying invoice and Payment Processing Platform including Text to Transfer, Text to Pay and QR functionality.

                        <br>
                        <br>

                        We reserve the right to upgrade, maintain, tune, backup, amend, add to or remove items from, redesign, improve or otherwise alter our Services at our sole and absolute discretion. You agree with your use of any PS Service, that PS will be the exclusive provider of payment processing services to you and that you will utilize one or more of the PS giving services along with putting the PS API button on your website.

                    </p>
                    <div class="subtittle">
                        <h2>3. GENERAL TERMS</h2>
                    </div>
                    <p>Our Service include:

                        <br>
                        <br>

                        <strong>3.1 Your Account and Information Provided</strong>
                        

                        <br>
                        <br>
                        You may be required to create an Account and specify a password in order to use the Services or certain features included in the Services.

                        <br>
                        <br>

                        By creating an Account, or using our Services, you represent and warrant that:

                        <ul>
                            <li>
                               You have full authority to create the Account (including on behalf of any Merchant).
                            </li>
                            <li>
                               You will provide all information necessary to establish and maintain an Account for use of our Services, including background verification information.
                            </li>
                        </ul>

                        All information you provide, including all information concerning your name, address, credit card number, bank account details, information required for background checks and other identifying information of any nature is true, complete and accurate; and

                        <br>
                        <br>

                        You will maintain the accuracy of all information provided to us.

                        <br><br>
                        Customers who use payment processing services are required to provide all information necessary to enable us to verify your identity and ownership of bank accounts, including:

                        <br>
                        <br>

                        Personal information (full legal name, resident address, date of birth, and Social Security Number (or other government ID, if not a U.S. citizen)) for your beneficial ownership; and Information about your bank account(s) that may be used for payment processing including deposit of processed funds, for anti-money laundering laws, other applicable laws and internal procedures relating to “Know Your Client” and credit worthiness background checks. 

                        <br>
                        <br>

                        You authorize PS to store the payment credentials for future scheduled or unscheduled transactions.

                        <br>
                        <br>

                        You must promptly advise us in advance of any changes to the information provided including your contact details, operations, banking relationships, or other information that would require a change in the support, operation, or configuration of the Services(s). This may be done via your Account or in accordance with the Notification Policy below.

                        <br>
                        <br>
                        You must not share your Account with anyone else. PS has no liability for any unauthorized action or loss resulting from or relating to shared Account details.

                        <br>
                        <br>

                        <strong>3.2 Term/Termination Policy</strong>

                        <br>
                        <br>
                        The Services are provided on a month-to-month basis unless otherwise agreed in writing.

                        <br>
                        <br>
                        Either you or PS may terminate the Services at any time upon 30 days’ prior written notice to the other party, delivered in accordance with the Notification Policy.

                        <br>
                        <br>

                        PS also reserves the right to:

                        <ul>
                            <li>limit or suspend your access to the Services; and/or</li>
                            <li>terminate the Terms of Services or other agreement with you; and/or</li>
                            <li>cancel your account; and/or</li>
                            <li>remove Customer Content uploaded to the Services,</li>
                        </ul>

                        <br>
                        <br>
                        with immediate effect, if in our reasonable opinion you are in breach of any of the obligations or undertakings in these Terms of Service.

                        <br>
                        <br>

                        You will remain liable for all obligations related to your Account even after it is closed. In particular, you will be responsible for any and all chargebacks, refunds, and any other fees associated with payment processing services following termination.

                        <br>
                        <br>

                        Please note that merely deleting a PS application will not close your account, cancel a recurring payment or delete a linked account (for example, a linked Customer account).

                        <br>
                        <br>

                        You are responsible for downloading and transferring any Customer Content you wish to retain or re-use or deleting that Customer Content from your Account. This must be done before termination.

                        <br>
                        <br>

                        You acknowledge that in the event of account termination or service cancellation, any PS provided telephone numbers associated with your Account shall remain with PS or may be released. You acknowledge that You are solely responsible for working with a third-party provider to establish any new numbers in connection with the termination or service cancellation of your Account and for notifying any third parties of your change in number.

                        <br>
                        <br>


                        <strong>3.3 Notification Policy</strong>

                        <br>
                        <br>

                        PS NOTIFICATION: For requests for change of Services under this Agreement, including cancellations, or to provide notice of other changes impacting your Account please use your Customer Account login or Merchant Administrator login to communicate directly to PS, or send an email to your account manager and copy support@paysprint.net.

                        <br>
                        <br>

                        CUSTOMER NOTIFICATION: For service change notifications, we will communicate via your login area and/or directly to your Customer or Merchant Administrator email address or the phone number as provided to us.  

                        <br>
                        <br>

                        <strong>3.4 Pricing, Payments and Renewals Policy</strong>

                        <br>
                        <br>

                        By using the Services, you agree to pay all relevant Service Fees.

                        <br>
                        <br>

                        Service Fees payable for use of any Services are as described on the Website (unless otherwise agreed in writing) and may be updated from time to time. All pricing is specified on a monthly basis or per transactions and in CAD Dollars (unless otherwise specified).

                        <br>
                        <br>

                        Services will automatically renew at the end of each subscription period, unless you cancel the Services through your Account before the end of the current subscription period.

                        <br>
                        <br>

                        You agree to pay all Service Fees and any other charges incurred by you or any users of your Account and your credit card (or other applicable payment mechanism) at the price(s) in effect when such charges are incurred on or before the due date.

                        <br>
                        <br>

                        You agree that you will only use credit cards belonging to you or for which you are expressly authorized to use.

                        <br>
                        <br>

                        <strong>3.5 Payments Processing Services Policy</strong>

                        <br>
                        <br>
                        PS allows Customers to accept payments via credit card, debit card, and ACH transactions including processing cards bearing the trademarks of Visa®, MasterCard®, Discover®, and American Express® (collectively, the “Networks”). PS is not a depositary institution and does not offer banking services or Money Service Business services as defined by the United States Department of Treasury. PS must enter into agreements with Networks, other processors, and banks. These third parties require our Customers to accept Sub-Merchant Agreement terms as described below.

                        <br>
                        <br>

                        Sub-Merchant Agreements: Customers who use payment processing services accept the relevant Sub-Merchant Agreements as determined by PS. Payment processing services for PS are currently provided by Moneris and are subject to the Moneris Connected Account Agreement, which includes the Moneris Terms of Service (collectively, the “Moneris Services Agreement”). By agreeing to these Terms of Service, you agree to be bound by the Moneris Services Agreement, as the same may be modified by Moneris from time to time. You also authorize us to share with Moneris any information you provide to us and transaction information related to your use of the Services provided by Moneris.

                        <br>
                        <br>

                        Service/Processing Fees: Service Fees shall apply to all financial transactions conducted through the use of PS (including credit card, debit card, and ACH transactions) as further described on the Website or as otherwise agreed in writing.  

                        <br>
                        <br>

                        Deposit of Funds received through PS: Monies received are automatically deposited into the PS wallet as default method and the user (Individual or Merchant) can withdraw the funds to any of the registered account (including credit card, debit card and or ACH Transactions) at prescribed fees.

                        <br>
                        <br>

                        Withdrawal of Funds from PS Wallet. User will withdraw funds from PS wallet, interest free, less any refunds, chargebacks, and any applicable fees (including PS Service/Processing Fees and/or transaction fees related to the Services, if applicable), as follows:

                        <br>
                        <br>

                        Wallet balance may be withdrawing at any time less all applicable charges. 

                        <br>
                        <br>

                        Funds will be remitted to the designated beneficiary by bank transfer, less the Service Fee and any other amounts deductible pursuant to these Terms of Service.

                        <br>
                        <br>

                        Funds may be held in escrow pending any outstanding information requested, which maybe necessary to vet each Merchant according to current legal, regulatory and compliance requirements. We may suspend or delay disbursements to you in order to protect PS against the risk of, among other things, existing, potential or anticipated chargebacks, fraud or your failure to fulfill Your responsibilities set forth in these Terms.

                        <br>
                        <br>

                        Proceeds (net of any Fees and other deductibles) will be available for distribution to the beneficiary by bank transfer typically within 1-2 banking days of transaction for credit/debit cards and up to 1-week for ACH transactions.  

                        <br>
                        <br>

                        PS has no liability for disbursements made in accordance with the above provisions.

                        <br>
                        <br>

                        Chargebacks: You agree that PS has the right to debit your PS wallet or bank/credit card account at any time to recover any negative balances that PS may incur, for example, as a result of refunds, chargebacks or disputed payments.  If PS is unable to collect on refunds/chargebacks using offset of your disbursement or debit of your bank account, PS has the right to invoice you for any unpaid balance.

                        <br>
                        <br>

                        Unauthorized payments and Errors:  If an Error (as defined) occurs that is solely our fault, we will use all reasonable efforts to remedy that Error (subject to the limitations provided in Clause 5). You must notify us immediately if you think there may be an Error or if you need more information about an Error at: <strong><a href="mailto:support@paysprint.net">support@paysprint.net</a></strong>.

                        <br>
                        <br>

                        <ul>
                            <li>Although we will use all reasonable efforts to assist, you are solely responsible for any transactions made or damage or loss incurred in the following circumstances (none of which comprise an Error):</li>
                            <li>If you make a mistake in making a transaction (for example, mistyping an amount you are sending).</li>
                            <li>If you give a third-party access to your Account (intentionally or otherwise) and they use your Account without your knowledge or permission.</li>
                            <li>Lost or stolen account credentials, or other use of your credentials without your permission by a third-party, before you notify us of that compromise.</li>
                            <li>The invalidation or reversal of a payment as a result of refunds, reversals or chargebacks.</li>
                            <li>Delays resulting from PS applying holds, limits or reviews or relating to the time to may take for a transaction to be completed.</li>
                        </ul>

                        <br>
                        <br>

                        In case of suspected unauthorized activity in relation to your Account, or questions about payments made or received, contact us as soon as you can at: <strong><a href="mailto:support@paysprint.net">support@paysprint.net</a></strong>

                        <br>
                        <br>

                        <strong>3.6 Acceptable Use Policy</strong>

                        <br>
                        <br>

                        You will abide by, and utilize the Services only in accordance with, our Acceptable Use Policy, as pushed from time to time.

                        <br>
                        <br>
                        Customers are responsible for ensuring that Merchant Administrators and Authorized Users and any other Users of the Services also comply with Acceptable Use Policy.

                        <br>
                        <br>

                        <strong>3.7 Intellectual Property Rights</strong>

                        <br>
                        <br>
                        Reservation of Rights. Subject to the limited rights expressly granted here under, PS reserves all rights, title and interest in and to the Services and content, including all related intellectual property rights. No rights are granted to you here under other than as expressly set forth here in.  

                        <br>
                        <br>
                        Access to and Use of Content. Customers have the right to access and use applicable Content subject to this Agreement. None shall, directly or indirectly, reverse engineer, decompile, disassemble or otherwise attempt to derive source code or other trade secrets from PS, or use the Services or websites in a way that violates any laws, infringes on anyone’s rights, is offensive, or interferes with the Services or Websites. Any feedback, answers, questions, comments, suggestions, ideas or the like which you send to PS relating to the Services will be treated as being non-confidential and non-proprietary. PS may use, disclose or publish any ideas, concepts, know-how or techniques contained in such information for any purpose whatsoever.

                        <br>
                        <br>

                        License to PS. You grant to us a non-exclusive, royalty-free, worldwide right and license during the Term to do the following to the extent necessary in the performance of Services:

                        <br>
                        <br>

                        <ul>
                            <li>digitize, convert, install, upload, select, order, arrange, compile, combine, synchronize, use, reproduce, store, process, retrieve, transmit, distribute, publish, publicly display, publicly perform and hyperlink the Customer Content; and</li>
                            <li>make archival or back-up copies of the Customer Content and Customer websites.</li>
                            <li>Except for the rights expressly granted above, we not acquiring any right, title or interest in or to the Customer Content, all of which shall remain solely with Customer. </li>
                            
                        </ul>

                        <br>
                        <br>

                        Use of data: We reserve the right to use all data collected, processed or derived by us in relation to the Services, including de-identified Customer Content, for the purpose of industry trend and best practices reporting, statistical analysis and research and research relating to the development or improvement of any of our services or products. We will not publish or disclose statistical findings of individual Customer or Merchant activity.


                    </p>
                    <div class="subtittle">
                        <h2>4. CUSTOMER RESPONSIBILITIES</h2>
                    </div>
                    <p>

                        <strong>4.1 Responsibilities of Customers and Merchant Administrators</strong>
                        
                        <br>

                        <strong>4.1.1 Customer Responsibilities</strong>

                        <br>
                        <br>
                        Customers who use PS’s products and services must comply with the following:

                        <br>
                        <br>

                        You will administer and be responsible for access to the Services (including in particular granting rights to Merchant Administrator(s) or Authorized User(s)) Note: Any person with access to your Account or accessing the Account as Merchant Administrator(s) or Authorized User(s), may be able to alter settings including beneficiary bank details. You must exercise special care to properly manage that access, to prevent fraud or other unauthorized access or use.

                        <br>
                        <br>

                        You are responsible for ensuring that all Merchant Administrators and Authorized Users comply with these Terms of Service and our Privacy Policy. You further represent and warrant that you are responsible for your conduct as well as the conduct of Merchant Administrators and Authorized Users while using the Services.

                        <br>
                        <br>

                        You are responsible for the security of your Account. You must maintain and observe all reasonable security measures to protect your electronic systems from unauthorized control, tampering, or other unauthorized access.

                        <br><br>
                        You must keep all passwords confidential and ensure you comply with strong password requirements. You should not share or otherwise disclose your password to any third party. You are responsible for ensuring that Merchant Administrator(s) and Authorized User(s) also maintain the confidentiality of their passwords and meet strong password requirements.  

                        <br>
                        <br>

                        You will use Services only for your legitimate business purposes and will comply with all applicable laws, rules, and regulations including laws regarding privacy and protection of consumer data.

                        <br>
                        <br>

                        <strong>4.1.2 Merchant Administrator Responsibilities</strong>

                        <br>
                        <br>
                        Merchant Administrators who use the Services must comply with the following:

                        <br>
                        <br>
                        Delays resulting from PS applying holds, limits or reviews or relating to the time to may take for a transaction to be completed.


                        <br>
                        <br>
                        You will follow the instruction of the Customer and comply with all policies and practices of Customer and PS that are relevant to the use of the Services, including these Terms of Service.

                        <br>
                        <br>

                       You shall provide us with all necessary rights, permissions and/or consents necessary to grant us the rights and licenses in these Terms of Service, and all rights, permissions and/or consents necessary for the lawful use and transmission of personal information and data that is required for the use and operation of the Services.

                        <br>
                        <br>

                        You shall(a) ensure that Authorized Users understand and comply with all policies and practices of Customer and PS that are relevant to their use of the Services;(b) ensure that the Authorized Users understand and comply with these Terms of Service and our Privacy Policy; (c) obtain all rights, permissions and/or consents from Authorized Users that are necessary to grant us the rights and licenses in these Terms of Service; and (d) obtain all rights, permissions and/or consents from Authorized Users for the lawful use and transmission of their personal information and data that is required for their use and operation of the Services. Merchant Administrators shall cooperate with PS in ensuring that they, Customer, and Authorized Users comply with these Terms of Service.

                        <br>
                        <br>

                        You are responsible for the security of access to the Account.

                        <br>
                        <br>

                        You must keep all passwords confidential and ensure you comply with strong password requirements. You should not share or otherwise disclose your password to any third party.

                        <br>
                        <br>


                        If you think that your Account or log-in credentials may have been compromised at any time, please notify us immediately at <strong><a href="mailto:support@paysprint.net">support@paysprint.net</a></strong>.

                        
                        <br>
                        <br>


                        <strong>4.2 Customer Content</strong>

                        <br>
                        <br>

                        Some of the Services allow the Customer (or its Merchant Administrators or Authorized Users) to enter data into the Services.  This may include information related to third party individuals – for example, the names and addresses and other information relating to the Customer's members, and financial details of from those members (“Customer Content”).

                        <br>
                        <br>

                        Customer shall bear all responsibility for Customer Content. In particular, you will be responsible for the accuracy, quality and legality of all your Customer Content, the means by which you acquired Customer Content, your use of Customer Content with the Services, and the interoperation of any non-PS applications you use in conjunction with the Services or Customer Content. 

                        <br>
                        <br>

                        You hereby represent and warrant to PS, and agree that during the Term, you will ensure that:

                        <br>
                        <br>

                        You are the owner or valid licensee of the Customer Content and each element thereof, and you have secured all necessary licenses, consents, permissions, waivers and releases for the use of the Customer Content and each element thereof, including without limitation, all trademarks, logos, names and likenesses contained there in, without any obligation by PS to pay any fees, residuals, guild payments or other compensation of any kind.

                        <br>
                        <br>

                        Your use, publication and display of the Customer Content will not infringe any copyright, patent, trademark, trade secret or other proprietary or intellectual property right of any person, or constitute a defamation, invasion of privacy or violation of any right of publicity or any other right of any person, including, without limitation, any contractual, statutory or common law right or any “moral right” or similar right however denominated.

                        <br>
                        <br>

                        You will comply with all applicable laws, rules and regulations regarding the Customer Content and will use the Customer Content only for lawful purposes; and

                        <br>
                        <br>

                        You have used your best efforts to ensure that Customer Content is, and will at all times remain, free of all computer viruses, worms, trojan horses and other malicious code.

                        <br>
                        <br>

                        By integrating your YouTube channel or Playlist with any PS Services you agree to be bound by YouTube’s Terms of Services (https://www.youtube.com/t/terms) and our Privacy Policy which includes reference to data associated with your use of YouTube’s services and acceptance of Google Privacy Policy.  




                    </p>


                    <div class="subtittle">
                        <h2>5. LIMITATION OF LIABILITY</h2>
                    </div>
                    <p>

                        As your sole and exclusive remedy for any Errors, PS will endeavor to rectify any Error we determine to be solely PS’s fault, for example, by appropriately crediting or debiting your Account for the difference in credits or debits due to our Error.

                        <br>
                        <br>
                        In no event will PS's liability in connection with the services, including any software provided here under, or any error whether caused by failure to deliver, non-performance, defects, breach of warranty or otherwise, exceed the aggregate service fees paid to PS by customer during the 3-month period immediately preceding the event giving rise to such liability.
                        <br>
                        <br>

                        PS cannot guarantee continuous service, service, at any particular time, information, or content stored or transmitted via the internet. PS will not be liable for any unauthorized access to, or any corruption, erasure, theft, destruction, alteration or inadvertent disclosure of data, information or content transmitted, received, of stored on its system, subject to applicable data breach notification laws.

                        <br>
                        <br>

                        Neither party shall be liable in any way to the other party or any other person for over draft fees, insufficient funds, inaccurate reporting, any lost profits or revenues, loss of use, loss of data or costs of procurement of substitute goods, licenses or services or similar economic loss, or any punitive, indirect, special, incidental, consequential or similar damages of any nature, whether foreseeable or not, under any warranty or other right here under arising out of or in connection with the performance or non-performance of any order, or for any claim against the other party by a third party, regardless of whether it has been advised of the possibility of such claim or damages.

                    </p>


                    <div class="subtittle">
                        <h2>6. THIRD PARTIES</h2>
                    </div>
                    <p>

                        <strong>6.1 Use of third parties</strong>
                        
                        <br>
                        <br>

                        Subject to Clause 8 and the provisions of the PS GDPR Data Protection Addendum, wherever applicable:

                        <ul>
                            <li>You understand and accept that PS uses third parties to assist in the delivery of its Services.</li>
                            <li>By agreeing to these Terms or by using the Services, you agree to be bound by the Terms of those third parties where they apply.</li>
                            <li>PS accepts no liability for your use of these third-party service providers.</li>
                            
                        </ul>

                        <br>
                        <br>

                        <strong>6.2 Website Links</strong>

                        <br>
                        <br>
                        The Website may contain hyperlinks and other pointers to websites operated by third parties. We do not control these third-party websites and are therefore not responsible for the content of any third-party website or any hyperlink contained in a third-party website. We provide the hyperlinks for your convenience only and do not indicate, expressly or implicitly, any endorsement, sponsorship or approval by us of a third-party website or the products or services offered at a third-party website. Your visit to a third-party website is entirely at your own risk.

                        

                        

                    </p>


                    <div class="subtittle">
                        <h2>7. CONFIDENTIALITY</h2>
                    </div>
                    <p>

                        <strong>7.1 No disclosure</strong>
                        
                        <br>
                        <br>

                        Each party will not, without the prior written consent of the other party, use or disclose to any person any Proprietary Information of the other party disclosed or made available to it, except for use of such Proprietary Information as required in connection with the performance of its obligations or use of the Services or as otherwise provided hereunder. Each party will (i) treat the Proprietary Information of the other party as secret and confidential, (ii)limit access to the Proprietary Information of the party to those of its employees who require it in order to effectuate the purposes of this Agreement, and (iii) not disclose the Proprietary Information of the other party to any other Person without the prior written consent of the other party.


                        <br>
                        <br>

                        <strong>7.2 Harm from disclosure</strong>

                        <br>
                        <br>
                        Each party acknowledges that disclosure of any aspect of the Proprietary Information of the other party shall immediately give rise to continuing irreparable injury to the other party inadequately compensable in damages at law, and, without prejudice to any other remedy available to the other party, shall entitle the other party to injunctive or other equitable relief. Upon expiration or termination of these Terms of Service for any reason, each party shall promptly return to the other party all Proprietary Information of the other party (including all copies thereof) in its possession or control.



                        

                    </p>

                    <div class="subtittle">
                        <h2>8. PRIVACY POLICY AND DATA PROTECTION</h2>
                    </div>
                    <p>

                        <strong>8.1 Privacy Policy</strong>
                        
                        <br>
                        <br>

                        Our Privacy Policy describes in more detail how PS processes personal data.  You should read that Privacy Policy and use the information it contains to help you make informed decisions.  


                        <br>
                        <br>

                        <strong>8.2 Compliance with Laws</strong>

                        <br>
                        <br>
                        PS and the Customer shall comply at all times with their respective obligations under Applicable Data Protection Legislation. In particular, the Customer is responsible for compliance with Data Protection laws that apply to them in relation to all Customer Content and all Customer-Collected Personal Data.

                        <br>
                        <br>

                        <strong>8.3 Data processing addendum</strong>

                        <br>
                        <br>
                        The PS GDPR Data Processing Addendum shall apply, in addition to the data protection provisions set out in these Terms of Service and the PS Privacy Policy, where:
                        <br>
                        <br>
                        PS is acting as data processor in relation to the Services, and is subject to the provisions of the EU GDPR; or

                        <br>
                        <br>

                        there is a transfer of personal data to PS from a Customer in the European Economic Area (EEA), the United Kingdom or any other jurisdiction where the transfer or disclosure of personal data outside the jurisdiction is restricted by applicable Data Protection Regulation to ensure adequate protection for that personal data.
                        <br>
                        <br>

                        If there is any inconsistency between these Terms of Service and the provisions contained in the Addendum., the terms of the Addendum shall prevail.

                        <br>
                        <br>

                        If at any time the Addendum ceases to provide an appropriate safeguard (and, to that end, a lawful ground under applicable Data Protection Legislation) for the transfer of personal data to a third country, territory or international Merchant outside the EEA, then, at the election of PS, each party shall, at its own expense, execute and deliver any necessary documentation as may be required in order to enable the parties to continue to lawfully transfer personal data outside the EEA.
                        

                    </p>


                    <div class="subtittle">
                        <h2>9. MISCELLANEOUS</h2>
                    </div>
                    <p>

                        <strong>9.1 Entire Agreement; Amendments.</strong>
                        
                        <br>
                        <br>

                        These Terms of Service, including documents incorporated herein by reference, supersedes all prior discussions, negotiations and agreements between the parties with respect to the subject matter hereof, and constitutes the sole and entire agreement between the parties with respect to the matters covered hereby. No additional terms or conditions relating to the subject matter of these Terms of Service shall be effective unless approved in writing by any authorized representative of you and PS.


                        <br>
                        <br>

                        <strong>9.2 Notices</strong>

                        <br>
                        <br>
                        All notices and demands required or contemplated hereunder by one party to the other shall be in writing and, unless otherwise specified, shall be deemed to have been duly made and given upon date of delivery if delivered in person orby an overnight delivery or postal service, or upon the expiration of five days after the date of posting if mailed by certified mail, postage prepaid, to the addresses set forth below.
                        <br>
                        <br>

                        PS Address for notice:
                        <br>
                        <br>
                        <strong>
                            PaySprint by Express Ca Corp,
                            <br>
                            10 George St. North, Brampton. ON. L6X1R2
                        </strong>
                        <br>
                        <br>
                        Attention: Chief Financial Officer 
                        <br>
                        <br>
                        PS may give written notice to Customer via e-mail to the Customer’s e-mail address as maintained in PS’s billing records. Either party may change its address or facsimile number for purposes of these Terms of Service by notice in writing to the other party as provided herein.
                        <br>
                        <br>

                        <strong>9.3 Waiver</strong>

                        <br>
                        <br>
                        No failure or delay by any party hereto to exercise any right or remedy here under shall operate as a waiver thereof, nor shall any single or partial exercise of any right or remedy by any party preclude any other or further the exercise of any other right or remedy. No express waiver or assent by any party here to any breach of or default in any term or condition of these Terms of Service shall constitute a waiver of or an assent to any succeeding breach of or default in the same or any other term or condition here of.
                        <br>
                        <br>
                        
                        <strong>9.4 Assignment; Successors</strong>
                        <br>
                        <br>
                        You may not assign or transfer these Terms of Service, or any of its rights or obligations hereunder, without the prior written consent of PS.
                        <br>
                        <br>
                        PS may assign its rights and obligations under these Terms of Service and may engage subcontractors or agents in performing its duties and exercising its rights hereunder, without your consent (unless otherwise agreed). These Terms of Service shall be binding upon and shall inure to the benefit of the parties here to and their respective successors and permitted assigns.

                        <br>
                        <br>
                        <strong>9.5 Force Majeure</strong>
                        <br>
                        <br>
                        Neither party is liable for any default or delay in the performance of any of its obligations under these Terms of Service (other than failure to make payments when due) if such default or delay is caused, directly or indirectly, by forces beyond such party’s reasonable control, including, without limitation, fire, flood, acts of God, labor disputes, accidents, acts of war or terrorism, interruptions of transportation or communications, supply shortages or the failure of any third party to perform any commitment relative to the production or delivery of any equipment or material required for such party to perform its obligations here under.
                        <br>
                        <br>
                        <strong>9.6 Marketing</strong>
                        <br>
                        <br>
                        Customers using the Services agree that during the term of these Terms of Service, PS may publicly refer to Customer, orally and in writing, as a customer of PS. Any other public reference to Customer by PS requires the written consent of Customer.
                        <br>
                        <br>
                        <strong>9.7 Governing Law and Jurisdiction</strong>
                        <br>
                        <br>
                        These Terms are governed by and construed in accordance with the laws of Province of Ontario, without regard to its conflict of laws rules. You expressly agree that the exclusive jurisdiction for any claim or dispute under these Terms and or your use of the Services resides in the courts located in Brampton, Ontario, and you further expressly agree to submit to the personal jurisdiction of such courts for the purpose of litigating any such claim or action. If it turns out that a particular provision in these Terms is not enforceable, that will not affect any other provision.
                        <br>
                        <br>
                        <strong>9.8 Dispute Resolution</strong>
                        <br>
                        <br>
                        If there is a dispute, claim or controversy arising out of or relating to the breach, termination, enforcement, interpretation or validity of any provision of these Terms of Service, either party may commence arbitration by providing a written demand for arbitration, setting forth the subject of the dispute and the relief requested. Arbitration will then be conducted in accordance with the following:

                        <br>
                        <br>
                        For disputes where the Customer is located outside Canada, or where the Customer otherwise elects, by arbitration in Brampton, Ontario before a single arbitrator in accordance with the following:

                        <br>
                        <br>
                        The arbitration will bead ministered by the American Arbitration Association under its Commercial Arbitration Rules.
                        <br>
                        <br>
                        The arbitrator will apply the substantive law of the State of California, exclusive of its conflict or choice of law rules.
                        <br>
                        <br>
                        The parties acknowledge that this Agreement evidences a transaction involving interstate commerce. Notwithstanding the provisions in this paragraph referencing applicable substantive law, the applicable federal law will govern any arbitration conducted pursuant to the terms of this Agreement.

                        

                    </p>


                    <div class="subtittle">
                        <h2>10. DEFINITIONS</h2>
                    </div>
                    <p>

                        Unless the terms and conditions of the Terms of Service explicitly state otherwise, expressions used in the Terms of Service have the following meanings:

                        <br>
                        <br>
                        Account means an account established to access the Services, including where it is opened for you to test the Service or for the purpose of demonstration.

                        <br>
                        <br>

                        Applicable Data Protection Legislation means a relevant law concerning the collection, use and disclosure of information which may identify an individual, where that law is binding on both PS and the Customer, which may include:


                        <br>
                        <br>
                         the EU GDPR; or

                        <br>
                        the Data Protection Act 2018(UK); or
                        <br>
                        the Personal Data Protection Act 2012 (Singapore); or
                        <br>
                        the Privacy Act 1988 (Cth)and any code registered under the Privacy Act or Australian Privacy Principles.
                        <br>
                        <br>

                        Authorized Users are users who are granted permission to access the Services by either (i) a Customer, (ii) a Merchant Administrator, or (iii) another Authorized User that has been given the permissions to add additional Authorized Users by a Merchant Administrator.
                        <br>
                        <br>

                        Customer means any Merchant or individual who establishes an account with PS.

                        <br>
                        <br>

                        Customer-Collected Personal Data means personal data processed by the Customer in the course of or relating to using the Services.

                        <br>
                        <br>

                        Error includes an Unauthorized Transaction, a transaction that is missing from or not properly identified in your PS account statement, a computational or mathematical error related to your Account.

                        <br>
                        <br>

                        EU GDPR means Regulation (EU) 2016/679 of the European Parliament and of the Council of 27 April 2016 on the protection of natural persons with regard to the processing of Personal Data and on the free movement of Personal Data, and repealing Directive 95/46/EC.

                        <br>
                        <br>
                        Law means any law applying to the provision or use of the Services.  

                        <br>
                        <br>
                        Members are individuals who are usually associated with a Customer/Merchant (for example, receiver of money or members of a Merchant’s congregation). Members may access the Services via an Authorized User account. Information including Customer Content about Members may be entered into a Service directly by the Member orby a Customer.

                        <br>
                        <br>

                        Merchant Administrator means any user who has been granted permission to manage, access or make decisions concerning a Customer’s Account by the owner of that Customer Account.	

                        <br>
                        <br>

                        Personal Data, for information for which the Applicable Data Protection Legislation:

                        <br>
                        <br>

                        Delays resulting from PS applying holds, limits or reviews or relating to the time to may take for a transaction to be completed.

                        <br>
                        <br>
                        is the GDPR, has the meaning given to it in the GDPR; and

                        <br>
                        <br>
                        is the Privacy Act 1988 (Cth), has the meaning given to “personal information” in the Privacy Act 1988(Cth).
                        <br>
                        <br>
                        Privacy Policy means, as the circumstances require, the PS Privacy Policy, or any privacy policy as published on a PS website from time to time.
                        <br>
                        <br>
                        Service means any service provided by PS including Sending and receiving money, paying invoice or maintaining a wallet either on the website or through the mobile app.

                        <br>
                        <br>
                        Service Fee means the transaction fee or pricing listed for the relevant Service on the “Pricing” page of the Website.
                        <br>
                        <br>
                        Software means all software owned and designed by PS.
                        <br>
                        <br>
                        Term means the period of time referred to in clause 3.2.
                        <br>
                        <br>
                        Unauthorized Transaction includes any transaction where an amount is debited or credited to an Account without authorization.  
                        <br>
                        <br>
                        You means a person or entity using the Services or visiting the Website (and includes Customers and Merchants).
                        <br>
                        <br>
                        Website means, as the circumstances require, the websites located at www.paysprint.net. 
                        <br>
                        <br>
                        PS includes PaySprint, EXBC or Express Ca Corp, subsidiaries, associates and affiliates. 

                    </p>





                </div>

            </div>
        </div>
    </section>
    <!-- End About Us Area -->




@endsection
