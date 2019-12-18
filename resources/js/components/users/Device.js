import React, { Component } from 'react';
import axios from 'axios';

class Device extends Component {
    constructor(props){
        super(props);
        this.state = {
            params: props.obj,
            showloader: 'd-none',

        };
    }

    static getDerivedStateFromProps(props, state) {
        return {
            params: props.obj,
        }
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        return true;
    }

    handleClick = () => {

        this.setState({showloader: ''});
        const userdevicemap = {
            user_id: this.props.user._id,
            system_id: 0,
            device_id: this.props.obj._id,
        }

        let uri = 'userdevicemap';
        axios.post(uri, userdevicemap)
            .then((response) => {

                alert(response.data);

                this.setState({
                    showloader: 'd-none'
                });


            })
            .catch((response)=>{
                this.handleClick
            });

        console.log(this.props.obj.name + " added to " + this.props.user.name);
        //preventDefault();
    }

    render() {
        return (
            <div className="col-sm col-sm-3 float-left text-center">
                <i className="fas fa-thermometer fa-2x"></i><br />
                <span className="badge badge-info">{ this.props.obj.name }</span><br />

                <a href="#" className="btn btn-light" onClick={ this.handleClick}>
                    <span className={`spinner-border spinner-border-sm text-success ${this.state.showloader}`} role="status" aria-hidden="true">&nbsp;&nbsp;</span>

                    <i className="fas fa-plus-circle text-success"></i>
                </a>


            </div>
        );
    }
}

export default Device;
