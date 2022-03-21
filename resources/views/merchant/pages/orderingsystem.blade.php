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
                    <button class="nav-link" id="nav-discount-tab" data-bs-toggle="tab" data-bs-target="#nav-discount"
                        type="button" role="tab" aria-controls="nav-discount" aria-selected="false">Discount codes</button>
                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                        type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Product
                        Categories</button>
                    <button class="nav-link" id="nav-managestore-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-managestore" type="button" role="tab" aria-controls="nav-managestore"
                        aria-selected="false">Manage Store</button>
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

                                                @if (count($data['myProducts']) > 0)
                                                    @foreach ($data['myProducts'] as $product)
                                                        <tr>
                                                            <td>
                                                                <a href="{{ $product->image }}" target="_blank"><img
                                                                        src="{{ $product->image }}" alt="" /></a>
                                                            </td>
                                                            <td>
                                                                <a href="#">
                                                                    <h6>{{ $product->productName }}</h6>
                                                                </a>{!! $product->description !!}
                                                            </td>
                                                            <td>{{ Auth::user()->currencySymbol . number_format($product->amount) }}
                                                                {{ $product->previousAmount > 0 ? ' - ' : '' }}
                                                                <span
                                                                    style="{{ $product->previousAmount > 0 ? 'text-decoration: line-through;' : '' }}">{{ $product->previousAmount > 0 ? Auth::user()->currencySymbol . number_format($product->previousAmount) : '' }}</span>
                                                            </td>
                                                            </td>
                                                            <td class="font-success">{{ $product->stock }} In Stock</td>
                                                            <td>{{ date('d/m/Y', strtotime($product->created_at)) }}</td>
                                                            <td>

                                                                <form action="{{ route('delete product', $product->id) }}"
                                                                    method="post" id="formProduct{{ $product->id }}">
                                                                    @csrf
                                                                </form>

                                                                <button class="btn btn-danger btn-xs" type="button"
                                                                    data-original-title="btn btn-danger btn-xs" title=""
                                                                    onclick="deleteProduct({{ $product->id }})">Delete</button>


                                                                <button class="btn btn-primary btn-xs" type="button"
                                                                    data-original-title="btn btn-danger btn-xs" title=""
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editProductModal{{ $product->id }}">Edit</button>
                                                            </td>
                                                        </tr>


                                                        <div class="modal fade"
                                                            id="editProductModal{{ $product->id }}">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="editexampleModalLongTitle">Edit product</h5>
                                                                        <button class="btn-close" type="button"
                                                                            data-dismiss="modal" aria-label="Close"
                                                                            onclick="$('.modal').modal('hide')"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form
                                                                            action="{{ route('update product', $product->id) }}"
                                                                            method="post" enctype="multipart/form-data">

                                                                            @csrf

                                                                            <div class="form-group">
                                                                                <label for="productName">Product
                                                                                    Name</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="productName" id="productName"
                                                                                    aria-describedby="productNameHelp"
                                                                                    placeholder="Enter product name"
                                                                                    value="{{ $product->productName }}"
                                                                                    required>

                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="amount">New Amount</label>
                                                                                <input type="number" min="0.00" step="0.01"
                                                                                    name="amount" class="form-control"
                                                                                    id="amount"
                                                                                    aria-describedby="amountHelp"
                                                                                    placeholder="Enter amount"
                                                                                    value="{{ $product->amount }}"
                                                                                    required>
                                                                                <small id="amountHelp"
                                                                                    class="form-text text-muted">This amount
                                                                                    would be stated in your
                                                                                    local currency</small>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="previousAmount">Previous
                                                                                    Amount</label>
                                                                                <input type="number" min="0.00" step="0.01"
                                                                                    name="previousAmount"
                                                                                    class="form-control"
                                                                                    id="previousAmount"
                                                                                    aria-describedby="previousAmountHelp"
                                                                                    placeholder="Enter previous amount"
                                                                                    value="{{ $product->previousAmount }}">
                                                                                <small id="previousAmountHelp"
                                                                                    class="form-text text-muted">This
                                                                                    previous amount would be
                                                                                    stated in your
                                                                                    local currency</small>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="stock">Stock</label>
                                                                                <input type="number" min="1" max="100"
                                                                                    class="form-control" name="stock"
                                                                                    id="stock" aria-describedby="stockHelp"
                                                                                    placeholder="Enter quantity in stock"
                                                                                    value="{{ $product->stock }}"
                                                                                    required>
                                                                                <small id="stockHelp"
                                                                                    class="form-text text-muted">How many do
                                                                                    you have in stock</small>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="stock">Product Image</label>
                                                                                <input type="file" class="form-control"
                                                                                    name="file" id="file"
                                                                                    aria-describedby="imageHelp">
                                                                                <small id="stockHelp"
                                                                                    class="form-text text-muted">Add the
                                                                                    product image here</small>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="description">Description</label>
                                                                                <textarea class="form-control store_description" name="description" aria-describedby="descriptionHelp"
                                                                                    placeholder="Enter product description"
                                                                                    required>{{ $product->description }}</textarea>
                                                                                <small id="descriptionHelp"
                                                                                    class="form-text text-muted">Give your
                                                                                    customers the
                                                                                    description about this product</small>
                                                                            </div>


                                                                            <button type="submit"
                                                                                class="btn btn-primary">Update</button>

                                                                        </form>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="6" align="center"><button class="btn btn-success"
                                                                type="button" data-bs-toggle="modal"
                                                                data-bs-target="#addProductModal">Add
                                                                product + </button></td>
                                                    </tr>
                                                @endif



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
                                    <div class="card-body">
                                        <div class="order-history table-responsive">
                                            <table class="table table-bordernone display" id="basic-2">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Image</th>
                                                        <th scope="col">Product name</th>
                                                        <th scope="col">Customer name</th>
                                                        <th scope="col">Order number</th>
                                                        <th scope="col">Units</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Payment Status</th>
                                                        <th scope="col">Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    @if (count($data['myOrders']) > 0)
                                                        @foreach ($data['myOrders'] as $orders)
                                                            <tr>
                                                                <td>
                                                                    <a href="{{ $orders->image }}" target="_blank"><img
                                                                            class="img-fluid img-30"
                                                                            src="{{ $orders->image }}"
                                                                            alt="{{ $orders->id }}" /></a>
                                                                </td>

                                                                <td>{{ $orders->productName }}</td>
                                                                <td>{{ $orders->name }}</td>
                                                                {{-- <td>{{ $orders->address }} <br> <small><a
                                                                            href="https://www.google.com/maps/place/{{ $orders->address }}"
                                                                            target="_blank" class="text-primary">View on
                                                                            map</a></small></td> --}}
                                                                <td>{{ $orders->orderId }} <br> <small><a href="#"
                                                                            class="text-primary">Checkout
                                                                            details</a></small></td>
                                                                <td>{{ $orders->quantity }}</td>
                                                                <td>{{ Auth::user()->currencySymbol . number_format($orders->quantity * $orders->amount, 2) }}
                                                                </td>
                                                                <td style="font-weight: 600;">
                                                                    {{ $orders->paymentStatus }}<br> <small><a href="#"
                                                                            class="text-primary">Update
                                                                            payment</a></small></td>
                                                                <td>
                                                                    {{ date('d/m/Y', strtotime($orders->created_at)) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="8" align="center">No orders received.</td>
                                                        </tr>
                                                    @endif



                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Discount Codes Start --}}

                <div class="tab-pane fade" id="nav-discount" role="tabpanel" aria-labelledby="nav-discount-tab">

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">


                                @if (count($data['myDiscounts']) > 0)
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="order-history table-responsive">

                                                <table class="table table-bordernone display" id="basic-3">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Product</th>
                                                            <th scope="col">Amount</th>
                                                            <th scope="col">Value Type</th>
                                                            <th scope="col">Code</th>
                                                            <th scope="col">Start</th>
                                                            <th scope="col">End</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                        @php
                                                            $i = 1;
                                                        @endphp

                                                        @foreach ($data['myDiscounts'] as $discounts)
                                                            <tr>


                                                                <td>{{ $discounts->productName }}</td>
                                                                <td>{{ $discounts->valueType == 'Fixed'? Auth::user()->currencySymbol . $discounts->discountAmount: $discounts->discountAmount . '%' }}
                                                                </td>

                                                                <td>{{ $discounts->valueType }}</td>
                                                                <td>{{ $discounts->code }}</td>

                                                                <td>
                                                                    {{ date('d/m/Y', strtotime($discounts->startDate)) }}
                                                                </td>
                                                                <td>
                                                                    {{ date('d/m/Y', strtotime($discounts->endDate)) }}
                                                                </td>
                                                                <td>



                                                                    <form
                                                                        action="{{ route('delete discount', $discounts->discountId) }}"
                                                                        method="post"
                                                                        id="formDiscount{{ $discounts->discountId }}">
                                                                        @csrf
                                                                    </form>

                                                                    <button class="btn btn-danger btn-xs" type="button"
                                                                        data-original-title="btn btn-danger btn-xs" title=""
                                                                        onclick="deleteDiscount({{ $discounts->discountId }})">Delete</button>


                                                                    <button class="btn btn-primary btn-xs" type="button"
                                                                        data-original-title="btn btn-danger btn-xs" title=""
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editDiscountModal{{ $discounts->discountId }}">Edit</button>
                                                                </td>
                                                            </tr>

                                                            <div class="modal fade"
                                                                id="editDiscountModal{{ $discounts->discountId }}">
                                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="editexampleModalLongTitle">Edit discount
                                                                            </h5>
                                                                            <button class="btn-close" type="button"
                                                                                data-dismiss="modal" aria-label="Close"
                                                                                onclick="$('.modal').modal('hide')"></button>
                                                                        </div>


                                                                        <div class="modal-body">
                                                                            <form
                                                                                action="{{ route('update discount', $discounts->discountId) }}"
                                                                                method="post" enctype="multipart/form-data">

                                                                                @csrf

                                                                                <div class="form-group">
                                                                                    <label for="code">Discount code </label>
                                                                                    <span class="float-end"><a
                                                                                            href="javascript:void()"
                                                                                            class="text-primary"
                                                                                            onclick="generateDiscountCode()">Generate
                                                                                            code</a></span>
                                                                                    <input type="text"
                                                                                        class="form-control" name="code"
                                                                                        id="code"
                                                                                        aria-describedby="codeHelp"
                                                                                        placeholder="Enter a discount code"
                                                                                        value="{{ $discounts->code }}">

                                                                                </div>


                                                                                {{-- Start Select Product... --}}


                                                                                <div class="form-group">
                                                                                    <label for="code">Apply discount code
                                                                                        per product</label>

                                                                                    <select name="productId" id="productId"
                                                                                        class="form-control form-select">
                                                                                        @if (count($data['myProducts']) > 0)
                                                                                            <option value="">Select product
                                                                                            </option>

                                                                                            @foreach ($data['myProducts'] as $product)
                                                                                                <option
                                                                                                    value="{{ $product->id }}">
                                                                                                    {{ $product->productName }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        @else
                                                                                            <option value="">Add a product
                                                                                            </option>
                                                                                        @endif

                                                                                    </select>

                                                                                </div>


                                                                                {{-- End Select Product... --}}




                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="valueType">Discount
                                                                                                value type</label>

                                                                                            <select name="valueType"
                                                                                                id="valueType"
                                                                                                class="form-control form-select"
                                                                                                required>
                                                                                                <option value="">Select a
                                                                                                    value</option>
                                                                                                <option value="Fixed"
                                                                                                    {{ $discounts->valueType == 'Fixed' ? 'selected' : '' }}>
                                                                                                    Fixed
                                                                                                </option>
                                                                                                <option value="Percentage"
                                                                                                    {{ $discounts->valueType == 'Percentage' ? 'selected' : '' }}>
                                                                                                    Percentage</option>
                                                                                            </select>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group"> <label
                                                                                                for="amount">
                                                                                                <h6>Discount Amount</h6>
                                                                                            </label>
                                                                                            <div class="input-group">
                                                                                                <div
                                                                                                    class="input-group-append">
                                                                                                    <span
                                                                                                        class="input-group-text text-muted symbolText">

                                                                                                        {{ $discounts->valueType == 'Fixed' ? Auth::user()->currencySymbol : '%' }}
                                                                                                    </span>
                                                                                                </div> <input type="number"
                                                                                                    min="0.00" step="0.01"
                                                                                                    name="amount"
                                                                                                    id="discountAmount"
                                                                                                    class="form-control"
                                                                                                    value="0.00"
                                                                                                    value="{{ $discounts->discountAmount }}">

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>



                                                                                <div class="form-group">
                                                                                    <label for="startDate">Start
                                                                                        date</label>
                                                                                    <input type="date"
                                                                                        class="form-control"
                                                                                        name="startDate" id="startDate"
                                                                                        aria-describedby="startDateHelp"
                                                                                        placeholder="Start date"
                                                                                        value="{{ $discounts->startDate }}">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="endDate">End date</label>
                                                                                    <input type="date"
                                                                                        class="form-control"
                                                                                        name="endDate" id="endDate"
                                                                                        aria-describedby="endDateHelp"
                                                                                        placeholder="End date"
                                                                                        value="{{ $discounts->endDate }}">
                                                                                </div>



                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Update</button>

                                                                            </form>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach




                                                    </tbody>
                                                </table>


                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="order-history table-responsive">

                                                <h4 style="font-weight: bold;">Generate a new discount code</h4>
                                                <p>
                                                    Want to offer discounts to customers and showcase your deals on the
                                                    PaySprint Market? Use code PSDEALS
                                                </p>

                                                <button data-bs-toggle="modal" data-bs-target="#addDiscount"
                                                    class="btn btn-primary">Add
                                                    discount code</button>

                                            </div>
                                        </div>
                                    </div>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>


                {{-- Discount Codes End --}}

                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

                    <!-- Container-fluid starts-->
                    <div class="container-fluid">
                        <div class="page-header">

                        </div>
                    </div>
                    <div class="container-fluid product-wrapper">
                        <div class="product-grid">
                            <div class="feature-products">
                                {{-- <div class="row m-b-10">

                                    <div class="col-md-12 col-sm-10 text-end">
                                        <span class="f-w-600 m-r-5">Showing Products 1 - 24 Of 200 Results</span>

                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pro-filter-sec">

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

                                    @if (count($data['myProducts']) > 0)
                                        @foreach ($data['myProducts'] as $categories)
                                            <div class="col-xl-3 col-sm-6 xl-4">
                                                <div class="card">
                                                    <div class="product-box">
                                                        <div class="product-img">
                                                            <img class="img-fluid" src="{{ $categories->image }}"
                                                                alt="" style="width: 100%; object-fit: contain;" />
                                                            <div class="product-hover">
                                                                <ul>

                                                                    <li>
                                                                        <a data-bs-toggle="modal"
                                                                            data-bs-target="#catexampleModalCenter{{ $categories->id }}"><i
                                                                                class="icon-eye"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="modal fade"
                                                            id="catexampleModalCenter{{ $categories->id }}">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <div class="product-box row">
                                                                            <div class="product-img col-lg-6"><img
                                                                                    class="img-fluid"
                                                                                    src="{{ $categories->image }}" alt=""
                                                                                    style="width: 100%; object-fit: contain;" />
                                                                            </div>
                                                                            <div
                                                                                class="product-details col-lg-6 text-start">
                                                                                <a href="javascript:void(0)">
                                                                                    <h4>{{ $categories->productName }}
                                                                                    </h4>
                                                                                </a>
                                                                                <div class="product-price">
                                                                                    {{ Auth::user()->currencySymbol . $categories->amount }}
                                                                                    <del>{{ Auth::user()->currencySymbol . $categories->previousAmount }}</del>
                                                                                </div>
                                                                                <div class="product-view">
                                                                                    <h6 class="f-w-600">Product
                                                                                        Details
                                                                                    </h6>
                                                                                    <p class="mb-0">
                                                                                        {!! $categories->description !!}</p>
                                                                                </div>

                                                                                <div class="product-qnty">
                                                                                    <h6 class="f-w-600">Quantity
                                                                                    </h6>
                                                                                    <fieldset>
                                                                                        <div class="input-group">
                                                                                            <input
                                                                                                class="touchspin text-center"
                                                                                                type="text"
                                                                                                value="{{ $categories->stock }}" />
                                                                                        </div>
                                                                                    </fieldset>
                                                                                    {{-- <div class="addcart-btn"><a
                                                                                            class="btn btn-primary me-3"
                                                                                            href="javascript:void()">Add to
                                                                                            Cart
                                                                                        </a><a class="btn btn-primary"
                                                                                            href="javascript:void(0)">View
                                                                                            Details</a></div> --}}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <button class="btn-close" type="button"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="product-details">
                                                            <a href="javascript:void(0)">
                                                                <h4>{{ $categories->productName }}</h4>
                                                            </a>
                                                            <p>{!! $categories->description !!}</p>
                                                            <div class="product-price">
                                                                {{ Auth::user()->currencySymbol . $categories->amount }}
                                                                <del>{{ Auth::user()->currencySymbol . $categories->previousAmount }}</del>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
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
                                                                    <a href="javascript:void()"><i
                                                                            class="icon-shopping-cart"></i></a>
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
                                                                            <a href="javascript:void(0)">
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
                                                                                        <button
                                                                                            class="btn btn-outline-light"
                                                                                            type="button">M</button>
                                                                                    </li>
                                                                                    <li>
                                                                                        <button
                                                                                            class="btn btn-outline-light"
                                                                                            type="button">L</button>
                                                                                    </li>
                                                                                    <li>
                                                                                        <button
                                                                                            class="btn btn-outline-light"
                                                                                            type="button">Xl</button>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                            <div class="product-qnty">
                                                                                <h6 class="f-w-600">Quantity</h6>
                                                                                <fieldset>
                                                                                    <div class="input-group">
                                                                                        <input
                                                                                            class="touchspin text-center"
                                                                                            type="text" value="5" />
                                                                                    </div>
                                                                                </fieldset>
                                                                                <div class="addcart-btn"><a
                                                                                        class="btn btn-primary me-3"
                                                                                        href="javascript:void()">Add to Cart
                                                                                    </a><a class="btn btn-primary"
                                                                                        href="javascript:void(0)">View
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
                                                        <a href="javascript:void(0)">
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
                                    @endif






                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Container-fluid Ends-->

                </div>



                {{-- Manage Store Start --}}

                <div class="tab-pane fade" id="nav-managestore" role="tabpanel" aria-labelledby="nav-managestore-tab">

                    <!-- Container-fluid starts-->
                    <div class="container-fluid">
                        <div class="page-header">

                        </div>
                    </div>
                    <div class="container-fluid product-wrapper">
                        <div class="product-grid">

                            <div class="product-wrapper-grid">
                                <div class="row">

                                    <div class="card">
                                        <div class="card-header" style="background-color: #F4F6F8">
                                            <h4>{{ Auth::user()->businessname }}</h4>
                                            <a href="{{ route('home') . '/shop/' . Auth::user()->businessname }}"
                                                target="_blank" class="text-primary"
                                                style="font-weight: bold;">{{ route('home') . '/shop/' . Auth::user()->businessname }}
                                                <span class="svg-icon"><svg width="10" height="10"
                                                        viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M4.16675 5.41667C4.34569 5.65589 4.57398 5.85383 4.83614 5.99707C5.09831 6.1403 5.38821 6.22547 5.68619 6.24681C5.98416 6.26815 6.28324 6.22516 6.56314 6.12075C6.84304 6.01634 7.09721 5.85295 7.30841 5.64167L8.55841 4.39167C8.93791 3.99875 9.1479 3.4725 9.14315 2.92625C9.13841 2.38001 8.9193 1.85748 8.53304 1.47122C8.14677 1.08495 7.62424 0.865848 7.078 0.861102C6.53176 0.856355 6.0055 1.06634 5.61258 1.44584L4.89591 2.15834"
                                                            stroke="#2D9CDB" stroke-linecap="round" stroke-linejoin="round">
                                                        </path>
                                                        <path
                                                            d="M5.83342 4.58333C5.65448 4.34411 5.42618 4.14617 5.16402 4.00293C4.90186 3.8597 4.61196 3.77453 4.31398 3.75319C4.016 3.73185 3.71692 3.77484 3.43702 3.87925C3.15712 3.98366 2.90295 4.14705 2.69175 4.35833L1.44175 5.60833C1.06225 6.00125 0.852266 6.5275 0.857012 7.07374C0.861759 7.61999 1.08086 8.14251 1.46713 8.52878C1.85339 8.91505 2.37592 9.13415 2.92216 9.1389C3.46841 9.14364 3.99466 8.93365 4.38758 8.55416L5.10008 7.84166"
                                                            stroke="#2D9CDB" stroke-linecap="round" stroke-linejoin="round">
                                                        </path>
                                                    </svg></span></a>
                                        </div>
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-md-9">
                                                    <h5 class="card-text">
                                                        Setup Your Store
                                                    </h5>
                                                    <p>
                                                        You can now setup your store for your customers to see how your
                                                        estore look like
                                                    </p>
                                                </div>
                                                <div class="col-md-3">
                                                    <button class="btn btn-success" style="width: 100%;"
                                                        data-bs-toggle="modal" data-bs-target="#createStoreModal">Setup
                                                        Store</button>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-md-9">
                                                    <h5 class="card-text">
                                                        Activate announcements & flash messages
                                                    </h5>
                                                    <p>
                                                        You can now activate announcements to be able to share information
                                                        on your
                                                        store with new and existing customers.
                                                    </p>
                                                </div>
                                                <div class="col-md-3">
                                                    <button class="btn btn-warning" style="width: 100%;">Activate</button>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <h5 class="card-text">
                                                        Generate QR code for your store
                                                    </h5>
                                                    <p>
                                                        You can now generate and download QR codes to share on your store.
                                                        Customers can scan the code to have access to all your products.
                                                    </p>
                                                </div>
                                                <div class="col-md-3">
                                                    <button class="btn btn-success" style="width: 100%;"><small>Activate QR
                                                            code</small></button>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="card-text">
                                                        Shipping Preference
                                                    </h5>
                                                    <br>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="flexCheckDefault">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            Turn off shipping
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="flexCheckChecked">
                                                        <label class="form-check-label" for="flexCheckChecked">
                                                            I’ll handle my shipping
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <h5 class="card-text">
                                                        Shipping Regions & Rates
                                                    </h5>
                                                    <p>

                                                    </p>
                                                </div>
                                                <div class="col-md-3">
                                                    <button class="btn btn-danger btn-block"
                                                        style="width: 100%;"><small>Add Shipping
                                                            Fee</small></button>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <h5 class="card-text">
                                                        Add Tax
                                                    </h5>
                                                    <p>

                                                    </p>
                                                </div>
                                                <div class="col-md-3">
                                                    <button class="btn btn-success" style="width: 100%;"><small>Add
                                                            Tax</small></button>
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

                {{-- Manage Store End --}}

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
                        <form action="{{ route('store product') }}" method="post" enctype="multipart/form-data">

                            @csrf

                            <div class="form-group">
                                <label for="productName">Product Name</label>
                                <input type="text" class="form-control" name="productName" id="productName"
                                    aria-describedby="productNameHelp" placeholder="Enter product name" required>

                            </div>
                            <div class="form-group">
                                <label for="amount">New Amount</label>
                                <input type="number" min="0.00" step="0.01" name="amount" class="form-control"
                                    id="amount" aria-describedby="amountHelp" placeholder="Enter amount" required>
                                <small id="amountHelp" class="form-text text-muted">This amount would be stated in your
                                    local currency</small>
                            </div>
                            <div class="form-group">
                                <label for="previousAmount">Previous Amount</label>
                                <input type="number" min="0.00" step="0.01" name="previousAmount" class="form-control"
                                    id="previousAmount" aria-describedby="previousAmountHelp"
                                    placeholder="Enter previous amount" value="0.00">
                                <small id="previousAmountHelp" class="form-text text-muted">This previous amount would be
                                    stated in your
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
                                <input type="file" class="form-control" name="file" id="file"
                                    aria-describedby="imageHelp" required>
                                <small id="stockHelp" class="form-text text-muted">Add the product image here</small>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control store_description" name="description" aria-describedby="descriptionHelp"
                                    placeholder="Enter product description" required></textarea>
                                <small id="descriptionHelp" class="form-text text-muted">Give your customers the
                                    description about this product</small>
                            </div>




                            <button type="submit" class="btn btn-primary">Submit</button>

                        </form>
                    </div>

                </div>
            </div>
        </div>


        <div class="modal fade" id="addDiscount">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Create discount</h5>
                        <button class="btn-close" type="button" data-dismiss="modal" aria-label="Close"
                            onclick="$('.modal').modal('hide')"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('store discount') }}" method="post" enctype="multipart/form-data">

                            @csrf

                            <div class="form-group">
                                <label for="code">Discount code </label> <span class="float-end"><a
                                        href="javascript:void()" class="text-primary"
                                        onclick="generateDiscountCode()">Generate
                                        code</a></span>
                                <input type="text" class="form-control" name="code" id="code" aria-describedby="codeHelp"
                                    placeholder="Enter a discount code" required>

                            </div>


                            {{-- Start Select Product... --}}


                            <div class="form-group">
                                <label for="code">Apply discount code per product</label>

                                <select name="productId" id="productId" class="form-control form-select">
                                    @if (count($data['myProducts']) > 0)
                                        <option value="">Select product</option>

                                        @foreach ($data['myProducts'] as $product)
                                            <option value="{{ $product->id }}">{{ $product->productName }}</option>
                                        @endforeach
                                    @else
                                        <option value="">Add a product</option>
                                    @endif

                                </select>

                            </div>


                            {{-- End Select Product... --}}




                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="valueType">Discount value type</label>

                                        <select name="valueType" id="valueType" class="form-control form-select" required>
                                            <option value="">Select a value</option>
                                            <option value="Fixed">Fixed</option>
                                            <option value="Percentage">Percentage</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> <label for="amount">
                                            <h6>Discount Amount</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span
                                                    class="input-group-text text-muted symbolText">
                                                    {{ Auth::user()->currencySymbol }} </span> </div> <input
                                                type="number" min="0.00" step="0.01" name="amount" id="discountAmount"
                                                class="form-control" value="0.00" required>

                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="startDate">Start date</label>
                                <input type="date" class="form-control" name="startDate" id="startDate"
                                    aria-describedby="startDateHelp" placeholder="Start date" required>
                            </div>
                            <div class="form-group">
                                <label for="endDate">End date</label>
                                <input type="date" class="form-control" name="endDate" id="endDate"
                                    aria-describedby="endDateHelp" placeholder="Start date" required>
                            </div>



                            <button type="submit" class="btn btn-primary">Submit</button>

                        </form>
                    </div>

                </div>
            </div>
        </div>


        <div class="modal fade" id="createStoreModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Setup Store</h5>
                        <button class="btn-close" type="button" data-dismiss="modal" aria-label="Close"
                            onclick="$('.modal').modal('hide')"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('setup estore') }}" method="post" enctype="multipart/form-data">

                            @csrf

                            <div class="form-group">
                                <label for="businessLogo">Business Logo </label>
                                <input type="file" class="form-control" name="businessLogo" id="businessLogo"
                                    aria-describedby="businessLogoHelp" required>

                                <small id="businessLogoHelp" class="form-text text-muted">Upload your business logo for
                                    your shop.</small>

                            </div>


                            <div class="form-group">
                                <label for="headerContent">Header Content Image </label>
                                <input type="file" class="form-control" name="headerContent[]" id="headerContent"
                                    aria-describedby="headerContentHelp" required multiple>

                                <small id="headerContentHelp" class="form-text text-muted">Upload your header content for
                                    your shop. <strong>MAX 3 pictures will be uploaded</strong> <br> <span
                                        class="text-danger">Please note
                                        JPG, PNG and SVG formats are
                                        only
                                        allowed.</span></small>

                            </div>

                            <div class="form-group">
                                <label for="headerTitle">Header Title Text </label>
                                <input type="text" class="form-control" name="headerTitle" id="headerTitle"
                                    aria-describedby="headerTitleHelp" placeholder="Enter header title" required>

                                <small id="headerTitleHelp" class="form-text text-muted">If HEADER CONTENT IMAGE is more
                                    than one (1), separate by comma (,)</small>

                            </div>


                            <div class="form-group">
                                <label for="headerSubtitle">Header Sub-title Text </label>
                                <input type="text" class="form-control" name="headerSubtitle" id="headerSubtitle"
                                    aria-describedby="headerSubtitleHelp" placeholder="Enter header sub-title" required>

                                <small id="headerSubtitleHelp" class="form-text text-muted">If HEADER CONTENT IMAGE is more
                                    than one (1), separate by comma (,)</small>

                            </div>


                            <div class="form-group">
                                <label for="advertSectionImage">Advert Section Image </label>
                                <input type="file" class="form-control" name="advertSectionImage[]"
                                    id="advertSectionImage" aria-describedby="advertSectionImageHelp" multiple>

                                <small id="advertSectionImageHelp" class="form-text text-muted">Upload your advert section
                                    image for
                                    your shop. <strong>MAX 3 pictures will be uploaded</strong> <br> <span
                                        class="text-danger">Please note
                                        JPG, PNG and SVG formats are
                                        only
                                        allowed.</span></small>

                            </div>


                            <div class="form-group">
                                <label for="advertTitle">Advert Title Text </label>
                                <input type="text" class="form-control" name="advertTitle" id="advertTitle"
                                    aria-describedby="advertTitleHelp" placeholder="Enter advert title">

                                <small id="advertTitleHelp" class="form-text text-muted">If ADVERT CONTENT IMAGE is more
                                    than one (1), separate by comma (,)</small>

                            </div>


                            <div class="form-group">
                                <label for="advertSubtitle">Advert Sub-title Text </label>
                                <input type="text" class="form-control" name="advertSubtitle" id="advertSubtitle"
                                    aria-describedby="advertSubtitleHelp" placeholder="Enter advert sub-title">

                                <small id="advertSubtitleHelp" class="form-text text-muted">If ADVERT CONTENT IMAGE is more
                                    than one (1), separate by comma (,)</small>

                            </div>



                            <input type="submit" class="btn btn-danger" name="savePreview" value="Save and Preview">
                            <input type="submit" class="btn btn-success" name="justSave" value="Just save it">

                        </form>
                    </div>

                </div>
            </div>
        </div>





    </div>
@endsection
