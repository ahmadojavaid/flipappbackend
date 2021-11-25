
                    <div class="tab-pane" id="settings">
                        <form method="post" action="{{route('admin.user.update')}}" onsubmit="update(event)" id="form">                            
                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Personal Info</h5>
                            <div class="alert alert-success success_msgs hide" role="alert">
                                
                            </div>
                            <div class="alert alert-danger hide error_msgs" role="alert">
                              
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="firstname">First Name</label>
                                        <input type="text" value="{{$user->first_name}}" class="form-control" name="first_name" id="firstname" placeholder="Enter first name" required="">
                                        <input type="hidden" name="id" value="{{$user->id}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" value="{{$user->last_name}}" class="form-control" name="last_name" id="lastname" placeholder="Enter last name" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="firstname">User Name</label>
                                        <input type="text" value="{{$user->user_name}}" class="form-control" name="user_name" id="firstname" placeholder="Enter User name" required="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" value="{{$user->email}}" class="form-control" name="email" id="email" placeholder="Enter Email" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="firstname">Country</label>
                                        <input type="text" value="{{$user->country}}" name="country" class="form-control" id="firstname" placeholder="Country" required="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastname">Phone</label>
                                        <input type="number" value="{{$user->phone_number}}" class="form-control" name="phone_number" id="lastname" placeholder="Enter Phone Number" required="">
                                    </div>
                                </div>
                            </div>

                            
                            
                            <div class="text-right">
                                <button type="submit" class="btn btn-success waves-effect waves-light mt-2 has-spinner">Update</button>
                            </div>
                        </form>
                    </div>