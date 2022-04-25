import axios from 'axios';
import React, { Component } from 'react';
import Notify from './Notify';

class Header extends Component {
	_isMounted = false;

	constructor(props) {
		super(props);

		this.state = {
			data: [],
			message: '',
			loading: true
		};
	}

	//    async componentDidMount(){

	//     this._isMounted = true;

	//         try {

	//             if (this._isMounted) {
	//                 // User Details
	//         const res = await axios.get(`/api/v1/userdata`, {headers: {Authorization: `Bearer ${this.props.apiToken}`}});

	//         if(res.status === 200){
	//             this.setState({
	//                 data: res.data.data,
	//                 message: res.data.message,
	//                 loading: false,
	//             });
	//         }
	//         else{
	//             this.setState({
	//                 data: res.data.data,
	//                 message: res.data.message,
	//                 loading: false,
	//             });
	//         }
	//             }

	//         } catch (error) {
	//             console.log(error);
	//         }

	//     }

	componentDidMount() {
		this._isMounted = true;

		try {
			axios
				.get(`/api/v1/userdata`, { headers: { Authorization: `Bearer ${this.props.apiToken}` } })
				.then((res) => {
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
		var data_HTML_HEADER_CONTENT = '';
		var imageAvatar = '';

		if (this.state.loading) {
			data_HTML_HEADER_CONTENT = (
				<div className="dropdown profile-dropdown">
					<img src="https://img.icons8.com/ios/35/000000/spinner-frame-4.png" className="fa fa-spin" />
				</div>
			);
		} else {
			if (this.state.data.avatar != null) {
				imageAvatar = this.state.data.avatar;
			} else {
				imageAvatar =
					'https://res.cloudinary.com/pilstech/image/upload/v1617797524/paysprint_asset/paysprint_jpeg_black_bk_2_w4hzub.jpg';
			}

			if (this.state.data.accountType == 'Individual') {
				data_HTML_HEADER_CONTENT = (
					<div className="dropdown profile-dropdown">
						<a
							href="#"
							className="avatar avatar-sm avatar-circle ms-4 ms-xxl-5"
							data-bs-toggle="dropdown"
							aria-expanded="false"
							id="dropdownMenuButton"
						>
							<img className="avatar-img" src={`${imageAvatar}`} alt={`${this.state.data.name}`} />
							<span className="avatar-status avatar-sm-status avatar-success">&nbsp;</span>
						</a>
						<ul className="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
							<li className="pt-2 px-4">
								<span className="fs-16 font-weight-bold text-black-600 Montserrat-font me-2">
									{this.state.data.name}
								</span>
								<img
									src="https://fabrx.co/preview/muse-dashboard/assets/svg/icons/fill-check.svg"
									alt="icon"
								/>
							</li>

							<li>
								<a className="dropdown-item" href="/profile">
									<svg
										data-name="Icons/Tabler/Share"
										xmlns="http://www.w3.org/2000/svg"
										width="16"
										height="16"
										viewBox="0 0 16 16"
									>
										<rect
											id="Icons_Tabler_User_background"
											data-name="Icons/Tabler/User background"
											width="16"
											height="16"
											fill="none"
										/>
										<path
											d="M11.334,16H.667a.665.665,0,0,1-.661-.568L0,15.343v-1.75A4.179,4.179,0,0,1,4.029,9.44l.193,0H7.778A4.186,4.186,0,0,1,12,13.4l0,.191v1.75a.661.661,0,0,1-.576.651ZM4.222,10.749a2.869,2.869,0,0,0-2.884,2.683l-.005.162v1.094h9.334V13.594A2.857,2.857,0,0,0,8.1,10.767l-.162-.013-.164,0ZM6,8.314A4.2,4.2,0,0,1,1.778,4.157a4.223,4.223,0,0,1,8.445,0A4.2,4.2,0,0,1,6,8.314Zm0-7A2.87,2.87,0,0,0,3.111,4.157a2.889,2.889,0,0,0,5.778,0A2.87,2.87,0,0,0,6,1.313Z"
											transform="translate(2)"
											fill="#495057"
										/>
									</svg>
									<span className="ms-2">Profile</span>
								</a>
							</li>

							<li>
								<a className="dropdown-item" href="/profile">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
										<path
											data-name="Combined Shape"
											d="M6.027,14.449a.8.8,0,0,0-1.193-.494,2.025,2.025,0,0,1-1.063.31,2.086,2.086,0,0,1-1.779-1.069,1.961,1.961,0,0,1,.051-2.03.8.8,0,0,0-.493-1.193,2.03,2.03,0,0,1,0-3.945.8.8,0,0,0,.494-1.193,1.962,1.962,0,0,1-.052-2.03,2.086,2.086,0,0,1,1.78-1.071,2.022,2.022,0,0,1,1.062.31.8.8,0,0,0,1.193-.493,2.03,2.03,0,0,1,3.945,0,.808.808,0,0,0,.472.551.788.788,0,0,0,.305.06.8.8,0,0,0,.417-.117,2.024,2.024,0,0,1,1.062-.31,2.087,2.087,0,0,1,1.78,1.07,1.963,1.963,0,0,1-.052,2.03.8.8,0,0,0,.494,1.192,2.03,2.03,0,0,1,0,3.946.8.8,0,0,0-.494,1.193,1.962,1.962,0,0,1,.052,2.03,2.086,2.086,0,0,1-1.779,1.07,2.025,2.025,0,0,1-1.063-.31.8.8,0,0,0-.722-.056.8.8,0,0,0-.471.55,2.03,2.03,0,0,1-3.945,0Zm0-1.687a2.03,2.03,0,0,1,1.2,1.4.8.8,0,0,0,1.553,0A2.029,2.029,0,0,1,11.8,12.9l.077.042a.78.78,0,0,0,.341.08.822.822,0,0,0,.7-.421.773.773,0,0,0-.02-.8l-.078-.141a2.03,2.03,0,0,1,1.333-2.889.8.8,0,0,0,0-1.552A2.031,2.031,0,0,1,12.9,4.195l.042-.076a.768.768,0,0,0-.042-.757.813.813,0,0,0-.68-.387.793.793,0,0,0-.418.122l-.141.078a2.038,2.038,0,0,1-.916.219,2.02,2.02,0,0,1-.777-.155,2.039,2.039,0,0,1-1.2-1.4l-.029-.1a.8.8,0,0,0-1.524.1A2.027,2.027,0,0,1,4.195,3.1l-.076-.041a.78.78,0,0,0-.341-.08.822.822,0,0,0-.7.422.772.772,0,0,0,.021.8l.078.141A2.029,2.029,0,0,1,1.841,7.223a.8.8,0,0,0,0,1.553A2.029,2.029,0,0,1,3.1,11.8l-.041.077a.768.768,0,0,0,.042.757.815.815,0,0,0,.68.387.791.791,0,0,0,.418-.122l.141-.078a2.027,2.027,0,0,1,1.693-.064ZM4.923,8A3.077,3.077,0,1,1,8,11.077,3.081,3.081,0,0,1,4.923,8ZM6.154,8A1.846,1.846,0,1,0,8,6.154,1.848,1.848,0,0,0,6.154,8Z"
											fill="#495057"
										/>
									</svg>
									<span className="ms-2">Settings</span>
								</a>
							</li>
							<li>
								<hr className="dropdown-divider" />
							</li>
							<li>
								<a className="dropdown-item" href="/logout">
									<img src="https://img.icons8.com/ios/20/000000/export.png" />
									<span className="ms-2">Logout</span>
								</a>
							</li>
						</ul>
					</div>
				);
			} else {
				data_HTML_HEADER_CONTENT = (
					<div className="dropdown profile-dropdown">
						<a
							href="#"
							className="avatar avatar-sm avatar-circle ms-4 ms-xxl-5"
							data-bs-toggle="dropdown"
							aria-expanded="false"
							id="dropdownMenuButton"
						>
							<img
								className="avatar-img"
								src={`${imageAvatar}`}
								alt={`${this.state.data.businessname}`}
							/>
							<span className="avatar-status avatar-sm-status avatar-success">&nbsp;</span>
						</a>
						<ul className="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
							<li className="pt-2 px-4">
								<span className="fs-16 font-weight-bold text-black-600 Montserrat-font me-2">
									{this.state.data.businessname}
								</span>
								<img
									src="https://fabrx.co/preview/muse-dashboard/assets/svg/icons/fill-check.svg"
									alt="icon"
								/>
							</li>

							<li>
								<a className="dropdown-item" href="/Admin/merchant/profile">
									<svg
										data-name="Icons/Tabler/Share"
										xmlns="http://www.w3.org/2000/svg"
										width="16"
										height="16"
										viewBox="0 0 16 16"
									>
										<rect
											id="Icons_Tabler_User_background"
											data-name="Icons/Tabler/User background"
											width="16"
											height="16"
											fill="none"
										/>
										<path
											d="M11.334,16H.667a.665.665,0,0,1-.661-.568L0,15.343v-1.75A4.179,4.179,0,0,1,4.029,9.44l.193,0H7.778A4.186,4.186,0,0,1,12,13.4l0,.191v1.75a.661.661,0,0,1-.576.651ZM4.222,10.749a2.869,2.869,0,0,0-2.884,2.683l-.005.162v1.094h9.334V13.594A2.857,2.857,0,0,0,8.1,10.767l-.162-.013-.164,0ZM6,8.314A4.2,4.2,0,0,1,1.778,4.157a4.223,4.223,0,0,1,8.445,0A4.2,4.2,0,0,1,6,8.314Zm0-7A2.87,2.87,0,0,0,3.111,4.157a2.889,2.889,0,0,0,5.778,0A2.87,2.87,0,0,0,6,1.313Z"
											transform="translate(2)"
											fill="#495057"
										/>
									</svg>
									<span className="ms-2">Profile</span>
								</a>
							</li>

							<li>
								<hr className="dropdown-divider" />
							</li>
							<li>
								<a className="dropdown-item" href="/Admin/merchant/profile">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
										<path
											data-name="Combined Shape"
											d="M6.027,14.449a.8.8,0,0,0-1.193-.494,2.025,2.025,0,0,1-1.063.31,2.086,2.086,0,0,1-1.779-1.069,1.961,1.961,0,0,1,.051-2.03.8.8,0,0,0-.493-1.193,2.03,2.03,0,0,1,0-3.945.8.8,0,0,0,.494-1.193,1.962,1.962,0,0,1-.052-2.03,2.086,2.086,0,0,1,1.78-1.071,2.022,2.022,0,0,1,1.062.31.8.8,0,0,0,1.193-.493,2.03,2.03,0,0,1,3.945,0,.808.808,0,0,0,.472.551.788.788,0,0,0,.305.06.8.8,0,0,0,.417-.117,2.024,2.024,0,0,1,1.062-.31,2.087,2.087,0,0,1,1.78,1.07,1.963,1.963,0,0,1-.052,2.03.8.8,0,0,0,.494,1.192,2.03,2.03,0,0,1,0,3.946.8.8,0,0,0-.494,1.193,1.962,1.962,0,0,1,.052,2.03,2.086,2.086,0,0,1-1.779,1.07,2.025,2.025,0,0,1-1.063-.31.8.8,0,0,0-.722-.056.8.8,0,0,0-.471.55,2.03,2.03,0,0,1-3.945,0Zm0-1.687a2.03,2.03,0,0,1,1.2,1.4.8.8,0,0,0,1.553,0A2.029,2.029,0,0,1,11.8,12.9l.077.042a.78.78,0,0,0,.341.08.822.822,0,0,0,.7-.421.773.773,0,0,0-.02-.8l-.078-.141a2.03,2.03,0,0,1,1.333-2.889.8.8,0,0,0,0-1.552A2.031,2.031,0,0,1,12.9,4.195l.042-.076a.768.768,0,0,0-.042-.757.813.813,0,0,0-.68-.387.793.793,0,0,0-.418.122l-.141.078a2.038,2.038,0,0,1-.916.219,2.02,2.02,0,0,1-.777-.155,2.039,2.039,0,0,1-1.2-1.4l-.029-.1a.8.8,0,0,0-1.524.1A2.027,2.027,0,0,1,4.195,3.1l-.076-.041a.78.78,0,0,0-.341-.08.822.822,0,0,0-.7.422.772.772,0,0,0,.021.8l.078.141A2.029,2.029,0,0,1,1.841,7.223a.8.8,0,0,0,0,1.553A2.029,2.029,0,0,1,3.1,11.8l-.041.077a.768.768,0,0,0,.042.757.815.815,0,0,0,.68.387.791.791,0,0,0,.418-.122l.141-.078a2.027,2.027,0,0,1,1.693-.064ZM4.923,8A3.077,3.077,0,1,1,8,11.077,3.081,3.081,0,0,1,4.923,8ZM6.154,8A1.846,1.846,0,1,0,8,6.154,1.848,1.848,0,0,0,6.154,8Z"
											fill="#495057"
										/>
									</svg>
									<span className="ms-2">Settings</span>
								</a>
							</li>
							<li>
								<a className="dropdown-item" href="/logout">
									<img src="https://img.icons8.com/ios/20/000000/export.png" />
									<span className="ms-2">Logout</span>
								</a>
							</li>
						</ul>
					</div>
				);
			}
		}

		return (
			<div>
				<div className="header border-bottom border-gray-200 header-fixed">
					<div className="container-fluid px-0">
						<div className="header-body px-3 px-xxl-5 py-3 py-lg-4">
							<div className="row align-items-center">
								<a href="#" className="muze-hamburger d-block d-lg-none col-auto">
									<img
										src="https://res.cloudinary.com/pilstech/image/upload/v1633640629/paysprint_asset/hamburger1_qkzb73.svg"
										alt="img"
									/>
									<img
										src="https://res.cloudinary.com/pilstech/image/upload/v1633640676/paysprint_asset/close1_kk4ugu.svg"
										style={{ width: '20px' }}
										className="menu-close"
										alt="img"
									/>
								</a>
								<a className="navbar-brand mx-auto d-lg-none col-auto px-0" href="#">
									<img
										src="https://res.cloudinary.com/paysprint/image/upload/v1650628016/assets/pay_sprint_black_horizotal_fwqo6q_ekpq1g.png"
										alt="PaySprint"
										style={{ width: '120px' }}
									/>
									<img
										src="https://res.cloudinary.com/paysprint/image/upload/v1650628016/assets/pay_sprint_black_horizotal_fwqo6q_ekpq1g.png"
										alt="Muze"
										className="white-logo"
									/>
								</a>
								<div className="col d-flex align-items-center">
									<a
										href="#"
										className="back-arrow bg-white circle circle-sm shadow border border-gray-200 rounded mb-0"
									>
										<svg
											xmlns="http://www.w3.org/2000/svg"
											width="13"
											height="13"
											viewBox="0 0 16 16"
										>
											<g data-name="icons/tabler/chevrons-left" transform="translate(0)">
												<rect
													data-name="Icons/Tabler/Chevrons Left background"
													width="16"
													height="16"
													fill="none"
												/>
												<path
													d="M14.468,14.531l-.107-.093-6.4-6.4a.961.961,0,0,1-.094-1.25l.094-.107,6.4-6.4a.96.96,0,0,1,1.451,1.25l-.094.108L10,7.36l5.72,5.721a.961.961,0,0,1,.094,1.25l-.094.107a.96.96,0,0,1-1.25.093Zm-7.68,0-.107-.093-6.4-6.4a.961.961,0,0,1-.093-1.25l.093-.107,6.4-6.4a.96.96,0,0,1,1.45,1.25l-.093.108L2.318,7.36l5.72,5.721a.96.96,0,0,1,.093,1.25l-.093.107a.96.96,0,0,1-1.25.093Z"
													transform="translate(0 1)"
													fill="#6C757D"
												/>
											</g>
										</svg>
									</a>

									<div className="ps-3 header-search">
										<span className="muze-search d-lg-none ms-3">
											<svg
												id="icons_tabler_close"
												data-name="icons/tabler/close"
												xmlns="http://www.w3.org/2000/svg"
												width="20"
												height="20"
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
													fill="#1e1e1e"
												/>
											</svg>
										</span>
									</div>

									<nav className="navbar navbar-expand-lg navbar-light top-header-nav">
										<div className="navbar-collapse">
											<ul className="navbar-nav" id="accordionExample2">
												<li className="nav-item">
													<a
														className="nav-link collapsed"
														href="#sidebarDashboards2"
														data-bs-toggle="collapse"
														role="button"
														aria-expanded="false"
														aria-controls="sidebarDashboards2"
													>
														<svg
															xmlns="http://www.w3.org/2000/svg"
															width="16"
															height="16"
															viewBox="0 0 16 16"
														>
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
														</svg>{' '}
														&nbsp;<span className="ms-2">Dashboards</span>
													</a>
												</li>
												<li className="nav-item">
													<a
														className="nav-link collapsed"
														href="#sidebarSendMoney1"
														data-bs-toggle="collapse"
														role="button"
														aria-expanded="false"
														aria-controls="sidebarSendMoney1"
													>
														<svg
															xmlns="http://www.w3.org/2000/svg"
															width="16"
															height="16"
															viewBox="0 0 16 16"
														>
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
														</svg>{' '}
														&nbsp;<span className="ms-2">Send Money</span>
													</a>
													<div
														className="collapse collapse-box"
														id="sidebarSendMoney1"
														data-bs-parent="#accordionExample2"
													>
														<ul className="nav nav-sm flex-column">
															<li className="nav-item">
																<a
																	href={`/payorganization?type=${btoa('local')}`}
																	className="nav-link"
																>
																	Local
																</a>
															</li>
															<li className="nav-item">
																<a
																	href={`/payorganization?type=${btoa(
																		'international'
																	)}`}
																	className="nav-link"
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
														href="#sidebarPayInvoice1"
														data-bs-toggle="collapse"
														role="button"
														aria-expanded="false"
														aria-controls="sidebarPayInvoice1"
													>
														<svg
															xmlns="http://www.w3.org/2000/svg"
															width="16"
															height="16"
															viewBox="0 0 16 16"
														>
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
														</svg>{' '}
														&nbsp;<span className="ms-2">Pay Invoice</span>
													</a>
													<div
														className="collapse collapse-box"
														id="sidebarPayInvoice1"
														data-bs-parent="#accordionExample2"
													>
														<ul className="nav nav-sm flex-column">
															<li className="nav-item">
																<a href="/currencyfx/invoice" className="nav-link">
																	PaySprint Invoice
																</a>
															</li>
															<li className="nav-item">
																<a
																	href="/currencyfx/crossborderplatform"
																	className="nav-link"
																>
																	Cross Border Payment
																</a>
															</li>
														</ul>
													</div>
												</li>

												<li className="nav-item">
													<a
														className="nav-link collapsed"
														href="#sidebarMarketPlace3"
														data-bs-toggle="collapse"
														role="button"
														aria-expanded="false"
														aria-controls="sidebarMarketPlace3"
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
														</svg>{' '}
														&nbsp;<span className="ms-2">Market Place</span>
													</a>
												</li>

												<li className="nav-item">
													<a
														className="nav-link collapsed"
														href="/currencyfx/mywallet"
														data-bs-toggle="collapse"
														role="button"
														aria-expanded="false"
														aria-controls="sidebarEWallet2"
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
														</svg>{' '}
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
														aria-controls="sidebarBankAccount2"
													>
														<svg
															xmlns="http://www.w3.org/2000/svg"
															width="16"
															height="16"
															viewBox="0 0 16 16"
														>
															<g
																data-name="Icons/Tabler/Paperclip"
																transform="translate(0 0)"
															>
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
														</svg>{' '}
														&nbsp;<span className="ms-2 position-relative">
															Transaction History{' '}
															<sup className="status bg-warning position-absolute">
																&nbsp;
															</sup>
														</span>
													</a>
												</li>
											</ul>
										</div>
									</nav>
								</div>

								<div className="col-auto d-flex flex-wrap align-items-center icon-blue-hover ps-0">
									<Notify link="/mywallet/notifications" apiToken={this.props.apiToken} />

									{data_HTML_HEADER_CONTENT}
								</div>
							</div>
						</div>
						<div className="double-header-nav">
							<nav className="navbar navbar-expand-lg navbar-light">
								<div className="navbar-collapse">
									<ul className="navbar-nav" id="accordionExample3">
										<li className="nav-item">
											<a
												className="nav-link collapsed"
												href="#sidebarDashboards3"
												data-bs-toggle="collapse"
												role="button"
												aria-expanded="false"
												aria-controls="sidebarDashboards3"
											>
												<svg
													xmlns="http://www.w3.org/2000/svg"
													width="16"
													height="16"
													viewBox="0 0 16 16"
												>
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
												</svg>{' '}
												&nbsp;<span className="ms-2">Dashboards</span>
											</a>
										</li>
										<li className="nav-item">
											<a
												className="nav-link collapsed"
												href="#sidebarSendMoney2"
												data-bs-toggle="collapse"
												role="button"
												aria-expanded="false"
												aria-controls="sidebarSendMoney2"
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
												</svg>{' '}
												&nbsp;<span className="ms-2">Send Money</span>
											</a>
											<div
												className="collapse collapse-box"
												id="sidebarSendMoney2"
												data-bs-parent="#accordionExample3"
											>
												<ul className="nav nav-sm flex-column" id="submenu6">
													<li className="nav-item">
														<a
															href={`/payorganization?type=${btoa('local')}`}
															className="nav-link"
														>
															Local
														</a>
													</li>
													<li className="nav-item">
														<a
															href={`/payorganization?type=${btoa('international')}`}
															className="nav-link"
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
												href="#sidebarPayInvoice2"
												data-bs-toggle="collapse"
												role="button"
												aria-expanded="false"
												aria-controls="sidebarPayInvoice2"
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
												</svg>{' '}
												&nbsp;<span className="ms-2">Pay Invoice</span>
											</a>
											<div
												className="collapse collapse-box"
												id="sidebarPayInvoice2"
												data-bs-parent="#accordionExample3"
											>
												<ul className="nav nav-sm flex-column" id="submenu6">
													<li className="nav-item">
														<a href="/currencyfx/invoice" className="nav-link">
															PaySprint Invoice
														</a>
													</li>
													<li className="nav-item">
														<a href="/currencyfx/crossborderplatform" className="nav-link">
															Cross Border Payment
														</a>
													</li>
												</ul>
											</div>
										</li>

										<li className="nav-item">
											<a
												className="nav-link collapsed"
												href="#sidebarPages4"
												data-bs-toggle="collapse"
												role="button"
												aria-expanded="false"
												aria-controls="sidebarPages4"
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
												</svg>{' '}
												&nbsp;<span className="ms-2">Market Place</span>
											</a>
										</li>

										<li className="nav-item">
											<a
												className="nav-link collapsed"
												href="/currencyfx/mywallet"
												data-bs-toggle="collapse"
												role="button"
												aria-expanded="false"
												aria-controls="sidebarAuthentication3"
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
												</svg>{' '}
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
												aria-controls="sidebarApps3"
											>
												<svg
													xmlns="http://www.w3.org/2000/svg"
													width="16"
													height="16"
													viewBox="0 0 16 16"
												>
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
												</svg>{' '}
												&nbsp;<span className="ms-2 position-relative">
													Transaction History{' '}
													<sup className="status bg-warning position-absolute">&nbsp;</sup>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</nav>
						</div>
					</div>
				</div>
			</div>
		);
	}
}

export default Header;
