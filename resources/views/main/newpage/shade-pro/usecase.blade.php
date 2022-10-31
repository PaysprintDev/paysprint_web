@extends('layouts.newpage.app')

@section('content')
<style>
   @import url('https://fonts.googleapis.com/css?family=Poppins&display=swap');
* {
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

.blog-card {
  display: flex;
  flex-direction: column;
  margin: 1rem auto;
  box-shadow: 0 3px 7px -1px rgba(0, 0, 0, 0.1);
  margin-bottom: 1.6%;
  background: #fff;
  line-height: 1.4;
  font-family: sans-serif;
  border-radius: 5px;
  overflow: hidden;
  z-index: 0;
}
.blog-card a {
  color: inherit;
}
.blog-card a:hover {
  color: #5ad67d;
}
.blog-card:hover .photo {
  transform: scale(1.3) rotate(3deg);
}
.blog-card .meta {
  position: relative;
  z-index: 0;
  height: 200px;
}
.blog-card .photo {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background-size: cover;
  background-position: center;
  transition: transform 0.2s;
}
.blog-card .details, .blog-card .details ul {
  margin: auto;
  padding: 0;
  list-style: none;
}
.blog-card .details {
  position: absolute;
  top: 0;
  bottom: 0;
  left: -100%;
  margin: auto;
  transition: left 0.2s;
  background: rgba(0, 0, 0, 0.6);
  color: #fff;
  padding: 10px;
  width: 100%;
  font-size: 0.9rem;
}
.blog-card .details a {
  text-decoration: dotted underline;
}
.blog-card .details ul li {
  display: inline-block;
}
.blog-card .details .tags li {
  margin-right: 2px;
}
.blog-card .details .tags li:first-child {
  margin-left: -4px;
}
.blog-card .description {
  padding: 1rem;
  background: #fff;
  position: relative;
  z-index: 1;
}
.blog-card .description h1, .blog-card .description h2 {
  font-family: Poppins, sans-serif;
}
.blog-card .description h1 {
  line-height: 1;
  margin: 0;
  font-size: 1.7rem;
}
.blog-card .description h2 {
  font-size: 1rem;
  font-weight: 300;
  text-transform: uppercase;
  color: #a2a2a2;
  margin-top: 5px;
}
.blog-card .description .read-more {
  text-align: right;
}
.blog-card .description .read-more a {
  color: #5ad67d;
  display: inline-block;
  position: relative;
  text-decoration: none;
}
.blog-card p {
  position: relative;
  margin: 1rem 0 0;
}

.blog-card:hover .details {
  left: 0%;
}
@media (min-width: 640px) {
  .blog-card {
    flex-direction: row;
    max-width: 700px;
  }
  .blog-card .meta {
    flex-basis: 40%;
    height: auto;
  }
  .blog-card .description {
    flex-basis: 60%;
  }
  .blog-card.alt {
    flex-direction: row-reverse;
  }
  .blog-card.alt .details {
    padding-left: 25px;
  }
  .content{
   
    margin-left:20rem;
    margin-right: 20rem
  }
  .content p{
    font-size: 16px;
    line-height: 35px
  }
}


</style>
    <div class="hero-container" >
      <div>
       <h1 style="padding-bottom: 70px">cases</h1>  
    </div> 
     <div class="sub-container" >
        <div class="blog-card">
            <div class="meta">
              <div class="photo" >
                <img src="{{ asset('images/sellitic.JPG') }}" alt="sellitic" style="width: 20rem; height:15rem"/>
              </div>
              <ul class="details">
                <li class="author"><a href="#">Consumer Services</a></li>
                <li class="date">Brampton, Ontario, Canada</li>
           
              </ul>
            </div>
            <div class="description">
              <h1>SELLITIC Marketplace Inc.</h1>
              <h2>SELLITIC - An online handicraft marketplace for the creative (handicraft) sector. </h2>
              <p>Consumer Services </p>
              <p>Brampton, Ontario, Canada</p>
             
            </div>
            
        </div>
        <div class="content">
        <p style="">SELLITIC adopts a purpose-driven and decentralized business model that drives diversity, equity and inclusion within the creative economy. Their mission to drive prosperity within the creative economy relies significantly on reducing the barriers to entry and operations for artists and artisans across Africa and the globe. <br>
            The marketplace connects artists and artisans (creators) with buyers globally which offers the creators more visibility and opportunities to export their products across the globe.
            PaySprint is supporting the SELLITIC Marketplace with a flexible, tailored-made, and affordable payments processing service that enables artisans in the informal sectors in over 100 countries to accept payments at zero costs to creators selling on the marketplace.<br>
            The low cost of completing the end-to-end transaction provides a huge incentive to both SELLITIC and creators selling on the marketplace.
        </p>
      </div>
      <hr>
           
        
      <div class="blog-card">
        <div class="meta">
          <div class="photo">
            <img src="{{ asset('images/Busy Wrench.JPG') }}" alt="busywrench" style="width: 20rem; height:15rem"/></div>
          <ul class="details">
            <li class="author"><a href="#">Automotive</a></li>
            <li class="date">Brampton, Ontario, Canada</li>
        
          </ul>
        </div>
        <div class="description">
          <h1>Automotive</h1>
          <h2>Busy Wrench - More than a Shop Management Software</h2>
          <p>Automotive</p>
          <p>Ontario, Canada</p>
        
        </div>
        
    </div>
    <div class="content">
    <p style="">Busy Wrench offers shop management software to auto repair sub-sector in automotive industry. The auto repair shop owners in the sub-sector are usually looking for Shop Management Software that offers not only an end-to-end shop operation management but also helps to drive traffic to shop floor, improve sales, track expenses, and boost the profitability of the business.These are the objectives Busy Wrench is designed to achieve.<br>
        PaySprint provides Busy Wrench with a unique opportunity to offer over 65, 000 Auto Repair shop-owners and 51,000 Auto Dealers on Busy Wrench with a low cost and affordable method of accepting payments from vehicle owners.
        
    </p>
  </div>
  <hr>
  <div class="blog-card">
    <div class="meta">
      <div class="photo">
        <img src="{{ asset('images/Renard-Blue.JPG') }}" alt="Renard" style="width: 20rem; height:15rem"/></div>
      <ul class="details">
        <li class="author"><a href="#">Retail</a></li>
        <li class="date">Quebec, Canada</li>
       
      </ul>
    </div>
    <div class="description">
      <h1>Renard-Bleuc</h1>
      <h2>Renard-Blue–Online Grocery Shopping with a Difference</h2>
      <p>Retail</p>
      <p>Quebec,Canada</p>
    
    </div>
    
</div>
<div class="content">
<p style="">Renard Blue offers affordable grocery shopping experience. The online grocery service provides customer with much ease of doing essentials from the comfort of their home.<br>
    Retail business is naturally characterised by high volume, low margin and high risk and costs of cash handling.
    PaySprint offers Renard-Blue the opportunity to accept online payments from customers at no costs which improves the profitability of the business.
    
</p>
</div>
    </div>
     
    

@endsection