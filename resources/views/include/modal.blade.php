<!-- Button trigger modal -->
<button type="button" class="btn btn-primary disp-0" data-toggle="modal" data-target="#exampleModalCenter" id="sendMoney">
    Launch demo modal
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          <h3 class="modal-title" id="exampleModalCenterTitle">Money Transfer</h3>
          
        </div>
        {{--  <div class="modal-body">
          <center><h4>How would you like to send Money</h4></center>
        </div>  --}}
        <div class="modal-footer">

          <div class="row">
            <center>
              <div class="col-md-6">
                <a href="{{ url('payorganization?type=local') }}" title="Local">
                <img src="https://img.icons8.com/cotton/64/000000/location-update.png"/>
                </a>
              </div>

              <div class="col-md-6">
                <a href="javascript:void()" onclick="comingSoon()" title="International">
                  <img src="https://img.icons8.com/cotton/64/000000/worldwide-location.png"/>
                  
                </a>
              </div>
            </center>
          </div>

          {{--  <a type="button" class="btn btn-primary btn btn-block" href="{{ url('payorganization?type=local') }}">Local</a>
          <a type="button" class="btn btn-danger btn btn-block" href="javascript:void()" onclick="comingSoon()">International</a>  --}}
          {{-- <a type="button" class="btn btn-danger btn btn-block" href="{{ url('payorganization?type=international') }}">International</a> --}}
        </div>
      </div>
    </div>
  </div>



<!-- Button trigger modal -->
<button type="button" class="btn btn-primary disp-0" data-toggle="modal" data-target="#examplePasswordCenter" id="password">
    Launch demo modal
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="examplePasswordCenter" tabindex="-1" role="dialog" aria-labelledby="examplePasswordCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          <h5 class="modal-title" id="examplePasswordCenterTitle">Reset Password</h5>
          
        </div>
         <div class="modal-body">
            <form action="#" method="post" id="formElemresetPassword">
              <div class="form-group">
                <label for="passwordsecurityQuestion">Security Question</label>
                <input type="hidden" class="form-control" name="securityQuestion" value="" id="passwordsecurityQuest">
                <h4 id="passwordmySecQuest" style="color:#0b460c; font-weight: 800;"></h4>
              </div>
              <hr>
              <div class="form-group">
                <label for="passwordsecurityAnswer">Security Answer</label>
                <input type="text" class="form-control" name="securityAnswer">
              </div>

              <div class="form-group">
                <label for="passwordnewpassword">New Password</label>
                <input type="text" class="form-control" name="newpassword">
              </div>


              <div class="form-group">
                <label for="passwordconfirmpassword">Confirm Password</label>
                <input type="text" class="form-control" name="confirmpassword">
              </div>


              <div class="form-group">
                <button type="button" class="btn btn-primary btn-block" id="resetPasswordBtn" onclick="handShake('resetPassword')">Submit</button>
              </div>

            </form>
        </div> 
      </div>
    </div>
  </div>


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary disp-0" data-toggle="modal" data-target="#exampleTransactionCenter" id="transaction">
    Launch demo modal
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleTransactionCenter" tabindex="-1" role="dialog" aria-labelledby="exampleTransactionCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          <h5 class="modal-title" id="exampleTransactionCenterTitle">Reset Transaction Pin</h5>
          
        </div>
         <div class="modal-body">

          <form action="#" method="post" id="formElemresetTransactionPin">
            <div class="form-group">
              <label for="transactionsecurityQuestion">Security Question</label>
              <input type="hidden" class="form-control" name="securityQuestion" value="" id="transactionsecurityQuest">
              <h4 id="transactionmySecQuest" style="color:#0b460c; font-weight: 800;"></h4>
            </div>
            <hr>
            <div class="form-group">
              <label for="transactionsecurityAnswer">Security Answer</label>
              <input type="text" class="form-control" name="securityAnswer">
            </div>

            <div class="form-group">
              <label for="transactionnewpin">New Pin</label>
              <input type="text" class="form-control" name="newpin">
            </div>


            <div class="form-group">
              <label for="transactionconfirmpin">Confirm Pin</label>
              <input type="text" class="form-control" name="confirmpin">
            </div>


            <div class="form-group">
              <button type="button" class="btn btn-primary btn-block" id="resetTransactionPinBtn" onclick="handShake('resetTransactionPin')">Submit</button>
            </div>

          </form>

        </div> 
      </div>
    </div>
  </div>