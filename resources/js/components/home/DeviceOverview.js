import React, {Component} from 'react';
import { polyfill } from 'es6-promise'; polyfill();
import axios from 'axios';
import Loader from '../Loader';
import DeviceStatus from "./DeviceStatus";

class DeviceOverview extends Component {
    constructor(props){
        super(props);
        this.state = {devices: '', showloader: ''}
    }

    componentDidMount(){
        axios.get('devices')
            .then(response => {
                this.setState({ devices: response.data, showloader: 'd-none' });

            })
            .catch(function (error) {
                console.log(error);
            })
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        return true;
    }

    componentDidUpdate(){
        axios.get('devices')
            .then(response => {
                this.setState({ devices: response.data, showloader: 'd-none' });

            })
            .catch(function (error) {
                console.log(error);
            })
    }

    deviceStatus(){
        if(this.state.devices instanceof Array){
            return this.state.devices.map(function(object, i){
                return <DeviceStatus obj={object} key={i} />;
            })
        }
    }

    render(){
        return(
            <div className="container-fluid">

                <div className="card w-100">
                    <div className="clearfix">&nbsp;</div>
                    <h3 align="center">Overview of Devices </h3>
                    <div className="col-sm-12 card-body">

                        <div className="row text-center d-flex" id="overview_panel">

                            {this.deviceStatus()}


                        </div>


                    </div>
                </div>

            </div>
        );
    }
}

export default DeviceOverview;
