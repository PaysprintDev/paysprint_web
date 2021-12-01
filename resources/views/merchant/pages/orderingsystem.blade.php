@extends('layouts.merch.merchant-dashboard')


@section('content')

    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">

                    <div class="col-lg-6">
                        <!-- Bookmark Start-->

                        <!-- Bookmark Ends-->
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid list-products">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                        type="button" role="tab" aria-controls="nav-home" aria-selected="true">Products</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                        type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Orders</button>
                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                        type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Product Category</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="row">
                        <!-- Individual column searching (text inputs) Starts-->
                        <div class="col-sm-12">
                            <div class="card">

                                <div class="card-body">
                                    <div class="table-responsive product-table">
                                        <table class="display" id="basic-1">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Details</th>
                                                    <th>Amount</th>
                                                    <th>Stock</th>
                                                    <th>Start date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <a href="#"><img
                                                                src="../assets/images/ecommerce/product-table-1.png"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>Red Lipstick</h6>
                                                        </a><span>Interchargebla lens Digital Camera with APS-C-X Trans CMOS
                                                            Sens</span>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-success">In Stock</td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Delete</button>
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#"><img
                                                                src="../assets/images/ecommerce/product-table-2.png"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>Pink Lipstick</h6>
                                                        </a>
                                                        <p>Interchargebla lens Digital Camera with APS-C-X Trans CMOS Sens
                                                        </p>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-primary">Low Stock</td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Delete</button>
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#"><img
                                                                src="../assets/images/ecommerce/product-table-3.png"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>Gray Lipstick</h6>
                                                        </a>
                                                        <p>Interchargebla lens Digital Camera with APS-C-X Trans CMOS Sens
                                                        </p>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-danger">out of stock</td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Delete</button>
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#"><img
                                                                src="../assets/images/ecommerce/product-table-4.png"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>Green Lipstick</h6>
                                                        </a>
                                                        <p>Interchargebla lens Digital Camera with APS-C-X Trans CMOS Sens
                                                        </p>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-primary">Low Stock</td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Delete</button>
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#"><img
                                                                src="../assets/images/ecommerce/product-table-5.png"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>Black Lipstick</h6>
                                                        </a>
                                                        <p>Interchargebla lens Digital Camera with APS-C-X Trans CMOS Sens
                                                        </p>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-success">In Stock</td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Delete</button>
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#"><img
                                                                src="../assets/images/ecommerce/product-table-6.png"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>White Lipstick</h6>
                                                        </a>
                                                        <p>Interchargebla lens Digital Camera with APS-C-X Trans CMOS Sens
                                                        </p>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-primary">Low Stock</td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Delete</button>
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#"><img
                                                                src="../assets/images/ecommerce/product-table-1.png"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>light Lipstick</h6>
                                                        </a>
                                                        <p>Interchargebla lens Digital Camera with APS-C-X Trans CMOS Sens
                                                        </p>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-danger">out of stock</td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Delete</button>
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#"><img
                                                                src="../assets/images/ecommerce/product-table-2.png"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>Gliter Lipstick</h6>
                                                        </a>
                                                        <p>Interchargebla lens Digital Camera with APS-C-X Trans CMOS Sens
                                                        </p>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-danger">out of stock</td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Delete</button>
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#"><img
                                                                src="../assets/images/ecommerce/product-table-3.png"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>green Lipstick</h6>
                                                        </a>
                                                        <p>Interchargebla lens Digital Camera with APS-C-X Trans CMOS Sens
                                                        </p>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-success">In Stock</td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Delete</button>
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#"><img
                                                                src="../assets/images/ecommerce/product-table-4.png"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>Yellow Lipstick</h6>
                                                        </a>
                                                        <p>Interchargebla lens Digital Camera with APS-C-X Trans CMOS Sens
                                                        </p>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-danger">out of stock</td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Delete</button>
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Edit</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h5>Order history</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="order-history table-responsive">
                                            <table class="table table-bordernone display" id="basic-1">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Prdouct</th>
                                                        <th scope="col">Prdouct name</th>
                                                        <th scope="col">Size</th>
                                                        <th scope="col">Color</th>
                                                        <th scope="col">Article number</th>
                                                        <th scope="col">Units</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col"><i class="fa fa-angle-down"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <a href="#"><img class="img-fluid img-30"
                                                                    src="../assets/images/product/1.png" alt="#" /></a>
                                                        </td>
                                                        <td>
                                                            <div class="product-name">
                                                                <a href="#">Long Top</a>
                                                                <div class="order-process"><span
                                                                        class="order-process-circle"></span>Processing</div>
                                                            </div>
                                                        </td>
                                                        <td>M</td>
                                                        <td>Lavander</td>
                                                        <td>4215738</td>
                                                        <td>1</td>
                                                        <td>$21</td>
                                                        <td><i data-feather="more-vertical"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="#"><img class="img-fluid img-30"
                                                                    src="../assets/images/product/13.png" alt="#" /></a>
                                                        </td>
                                                        <td>
                                                            <div class="product-name">
                                                                <a href="#">Fancy watch</a>
                                                                <div class="order-process"><span
                                                                        class="order-process-circle"></span>Processing</div>
                                                            </div>
                                                        </td>
                                                        <td>35mm</td>
                                                        <td>Blue</td>
                                                        <td>5476182</td>
                                                        <td>1</td>
                                                        <td>$10</td>
                                                        <td><i data-feather="more-vertical"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td><img class="img-fluid img-30"
                                                                src="../assets/images/product/4.png" alt="#" /></td>
                                                        <td>
                                                            <div class="product-name">
                                                                <a href="#">Man shoes</a>
                                                                <div class="order-process"><span
                                                                        class="order-process-circle"></span>Processing</div>
                                                            </div>
                                                        </td>
                                                        <td>8</td>
                                                        <td>Black & white</td>
                                                        <td>1756457</td>
                                                        <td>1</td>
                                                        <td>$18</td>
                                                        <td><i data-feather="more-vertical"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="#"><img class="img-fluid img-30"
                                                                    src="../assets/images/product/10.png" alt="#" /></a>
                                                        </td>
                                                        <td>
                                                            <div class="product-name">
                                                                <a href="#">Ledis side bag</a>
                                                                <div class="order-process"><span
                                                                        class="order-process-circle shipped-order"></span>Shipped
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>22cm x 18cm</td>
                                                        <td>Brown</td>
                                                        <td>7451725</td>
                                                        <td>1</td>
                                                        <td>$13</td>
                                                        <td><i data-feather="more-vertical"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="#"><img class="img-fluid img-30"
                                                                    src="../assets/images/product/12.png" alt="#" /></a>
                                                        </td>
                                                        <td>
                                                            <div class="product-name">
                                                                <a href="#">Ledis Slipper</a>
                                                                <div class="order-process"><span
                                                                        class="order-process-circle shipped-order"></span>Shipped
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>6</td>
                                                        <td>Brown & white</td>
                                                        <td>4127421</td>
                                                        <td>1</td>
                                                        <td>$6</td>
                                                        <td><i data-feather="more-vertical"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="#"><img class="img-fluid img-30"
                                                                    src="../assets/images/product/3.png" alt="#" /></a>
                                                        </td>
                                                        <td>
                                                            <div class="product-name">
                                                                <a href="#">Fancy ledis Jacket</a>
                                                                <div class="order-process"><span
                                                                        class="order-process-circle shipped-order"></span>Shipped
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>Xl</td>
                                                        <td>Light gray</td>
                                                        <td>3581714</td>
                                                        <td>1</td>
                                                        <td>$24</td>
                                                        <td><i data-feather="more-vertical"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="#"><img class="img-fluid img-30"
                                                                    src="../assets/images/product/2.png" alt="#" /></a>
                                                        </td>
                                                        <td>
                                                            <div class="product-name">
                                                                <a href="#">Ledis Handbag</a>
                                                                <div class="order-process"><span
                                                                        class="order-process-circle shipped-order"></span>Shipped
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>25cm x 20cm</td>
                                                        <td>Black</td>
                                                        <td>6748142</td>
                                                        <td>1</td>
                                                        <td>$14</td>
                                                        <td><i data-feather="more-vertical"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="#"><img class="img-fluid img-30"
                                                                    src="../assets/images/product/15.png" alt="#" /></a>
                                                        </td>
                                                        <td>
                                                            <div class="product-name">
                                                                <a href="#">Iphone6 mobile</a>
                                                                <div class="order-process"><span
                                                                        class="order-process-circle cancel-order"></span>Cancelled
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>10cm x 15cm</td>
                                                        <td>Black</td>
                                                        <td>5748214</td>
                                                        <td>1</td>
                                                        <td>$25</td>
                                                        <td><i data-feather="more-vertical"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="#"><img class="img-fluid img-30"
                                                                    src="../assets/images/product/14.png" alt="#" /></a>
                                                        </td>
                                                        <td>
                                                            <div class="product-name">
                                                                <a href="#">Watch</a>
                                                                <div class="order-process"><span
                                                                        class="order-process-circle cancel-order"></span>Cancelled
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>27mm</td>
                                                        <td>Brown</td>
                                                        <td>2471254</td>
                                                        <td>1</td>
                                                        <td>$12</td>
                                                        <td><i data-feather="more-vertical"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="#"><img class="img-fluid img-30"
                                                                    src="../assets/images/product/11.png" alt="#" /></a>
                                                        </td>
                                                        <td>
                                                            <div class="product-name">
                                                                <a href="#">Slipper</a>
                                                                <div class="order-process"><span
                                                                        class="order-process-circle cancel-order"></span>Cancelled
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>6</td>
                                                        <td>Blue</td>
                                                        <td>8475112</td>
                                                        <td>1</td>
                                                        <td>$6</td>
                                                        <td><i data-feather="more-vertical"></i></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

                    <!-- Container-fluid starts-->
                    <div class="container-fluid">
                        <div class="page-header">

                        </div>
                    </div>
                    <div class="container-fluid product-wrapper">
                        <div class="product-grid">
                            <div class="feature-products">
                                <div class="row m-b-10">
                                    <div class="col-md-3 col-sm-2 products-total">
                                        <div class="square-product-setting d-inline-block">
                                            <a class="icon-grid grid-layout-view" href="javascript:void(0)"
                                                data-original-title="" title=""><i data-feather="grid"></i></a>
                                        </div>
                                        <div class="square-product-setting d-inline-block">
                                            <a class="icon-grid m-0 list-layout-view" href="javascript:void(0)"
                                                data-original-title="" title=""><i data-feather="list"></i></a>
                                        </div>
                                        <div class="d-none-productlist filter-toggle">
                                            <h6 class="mb-0">
                                                Filters<span class="ms-2"><i class="toggle-data"
                                                        data-feather="chevron-down"></i></span>
                                            </h6>
                                        </div>
                                        <div class="grid-options d-inline-block">
                                            <ul>
                                                <li>
                                                    <a class="product-2-layout-view" href="javascript:void(0)"
                                                        data-original-title="" title=""><span
                                                            class="line-grid line-grid-1 bg-primary"></span><span
                                                            class="line-grid line-grid-2 bg-primary"></span></a>
                                                </li>
                                                <li>
                                                    <a class="product-3-layout-view" href="javascript:void(0)"
                                                        data-original-title="" title="">
                                                        <span class="line-grid line-grid-3 bg-primary"></span><span
                                                            class="line-grid line-grid-4 bg-primary"></span><span
                                                            class="line-grid line-grid-5 bg-primary"></span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="product-4-layout-view" href="javascript:void(0)"
                                                        data-original-title="" title="">
                                                        <span class="line-grid line-grid-6 bg-primary"></span><span
                                                            class="line-grid line-grid-7 bg-primary"></span><span
                                                            class="line-grid line-grid-8 bg-primary"></span>
                                                        <span class="line-grid line-grid-9 bg-primary"></span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="product-6-layout-view" href="javascript:void(0)"
                                                        data-original-title="" title="">
                                                        <span class="line-grid line-grid-10 bg-primary"></span><span
                                                            class="line-grid line-grid-11 bg-primary"></span><span
                                                            class="line-grid line-grid-12 bg-primary"></span>
                                                        <span class="line-grid line-grid-13 bg-primary"></span><span
                                                            class="line-grid line-grid-14 bg-primary"></span><span
                                                            class="line-grid line-grid-15 bg-primary"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-sm-10 text-end">
                                        <span class="f-w-600 m-r-5">Showing Products 1 - 24 Of 200 Results</span>
                                        <div class="select2-drpdwn-product select-options d-inline-block">
                                            <select class="form-control btn-square" name="select">
                                                <option value="opt1">Featured</option>
                                                <option value="opt2">Lowest Prices</option>
                                                <option value="opt3">Highest Prices</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pro-filter-sec">
                                            <div class="product-sidebar">
                                                <div class="filter-section">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h6 class="mb-0 f-w-600">
                                                                Filters<span class="pull-right"><i
                                                                        class="fa fa-chevron-down toggle-data"></i></span>
                                                            </h6>
                                                        </div>
                                                        <div class="left-filter">
                                                            <div class="card-body filter-cards-view animate-chk">
                                                                <div class="product-filter">
                                                                    <h6 class="f-w-600">Category</h6>
                                                                    <div class="checkbox-animated mt-0">
                                                                        <label class="d-block" for="edo-ani5">
                                                                            <input class="radio_animated" id="edo-ani5"
                                                                                type="radio" data-original-title=""
                                                                                title="" />Man Shirt </label>
                                                                        <label class="d-block" for="edo-ani6">
                                                                            <input class="radio_animated" id="edo-ani6"
                                                                                type="radio" data-original-title=""
                                                                                title="" />Man Jeans </label>
                                                                        <label class="d-block" for="edo-ani7">
                                                                            <input class="radio_animated" id="edo-ani7"
                                                                                type="radio" data-original-title=""
                                                                                title="" />Woman Top </label>
                                                                        <label class="d-block" for="edo-ani8">
                                                                            <input class="radio_animated" id="edo-ani8"
                                                                                type="radio" data-original-title=""
                                                                                title="" />Woman Jeans </label>
                                                                        <label class="d-block" for="edo-ani9">
                                                                            <input class="radio_animated" id="edo-ani9"
                                                                                type="radio" data-original-title=""
                                                                                title="" />Man T-shirt </label>
                                                                    </div>
                                                                </div>
                                                                <div class="product-filter">
                                                                    <h6 class="f-w-600">Brand</h6>
                                                                    <div class="checkbox-animated mt-0">
                                                                        <label class="d-block" for="chk-ani">
                                                                            <input class="checkbox_animated" id="chk-ani"
                                                                                type="checkbox" data-original-title=""
                                                                                title="" />
                                                                            Levi's </label>
                                                                        <label class="d-block" for="chk-ani1">
                                                                            <input class="checkbox_animated" id="chk-ani1"
                                                                                type="checkbox" data-original-title=""
                                                                                title="" />Diesel
                                                                        </label>
                                                                        <label class="d-block" for="chk-ani2">
                                                                            <input class="checkbox_animated" id="chk-ani2"
                                                                                type="checkbox" data-original-title=""
                                                                                title="" />Lee
                                                                        </label>
                                                                        <label class="d-block" for="chk-ani3">
                                                                            <input class="checkbox_animated" id="chk-ani3"
                                                                                type="checkbox" data-original-title=""
                                                                                title="" />Hudson
                                                                        </label>
                                                                        <label class="d-block" for="chk-ani4">
                                                                            <input class="checkbox_animated" id="chk-ani4"
                                                                                type="checkbox" data-original-title=""
                                                                                title="" />Denizen </label>
                                                                        <label class="d-block" for="chk-ani5">
                                                                            <input class="checkbox_animated" id="chk-ani5"
                                                                                type="checkbox" data-original-title=""
                                                                                title="" />Spykar
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="product-filter slider-product">
                                                                    <h6 class="f-w-600">Colors</h6>
                                                                    <div class="color-selector">
                                                                        <ul>
                                                                            <li class="white"></li>
                                                                            <li class="gray"></li>
                                                                            <li class="black"></li>
                                                                            <li class="orange"></li>
                                                                            <li class="green"></li>
                                                                            <li class="pink"></li>
                                                                            <li class="yellow"></li>
                                                                            <li class="blue"></li>
                                                                            <li class="red"></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="product-filter pb-0">
                                                                    <h6 class="f-w-600">Price</h6>
                                                                    <input id="u-range-03" type="text" />
                                                                    <h6 class="f-w-600">New Products</h6>
                                                                </div>
                                                                <div class="product-filter pb-0 new-products">
                                                                    <div class="owl-carousel owl-theme" id="testimonial">
                                                                        <div class="item">
                                                                            <div class="product-box">
                                                                                <div class="media">
                                                                                    <div class="product-img me-3"><img
                                                                                            class="img-fluid"
                                                                                            src="../assets/images/ecommerce/01.jpg"
                                                                                            alt="" data-original-title=""
                                                                                            title="" /></div>
                                                                                    <div class="media-body">
                                                                                        <div class="product-details">
                                                                                            <div>
                                                                                                <ul>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                </ul>
                                                                                                <p class="mb-0 f-w-700">
                                                                                                    Fancy Shirt</p>
                                                                                                <div
                                                                                                    class="f-w-500">
                                                                                                    $100.00
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-box">
                                                                                <div class="media">
                                                                                    <div class="product-img me-3"><img
                                                                                            class="img-fluid"
                                                                                            src="../assets/images/ecommerce/02.jpg"
                                                                                            alt="" data-original-title=""
                                                                                            title="" /></div>
                                                                                    <div class="media-body">
                                                                                        <div class="product-details">
                                                                                            <div>
                                                                                                <ul>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                </ul>
                                                                                                <p class="mb-0 f-w-700">
                                                                                                    Fancy Shirt</p>
                                                                                                <div
                                                                                                    class="f-w-500">
                                                                                                    $100.00
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-box">
                                                                                <div class="media">
                                                                                    <div class="product-img me-3"><img
                                                                                            class="img-fluid"
                                                                                            src="../assets/images/ecommerce/03.jpg"
                                                                                            alt="" data-original-title=""
                                                                                            title="" /></div>
                                                                                    <div class="media-body">
                                                                                        <div class="product-details">
                                                                                            <div>
                                                                                                <ul>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                </ul>
                                                                                                <p class="mb-0 f-w-700">
                                                                                                    Fancy Shirt</p>
                                                                                                <div
                                                                                                    class="f-w-500">
                                                                                                    $100.00
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item">
                                                                            <div class="product-box">
                                                                                <div class="media">
                                                                                    <div class="product-img me-3"><img
                                                                                            class="img-fluid"
                                                                                            src="../assets/images/ecommerce/01.jpg"
                                                                                            alt="" data-original-title=""
                                                                                            title="" /></div>
                                                                                    <div class="media-body">
                                                                                        <div class="product-details">
                                                                                            <div>
                                                                                                <ul>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                </ul>
                                                                                                <p class="mb-0 f-w-700">
                                                                                                    Fancy Shirt</p>
                                                                                                <div
                                                                                                    class="f-w-500">
                                                                                                    $100.00
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-box">
                                                                                <div class="media">
                                                                                    <div class="product-img me-3"><img
                                                                                            class="img-fluid"
                                                                                            src="../assets/images/ecommerce/02.jpg"
                                                                                            alt="" data-original-title=""
                                                                                            title="" /></div>
                                                                                    <div class="media-body">
                                                                                        <div class="product-details">
                                                                                            <div>
                                                                                                <ul>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                </ul>
                                                                                                <p class="mb-0 f-w-700">
                                                                                                    Fancy Shirt</p>
                                                                                                <div
                                                                                                    class="f-w-500">
                                                                                                    $100.00
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-box">
                                                                                <div class="media">
                                                                                    <div class="product-img me-3"><img
                                                                                            class="img-fluid"
                                                                                            src="../assets/images/ecommerce/03.jpg"
                                                                                            alt="" data-original-title=""
                                                                                            title="" /></div>
                                                                                    <div class="media-body">
                                                                                        <div class="product-details">
                                                                                            <div>
                                                                                                <ul>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                    <li><i
                                                                                                            class="fa fa-star font-warning"></i>
                                                                                                    </li>
                                                                                                </ul>
                                                                                                <p class="mb-0 f-w-700">
                                                                                                    Fancy Shirt</p>
                                                                                                <div
                                                                                                    class="f-w-500">
                                                                                                    $100.00
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="product-filter text-center"><img
                                                                        class="img-fluid banner-product"
                                                                        src="../assets/images/ecommerce/banner.jpg" alt=""
                                                                        data-original-title="" title="" /></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-search">
                                                <form>
                                                    <div class="form-group m-0"><input class="form-control"
                                                            type="search" placeholder="Search.." data-original-title=""
                                                            title="" /><i class="fa fa-search"></i></div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-wrapper-grid">
                                <div class="row">
                                    <div class="col-xl-3 col-sm-6 xl-4">
                                        <div class="card">
                                            <div class="product-box">
                                                <div class="product-img">
                                                    <img class="img-fluid" src="../assets/images/ecommerce/01.jpg"
                                                        alt="" />
                                                    <div class="product-hover">
                                                        <ul>
                                                            <li>
                                                                <a href="cart.html"><i class="icon-shopping-cart"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModalCenter16"><i
                                                                        class="icon-eye"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="exampleModalCenter16">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="product-box row">
                                                                    <div class="product-img col-lg-6"><img
                                                                            class="img-fluid"
                                                                            src="../assets/images/ecommerce/01.jpg"
                                                                            alt="" /></div>
                                                                    <div class="product-details col-lg-6 text-start">
                                                                        <a href="product-page.html">
                                                                            <h4>Man's Jacket</h4>
                                                                        </a>
                                                                        <div class="product-price">
                                                                            $26.00
                                                                            <del>$35.00</del>
                                                                        </div>
                                                                        <div class="product-view">
                                                                            <h6 class="f-w-600">Product Details
                                                                            </h6>
                                                                            <p class="mb-0">Sed ut
                                                                                perspiciatis, unde omnis
                                                                                iste natus error sit voluptatem
                                                                                accusantium
                                                                                doloremque laudantium, totam rem aperiam
                                                                                eaque ipsa, quae ab illo.</p>
                                                                        </div>
                                                                        <div class="product-size">
                                                                            <ul>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">M</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">L</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">Xl</button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="product-qnty">
                                                                            <h6 class="f-w-600">Quantity</h6>
                                                                            <fieldset>
                                                                                <div class="input-group">
                                                                                    <input class="touchspin text-center"
                                                                                        type="text" value="5" />
                                                                                </div>
                                                                            </fieldset>
                                                                            <div class="addcart-btn"><a
                                                                                    class="btn btn-primary me-3"
                                                                                    href="cart.html">Add to Cart </a><a
                                                                                    class="btn btn-primary"
                                                                                    href="product-page.html">View
                                                                                    Details</a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button class="btn-close" type="button"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-details">
                                                    <a href="product-page.html">
                                                        <h4>Man's Jacket</h4>
                                                    </a>
                                                    <p>Solid Denim Jacket</p>
                                                    <div class="product-price">
                                                        $26.00
                                                        <del>$35.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 xl-4">
                                        <div class="card">
                                            <div class="product-box">
                                                <div class="product-img">
                                                    <div class="ribbon ribbon-danger">Sale</div>
                                                    <img class="img-fluid" src="../assets/images/ecommerce/02.jpg"
                                                        alt="" />
                                                    <div class="product-hover">
                                                        <ul>
                                                            <li>
                                                                <a href="cart.html"><i class="icon-shopping-cart"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModalCenter1"><i
                                                                        class="icon-eye"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="exampleModalCenter1">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="product-box row">
                                                                    <div class="product-img col-lg-6"><img
                                                                            class="img-fluid"
                                                                            src="../assets/images/ecommerce/02.jpg"
                                                                            alt="" /></div>
                                                                    <div class="product-details col-lg-6 text-start">
                                                                        <a href="product-page.html">
                                                                            <h4>fido dido</h4>
                                                                        </a>
                                                                        <div class="product-price">
                                                                            $55.00
                                                                            <del>$62.00 </del>
                                                                        </div>
                                                                        <div class="product-view">
                                                                            <h6 class="f-w-600">Product Details
                                                                            </h6>
                                                                            <p class="mb-0">Sed ut
                                                                                perspiciatis, unde omnis
                                                                                iste natus error sit voluptatem
                                                                                accusantium
                                                                                doloremque laudantium, totam rem aperiam
                                                                                eaque ipsa, quae ab illo.</p>
                                                                        </div>
                                                                        <div class="product-size">
                                                                            <ul>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">M</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">L</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">Xl</button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="product-qnty">
                                                                            <h6 class="f-w-600">Quantity</h6>
                                                                            <fieldset>
                                                                                <div class="input-group">
                                                                                    <input class="touchspin text-center"
                                                                                        type="text" value="5" />
                                                                                </div>
                                                                            </fieldset>
                                                                            <div class="addcart-btn"><a
                                                                                    class="btn btn-primary me-3"
                                                                                    href="cart.html">Add to Cart</a><a
                                                                                    class="btn btn-primary"
                                                                                    href="product-page.html">View
                                                                                    Details</a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button class="btn-close" type="button"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-details">
                                                    <a href="product-page.html">
                                                        <h4>fido dido</h4>
                                                    </a>
                                                    <p>Solid Polo Collar T-shirt</p>
                                                    <div class="product-price">
                                                        $55.00
                                                        <del>$62.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 xl-4">
                                        <div class="card">
                                            <div class="product-box">
                                                <div class="product-img">
                                                    <img class="img-fluid" src="../assets/images/ecommerce/03.jpg"
                                                        alt="" />
                                                    <div class="product-hover">
                                                        <ul>
                                                            <li>
                                                                <a href="cart.html"><i class="icon-shopping-cart"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModalCenter2"><i
                                                                        class="icon-eye"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="exampleModalCenter2">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="product-box row">
                                                                    <div class="product-img col-lg-6"><img
                                                                            class="img-fluid"
                                                                            src="../assets/images/ecommerce/03.jpg"
                                                                            alt="" /></div>
                                                                    <div class="product-details col-lg-6 text-start">
                                                                        <a href="product-page.html">
                                                                            <h4>Wonder Woman</h4>
                                                                        </a>
                                                                        <div class="product-price">
                                                                            $45.00
                                                                            <del>$52.00</del>
                                                                        </div>
                                                                        <div class="product-view">
                                                                            <h6 class="f-w-600">Product Details
                                                                            </h6>
                                                                            <p class="mb-0">Sed ut
                                                                                perspiciatis, unde omnis
                                                                                iste natus error sit voluptatem
                                                                                accusantium
                                                                                doloremque laudantium, totam rem aperiam
                                                                                eaque ipsa, quae ab illo.</p>
                                                                        </div>
                                                                        <div class="product-size">
                                                                            <ul>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">M</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">L</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">Xl</button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="product-qnty">
                                                                            <h6 class="f-w-600">Quantity</h6>
                                                                            <fieldset>
                                                                                <div class="input-group">
                                                                                    <input class="touchspin text-center"
                                                                                        type="text" value="5" />
                                                                                </div>
                                                                            </fieldset>
                                                                            <div class="addcart-btn"><a
                                                                                    class="btn btn-primary me-3"
                                                                                    href="cart.html">Add to Cart</a><a
                                                                                    class="btn btn-primary"
                                                                                    href="product-page.html">View
                                                                                    Details</a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button class="btn-close" type="button"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-details">
                                                    <a href="product-page.html">
                                                        <h4>Wonder Woman</h4>
                                                    </a>
                                                    <p>Woman Gray Round T-shirt</p>
                                                    <div class="product-price">
                                                        $45.00
                                                        <del>$52.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 xl-4">
                                        <div class="card">
                                            <div class="product-box">
                                                <div class="product-img">
                                                    <div class="ribbon ribbon-success ribbon-right">50%</div>
                                                    <img class="img-fluid" src="../assets/images/ecommerce/04.jpg"
                                                        alt="" />
                                                    <div class="product-hover">
                                                        <ul>
                                                            <li>
                                                                <a href="cart.html"><i class="icon-shopping-cart"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModalCenter3"><i
                                                                        class="icon-eye"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="exampleModalCenter3">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="product-box row">
                                                                    <div class="product-img col-lg-6"><img
                                                                            class="img-fluid"
                                                                            src="../assets/images/ecommerce/04.jpg"
                                                                            alt="" /></div>
                                                                    <div class="product-details col-lg-6 text-start">
                                                                        <a href="product-page.html">
                                                                            <h4>Roadster</h4>
                                                                        </a>
                                                                        <div class="product-price">
                                                                            $38.00
                                                                            <del>$45.00 </del>
                                                                        </div>
                                                                        <div class="product-view">
                                                                            <h6 class="f-w-600">Product Details
                                                                            </h6>
                                                                            <p class="mb-0">Sed ut
                                                                                perspiciatis, unde omnis
                                                                                iste natus error sit voluptatem
                                                                                accusantium
                                                                                doloremque laudantium, totam rem aperiam
                                                                                eaque ipsa, quae ab illo.</p>
                                                                        </div>
                                                                        <div class="product-size">
                                                                            <ul>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">M</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">L</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">Xl</button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="product-qnty">
                                                                            <h6 class="f-w-600">Quantity</h6>
                                                                            <fieldset>
                                                                                <div class="input-group">
                                                                                    <input class="touchspin text-center"
                                                                                        type="text" value="5" />
                                                                                </div>
                                                                            </fieldset>
                                                                            <div class="addcart-btn"><a
                                                                                    class="btn btn-primary me-3"
                                                                                    href="cart.html">Add to Cart</a><a
                                                                                    class="btn btn-primary"
                                                                                    href="product-page.html">View
                                                                                    Details</a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button class="btn-close" type="button"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-details">
                                                    <a href="product-page.html">
                                                        <h4>Roadster</h4>
                                                    </a>
                                                    <p>Women Solid Denim Jacket</p>
                                                    <div class="product-price">
                                                        $38.00
                                                        <del>$45.00 </del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 xl-4">
                                        <div class="card">
                                            <div class="product-box">
                                                <div class="product-img">
                                                    <div class="ribbon ribbon-success ribbon-right">50%</div>
                                                    <img class="img-fluid" src="../assets/images/ecommerce/04.jpg"
                                                        alt="" />
                                                    <div class="product-hover">
                                                        <ul>
                                                            <li>
                                                                <a href="cart.html"><i class="icon-shopping-cart"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModalCenter4"><i
                                                                        class="icon-eye"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="exampleModalCenter4">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="product-box row">
                                                                    <div class="product-img col-lg-6"><img
                                                                            class="img-fluid"
                                                                            src="../assets/images/ecommerce/04.jpg"
                                                                            alt="" /></div>
                                                                    <div class="product-details col-lg-6 text-start">
                                                                        <a href="product-page.html">
                                                                            <h4>Roadster</h4>
                                                                        </a>
                                                                        <div class="product-price">
                                                                            $38.00
                                                                            <del>$45.00 </del>
                                                                        </div>
                                                                        <div class="product-view">
                                                                            <h6 class="f-w-600">Product Details
                                                                            </h6>
                                                                            <p class="mb-0">Sed ut
                                                                                perspiciatis, unde omnis
                                                                                iste natus error sit voluptatem
                                                                                accusantium
                                                                                doloremque laudantium, totam rem aperiam
                                                                                eaque ipsa, quae ab illo.</p>
                                                                        </div>
                                                                        <div class="product-size">
                                                                            <ul>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">M</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">L</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">Xl</button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="product-qnty">
                                                                            <h6 class="f-w-600">Quantity</h6>
                                                                            <fieldset>
                                                                                <div class="input-group">
                                                                                    <input class="touchspin text-center"
                                                                                        type="text" value="5" />
                                                                                </div>
                                                                            </fieldset>
                                                                            <div class="addcart-btn"><a
                                                                                    class="btn btn-primary me-3"
                                                                                    href="cart.html">Add to Cart</a><a
                                                                                    class="btn btn-primary"
                                                                                    href="product-page.html">View
                                                                                    Details</a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button class="btn-close" type="button"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-details">
                                                    <a href="product-page.html">
                                                        <h4>Roadster</h4>
                                                    </a>
                                                    <p>Women Solid Denim Jacket</p>
                                                    <div class="product-price">
                                                        $38.00
                                                        <del>$45.00 </del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 xl-4">
                                        <div class="card">
                                            <div class="product-box">
                                                <div class="product-img">
                                                    <img class="img-fluid" src="../assets/images/ecommerce/01.jpg"
                                                        alt="" />
                                                    <div class="product-hover">
                                                        <ul>
                                                            <li>
                                                                <a href="cart.html"><i class="icon-shopping-cart"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModalCenter5"><i
                                                                        class="icon-eye"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="exampleModalCenter5">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="product-box row">
                                                                    <div class="product-img col-lg-6"><img
                                                                            class="img-fluid"
                                                                            src="../assets/images/ecommerce/01.jpg"
                                                                            alt="" /></div>
                                                                    <div class="product-details col-lg-6 text-start">
                                                                        <a href="product-page.html">
                                                                            <h4>Man's Jacket</h4>
                                                                        </a>
                                                                        <div class="product-price">
                                                                            $26.00
                                                                            <del>$35.00</del>
                                                                        </div>
                                                                        <div class="product-view">
                                                                            <h6 class="f-w-600">Product Details
                                                                            </h6>
                                                                            <p class="mb-0">Sed ut
                                                                                perspiciatis, unde omnis
                                                                                iste natus error sit voluptatem
                                                                                accusantium
                                                                                doloremque laudantium, totam rem aperiam
                                                                                eaque ipsa, quae ab illo.</p>
                                                                        </div>
                                                                        <div class="product-size">
                                                                            <ul>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">M</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">L</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">Xl</button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="product-qnty">
                                                                            <h6 class="f-w-600">Quantity</h6>
                                                                            <fieldset>
                                                                                <div class="input-group">
                                                                                    <input class="touchspin text-center"
                                                                                        type="text" value="5" />
                                                                                </div>
                                                                            </fieldset>
                                                                            <div class="addcart-btn"><a
                                                                                    class="btn btn-primary me-3"
                                                                                    href="cart.html">Add to Cart</a><a
                                                                                    class="btn btn-primary"
                                                                                    href="product-page.html">View
                                                                                    Details</a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button class="btn-close" type="button"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-details">
                                                    <a href="product-page.html">
                                                        <h4>Man's Jacket</h4>
                                                    </a>
                                                    <p>Solid Denim Jacket</p>
                                                    <div class="product-price">
                                                        $26.00
                                                        <del>$35.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 xl-4">
                                        <div class="card">
                                            <div class="product-box">
                                                <div class="product-img">
                                                    <div class="ribbon ribbon-danger">Sale</div>
                                                    <img class="img-fluid" src="../assets/images/ecommerce/02.jpg"
                                                        alt="" />
                                                    <div class="product-hover">
                                                        <ul>
                                                            <li>
                                                                <a href="cart.html"><i class="icon-shopping-cart"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModalCenter6"><i
                                                                        class="icon-eye"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="exampleModalCenter6" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalCenter1" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="product-box row">
                                                                    <div class="product-img col-lg-6"><img
                                                                            class="img-fluid"
                                                                            src="../assets/images/ecommerce/02.jpg"
                                                                            alt="" /></div>
                                                                    <div class="product-details col-lg-6 text-start">
                                                                        <a href="product-page.html">
                                                                            <h4>fido dido</h4>
                                                                        </a>
                                                                        <div class="product-price">
                                                                            $55.00
                                                                            <del>$62.00 </del>
                                                                        </div>
                                                                        <div class="product-view">
                                                                            <h6 class="f-w-600">Product Details
                                                                            </h6>
                                                                            <p class="mb-0">Sed ut
                                                                                perspiciatis, unde omnis
                                                                                iste natus error sit voluptatem
                                                                                accusantium
                                                                                doloremque laudantium, totam rem aperiam
                                                                                eaque ipsa, quae ab illo.</p>
                                                                        </div>
                                                                        <div class="product-size">
                                                                            <ul>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">M</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">L</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">Xl</button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="product-qnty">
                                                                            <h6 class="f-w-600">Quantity</h6>
                                                                            <fieldset>
                                                                                <div class="input-group">
                                                                                    <input class="touchspin text-center"
                                                                                        type="text" value="5" />
                                                                                </div>
                                                                            </fieldset>
                                                                            <div class="addcart-btn"><a
                                                                                    class="btn btn-primary me-3"
                                                                                    href="cart.html">Add to Cart</a><a
                                                                                    class="btn btn-primary"
                                                                                    href="product-page.html">View
                                                                                    Details</a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button class="btn-close" type="button"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-details">
                                                    <a href="product-page.html">
                                                        <h4>fido dido</h4>
                                                    </a>
                                                    <p>Solid Polo Collar T-shirt</p>
                                                    <div class="product-price">
                                                        $55.00
                                                        <del>$62.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 xl-4">
                                        <div class="card">
                                            <div class="product-box">
                                                <div class="product-img">
                                                    <img class="img-fluid" src="../assets/images/ecommerce/03.jpg"
                                                        alt="" />
                                                    <div class="product-hover">
                                                        <ul>
                                                            <li>
                                                                <a href="cart.html"><i class="icon-shopping-cart"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModalCenter7"><i
                                                                        class="icon-eye"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="exampleModalCenter7" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalCenter2" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="product-box row">
                                                                    <div class="product-img col-lg-6"><img
                                                                            class="img-fluid"
                                                                            src="../assets/images/ecommerce/03.jpg"
                                                                            alt="" /></div>
                                                                    <div class="product-details col-lg-6 text-start">
                                                                        <a href="product-page.html">
                                                                            <h4>Wonder Woman</h4>
                                                                        </a>
                                                                        <div class="product-price">
                                                                            $45.00
                                                                            <del>$52.00</del>
                                                                        </div>
                                                                        <div class="product-view">
                                                                            <h6 class="f-w-600">Product Details
                                                                            </h6>
                                                                            <p class="mb-0">Sed ut
                                                                                perspiciatis, unde omnis
                                                                                iste natus error sit voluptatem
                                                                                accusantium
                                                                                doloremque laudantium, totam rem aperiam
                                                                                eaque ipsa, quae ab illo.</p>
                                                                        </div>
                                                                        <div class="product-size">
                                                                            <ul>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">M</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">L</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">Xl</button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="product-qnty">
                                                                            <h6 class="f-w-600">Quantity</h6>
                                                                            <fieldset>
                                                                                <div class="input-group">
                                                                                    <input class="touchspin text-center"
                                                                                        type="text" value="5" />
                                                                                </div>
                                                                            </fieldset>
                                                                            <div class="addcart-btn"><a
                                                                                    class="btn btn-primary me-3"
                                                                                    href="cart.html">Add to Cart</a><a
                                                                                    class="btn btn-primary"
                                                                                    href="product-page.html">View
                                                                                    Details</a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button class="btn-close" type="button"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-details">
                                                    <a href="product-page.html">
                                                        <h4>Wonder Woman</h4>
                                                    </a>
                                                    <p>Woman Gray Round T-shirt</p>
                                                    <div class="product-price">
                                                        $45.00
                                                        <del>$52.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 xl-4">
                                        <div class="card">
                                            <div class="product-box">
                                                <div class="product-img">
                                                    <img class="img-fluid" src="../assets/images/ecommerce/03.jpg"
                                                        alt="" />
                                                    <div class="product-hover">
                                                        <ul>
                                                            <li>
                                                                <a href="cart.html"><i class="icon-shopping-cart"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModalCenter8"><i
                                                                        class="icon-eye"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="exampleModalCenter8" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalCenter2" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="product-box row">
                                                                    <div class="product-img col-lg-6"><img
                                                                            class="img-fluid"
                                                                            src="../assets/images/ecommerce/03.jpg"
                                                                            alt="" /></div>
                                                                    <div class="product-details col-lg-6 text-start">
                                                                        <a href="product-page.html">
                                                                            <h4>Wonder Woman</h4>
                                                                        </a>
                                                                        <div class="product-price">
                                                                            $45.00
                                                                            <del>$52.00</del>
                                                                        </div>
                                                                        <div class="product-view">
                                                                            <h6 class="f-w-600">Product Details
                                                                            </h6>
                                                                            <p class="mb-0">Sed ut
                                                                                perspiciatis, unde omnis
                                                                                iste natus error sit voluptatem
                                                                                accusantium
                                                                                doloremque laudantium, totam rem aperiam
                                                                                eaque ipsa, quae ab illo.</p>
                                                                        </div>
                                                                        <div class="product-size">
                                                                            <ul>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">M</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">L</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">Xl</button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="product-qnty">
                                                                            <h6 class="f-w-600">Quantity</h6>
                                                                            <fieldset>
                                                                                <div class="input-group">
                                                                                    <input class="touchspin text-center"
                                                                                        type="text" value="5" />
                                                                                </div>
                                                                            </fieldset>
                                                                            <div class="addcart-btn"><a
                                                                                    class="btn btn-primary me-3"
                                                                                    href="cart.html">Add to Cart</a><a
                                                                                    class="btn btn-primary"
                                                                                    href="product-page.html">View
                                                                                    Details</a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button class="btn-close" type="button"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-details">
                                                    <a href="product-page.html">
                                                        <h4>Wonder Woman</h4>
                                                    </a>
                                                    <p>Woman Gray Round T-shirt</p>
                                                    <div class="product-price">
                                                        $45.00
                                                        <del>$52.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 xl-4">
                                        <div class="card">
                                            <div class="product-box">
                                                <div class="product-img">
                                                    <div class="ribbon ribbon-success ribbon-right">50%</div>
                                                    <img class="img-fluid" src="../assets/images/ecommerce/04.jpg"
                                                        alt="" />
                                                    <div class="product-hover">
                                                        <ul>
                                                            <li>
                                                                <a href="cart.html"><i class="icon-shopping-cart"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModalCenter9"><i
                                                                        class="icon-eye"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="exampleModalCenter9" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalCenter3" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="product-box row">
                                                                    <div class="product-img col-lg-6"><img
                                                                            class="img-fluid"
                                                                            src="../assets/images/ecommerce/04.jpg"
                                                                            alt="" /></div>
                                                                    <div class="product-details col-lg-6 text-start">
                                                                        <a href="product-page.html">
                                                                            <h4>Roadster</h4>
                                                                        </a>
                                                                        <div class="product-price">
                                                                            $38.00
                                                                            <del>$45.00 </del>
                                                                        </div>
                                                                        <div class="product-view">
                                                                            <h6 class="f-w-600">Product Details
                                                                            </h6>
                                                                            <p class="mb-0">Sed ut
                                                                                perspiciatis, unde omnis
                                                                                iste natus error sit voluptatem
                                                                                accusantium
                                                                                doloremque laudantium, totam rem aperiam
                                                                                eaque ipsa, quae ab illo.</p>
                                                                        </div>
                                                                        <div class="product-size">
                                                                            <ul>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">M</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">L</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">Xl</button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="product-qnty">
                                                                            <h6 class="f-w-600">Quantity</h6>
                                                                            <fieldset>
                                                                                <div class="input-group">
                                                                                    <input class="touchspin text-center"
                                                                                        type="text" value="5" />
                                                                                </div>
                                                                            </fieldset>
                                                                            <div class="addcart-btn"><a
                                                                                    class="btn btn-primary me-3"
                                                                                    href="cart.html">Add to Cart</a><a
                                                                                    class="btn btn-primary"
                                                                                    href="product-page.html">View
                                                                                    Details</a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button class="btn-close" type="button"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-details">
                                                    <a href="product-page.html">
                                                        <h4>Roadster</h4>
                                                    </a>
                                                    <p>Women Solid Denim Jacket</p>
                                                    <div class="product-price">
                                                        $38.00
                                                        <del>$45.00 </del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 xl-4">
                                        <div class="card">
                                            <div class="product-box">
                                                <div class="product-img">
                                                    <img class="img-fluid" src="../assets/images/ecommerce/01.jpg"
                                                        alt="" />
                                                    <div class="product-hover">
                                                        <ul>
                                                            <li>
                                                                <a href="cart.html"><i class="icon-shopping-cart"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModalCenter10"><i
                                                                        class="icon-eye"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="exampleModalCenter10">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="product-box row">
                                                                    <div class="product-img col-lg-6"><img
                                                                            class="img-fluid"
                                                                            src="../assets/images/ecommerce/01.jpg"
                                                                            alt="" /></div>
                                                                    <div class="product-details col-lg-6 text-start">
                                                                        <a href="product-page.html">
                                                                            <h4>Man's Jacket</h4>
                                                                        </a>
                                                                        <div class="product-price">
                                                                            $26.00
                                                                            <del>$35.00</del>
                                                                        </div>
                                                                        <div class="product-view">
                                                                            <h6 class="f-w-600">Product Details
                                                                            </h6>
                                                                            <p class="mb-0">Sed ut
                                                                                perspiciatis, unde omnis
                                                                                iste natus error sit voluptatem
                                                                                accusantium
                                                                                doloremque laudantium, totam rem aperiam
                                                                                eaque ipsa, quae ab illo.</p>
                                                                        </div>
                                                                        <div class="product-size">
                                                                            <ul>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">M</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">L</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">Xl</button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="product-qnty">
                                                                            <h6 class="f-w-600">Quantity</h6>
                                                                            <fieldset>
                                                                                <div class="input-group">
                                                                                    <input class="touchspin text-center"
                                                                                        type="text" value="5" />
                                                                                </div>
                                                                            </fieldset>
                                                                            <div class="addcart-btn"><a
                                                                                    class="btn btn-primary me-3"
                                                                                    href="cart.html">Add to Cart</a><a
                                                                                    class="btn btn-primary"
                                                                                    href="product-page.html">View
                                                                                    Details</a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button class="btn-close" type="button"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-details">
                                                    <a href="product-page.html">
                                                        <h4>Man's Jacket</h4>
                                                    </a>
                                                    <p>Solid Denim Jacket</p>
                                                    <div class="product-price">
                                                        $26.00
                                                        <del>$35.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 xl-4">
                                        <div class="card">
                                            <div class="product-box">
                                                <div class="product-img">
                                                    <div class="ribbon ribbon-danger">Sale</div>
                                                    <img class="img-fluid" src="../assets/images/ecommerce/02.jpg"
                                                        alt="" />
                                                    <div class="product-hover">
                                                        <ul>
                                                            <li>
                                                                <a href="cart.html"><i class="icon-shopping-cart"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModalCenter11"><i
                                                                        class="icon-eye"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="exampleModalCenter11" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalCenter1" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="product-box row">
                                                                    <div class="product-img col-lg-6"><img
                                                                            class="img-fluid"
                                                                            src="../assets/images/ecommerce/02.jpg"
                                                                            alt="" /></div>
                                                                    <div class="product-details col-lg-6 text-start">
                                                                        <a href="product-page.html">
                                                                            <h4>fido dido</h4>
                                                                        </a>
                                                                        <div class="product-price">
                                                                            $55.00
                                                                            <del>$62.00 </del>
                                                                        </div>
                                                                        <div class="product-view">
                                                                            <h6 class="f-w-600">Product Details
                                                                            </h6>
                                                                            <p class="mb-0">Sed ut
                                                                                perspiciatis, unde omnis
                                                                                iste natus error sit voluptatem
                                                                                accusantium
                                                                                doloremque laudantium, totam rem aperiam
                                                                                eaque ipsa, quae ab illo.</p>
                                                                        </div>
                                                                        <div class="product-size">
                                                                            <ul>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">M</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">L</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">Xl</button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="product-qnty">
                                                                            <h6 class="f-w-600">Quantity</h6>
                                                                            <fieldset>
                                                                                <div class="input-group">
                                                                                    <input class="touchspin text-center"
                                                                                        type="text" value="5" />
                                                                                </div>
                                                                            </fieldset>
                                                                            <div class="addcart-btn"><a
                                                                                    class="btn btn-primary me-3"
                                                                                    href="cart.html">Add to Cart</a><a
                                                                                    class="btn btn-primary"
                                                                                    href="product-page.html">View
                                                                                    Details</a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button class="btn-close" type="button"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-details">
                                                    <a href="product-page.html">
                                                        <h4>fido dido</h4>
                                                    </a>
                                                    <p>Solid Polo Collar T-shirt</p>
                                                    <div class="product-price">
                                                        $55.00
                                                        <del>$62.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 xl-4">
                                        <div class="card">
                                            <div class="product-box">
                                                <div class="product-img">
                                                    <div class="ribbon ribbon-danger">Sale</div>
                                                    <img class="img-fluid" src="../assets/images/ecommerce/02.jpg"
                                                        alt="" />
                                                    <div class="product-hover">
                                                        <ul>
                                                            <li>
                                                                <a href="cart.html"><i class="icon-shopping-cart"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModalCenter12"><i
                                                                        class="icon-eye"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="exampleModalCenter12" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalCenter1" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="product-box row">
                                                                    <div class="product-img col-lg-6"><img
                                                                            class="img-fluid"
                                                                            src="../assets/images/ecommerce/02.jpg"
                                                                            alt="" /></div>
                                                                    <div class="product-details col-lg-6 text-start">
                                                                        <a href="product-page.html">
                                                                            <h4>fido dido</h4>
                                                                        </a>
                                                                        <div class="product-price">
                                                                            $55.00
                                                                            <del>$62.00 </del>
                                                                        </div>
                                                                        <div class="product-view">
                                                                            <h6 class="f-w-600">Product Details
                                                                            </h6>
                                                                            <p class="mb-0">Sed ut
                                                                                perspiciatis, unde omnis
                                                                                iste natus error sit voluptatem
                                                                                accusantium
                                                                                doloremque laudantium, totam rem aperiam
                                                                                eaque ipsa, quae ab illo.</p>
                                                                        </div>
                                                                        <div class="product-size">
                                                                            <ul>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">M</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">L</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">Xl</button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="product-qnty">
                                                                            <h6 class="f-w-600">Quantity</h6>
                                                                            <fieldset>
                                                                                <div class="input-group">
                                                                                    <input class="touchspin text-center"
                                                                                        type="text" value="5" />
                                                                                </div>
                                                                            </fieldset>
                                                                            <div class="addcart-btn"><a
                                                                                    class="btn btn-primary me-3"
                                                                                    href="cart.html">Add to Cart</a><a
                                                                                    class="btn btn-primary"
                                                                                    href="product-page.html">View
                                                                                    Details</a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button class="btn-close" type="button"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-details">
                                                    <a href="product-page.html">
                                                        <h4>fido dido</h4>
                                                    </a>
                                                    <p>Solid Polo Collar T-shirt</p>
                                                    <div class="product-price">
                                                        $55.00
                                                        <del>$62.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 xl-4">
                                        <div class="card">
                                            <div class="product-box">
                                                <div class="product-img">
                                                    <img class="img-fluid" src="../assets/images/ecommerce/03.jpg"
                                                        alt="" />
                                                    <div class="product-hover">
                                                        <ul>
                                                            <li>
                                                                <a href="cart.html"><i class="icon-shopping-cart"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModalCenter13"><i
                                                                        class="icon-eye"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="exampleModalCenter13" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalCenter2" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="product-box row">
                                                                    <div class="product-img col-lg-6"><img
                                                                            class="img-fluid"
                                                                            src="../assets/images/ecommerce/03.jpg"
                                                                            alt="" /></div>
                                                                    <div class="product-details col-lg-6 text-start">
                                                                        <a href="product-page.html">
                                                                            <h4>Wonder Woman</h4>
                                                                        </a>
                                                                        <div class="product-price">
                                                                            $45.00
                                                                            <del>$52.00</del>
                                                                        </div>
                                                                        <div class="product-view">
                                                                            <h6 class="f-w-600">Product Details
                                                                            </h6>
                                                                            <p class="mb-0">Sed ut
                                                                                perspiciatis, unde omnis
                                                                                iste natus error sit voluptatem
                                                                                accusantium
                                                                                doloremque laudantium, totam rem aperiam
                                                                                eaque ipsa, quae ab illo.</p>
                                                                        </div>
                                                                        <div class="product-size">
                                                                            <ul>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">M</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">L</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">Xl</button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="product-qnty">
                                                                            <h6 class="f-w-600">Quantity</h6>
                                                                            <fieldset>
                                                                                <div class="input-group">
                                                                                    <input class="touchspin text-center"
                                                                                        type="text" value="5" />
                                                                                </div>
                                                                            </fieldset>
                                                                            <div class="addcart-btn"><a
                                                                                    class="btn btn-primary me-3"
                                                                                    href="cart.html">Add to Cart</a><a
                                                                                    class="btn btn-primary"
                                                                                    href="product-page.html">View
                                                                                    Details</a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button class="btn-close" type="button"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-details">
                                                    <a href="product-page.html">
                                                        <h4>Wonder Woman</h4>
                                                    </a>
                                                    <p>Woman Gray Round T-shirt</p>
                                                    <div class="product-price">
                                                        $45.00
                                                        <del>$52.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 xl-4">
                                        <div class="card">
                                            <div class="product-box">
                                                <div class="product-img">
                                                    <div class="ribbon ribbon-success ribbon-right">50%</div>
                                                    <img class="img-fluid" src="../assets/images/ecommerce/04.jpg"
                                                        alt="" />
                                                    <div class="product-hover">
                                                        <ul>
                                                            <li>
                                                                <a href="cart.html"><i class="icon-shopping-cart"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModalCenter14"><i
                                                                        class="icon-eye"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="exampleModalCenter14" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalCenter3" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="product-box row">
                                                                    <div class="product-img col-lg-6"><img
                                                                            class="img-fluid"
                                                                            src="../assets/images/ecommerce/04.jpg"
                                                                            alt="" /></div>
                                                                    <div class="product-details col-lg-6 text-start">
                                                                        <a href="product-page.html">
                                                                            <h4>Roadster</h4>
                                                                        </a>
                                                                        <div class="product-price">
                                                                            $38.00
                                                                            <del>$45.00 </del>
                                                                        </div>
                                                                        <div class="product-view">
                                                                            <h6 class="f-w-600">Product Details
                                                                            </h6>
                                                                            <p class="mb-0">Sed ut
                                                                                perspiciatis, unde omnis
                                                                                iste natus error sit voluptatem
                                                                                accusantium
                                                                                doloremque laudantium, totam rem aperiam
                                                                                eaque ipsa, quae ab illo.</p>
                                                                        </div>
                                                                        <div class="product-size">
                                                                            <ul>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">M</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">L</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">Xl</button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="product-qnty">
                                                                            <h6 class="f-w-600">Quantity</h6>
                                                                            <fieldset>
                                                                                <div class="input-group">
                                                                                    <input class="touchspin text-center"
                                                                                        type="text" value="5" />
                                                                                </div>
                                                                            </fieldset>
                                                                            <div class="addcart-btn"><a
                                                                                    class="btn btn-primary me-3"
                                                                                    href="cart.html">Add to Cart</a><a
                                                                                    class="btn btn-primary"
                                                                                    href="product-page.html">View
                                                                                    Details</a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button class="btn-close" type="button"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-details">
                                                    <a href="product-page.html">
                                                        <h4>Roadster</h4>
                                                    </a>
                                                    <p>Women Solid Denim Jacket</p>
                                                    <div class="product-price">
                                                        $38.00
                                                        <del>$45.00 </del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 xl-4">
                                        <div class="card">
                                            <div class="product-box">
                                                <div class="product-img">
                                                    <img class="img-fluid" src="../assets/images/ecommerce/01.jpg"
                                                        alt="" />
                                                    <div class="product-hover">
                                                        <ul>
                                                            <li>
                                                                <a href="cart.html"><i class="icon-shopping-cart"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModalCenter15"><i
                                                                        class="icon-eye"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="exampleModalCenter15">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="product-box row">
                                                                    <div class="product-img col-lg-6"><img
                                                                            class="img-fluid"
                                                                            src="../assets/images/ecommerce/01.jpg"
                                                                            alt="" /></div>
                                                                    <div class="product-details col-lg-6 text-start">
                                                                        <a href="product-page.html">
                                                                            <h4>Man's Jacket</h4>
                                                                        </a>
                                                                        <div class="product-price">
                                                                            $26.00
                                                                            <del>$35.00</del>
                                                                        </div>
                                                                        <div class="product-view">
                                                                            <h6 class="f-w-600">Product Details
                                                                            </h6>
                                                                            <p class="mb-0">Sed ut
                                                                                perspiciatis, unde omnis
                                                                                iste natus error sit voluptatem
                                                                                accusantium
                                                                                doloremque laudantium, totam rem aperiam
                                                                                eaque ipsa, quae ab illo.</p>
                                                                        </div>
                                                                        <div class="product-size">
                                                                            <ul>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">M</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">L</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="btn btn-outline-light"
                                                                                        type="button">Xl</button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="product-qnty">
                                                                            <h6 class="f-w-600">Quantity</h6>
                                                                            <fieldset>
                                                                                <div class="input-group">
                                                                                    <input class="touchspin text-center"
                                                                                        type="text" value="5" />
                                                                                </div>
                                                                            </fieldset>
                                                                            <div class="addcart-btn"><a
                                                                                    class="btn btn-primary me-3"
                                                                                    href="cart.html">Add to Cart</a><a
                                                                                    class="btn btn-primary"
                                                                                    href="product-page.html">View
                                                                                    Details</a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button class="btn-close" type="button"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-details">
                                                    <a href="product-page.html">
                                                        <h4>Man's Jacket</h4>
                                                    </a>
                                                    <p>Solid Denim Jacket</p>
                                                    <div class="product-price">
                                                        $26.00
                                                        <del>$35.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Container-fluid Ends-->

                </div>
            </div>


        </div>
    </div>



@endsection
