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
          <h5 class="modal-title" id="exampleModalCenterTitle">Send Money</h5>
          
        </div>
        <div class="modal-body">
          <center><h4>How would you like to send Money</h4></center>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
          <a type="button" class="btn btn-primary btn btn-block" href="{{ url('payorganization?type=local') }}">Local</a>
          <a type="button" class="btn btn-danger btn btn-block" href="{{ url('payorganization?type=international') }}">International</a>
        </div>
      </div>
    </div>
  </div>