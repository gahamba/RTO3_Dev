import React, { Component } from 'react';
import DeviceReadings from "../home/DeviceReadings";
import UserDetails from "./UserDetails";

class EachUser extends Component {
    render() {
        return (
            <div className="col-sm-4 d-flex">
                <div className={` container card card-body ${ this.props.obj.user_type == 0 ? 'light_panel' : ''} space_inner `}>

                    <div className="row">

                        <div className="col-sm-4 text-center right_border">

                            <img className="rounded-circle user_profile2" src="../public/images/user.png"/>
                            <p><span className="badge badge-info contrast_component2">{ this.props.obj.name }</span></p>


                        </div>

                        <div className="col-sm-8 text-center">

                            <h4 align="center">Details
                                <a href="#" data-toggle="modal"
                                                          data-target={`#user${this.props.obj._id}`}>
                                    <i className="fas fa-cog text_contrast2"></i>
                                </a>
                            </h4>
                            <p className=""><i className="fas fa-envelope"></i>&nbsp; { this.props.obj.email }</p>
                            <p className=""><i className="fas fa-phone"></i>&nbsp; { this.props.obj.phone }</p>
                            <p>
                                <a href="#" className="btn btn-sm btn-warning">Reset Account</a>&nbsp;
                                <a href="#" className="btn btn-sm">Send In-Message</a>
                            </p>

                            <UserDetails userId={`user${this.props.obj._id}`} params={this.props.obj} />

                        </div>

                    </div>


                </div>
            </div>
        );
    }
}

export default EachUser;
