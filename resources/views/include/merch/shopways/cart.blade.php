       <!-- mini cart start -->


       <div class="mini-cart" id="cartRec">
           <a href="javascript:void(0)" class="shopping-cart-close"><i class="ion-close-round"></i></a>
           <div class="cart-item-title">
               <p>
                   <span class="cart-count-desc">There are</span>
                   <span class="cart-count-item bigcounter">{{ count($data['mycartlist']) }}</span>
                   <span class="cart-count-desc">Products</span>
               </p>
           </div>
           <ul class="cart-item-loop">

               @php

                   $totalPrice = 0;

               @endphp

               @if (count($data['mycartlist']) > 0)



                   @foreach ($data['mycartlist'] as $cartList)
                       <li class="cart-item">
                           <div class="cart-img">
                               <a href="javascript:void(0)">
                                   <img src="{{ $cartList->productImage }}" alt="cart-image" class="img-fluid">
                               </a>
                           </div>
                           <div class="cart-title">
                               <h6><a href="javascript:void(0)">{{ $cartList->productName }}</a></h6>
                               <div class="cart-pro-info">
                                   <div class="cart-qty-price">
                                       <span class="quantity">{{ $cartList->quantity }} x </span>
                                       <span
                                           class="price-box">{{ $data['user']->currencySymbol . number_format($cartList->price, 2) }}</span>
                                       <hr>
                                       <span
                                           class="price-box">{{ $data['user']->currencySymbol . number_format($cartList->price * $cartList->quantity, 2) }}</span>
                                   </div>
                                   <div class="delete-item-cart">
                                       <a href="javascript:void(0)" onclick="deleteFromCart('{{ $cartList->id }}')"><i
                                               class="icon-trash icons"></i></a>
                                   </div>
                               </div>
                           </div>
                       </li>

                       @php $totalPrice += $cartList->quantity * $cartList->price; @endphp
                   @endforeach
               @else
                   <li class="cart-item">
                       <h4 class="text-center">No item in cart</h4>
                   </li>

               @endif


           </ul>
           <ul class="subtotal-title-area">
               <li class="subtotal-info">
                   <div class="subtotal-titles">
                       <h6>Sub total:</h6>
                       <span
                           class="subtotal-price">{{ $data['user']->currencySymbol . number_format($totalPrice, 2) }}</span>
                   </div>
               </li>
               <li class="mini-cart-btns">
                   <div class="cart-btns">
                       <a href="{{ route('customer shoping cart', 'store=' . $data['user']->businessname) }}"
                           class="btn btn-style1">View cart</a>
                       <a href="{{ route('checkout item', 'store=' . $data['user']->businessname) }}"
                           class="btn btn-style1">Checkout</a>
                   </div>
               </li>
           </ul>
       </div>
       <!-- mini cart end -->
