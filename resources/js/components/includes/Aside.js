import axios from 'axios';
import React, { Component } from 'react';

class Aside extends Component {
	constructor(props) {
		super(props);

		this.state = {
			sellCurrency: this.props.currencycode,
			sellAmount: '',
			buyCurrency: 'USD',
			buyAmount: '',
			desiredSellRate: '1.00',
			desiredSellCurrency: this.props.currencycode,
			desiredBuyCurrency: 'USD',
			desiredBuyRate: '',
			expiryDate: '',
			selloption: '',
			rateVal: ''
		};

		this.handleChange = this.handleChange.bind(this);

		this.handleSubmit = this.handleSubmit.bind(this);
	}

	async componentDidMount() {
		const selloption = [];

		// Get My Wallet Currency
		try {
			const res = await axios.get('/api/v1/fxwallets', {
				headers: { Authorization: `Bearer ${this.props.apiToken}` }
			});

			if (res.status === 200) {
				const result = res.data.data;

				result.map((item) => {
					selloption.push(
						<option key={item.id} value={item.currencyCode}>
							{item.currencyCode}
						</option>
					);
				});

				this.setState({
					selloption: selloption
				});
			} else {
				swal('Oops!', res.data.message, 'error');
			}
		} catch (error) {
			swal('Oops!', `${error.message}`, 'error');
		}
	}

	async handleChange(event) {
		this.setState({ [event.target.name]: event.target.value });

		const headers = {
			Authorization: `Bearer base64:JFM+PJaWD/pBypX+NhXudDrAmianZdGYZ41qz4WhXL0=`,
			'Content-Type': 'application/json'
		};

		document.getElementById('sellCurrencyRateResult').innerHTML = '';
		document.getElementById('buyCurrencyRateResult').innerHTML = '';
		document.getElementById('buyCurrencyCode').innerHTML = '';
		document.getElementById('sellCurrencyCode').innerHTML = '';

		if (event.target.name == 'sellCurrency') {
			this.state.sellCurrency = event.target.value;
		}
		if (event.target.name == 'buyCurrency') {
			this.state.buyCurrency = event.target.value;
		}

		this.setState({
			buyAmount: '',
			desiredBuyRate: '',
			desiredBuyCurrency: '',
			desiredSellCurrency: '',
			rateVal: ''
		});

		// Do Axios

		try {
			/**
			 * Calculate PaySprint Rate On Handle Change with Default Rate
			 * Then if desiredRate < or > PaySprint Rate
			 * Add charges note to the response and update state
			**/

			const resultA = await axios.get(
				`/api/v1/conversionrate/${this.state.sellCurrency}/${this.state.buyCurrency}`,
				{ headers: headers }
			);

			const resultB = await axios.get(
				`/api/v1/conversionrate/${this.state.buyCurrency}/${this.state.sellCurrency}`,
				{ headers: headers }
			);

			if (resultA.status === 200 && resultB.status === 200) {
				// var buying = this.state.sellAmount / resultB.data;

				var buying = this.state.sellAmount * resultA.data;

				document.getElementById('buyCurrencyCode').innerHTML = `1 ${this.state.sellCurrency} - `;
				document.getElementById('sellCurrencyCode').innerHTML = `1 ${this.state.buyCurrency} - `;

				document.getElementById('sellCurrencyRateResult').innerHTML =
					parseFloat(resultA.data).toFixed(4) + ` ${this.state.buyCurrency}`;

				document.getElementById('buyCurrencyRateResult').innerHTML =
					parseFloat(resultB.data).toFixed(4) + ` ${this.state.sellCurrency}`;

				document.getElementById('desiredBuyRate').value = parseFloat(resultA.data).toFixed(4);
				document.getElementById('desiredBuyCurrency').value = `${this.state.buyCurrency}`;
				document.getElementById('desiredSellCurrency').value = `${this.state.sellCurrency}`;
				document.getElementById('buyAmount').value = `${buying}`;
				this.setState({
					buyAmount: `${buying}`,
					desiredBuyRate: parseFloat(resultA.data).toFixed(4),
					desiredBuyCurrency: `${this.state.buyCurrency}`,
					desiredSellCurrency: `${this.state.sellCurrency}`,
					rateVal:
						document.getElementById('sellCurrencyCode').innerHTML +
						document.getElementById('buyCurrencyRateResult').innerHTML
				});
			} else {
				document.getElementById('buyCurrencyCode').innerHTML = `1 ${this.state.sellCurrency} - `;
				document.getElementById('sellCurrencyCode').innerHTML = `1 ${this.state.buyCurrency} - `;
				document.getElementById('sellCurrencyRateResult').innerHTML = '0.00';
				document.getElementById('buyCurrencyRateResult').innerHTML = '0.00';
			}
		} catch (error) {
			document.getElementById('buyCurrencyCode').innerHTML = `1 ${this.state.sellCurrency} - `;
			document.getElementById('sellCurrencyCode').innerHTML = `1 ${this.state.buyCurrency} - `;
			document.getElementById('sellCurrencyRateResult').innerHTML = `${error}`;
			document.getElementById('buyCurrencyRateResult').innerHTML = `${error}`;
		}

		// if (event.target.name === 'desiredBuyRate') return console.log(event.target.name, event.target.value);

		console.log(this.state);
	}

	async handleSubmit(event) {
		event.preventDefault();

		document.getElementById('submitOffer').disabled = true;

		const headers = {
			Authorization: `Bearer ${this.props.apiToken}`,
			'Content-Type': 'application/json'
		};

		try {
			// Response Data
			const res = await axios({ method: 'POST', url: '/api/v1/createoffer', data: this.state, headers: headers });

			document.getElementById('submitOffer').value = 'Please wait...';

			if (res.status === 200) {
				this.setState({
					sellCurrency: this.props.currencycode,
					sellAmount: '',
					buyCurrency: 'USD',
					buyAmount: '',
					desiredSellRate: '1.00',
					desiredSellCurrency: this.props.currencycode,
					desiredBuyCurrency: 'USD',
					desiredBuyRate: '',
					expiryDate: ''
				});

				swal('Great!', 'Offer created!', 'success');
				setTimeout(() => {
					location.reload();
				}, 2000);
			} else {
				this.setState({ [event.target.name]: event.target.value });

				document.getElementById('submitOffer').value = 'Submit Offer';
				document.getElementById('submitOffer').disabled = false;

				swal('Oops!', res.data.message, 'error');
			}
		} catch (error) {
			// Catch Error
			swal('Oops!', `${error.message}`, 'error');
		}
	}

	render() {
		return (
			<div>
				<div className="customize-sidebar">
					<div className="border-bottom border-gray-200 p-3 p-md-4">
						<div className="text-end">
							<a href="#" className="btn btn-light btn-icon rounded-pill customize-close">
								<svg
									data-name="icons/tabler/close"
									xmlns="http://www.w3.org/2000/svg"
									width="15"
									height="15"
									viewBox="0 0 16 16"
								>
									<rect
										data-name="Icons/Tabler/Close background"
										width="16"
										height="16"
										fill="none"
									/>
									<path
										d="M.82.1l.058.05L6,5.272,11.122.151A.514.514,0,0,1,11.9.82l-.05.058L6.728,6l5.122,5.122a.514.514,0,0,1-.67.777l-.058-.05L6,6.728.878,11.849A.514.514,0,0,1,.1,11.18l.05-.058L5.272,6,.151.878A.514.514,0,0,1,.75.057Z"
										transform="translate(2 2)"
										fill="#1E1E1E"
									/>
								</svg>
							</a>
						</div>

						<div className="px-2 px-md-4">
							<h3 className="mb-0">
								<img
									src="https://img.icons8.com/external-becris-lineal-becris/20/000000/external-add-mintab-for-ios-becris-lineal-becris-2.png"
									alt="Tio Tune"
								/>
								Create an Offer
							</h3>
							<p className="text-gray-700 mb-0 lh-lg">Default rates are according to PaySprint rates.</p>
						</div>
					</div>
					<div className="customize-body" data-simplebar>
						<form onSubmit={this.handleSubmit}>
							<div className="p-4 px-lg-12 border-bottom border-gray-200">
								<h6 className="font-weight-semibold mb-3">Currency Exchange</h6>

								<div className="d-flex muze-skins customizer-controls">
									<div className="mb-4 mb-xl-2" style={{ width: '20%' }}>
										<select
											value={this.state.sellCurrency}
											id="sellCurrency"
											name="sellCurrency"
											onChange={this.handleChange}
											className="form-control form-control-xl"
											onChange={this.handleChange}
										>
											{this.state.selloption}
										</select>
									</div>
									<div className="mb-4 mb-xl-10" style={{ width: '80%' }}>
										<input
											type="number"
											placeholder="Sell Currency"
											name="sellAmount"
											value={this.state.sellAmount}
											onChange={this.handleChange}
											min="0.00"
											step="any"
											id="sellAmount"
											className="form-control form-control-xl"
										/>
									</div>
								</div>

								<div className="d-flex muze-skins customizer-controls">
									<div className="mb-4 mb-xl-2" style={{ width: '25%' }}>
										<select
											value={this.state.buyCurrency}
											id="buyCurrency"
											name="buyCurrency"
											onChange={this.handleChange}
											className="form-control form-control-xl"
											onChange={this.handleChange}
										>
											{this.state.selloption}
										</select>
									</div>
									<div className="mb-4 mb-xl-10" style={{ width: '75%' }}>
										<input
											type="number"
											placeholder="Buy Currency"
											name="buyAmount"
											value={this.state.buyAmount}
											onChange={this.handleChange}
											min="0.00"
											step="any"
											id="buyAmount"
											className="form-control form-control-xl"
										/>
									</div>
								</div>
							</div>

                            <div className="p-4 px-lg-12 border-bottom border-gray-200">
                                <h6 className="font-weight-semibold mb-3">Offer Expiration</h6>

                                <div className="d-flex muze-skins customizer-controls">
                                    <div className="mb-4 mb-xl-10" style={{ width: '100%' }}>
                                        <input
                                            type="date"
                                            name="expiryDate"
                                            value={this.state.expiryDate}
                                            onChange={this.handleChange}
                                            id="expiryDate"
                                            className="form-control form-control-xl"
                                        />
                                    </div>
                                </div>
                            </div>

							<div className="p-4 px-lg-12 border-bottom border-gray-200">
								{/* <h6 className="font-weight-semibold mb-3">Your Desired Rate</h6> */}
								<h6 className="font-weight-semibold mb-3">PaySprint Rate</h6>

								<div className="d-flex muze-skins customizer-controls">
									<div className="mb-4 mb-xl-10" style={{ width: '75%' }}>
										<input
											type="number"
											id="desiredSellRate"
											name="desiredSellRate"
											value={this.state.desiredSellRate}
											className="form-control form-control-xl"
											onChange={this.handleChange}
											readOnly
										/>
									</div>
									<div className="mb-4 mb-xl-2" style={{ width: '25%' }}>
										<select
											id="desiredSellCurrency"
											name="desiredSellCurrency"
											value={this.state.desiredSellCurrency}
											onChange={this.handleChange}
											className="form-control form-control-xl"
											readOnly
										>
											{this.state.selloption}
										</select>
									</div>
								</div>

								<div className="d-flex muze-skins customizer-controls">
									<div className="mb-4 mb-xl-10" style={{ width: '75%' }}>
										<input
											type="number"
											placeholder="1.00"
											min="0.00"
											step="any"
											name="desiredBuyRate"
											value={this.state.desiredBuyRate}
											onChange={this.handleChange}
											id="desiredBuyRate"
											className="form-control form-control-xl"
											readOnly
										/>
									</div>
									<div className="mb-4 mb-xl-2" style={{ width: '25%' }}>
										<select
											value={this.state.desiredBuyCurrency}
											id="desiredBuyCurrency"
											name="desiredBuyCurrency"
											onChange={this.handleChange}
											className="form-control form-control-xl"
											onChange={this.handleChange}
											readOnly
										>
											{this.state.selloption}
										</select>

										<input type="hidden" value={this.state.rateVal} name="rateVal" />
									</div>
								</div>

								<p className="text-gray-600 pt-2 mb-0 font-weight-semibold">
									<span id="buyCurrencyCode" /> <span id="sellCurrencyRateResult" />
								</p>
								<p className="text-gray-600 pt-2 mb-0 font-weight-semibold">
									<span id="sellCurrencyCode" /> <span id="buyCurrencyRateResult" />
								</p>
							</div>



							<input
								type="submit"
								value="Submit Offer"
								className="form-control form-control-xl btn btn-xl btn-primary"
								id="submitOffer"
							/>
						</form>
					</div>
					{/* <div className="p-4 px-lg-5 border-top border-gray-200 bg-white">
						<div className="row">
							<div className="col-6 d-grid">
								<a href="#" className="btn btn-xl btn-outline-dark" id="ResetCustomizer">
									Reset
								</a>
							</div>
							<div className="col-6 d-grid">
								<a type='button' href="#" className="btn btn-xl btn-primary" id="CustomizerPreview" onClick={this.handleSubmitOffer}>
                                    Submit
								</a>
							</div>
						</div>
					</div> */}
				</div>

				<nav className="navbar navbar-vertical navbar-expand-lg navbar-light">
					<a className="navbar-brand mx-auto d-none d-lg-block my-0 my-lg-4" href="/currencyfx">
						<img
							src="https://res.cloudinary.com/paysprint/image/upload/v1650628016/assets/pay_sprint_black_horizotal_fwqo6q_ekpq1g.png"
							alt="Muze"
						/>
						<img
							src="https://res.cloudinary.com/paysprint/image/upload/v1650628016/assets/pay_sprint_black_horizotal_fwqo6q_ekpq1g.png"
							alt="Muze"
							className="white-logo2"
						/>
						<img
							src="https://res.cloudinary.com/pilstech/image/upload/v1617797524/paysprint_asset/paysprint_icon_png_rhxm1e.png"
							className="muze-icon"
							alt="Muze"
						/>
						<img
							src="https://res.cloudinary.com/pilstech/image/upload/v1617797524/paysprint_asset/paysprint_icon_png_rhxm1e.png"
							className="muze-icon-white"
							alt="Muze"
						/>
					</a>
					<div className="navbar-collapse">
						<ul className="navbar-nav mb-2" id="accordionExample" data-simplebar>
							<li className="nav-item">
								<a
									className="nav-link collapsed"
									href="/currencyfx"
									data-bs-toggle="collapse"
									role="button"
									aria-expanded="true"
									aria-controls="sidebarDashboards"
								>
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
										<g data-name="icons/tabler/chart" transform="translate(0)">
											<rect
												data-name="Icons/Tabler/Chart background"
												width="16"
												height="16"
												fill="none"
											/>
											<path
												d="M.686,13.257a.686.686,0,0,1-.093-1.365l.093-.006H15.314a.686.686,0,0,1,.093,1.365l-.093.006ZM.394,9.535l-.089-.05a.688.688,0,0,1-.24-.863l.05-.088L3.773,3.048a.684.684,0,0,1,.782-.272l.095.039L7.811,4.4,11.121.257a.687.687,0,0,1,.945-.122L12.142.2,15.8,3.858a.686.686,0,0,1-.893,1.036l-.077-.067L11.713,1.712,8.536,5.685a.684.684,0,0,1-.743.225l-.1-.04L4.578,4.313,1.256,9.294a.684.684,0,0,1-.862.24Z"
												transform="translate(0 1)"
												fill="#1e1e1e"
											/>
										</g>
									</svg>
									&nbsp;<span className="ms-2">Dashboards</span>
								</a>
							</li>
							<li className="nav-item">
								<a
									className="nav-link collapsed"
									href="/"
									data-bs-toggle="collapse"
									role="button"
									aria-expanded="true"
									aria-controls="sidebarHome"
								>
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
										<g data-name="icons/tabler/chart" transform="translate(0)">
											<rect
												data-name="Icons/Tabler/Chart background"
												width="16"
												height="16"
												fill="none"
											/>
											<path
												d="M.686,13.257a.686.686,0,0,1-.093-1.365l.093-.006H15.314a.686.686,0,0,1,.093,1.365l-.093.006ZM.394,9.535l-.089-.05a.688.688,0,0,1-.24-.863l.05-.088L3.773,3.048a.684.684,0,0,1,.782-.272l.095.039L7.811,4.4,11.121.257a.687.687,0,0,1,.945-.122L12.142.2,15.8,3.858a.686.686,0,0,1-.893,1.036l-.077-.067L11.713,1.712,8.536,5.685a.684.684,0,0,1-.743.225l-.1-.04L4.578,4.313,1.256,9.294a.684.684,0,0,1-.862.24Z"
												transform="translate(0 1)"
												fill="#1e1e1e"
											/>
										</g>
									</svg>
									&nbsp;<span className="ms-2">Home</span>
								</a>
							</li>
							<li className="nav-item">
								<a
									className="nav-link collapsed"
									href="#sidebarSendMoney"
									data-bs-toggle="collapse"
									role="button"
									aria-expanded="true"
									aria-controls="sidebarSendMoney"
								>
									<svg
										data-name="Icons/Tabler/Paperclip"
										xmlns="http://www.w3.org/2000/svg"
										width="16"
										height="16"
										viewBox="0 0 16 16"
									>
										<rect
											data-name="Icons/Tabler/Paperclip background"
											width="16"
											height="16"
											fill="none"
										/>
										<path
											d="M6.766,1.178A4.018,4.018,0,0,1,12.591,6.71l-.147.155-5.1,5.11A2.352,2.352,0,0,1,3.9,8.77l.114-.123,5.1-5.11a.685.685,0,0,1,1.035.893l-.066.077-5.1,5.11a.981.981,0,0,0,1.3,1.465l.086-.076,5.1-5.11A2.648,2.648,0,0,0,7.861,2.028l-.127.119-5.1,5.11a4.315,4.315,0,0,0,5.941,6.255l.156-.149,5.1-5.11a.685.685,0,0,1,1.035.893l-.066.077-5.1,5.11A5.685,5.685,0,0,1,1.5,6.457l.162-.169Z"
											transform="translate(1)"
											fill="#1e1e1e"
										/>
									</svg>
									&nbsp;<span className="ms-2">Send Money</span>
								</a>
								<div
									className="collapse collapse-box show"
									id="sidebarSendMoney"
									data-bs-parent="#accordionExample"
								>
									<ul className="nav nav-sm flex-column">
										<li className="nav-item">
											<a href={`/payorganization?type=${btoa('local')}`} className="nav-link">
												Local
											</a>
										</li>
										<li className="nav-item">
											<a
												href={`/payorganization?type=${btoa('international')}`}
												className="nav-link active"
											>
												International
											</a>
										</li>
									</ul>
								</div>
							</li>

							<li className="nav-item">
								<a
									className="nav-link collapsed"
									href="#sidebarPayInvoice"
									data-bs-toggle="collapse"
									role="button"
									aria-expanded="true"
									aria-controls="sidebarPayInvoice"
								>
									<svg
										data-name="Icons/Tabler/Bolt"
										xmlns="http://www.w3.org/2000/svg"
										width="16"
										height="16"
										viewBox="0 0 16 16"
									>
										<rect
											data-name="Icons/Tabler/Page background"
											width="16"
											height="16"
											fill="none"
										/>
										<path
											d="M1.975,14A1.977,1.977,0,0,1,0,12.026V1.975A1.977,1.977,0,0,1,1.975,0h5.04a.535.535,0,0,1,.249.069l.007,0h0a.534.534,0,0,1,.109.084l3.574,3.575a.536.536,0,0,1,.163.289h0l0,.013h0l0,.013v0l0,.011v.053s0,.009,0,.014v7.9A1.977,1.977,0,0,1,9.154,14Zm-.9-12.026V12.026a.9.9,0,0,0,.9.9H9.154a.9.9,0,0,0,.9-.9V4.667H7.718a1.255,1.255,0,0,1-1.248-1.12L6.461,3.41V1.077H1.975A.9.9,0,0,0,1.077,1.975ZM7.538,3.41a.179.179,0,0,0,.122.17l.057.01H9.29L7.538,1.838Z"
											transform="translate(2 1)"
											fill="#1e1e1e"
										/>
									</svg>
									&nbsp;<span className="ms-2">Pay Invoice</span>
								</a>
								<div
									className="collapse collapse-box show"
									id="sidebarPayInvoice"
									data-bs-parent="#accordionExample"
								>
									<ul className="nav nav-sm flex-column">
										<li className="nav-item">
											<a href="/currencyfx/invoice" className="nav-link">
												PaySprint Merchant
											</a>
										</li>
										<li className="nav-item">
											<a
												href="/currencyfx/crossborderplatform"
												className="nav-link active"
												style={{ fontSize: '12px', fontWeight: 'bold' }}
											>
												Non-PaySprint Merchant
											</a>
										</li>
									</ul>
								</div>
							</li>

							<li className="nav-item">
								<a
									className="nav-link collapsed"
									href="/currencyfx/marketplace"
									data-bs-toggle="collapse"
									role="button"
									aria-expanded="false"
									aria-controls="sidebarMarketPlace"
								>
									<svg
										data-name="Icons/Tabler/Bolt"
										xmlns="http://www.w3.org/2000/svg"
										width="16"
										height="16"
										viewBox="0 0 16 16"
									>
										<rect
											data-name="Icons/Tabler/Page background"
											width="16"
											height="16"
											fill="none"
										/>
										<path
											d="M1.975,14A1.977,1.977,0,0,1,0,12.026V1.975A1.977,1.977,0,0,1,1.975,0h5.04a.535.535,0,0,1,.249.069l.007,0h0a.534.534,0,0,1,.109.084l3.574,3.575a.536.536,0,0,1,.163.289h0l0,.013h0l0,.013v0l0,.011v.053s0,.009,0,.014v7.9A1.977,1.977,0,0,1,9.154,14Zm-.9-12.026V12.026a.9.9,0,0,0,.9.9H9.154a.9.9,0,0,0,.9-.9V4.667H7.718a1.255,1.255,0,0,1-1.248-1.12L6.461,3.41V1.077H1.975A.9.9,0,0,0,1.077,1.975ZM7.538,3.41a.179.179,0,0,0,.122.17l.057.01H9.29L7.538,1.838Z"
											transform="translate(2 1)"
											fill="#1e1e1e"
										/>
									</svg>
									&nbsp;<span className="ms-2">Buy & Sell Currency</span>
								</a>
							</li>
							<li className="nav-item">
								<a
									className="nav-link collapsed"
									href="/currencyfx/mywallet"
									data-bs-toggle="collapse"
									role="button"
									aria-expanded="false"
									aria-controls="sidebarEWallet"
								>
									<svg
										data-name="Icons/Tabler/Paperclip"
										xmlns="http://www.w3.org/2000/svg"
										width="16"
										height="16"
										viewBox="0 0 16 16"
									>
										<rect
											data-name="Icons/Tabler/Plug background"
											width="16"
											height="16"
											fill="none"
										/>
										<path
											d="M6.7,16a2.378,2.378,0,0,1-2.373-2.234l0-.145V12.541H3.244A3.241,3.241,0,0,1,0,9.47L0,9.3V4.109a.649.649,0,0,1,.561-.643L.649,3.46H1.73V.649A.649.649,0,0,1,3.021.561l.005.088V3.46H6.919V.649A.649.649,0,0,1,8.211.561l.005.088V3.46H9.3a.649.649,0,0,1,.643.561l.006.088V9.3a3.241,3.241,0,0,1-3.071,3.239l-.173,0H5.621v1.081A1.081,1.081,0,0,0,6.593,14.7l.11.005H9.3a.649.649,0,0,1,.088,1.292L9.3,16Zm0-4.757A1.951,1.951,0,0,0,8.644,9.431l0-.134V4.757H1.3V9.3A1.951,1.951,0,0,0,3.11,11.239l.133,0H6.7Z"
											transform="translate(3)"
											fill="#1e1e1e"
										/>
									</svg>
									&nbsp;<span className="ms-2">E-Wallet</span>
								</a>
							</li>
							<li className="nav-item">
								<a
									className="nav-link collapsed"
									href="/currencyfx/transactionhistory"
									data-bs-toggle="collapse"
									role="button"
									aria-expanded="false"
									aria-controls="sidebarBamkAccount"
								>
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
										<g data-name="Icons/Tabler/Paperclip" transform="translate(0 0)">
											<rect
												data-name="Icons/Tabler/apps background"
												width="16"
												height="16"
												fill="none"
											/>
											<path
												d="M10.743,16a1.6,1.6,0,0,1-1.6-1.6V10.743a1.6,1.6,0,0,1,1.6-1.6H14.4a1.6,1.6,0,0,1,1.6,1.6V14.4A1.6,1.6,0,0,1,14.4,16Zm-.229-5.257V14.4a.229.229,0,0,0,.229.229H14.4a.229.229,0,0,0,.229-.229V10.743a.229.229,0,0,0-.229-.229H10.743A.229.229,0,0,0,10.515,10.743ZM1.6,16A1.6,1.6,0,0,1,0,14.4V10.743a1.6,1.6,0,0,1,1.6-1.6H5.257a1.6,1.6,0,0,1,1.6,1.6V14.4a1.6,1.6,0,0,1-1.6,1.6Zm-.229-5.257V14.4a.229.229,0,0,0,.229.229H5.257a.229.229,0,0,0,.229-.229V10.743a.229.229,0,0,0-.229-.229H1.6A.229.229,0,0,0,1.372,10.743Zm9.372-3.886a1.6,1.6,0,0,1-1.6-1.6V1.6a1.6,1.6,0,0,1,1.6-1.6H14.4A1.6,1.6,0,0,1,16,1.6V5.257a1.6,1.6,0,0,1-1.6,1.6ZM10.515,1.6V5.257a.229.229,0,0,0,.229.229H14.4a.229.229,0,0,0,.229-.229V1.6a.229.229,0,0,0-.229-.229H10.743A.229.229,0,0,0,10.515,1.6ZM1.6,6.857A1.6,1.6,0,0,1,0,5.257V1.6A1.6,1.6,0,0,1,1.6,0H5.257a1.6,1.6,0,0,1,1.6,1.6V5.257a1.6,1.6,0,0,1-1.6,1.6ZM1.372,1.6V5.257a.229.229,0,0,0,.229.229H5.257a.229.229,0,0,0,.229-.229V1.6a.229.229,0,0,0-.229-.229H1.6A.229.229,0,0,0,1.372,1.6Z"
												transform="translate(0 0)"
												fill="#1e1e1e"
											/>
										</g>
									</svg>
									&nbsp;<span className="ms-2 position-relative">
										Transaction History
										<sup className="status bg-warning ms-2 position-absolute">&nbsp;</sup>
									</span>
								</a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		);
	}
}

export default Aside;
