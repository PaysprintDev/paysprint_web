import axios from 'axios';
import React, { Component } from 'react';
import Aside from '../includes/Aside';
import Header from '../includes/Header';

const apiToken = document.getElementById('user_api_token').value;
const myCurrencyCode = document.getElementById('user_currency_code').value;

class Start extends Component {
	componentDidMount() {
		this._isMounted = true;

		try {
			axios.get(`/api/v1/userdata`, { headers: { Authorization: `Bearer ${apiToken}` } }).then((res) => {
				if (this._isMounted) {
					if (res.status === 200) {
						this.setState({
							data: res.data.data,
							message: res.data.message,
							loading: false,
							currency: res.data.data.currencySymbol
						});
					} else {
						this.setState({
							data: res.data.data,
							message: res.data.message,
							loading: false,
							currency: ''
						});
					}
				}
			});
		} catch (error) {
			console.log(error);
		}
	}

	render() {
		return (
			<div>
				<Aside apiToken={apiToken} currencycode={myCurrencyCode} />

				<Header apiToken={apiToken} />

				<div className="main-content">
					<div className="p-3 p-xxl-5 after-header">
						<div className="container-fluid px-0">
							<div className="row">
								<div className="col-12 text-center pt-4 pt-md-2 py-md-5">
									<h1>Hello Gorgeous 👋</h1>
									<p className="text-black-600">
										Start by creating a foreign exchange account TODAY!
									</p>
									<div className="p-2 p-md-5">
										<img src="/cfx/assets/img/placeholder17.png" alt="Placeholder" />
									</div>
									<div className="py-3 p-md-3">
										<a href="/currencyfx" className="btn btn-xl btn-primary">
											Get Started
											<svg
												className="ms-1"
												data-name="Icons/Tabler/Chevron Down"
												xmlns="http://www.w3.org/2000/svg"
												width="18"
												height="18"
												viewBox="0 0 10 10"
											>
												<rect
													data-name="Icons/Tabler/Chevron Right background"
													width="10"
													height="10"
													fill="none"
												/>
												<path
													d="M.163.163A.556.556,0,0,1,.886.109L.948.163,5.393,4.607a.556.556,0,0,1,.054.723l-.054.062L.948,9.837a.556.556,0,0,1-.839-.723l.054-.062L4.214,5,.163.948A.556.556,0,0,1,.109.225Z"
													transform="translate(2.5)"
													fill="#ffffff"
												/>
											</svg>
										</a>
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

export default Start;
