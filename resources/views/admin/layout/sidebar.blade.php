<!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu">

                <div class="slimscroll-menu">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul class="metismenu" id="side-menu">

                            <li class="menu-title">Navigation</li>

                            <li>
                                <a href="{{route('admin.dashboard')}}">
                                    <i class="fe-airplay"></i>
                                    <span> Dashboards </span>
                                </a>
                                <!-- <ul class="nav-second-level" aria-expanded="false">
                                    <li>
                                        <a href="index.html">Dashboard 1</a>
                                    </li>
                                    <li>
                                        <a href="dashboard-2.html">Dashboard 2</a>
                                    </li>
                                    <li>
                                        <a href="dashboard-3.html">Dashboard 3</a>
                                    </li>
                                    <li>
                                        <a href="dashboard-4.html">Dashboard 4</a>
                                    </li>
                                </ul> -->
                            </li>
                            <li class="{{ (request()->segment(2) == 'brands') ? 'active' : '' }}">
                                <a  class="{{ (request()->segment(2) == 'brands') ? 'active' : '' }}" href="{{route('admin.brand.index')}}">
                                    <i class="fas fa-crown "></i>
                                    <span> Brands </span>
                                </a>
                            </li>
                            <li class="{{ (request()->segment(2) == 'products') ? 'active' : '' }}">
                                <a  class="{{ (request()->segment(2) == 'products') ? 'active' : '' }}" href="{{route('admin.product.index')}}">
                                    <i class="fab fa-product-hunt "></i>
                                    <span> Products </span>
                                </a>
                            </li>
                            <li class="{{ (request()->segment(2) == 'release') ? 'active' : '' }}">
                                <a  class="{{ (request()->segment(2) == 'release') ? 'active' : '' }}" href="{{route('admin.release_product.index')}}">
                                    <i class="mdi mdi-airplane-takeoff  "></i>
                                    <span> Release Products </span>
                                </a>
                            </li>
                            <li class="{{ (request()->segment(2) == 'users') ? 'active' : '' }}">
                                <a  class="{{ (request()->segment(2) == 'users') ? 'active' : '' }}" href="{{route('admin.user.index')}}">
                                    <i class="fas fa-users "></i>
                                    <span> Users </span>
                                </a>
                            </li>
                            <li class="{{ (request()->segment(2) == 'product-by-size') ? 'active' : '' }}">
                                <a  class="{{ (request()->segment(2) == 'product-by-size') ? 'active' : '' }}" href="{{route('admin.bids_asks.product_by_size')}}">
                                    <i class="fas fa-dungeon "></i>
                                    <span> Product Bids & Asks </span>
                                </a>
                            </li>             
                            <li class="{{ (request()->segment(2) == 'coupons') ? 'active' : '' }}">
                                <a  class="{{ (request()->segment(2) == 'coupons') ? 'active' : '' }}" href="{{route('admin.coupon.index')}}">
                                    <i class=" fas fa-tags "></i>
                                    <span> Coupons </span>
                                </a>
                            </li>
                            

                            <li>
                                <a href="javascript:;">
                                    <i class="fas fa-cog "></i>
                                    <span> Settings </span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li>
                                        <a href="{{route('admin.setting.paypal')}}">Payment</a>
                                    </li>
                                    <li>
                                        <a href="{{route('admin.setting.shipment')}}">Shipment</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
<!-- Left Sidebar End -->