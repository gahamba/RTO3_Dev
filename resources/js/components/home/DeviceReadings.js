import React, {Component} from 'react';
import { polyfill } from 'es6-promise'; polyfill();
import axios from 'axios';
import Loader from '../Loader';
import TableRow from "./TableRow";
import ErrorLineChart from './ErrorLineChart';

class DeviceReadings extends Component {
    /**
     * Constructor
     * @param props
     */
    constructor(props){
        super(props);
        this.state = {readings: '', showloader: ''};
    }

    componentDidMount(){
        this.fetchDevices();
    }

    componentDidUpdate(){
        this.fetchDevices();
    }

    tabTodayRow(){
        if(this.state.readings.today instanceof Array){
            return this.state.readings.today.map(function(object, i){
                return <TableRow obj={object} key={i} />;
            })
        }
    }

    tabRecentsRow(){
        if(this.state.readings.recents instanceof Array){
            return this.state.readings.recents.map(function(object, i){
                return <TableRow obj={object} key={i} />;
            })
        }
    }

    fetchDevices(){
        axios.get('sensorRecentReadings/'+this.props.params.unique_id+'/'+this.props.datapoint)
            .then(response => {
                this.setState({ readings: response.data, showloader: 'd-none'});
                console.log(this.state.readings.recents[0]);

            })
            .catch(function (error) {
                if (error.response) {
                    console.log(error.response.data);
                }

            })
    }


    render(){

        return(
            <div>

                <div className="modal fade" id={this.props.readingId} tabIndex="-1" role="dialog"
                     aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div className="modal-dialog modal-lg modal-full">
                        <div className="modal-content">
                            <div className="card card-body">
                                <h4>Device: {this.props.params.name} ({this.props.params.unique_id})</h4>
                                <p>Min Threshold: {this.props.params.min_threshold} &nbsp;&nbsp;&nbsp;
                                    Max Threshold: {this.props.params.max_threshold} </p>

                                <div className="container-fluid">

                                    <div className="row">

                                        <div className="col-sm-6">
                                            <Loader display={this.state.showloader} />
                                            <h6>Readings Today</h6>
                                            <table className="table table-sm table-striped table-hover w-100" align="center">
                                                <thead>
                                                <tr>
                                                    <td scope="col">Reading</td>
                                                    <td scope="col">DateTime</td>
                                                    <td scope="col">Status</td>
                                                </tr>
                                                </thead>

                                                <tbody>

                                                {this.tabTodayRow()}

                                                </tbody>

                                            </table>

                                        </div>

                                        <div className="col-sm-6">

                                            <Loader display={this.state.showloader} />
                                            <ErrorLineChart values={this.state.readings.today}
                                                            min={this.props.params.min_threshold}
                                                            max={this.props.params.max_threshold}
                                                            data="Today"/>

                                        </div>

                                    </div>

                                    <div className="row">

                                        <div className="col-sm-6">
                                            <Loader display={this.state.showloader} />
                                            <h6>Recent Readings</h6>
                                            <table className="table table-sm table-striped table-hover w-100" align="center">
                                                <thead>
                                                <tr>
                                                    <td scope="col">Reading</td>
                                                    <td scope="col">DateTime</td>
                                                    <td scope="col">Status</td>
                                                </tr>
                                                </thead>

                                                <tbody>

                                                {this.tabRecentsRow()}

                                                </tbody>

                                            </table>

                                        </div>

                                        <div className="col-sm-6">

                                            <Loader display={this.state.showloader} />
                                            <ErrorLineChart values={this.state.readings.recents}
                                                                  min={this.props.params.min_threshold}
                                                                  max={this.props.params.max_threshold}
                                                                  data="Recent"/>

                                        </div>

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

export default DeviceReadings;


