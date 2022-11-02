



@extends('layouts.newpage.merchantapp')

@section('content')
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="robots" content="noindex,nofollow">

  <link rel="canonical" href="https://info.gartnerdigitalmarkets.com/paysprint-gdm-lp">

  <link rel="shortcut icon" href="http://v.fastcdn.co/u/e36f2c7e/62520496-0-paysprint-jpeg-black.jpg" type="image/ico">
  <title>PaySprint | Payment Processing Software</title>

  <meta property="og:locale" content="en_US">
  <meta property="og:type" content="article">
  <meta property="og:title" content="">
  <meta property="og:description" content="">
  <meta property="og:site_name" content="">
  <meta property="og:url" content="https://info.gartnerdigitalmarkets.com/paysprint-gdm-lp">


  <link rel="preload" as="script" href="http://g.fastcdn.co/js/utils.cd5b4894ab46ac49c25b.js">
  </link>
  <link rel="preload" as="script" href="http://g.fastcdn.co/js/Cradle.2834144546d6c56f4dd5.js">
  </link>
  <link rel="preload" as="script" href="http://g.fastcdn.co/js/UserConsent.774850cdd67203cf7eb7.js">
  </link>
  <link rel="preload" as="script" href="http://g.fastcdn.co/js/LazyImage.90aa95d960c719e556c2.js">
  </link>
  <link rel="preload" as="script" href="http://g.fastcdn.co/js/Form.9913500b352375ec139e.js">
  </link>
  <link rel="preconnect dns-prefetch" href="https://fonts.gstatic.com/" crossorigin>
  </link>
  <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"
/>




{{-- 
  <link type="text/css" rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,100italic,300italic,400italic,500italic,,700italic,900italic" /> --}}
  <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700" /> 


  <style type="text/css" media="screen">
    body {
      -moz-osx-font-smoothing: grayscale;
      -webkit-font-smoothing: antialiased;
      margin: 0;
      width: 100%;
      font-family: Roboto;
      font-weight: 400;
      background: rgb(255, 255, 255);
    }

    /* start review */
    h3{
      text-align: center;
      font-size: 30px;
      margin: 0;
      padding-top: 10px;
      }
      a{
      text-decoration: none;
      }
      .gallery{
      display: flex;
      flex-wrap: wrap;
      width: 100%;
      justify-content: center;
      align-items: center;
      margin: 50px 0;
      }
      .content{
      width: 30%;
      margin: 15px;
      box-sizing: border-box;
      float: left;
      text-align: center;
      border-radius:10px;
      border-top-right-radius: 10px;
      border-bottom-right-radius: 10px;
      padding-top: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      transition: .4s;
      }
      .content:hover{
      box-shadow: 0 0 11px rgba(33,33,33,.2);
      transform: translate(0px, -8px);
      transition: .6s;
      }
     h3{
      padding-bottom: 5px;
     }
      h4{
      text-align: center;
  
      padding: 0 8px;
      padding-bottom: 3px;
      }
      h6{
      font-size: 26px;
      text-align: center;
 
      margin: 0;
      padding-bottom: 10px;
      }
      .list-star{
      list-style-type: none;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 0px;
      }
      .star{
      padding: 5px;
      }
      .fa{
      color: #ff9f43;
      font-size: 10px;
      transition: .4s;
      }
      .fa:hover{
      transform: scale(1.3);
      transition: .6s;
      }
  
      @media(max-width: 1000px){
      .content{
      width: 46%;
      }
      }
      @media(max-width: 750px){
      .content{
      width: 100%;
      }
      }
      /* end */

    a {
      text-decoration: none;
      color: inherit;
      cursor: pointer;
    }

    a:not(.btn):hover {
      text-decoration: underline;
    }

    input,
    select,
    textarea,
    p,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      margin: 0;
      font-size: inherit;
      font-weight: inherit;
    }

    main {
      overflow: hidden;
    }

    u>span {
      text-decoration: inherit;
    }

    ol,
    ul {
      padding-left: 2.5rem;
      margin: .625rem 0;
    }

    p {
      word-wrap: break-word;
    }

    h1>span,
    h2>span,
    h3>span,
    h4>span,
    h5>span,
    h6>span {
      display: block;
      word-wrap: break-word;
    }

    iframe {
      border: 0;
    }

    * {
      box-sizing: border-box;
    }

    :root.js-text-scaling {
      --mobile-font-size: 4vw;
      --default-font-size: 16px;
    }

    .item-absolute {
      position: absolute;
    }

    .item-relative {
      position: relative;
    }

    .item-block {
      display: block;
      height: 100%;
      width: 100%;
    }

    .item-cover {
      z-index: 1000030;
    }

    .item-breakword {
      word-wrap: break-word;
    }

    .item-content-box {
      box-sizing: content-box;
    }

    .hidden {
      display: none;
    }

    .clearfix {
      clear: both;
    }

    sup {
      margin-left: 0.1rem;
      line-height: 0;
    }

    @keyframes slide-down {
      from {
        opacity: 0;
        transform: translateY(-50px);
      }
    }

    @keyframes fade-in {
      from {
        opacity: 0;
      }
    }

    @supports (-webkit-overflow-scrolling:touch) {

      @media (-webkit-min-device-pixel-ratio:2),
      (min-resolution:192dpi) {
        .image[src$=".svg"] {
          width: calc(100% + 1px);
        }
      }
    }

    .show-for-sr {
      border: 0 !important;
      clip: rect(1px, 1px, 1px, 1px) !important;
      -webkit-clip-path: inset(50%) !important;
      clip-path: inset(50%) !important;
      height: 1px !important;
      margin: -1px !important;
      overflow: hidden !important;
      padding: 0 !important;
      position: absolute !important;
      width: 1px !important;
      white-space: nowrap !important;
    }

    .headline {
      font-family: Montserrat;
      font-weight: 700;
    }

    .section-fit {
      max-width: 400px;
    }
    .bullet-html{
      display: inline-block;
  width: 10px;
  height: 10px;
  margin-right: 6px;
  -webkit-border-radius: 20px;
  -moz-border-radius: 20px;
  -ms-border-radius: 20px;
  -o-border-radius: 20px;
  border-radius: 20px;
  background-color: #5D329C;
    }

    :root {
      --section-relative-margin: 0 auto;
    }

    .section-relative {
      position: relative;
      margin: 0 auto;
    }

    .js-text-scaling .section-relative {
      margin: var(--section-relative-margin);
    }

    .section-inner {
      height: 100%;
    }

    #page_block_header {
      height: 73.0625rem;
      max-width: 100%;
    }

    #page_block_header .section-holder-border {
      border: 0;
    }

    #page_block_header .section-block {
      background: url(http://v.fastcdn.co/u/e36f2c7e/62518204-0-BG-lines.png) repeat rgb(244, 247, 250) 35% 87% / cover;
      height: 73.0625rem;
    }

    #page_block_header .section-holder-overlay {
      display: none;
    }

    #element-129 {
      top: 1.875rem;
      left: 1.25rem;
      height: 3.125rem;
      width: 8.875rem;
      z-index: 3;
    }

    #element-129 .cropped {
      background: url(//v.fastcdn.co/u/e36f2c7e/62518207-0-merchant.png) -0.5625rem -0.25rem / 10rem 3.8125rem;
    }

    #element-265 {
      top: 24.3125rem;
      left: 0;
      height: 6.8125rem;
      width: 6.6875rem;
      z-index: 14;
    }

    #element-139 {
      top: 26rem;
      left: 1.25rem;
      height: 20.625rem;
      width: 22.5rem;
      z-index: 15;
    }

    .circle {
      border-radius: 50%;
    }

    .shape {
      height: inherit;
    }

    .line-horizontal {
      height: .625rem;
    }

    .line-vertical {
      height: 100%;
      margin-right: .625rem;
    }
    

    [class*='line-'] {
      box-sizing: content-box;
    }

    #element-139 .shape {
      border: 0.0625rem solid #FFFFFF;
      background: rgb(249, 249, 249);
    }

    #element-139 .contents {
      font-family: Nunito !important;
      font-weight: 400 !important;
      background-color: rgb(255, 255, 255) !important;
      border-radius: 0px !important;
      border-style: solid !important;
      background-repeat: repeat !important;
      background-position: left top !important;
      background-size: cover !important;
      box-shadow: 0px 31px 21px -13px rgba(222, 222, 222, .5) !important;
    }

    #element-143 {
      top: 28.625rem;
      left: 2.5rem;
      height: 1.5rem;
      width: 20rem;
      z-index: 18;
      color: #37465A;
      font-size: 1.2384rem;
      line-height: 1.5rem;
      text-align: center;
    }

    #element-143 .x_bdb4a4e4 {
      text-align: center;
      line-height: 1.5rem;
      font-size: 1.2384rem;
    }

    #element-143 .x_93908647 {
      color: #333333;
    }

    #element-141 {
      top: 31.125rem;
      left: 3.125rem;
      height: 29.6875rem;
      width: 18.75rem;
      z-index: 17;
    }

    .btn {
      cursor: pointer;
      text-align: center;
      transition: border .5s;
      width: 100%;
      border: 0;
      white-space: normal;
      display: table-cell;
      vertical-align: middle;
      padding: 0;
      line-height: 120%;
    }

    .btn-shadow {
      box-shadow: 0 1px 3px rgba(1, 1, 1, 0.5);
    }

    .lightbox {
      display: none;
      position: fixed;
      width: 100%;
      height: 100%;
      top: 0;
    }

    .lightbox-dim {
      background: rgba(0, 0, 0, 0.85);
      height: 100%;
      animation: fade-in .5s ease-in-out;
      overflow-x: hidden;
      display: flex;
      align-items: center;
      padding: 30px 0;
    }

    .lightbox-content {
      background-color: #fefefe;
      border-radius: 3px;
      position: relative;
      margin: auto;
      animation: slide-down .5s ease-in-out;
    }

    .lightbox-opened {
      display: block;
    }

    .lightbox-close {
      width: 26px;
      right: 0;
      top: -10px;
      cursor: pointer;
    }

    .lightbox-close-btn {
      padding: 0;
      border: none;
      background: none;
    }

    .lightbox-btn-svg {
      display: block;
    }

    .lightbox-close-icon {
      fill: #fff;
    }

    .notification-text {
      font-size: 1.5rem;
      color: #fff;
      text-align: center;
      width: 100%;
    }

    .modal-on {
      overflow: hidden;
    }

    .form {
      font-size: 1.25rem;
    }

    fieldset {
      margin: 0;
      padding: 0;
      border: 0;
      min-width: 0;
    }

    .form-input {
      color: transparent;
      background-color: transparent;
      border: 1px solid transparent;
      border-radius: 3px;
      font-family: inherit;
      width: 100%;
      height: 3.5rem;
      margin: 0.5rem 0;
      padding: 0.5rem 0.625rem 0.5625rem;
    }

    .form-input::placeholder {
      opacity: 1;
      color: transparent;
    }

    .form-textarea {
      display: inline-block;
      vertical-align: top;
    }

    .form-select {
      background: url("//v.fastcdn.co/a/img/builder2/select-arrow-drop-down.png") no-repeat right;
      -webkit-appearance: none;
      -moz-appearance: none;
      color: transparent;
    }

    .form-label {
      display: inline-block;
      color: transparent;
    }

    .form-label-title {
      display: block;
      line-height: 1.1;
      width: 100%;
      padding: 0.75rem 0 0.5625rem;
      margin: 0.5rem 0 0.125rem;
    }

    .form-multiple-label:empty {
      display: block;
      height: 0.8rem;
      margin-top: .375rem;
    }

    .form-label-outside {
      margin: 0.3125rem 0 0;
    }

    .form-multiple-input {
      position: absolute;
      opacity: 0;
    }

    .form-multiple-label {
      position: relative;
      padding-top: 0.75rem;
      line-height: 1.05;
      margin-left: 1.5625rem;
    }

    .form-multiple-label:before {
      content: "";
      display: inline-block;
      box-sizing: inherit;
      width: 1rem;
      height: 1rem;
      background-color: #fff;
      border-radius: 0.25rem;
      border: 1px solid #8195a8;
      margin-right: 0.5rem;
      vertical-align: -2px;
      position: absolute;
      left: -1.5625rem;
    }

    .form-checkbox-label:after {
      content: "";
      width: 0.25rem;
      height: 0.5rem;
      position: absolute;
      top: 0.8rem;
      left: -1.25rem;
      transform: rotate(45deg);
      border-right: 0.1875rem solid;
      border-bottom: 0.1875rem solid;
      color: #fff;
    }
    .swiper {
      width: 600px;
      height: 300px;
      }

    .form-radio-label:before {
      border-radius: 50%;
    }

    .form-multiple-input:focus+.form-multiple-label:before {
      border: 2px solid #308dfc;
    }

    .form-multiple-input:checked+.form-radio-label:before {
      border: 0.3125rem solid #308dfc;
    }

    .form-multiple-input:checked+.form-checkbox-label:before {
      background-color: #308dfc;
      border: 0;
    }

    .form-btn {
      -webkit-appearance: none;
      -moz-appearance: none;
      background-color: transparent;
      border: 0;
      cursor: pointer;
      min-height: 100%;
    }

    .form-input-inner-shadow {
      box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.28);
    }

    body#landing-page .user-invalid-label {
      color: #e85f54;
    }

    body#landing-page .user-invalid {
      border-color: #e85f54;
    }

    .form-messagebox {
      transform: translate(0.4375rem, -0.4375rem);
    }

    .form-messagebox:before {
      content: "";
      position: absolute;
      display: block;
      width: 0.375rem;
      height: 0.375rem;
      transform: rotate(45deg);
      background-color: #e85f54;
      top: -0.1875rem;
      left: 25%;
    }

    .form-messagebox-contents {
      font-size: 0.875rem;
      font-weight: 500;
      color: #fff;
      background-color: #e85f54;
      padding: 0.4375rem 0.9375rem;
      max-width: 250px;
      word-wrap: break-word;
      margin: auto;
    }

    .form-messagebox-top {
      transform: translate(0, -1rem);
    }

    .form-messagebox-top:before {
      bottom: -0.1875rem;
      top: auto;
    }

    #element-141 .btn.btn-effect3d:active {
      box-shadow: none;
    }

    #element-141 .btn:hover {
      background: #DDC014;
      color: #333333;
    }

    #element-141 .btn {
      background: #F7E36B;
      color: #333333;
      font-size: 1.2384rem;
      font-family: Montserrat;
      font-weight: 700;
      height: 3.6875rem;
      width: 18.75rem;
      border-radius: 3px;
    }

    #element-141 .form-label {
      color: #333333;
    }

    #element-141 ::placeholder {
      color: #333333;
    }

    #element-141 .form-input {
      color: #333333;
      background-color: #FFFFFF;
      border-color: #D7D7D7;
    }

    #element-141 .user-invalid {
      border-color: #E12627;
    }

    #element-141 input::placeholder,
    #element-141 .form-label-inside {
      color: #333333;
    }

    #element-141 select.valid {
      color: #333333;
    }

    #element-141 .form-btn-geometry {
      top: 31.5625rem;
      left: 0.0625rem;
      height: 3.6875rem;
      width: 18.75rem;
      z-index: 17;
    }

    #element-130 {
      top: 8.125rem;
      left: 1.25rem;
      height: 4.875rem;
      width: 20.625rem;
      z-index: 4;
      color: #37465A;
      font-size: 1.7337rem;
      line-height: 2.45rem;
      text-align: left;
    }

    #element-130 .x_027b22ed {
      text-align: left;
      line-height: 2.4375rem;
      font-size: 1.7337rem;
    }

    #element-131 {
      top: 13.9375rem;
      left: 1.25rem;
      height: 7.25rem;
      width: 19.3125rem;
      z-index: 5;
      color: #37465A;
      font-size: 1.1146rem;
      line-height: 1.8rem;
      text-align: left;
    }

    #element-131 .x_b6c3675a {
      text-align: left;
      line-height: 1.8125rem;
      font-size: 1.1146rem;
   
    }

    #element-136 {
      top: 22.125rem;
      left: 2.75rem;
      height: 1.625rem;
      width: 9.125rem;
      z-index: 10;
      color: #37465A;
      font-size: 0.9907rem;
      line-height: 1.6rem;
      text-align: left;
    }

    #element-136 .x_8b9ce48e {
      text-align: left;
      line-height: 1.625rem;
      font-size: 0.9907rem;
    }

    #element-132 {
      top: 22.625rem;
      left: 1.25rem;
      height: 0.75rem;
      width: 0.75rem;
      z-index: 6;
    }

    #element-132 .shape {
      border: 0;
      background: rgb(28, 16, 207);
    }

    #element-137 {
      top: 24.375rem;
      left: 2.8125rem;
      height: 1.625rem;
      width: 12.0625rem;
      z-index: 11;
      color: #37465A;
      font-size: 0.9907rem;
      line-height: 1.6rem;
      text-align: left;
    }

    #element-137 .x_8b9ce48e {
      text-align: left;
      line-height: 1.625rem;
      font-size: 0.9907rem;
    }

    #element-133 {
      top: 24.875rem;
      left: 1.25rem;
      height: 0.75rem;
      width: 0.75rem;
      z-index: 8;
    }

    #element-133 .shape {
      border: 0;
      background: rgb(28, 16, 207);
    }

    #element-138 {
      top: 26.625rem;
      left: 2.75rem;
      height: 1.625rem;
      width: 7.4375rem;
      z-index: 13;
      color: #37465A;
      font-size: 0.9907rem;
      line-height: 1.6rem;
      text-align: left;
    }

    #element-138 .x_8b9ce48e {
      text-align: left;
      line-height: 1.625rem;
      font-size: 0.9907rem;
    }

    #element-134 {
      top: 27.125rem;
      left: 1.25rem;
      height: 0.75rem;
      width: 0.75rem;
      z-index: 9;
    }

    #element-134 .shape {
      border: 0;
      background: rgb(28, 16, 207);
    }

    #page-block-5yg6cfwpzsk {
      height: 50.9375rem;
      max-width: 100%;
    }

    #page-block-5yg6cfwpzsk .section-holder-border {
      border: 0;
    }

    #page-block-5yg6cfwpzsk .section-block {
      background: rgb(255, 255, 255);
      height: 50.9375rem;
    }

    #page-block-5yg6cfwpzsk .section-holder-overlay {
      display: none;
    }

    #element-162 {
      top: 3.125rem;
      left: 1.25rem;
      height: 6.5625rem;
      width: 18.1875rem;
      z-index: 21;
      color: #37465A;
      font-size: 1.548rem;
      line-height: 2.1875rem;
      text-align: left;
    }

    #element-162 .x_26d449b5 {
      text-align: left;
      line-height: 2.1875rem;
      font-size: 1.548rem;
    }

    #element-162 .x_93908647 {
      color: #333333;
    }

    #element-163 {
      top: 10.625rem;
      left: 1.25rem;
      height: 5.4375rem;
      width: 18.1875rem;
      z-index: 22;
      color: #37465A;
      font-size: 1.1146rem;
      line-height: 1.8rem;
      text-align: left;
    }

    #element-163 .x_8c071feb {
      text-align: left;
      line-height: 1.8125rem;
      font-size: 1.1146rem;
    }

    #element-163 .x_93908647 {
      color: #333333;
    }

    #element-243 {
      top: 18.25rem;
      left: 1.25rem;
      height: 2.375rem;
      width: 2.1875rem;
      z-index: 42;
    }

    #element-150 {
      top: 18.25rem;
      left: 4.375rem;
      height: 3.5rem;
      width: 14.1875rem;
      z-index: 41;
      color: #37465A;
      font-size: 1.2384rem;
      line-height: 1.75rem;
      text-align: left;
    }

    #element-150 .x_b558b569 {
      text-align: left;
      line-height: 1.75rem;
      font-size: 1.2384rem;
    }

    #element-150 .x_93908647 {
      color: #333333;
    }

    #element-245 {
      top: 23.625rem;
      left: 1.25rem;
      height: 2.375rem;
      width: 2.1875rem;
      z-index: 46;
    }

    #element-156 {
      top: 23.625rem;
      left: 4.375rem;
      height: 3.5rem;
      width: 16.25rem;
      z-index: 45;
      color: #37465A;
      font-size: 1.2384rem;
      line-height: 1.75rem;
      text-align: left;
    }

    #element-156 .x_b558b569 {
      text-align: left;
      line-height: 1.75rem;
      font-size: 1.2384rem;
    }

    #element-156 .x_93908647 {
      color: #333333;
    }

    #element-247 {
      top: 29rem;
      left: 1.25rem;
      height: 2.375rem;
      width: 2.1875rem;
      z-index: 50;
    }

    #element-158 {
      top: 29rem;
      left: 4.375rem;
      height: 3.5rem;
      width: 17.5625rem;
      z-index: 49;
      color: #37465A;
      font-size: 1.2384rem;
      line-height: 1.75rem;
      text-align: left;
    }

    #element-158 .x_b558b569 {
      text-align: left;
      line-height: 1.75rem;
      font-size: 1.2384rem;
    }

    #element-158 .x_93908647 {
      color: #333333;
    }

    #element-244 {
      top: 34.375rem;
      left: 1.25rem;
      height: 2.375rem;
      width: 2.1875rem;
      z-index: 44;
    }

    #element-154 {
      top: 34.375rem;
      left: 4.375rem;
      height: 3.5rem;
      width: 14.125rem;
      z-index: 43;
      color: #37465A;
      font-size: 1.2384rem;
      line-height: 1.75rem;
      text-align: left;
    }

    #element-154 .x_b558b569 {
      text-align: left;
      line-height: 1.75rem;
      font-size: 1.2384rem;
    }

    #element-154 .x_93908647 {
      color: #333333;
    }

    #element-246 {
      top: 39.75rem;
      left: 1.25rem;
      height: 2.375rem;
      width: 2.1875rem;
      z-index: 48;
    }

    #element-152 {
      top: 39.75rem;
      left: 4.375rem;
      height: 3.5rem;
      width: 16.25rem;
      z-index: 47;
      color: #37465A;
      font-size: 1.2384rem;
      line-height: 1.75rem;
      text-align: left;
    }

    #element-152 .x_b558b569 {
      text-align: left;
      line-height: 1.75rem;
      font-size: 1.2384rem;
    }

    #element-152 .x_93908647 {
      color: #333333;
    }

    #element-248 {
      top: 45.125rem;
      left: 1.25rem;
      height: 2.375rem;
      width: 2.1875rem;
      z-index: 52;
    }

    #element-160 {
      top: 45.4375rem;
      left: 4.375rem;
      height: 1.75rem;
      width: 15.25rem;
      z-index: 51;
      color: #37465A;
      font-size: 1.2384rem;
      line-height: 1.75rem;
      text-align: left;
    }

    #element-160 .x_b558b569 {
      text-align: left;
      line-height: 1.75rem;
      font-size: 1.2384rem;
    }

    #element-160 .x_93908647 {
      color: #333333;
    }

    #page-block-3cg5fcg36ot {
      height: 75.8125rem;
      max-width: 100%;
    }

    #page-block-3cg5fcg36ot .section-holder-border {
      border: 0;
    }

    #page-block-3cg5fcg36ot .section-block {
      background: rgb(242, 242, 242);
      height: 75.8125rem;
    }

    #page-block-3cg5fcg36ot .section-holder-overlay {
      display: none;
    }

    #element-215 {
      top: 3.125rem;
      left: 1.25rem;
      height: 8.75rem;
      width: 16.75rem;
      z-index: 32;
      color: #37465A;
      font-size: 1.548rem;
      line-height: 2.1875rem;
      text-align: left;
    }

    #element-215 .x_26d449b5 {
      text-align: left;
      line-height: 2.1875rem;
      font-size: 1.548rem;
    }

    #element-215 .x_93908647 {
      color: #333333;
    }

    #element-256 {
      top: 18.1875rem;
      left: 1.25rem;
      height: 2.8125rem;
      width: 2.5625rem;
      z-index: 58;
     
    }

    #element-197 {
      top: 17.75rem;
      left: 1.25rem;
      height: 1.4375rem;
      width: 21.125rem;
      z-index: 56;
      color: #37465A;
      font-size: 1.1765rem;
      line-height: 1.425rem;
      text-align: left;
    }

    #element-197 .x_561aca13 {
      text-align: left;
      line-height: 1.4375rem;
      font-size: 1.1765rem;
    }

    #element-197 .x_93908647 {
      color: #333333;
    }

    #element-198 {
      top: 19.875rem;
      left: 1.25rem;
      height: 4.5rem;
      width: 18.5625rem;
      z-index: 57;
      color: #37465A;
      font-size: 1.0526rem;
      line-height: 1.4875rem;
      text-align: left;
    }

    #element-198 .x_4976ff6a {
      text-align: left;
      line-height: 1.5rem;
      font-size: 1.0526rem;
    }

    #element-198 .x_93908647 {
      color: #333333;
    }

    #element-266 {
      top: 49.8125rem;
      left: 0;
      height: 6.8125rem;
      width: 6.6875rem;
      z-index: 16;
    }

    #element-208 {
      top: 51.5rem;
      left: 1.25rem;
      height: 20.8125rem;
      width: 22.5rem;
      z-index: 23;
    }

    #element-208 .shape {
      border: 0;
      border-radius: 0.3125rem 0.3125rem 0.3125rem 0.3125rem;
      background: rgb(242, 242, 242);
    }

    #element-208 .contents {
      font-family: Roboto !important;
      font-weight: 400 !important;
      background-color: rgb(255, 255, 255) !important;
      border-radius: 5px !important;
      border-color: rgba(0, 0, 0, 0) !important;
      border-width: 1px !important;
      border-style: solid !important;
      background-repeat: repeat !important;
      background-position: left top !important;
      background-size: cover !important;
      box-shadow: 0px 31px 21px -13px rgba(222, 222, 222, .5) !important;
    }

    #element-207 {
      top: 54.25rem;
      left: 3.8125rem;
      height: 3.125rem;
      width: 17.375rem;
      z-index: 25;
      color: #37465A;
      font-size: 1.1146rem;
      line-height: 1.575rem;
      text-align: left;
    }

    #element-207 .x_9a9d3d17 {
      text-align: left;
      line-height: 1.5625rem;
      font-size: 1.1146rem;
    }

    #element-207 .x_93908647 {
      color: #333333;
    }

    #element-209 {
      top: 58.6875rem;
      left: 3.875rem;
      height: 1.3125rem;
      width: 5.6875rem;
      z-index: 24;
    }

    #element-214 {
      top: 61.25rem;
      left: 3.875rem;
      height: 1.75rem;
      width: 10.8125rem;
      z-index: 31;
      color: #37465A;
      font-size: 1.2384rem;
      line-height: 1.75rem;
      text-align: left;
    }

    #element-214 .x_b558b569 {
      text-align: left;
      line-height: 1.75rem;
      font-size: 1.2384rem;
    }

    #element-214 .x_93908647 {
      color: #333333;
    }

    #element-210 {
      top: 63.3125rem;
      left: 3.875rem;
      height: 1.5rem;
      width: 10.8125rem;
      z-index: 26;
      color: #37465A;
      font-size: 0.9288rem;
      line-height: 1.5rem;
      text-align: left;
    }

    #element-210 .x_62b81fb4 {
      text-align: left;
      line-height: 1.5rem;
      font-size: 0.9288rem;
    }

    #element-210 .x_93908647 {
      color: #333333;
    }

    #element-211 {
      top: 65.625rem;
      left: 3.8125rem;
      height: 1.3125rem;
      width: 17.375rem;
      z-index: 27;
    }

    #element-211 .shape {
      border-bottom: 1px solid #E2EAEE;
    }

    #element-213 {
      top: 67.875rem;
      left: 3.875rem;
      height: 1.625rem;
      width: 6.4375rem;
      z-index: 29;
      color: #37465A;
      font-size: 0.9907rem;
      line-height: 1.6rem;
      text-align: left;
    }

    #element-213 .x_fae6260b {
      text-align: left;
      line-height: 1.625rem;
      font-size: 0.9907rem;
    }

    #element-213 .x_9508b241 {
      color: #72777d;
    }

    #element-212 {
      top: 68.0625rem;
      left: 8.75rem;
      height: 1.3125rem;
      width: 5.75rem;
      z-index: 28;
    }

    #element-258 {
      top: 26.0625rem;
      left: 1.3125rem;
      height: 2.8125rem;
      width: 2.5625rem;
      z-index: 61;
    }

    #element-200 {
      top: 29.625rem;
      left: 1.3125rem;
      height: 1.4375rem;
      width: 17.0625rem;
      z-index: 59;
      color: #37465A;
      font-size: 1.1765rem;
      line-height: 1.425rem;
      text-align: left;
    }

    #element-200 .x_561aca13 {
      text-align: left;
      line-height: 1.4375rem;
      font-size: 1.1765rem;
    }

    #element-200 .x_93908647 {
      color: #333333;
    }

    #element-201 {
      top: 31.6875rem;
      left: 1.3125rem;
      height: 4.5rem;
      width: 17.0625rem;
      z-index: 60;
      color: #37465A;
      font-size: 1.0526rem;
      line-height: 1.4875rem;
      text-align: left;
    }

    #element-201 .x_4976ff6a {
      text-align: left;
      line-height: 1.5rem;
      font-size: 1.0526rem;
    }

    #element-201 .x_93908647 {
      color: #333333;
    }

    #element-255 {
      top: 37.875rem;
      left: 1.3125rem;
      height: 2.8125rem;
      width: 2.5625rem;
      z-index: 55;
    }

    #element-203 {
      top: 41.4375rem;
      left: 1.3125rem;
      height: 1.75rem;
      width: 21.5625rem;
      z-index: 53;
      color: #37465A;
      font-size: 1.2384rem;
      line-height: 1.75rem;
      text-align: left;
    }

    #element-203 .x_0fa34b5f {
      text-align: left;
      line-height: 1.75rem;
      font-size: 1.2384rem;
    }

    #element-203 .x_93908647 {
      color: #333333;
    }

    #element-204 {
      top: 43.9375rem;
      left: 1.3125rem;
      height: 3.375rem;
      width: 21.5625rem;
      z-index: 54;
      color: #37465A;
      font-size: 1.0526rem;
      line-height: 1.7rem;
      text-align: left;
    }

    #element-204 .x_390ad34e {
      text-align: left;
      line-height: 1.6875rem;
      font-size: 1.0526rem;
    }

    #element-204 .x_93908647 {
      color: #333333;
    }

    #page-block-p0avpzvahxp {
      height: 25.75rem;
      max-width: 100%;
    }

    #page-block-p0avpzvahxp .section-holder-border {
      border: 0;
    }

    #page-block-p0avpzvahxp .section-block {
      background: rgb(255, 255, 255);
      height: 25.75rem;
    }

    #page-block-p0avpzvahxp .section-holder-overlay {
      display: none;
    }

    #element-216 {
      top: 3.125rem;
      left: 1.25rem;
      height: 6.375rem;
      width: 17.6875rem;
      z-index: 12;
      color: #37465A;
      font-size: 1.7337rem;
      line-height: 2.1rem;
      text-align: left;
    }

    #element-216 .x_21a56353 {
      text-align: left;
      line-height: 2.125rem;
      font-size: 1.7337rem;
    }

    #element-216 .x_93908647 {
      color: #333333;
    }

    #element-217 {
      top: 10.25rem;
      left: 1.25rem;
      height: 5.4375rem;
      width: 19.3125rem;
      z-index: 19;
      color: #37465A;
      font-size: 1.1146rem;
      line-height: 1.8rem;
      text-align: left;
    }

    #element-217 .x_8c071feb {
      text-align: left;
      line-height: 1.8125rem;
      font-size: 1.1146rem;
    }

    #element-217 .x_93908647 {
      color: #333333;
    }

    #element-218 {
      top: 18.1875rem;
      left: 1.25rem;
      height: 4.0625rem;
      width: 17.5rem;
      z-index: 20;
    }

    #element-218 .btn.btn-effect3d:active {
      box-shadow: none;
    }

    #element-218 .btn:hover {
      background: #DDC014;
      color: #333333;
    }

    #element-218 .btn {
      background: #F7E36B;
      color: #333333;
      font-size: 1.2384rem;
      font-family: Montserrat;
      font-weight: 700;
      height: 4.0625rem;
      width: 17.5rem;
      border-radius: 5px;
    }

    #page-block-lote38odq7l {
      height: 29.25rem;
      max-width: 100%;
    }

    #page-block-lote38odq7l .section-holder-border {
      border: 0;
    }

    #page-block-lote38odq7l .section-block {
      background: rgb(249, 249, 249);
      height: 29.25rem;
    }

    #page-block-lote38odq7l .section-holder-overlay {
      display: none;
    }

    #element-222 {
      top: 3.125rem;
      left: 1.25rem;
      height: 1.5625rem;
      width: 11.0625rem;
      z-index: 33;
      color: #37465A;
      font-size: 1.1146rem;
      line-height: 1.575rem;
      text-align: left;
    }

    #element-222 .x_9a9d3d17 {
      text-align: left;
      line-height: 1.5625rem;
      font-size: 1.1146rem;
    }

    #element-222 .x_93908647 {
      color: #333333;
    }

    #element-223 {
      top: 5.3125rem;
      left: 1.25rem;
      height: 4.875rem;
      width: 14.125rem;
      z-index: 34;
      color: #37465A;
      font-size: 0.9907rem;
      line-height: 1.6rem;
      text-align: left;
    }

    #element-223 .x_fae6260b {
      text-align: left;
      line-height: 1.625rem;
      font-size: 0.9907rem;
    }

    #element-223 .x_93908647 {
      color: #333333;
    }

    #element-224 {
      top: 12.0625rem;
      left: 15.125rem;
      height: 1.5625rem;
      width: 8.625rem;
      z-index: 35;
      color: #37465A;
      font-size: 1.1146rem;
      line-height: 1.575rem;
      text-align: left;
    }

    #element-224 .x_9a9d3d17 {
      text-align: left;
      line-height: 1.5625rem;
      font-size: 1.1146rem;
    }

    #element-224 .x_93908647 {
      color: #333333;
    }

    #element-225 {
      top: 14.25rem;
      left: 15.125rem;
      height: 1.625rem;
      width: 8.625rem;
      z-index: 36;
      color: #37465A;
      font-size: 0.9907rem;
      line-height: 1.6rem;
      text-align: left;
    }

    #element-225 .x_fae6260b {
      text-align: left;
      line-height: 1.625rem;
      font-size: 0.9907rem;
    }

    #element-225 .x_93908647 {
      color: #333333;
    }

    #element-226 {
      top: 12.0625rem;
      left: 1.25rem;
      height: 1.5625rem;
      width: 7.9375rem;
      z-index: 37;
      color: #37465A;
      font-size: 1.1146rem;
      line-height: 1.575rem;
      text-align: left;
    }

    #element-226 .x_9a9d3d17 {
      text-align: left;
      line-height: 1.5625rem;
      font-size: 1.1146rem;
    }

    #element-226 .x_93908647 {
      color: #333333;
    }

    #element-227 {
      top: 14.25rem;
      left: 1.25rem;
      height: 3.25rem;
      width: 7.9375rem;
      z-index: 38;
      color: #37465A;
      font-size: 0.9907rem;
      line-height: 1.6rem;
      text-align: left;
    }

    #element-227 .x_fae6260b {
      text-align: left;
      line-height: 1.625rem;
      font-size: 0.9907rem;
    }

    #element-227 .x_93908647 {
      color: #333333;
    }

    #element-234 {
      top: 19.375rem;
      left: 1.25rem;
      height: 1.5625rem;
      width: 12.8125rem;
      z-index: 40;
      color: #37465A;
      font-size: 1.1146rem;
      line-height: 1.575rem;
      text-align: left;
    }

    #element-234 .x_9a9d3d17 {
      text-align: left;
      line-height: 1.5625rem;
      font-size: 1.1146rem;
    }

    #element-234 .x_5e78ce6a {
      text-align: left;
      color: #333333;
    }

    #element-234 .x_93908647 {
      color: #333333;
    }

    #element-230 {
      top: 21.5625rem;
      left: 1.25rem;
      height: 3.375rem;
      width: 17.5rem;
      z-index: 39;
      color: #37465A;
      font-size: 0.6811rem;
      line-height: 1.1rem;
      text-align: left;
    }

    #element-230 .x_7b84e050 {
      text-align: left;
      line-height: 1.125rem;
      font-size: 0.6811rem;
    }

    #element-230 .x_93908647 {
      color: #333333;
    }

    #element-221 {
      top: 23rem;
      left: 1.25rem;
      height: 6.25rem;
      width: 22.5rem;
      z-index: 7;
    }

    .full-size {
      width: 100%;
      height: 100%;
    }

    .html-widget__text-center {
      text-align: center;
    }

    .snackbar {
      background-color: #fff;
      color: #37475a;
      max-width: 1200px;
      box-shadow: 0 1px 2px 0 rgba(55, 71, 90, 0.36);
      border-radius: 3px;
      font-size: 13px;
      font-family: 'Roboto', sans-serif;
      padding: 20px;
      margin: 0 auto;
      z-index: 1000020;
      position: fixed;
      bottom: 30px;
      left: 0;
      right: 0;
    }

    .snackbar-content {
      margin-bottom: 20px;
      line-height: 1.54;
      letter-spacing: 0.2px;
    }

    .snackbar-link {
      color: #1e88e5;
    }

    .snackbar-btn-group {
      float: right;
    }

    .snackbar-btn {
      color: #1e88e5;
      padding: 8px 15px;
      border: 0;
      background-color: #fff;
      font: inherit;
      text-transform: uppercase;
      cursor: pointer;
    }

    .snackbar-btn-default {
      font-size: 12px;
    }

    .snackbar-btn-cta {
      color: #fff;
      background-color: #1e88e5;
      border-radius: 3px;
      box-shadow: 0 1px 2px 0 rgba(55, 71, 90, 0.36);
      margin-left: 15px;
    }

    @media screen and (max-width:400px) {
      :root {
        font-size: 4vw;
      }

      :root.js-text-scaling {
        font-size: var(--mobile-font-size);
      }
    }

    @media screen and (min-width:401px) and (max-width:767px) {
      :root {
        font-size: 16px;
      }

      :root.js-text-scaling {
        font-size: var(--default-font-size);
      }
    }

    @media screen and (min-width:768px) and (max-width:1200px) {
      :root {
        font-size: 1.33vw;
      }
    }

    @media screen and (max-width:767px) {
      .hidden-mobile {
        display: none;
      }
    }

    @media screen and (min-width:768px) {
      .section-fit {
        max-width: 60rem;
      }

      #page_block_header {
        height: 48.6875rem;
        max-width: 100%;
      }

      #page_block_header .section-holder-border {
        border: 0;
      }

      #page_block_header .section-block {
        background: url(//v.fastcdn.co/u/e36f2c7e/62518204-0-BG-lines.png) repeat rgb(244, 247, 250) 98% 24% / cover;
        height: 48.6875rem;
      }

      #page_block_header .section-holder-overlay {
        display: none;
      }

      #element-129 {
        top: 2.1875rem;
        left: -3.125rem;
        height: 3.125rem;
        width: 8.875rem;
        z-index: 3;
      }

      #element-129 .cropped {
        background: url(//v.fastcdn.co/u/e36f2c7e/62518207-0-merchant.png) -0.5625rem -0.25rem / 10rem 3.8125rem;
      }

      #element-265 {
        top: 10.4375rem;
        left: 31.6875rem;
        height: 6.8125rem;
        width: 6.6875rem;
        z-index: 14;
      }

      #element-139 {
        top: 13.3125rem;
        left: 33.75rem;
        /* height: 5.9375rem; */
        width: 29.25rem;
        z-index: 15;
      }

      #element-139 .shape {
        border: 0.0625rem solid #FFFFFF;
        background: rgb(249, 249, 249);
      }

      /* #element-139 .contents {
        font-family: Nunito !important;
        font-weight: 400 !important;
        background-color: rgb(255, 255, 255) !important;
        border-radius: 0px !important;
        width: 29.25rem !important;
        height: 27.9375rem !important;
        border-style: solid !important;
        background-repeat: repeat !important;
        background-position: left top !important;
        background-size: cover !important;
        box-shadow: 0px 31px 21px -13px rgba(222, 222, 222, .5) !important;
      } */

      #element-143 {
        top: 8.875rem;
        left: 36.875rem;
        height: 2.125rem;
        width: 23.125rem;
        z-index: 18;
        color: #37465A;
        font-size: 1.4861rem;
        line-height: 2.1rem;
        text-align: center;
      }

      #element-143 .x_fc9d998b {
        text-align: center;
        line-height: 2.125rem;
        font-size: 1.4861rem;
      }

      #element-143 .x_93908647 {
        color: #333333;
      }

      #element-141 {
        top: 12.625rem;
        left: 39.0625rem;
        height: 20.4375rem;
        width: 18.75rem;
        z-index: 17;
      }

      .notification-text {
        font-size: 3.125rem;
      }

      .form {
        font-size: 0.8125rem;
      }

      .form-input {
        font-size: 0.9375rem;
        height: 2.6875rem;
      }

      .form-textarea {
        height: 6.25rem;
      }

      .form-label-title {
        margin: 0.3125rem 0 0.5rem;
        font-size: 0.89375rem;
        padding: 0;
        line-height: 1.1875rem;
      }

      .form-multiple-label {
        margin-bottom: 0.625rem;
        font-size: 0.9375rem;
        line-height: 1.1875rem;
        padding: 0;
      }

      .form-multiple-label:empty {
        display: inline;
      }

      .form-checkbox-label:after {
        top: 0.1rem;
      }

      .form-label-outside {
        margin-bottom: 0;
      }

      .form-multiple-label:before {
        transition: background-color 0.1s, border 0.1s;
      }

      .form-radio-label:hover:before {
        border: 0.3125rem solid #9bc7fd;
      }

      .form-messagebox {
        transform: translate(0);
        display: flex;
      }

      .form-messagebox-left {
        transform: translateX(-100%);
        left: -0.625rem;
      }

      .form-messagebox-right {
        transform: translateX(100%);
        right: -0.625rem;
      }

      .form-messagebox:before {
        top: calc(50% - 0.1875rem);
        left: auto;
      }

      .form-messagebox-left:before {
        right: -0.1875rem;
      }

      .form-messagebox-right:before {
        left: -0.1875rem;
      }

      #element-141 .btn.btn-effect3d:active {
        box-shadow: none;
      }

      #element-141 .btn:hover {
        background: #DDC014;
        color: #333333;
      }

      #element-141 .btn {
        background: #F7E36B;
        color: #333333;
        font-size: 1.2384rem;
        font-family: Montserrat;
        font-weight: 700;
        height: 3.6875rem;
        width: 18.75rem;
        border-radius: 3px;
      }

      #element-141 .form-label {
        color: #333333;
      }

      #element-141 ::placeholder {
        color: #333333;
      }

      #element-141 .form-input {
        color: #333333;
        background-color: #FFFFFF;
        border-color: #D7D7D7;
      }

      #element-141 .user-invalid {
        border-color: #E12627;
      }

      #element-141 input::placeholder,
      #element-141 .form-label-inside {
        color: #333333;
      }

      #element-141 select.valid {
        color: #333333;
      }

      #element-141 .form-btn-geometry {
        top: 22.3125rem;
        left: 0;
        height: 3.6875rem;
        width: 18.75rem;
        z-index: 17;
      }

      #element-130 {
        top: 14.1875rem;
        left: -3.125rem;
        height: 7.125rem;
        width: 29.8125rem;
        z-index: 4;
        color: #37465A;
        font-size: 2.5387rem;
        line-height: 3.5875rem;
        text-align: left;
      }

      #element-130 .x_8c048be8 {
        text-align: left;
        line-height: 3.5625rem;
        font-size: 2.5387rem;
      }

      #element-131 {
        top: 22.375rem;
        left: -3.125rem;
        height: 7.4375rem;
        width: 25.5625rem;
        z-index: 5;
        color: #37465A;
        font-size: 1.1146rem;
        line-height: 1.8rem;
        text-align: left;
        padding-bottom: 4rem
      }

      #element-131 .x_8ae9aa76 {
        text-align: left;
        line-height: 1.7125rem;
        font-size:16px;
        margin-bottom: 3rem;
        
      }

      #element-136 {
        top: 29.0625rem;
        left: -1.6875rem;
        height: 1.625rem;
        width: 9.125rem;
        z-index: 10;
        color: #37465A;
        font-size: 0.9907rem;
        line-height: 1.6rem;
        text-align: left;
      }

      #element-136 .x_3579aa00 {
        text-align: left;
        line-height: 1.625rem;
        font-size: 0.9907rem;
      }

      #element-132 {
        top: 29.5rem;
        left: -3.125rem;
        height: 0.8125rem;
        width: 0.8125rem;
        z-index: 6;
      }

      #element-132 .shape {
        border: 0;
        background: rgb(28, 16, 207);
      }

      #element-137 {
        top: 31.125rem;
        left: -1.6875rem;
        height: 1.625rem;
        width: 12.0625rem;
        z-index: 11;
        color: #37465A;
        font-size: 0.9907rem;
        line-height: 1.6rem;
        text-align: left;
      }

      #element-137 .x_3579aa00 {
        text-align: left;
        line-height: 1.625rem;
        font-size: 0.9907rem;
      }

      #element-133 {
        top: 31.5625rem;
        left: -3.125rem;
        height: 0.8125rem;
        width: 0.8125rem;
        z-index: 8;
      }

      #element-133 .shape {
        border: 0;
        background: rgb(28, 16, 207);
      }

      #element-138 {
        top: 33.1875rem;
        left: -1.6875rem;
        height: 1.625rem;
        width: 7.4375rem;
        z-index: 13;
        color: #37465A;
        font-size: 0.9907rem;
        line-height: 1.6rem;
        text-align: left;
      }

      #element-138 .x_3579aa00 {
        text-align: left;
        line-height: 1.625rem;
        font-size: 0.9907rem;
      }

      #element-134 {
        top: 33.625rem;
        left: -3.125rem;
        height: 0.8125rem;
        width: 0.8125rem;
        z-index: 9;
      }

      #element-134 .shape {
        border: 0;
        background: rgb(28, 16, 207);
      }

      #page-block-5yg6cfwpzsk {
        height: 35.4375rem;
        max-width: 100%;
      }

      #page-block-5yg6cfwpzsk .section-holder-border {
        border: 0;
      }

      #page-block-5yg6cfwpzsk .section-block {
        background: rgb(255, 255, 255);
        height: 35.4375rem;
      }

      #page-block-5yg6cfwpzsk .section-holder-overlay {
        display: none;
      }

      #element-162 {
        top: 5rem;
        left: 12.75rem;
        height: 6.125rem;
        width: 34.5rem;
        z-index: 21;
        color: #37465A;
        font-size: 2.1672rem;
        line-height: 3.0625rem;
        text-align: center;
      }

      #element-162 .x_ab3dc331 {
        text-align: center;
        line-height: 3.0625rem;
        font-size: 2.1672rem;
      }

      #element-162 .x_93908647 {
        color: #333333;
      }

      #element-163 {
        top: 12.0625rem;
        left: 16.8125rem;
        height: 3.625rem;
        width: 26.375rem;
        z-index: 22;
        color: #37465A;
        font-size: 1.1146rem;
        line-height: 1.8rem;
        text-align: center;
      }

      #element-163 .x_e6507cf2 {
        text-align: center;
        line-height: 1.8125rem;
        font-size: 1.1146rem;
      }

      #element-163 .x_93908647 {
        color: #333333;
      }

      #element-243 {
        top: 20rem;
        left: -3.125rem;
        height: 2.375rem;
        width: 2.1875rem;
        z-index: 42;
      }

      #element-150 {
        top: 20rem;
        left: 0;
        height: 3.5rem;
        width: 14.1875rem;
        z-index: 41;
        color: #37465A;
        font-size: 1.2384rem;
        line-height: 1.75rem;
        text-align: left;
      }

      #element-150 .x_b558b569 {
        text-align: left;
        line-height: 1.75rem;
        font-size: 1.2384rem;
      }

      #element-150 .x_93908647 {
        color: #333333;
      }

      #element-245 {
        top: 20rem;
        left: 18.625rem;
        height: 2.375rem;
        width: 2.1875rem;
        z-index: 46;
      }

      #element-156 {
        top: 20rem;
        left: 21.75rem;
        height: 3.5rem;
        width: 16.25rem;
        z-index: 45;
        color: #37465A;
        font-size: 1.2384rem;
        line-height: 1.75rem;
        text-align: left;
      }

      #element-156 .x_b558b569 {
        text-align: left;
        line-height: 1.75rem;
        font-size: 1.2384rem;
      }

      #element-156 .x_93908647 {
        color: #333333;
      }

      #element-247 {
        top: 20rem;
        left: 42.4375rem;
        height: 2.375rem;
        width: 2.1875rem;
        z-index: 50;
      }

      #element-158 {
        top: 20rem;
        left: 45.5625rem;
        height: 3.5rem;
        width: 17.5625rem;
        z-index: 49;
        color: #37465A;
        font-size: 1.2384rem;
        line-height: 1.75rem;
        text-align: left;
      }

      #element-158 .x_b558b569 {
        text-align: left;
        line-height: 1.75rem;
        font-size: 1.2384rem;
      }

      #element-158 .x_93908647 {
        color: #333333;
      }

      #element-244 {
        top: 26.625rem;
        left: -3.125rem;
        height: 2.375rem;
        width: 2.1875rem;
        z-index: 44;
      }

      #element-154 {
        top: 26.625rem;
        left: 0;
        height: 3.5rem;
        width: 14.125rem;
        z-index: 43;
        color: #37465A;
        font-size: 1.2384rem;
        line-height: 1.75rem;
        text-align: left;
      }

      #element-154 .x_b558b569 {
        text-align: left;
        line-height: 1.75rem;
        font-size: 1.2384rem;
      }

      #element-154 .x_93908647 {
        color: #333333;
      }

      #element-246 {
        top: 26.625rem;
        left: 18.625rem;
        height: 2.375rem;
        width: 2.1875rem;
        z-index: 48;
      }

      #element-152 {
        top: 26.625rem;
        left: 21.75rem;
        height: 3.5rem;
        width: 16.25rem;
        z-index: 47;
        color: #37465A;
        font-size: 1.2384rem;
        line-height: 1.75rem;
        text-align: left;
      }

      #element-152 .x_b558b569 {
        text-align: left;
        line-height: 1.75rem;
        font-size: 1.2384rem;
      }

      #element-152 .x_93908647 {
        color: #333333;
      }

      #element-248 {
        top: 26.625rem;
        left: 42.4375rem;
        height: 2.375rem;
        width: 2.1875rem;
        z-index: 52;
      }

      #element-160 {
        top: 26.9375rem;
        left: 45.5625rem;
        height: 1.75rem;
        width: 15.25rem;
        z-index: 51;
        color: #37465A;
        font-size: 1.2384rem;
        line-height: 1.75rem;
        text-align: left;
      }

      #element-160 .x_b558b569 {
        text-align: left;
        line-height: 1.75rem;
        font-size: 1.2384rem;
      }

      #element-160 .x_93908647 {
        color: #333333;
      }

      #page-block-3cg5fcg36ot {
        height: 44.6875rem;
        max-width: 100%;
      }

      #page-block-3cg5fcg36ot .section-holder-border {
        border: 0;
      }

      #page-block-3cg5fcg36ot .section-block {
        background: rgb(242, 242, 242);
        height: 44.6875rem;
      }

      #page-block-3cg5fcg36ot .section-holder-overlay {
        display: none;
      }

      #element-215 {
        top: 5rem;
        left: 9.0625rem;
        height: 6.125rem;
        width: 41.875rem;
        z-index: 32;
        color: #37465A;
        font-size: 2.1672rem;
        line-height: 3.0625rem;
        text-align: center;
      }

      #element-215 .x_ab3dc331 {
        text-align: center;
        line-height: 3.0625rem;
        font-size: 2.1672rem;
      }

      #element-215 .x_93908647 {
        color: #333333;
      }

      #element-256 {
        top: 15.5625rem;
        left: -3.125rem;
        height: 2.8125rem;
        width: 2.5625rem;
        z-index: 58;
      } 

      #element-356 {
        top: 16.5625rem;
        left: -4.125rem;
        height: 2.8125rem;
        background-color: white;
        padding: 8px;
        width: 2.5625rem;
        z-index: 58;
      } 

      #element-197 {
        top: 15.5625rem;
        left: 0.3125rem;
        height: 1.75rem;
        width: 21.75rem;
        z-index: 56;
        color: #37465A;
        font-size: 1.2384rem;
        line-height: 1.75rem;
        text-align: left;
      }

      #element-197 .x_8b236db7 {
        text-align: left;
        line-height: 1.75rem;
        font-size: 1.2384rem;
      }

      #element-197 .x_93908647 {
        color: #333333;
      }

      #element-198 {
        top: 18.25rem;
        left: 0.3125rem;
        height: 3.375rem;
        width: 24.875rem;
        z-index: 57;
        color: #37465A;
        font-size: 1.0526rem;
        line-height: 1.7rem;
        text-align: left;
      }

      #element-198 .x_80f7663c {
        text-align: left;
        line-height: 1.6875rem;
        font-size: 1.0526rem;
      }

      #element-198 .x_93908647 {
        color: #333333;
      }

      #element-266 {
        top: 15.5625rem;
        left: 35.0625rem;
        height: 6.8125rem;
        width: 6.6875rem;
        z-index: 16;
      }

      #element-208 {
        top: 17.3125rem;
        left: 37.1875rem;
        height: 20.4375rem;
        width: 25.9375rem;
        z-index: 23;
      }

      #element-208 .shape {
        border: 0;
        border-radius: 0.3125rem 0.3125rem 0.3125rem 0.3125rem;
        background: rgb(242, 242, 242);
      }

      #element-208 .contents {
        font-family: Roboto !important;
        font-weight: 400 !important;
        background-color: rgb(255, 255, 255) !important;
        border-radius: 5px !important;
        border-color: rgba(0, 0, 0, 0) !important;
        border-width: 1px !important;
        width: 25.8125rem !important;
        height: 20.3125rem !important;
        border-style: solid !important;
        background-repeat: repeat !important;
        background-position: left top !important;
        background-size: cover !important;
        box-shadow: 0px 31px 21px -13px rgba(222, 222, 222, .5) !important;
      }

      #element-207 {
        top: 19rem;
        left: 40.3125rem;
        height: 4rem;
        width: 19.625rem;
        z-index: 25;
        color: #37465A;
        font-size: 1.2384rem;
        line-height: 2rem;
        text-align: left;
      }

      #element-207 .x_9811881d {
        text-align: left;
        line-height: 2rem;
        font-size: 1.2384rem;
      }

      #element-207 .x_93908647 {
        color: #333333;
      }

      #element-209 {
        top: 24.5625rem;
        left: 40.3125rem;
        height: 1.3125rem;
        width: 5.6875rem;
        z-index: 24;
      }

      #element-214 {
        top: 27.375rem;
        left: 40.3125rem;
        height: 1.5625rem;
        width: 10.8125rem;
        z-index: 31;
        color: #37465A;
        font-size: 1.1146rem;
        line-height: 1.575rem;
        text-align: left;
      }

      #element-214 .x_9a9d3d17 {
        text-align: left;
        line-height: 1.5625rem;
        font-size: 1.1146rem;
      }

      #element-214 .x_93908647 {
        color: #333333;
      }

      #element-210 {
        top: 29.4375rem;
        left: 40.3125rem;
        height: 1.375rem;
        width: 10.8125rem;
        z-index: 26;
        color: #37465A;
        font-size: 0.8669rem;
        line-height: 1.4rem;
        text-align: left;
      }

      #element-210 .x_8b9dcb22 {
        text-align: left;
        line-height: 1.375rem;
        font-size: 0.8669rem;
      }

      #element-210 .x_93908647 {
        color: #333333;
      }

      #element-211 {
        top: 32rem;
        left: 40.3125rem;
        height: 1.3125rem;
        width: 19.625rem;
        z-index: 27;
      }

      #element-211 .shape {
        border-bottom: 1px solid #E2EAEE;
      }

      #element-213 {
        top: 34.625rem;
        left: 40.3125rem;
        height: 1.375rem;
        width: 5.4375rem;
        z-index: 29;
        color: #37465A;
        font-size: 0.8383rem;
        line-height: 1.3538rem;
        text-align: left;
      }

      #element-213 .x_911e5143 {
        text-align: left;
        line-height: 1.375rem;
        font-size: 0.8383rem;
      }

      #element-213 .x_9508b241 {
        color: #72777d;
      }

      #element-212 {
        top: 34.8125rem;
        left: 44.625rem;
        height: 1.125rem;
        width: 4.875rem;
        z-index: 28;
      }

      #element-258 {
        top: 24.4375rem;
        left: -3.125rem;
        height: 2.8125rem;
        width: 2.5625rem;
        z-index: 61;
      }
      #element-358 {
        top: 25.5375rem;
        left: -4.125rem;
        padding: 10px;
        background-color: white;
        height: 2.8125rem;
        width: 2.5625rem;
        z-index: 61;
      }

      #element-200 {
        top: 24.4375rem;
        left: 0.3125rem;
        height: 1.75rem;
        width: 23rem;
        z-index: 59;
        color: #37465A;
        font-size: 1.2384rem;
        line-height: 1.75rem;
        text-align: left;
      }

      #element-200 .x_8b236db7 {
        text-align: left;
        line-height: 1.75rem;
        font-size: 1.2384rem;
      }

      #element-200 .x_93908647 {
        color: #333333;
      }

      #element-201 {
        top: 27.125rem;
        left: 0.3125rem;
        height: 3.375rem;
        width: 23.875rem;
        z-index: 60;
        color: #37465A;
        font-size: 1.0526rem;
        line-height: 1.7rem;
        text-align: left;
      }

      #element-201 .x_80f7663c {
        text-align: left;
        line-height: 1.6875rem;
        font-size: 1.0526rem;
      }

      #element-201 .x_93908647 {
        color: #333333;
      }

      #element-255 {
        top: 33.3125rem;
        left: -3.125rem;
        height: 2.8125rem;
        width: 2.5625rem;
        z-index: 55;
        
      }
      #element-355 {
        top: 34.3125rem;
        left: -4.125rem;
        height: 2.8125rem;
        width: 2.5625rem;
        z-index: 55;
        padding: 10px;
        background-color: white
      }

      #element-203 {
        top: 33.3125rem;
        left: 0.3125rem;
        height: 1.75rem;
        width: 21.5625rem;
        z-index: 53;
        color: #37465A;
        font-size: 1.2384rem;
        line-height: 1.75rem;
        text-align: left;
      }

      #element-203 .x_8b236db7 {
        text-align: left;
        line-height: 1.75rem;
        font-size: 1.2384rem;
      }

      #element-203 .x_93908647 {
        color: #333333;
      }

      #element-204 {
        top: 36rem;
        left: 0.3125rem;
        height: 3.375rem;
        width: 21.5625rem;
        z-index: 54;
        color: #37465A;
        font-size: 1.0526rem;
        line-height: 1.7rem;
        text-align: left;
      }

      #element-204 .x_80f7663c {
        text-align: left;
        line-height: 1.6875rem;
        font-size: 1.0526rem;
      }

      #element-204 .x_93908647 {
        color: #333333;
      }

      #page-block-p0avpzvahxp {
        height: 28.5625rem;
        max-width: 100%;
      }

      #page-block-p0avpzvahxp .section-holder-border {
        border: 0;
      }

      #page-block-p0avpzvahxp .section-block {
        background: rgb(255, 255, 255);
        height: 28.5625rem;
      }

      #page-block-p0avpzvahxp .section-holder-overlay {
        display: none;
      }

      #element-216 {
        top: 4.9375rem;
        left: 11.9375rem;
        height: 7.125rem;
        width: 36.125rem;
        z-index: 12;
        color: #37465A;
        font-size: 2.5387rem;
        line-height: 3.5875rem;
        text-align: center;
      }

      #element-216 .x_10983523 {
        text-align: center;
        line-height: 3.5625rem;
        font-size: 2.5387rem;
      }

      #element-216 .x_93908647 {
        color: #333333;
      }

      #element-217 {
        top: 13rem;
        left: 16.0625rem;
        height: 3.625rem;
        width: 27.875rem;
        z-index: 19;
        color: #37465A;
        font-size: 1.1146rem;
        line-height: 1.8rem;
        text-align: center;
      }

      #element-217 .x_e6507cf2 {
        text-align: center;
        line-height: 1.8125rem;
        font-size: 1.1146rem;
      }

      #element-217 .x_93908647 {
        color: #333333;
      }

      #element-218 {
        top: 19.125rem;
        left: 21.25rem;
        height: 4.0625rem;
        width: 17.5rem;
        z-index: 20;
      }

      #element-218 .btn.btn-effect3d:active {
        box-shadow: none;
      }

      #element-218 .btn:hover {
        background: #DDC014;
        color: #333333;
      }

      #element-218 .btn {
        background: #F7E36B;
        color: #333333;
        font-size: 1.2384rem;
        font-family: Montserrat;
        font-weight: 700;
        height: 4.0625rem;
        width: 17.5rem;
        border-radius: 5px;
      }

      #page-block-lote38odq7l {
        height: 21rem;
        max-width: 100%;
      }

      #page-block-lote38odq7l .section-holder-border {
        border: 0;
      }

      #page-block-lote38odq7l .section-block {
        background: rgb(249, 249, 249);
        height: 21rem;
      }

      #page-block-lote38odq7l .section-holder-overlay {
        display: none;
      }

      #element-222 {
        top: 5rem;
        left: -3.125rem;
        height: 1.5625rem;
        width: 11.0625rem;
        z-index: 33;
        color: #37465A;
        font-size: 1.1146rem;
        line-height: 1.575rem;
        text-align: left;
      }

      #element-222 .x_9a9d3d17 {
        text-align: left;
        line-height: 1.5625rem;
        font-size: 1.1146rem;
      }

      #element-222 .x_93908647 {
        color: #333333;
      }

      #element-223 {
        top: 7.375rem;
        left: -3.125rem;
        height: 4.875rem;
        width: 14.125rem;
        z-index: 34;
        color: #37465A;
        font-size: 0.9907rem;
        line-height: 1.6rem;
        text-align: left;
      }

      #element-223 .x_fae6260b {
        text-align: left;
        line-height: 1.625rem;
        font-size: 0.9907rem;
      }

      #element-223 .x_93908647 {
        color: #333333;
      }

      #element-224 {
        top: 5rem;
        left: 17rem;
        height: 1.5625rem;
        width: 8.625rem;
        z-index: 35;
        color: #37465A;
        font-size: 1.1146rem;
        line-height: 1.575rem;
        text-align: left;
      }

      #element-224 .x_9a9d3d17 {
        text-align: left;
        line-height: 1.5625rem;
        font-size: 1.1146rem;
      }

      #element-224 .x_93908647 {
        color: #333333;
      }

      #element-225 {
        top: 7.375rem;
        left: 17rem;
        height: 1.625rem;
        width: 8.625rem;
        z-index: 36;
        color: #37465A;
        font-size: 0.9907rem;
        line-height: 1.6rem;
        text-align: left;
      }

      #element-225 .x_fae6260b {
        text-align: left;
        line-height: 1.625rem;
        font-size: 0.9907rem;
      }

      #element-225 .x_93908647 {
        color: #333333;
      }

      #element-226 {
        top: 5rem;
        left: 31.625rem;
        height: 1.5625rem;
        width: 7.9375rem;
        z-index: 37;
        color: #37465A;
        font-size: 1.1146rem;
        line-height: 1.575rem;
        text-align: left;
      }

      #element-226 .x_9a9d3d17 {
        text-align: left;
        line-height: 1.5625rem;
        font-size: 1.1146rem;
      }

      #element-226 .x_93908647 {
        color: #333333;
      }

      #element-227 {
        top: 7.4375rem;
        left: 31.625rem;
        height: 3.25rem;
        width: 7.9375rem;
        z-index: 38;
        color: #37465A;
        font-size: 0.9907rem;
        line-height: 1.6rem;
        text-align: left;
      }

      #element-227 .x_fae6260b {
        text-align: left;
        line-height: 1.625rem;
        font-size: 0.9907rem;
      }

      #element-227 .x_93908647 {
        color: #333333;
      }

      #element-234 {
        top: 5rem;
        left: 45.625rem;
        height: 1.5625rem;
        width: 12.8125rem;
        z-index: 40;
        color: #37465A;
        font-size: 1.1146rem;
        line-height: 1.575rem;
        text-align: left;
      }

      #element-234 .x_9a9d3d17 {
        text-align: left;
        line-height: 1.5625rem;
        font-size: 1.1146rem;
      }

      #element-234 .x_5e78ce6a {
        text-align: left;
        color: #333333;
      }

      #element-234 .x_93908647 {
        color: #333333;
      }

      #element-230 {
        top: 7.4375rem;
        left: 45.625rem;
        height: 3.375rem;
        width: 17.5rem;
        z-index: 39;
        color: #37465A;
        font-size: 0.6811rem;
        line-height: 1.1rem;
        text-align: left;
      }

      #element-230 .x_7b84e050 {
        text-align: left;
        line-height: 1.125rem;
        font-size: 0.6811rem;
      }

      #element-230 .x_93908647 {
        color: #333333;
      }

      #element-221 {
        top: 14.75rem;
        left: -3.125rem;
        height: 6.25rem;
        width: 29.4375rem;
        z-index: 7;
      }
    }

    @media all and (-ms-high-contrast:none),
    (-ms-high-contrast:active) {
      .form-messagebox {
        height: auto !important;
      }
    }
  </style>

  <script>
    window.__variantsData = [{ name: 'A', chance: 100 }];

    window.__page_id = 23321611;
    window.__customer_id = 4356746;
    window.__default_experience_id = 23321611;
    window.__version = 11;
    window.__variant = "A";
    window.__variant_id = 1;
    window.__variant_custom_name = "Variation A";
    window.__preview = false;
    window.__page_type = 2;
    window.__variant_hash = "8f1b70a8b9e9c22ba190ed395d2c2b33a578a972";
    window.__page_domain = "info.gartnerdigitalmarkets.com";
    window.__page_generator = true;
    window.__experiment_id = null;
    window._Translate = {
      translations: {},
      set: function (text, translation) { this.translations[text] = translation; },
      get: function (text) { return this.translations[text] || text; }
    };
  </script>
  <script id="ip-config" type="application/json">
  {"mobileDisabled":false,"downloadFileEndpoint":"https://app.instapage.com/ajax/pageserver/files/serve-file","reCaptchaEnabled":false,"snowplowUrl":"https://cdn.instapagemetrics.com/t/js/3/it.js","snowplowWrapperUrl":"//g.fastcdn.co/js/sptw.e0d3d3700fa08797ac40.js"}
</script>

  <script id="ip-analytics"
    type="application/json">{"trackingData":{"anthillApiKey":"f206a081f316d973361b1c2117a5110dee35b7be7826dd7f4062c99a38e87ad720f92ee52d4bae7bad6e92055b8b3a8473b277cdd895c7736a8af63c930064cbb80547bfa44c09e493135578b86755f26e6f09c37d13e1b873dcacebafc65bbca9f4444485ed7198f474bed2c12fbffd0677725417df8c3a36d818ee1ffa68760b75ff08cd3b06c27aac9a9cb1f1bf65","ownerId":3676160,"customerId":4356746,"pageId":23321611,"publishedVersion":11,"variationName":"A","variationId":1,"linkedVariationId":2,"variation":"A","trackedLinks":[],"allLinks":[{"href":"#element-234","id":"arlydcynvu","type":"footnote","track":false,"targetNewWindow":false},{"href":"#page_block_header","id":"3s1v37daorj","type":"onpage","track":false,"targetNewWindow":false},{"href":"https://paysprint.ca/privacy-policy","ariaLabel":"","id":"nvmuwq5dti","type":"url","track":false,"targetNewWindow":true},{"href":"https://paysprint.ca/terms-of-service","ariaLabel":"","id":"prahnjxmoji","type":"url","track":false,"targetNewWindow":true}],"user_id":3676160},"conversionSettings":{"forms":true,"links":true,"external":false},"visitUrl":"https://anthill.instapage.com/projects/56c2f3d796773d0a7e96a536/events/visit","conversionUrl":"https://anthill.instapage.com/projects/56c2f3d796773d0a7e96a536/events/conversion"}</script>

  <script id="ip-trkr" type="text/javascript" async=1>
    ; (function (p, l, o, w, i, n, g) {
      if (!p[i]) {
        p.GlobalSnowplowNamespace = p.GlobalSnowplowNamespace || [];
        p.GlobalSnowplowNamespace.push(i); p[i] = function () {
          (p[i].q = p[i].q || []).push(arguments)
        }; p[i].q = p[i].q || []; n = l.createElement(o); g = l.getElementsByTagName(o)[0]; n.async = 1;
        n.src = w; g.parentNode.insertBefore(n, g)
      }
    }(window, document, "script", "https://cdn.instapagemetrics.com/t/js/3/it.js", "instapageSp"));
    ; (function (i, n, s, t, a, p, g) {
      i[a] || (i[a] = function () { (i[a].q = i[a].q || []).push(arguments) },
        i[a].q = i[a].q || [], p = n.createElement(s), g = n.getElementsByTagName(s)[0], p.async = 1,
        p.src = t, g.parentNode.insertBefore(p, g))
    }(window, document, "script", "http://g.fastcdn.co/js/sptw.e0d3d3700fa08797ac40.js", "_instapageSnowplow"));
    try {
      var trackingData = JSON.parse(document.querySelector('#ip-analytics').text).trackingData;
      window._instapageSnowplow('setWrapperConfig', {
        lpContext: {
          lp_id: trackingData.pageId,
          lp_variation_id: trackingData.variationId,
          lp_version: trackingData.publishedVersion,
          subaccount_id: trackingData.customerId
        },
        collectorHost: "https://ec.instapagemetrics.com"
      });
      window._instapageSnowplow('enableActivityTracking');
      window._instapageSnowplow('trackPageView');
    } catch (e) {
      console.warn('Snowplow tracker error', e);
    }
  </script>

  <script id="ip-cm" type="text/javascript" async=1>
    ; (function (c, o, n, s, e, m, a) {
      c[e] || (c[e] = function () { (c[e].q = c[e].q || []).push(arguments) },
        c[e].q = c[e].q || [], m = o.createElement(n), a = o.getElementsByTagName(n)[0], m.async = 1,
        m.src = s, a.parentNode.insertBefore(m, a))
    }(window, document, "script", "https://g.fastcdn.co/js/cm.js", "_instapageConsentManagement"));
  </script>






  <!-- F_INSTAPAGE[dynamic_text_replacement;page_generator] -->

  <!-- Workspace Level Script Head -->

  <!-- end Workspace Level Script Head -->

  <!-- custom HEAD code-->

  <script>window.__gdprComplianceScripts = window.__gdprComplianceScripts || []; window.__gdprComplianceScripts.push(function () { });</script>
  <!-- Begin "Form submit callback" || Help center -->
  <!-- Insert in Settings->Javascript->Header -->
  <!-- CS:20200120-04-0 -->
  <script>
    window.instapageFormSubmitSuccess = function (form) {
      var capterra_vkey = 'aea3170b1548039193ac37fe45efbefb',
        capterra_vid = '2207270',
        capterra_prefix = (('https:' == document.location.protocol)
          ? 'https://ct.capterra.com' : 'http://ct.capterra.com');
      var ct = document.createElement('script');
      ct.type = 'text/javascript';
      ct.async = true;
      ct.src = capterra_prefix + '/capterra_tracker.js?vid='
        + capterra_vid + '&vkey=' + capterra_vkey;
      var s = document.getElementsByTagName('script')[0];
      s.parentNode.insertBefore(ct, s);
    };
  </script>
  <!-- End "Form submit callback" || Help center -->
  <!-- end custom HEAD code-->
</head>

<body id="landing-page">
  <!-- Workspace Level Script Body -->

  <!-- end Workspace Level Script Body -->

  <!-- custom BODY code-->
  <style>
    /*Dynamic Copyright*/
    #newDate {
      font-family: 'Roboto', sans-serif !important;
      font-size: 16px !important;
      color: #333333 !important;
      text-align: left;
      margin-top: 50px;
    }

    /*Confirmation text*/
    .notification-text {
      font-family: 'Roboto', sans-serif !important;
      font-size: 20px !important;
      color: #ffffff !important;
      text-align: center !important;
    }

    @media (max-width: 576px) {
      .notification-text {
        margin-left: 50px !important;
        margin-right: 50px !important;
        font-size: 18px !important;
      }
    }

    /* cookie bar */
    .snackbar-btn-cta {
      background-color: #HEXCODE !important;
      color: #HEXCODE !important;
    }

    .snackbar-btn-default {
      color: #HEXCODE !important;
    }

    .snackbar-link {
      color: #HEXCODEimportant;
    }
  </style>
  <script>window.__gdprComplianceScripts = window.__gdprComplianceScripts || []; window.__gdprComplianceScripts.push(function () { });</script>
  <!-- end custom BODY code-->



  <div id="ip-user-consent" class="snackbar hidden">
    <p class="snackbar-content">
      This website uses cookies that are necessary to deliver an enjoyable experience and ensure
      its correct functionality and cannot be turned off. Optional cookies are used to improve the page with analytics,
      by
      clicking “Yes, I accept” you consent to this use of cookies. <a target="_blank" class="snackbar-link"
        href="https://paysprint.ca/terms-of-service">Learn more</a>
    </p>
    <div class="snackbar-btn-group">
      <button id="ip-user-consent-decline" class="snackbar-btn snackbar-btn-default">
        I do not accept
      </button>
      <button id="ip-user-consent-accept" class="snackbar-btn snackbar-btn-cta">
        Yes, I accept
      </button>
    </div>
    <div class="clearfix"></div>
  </div>


  <main>
    <section class="section section-relative " id="page_block_header" data-at="section">

      <div class="section-holder-border item-block item-absolute" data-at="section-border"></div>
      <div class="section-holder-overlay item-block item-absolute" data-at="section-overlay"></div>
      <div class="section-block">
        <div class="section-inner section-fit section-relative">
          <div class="widget item-absolute  " id="element-129">
            <div class="contents cropped item-block" data-at="image-cropp">
            </div>
          </div>

          <div class="widget item-absolute  " id="element-265">
            <div class="contents cropped item-block" data-at="image-cropp">
              <img class="item-content-box item-block image " data-at="image" alt=""
                src="https://v.fastcdn.co/u/e36f2c7e/62519955-0-l5-about-pattern.png"
                srcset="//v.fastcdn.co/u/e36f2c7e/62519955-0-l5-about-pattern.png 2x">
            </div>
          </div>

          <div class="widget item-absolute " id="element-139">
            <div class="contents shape  box figure " data-at="shape">
              <img class="w-100" src=" {{ asset('images/PSM.jpg') }}" style="">

            </div>
          </div>

          {{-- <div class="widget item-absolute headline  " id="element-143" data-at="headline">
            <div class="contents">
              <h1>
                <span class="x_fc9d998b x_bdb4a4e4"><span class="x_93908647">See PaySprint in action</span></span>
              </h1>
            </div>
          </div> --}}

          <div class="widget item-absolute  " id="element-141">
           

            <div id="form-validation-error-box-element-141" class="item-cover item-absolute form-messagebox"
              data-at="form-validation-box" style="display:none;">
              <div class="form-messagebox-contents" data-at="form-validation-box-message">
               
              </div>
              
            </div>
          </div> 

          <div class="widget item-absolute headline  " id="element-130" data-at="headline">
            <div class="contents">
              <h1>
                <span class="x_8c048be8 x_027b22ed">A complete&nbsp;payments processing service</span>
              </h1>
            </div>
          </div>

          <div class="widget item-absolute paragraph mb-3" id="element-131" data-at="paragraph" >
            <div class="contents mb-3" >
              <p class="x_8ae9aa76 x_b6c3675a">PaySprint for Business enables you to receive payments on any mobile device (for in-store sales) and your website (for online sales) with no transaction fees. </p>
            </div>
          </div>
        
            
          <div class="widget item-absolute paragraph hidden-mobile" id="element-136" data-at="paragraph">
            <div class="contents">
              <p class="x_3579aa00 x_8b9ce48e" >Identity verification</p>
            </div>
          </div>

          <div class="widget item-absolute hidden-mobile" id="element-132">
            <span class="bullet-html pulse" ></span>
          </div>

          <div class="widget item-absolute paragraph hidden-mobile " id="element-137" data-at="paragraph">
            <div class="contents">
              <p class="x_3579aa00 x_8b9ce48e">Multi-level authentication</p>
            </div>
          </div>

          <div class="widget item-absolute hidden-mobile" id="element-133">
            <span class="bullet-html pulse"></span>
          </div>

          <div class="widget item-absolute paragraph hidden-mobile " id="element-138" data-at="paragraph">
            <div class="contents">
              <p class="x_3579aa00 x_8b9ce48e">Full encryption</p>
            </div>
          </div>

          <div class="widget item-absolute hidden-mobile" id="element-134">
            <span class="bullet-html pulse"></span>
          </div>

        </div>
      </div>
    </section>

   
  <h1>

  

    <section class="section section-relative " id="page-block-5yg6cfwpzsk" data-at="section">

      <div class="section-holder-border item-block item-absolute" data-at="section-border"></div>
      <div class="section-holder-overlay item-block item-absolute" data-at="section-overlay"></div>
      <div class="section-block">
        <div class="section-inner section-fit section-relative">
          <div class="widget item-absolute headline  " id="element-162" data-at="headline">
            <div class="contents">
              <h1>
                <span class="x_ab3dc331 x_26d449b5"><span class="x_93908647">Take advantage of merchant cash advance
                    service</span></span>
              </h1>
            </div>
          </div>

          <div class="widget item-absolute paragraph  " id="element-163" data-at="paragraph">
            <div class="contents">
              <p class="x_e6507cf2 x_8c071feb"><span class="x_93908647">Get much-needed financing with a service built
                  to support small businesses with few requirements.</span></p>
            </div>
          </div>

          <div class="widget item-absolute  " id="element-243">
            <div class="contents cropped item-block" data-at="image-cropp">
              <img class="item-content-box item-block image img-lazy" data-at="image" alt=""
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mM89h8AApEBx2iaqpQAAAAASUVORK5CYII&#x3D;"
                data-src="https://v.fastcdn.co/u/e36f2c7e/62519908-0-check.svg"
                data-retina-src="https://v.fastcdn.co/u/e36f2c7e/62519908-0-check.svg">
            </div>
          </div>

          <div class="widget item-absolute headline  " id="element-150" data-at="headline">
            <div class="contents">
              <h3>
                <span class="x_b558b569"><span class="x_93908647">Design bills/invoices professionally</span></span>
              </h3>
            </div>
          </div>

          <div class="widget item-absolute  " id="element-245">
            <div class="contents cropped item-block" data-at="image-cropp">
              <img class="item-content-box item-block image img-lazy" data-at="image" alt=""
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mM89h8AApEBx2iaqpQAAAAASUVORK5CYII&#x3D;"
                data-src="https://v.fastcdn.co/u/e36f2c7e/62519908-0-check.svg"
                data-retina-src="https://v.fastcdn.co/u/e36f2c7e/62519908-0-check.svg">
            </div>
          </div>

          <div class="widget item-absolute headline  " id="element-156" data-at="headline">
            <div class="contents">
              <h3>
                <span class="x_b558b569"><span class="x_93908647">Accept and receive payments on any
                    device</span></span>
              </h3>
            </div>
          </div>

          <div class="widget item-absolute  " id="element-247">
            <div class="contents cropped item-block" data-at="image-cropp">
              <img class="item-content-box item-block image img-lazy" data-at="image" alt=""
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mM89h8AApEBx2iaqpQAAAAASUVORK5CYII&#x3D;"
                data-src="https://v.fastcdn.co/u/e36f2c7e/62519908-0-check.svg"
                data-retina-src="https://v.fastcdn.co/u/e36f2c7e/62519908-0-check.svg">
            </div>
          </div>

          <div class="widget item-absolute headline  " id="element-158" data-at="headline">
            <div class="contents">
              <h3>
                <span class="x_b558b569"><span class="x_93908647">Accept payments through multiple
                    channels</span></span>
              </h3>
            </div>
          </div>

          <div class="widget item-absolute  " id="element-244">
            <div class="contents cropped item-block" data-at="image-cropp">
              <img class="item-content-box item-block image img-lazy" data-at="image" alt=""
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mM89h8AApEBx2iaqpQAAAAASUVORK5CYII&#x3D;"
                data-src="https://v.fastcdn.co/u/e36f2c7e/62519908-0-check.svg"
                data-retina-src="https://v.fastcdn.co/u/e36f2c7e/62519908-0-check.svg">
            </div>
          </div>

          <div class="widget item-absolute headline  " id="element-154" data-at="headline">
            <div class="contents">
              <h3>
                <span class="x_b558b569"><span class="x_93908647">Make cross border business
                    payments&nbsp;</span></span>
              </h3>
            </div>
          </div>

          <div class="widget item-absolute  " id="element-246">
            <div class="contents cropped item-block" data-at="image-cropp">
              <img class="item-content-box item-block image img-lazy" data-at="image" alt=""
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mM89h8AApEBx2iaqpQAAAAASUVORK5CYII&#x3D;"
                data-src="https://v.fastcdn.co/u/e36f2c7e/62519908-0-check.svg"
                data-retina-src="https://v.fastcdn.co/u/e36f2c7e/62519908-0-check.svg">
            </div>
          </div>

          <div class="widget item-absolute headline  " id="element-152" data-at="headline">
            <div class="contents">
              <h3>
                <span class="x_b558b569"><span class="x_93908647">Generate a receivable report with ease</span></span>
              </h3>
            </div>
          </div>

          <div class="widget item-absolute  " id="element-248">
            <div class="contents cropped item-block" data-at="image-cropp">
              <img class="item-content-box item-block image img-lazy" data-at="image" alt=""
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mM89h8AApEBx2iaqpQAAAAASUVORK5CYII&#x3D;"
                data-src="https://v.fastcdn.co/u/e36f2c7e/62519908-0-check.svg"
                data-retina-src="https://v.fastcdn.co/u/e36f2c7e/62519908-0-check.svg">
            </div>
          </div>

          <div class="widget item-absolute headline  " id="element-160" data-at="headline">
            <div class="contents">
              <h3>
                <span class="x_b558b569"><span class="x_93908647">Generate no-cost leads</span></span>
              </h3>
            </div>
          </div>

        </div>
      </div>
    </section>
     
    <section class="section section-relative  " id="page-block-3cg5fcg36ot" data-at="section">

      {{-- <div class="section-holder-border item-block item-absolute" data-at="section-border"></div> --}}
      {{-- <div class="section-holder-overlay item-block item-absolute" data-at="section-overlay"></div> --}}
      <div class="section-block">
        <div class="section-inner section-fit section-relative ">
          <div class="widget item-absolute headline  " id="element-215" data-at="headline">
            <div class="contents">
              <h1>
                <span class="x_ab3dc331 x_26d449b5"><span class="x_93908647">Ways to Receive Payments with<br>No fees</span></span>
              </h1>
            </div>
          </div>
          <div class="">
          <div class="widget item-absolute  " id="element-356">
            <div class="contents cropped item-block" data-at="image-cropp">
              <img class="item-content-box item-block image img-lazy" data-at="image" alt=""
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mM89h8AApEBx2iaqpQAAAAASUVORK5CYII&#x3D;"
                data-src="https://img.icons8.com/carbon-copy/2x/barcode-scanner.png"
                data-retina-src="https://img.icons8.com/carbon-copy/2x/barcode-scanner.png">
            </div>
          </div>

          <div class="widget item-absolute headline  " id="element-197" data-at="headline">
            <div class="contents">
              <h3>
                <span class="x_8b236db7 x_561aca13"><span class="x_93908647">Face-to-Face Payment</span></span>
              </h3>
            </div>
          </div>

          <div class="widget item-absolute paragraph  " id="element-198" data-at="paragraph">
            <div class="contents">
              <p class="x_80f7663c x_4976ff6a"><span class="x_93908647">Dispaly QR Code for Customers to scan and make payments with Debit/Credit Card or PaySprint Wallet.</span></p>
            </div>
          </div>

          <div class="widget item-absolute  " id="element-358">
            <div class="contents cropped item-block" data-at="image-cropp">
              <img class="item-content-box item-block image img-lazy" data-at="image" alt=""
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mM89h8AApEBx2iaqpQAAAAASUVORK5CYII&#x3D;"
                data-src="https://img.icons8.com/external-wanicon-lineal-wanicon/2x/external-customer-online-shopping-wanicon-lineal-wanicon.png"
                data-retina-src="https://img.icons8.com/external-wanicon-lineal-wanicon/2x/external-customer-online-shopping-wanicon-lineal-wanicon.png">
            </div>
          </div>

          <div class="widget item-absolute headline  " id="element-200" data-at="headline">
            <div class="contents">
              <h3>
                <span class="x_8b236db7 x_561aca13"><span class="x_93908647">Remote Customers</span></span>
              </h3>
            </div>
          </div>

          <div class="widget item-absolute paragraph  " id="element-201" data-at="paragraph">
            <div class="contents">
              <p class="x_80f7663c x_4976ff6a"><span class="x_93908647">Share Payments link with customers to make payments with Debit/Credit Card or PaySprint Wallet.</span></p>
            </div>
          </div>

          <div class="widget item-absolute  " id="element-355">
            <div class="contents cropped item-block" data-at="image-cropp">
              <img class="item-content-box item-block image img-lazy" data-at="image" alt=""
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mM89h8AApEBx2iaqpQAAAAASUVORK5CYII&#x3D;"
                data-src="https://img.icons8.com/external-icongeek26-linear-colour-icongeek26/2x/external-customer-ads-icongeek26-linear-colour-icongeek26.png"
                data-retina-src="https://img.icons8.com/external-icongeek26-linear-colour-icongeek26/2x/external-customer-ads-icongeek26-linear-colour-icongeek26.png">
            </div>
          </div>

          <div class="widget item-absolute headline  " id="element-203" data-at="headline">
            <div class="contents">
              <h3>
                <span class="x_8b236db7 x_0fa34b5f"><span class="x_93908647">Online Customers.</span></span>
              </h3>
            </div>
          </div>

          <div class="widget item-absolute paragraph  " id="element-204" data-at="paragraph">
            <div class="contents">
              <p class="x_80f7663c x_390ad34e"><span class="x_93908647">Install PaySprint on website for customers to make payment with Debit/Credit Card or PaySprint Wallet.</span></p>
            </div>
          </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section section-relative  " id="page-block-3cg5fcg36ot" data-at="section">

      {{-- <div class="section-holder-border item-block item-absolute" data-at="section-border"></div> --}}
      {{-- <div class="section-holder-overlay item-block item-absolute" data-at="section-overlay"></div> --}}
      <div class="section-block">
        <div class="section-inner section-fit section-relative ">
          <div class="widget item-absolute headline  " id="element-215" data-at="headline">
            <div class="contents">
              <h1>
                <span class="x_ab3dc331 x_26d449b5"><span class="x_93908647">Connect your bank account to have your
                  payments deposited directly</span></span>
              </h1>
            </div>
          </div>
          <div class="">
          <div class="widget item-absolute  " id="element-256">
            <div class="contents cropped item-block" data-at="image-cropp">
              <img class="item-content-box item-block image img-lazy" data-at="image" alt=""
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mM89h8AApEBx2iaqpQAAAAASUVORK5CYII&#x3D;"
                data-src="https://v.fastcdn.co/u/e36f2c7e/62519900-0-money-bag.svg"
                data-retina-src="https://v.fastcdn.co/u/e36f2c7e/62519900-0-money-bag.svg">
            </div>
          </div>

          <div class="widget item-absolute headline  " id="element-197" data-at="headline">
            <div class="contents">
              <h1>
                <span class="x_8b236db7 x_561aca13"><span class="x_93908647">Economize payment processing</span></span>
              </h1>
            </div>
          </div>

          <div class="widget item-absolute paragraph  " id="element-198" data-at="paragraph">
            <div class="contents">
              <p class="x_80f7663c x_4976ff6a"><span class="x_93908647">Save up to 90% of the cost of accepting customer
                  payments through swift and no-hassle transactions.</span></p>
            </div>
          </div>

          <div class="widget item-absolute  " id="element-258">
            <div class="contents cropped item-block" data-at="image-cropp">
              <img class="item-content-box item-block image img-lazy" data-at="image" alt=""
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mM89h8AApEBx2iaqpQAAAAASUVORK5CYII&#x3D;"
                data-src="https://v.fastcdn.co/u/e36f2c7e/62519905-0-cash-flow.svg"
                data-retina-src="https://v.fastcdn.co/u/e36f2c7e/62519905-0-cash-flow.svg">
            </div>
          </div>

          <div class="widget item-absolute headline  " id="element-200" data-at="headline">
            <div class="contents">
              <h1>
                <span class="x_8b236db7 x_561aca13"><span class="x_93908647">Improve your cashflow</span></span>
              </h1>
            </div>
          </div>

          <div class="widget item-absolute paragraph  " id="element-201" data-at="paragraph">
            <div class="contents">
              <p class="x_80f7663c x_4976ff6a"><span class="x_93908647">Accept payments from customers at no extra cost
                  on any mobile device, online, or on your website.</span></p>
            </div>
          </div>

          <div class="widget item-absolute  " id="element-255">
            <div class="contents cropped item-block" data-at="image-cropp">
              <img class="item-content-box item-block image img-lazy" data-at="image" alt=""
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mM89h8AApEBx2iaqpQAAAAASUVORK5CYII&#x3D;"
                data-src="https://v.fastcdn.co/u/e36f2c7e/62519909-0-online-data.svg"
                data-retina-src="https://v.fastcdn.co/u/e36f2c7e/62519909-0-online-data.svg">
            </div>
          </div>

          <div class="widget item-absolute headline  " id="element-203" data-at="headline">
            <div class="contents">
              <h1>
                <span class="x_8b236db7 x_0fa34b5f"><span class="x_93908647">Drive more traffic</span></span>
              </h1>
            </div>
          </div>

          <div class="widget item-absolute paragraph  " id="element-204" data-at="paragraph">
            <div class="contents">
              <p class="x_80f7663c x_390ad34e"><span class="x_93908647">Use PaySprint Market Place to drive more
                  customers to your business at no extra cost.</span></p>
            </div>
          </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section section-relative " id="page-block-p0avpzvahxp" data-at="section">

      <div class="section-holder-border item-block item-absolute" data-at="section-border"></div>
      <div class="section-holder-overlay item-block item-absolute" data-at="section-overlay"></div>
      <div class="section-block">
        <div class="section-inner section-fit section-relative">
          <div class="widget item-absolute headline  " id="element-216" data-at="headline">
            <div class="contents">
              <h1>
                <span class="x_10983523 x_21a56353"><span class="x_93908647">Utilize additional outlets to sell more to
                    customers</span></span>
              </h1>
            </div>
          </div>

          <div class="widget item-absolute paragraph  " id="element-217" data-at="paragraph">
            <div class="contents">
              <p class="x_e6507cf2 x_8c071feb"><span class="x_93908647">Enable yourself to sell more online with
                  easy-to-set-up tools and easy-to-use content management features.</span></p>
            </div>
          </div>

          <div class="widget item-absolute  " id="element-218">
            <a href="{{ route('register') }}" id="link-3s1v37daorj" class="onpage-link btn    item-block" data-at="button"
              data-link-3s1v37daorj>
              Get a Free Demo now
            </a>
          </div>

        </div>
      </div>

    
    </section>

 {{-- Review  --}}

     
 <div class="gallery">
  <div class="content">
  
  <h3>Taiwo A.</h3>
  <h4 style="padding-bottom: 3px">PaySprint is easy and inexpensive to use. I love the app.</h4>
 
  <ul class="list-star">
  <li class="star"><i class="fa fa-star" aria-hidden="true"></i></li>
  <li class="star"><i class="fa fa-star" aria-hidden="true"></i></li>
  <li class="star"><i class="fa fa-star" aria-hidden="true"></i></li>
  <li class="star"><i class="fa fa-star" aria-hidden="true"></i></li>
  <li class="star"><i class="fa fa-star" aria-hidden="true"></i></li>
  </ul>
  <h6>Auditor,Accounting</h6>
  </div>
  <div class="content">

  <h3>Tara W.</h3>
  <h4>Great to work with, I really like invoicing, and easy to use app.</h4>
  
  <ul class="list-star">
  <li class="star"><i class="fa fa-star" aria-hidden="true"></i></li>
  <li class="star"><i class="fa fa-star" aria-hidden="true"></i></li>
  <li class="star"><i class="fa fa-star" aria-hidden="true"></i></li>
  <li class="star"><i class="fa fa-star" aria-hidden="true"></i></li>
  <li class="star"><i class="fa fa-star" aria-hidden="true"></i></li>
  </ul>
  <h6>Real Estate</h6>
  </div>
  <div class="content">
 
  <h3>Chantae T.</h3>
  <h4>Just getting started, but love it so far, Easy to use! I find PaySprint to be very competitive.</h4>

  <ul class="list-star">
  <li class="star"><i class="fa fa-star" aria-hidden="true"></i></li>
  <li class="star"><i class="fa fa-star" aria-hidden="true"></i></li>
  <li class="star"><i class="fa fa-star" aria-hidden="true"></i></li>
  <li class="star"><i class="fa fa-star" aria-hidden="true"></i></li>
  <li class="star"><i class="fa fa-star" aria-hidden="true"></i></li>
  </ul>
  <h6>Owner</h6>
  </div>
</div>

{{-- End of Review --}}




      <!-- Featured On -->


<div class="brand-section pt-13 pt-lg-17 pb-11 border-bottom bg-default-6">
  <div class="container">
      <div class="row justify-content-center align-items-center">
          <div class="col-md-8">
              {{-- <p class="gr-text-9 text-center mb-7">Trusted and Featured on:
              </p> --}}
              <h2 class="gr-text-4 text-center mb-8">As Featured on</h2>
          </div>
          <div class="col-12">
              <div class="brand-logos d-flex justify-content-center justify-content-xl-between align-items-center mx-n9 flex-wrap">
                  <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right" data-aos-duration="500" data-aos-once="true">
                      <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/questrade_znhne7_ua01kw.png" alt="" class="w-100" width="80" height="80">
                  </div>
                  <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right" data-aos-duration="500" data-aos-delay="600" data-aos-once="true">
                      <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/YahooFinanceLogo_geieeb_gpqual.png" alt="" class="w-100" width="60" height="60">
                  </div>
                  <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right" data-aos-duration="800" data-aos-delay="800" data-aos-once="true">
                      <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130249/assets/featuredon/private_capital_lxc1jr_kkswzw.png" alt="" class="w-100" width="60" height="60">
                  </div>
                  <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right" data-aos-duration="800" data-aos-delay="800" data-aos-once="true">
                      <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/benzinga_qpr7ot_kdvvtl.png" alt="" class="w-100" width="100" height="100">
                  </div>
                  <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right" data-aos-duration="800" data-aos-delay="800" data-aos-once="true">
                      <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/reuters_o3wnje_rmf94n.png" alt="" class="w-100" width="100" height="100">
                  </div>
                  <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right" data-aos-duration="500" data-aos-delay="400" data-aos-once="true">
                      <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130249/assets/featuredon/canadianbusinessjournal_e3mobm_lllwjj.png" alt="" class="w-100" width="100" height="100">
                  </div>
                  <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right" data-aos-duration="500" data-aos-delay="200" data-aos-once="true">
                      <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/magazinetoday_nsudvk_bjnihr.jpg" alt="" class="w-100" width="80" height="80">
                  </div>
                  <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right" data-aos-duration="500" data-aos-delay="200" data-aos-once="true">
                      <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/morningstar_ehxgue_mkpsrd.png" alt="" class="w-100" width="100" height="100">
                  </div>
                  <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right" data-aos-duration="500" data-aos-delay="200" data-aos-once="true">
                      <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/1280px-The_Globe_and_Mail__2019-10-31_.svg_ph46rz_qo87pl.png" alt="" class="w-100" style="width: 300px !important;">
                  </div>






              </div>
          </div>
      </div>
  </div>
</div>


<!-- End Featured On -->

<div class="cta-section pt-15 pt-lg-10 pb-5 pb-lg-5 bg-pattern pattern-7" style="background-color: #f2f2f2 !important;">
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-6">
              <div class="text-center dark-mode-texts">
                  <h2 class="gr-text-4 mb-7" style="color: #433d3d;">DOWNLOAD OUR APP</h2>

                  <a href="https://play.google.com/store/apps/details?id=com.fursee.damilare.sprint_mobile" target="_blank" class="btn text-white gr-hover-y px-lg-9">
                      <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130088/assets/l6-download-gplay_o9rcfj_l6erwf.png" alt="play store">
                  </a>
                  <a href="https://apps.apple.com/gb/app/paysprint/id1567742130" target="_blank" class="btn text-white gr-hover-y px-lg-7">
                      <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130088/assets/l6-download-appstore_odcskf_atgygf.png" alt="apple store">
                  </a>
                  <p class="gr-text-11 mb-0 mt-6" style="color: #433d3d;">It takes only 2 mins!</p>
              </div>

              <div class="hero-img-1" data-aos="fade-left" data-aos-duration="500" data-aos-once="true">
                  <div class="hero-video-thumb position-relative gr-z-index-1">
                      <center>
                          <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_ft8qly_frobtx.jpg" alt="" class="w-100 rounded-8" style="height: 350px !important;width: 350px !important;">
                      </center>
                      <a class="video-play-trigger gr-abs-center bg-white circle-xl gr-flex-all-center gr-abs-hover-y focus-reset" data-fancybox="" href="https://youtu.be/ptsmEYFJMx4" tabindex="-1"><i class="icon icon-triangle-right-17-2"></i></a>
                   
              </div>
          </div>

      </div>

    

  </div>
</div>

 

  </main>







  

  <!-- custom FOOTER code-->

  <script>window.__gdprComplianceScripts = window.__gdprComplianceScripts || []; window.__gdprComplianceScripts.push(function () { });</script>
  <!-- end custom FOOTER code-->

  <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
   <script src="https://g.fastcdn.co/js/utils.cd5b4894ab46ac49c25b.js"></script>
  <script src="https://g.fastcdn.co/js/Cradle.2834144546d6c56f4dd5.js"></script>
  <script src="https://g.fastcdn.co/js/UserConsent.774850cdd67203cf7eb7.js"></script>
  <script src="https://g.fastcdn.co/js/LazyImage.90aa95d960c719e556c2.js"></script>
  <script src="https://g.fastcdn.co/js/Form.9913500b352375ec139e.js"></script>
  <script async src="https://heatmap-events-collector.instapage.com/static/lib.js"></script>
  <script>
    const swiper = new Swiper('.swiper', {
  // Optional parameters
  direction: 'vertical',
  loop: true,

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
  },

  // Navigation arrows
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

  // And if we need scrollbar
  scrollbar: {
    el: '.swiper-scrollbar',
  },
});
  </script>

  <!-- Generated at: 2022-09-16T14:13:51.148Z -->
 
@endsection

</body>



<!-- Mirrored from info.gartnerdigitalmarkets.com/paysprint-gdm-lp by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 19 Sep 2022 12:07:19 GMT -->

</html>