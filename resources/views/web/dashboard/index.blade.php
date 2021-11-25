@extends('layouts.dashboard.master')
@section('title', 'Dashboard')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div id="content">
        <nav>
            <div class="nav nav-tabs border-0 text-center" id="nav-tab" role="tablist">
                <a class="nav-item nav-link sell-pending-nav-link active m-2" style="width: 10rem;" id="nav-home-tab"
                   data-toggle="tab" href="#nav-home" role="tab"
                   aria-controls="nav-home" aria-selected="true">PENDING</a>
                <a class="nav-item nav-link m-2 sell-pending-nav-link" style="width: 10rem;" id="nav-profile-tab"
                   data-toggle="tab" href="#nav-profile" role="tab"
                   aria-controls="nav-profile" aria-selected="false">HISTORY</a>

            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="table-responsive pt-4">
                    <table class="table">
                        <thead class="text-center text-white">
                        <tr>
                            <th scope="col" style="background-color: #2F2F2F; width: 15rem;border: 1px white solid;">
                                Item
                            </th>
                            <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">
                                Bid
                            </th>
                            <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">
                                Highest Bid
                            </th>
                            <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">
                                Lowest Ask
                            </th>
                            <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">
                                Expires
                            </th>
                        </tr>
                        </thead>
                        <tbody class="text-center" style="background-color: #F8F8F8;">
                        <tr>
                            <td>
                                <div class="d-flex flex-row justify-content-start">
                                    <div class="p-1">
                                        <img src="{{ asset('assets/img/products/Screenshot%202019-07-13%20at%2016.16.24.png') }}"
                                             style="width: 60px;height: 60px;object-fit: cover;">
                                    </div>
                                    <div class="p-1">
                                        <div class="d-flex flex-column justify-content-between">
                                            <div>
                                                <p class="mb-0">SUPREME®/CHAMPION®<br>
                                                    CHROME S/S TOP BLACK</p>
                                            </div>
                                            <div class="text-left">
                                                <p class="mb-0 d-inline">Size:</p>
                                                <p class="mb-0 d-inline font-weight-bold pl-2">L</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>£235</td>
                            <td>£237</td>
                            <td>£244</td>
                            <td>
                                <p class="d-inline mb-0">3</p>
                                <p class="d-inline mb-0 pl-2">Days</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex flex-row justify-content-start">
                                    <div class="p-1">
                                        <img src="{{ asset('assets/img/products/Screenshot%202019-07-13%20at%2016.16.24.png') }}"
                                             style="width: 60px;height: 60px;object-fit: cover;">
                                    </div>
                                    <div class="p-1">
                                        <div class="d-flex flex-column justify-content-between">
                                            <div>
                                                <p class="mb-0">SUPREME®/CHAMPION®<br>
                                                    CHROME S/S TOP BLACK</p>
                                            </div>
                                            <div class="text-left">
                                                <p class="mb-0 d-inline">Size:</p>
                                                <p class="mb-0 d-inline font-weight-bold pl-2">L</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>£235</td>
                            <td>£237</td>
                            <td>£244</td>
                            <td>
                                <p class="d-inline mb-0">3</p>
                                <p class="d-inline mb-0 pl-2">Days</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex flex-row justify-content-start">
                                    <div class="p-1">
                                        <img src="{{ asset('assets/img/products/Screenshot%202019-07-13%20at%2016.16.24.png') }}"
                                             style="width: 60px;height: 60px;object-fit: cover;">
                                    </div>
                                    <div class="p-1">
                                        <div class="d-flex flex-column justify-content-between">
                                            <div>
                                                <p class="mb-0">SUPREME®/CHAMPION®<br>
                                                    CHROME S/S TOP BLACK</p>
                                            </div>
                                            <div class="text-left">
                                                <p class="mb-0 d-inline">Size:</p>
                                                <p class="mb-0 d-inline font-weight-bold pl-2">L</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>£235</td>
                            <td>£237</td>
                            <td>£244</td>
                            <td>
                                <p class="d-inline mb-0">3</p>
                                <p class="d-inline mb-0 pl-2">Days</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex flex-row justify-content-start">
                                    <div class="p-1">
                                        <img src="{{ asset('assets/img/products/Screenshot%202019-07-13%20at%2016.16.24.png') }}"
                                             style="width: 60px;height: 60px;object-fit: cover;">
                                    </div>
                                    <div class="p-1">
                                        <div class="d-flex flex-column justify-content-between">
                                            <div>
                                                <p class="mb-0">SUPREME®/CHAMPION®<br>
                                                    CHROME S/S TOP BLACK</p>
                                            </div>
                                            <div class="text-left">
                                                <p class="mb-0 d-inline">Size:</p>
                                                <p class="mb-0 d-inline font-weight-bold pl-2">L</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>£235</td>
                            <td>£237</td>
                            <td>£244</td>
                            <td>
                                <p class="d-inline mb-0">3</p>
                                <p class="d-inline mb-0 pl-2">Days</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex flex-row justify-content-start">
                                    <div class="p-1">
                                        <img src="{{ asset('assets/img/products/Screenshot%202019-07-13%20at%2016.16.24.png') }}"
                                             style="width: 60px;height: 60px;object-fit: cover;">
                                    </div>
                                    <div class="p-1">
                                        <div class="d-flex flex-column justify-content-between">
                                            <div>
                                                <p class="mb-0">SUPREME®/CHAMPION®<br>
                                                    CHROME S/S TOP BLACK</p>
                                            </div>
                                            <div class="text-left">
                                                <p class="mb-0 d-inline">Size:</p>
                                                <p class="mb-0 d-inline font-weight-bold pl-2">L</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>£235</td>
                            <td>£237</td>
                            <td>£244</td>
                            <td>
                                <p class="d-inline mb-0">3</p>
                                <p class="d-inline mb-0 pl-2">Days</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex flex-row justify-content-start">
                                    <div class="p-1">
                                        <img src="{{ asset('assets/img/products/Screenshot%202019-07-13%20at%2016.16.24.png') }}"
                                             style="width: 60px;height: 60px;object-fit: cover;">
                                    </div>
                                    <div class="p-1">
                                        <div class="d-flex flex-column justify-content-between">
                                            <div>
                                                <p class="mb-0">SUPREME®/CHAMPION®<br>
                                                    CHROME S/S TOP BLACK</p>
                                            </div>
                                            <div class="text-left">
                                                <p class="mb-0 d-inline">Size:</p>
                                                <p class="mb-0 d-inline font-weight-bold pl-2">L</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>£235</td>
                            <td>£237</td>
                            <td>£244</td>
                            <td>
                                <p class="d-inline mb-0">3</p>
                                <p class="d-inline mb-0 pl-2">Days</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex flex-row justify-content-start">
                                    <div class="p-1">
                                        <img src="{{ asset('assets/img/products/Screenshot%202019-07-13%20at%2016.16.24.png') }}"
                                             style="width: 60px;height: 60px;object-fit: cover;">
                                    </div>
                                    <div class="p-1">
                                        <div class="d-flex flex-column justify-content-between">
                                            <div>
                                                <p class="mb-0">SUPREME®/CHAMPION®<br>
                                                    CHROME S/S TOP BLACK</p>
                                            </div>
                                            <div class="text-left">
                                                <p class="mb-0 d-inline">Size:</p>
                                                <p class="mb-0 d-inline font-weight-bold pl-2">L</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>£235</td>
                            <td>£237</td>
                            <td>£244</td>
                            <td>
                                <p class="d-inline mb-0">3</p>
                                <p class="d-inline mb-0 pl-2">Days</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex flex-row justify-content-start">
                                    <div class="p-1">
                                        <img src="{{ asset('assets/img/products/Screenshot%202019-07-13%20at%2016.16.24.png') }}"
                                             style="width: 60px;height: 60px;object-fit: cover;">
                                    </div>
                                    <div class="p-1">
                                        <div class="d-flex flex-column justify-content-between">
                                            <div>
                                                <p class="mb-0">SUPREME®/CHAMPION®<br>
                                                    CHROME S/S TOP BLACK</p>
                                            </div>
                                            <div class="text-left">
                                                <p class="mb-0 d-inline">Size:</p>
                                                <p class="mb-0 d-inline font-weight-bold pl-2">L</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>£235</td>
                            <td>£237</td>
                            <td>£244</td>
                            <td>
                                <p class="d-inline mb-0">3</p>
                                <p class="d-inline mb-0 pl-2">Days</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex flex-row justify-content-start">
                                    <div class="p-1">
                                        <img src="{{ asset('assets/img/products/Screenshot%202019-07-13%20at%2016.16.24.png') }}"
                                             style="width: 60px;height: 60px;object-fit: cover;">
                                    </div>
                                    <div class="p-1">
                                        <div class="d-flex flex-column justify-content-between">
                                            <div>
                                                <p class="mb-0">SUPREME®/CHAMPION®<br>
                                                    CHROME S/S TOP BLACK</p>
                                            </div>
                                            <div class="text-left">
                                                <p class="mb-0 d-inline">Size:</p>
                                                <p class="mb-0 d-inline font-weight-bold pl-2">L</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>£235</td>
                            <td>£237</td>
                            <td>£244</td>
                            <td>
                                <p class="d-inline mb-0">3</p>
                                <p class="d-inline mb-0 pl-2">Days</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex flex-row justify-content-start">
                                    <div class="p-1">
                                        <img src="{{ asset('assets/img/products/Screenshot%202019-07-13%20at%2016.16.24.png') }}"
                                             style="width: 60px;height: 60px;object-fit: cover;">
                                    </div>
                                    <div class="p-1">
                                        <div class="d-flex flex-column justify-content-between">
                                            <div>
                                                <p class="mb-0">SUPREME®/CHAMPION®<br>
                                                    CHROME S/S TOP BLACK</p>
                                            </div>
                                            <div class="text-left">
                                                <p class="mb-0 d-inline">Size:</p>
                                                <p class="mb-0 d-inline font-weight-bold pl-2">L</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>£235</td>
                            <td>£237</td>
                            <td>£244</td>
                            <td>
                                <p class="d-inline mb-0">3</p>
                                <p class="d-inline mb-0 pl-2">Days</p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="table-responsive pt-4">
                    <table class="table">
                        <thead class="text-center text-white">
                        <tr>
                            <th scope="col" style="background-color: #2F2F2F; width: 15rem;border: 1px white solid;">
                                Item
                            </th>
                            <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">
                                Style
                            </th>
                            <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">
                                Price
                            </th>
                            <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">
                                Date
                            </th>
                            <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">
                                Status
                            </th>
                        </tr>
                        </thead>
                        <tbody class="text-center" style="background-color: #F8F8F8;">
                        <tr>
                            <td>
                                <div class="d-flex flex-row justify-content-start">
                                    <div class="p-1">
                                        <img src="{{ asset('assets/img/products/Screenshot%202019-07-13%20at%2016.16.24.png') }}"
                                             style="width: 60px;height: 60px;object-fit: cover;">
                                    </div>
                                    <div class="p-1">
                                        <div class="d-flex flex-column justify-content-between">
                                            <div>
                                                <p class="mb-0">SUPREME®/CHAMPION®<br>
                                                    CHROME S/S TOP BLACK</p>
                                            </div>
                                            <div class="text-left">
                                                <p class="mb-0 d-inline">Size:</p>
                                                <p class="mb-0 d-inline font-weight-bold pl-2">L</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>84505-30</td>
                            <td>£237</td>
                            <td>4-28-2019</td>
                            <td>
                                <p class="d-inline mb-0">Successfully
                                    Sold</p>
                                <img class="d-inline pl-2" src="{{ asset('assets/img/icons/Ellipse 9.png') }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex flex-row justify-content-start">
                                    <div class="p-1">
                                        <img src="{{ asset('assets/img/products/Screenshot%202019-07-13%20at%2016.16.24.png') }}"
                                             style="width: 60px;height: 60px;object-fit: cover;">
                                    </div>
                                    <div class="p-1">
                                        <div class="d-flex flex-column justify-content-between">
                                            <div>
                                                <p class="mb-0">SUPREME®/CHAMPION®<br>
                                                    CHROME S/S TOP BLACK</p>
                                            </div>
                                            <div class="text-left">
                                                <p class="mb-0 d-inline">Size:</p>
                                                <p class="mb-0 d-inline font-weight-bold pl-2">L</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>84505-30</td>
                            <td>£237</td>
                            <td>4-28-2019</td>
                            <td>
                                <p class="d-inline mb-0">Successfully
                                    Sold</p>
                                <img class="d-inline pl-2" src="{{ asset('assets/img/icons/Ellipse 9.png') }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex flex-row justify-content-start">
                                    <div class="p-1">
                                        <img src="{{ asset('assets/img/products/Screenshot%202019-07-13%20at%2016.16.24.png') }}"
                                             style="width: 60px;height: 60px;object-fit: cover;">
                                    </div>
                                    <div class="p-1">
                                        <div class="d-flex flex-column justify-content-between">
                                            <div>
                                                <p class="mb-0">SUPREME®/CHAMPION®<br>
                                                    CHROME S/S TOP BLACK</p>
                                            </div>
                                            <div class="text-left">
                                                <p class="mb-0 d-inline">Size:</p>
                                                <p class="mb-0 d-inline font-weight-bold pl-2">L</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>84505-30</td>
                            <td>£237</td>
                            <td>4-28-2019</td>
                            <td>
                                <p class="d-inline mb-0">Successfully
                                    Sold</p>
                                <img class="d-inline pl-2" src="{{ asset('assets/img/icons/Ellipse 9.png') }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex flex-row justify-content-start">
                                    <div class="p-1">
                                        <img src="{{ asset('assets/img/products/Screenshot%202019-07-13%20at%2016.16.24.png') }}"
                                             style="width: 60px;height: 60px;object-fit: cover;">
                                    </div>
                                    <div class="p-1">
                                        <div class="d-flex flex-column justify-content-between">
                                            <div>
                                                <p class="mb-0">SUPREME®/CHAMPION®<br>
                                                    CHROME S/S TOP BLACK</p>
                                            </div>
                                            <div class="text-left">
                                                <p class="mb-0 d-inline">Size:</p>
                                                <p class="mb-0 d-inline font-weight-bold pl-2">L</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>84505-30</td>
                            <td>£237</td>
                            <td>4-28-2019</td>
                            <td>
                                <p class="d-inline mb-0">Successfully
                                    Sold</p>
                                <img class="d-inline pl-2" src="{{ asset('assets/img/icons/Ellipse 9.png') }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex flex-row justify-content-start">
                                    <div class="p-1">
                                        <img src="{{ asset('assets/img/products/Screenshot%202019-07-13%20at%2016.16.24.png') }}"
                                             style="width: 60px;height: 60px;object-fit: cover;">
                                    </div>
                                    <div class="p-1">
                                        <div class="d-flex flex-column justify-content-between">
                                            <div>
                                                <p class="mb-0">SUPREME®/CHAMPION®<br>
                                                    CHROME S/S TOP BLACK</p>
                                            </div>
                                            <div class="text-left">
                                                <p class="mb-0 d-inline">Size:</p>
                                                <p class="mb-0 d-inline font-weight-bold pl-2">L</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>84505-30</td>
                            <td>£237</td>
                            <td>4-28-2019</td>
                            <td>
                                <p class="d-inline mb-0">Successfully
                                    Sold</p>
                                <img class="d-inline pl-2" src="{{ asset('assets/img/icons/Ellipse 9.png') }}">
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
@endsection
@section('cssheader')
@endsection
@section('jsfooter')
@endsection