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
                    <button class="nav-link btn btn-success" type="button" data-bs-toggle="modal"
                        data-bs-target="#addProductModal">Add product + </button>

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
                                                                src="{{ asset('merchantassets/assets/images/ecommerce/product-table-1.png') }}"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>Red Lipstick</h6>
                                                        </a><span>Interchargebla lens Digital Camera with APS-C-X Trans CMOS
                                                            Sens</span>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-success">3 In Stock</td>
                                                    <td>28/02/2022</td>
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
                                                        <th scope="col">Image</th>
                                                        <th scope="col">Product name</th>
                                                        <th scope="col">Customer name</th>
                                                        <th scope="col">Delivery address</th>
                                                        <th scope="col">Order number</th>
                                                        <th scope="col">Units</th>
                                                        <th scope="col">Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <a href="#"><img class="img-fluid img-30"
                                                                    src="{{ asset('merchantassets/assets/images/product/1.png') }}"
                                                                    alt="#" /></a>
                                                        </td>

                                                        <td>Men Shirt</td>
                                                        <td>Adama Traore</td>
                                                        <td>14, Samuel Awoniyi <br> <small><a href="#"
                                                                    class="text-primary">View on
                                                                    map</a></small></td>
                                                        <td>4215738 <br> <small><a href="#" class="text-primary">Order
                                                                    details</a></small></td>
                                                        <td>1</td>
                                                        <td>$21</td>
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

                                    <div class="col-md-12 col-sm-10 text-end">
                                        <span class="f-w-600 m-r-5">Showing Products 1 - 24 Of 200 Results</span>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pro-filter-sec">

                                            <div class="product-search">
                                                <form>
                                                    <div class="form-group m-0"><input class="form-control" type="search"
                                                            placeholder="Search.." data-original-title="" title="" /><i
                                                            class="fa fa-search"></i></div>
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
                                                    <img class="img-fluid"
                                                        src="{{ asset('merchantassets/assets/images/ecommerce/01.jpg') }}"
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
                                                                            src="{{ asset('merchantassets/assets/images/ecommerce/01.jpg') }}"
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
                                                    <img class="img-fluid"
                                                        src="{{ asset('merchantassets/assets/images/ecommerce/02.jpg') }}"
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
                                                                            src="{{ asset('merchantassets/assets/images/ecommerce/02.jpg') }}"
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
                                                    <img class="img-fluid"
                                                        src="{{ asset('merchantassets/assets/images/ecommerce/03.jpg') }}"
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
                                                                            src="{{ asset('merchantassets/assets/images/ecommerce/03.jpg') }}"
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
                                                    <img class="img-fluid"
                                                        src="{{ asset('merchantassets/assets/images/ecommerce/04.jpg') }}"
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
                                                                            src="{{ asset('merchantassets/assets/images/ecommerce/04.jpg') }}"
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

                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Container-fluid Ends-->

                </div>
            </div>


        </div>


        <div class="modal fade" id="addProductModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add a product</h5>
                        <button class="btn-close" type="button" data-dismiss="modal" aria-label="Close"
                            onclick="$('.modal').modal('hide')"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('store product') }}" method="post" enctype="multipart/form">

                            <div class="form-group">
                                <label for="productName">Product Name</label>
                                <input type="text" class="form-control" name="productName" id="productName"
                                    aria-describedby="productNameHelp" placeholder="Enter product name" required>

                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" min="0.00" step="0.01" name="amount" class="form-control"
                                    id="amount" aria-describedby="amountHelp" placeholder="Enter amount" required>
                                <small id="amountHelp" class="form-text text-muted">This amount would be stated in your
                                    local currency</small>
                            </div>
                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="number" min="1" max="100" class="form-control" name="stock" id="stock"
                                    aria-describedby="stockHelp" placeholder="Enter quantity in stock" required>
                                <small id="stockHelp" class="form-text text-muted">How many do you have in stock</small>
                            </div>

                            <div class="form-group">
                                <label for="stock">Product Image</label>
                                <input type="file" class="form-control" name="image" id="image"
                                    aria-describedby="imageHelp" required>
                                <small id="stockHelp" class="form-text text-muted">Add the product image here</small>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" id="store_description"
                                    aria-describedby="descriptionHelp" placeholder="Enter product description"
                                    required></textarea>
                                <small id="descriptionHelp" class="form-text text-muted">Give your customers the
                                    description about this product</small>
                            </div>




                            <button type="submit" class="btn btn-primary">Submit</button>

                        </form>
                    </div>

                </div>
            </div>
        </div>





    </div>
@endsection
