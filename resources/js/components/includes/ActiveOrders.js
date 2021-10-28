import React, { Component } from 'react';

class ActiveOrders extends Component {
	_isMounted = false;

	constructor(props) {
		super(props);

		this.state = {
			data: [],
			message: '',
			loading: true
		};
	}

	async componentDidMount() {
		this._isMounted = true;

		const res = await axios.get(`/api/v1/activeorders`, {
			headers: { Authorization: `Bearer ${this.props.apiToken}` }
		});

		try {
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
		} catch (error) {
			console.error(error);
		}
	}

	componentWillUnmount() {
		this._isMounted = false;
	}

	render() {
		var data_HTML_ACTIVE_ORDERS = '';
		var status_HTML = '';

		if (this.state.loading) {
			data_HTML_ACTIVE_ORDERS = (
				<tr>
					<td colSpan="7" align="center">
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
				data_HTML_ACTIVE_ORDERS = this.state.data.map((activeOrders) => {
					if (activeOrders.status == 'Sold') {
						status_HTML = (
							<div className="dropdown-menu dropdown-menu-end">
								<a href="#" className="dropdown-item">
									Deal Closed
								</a>
							</div>
						);
					} else {
						status_HTML = (
							<div className="dropdown-menu dropdown-menu-end">
								<a href="#" className="dropdown-item">
									Accept & Transfer
								</a>
							</div>
						);
					}

					return (
						<tr key={activeOrders.id}>
							<td>
								<span className="font-weight-semibold text-gray-700">{activeOrders.order_id}</span>
							</td>
							<td>
								<span className="font-weight-semibold text-gray-500">
									{parseFloat(activeOrders.sell).toFixed(2) + ' ' + activeOrders.sell_currencyCode}
								</span>
							</td>
							<td>
								<span className="font-weight-semibold text-gray-500">
									{parseFloat(activeOrders.buy).toFixed(2) + ' ' + activeOrders.buy_currencyCode}
								</span>
							</td>
							<td>
								<span className="font-weight-semibold text-gray-500">{activeOrders.rate}</span>
							</td>
							<td>
								<span className="font-weight-semibold text-gray-500">{activeOrders.expiry}</span>
							</td>
							<td>
								<span
									className="font-weight-semibold text-gray-500"
									style={{ color: `${activeOrders.color}` }}
								>
									{activeOrders.status}
								</span>
							</td>
							<td>
								<div className="dropdown ">
									<a
										href="#"
										className="btn btn-dark-100 btn-icon btn-sm rounded-circle"
										role="button"
										data-bs-toggle="dropdown"
										aria-haspopup="true"
										aria-expanded="false"
									>
										<svg
											data-name="Icons/Tabler/Notification"
											xmlns="http://www.w3.org/2000/svg"
											width="13.419"
											height="13.419"
											viewBox="0 0 13.419 13.419"
										>
											<rect
												data-name="Icons/Tabler/Dots background"
												width="13.419"
												height="13.419"
												fill="none"
											/>
											<path
												d="M0,10.4a1.342,1.342,0,1,1,1.342,1.342A1.344,1.344,0,0,1,0,10.4Zm1.15,0a.192.192,0,1,0,.192-.192A.192.192,0,0,0,1.15,10.4ZM0,5.871A1.342,1.342,0,1,1,1.342,7.213,1.344,1.344,0,0,1,0,5.871Zm1.15,0a.192.192,0,1,0,.192-.192A.192.192,0,0,0,1.15,5.871ZM0,1.342A1.342,1.342,0,1,1,1.342,2.684,1.344,1.344,0,0,1,0,1.342Zm1.15,0a.192.192,0,1,0,.192-.192A.192.192,0,0,0,1.15,1.342Z"
												transform="translate(5.368 0.839)"
												fill="#6c757d"
											/>
										</svg>
									</a>

									{status_HTML}
								</div>
							</td>
						</tr>
					);
				});
			}
		}

		return (
			<div>
				<div className="row">
					<div className="col-12 mb-4">
						<div className="card rounded-12 shadow-dark-80 border border-gray-50">
							<div className="d-flex align-items-center px-3 px-md-4 py-3">
								<h5 className="card-header-title mb-0 ps-md-2 font-weight-semibold">Active Orders</h5>
								<div className="dropdown export-dropdown ms-auto pe-md-2">
									<a
										href="#"
										role="button"
										id="Sources"
										data-bs-toggle="dropdown"
										aria-expanded="false"
										className="btn btn-outline-dark text-gray-700 border-gray-700 px-3"
									>
										<span>Today</span>
										<svg
											className="ms-2"
											xmlns="http://www.w3.org/2000/svg"
											width="13"
											height="13"
											viewBox="0 0 13 13"
										>
											<rect
												data-name="Icons/Tabler/Chevron Down background"
												width="13"
												height="13"
												fill="none"
											/>
											<path
												d="M.214.212a.738.738,0,0,1,.952-.07l.082.07L7.1,5.989a.716.716,0,0,1,.071.94L7.1,7.011l-5.85,5.778a.738.738,0,0,1-1.034,0,.716.716,0,0,1-.071-.94l.071-.081L5.547,6.5.214,1.233A.716.716,0,0,1,.143.293Z"
												transform="translate(13 3.25) rotate(90)"
												fill="#495057"
											/>
										</svg>
									</a>
									<ul className="dropdown-menu dropdown-menu-end" aria-labelledby="Sources">
										<li>
											<a className="dropdown-item" href="#">
												<span>Today</span>
											</a>
										</li>
										<li>
											<a className="dropdown-item" href="#">
												<span>Yesterday</span>
											</a>
										</li>
										<li>
											<a className="dropdown-item" href="#">
												<span>Last 7 days</span>
											</a>
										</li>
										<li>
											<a className="dropdown-item" href="#">
												<span>This month</span>
											</a>
										</li>
										<li>
											<a className="dropdown-item" href="#">
												<span>Last month</span>
											</a>
										</li>
										<li>
											<hr className="dropdown-divider" />
										</li>
										<li>
											<a className="dropdown-item" href="#">
												<svg
													data-name="icons/tabler/calendar"
													xmlns="http://www.w3.org/2000/svg"
													width="16"
													height="16"
													viewBox="0 0 16 16"
												>
													<rect
														data-name="Icons/Tabler/Calendar background"
														width="16"
														height="16"
														fill="none"
													/>
													<path
														d="M2.256,16A2.259,2.259,0,0,1,0,13.743V3.9A2.259,2.259,0,0,1,2.256,1.641H3.282V.616A.615.615,0,0,1,4.507.532l.005.084V1.641H9.846V.616A.615.615,0,0,1,11.071.532l.006.084V1.641H12.1A2.259,2.259,0,0,1,14.359,3.9v9.846A2.259,2.259,0,0,1,12.1,16ZM1.231,13.743a1.027,1.027,0,0,0,1.025,1.026H12.1a1.027,1.027,0,0,0,1.026-1.026V7.795H1.231Zm11.9-7.179V3.9A1.027,1.027,0,0,0,12.1,2.872H11.077V3.9a.616.616,0,0,1-1.226.084L9.846,3.9V2.872H4.513V3.9a.615.615,0,0,1-1.225.084L3.282,3.9V2.872H2.256A1.026,1.026,0,0,0,1.231,3.9V6.564Z"
														transform="translate(1)"
														fill="#495057"
													/>
												</svg>
												<span className="ms-2">Custom</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
							<div className="table-responsive mb-0">
								<table className="table card-table table-nowrap overflow-hidden">
									<thead>
										<tr>
											<th>Order ID</th>
											<th>Selling</th>
											<th>Buying</th>
											<th>Rate</th>
											<th>Expire On</th>
											<th>Status</th>
											<th>&nbsp;</th>
										</tr>
									</thead>
									<tbody className="list">{data_HTML_ACTIVE_ORDERS}</tbody>
								</table>
							</div>

							<div className="d-flex align-items-center p-3 p-md-4 border-top border-gray-200">
								<a
									href="/currencyfx/marketplace"
									className="my-1 tiny font-weight-semibold mx-auto btn btn-link link-dark"
								>
									Visit Market Place<svg
										className="ms-1"
										data-name="icons/tabler/chevron right"
										xmlns="http://www.w3.org/2000/svg"
										width="10"
										height="10"
										viewBox="0 0 16 16"
									>
										<rect
											data-name="Icons/Tabler/Chevron Right background"
											width="16"
											height="16"
											fill="none"
										/>
										<path
											d="M.26.26A.889.889,0,0,1,1.418.174l.1.086L8.629,7.371a.889.889,0,0,1,.086,1.157l-.086.1L1.517,15.74A.889.889,0,0,1,.174,14.582l.086-.1L6.743,8,.26,1.517A.889.889,0,0,1,.174.36Z"
											transform="translate(4)"
											fill="#1e1e1e"
										/>
									</svg>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		);
	}
}

export default ActiveOrders;
