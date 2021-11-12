import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import Aside from '../includes/Aside';
import Header from '../includes/Header';

const apiToken = document.getElementById('user_api_token').value;
const myCurrencyCode = document.getElementById('user_currency_code').value;

class EWallet extends Component {
	_isMounted = false;

	constructor(props) {
		super(props);

		this.state = {
			data: [],
			message: '',
			loading: true,
			currency: ''
		};
	}

	componentDidMount() {
		this._isMounted = true;

		try {
			axios.get(`/api/v1/fxwallets`, { headers: { Authorization: `Bearer ${apiToken}` } }).then((res) => {
				if (this._isMounted) {
					if (res.status === 200) {
						this.setState({
							data: res.data.data,
							message: res.data.message,
							loading: false
						});
					} else {
						this.setState({
							data: res.data.data,
							message: res.data.message,
							loading: false
						});
					}
				}
			});
		} catch (error) {
			console.log(error);
		}
	}

	componentWillUnmount() {
		this._isMounted = false;
	}

	render() {
		// Get Data Here
		var data_HTML_ACTIVE_ORDERS = '';
		var status_HTML = '';
		var i = 0;

		if (this.state.loading) {
			data_HTML_ACTIVE_ORDERS = (
				<tr>
					<td colSpan="6" align="center">
						<span className="font-weight-semibold text-gray-700 text-center">
							<img
								src="https://img.icons8.com/ios/35/000000/spinner-frame-4.png"
								className="fa fa-spin"
							/>
						</span>
					</td>
				</tr>
			);
		} else {
			if (this.state.message != 'success') {
				data_HTML_ACTIVE_ORDERS = (
					<tr>
						<td colSpan="7" align="center">
							<span className="font-weight-semibold text-gray-700 text-center">{this.state.message}</span>
						</td>
					</tr>
				);
			} else {
				data_HTML_ACTIVE_ORDERS = this.state.data.map((mywalletdata) => {
					i++;
					if (mywalletdata.active == 'true') {
						status_HTML = <span className="font-weight-semibold text-success">default</span>;
					} else {
						status_HTML = <span className="font-weight-semibold text-warning">secondary</span>;
					}

					return (
						<tr key={mywalletdata.id}>
							<td>{i}</td>

							<td>
								<span className="font-weight-semibold text-gray-700">{mywalletdata.escrow_id}</span>
							</td>
							<td>
								<span className="font-weight-semibold text-gray-700">{mywalletdata.currencyCode}</span>
							</td>
							<td>
								<span className="font-weight-semibold text-gray-700">
									{mywalletdata.currencySymbol +
										' ' +
										parseFloat(mywalletdata.wallet_balance).toFixed(2)}
								</span>
							</td>
							<td>{status_HTML}</td>
							<td>
								<a
									type="button"
									className="btn btn-warning"
									href={`/currencyfx/fund?currency=${mywalletdata.escrow_id}`}
								>
									<span className="font-weight-semibold text-black">
										<small>Fund Wallet</small>
									</span>
								</a>
							</td>
							<td>
								<a
									type="button"
									className="btn btn-primary"
									href={`/currencyfx/fund/transfer?currency=${mywalletdata.escrow_id}`}
								>
									<span className="font-weight-semibold text-white">
										<small>Move Money</small>
									</span>
								</a>
							</td>
						</tr>
					);
				});
			}
		}

		return (
			<div>
				<Aside apiToken={apiToken} currencycode={myCurrencyCode} />
				<Header apiToken={apiToken} />
				<div className="main-content">
					<div className="px-3 px-xxl-5 py-3 py-lg-4 border-bottom border-gray-200 after-header">
						<div className="container-fluid px-0">
							<div className="row align-items-center">
								<div className="col">
									<span className="text-uppercase tiny text-gray-600 Montserrat-font font-weight-semibold">
										Currency Exchange
									</span>
									<h1 className="h2 mb-0 lh-sm">My Wallets</h1>
								</div>
								<div className="col-auto d-flex align-items-center my-2 my-sm-0">
									<a href="#" className="btn btn-lg btn-outline-dark px-3 me-2 me-md-3 customize-btn">
										<span className="ps-1">New Offer</span>{' '}
										<svg
											className="ms-4"
											xmlns="http://www.w3.org/2000/svg"
											width="14"
											height="14"
											viewBox="0 0 14 14"
										>
											<rect
												data-name="Icons/Tabler/Add background"
												width="14"
												height="14"
												fill="none"
											/>
											<path
												d="M6.329,13.414l-.006-.091V7.677H.677A.677.677,0,0,1,.585,6.329l.092-.006H6.323V.677A.677.677,0,0,1,7.671.585l.006.092V6.323h5.646a.677.677,0,0,1,.091,1.348l-.091.006H7.677v5.646a.677.677,0,0,1-1.348.091Z"
												fill="#1e1e1e"
											/>
										</svg>
									</a>

									<Link to={'/currencyfx/'} className="btn btn-lg btn-warning">
										<svg
											className="me-2"
											data-name="Icons/Tabler/Paperclip Copy 2"
											xmlns="http://www.w3.org/2000/svg"
											width="14"
											height="14"
											viewBox="0 0 18 18"
										>
											<rect
												data-name="Icons/Tabler/Bolt background"
												width="18"
												height="18"
												fill="none"
											/>
											<path
												d="M6.377,18a.7.7,0,0,1-.709-.6l-.006-.1V11.537H.709A.7.7,0,0,1,.1,11.193a.673.673,0,0,1-.014-.672l.054-.083L7.693.274,7.755.2,7.828.141,7.913.087,7.981.055l.087-.03L8.16.006,8.256,0h.037l.059.005.04.007.052.011.045.014.043.016.052.023.089.055.016.011A.765.765,0,0,1,8.756.2L8.82.273l.055.083.033.067.03.085L8.957.6l.007.094V6.461h4.952a.7.7,0,0,1,.613.345.672.672,0,0,1,.013.672l-.053.082L6.942,17.714A.691.691,0,0,1,6.377,18ZM7.548,2.821,2.1,10.153H6.369a.7.7,0,0,1,.7.6l.006.093v4.331l5.449-7.331H8.256a.7.7,0,0,1-.7-.6l-.007-.094Z"
												transform="translate(2.25 0)"
												fill="#1E1E1E"
											/>
										</svg>
										<span>Dashboard</span>
									</Link>
								</div>
							</div>
						</div>
					</div>
					<div className="p-3 p-xxl-5">
						<div className="container-fluid px-0">
							<div className="row group-cards pt-2">
								<div className="col-12 mb-4">
									<div className="card rounded-12 shadow-dark-80 border border-gray-50">
										<div className="d-flex align-items-center px-3 px-md-4 py-3">
											<h5 className="card-header-title mb-0 ps-md-2 font-weight-semibold">
												My Wallets
											</h5>
										</div>
										<div className="table-responsive mb-0">
											<table className="table card-table table-nowrap overflow-hidden">
												<thead>
													<tr>
														<th>#</th>
														<th>Wallet ID</th>
														<th>Wallet Currency</th>
														<th>Wallet Balance</th>
														<th>Status</th>
														<th>Funding</th>
														<th>Move money</th>
													</tr>
												</thead>
												<tbody className="list">{data_HTML_ACTIVE_ORDERS}</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		);
	}
}

export default EWallet;
