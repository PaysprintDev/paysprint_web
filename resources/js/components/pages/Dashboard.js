import axios from 'axios';
import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import ActiveOrders from '../includes/ActiveOrders';
import Aside from '../includes/Aside';
import Footer from '../includes/Footer';
import Header from '../includes/Header';


const apiToken = document.getElementById('user_api_token').value;

class Dashboard extends Component {

    _isMounted = false;

    constructor(props) {
        super(props)

        this.state = {
            data: [],
            message: '',
            loading: true,
        }
    }


    componentDidMount() {

        this._isMounted = true;

        try {

                axios.get(`/api/v1/userdata`, { headers: { Authorization: `Bearer ${apiToken}` } }).then(res => {
                    
                    if (this._isMounted) {
                        
                        if (res.status === 200) {
                            this.setState({
                                data: res.data.data,
                                message: res.data.message,
                                loading: false,
                            });
                        }
                        else {
                            this.setState({
                                data: res.data.data,
                                message: res.data.message,
                                loading: false,
                            });
                        }
                        
                    }
                    
                });


        } catch (error) {
            console.log(error);
        }





    }


    componentWillUnmount(){
        this._isMounted = false;
    }




    render() {

        function round(num) {
            var m = Number((Math.abs(num) * 100).toPrecision(15));
            return Math.round(m) / 100 * Math.sign(num);
        }

        var walletBalance = "";

        if (this.state.loading) {
            walletBalance = <div className="col-auto"><img src="https://img.icons8.com/ios/30/000000/spinner-frame-4.png" className="fa fa-spin" /></div>;
        }
        else {
            walletBalance = <div className="col-auto"><h2>{this.state.data.currencySymbol + '' + round(this.state.data.wallet_balance)}</h2></div>
        }

        return (
            <div>
                <Aside />

                <Header apiToken={apiToken} />
                <div className="main-content">

                    <div className="px-3 px-xxl-5 py-3 py-lg-4 border-bottom border-gray-200 after-header">
                        <div className="container-fluid px-0">
                            <div className="row align-items-center">
                                <div className="col">
                                    <h3 className="h2 mb-0">What do you want to do today?</h3>
                                </div>
                                <div className="col-auto d-flex align-items-center my-2 my-sm-0">
                                    <a href="#" className="btn btn-lg btn-outline-dark px-3 me-2 me-md-3 customize-btn"><span className="ps-1">New
                                        Offer</span> <svg className="ms-4" xmlns="http://www.w3.org/2000/svg" width="14"
                                            height="14" viewBox="0 0 14 14">
                                            <rect data-name="Icons/Tabler/Add background" width="14" height="14" fill="none" />
                                            <path
                                                d="M6.329,13.414l-.006-.091V7.677H.677A.677.677,0,0,1,.585,6.329l.092-.006H6.323V.677A.677.677,0,0,1,7.671.585l.006.092V6.323h5.646a.677.677,0,0,1,.091,1.348l-.091.006H7.677v5.646a.677.677,0,0,1-1.348.091Z"
                                                fill="#1e1e1e" />
                                        </svg>
                                    </a>
                                    <div className="dropdown export-dropdown">
                                        <a href="#" role="button" id="Exportbtn" data-bs-toggle="dropdown" aria-expanded="false"
                                            className="btn btn-lg btn-warning ms-1 px-3"><span className="ps-1">Wallet</span> <svg
                                                className="ms-4" xmlns="http://www.w3.org/2000/svg" width="14" height="7.875"
                                                viewBox="0 0 14 7.875">
                                                <path
                                                    d="M.231.228A.8.8,0,0,1,1.256.152l.088.075,6.3,6.222a.771.771,0,0,1,.076,1.013l-.076.087-6.3,6.222a.794.794,0,0,1-1.114,0,.771.771,0,0,1-.076-1.013l.076-.087L5.973,7,.231,1.328A.771.771,0,0,1,.154.315Z"
                                                    transform="translate(14) rotate(90)" fill="#1e1e1e" />
                                            </svg>
                                        </a>
                                        <ul className="dropdown-menu" aria-labelledby="Exportbtn">
                                            <li className="dropdown-sub-title">
                                                <span>WALLET ACTIONS</span>
                                            </li>
                                            <li><a className="dropdown-item" href="/mywallet"><svg data-name="Icons/Tabler/Share"
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                                <rect data-name="Icons/Tabler/File background" width="16" height="16" fill="none" />
                                                <path data-name="Combined Shape"
                                                    d="M2.256,16A2.259,2.259,0,0,1,0,13.744V2.256A2.259,2.259,0,0,1,2.256,0H8a.613.613,0,0,1,.4.148l0,0L8.41.157l0,0,.005.005L8.425.17l0,0L8.435.18l4.1,4.1a.614.614,0,0,1,.185.44v9.026A2.259,2.259,0,0,1,10.462,16ZM1.231,2.256V13.744a1.026,1.026,0,0,0,1.025,1.025h8.205a1.027,1.027,0,0,0,1.026-1.025V5.333H8.821A1.436,1.436,0,0,1,7.387,3.979l0-.082V1.231H2.256A1.026,1.026,0,0,0,1.231,2.256ZM8.616,3.9a.206.206,0,0,0,.168.2l.037,0h1.8l-2-2ZM3.9,12.718a.615.615,0,0,1-.059-1.228l.059,0H8.821a.615.615,0,0,1,.059,1.228l-.059,0Zm0-3.282a.615.615,0,0,1-.059-1.228l.059,0H8.821a.615.615,0,0,1,.059,1.228l-.059,0Zm0-3.281a.616.616,0,0,1-.059-1.228l.059,0h.821a.615.615,0,0,1,.059,1.228l-.059,0Z"
                                                    transform="translate(2)" fill="#495057" />
                                            </svg><span className="ms-2">MY WALLET</span></a></li>
                                            <li><a className="dropdown-item" href="/mywallet/addmoney"><svg data-name="Icons/Tabler/Share"
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                                <rect data-name="Icons/Tabler/File background" width="16" height="16" fill="none" />
                                                <path data-name="Combined Shape"
                                                    d="M2.256,16A2.259,2.259,0,0,1,0,13.744V2.256A2.259,2.259,0,0,1,2.256,0H8a.613.613,0,0,1,.4.148l0,0L8.41.157l0,0,.005.005L8.425.17l0,0L8.435.18l4.1,4.1a.614.614,0,0,1,.185.44v9.026A2.259,2.259,0,0,1,10.462,16ZM1.231,2.256V13.744a1.026,1.026,0,0,0,1.025,1.025h8.205a1.027,1.027,0,0,0,1.026-1.025V5.333H8.821A1.436,1.436,0,0,1,7.387,3.979l0-.082V1.231H2.256A1.026,1.026,0,0,0,1.231,2.256ZM8.616,3.9a.206.206,0,0,0,.168.2l.037,0h1.8l-2-2ZM3.9,12.718a.615.615,0,0,1-.059-1.228l.059,0H8.821a.615.615,0,0,1,.059,1.228l-.059,0Zm0-3.282a.615.615,0,0,1-.059-1.228l.059,0H8.821a.615.615,0,0,1,.059,1.228l-.059,0Zm0-3.281a.616.616,0,0,1-.059-1.228l.059,0h.821a.615.615,0,0,1,.059,1.228l-.059,0Z"
                                                    transform="translate(2)" fill="#495057" />
                                            </svg><span className="ms-2">ADD MONEY</span></a></li>
                                            <li><a className="dropdown-item" href="/mywallet/withdrawmoney"><svg data-name="Icons/Tabler/Share"
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                                <rect data-name="Icons/Tabler/File background" width="16" height="16" fill="none" />
                                                <path data-name="Combined Shape"
                                                    d="M2.256,16A2.259,2.259,0,0,1,0,13.744V2.256A2.259,2.259,0,0,1,2.256,0H8a.613.613,0,0,1,.4.148l0,0L8.41.157l0,0,.005.005L8.425.17l0,0L8.435.18l4.1,4.1a.614.614,0,0,1,.185.44v9.026A2.259,2.259,0,0,1,10.462,16ZM1.231,2.256V13.744a1.026,1.026,0,0,0,1.025,1.025h8.205a1.027,1.027,0,0,0,1.026-1.025V5.333H8.821A1.436,1.436,0,0,1,7.387,3.979l0-.082V1.231H2.256A1.026,1.026,0,0,0,1.231,2.256ZM8.616,3.9a.206.206,0,0,0,.168.2l.037,0h1.8l-2-2ZM3.9,12.718a.615.615,0,0,1-.059-1.228l.059,0H8.821a.615.615,0,0,1,.059,1.228l-.059,0Zm0-3.282a.615.615,0,0,1-.059-1.228l.059,0H8.821a.615.615,0,0,1,.059,1.228l-.059,0Zm0-3.281a.616.616,0,0,1-.059-1.228l.059,0h.821a.615.615,0,0,1,.059,1.228l-.059,0Z"
                                                    transform="translate(2)" fill="#495057" />
                                            </svg><span className="ms-2">WITHDRAW</span></a></li>
                                            <li>
                                                <hr className="dropdown-divider" />
                                            </li>
                                            <li><a className="dropdown-item" href="#"><svg data-name="Icons/Tabler/Share"
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                                <rect data-name="Icons/Tabler/Share background" width="16" height="16"
                                                    fill="none" />
                                                <path
                                                    d="M9.846,12.923a3.07,3.07,0,0,1,.1-.768L5.516,9.874a3.077,3.077,0,1,1,0-3.748L9.943,3.845a3.084,3.084,0,1,1,.541,1.106L6.057,7.232a3.087,3.087,0,0,1,0,1.537l4.427,2.281a3.075,3.075,0,1,1-.638,1.874Zm1.231,0a1.846,1.846,0,1,0,.2-.84q-.011.028-.025.055l-.014.025A1.836,1.836,0,0,0,11.077,12.923ZM1.231,8a1.846,1.846,0,0,0,3.487.845.623.623,0,0,1,.027-.061l.017-.031a1.845,1.845,0,0,0,0-1.508l-.017-.031a.622.622,0,0,1-.027-.061A1.846,1.846,0,0,0,1.231,8ZM12.923,4.923a1.846,1.846,0,1,0-1.682-1.086l.013.024q.014.027.025.056A1.848,1.848,0,0,0,12.923,4.923Z"
                                                    fill="#495057" />
                                            </svg><span className="ms-2">Share</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div className="p-3 p-xxl-5">
                        <div className="container-fluid px-0">
                            <div className="row">
                                <div className="col-md-12">
                                    <div className="bg-blue-50 p-4 p-md-5 position-relative overflow-hidden rounded-12 mb-4 alert alert-dismissible zIndex-0"
                                        role="alert">
                                        <div className="row mb-0 mb-sm-5 mb-md-0 ps-xl-3">
                                            <div className="col-lg-12 col-xl-12 col-xxl-12 pb-md-5 mb-md-5 mb-lg-0">

                                                <span className="badge badge-lg badge-warning text-uppercase">Currency Exchange</span>
                                                <h2 className="my-2">Buy and Sell at favourable rate
                                                    <img src="https://fabrx.co/preview/muse-dashboard/assets/svg/icons/right-arrow.svg"
                                                        className="ms-2 arrow-icon" alt="img" />
                                                </h2>
                                            </div>


                                            <div className="col-lg-8">
                                                <div className="get-started-img">
                                                    <img src="/cfx/assets/img/get-started.png" className="img-fluid"
                                                        alt="img" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <ActiveOrders apiToken={apiToken} />



                            <div className="row">
                                <div className="col-12 col-xxl-5 mb-4">
                                    <div className="card rounded-12 shadow-dark-80 overflow-hidden border border-gray-50">
                                        <div className="card-body px-0 pb-0">

                                            <div className="list-group list-group-flush my-n3">
                                                <div className="list-group-item px-3 px-md-4">
                                                    <div className="row align-items-center px-md-2">
                                                        <div className="col-auto">
                                                            <img className="avatar-img"
                                                                src="https://res.cloudinary.com/pilstech/image/upload/v1633681766/paysprint_asset/wallet-balance_qluod6.svg"
                                                                alt="Avatars" />
                                                        </div>
                                                        <div className="col p-0">
                                                            <h4 className="mb-1 font-weight-semibold">
                                                                Wallet balance
                                                            </h4>
                                                        </div>
                                                        {walletBalance}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className="col-12 col-xxl-7 mb-4">
                                    <div className="card rounded-12 shadow-dark-80 h-100 border border-gray-50">
                                        <div className="card-body px-0 pb-0">

                                            <div className="list-group list-group-flush my-n3">
                                                <div className="list-group-item px-3 px-md-4">
                                                    <div className="row align-items-center px-md-2">

                                                        <div className="col p-0">
                                                            <p className="mb-1">

                                                                This month we gave away <span
                                                                    style={{ fontWeight: "bold", fontSize: "20px" }}>$5,000</span> in
                                                                referrals. You
                                                                could earn with
                                                                referrals too!
                                                            </p>
                                                        </div>
                                                        <div className="col-auto">
                                                            <a href="#" className="btn btn-lg btn-outline-dark px-3 me-2 me-md-3"><span
                                                                className="ps-1">Refer Now</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>






                        </div>

                    </div>

                </div>

                {/* <Footer /> */}

            </div>
        );
    }
}

export default Dashboard;