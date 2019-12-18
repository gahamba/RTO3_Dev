import React, { Component } from 'react';

class Alert extends Component{


    render(){
        return(
            <div className={`alert alert-${this.props.alert} ${this.props.display}alert-dismissible fade show`} role="alert">
                {this.props.message}
                <button type="button" className="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
        );
    }
}

export default Alert;

