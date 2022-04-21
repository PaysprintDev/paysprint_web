import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import Aside from '../includes/Aside';
import Header from '../includes/Header';

const apiToken = document.getElementById('user_api_token').value;
const myCurrencyCode = document.getElementById('user_currency_code').value;

class CrossBorderPlatform extends Component {
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
			axios
				.get(`/api/v1/getallcrossborderpayment`, { headers: { Authorization: `Bearer ${apiToken}` } })
				.then((res) => {
					if (this._isMounted) {
						if (res.status === 200) {
							console.log(res.data.data);
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
		var data_HTML_ACTIVE_ORDERS = '';
		var status_HTML = '';
		var status_Action = '';

		if (this.state.loading) {
			data_HTML_ACTIVE_ORDERS = (
				<tr>
					<td colSpan="8" align="center">
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
						<td colSpan="8" align="center">
							<span className="font-weight-semibold text-gray-700 text-center">{this.state.message}</span>
						</td>
					</tr>
				);
			} else {
				data_HTML_ACTIVE_ORDERS = this.state.data.map((activeOrders) => {
					if (activeOrders.status == false) {
						status_HTML = <span className="text-danger font-weight-semibold">Pending</span>;
					} else {
						status_HTML = <span className="text-success font-weight-semibold">Processed</span>;
					}

					return (
						<tr key={activeOrders.id}>
							<td>
								<span className="font-weight-semibold text-gray-700">
									{activeOrders.transaction_id}
								</span>
							</td>
							<td>
								<span className="font-weight-semibold text-gray-500">{activeOrders.created_at}</span>
							</td>
							<td>
								<span className="font-weight-semibold text-gray-500">
									{activeOrders.receivers_name}
								</span>
							</td>
							<td>
								<span className="font-weight-semibold text-gray-500">
									{activeOrders.currencySymbol + ' ' + parseFloat(activeOrders.amount).toFixed(2)}
								</span>
							</td>
							<td>
								<span className="font-weight-semibold text-gray-500">{activeOrders.select_wallet}</span>
							</td>
							<td>
								<span className="font-weight-semibold text-gray-500">{activeOrders.purpose}</span>
							</td>
							<td align="center">
								<span className="font-weight-semibold text-gray-500">
									<a href={`${activeOrders.file}`} target="_blank">
										<img src="https://img.icons8.com/external-kiranshastry-lineal-color-kiranshastry/20/000000/external-invoice-advertising-kiranshastry-lineal-color-kiranshastry.png" />
									</a>
								</span>
							</td>

							<td>{status_HTML}</td>
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
									<h1 className="h2 mb-0 lh-sm">Cross Border Payments</h1>
								</div>
								<div className="col-auto d-flex align-items-center my-2 my-sm-0">
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
							<div className="mb-2 mb-md-3 mb-xl-4 pb-2">
								<ul className="nav nav-tabs nav-tabs-md nav-tabs-line position-relative zIndex-0">
									<li className="nav-item">
										<Link className="nav-link active" to={'/currencyfx/crossborderplatform'}>
											Processed Invoice Payment
										</Link>
									</li>
									<li className="nav-item">
										<Link className="nav-link" to={'/currencyfx/pendingcrossborderpayment'}>
											Pending Invoice Pay
										</Link>
									</li>
									<li className="nav-item">
										<a className="nav-link" href="/currencyfx/crossborder">
											Create New Payment
										</a>
									</li>
								</ul>
							</div>

							<div className="row group-cards pt-2">
								<div className="col-12 mb-4">
									<div className="card rounded-12 shadow-dark-80 border border-gray-50">
										<div className="d-flex align-items-center px-3 px-md-4 py-3">
											<h5 className="card-header-title mb-0 ps-md-2 font-weight-semibold">
												Process Invoicese Payments
											</h5>
											<div className="dropdown export-dropdown ms-auto pe-md-2">
												<a
													href="/currencyfx/crossborder"
													role="button"
													aria-expanded="false"
													className="btn btn-outline-dark text-gray-700 border-gray-700 px-3"
												>
													<span>
														<img
															src="https://img.icons8.com/external-becris-lineal-becris/18/000000/external-add-mintab-for-ios-becris-lineal-becris-2.png"
															alt="Tio Tune"
														/>
														Create New Payment
													</span>
												</a>
											</div>
										</div>
										<div className="table-responsive mb-0">
											<table className="table card-table table-nowrap overflow-hidden">
												<thead>
													<tr>
														<th>Transaction ID</th>
														<th>Date & Time</th>
														<th>Receiver</th>
														<th>Amount</th>
														<th>Payment Method</th>
														<th>Purpose</th>
														<th>Invoice File</th>
														<th>Status</th>
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

export default CrossBorderPlatform;
