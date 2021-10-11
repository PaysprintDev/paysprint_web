import React, {Component} from "react";

class HeaderFunction extends Component{

    render(){

        if (this.props.loading) {
            return (
                <img src="https://img.icons8.com/ios/35/000000/spinner-frame-4.png" className="fa fa-spin" />
            );
        }
        else {

            return(
                this.props.data.map((item) => {
                    return (
                        <a href="#" className="dropdown-item text-wrap" key={item.id}>
                            <div className="media">
                                <span className="d-flex align-items-center">
                                    <span
                                        className="avatar-status avatar-sm-status avatar-offline position-relative me-2 end-0 bottom-0">&nbsp;</span>
                                    <span className="avatar avatar-xs shadow-sm rounded-circle me-2 d-flex align-items-center justify-content-center bg-white"><img
                                        src="https://res.cloudinary.com/pilstech/image/upload/v1617797524/paysprint_asset/paysprint_jpeg_black_bk_2_w4hzub.jpg"
                                        alt="Facebook" /></span>
                                </span>
                                <div className="media-body ps-1">
                                    <div className="d-flex align-items-center">
                                        <span className="fs-16 font-weight-semibold dropdown-title">PaySprint {item.platform}</span>
                                        <span className="font-weight-semibold tiny text-gray-600 ms-auto">{item.period}</span>
                                    </div>
                                    <span className="d-block small text-gray-600 mt-1 dropdown-content">{item.activity}</span>
                                </div>
                            </div>
                        </a>
                    );
                })
            );
        }
    }

}

export default HeaderFunction;