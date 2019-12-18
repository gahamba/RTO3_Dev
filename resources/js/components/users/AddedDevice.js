import React, { Component } from 'react';
import axios from 'axios';

class AddedDevice extends Component {
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

        let uri = 'deleteMap/'+this.props.obj._id+'/'+this.props.user._id;
        axios.get(uri)
            .then((response) => {

                alert(response.data);

                this.setState({
                    showloader: 'd-none'
                });


            })
            .catch((response)=>{
                this.handleClick
            });

        console.log(this.props.obj.name + " removed from " + this.props.user.name);
        //preventDefault();
    }

    render() {
        return (
            <div className="col-sm col-sm-3 float-left text-center">
                <i className="fas fa-thermometer fa-2x"></i><br />
                <span className="badge badge-info">{ this.props.obj.name }</span><br />

                <a href="#" className="btn btn-light" onClick={ this.handleClick}>
                    <span className={`spinner-border spinner-border-sm text-danger ${this.state.showloader}`} role="status" aria-hidden="true">&nbsp;&nbsp;</span>

                    <i className="fas fa-minus-circle text-danger"></i>
                </a>


            </div>
        );
    }
}

export default AddedDevice;
