{{-- Start Modal --}}



                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary disp-0" data-toggle="modal"
                                                    data-target="#launchFileUpload{{ $datainfo->id }}"
                                                    id="launchButton{{ $datainfo->id }}">
                                                    Launch demo modal
                                                </button>


                                                <form action="{{ route('upload user doc') }}" method="POST"
                                                    enctype="multipart/form-data" id="uploadthisform{{ $datainfo->id }}">
                                                    @csrf
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="launchFileUpload{{ $datainfo->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="launchFileUploadTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">

                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                                        {{ $datainfo->name }}</h3>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <div class="modal-body">
                                                                     <div class="form-group">
                                                                    <select name="docType" id="docType{{ $datainfo->id }}" class="form-control">
                                                                        <option value="">Select Document Type</option>
                                                                        <option value="avatar">Avatar</option>
                                                                        <option value="nin_front">National Identity Card</option>
                                                                        <option value="drivers_license_front">Driver Licence</option>
                                                                        <option value="international_passport_front">International Passport</option>
                                                                        <option value="idvdoc">Other Document</option>
                                                                    </select>
                                                                    </div>


                                                                    <div class="form-group">

                                                                        <input type="file" name="image"
                                                                        id="uploadContent{{ $datainfo->id }}"
                                                                        class="form-control">
                                                                    <input type="hidden" name="user_id"
                                                                        value="{{ $datainfo->id }}">


                                                                    </div>


                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-primary"
                                                                        id="uploadBtn{{ $datainfo->id }}"
                                                                        onclick="uploadDocsForUser('uploadthisform', '{{ $datainfo->id }}')">Upload</button>
                                                                </div>

                                                            </div>


                                                        </div>
                                                    </div>

                                                </form>





                                                {{-- End Modal --}}
