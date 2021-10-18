import React, { Component } from 'react';
import HeaderFunction from '../constraints/HeaderFunction';

class Notify extends Component {
	_isMounted = false;

	constructor(props) {
		super(props);

		this.state = {
			data: [],
			message: '',
			loading: true
		};
	}

	// async componentWillMount(){

	//     this._isMounted = true;

	//             // User Notifications
	//     const notyRes = await axios.get('/api/v1/notification', {headers: {Authorization: `Bearer ${this.props.apiToken}`}});

	//     try {

	//         if (this._isMounted) {
	//             if(notyRes.status === 200){
	//         this.setState({
	//                 data: notyRes.data.data,
	//                 message: notyRes.data.message,
	//                 loading: false,
	//             });
	//     }
	//     else{
	//         this.setState({
	//                 data: notyRes.data.data,
	//                 message: notyRes.data.message,
	//                 loading: false,
	//             });
	//     }
	//         }

	//     } catch (error) {
	//         console.error(error);
	//     }

	// }

	componentDidMount() {
		this._isMounted = true;

		try {
			axios
				.get(`/api/v1/notification`, { headers: { Authorization: `Bearer ${this.props.apiToken}` } })
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
		return (
			<div>
				<div className="dropdown grid-option">
					<a
						href="#"
						className="text-dark ms-4 ms-xxl-5 mb-0 notification"
						data-bs-toggle="dropdown"
						aria-expanded="false"
						id="notification"
					>
						<svg
							id="Icons_tabler_notification"
							data-name="Icons/tabler/notification"
							xmlns="http://www.w3.org/2000/svg"
							width="24"
							height="24"
							viewBox="0 0 24 24"
						>
							<rect
								id="Icons_Tabler_Notification_background"
								data-name="Icons/Tabler/Notification background"
								width="24"
								height="24"
								fill="none"
							/>
							<path
								d="M6.162,19.63l-.005-.246v-.308H.926A.923.923,0,0,1,.471,17.35a4,4,0,0,0,1.956-2.66l.036-.229V10.726A9.492,9.492,0,0,1,7.292,2.873l.147-.08,0-.018A3.369,3.369,0,0,1,10.566.007L10.771,0a3.379,3.379,0,0,1,3.287,2.573l.045.22.147.08a9.556,9.556,0,0,1,4.806,7.541l.023.355-.007,3.582a4.016,4.016,0,0,0,2,3,.924.924,0,0,1-.329,1.719l-.126.008H15.387v.308a4.616,4.616,0,0,1-9.225.246ZM8,19.385a2.769,2.769,0,0,0,5.532.189l.007-.189v-.308H8ZM9.242,3.228l-.012.238-.005.045L9.2,3.63l-.039.113-.054.107-.035.055L9,4l-.036.038-.05.046-.1.074L8.7,4.219A7.7,7.7,0,0,0,4.332,10.46l-.022.309-.007,3.8a5.875,5.875,0,0,1-.94,2.541l-.084.119H18.266l-.007-.012a6.007,6.007,0,0,1-.983-2.452l-.043-.306V10.812a7.674,7.674,0,0,0-4.4-6.593.919.919,0,0,1-.518-.7l-.009-.132a1.538,1.538,0,0,0-3.069-.157Z"
								transform="translate(1.499)"
								fill="#1e1e1e"
							/>
						</svg>
						<sup className="status bg-warning">&nbsp;</sup>
					</a>
					<div className="dropdown-menu dropdown-menu-end py-0" aria-labelledby="chat">
						<div className="dropdown-header d-flex align-items-center px-4 py-2">
							<span className="fs-16 Montserrat-font font-weight-semibold text-black-600">
								Notification
							</span>
							<div className="dropdown ms-auto">
								<a
									href="#"
									role="button"
									data-bs-toggle="dropdown"
									aria-expanded="false"
									id="morebtn3"
									className="btn btn-dark-100 btn-icon btn-sm rounded-circle my-1"
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
							</div>
						</div>

						<div className="dropdown-body" data-simplebar>
							<HeaderFunction loading={this.state.loading} data={this.state.data} />
						</div>

						<div className="dropdown-footer text-center py-2 border-top border-gray-50">
							<a href={`${this.props.link}`} className="btn btn-link link-dark my-2">
								View all<svg
									className="ms-2"
									data-name="Icons/Tabler/Chevron Down"
									xmlns="http://www.w3.org/2000/svg"
									width="10"
									height="10"
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
										fill="#1E1E1E"
									/>
								</svg>
							</a>
						</div>
					</div>
				</div>
			</div>
		);
	}
}

export default Notify;
