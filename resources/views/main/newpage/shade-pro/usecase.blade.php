@extends('layouts.newpage.app')

@section('content')
<style>
@import url("https://fonts.googleapis.com/css2?family=Karla:wght@300;400;700&display=swap");

/* Fonts and colors variables */
:root {
	--shadow-green: #9bc1bc;
	--riptide: #79e5cb;
	--matise: #2374ab;
	--white: #fff;

	--base-font: "Karla", sans-serif;
}

/* Reset styles and also used Normalize */
* {
	padding: 0;
	margin: 0;
	box-sizing: border-box;
}
/* .hero-container{
  margin-bottom: 52px  
} */

body {
	background-color: #f2f2f2;
	font-family: var(--base-font);
}

img {
	width: 100%;
	vertical-align: top;
}

.container {
	width: 100%;
	max-width: 1000px;
	margin-top: 50px;
	margin-bottom: 100px;
	margin-left: auto;
	margin-right: auto;
	padding: 0 20px;

	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 40px;
}


/* Card */
.product-card {
	max-width: 200px;
	flex-basis: 180px;
	flex-grow: 1;
	background-color: var(--white);
}
	@media screen and (max-width: 440px) {
		max-width: 100%;
	}


	/* Top part of the card */
	.product-card__images {
		cursor: pointer;
		position: relative;
    }
		/* Show the 'see more' button on hover */
        .product-card__images:hover,
        .product-card__images:focus {
			.product-card__btn {
				display: block;
			}
		}
	

	.product-card__img {
    }
		.product-card--hidden {
			opacity: 0;
			position: absolute;
			left: 0;
			top: 0;
			transition: 0.3s;
        }
			.product-card:hover {
				opacity: 1;
			}
		
	

	/* Bottom part of the card */
	.product-card__info {
		padding: 10px;
		text-align: center;
	}

	.product-card__name {
		font-size: 13px;
		font-weight: normal;
		text-transform: capitalize;
	}

	.product-card__price {
		color: var(--matise);
		font-size: 13px;
		margin: 10px 0;
	}

	.product-card__promo {
		color: #000;
		margin-left: 5px;
		text-decoration: line-through;
	}

	.product-card__stars {
		color: var(--matise);
	}

	.product-card__review-count {
		color: #000;
		font-size: 13px;
		font-weight: 300;
	}

	/* Like button */
	.product-card__like {
		color: var(--riptide);
		cursor: pointer;
		font-size: 30px;
		left: 15px;
		position: absolute;
		top: 15px;
	}

	/* Hide the checkbox and the filled heart by default */
	.product-card__like-check,
	.product-card__heart--filled {
		display: none;
	}

	/* Toggle hearts display w/CSS */
	.product-card__like-check {
		&:checked + .product-card__heart {
			display: none;
			+ .product-card__heart--filled {
				display: inline;
			}
		}
	}

	/* See more button */
	.product-card__btn {
		background-color: var(--riptide);
		border-radius: 5px;
		border: none;
		color: var(--white);
		cursor: pointer;
		display: none;
		font-size: 14px;
		font-weight: bold;
		left: 50%;
		padding: 10px 15px;
		position: absolute;
		top: 50%;
		transform: translate(-50%, -50%);
		width: 50%;

		&:hover {
			background-color: var(--shadow-green);
		}
	}

</style>
    <div class="hero-container" >
        <div class="col-xl-8 col-lg-9">
            <div class="px-md-15 text-center">
                <h2 class="title gr-text-2 mb-8 mb-lg-10">case</h2>
                {{-- <p class="gr-text-7 mb-0 mb-lg-13">Full Time, Remote</p> --}}



            </div>
        </div>
    

     <div class="container" >
       
        <div class="product-card">
            <div class="product-card__images">
                <div class="product-card__img">
                    <img class="img-1" src="https://raw.githubusercontent.com/Javieer57/e-commerce-cards/807c6da77f7ed83f22f4c569c5281d43dbe73656/img/card_item_1.jpg" />
                </div>


                {{-- <label class="product-card__like">
                    <input class="product-card__like-check" aria-label="like this product" type="checkbox" />
                    <i class="product-card__heart far fa-heart"></i>
                    <i class="product-card__heart--filled fas fa-heart"></i>
                </label>

                <button class="product-card__btn">See more</button> --}}
            </div>

            <div class="product-card__info">
                <h3 class="product-card__name">SHINee The Story of Light Dad Hat</h3>

                <div class="product-card__price">
                    <span>$25.00</span>
                    <span class="product-card__promo">$30.00</span>
                </div>

                <div class="product-card__stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                    <span class="product-card__review-count">(16)</span>
                </div>
            </div>
        </div>

        <div class="product-card">
            <div class="product-card__images">
                <div class="product-card__img">
                    <img class="img-1" src="https://raw.githubusercontent.com/Javieer57/e-commerce-cards/807c6da77f7ed83f22f4c569c5281d43dbe73656/img/card_item_3.jpg" />
                </div>


                {{-- <label class="product-card__like">
                    <input class="product-card__like-check" aria-label="like this product" type="checkbox" />
                    <i class="product-card__heart far fa-heart"></i>
                    <i class="product-card__heart--filled fas fa-heart"></i>
                </label>

                <button class="product-card__btn">See more</button> --}}
            </div>

            <div class="product-card__info">
                <h3 class="product-card__name">BoA Debut 20th Anniversary Big Soju Glass</h3>

                <div class="product-card__price">
                    <span>$25.00</span>
                </div>

                <div class="product-card__stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                    <span class="product-card__review-count">(10)</span>
                </div>
            </div>
        </div>

        <div class="product-card">
            <div class="product-card__images">
                <div class="product-card__img">
                    <img class="img-1" src="https://raw.githubusercontent.com/Javieer57/e-commerce-cards/807c6da77f7ed83f22f4c569c5281d43dbe73656/img/card_item_8.jpg" />
                </div>


                {{-- <label class="product-card__like">
                    <input class="product-card__like-check" aria-label="like this product" type="checkbox" />
                    <i class="product-card__heart far fa-heart"></i>
                    <i class="product-card__heart--filled fas fa-heart"></i>
                </label>

                <button class="product-card__btn">See more</button> --}}
            </div>

            <div class="product-card__info">
                <h3 class="product-card__name">Pre-Order - aespa Logo Printed Sweatshirts</h3>

                <div class="product-card__price">
                    <span>$42.00</span>
                </div>

                <div class="product-card__stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <span class="product-card__review-count">(11)</span>
                </div>
            </div>
        </div>

        <div class="product-card">
            <div class="product-card__images">
                <div class="product-card__img">
                    <img class="img-1" src="https://raw.githubusercontent.com/Javieer57/e-commerce-cards/807c6da77f7ed83f22f4c569c5281d43dbe73656/img/card_item_5.jpg" />
                </div>

{{--               
                <label class="product-card__like">
                    <input class="product-card__like-check" aria-label="like this product" type="checkbox" />
                    <i class="product-card__heart far fa-heart"></i>
                    <i class="product-card__heart--filled fas fa-heart"></i>
                </label>

                <button class="product-card__btn">See more</button> --}}
            </div>

            <div class="product-card__info">
                <h3 class="product-card__name">SHINee Official Fanlight (Lightstick)</h3>

                <div class="product-card__price">
                    <span>$50.00</span>
                </div>

                <div class="product-card__stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <span class="product-card__review-count">(311)</span>
                </div>
            </div>
        </div>
     </div>
    </div> 
    

@endsection