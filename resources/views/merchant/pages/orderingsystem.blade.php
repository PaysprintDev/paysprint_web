@extends('layouts.merch.merchant-dashboard')



@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">

                    <div class="col-lg-6 float-right">
                        <!-- Bookmark Start-->

                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>eStore Escrow Balance</td>
                                    <td style="font-weight: bold;">
                                        {{ Auth::user()->currencySymbol . '' . number_format(Auth::user()->escrow_balance, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Dispute Balance</td>
                                    <td style="font-weight: bold;">
                                        {{ Auth::user()->currencySymbol . '' . number_format(Auth::user()->dispute_balance, 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Bookmark Ends-->
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid list-products">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                        type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Product
                        Categories</button>
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                        type="button" role="tab" aria-controls="nav-home" aria-selected="true">Products</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                        type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Orders</button>
                    <button class="nav-link" id="nav-sales-tab" data-bs-toggle="tab" data-bs-target="#nav-sales"
                        type="button" role="tab" aria-controls="nav-sales" aria-selected="false">Sales</button>
                    <button class="nav-link" id="nav-refund-tab" data-bs-toggle="tab" data-bs-target="#nav-refund"
                        type="button" role="tab" aria-controls="nav-refund" aria-selected="false">Refund</button>
                    <button class="nav-link" id="nav-discount-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-discounts" type="button" role="tab" aria-controls="nav-discounts"
                        aria-selected="false">Discount codes <span class="text-danger">[coming soon]</span></button>
                    {{-- <button class="nav-link" id="nav-discount-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-discount" type="button" role="tab" aria-controls="nav-discount"
                        aria-selected="false">Discount codes <span class="text-danger">[coming soon]</span></button> --}}

                    <button class="nav-link" id="nav-managestore-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-managestore" type="button" role="tab" aria-controls="nav-managestore"
                        aria-selected="false">Manage eStore</button>
                    <button class="nav-link btn btn-success" type="button" data-bs-toggle="modal"
                        data-bs-target="#addProductModal">Add product + </button>

                    {{-- Continued here... --}}

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

                                                                <form
                                                                    action="{{ route('delete product', $product->id) }}"
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
                                                                                <label for="code">Product Code </label>
                                                                                <span class="float-end"><a
                                                                                        href="javascript:void(0)"
                                                                                        class="text-primary"
                                                                                        onclick="generateProductCode()">Generate
                                                                                        code</a></span>
                                                                                <input type="text"
                                                                                    class="form-control productCode"
                                                                                    name="productCode"
                                                                                    aria-describedby="codeHelp"
                                                                                    value="{{ $product->productCode }}"
                                                                                    placeholder="Enter a product code"
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
                                                                                <input type="number" min="1"
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
                                                                                <label for="stock">Category</label>
                                                                                <select name="category" id="category"
                                                                                    class="form-control form-select prodCategory">
                                                                                    @if (count($data['productcategory']) > 0)
                                                                                        <option value="">Select category
                                                                                        </option>

                                                                                        @foreach ($data['productcategory'] as $itemCat)
                                                                                            <option
                                                                                                value="{{ $itemCat->category }}"
                                                                                                {{ $product->category == $itemCat->category ? 'selected' : '' }}>
                                                                                                {{ $itemCat->category }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                                <small id="stockHelp"
                                                                                    class="form-text text-muted">Select
                                                                                    product category</small>
                                                                            </div>


                                                                            <div class="form-group specifycategory disp-0">
                                                                                <label for="specifyCategory">Specify
                                                                                    Category</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="specifyCategory"
                                                                                    id="specifyCategory"
                                                                                    aria-describedby="specifyCategoryHelp"
                                                                                    placeholder="Specify Category">

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
                                                        <th scope="col">Action</th>
                                                        <th scope="col">Image</th>
                                                        <th scope="col">Product name</th>
                                                        <th scope="col">Customer name</th>
                                                        <th scope="col">Order number</th>
                                                        <th scope="col">Shipping Address</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Payment Status</th>
                                                        <th scope="col">Order Date</th>
                                                        <th scope="col">Payment Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    @if (count($data['myOrders']) > 0)
                                                        @foreach ($data['myOrders'] as $orders)
                                                            @if ($orders->deliveryStatus != 'delivered')
                                                                <tr>
                                                                    <td>
                                                                        @if ($orders->deliveryStatus == 'off')
                                                                            <button class="btn btn-danger"
                                                                                id="delivery{{ $orders->orderId }}"
                                                                                onclick="outForDelivery('{{ $orders->orderId }}')">Out
                                                                                for
                                                                                Delivery</button>
                                                                        @elseif($orders->deliveryStatus == 'in-progress')
                                                                            <button class="btn btn-warning"
                                                                                disabled>Delivery in
                                                                                progress</button>
                                                                        @else
                                                                            <button class="btn btn-success"
                                                                                disabled>Delivered</button>
                                                                        @endif

                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ $orders->image }}"
                                                                            target="_blank"><img class="img-fluid img-30"
                                                                                src="{{ $orders->image }}"
                                                                                alt="{{ $orders->id }}" /></a>
                                                                    </td>

                                                                    <td>{{ $orders->productName }}</td>
                                                                    <td>{{ $orders->name }}</td>
                                                                    {{-- <td>{{ $orders->address }} <br> <small><a
                                                                            href="https://www.google.com/maps/place/{{ $orders->address }}" target="_blank"
                                                                            target="_blank" class="text-primary">View on
                                                                            map</a></small></td> --}}
                                                                    <td>{{ $orders->orderId }}</td>
                                                                    <td>
                                                                        <a href="https://www.google.com/maps/place/{{ $orders->address }}"
                                                                            target="_blank">{{ $orders->address }}</a>
                                                                    </td>
                                                                    <td>{{ $orders->quantity }}</td>
                                                                    <td>{{ Auth::user()->currencySymbol . number_format($orders->quantity * $orders->amount, 2) }}
                                                                    </td>
                                                                    <td style="font-weight: 600;"
                                                                        class="{{ $orders->paymentStatus == 'paid' ? 'text-success' : 'text-danger' }}">
                                                                        {{ $orders->paymentStatus }}</td>
                                                                    <td>
                                                                        {{ date('d/m/Y', strtotime($orders->created_at)) }}
                                                                    </td>
                                                                    <td>
                                                                        {{ date('d/m/Y', strtotime($orders->updated_at)) }}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="10" align="center">No orders received.</td>
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


                <div class="tab-pane fade" id="nav-sales" role="tabpanel" aria-labelledby="nav-sales-tab">

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="order-history table-responsive">
                                            <table class="table table-bordernone display" id="basic-2">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Action</th>
                                                        <th scope="col">Image</th>
                                                        <th scope="col">Product name</th>
                                                        <th scope="col">Customer name</th>
                                                        <th scope="col">Order number</th>
                                                        <th scope="col">Shipping Address</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Payment Status</th>
                                                        <th scope="col">Order Date</th>
                                                        <th scope="col">Payment Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    @if (count($data['myOrders']) > 0)
                                                        @foreach ($data['myOrders'] as $orders)
                                                            @if ($orders->deliveryStatus == 'delivered')
                                                                <tr>
                                                                    <td>
                                                                        <button class="btn btn-success"
                                                                            disabled>Delivered</button>

                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ $orders->image }}"
                                                                            target="_blank"><img class="img-fluid img-30"
                                                                                src="{{ $orders->image }}"
                                                                                alt="{{ $orders->id }}" /></a>
                                                                    </td>

                                                                    <td>{{ $orders->productName }}</td>
                                                                    <td>{{ $orders->name }}</td>
                                                                    {{-- <td>{{ $orders->address }} <br> <small><a
                                                                            href="https://www.google.com/maps/place/{{ $orders->address }}" target="_blank"
                                                                            target="_blank" class="text-primary">View on
                                                                            map</a></small></td> --}}
                                                                    <td>{{ $orders->orderId }}</td>
                                                                    <td>
                                                                        <a href="https://www.google.com/maps/place/{{ $orders->address }}"
                                                                            target="_blank">{{ $orders->address }}</a>
                                                                    </td>
                                                                    <td>{{ $orders->quantity }}</td>
                                                                    <td>{{ Auth::user()->currencySymbol . number_format($orders->quantity * $orders->amount, 2) }}
                                                                    </td>
                                                                    <td style="font-weight: 600;"
                                                                        class="{{ $orders->paymentStatus == 'paid' ? 'text-success' : 'text-danger' }}">
                                                                        {{ $orders->paymentStatus }}</td>
                                                                    <td>
                                                                        {{ date('d/m/Y', strtotime($orders->created_at)) }}
                                                                    </td>
                                                                    <td>
                                                                        {{ date('d/m/Y', strtotime($orders->updated_at)) }}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="10" align="center">No orders received.</td>
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
                                                                <td>{{ $discounts->valueType == 'Fixed' ? Auth::user()->currencySymbol . $discounts->discountAmount : $discounts->discountAmount . '%' }}
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
                                                                                            href="javascript:void(0)"
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
                                                                <h4>{{ $categories->productName }} |
                                                                    <small>{{ $categories->productCode }}</small>
                                                                </h4>
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
                                        <h3 class="mt-3 text-center">No product here</h3>
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
                                                        Setup Your eStore
                                                    </h5>
                                                    <p>
                                                        You can now setup your store for your customers to see how your
                                                        estore look like
                                                    </p>
                                                </div>
                                                <div class="col-md-3">

                                                    @isset($data['myStore'])
                                                        <button class="btn btn-primary" style="width: 100%;"
                                                            data-bs-toggle="modal" data-bs-target="#editStoreModal">Update
                                                            eStore</button>
                                                    @else
                                                        <button class="btn btn-success" style="width: 100%;"
                                                            data-bs-toggle="modal" data-bs-target="#createStoreModal">Setup
                                                            eStore</button>
                                                    @endisset


                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-md-9">
                                                    <h5 class="card-text">
                                                        Announcements
                                                    </h5>
                                                    <p>
                                                        You can now activate announcements to be able to share information
                                                        on your
                                                        eStore with new and existing customers.
                                                    </p>
                                                </div>
                                                <div class="col-md-3">
                                                    <button class="btn btn-warning" style="width: 100%;"
                                                        onclick="comingSoon()">Coming
                                                        soon</button>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="card-text">
                                                        Shipping Option
                                                    </h5>
                                                    <br>
                                                    <div class="form-check">

                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="flexCheckDefault"
                                                            {{ $data['storepickup'] > 0 ? 'checked disabled' : '' }}>
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            In-Store Pick Up
                                                        </label>

                                                        <button class="instorebtn d-none" data-bs-toggle="modal"
                                                            data-bs-target="#instorePickup">Click button</button>

                                                        {!! $data['storepickup'] > 0
    ? '<span class="float-end"><a href="javascript:void(0)"
                                                                class="text-primary">View/Add
                                                                pickup addresses</a></span>'
    : '' !!}



                                                    </div>

                                                    <div class="modal fade" id="instorePickup">
                                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">
                                                                        Setup Store Address</h5>
                                                                    <button class="btn-close" type="button"
                                                                        data-dismiss="modal" aria-label="Close"
                                                                        onclick="$('.modal').modal('hide')"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ route('store pickup address') }}"
                                                                        method="post">

                                                                        @csrf

                                                                        <div class="form-group">
                                                                            <label for="instore_address">Address</label>
                                                                            <input type="text" class="form-control"
                                                                                name="address" id="instore_address"
                                                                                aria-describedby="instore_addressHelp"
                                                                                placeholder="Enter your address">
                                                                            <small id="instore_addressHelp"
                                                                                class="form-text text-muted">Please type
                                                                                the correct address to your store</small>
                                                                        </div>


                                                                        <div class="form-group">
                                                                            <label for="instore_state">State</label>
                                                                            <input type="text" class="form-control"
                                                                                name="state" id="instore_state"
                                                                                aria-describedby="instore_stateHelp"
                                                                                placeholder="E.g {{ Auth::user()->state }}"
                                                                                required>
                                                                            <small id="instore_addressHelp"
                                                                                class="form-text text-muted">Note that this
                                                                                should match with the address above</small>

                                                                        </div>


                                                                        <div class="form-group">
                                                                            <label for="instore_state">Delivery Rate</label>
                                                                            <input type="number" class="form-control"
                                                                                name="deliveryRate"
                                                                                id="instore_deliveryRate"
                                                                                aria-describedby="instore_deliveryRateHelp"
                                                                                placeholder="Enter delivery rate"
                                                                                value="0.00" min="0.00" step="0.00"
                                                                                required>
                                                                            <small id="instore_addressHelp"
                                                                                class="form-text text-muted">Please set
                                                                                your store delivery rate</small>

                                                                        </div>



                                                                        <button type="submit"
                                                                            class="btn btn-primary">Submit</button>

                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="flexCheckChecked"
                                                            {{ $data['deliverypickup'] > 0 ? 'checked disabled' : '' }}>
                                                        <label class="form-check-label" for="flexCheckChecked">
                                                            Delivery
                                                        </label>



                                                        {!! $data['deliverypickup'] > 0
    ? '<span class="float-end"><a href="javascript:void(0)"
                                                                class="text-danger">View/Add
                                                                delivery rates</a></span>'
    : '' !!}
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
                                                    <button class="btn btn-danger btn-block" style="width: 100%;"
                                                        onclick="shippingWithRate()"><small>Add Shipping
                                                            Fee</small></button>


                                                    <button class="deliveryshippingbtn d-none" data-bs-toggle="modal"
                                                        data-bs-target="#instoreShipping">Click button</button>
                                                </div>



                                            </div>

                                            <div class="modal fade" id="instoreShipping">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                                Shipping Regions & Rates (Delivery Service)</h5>
                                                            <button class="btn-close" type="button"
                                                                data-dismiss="modal" aria-label="Close"
                                                                onclick="$('.modal').modal('hide')"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('store shipping address') }}"
                                                                method="post">

                                                                @csrf

                                                                <div class="form-group">
                                                                    <label for="instore_address">Country</label>
                                                                    <select name="country" id="delivery_country"
                                                                        class="form-control form-select" required>

                                                                    </select>
                                                                    <small id="delivery_countryHelp"
                                                                        class="form-text text-muted">Please select
                                                                        country you deliver to.</small>
                                                                </div>



                                                                <div class="form-group">
                                                                    <label for="instore_state">Currency Code</label>
                                                                    <select name="currencyCode" id="category"
                                                                        class="form-control form-select" required>
                                                                        @if (count($data['activeCountry']) > 0)
                                                                            <option value="">Select currency code
                                                                            </option>

                                                                            @foreach ($data['activeCountry'] as $item)
                                                                                <option
                                                                                    value="{{ $item->currencyCode }}">
                                                                                    {{ $item->name . ' (' . $item->currencyCode . ')' }}
                                                                                </option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                    <small id="instore_addressHelp"
                                                                        class="form-text text-muted">Pick a correct
                                                                        currency code for the above country</small>

                                                                </div>


                                                                <div class="form-group">
                                                                    <label for="instore_state">State</label>
                                                                    <select name="state" id="delivery_state"
                                                                        class="form-control form-select" required>

                                                                    </select>
                                                                    <small id="instore_addressHelp"
                                                                        class="form-text text-muted">Select the states
                                                                        you deliver to</small>

                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="instore_city">City</label>
                                                                    <input type="text" class="form-control" name="city"
                                                                        id="delivery_city"
                                                                        aria-describedby="instore_cityHelp"
                                                                        placeholder="Enter delivery city" required>
                                                                    <small id="instore_cityHelp"
                                                                        class="form-text text-muted">Please specify the
                                                                        city</small>

                                                                </div>



                                                                <div class="form-group">
                                                                    <label for="instore_state">Delivery Rate</label>
                                                                    <input type="number" class="form-control"
                                                                        name="deliveryRate" id="delivery_deliveryRate"
                                                                        aria-describedby="instore_deliveryRateHelp"
                                                                        placeholder="Enter delivery rate" value="0.00"
                                                                        min="0.00" step="0.00" required>
                                                                    <small id="instore_addressHelp"
                                                                        class="form-text text-muted">Please set
                                                                        your store delivery rate</small>

                                                                </div>



                                                                <button type="submit"
                                                                    class="btn btn-primary">Submit</button>

                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <h5 class="card-text">
                                                        Product Tax
                                                    </h5>
                                                    <p>

                                                    </p>
                                                </div>
                                                <div class="col-md-3">

                                                    @isset($data['myProductTax'])
                                                        <button class="btn btn-success" style="width: 100%;"
                                                            data-bs-toggle="modal" data-bs-target="#editProductTax"><small>Edit
                                                                Product
                                                                Tax</small></button>
                                                    @else
                                                        <button class="btn btn-success" style="width: 100%;"
                                                            data-bs-toggle="modal" data-bs-target="#addProductTax"><small>Add
                                                                Product
                                                                Tax</small></button>
                                                    @endisset


                                                </div>
                                            </div>


                                            <div class="modal fade" id="addProductTax">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                                Add Product Tax</h5>
                                                            <button class="btn-close" type="button"
                                                                data-dismiss="modal" aria-label="Close"
                                                                onclick="$('.modal').modal('hide')"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('store product tax') }}"
                                                                method="post">

                                                                @csrf

                                                                <div class="form-group">
                                                                    <label for="taxName">Tax Name</label>
                                                                    <input type="text" class="form-control"
                                                                        name="taxName" id="taxName"
                                                                        aria-describedby="taxNameHelp"
                                                                        placeholder="Enter tax name" required>
                                                                    <small id="taxNameHelp"
                                                                        class="form-text text-muted">Please provide the tax
                                                                        name</small>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="taxValue">Tax Value (%)</label>
                                                                    <input type="number" min="0.00" step="0.01"
                                                                        class="form-control" name="taxValue"
                                                                        id="taxValue" aria-describedby="taxValueHelp"
                                                                        placeholder="Enter tax value (%)" required>
                                                                    <small id="taxValueHelp"
                                                                        class="form-text text-muted">Please provide the tax
                                                                        name</small>
                                                                </div>



                                                                <button type="submit"
                                                                    class="btn btn-primary">Submit</button>

                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>



                                            @isset($data['myProductTax'])
                                                <div class="modal fade" id="editProductTax">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">
                                                                    Edit Product Tax</h5>
                                                                <button class="btn-close" type="button"
                                                                    data-dismiss="modal" aria-label="Close"
                                                                    onclick="$('.modal').modal('hide')"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('edit product tax', $data['myProductTax']->id) }}"
                                                                    method="post">

                                                                    @csrf

                                                                    <div class="form-group">
                                                                        <label for="taxName">Tax Name</label>
                                                                        <input type="text" class="form-control"
                                                                            name="taxName" id="taxName"
                                                                            aria-describedby="taxNameHelp"
                                                                            placeholder="Enter tax name"
                                                                            value="{{ $data['myProductTax']->taxName }}"
                                                                            required>
                                                                        <small id="taxNameHelp"
                                                                            class="form-text text-muted">Please provide the tax
                                                                            name</small>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="taxValue">Tax Value (%)</label>
                                                                        <input type="number" min="0.00" step="0.01"
                                                                            class="form-control" name="taxValue"
                                                                            id="taxValue" aria-describedby="taxValueHelp"
                                                                            placeholder="Enter tax value (%)"
                                                                            value="{{ $data['myProductTax']->taxValue }}"
                                                                            required>
                                                                        <small id="taxValueHelp"
                                                                            class="form-text text-muted">Please provide the tax
                                                                            name</small>
                                                                    </div>



                                                                    <button type="submit"
                                                                        class="btn btn-primary">Submit</button>

                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endisset

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
                                <label for="stock">Category</label>
                                <select name="category" id="category" class="form-control form-select prodCategory"
                                    required>


                                    @if (count($data['productcategory']) > 0)
                                        <option value="">Select category</option>

                                        @foreach ($data['productcategory'] as $itemCat)
                                            <option value="{{ $itemCat->category }}">{{ $itemCat->category }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <small id="stockHelp" class="form-text text-muted">Select product category</small>
                            </div>

                            <div class="form-group specifycategory disp-0">
                                <label for="specifyCategory">Specify Category</label>
                                <input type="text" class="form-control" name="specifyCategory" id="specifyCategory"
                                    aria-describedby="specifyCategoryHelp" placeholder="Specify Category">

                            </div>

                            <div class="form-group">
                                <label for="productName">Product Name</label>
                                <input type="text" class="form-control" name="productName" id="productName"
                                    aria-describedby="productNameHelp" placeholder="Enter product name" required>

                            </div>

                            <div class="form-group">
                                <label for="code">Product Code </label>
                                <span class="float-end"><a href="javascript:void(0)" class="text-primary"
                                        onclick="generateProductCode()">Auto Generate
                                        code</a></span>
                                <input type="text" class="form-control productCode" name="productCode"
                                    aria-describedby="codeHelp" placeholder="Enter a product code" required>

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
                                <input type="number" min="1" class="form-control" name="stock" id="stock"
                                    aria-describedby="stockHelp" placeholder="Enter quantity in stock" required>
                                <small id="stockHelp" class="form-text text-muted">How many do you have in stock</small>
                            </div>


                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control store_description" name="description" aria-describedby="descriptionHelp"
                                    placeholder="Enter product description" required></textarea>
                                <small id="descriptionHelp" class="form-text text-muted">Give your customers the
                                    description about this product</small>
                            </div>

                            <div class="form-group">
                                <label for="stock">Product Image</label>
                                <input type="file" class="form-control" name="file" id="file"
                                    aria-describedby="imageHelp" required>
                                <small id="stockHelp" class="form-text text-muted">Add the product image here</small>
                            </div>

                            <div class="form-group">
                                <label for="deliveryDate">Delivery Period</label>
                                <input type="text" min="1" class="form-control" name="deliveryDate" id="deliveryDate"
                                    aria-describedby="deliveryDateHelp" placeholder="6 days" required>
                                <small id="deliveryDateHelp" class="form-text text-muted">How many days would the product
                                    be shipped?</small>
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
                                        href="javascript:void(0)" class="text-primary"
                                        onclick="generateDiscountCode()">Auto Generate
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
                        <h5 class="modal-title" id="exampleModalLongTitle">Setup eStore</h5>
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


                            <div class="form-group">
                                <label for="advertSubtitle">Return and Refund Policy </label>

                                <textarea name="refundPolicy" id="refundPolicy" cols="30" rows="10" class="form-control"></textarea>

                                <small id="advertSubtitleHelp" class="form-text text-muted">Here is to assertain your
                                    customers of your return and refund policy</small>

                            </div>



                            <div class="form-group">
                                <label for="facebook">Facebook Link </label>
                                <input type="text" class="form-control" name="facebook" id="facebook"
                                    aria-describedby="facebookHelp" placeholder="Enter your facebook link">

                                <small id="facebookHelp" class="form-text text-muted">Let your customers view you on
                                    facebook</small>

                            </div>
                            <div class="form-group">
                                <label for="twitter">Twitter Link </label>
                                <input type="text" class="form-control" name="twitter" id="twitter"
                                    aria-describedby="twitterHelp" placeholder="Enter your twitter link">

                                <small id="twitterHelp" class="form-text text-muted">Let your customers view you on
                                    twitter</small>

                            </div>
                            <div class="form-group">
                                <label for="instagram">Instagram Link </label>
                                <input type="text" class="form-control" name="instagram" id="instagram"
                                    aria-describedby="instagramHelp" placeholder="Enter your instgram link">

                                <small id="instagramHelp" class="form-text text-muted">Let your customers view you on
                                    instagram</small>

                            </div>
                            <div class="form-group">
                                <label for="whatsapp">Whatsapp Link </label>
                                <input type="text" class="form-control" name="whatsapp" id="whatsapp"
                                    aria-describedby="whatsappHelp" placeholder="Enter your whatsapp business link">

                                <small id="whatsappHelp" class="form-text text-muted">Let your customers view you on
                                    WhatsApp</small>

                            </div>



                            <input type="submit" class="btn btn-danger" name="savePreview" value="Save and Preview">
                            <input type="submit" class="btn btn-success" name="publishStore" value="Publish Store">

                        </form>
                    </div>

                </div>
            </div>
        </div>



        {{-- Edit Store --}}
        @isset($data['myStore'])
            <div class="modal fade" id="editStoreModal">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Update eStore</h5>
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
                                        aria-describedby="headerTitleHelp" placeholder="Enter header title"
                                        value="{{ $data['myStore']->headerTitle }}" required>

                                    <small id="headerTitleHelp" class="form-text text-muted">If HEADER CONTENT IMAGE is more
                                        than one (1), separate by comma (,)</small>

                                </div>


                                <div class="form-group">
                                    <label for="headerSubtitle">Header Sub-title Text </label>
                                    <input type="text" class="form-control" name="headerSubtitle" id="headerSubtitle"
                                        aria-describedby="headerSubtitleHelp" placeholder="Enter header sub-title"
                                        value="{{ $data['myStore']->headerSubtitle }}" required>

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
                                        aria-describedby="advertTitleHelp" placeholder="Enter advert title"
                                        value="{{ $data['myStore']->advertTitle }}">

                                    <small id="advertTitleHelp" class="form-text text-muted">If ADVERT CONTENT IMAGE is more
                                        than one (1), separate by comma (,)</small>

                                </div>


                                <div class="form-group">
                                    <label for="advertSubtitle">Advert Sub-title Text </label>
                                    <input type="text" class="form-control" name="advertSubtitle" id="advertSubtitle"
                                        aria-describedby="advertSubtitleHelp" placeholder="Enter advert sub-title"
                                        value="{{ $data['myStore']->advertSubtitle }}">

                                    <small id="advertSubtitleHelp" class="form-text text-muted">If ADVERT CONTENT IMAGE is more
                                        than one (1), separate by comma (,)</small>

                                </div>

                                <div class="form-group">
                                    <label for="advertSubtitle">Advert Sub-title Text </label>
                                    <input type="text" class="form-control" name="advertSubtitle" id="advertSubtitle"
                                        aria-describedby="advertSubtitleHelp" placeholder="Enter advert sub-title"
                                        value="{{ $data['myStore']->advertSubtitle }}">

                                    <small id="advertSubtitleHelp" class="form-text text-muted">If ADVERT CONTENT IMAGE is more
                                        than one (1), separate by comma (,)</small>

                                </div>


                                <div class="form-group">
                                    <label for="advertSubtitle">Return and Refund Policy </label>

                                    <textarea name="refundPolicy" id="refundPolicy" cols="30" rows="10"
                                        class="form-control">{{ $data['myStore']->refundPolicy }}</textarea>

                                    <small id="advertSubtitleHelp" class="form-text text-muted">Here is to assertain your
                                        customers of your return and refund policy</small>

                                </div>


                                <div class="form-group">
                                    <label for="facebook">Facebook Link </label>
                                    <input type="text" class="form-control" name="facebook" id="facebook"
                                        aria-describedby="facebookHelp" placeholder="Enter your facebook link"
                                        value="{{ $data['myStore']->facebook }}">

                                    <small id="facebookHelp" class="form-text text-muted">Let your customers view you on
                                        facebook</small>

                                </div>
                                <div class="form-group">
                                    <label for="twitter">Twitter Link </label>
                                    <input type="text" class="form-control" name="twitter" id="twitter"
                                        aria-describedby="twitterHelp" placeholder="Enter your twitter link"
                                        value="{{ $data['myStore']->twitter }}">

                                    <small id="twitterHelp" class="form-text text-muted">Let your customers view you on
                                        twitter</small>

                                </div>
                                <div class="form-group">
                                    <label for="instagram">Instagram Link </label>
                                    <input type="text" class="form-control" name="instagram" id="instagram"
                                        aria-describedby="instagramHelp" placeholder="Enter your instagram link"
                                        value="{{ $data['myStore']->instagram }}">

                                    <small id="instagramHelp" class="form-text text-muted">Let your customers view you on
                                        instagram</small>

                                </div>
                                <div class="form-group">
                                    <label for="whatsapp">Whatsapp Link </label>
                                    <input type="text" class="form-control" name="whatsapp" id="whatsapp"
                                        aria-describedby="whatsappHelp" placeholder="Enter your whatsapp business link"
                                        value="{{ $data['myStore']->whatsapp }}">

                                    <small id="whatsappHelp" class="form-text text-muted">Let your customers view you on
                                        WhatsApp</small>

                                </div>





                                <input type="submit" class="btn btn-danger" name="savePreview" value="Save and Preview">
                                <input type="submit" class="btn btn-success" name="publishStore" value="Publish Store">

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        @endisset


    </div>
@endsection
