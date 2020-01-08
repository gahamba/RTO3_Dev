import React, { Component } from 'react';
import EditDevice from '.././devices/EditDevice';
import DeviceReadings from './DeviceReadings';
import CorrectiveComment from './CorrectiveComment';

class DeviceStatus extends Component {

    datapointStatus(){
        if(this.props.obj.datapoints instanceof Array){
            return this.props.obj.datapoints.map(function(object, i){

                return(
                    <div key={i} className="col" data-toggle="tooltip" data-placement="right" title="View recent readings for this sensor">


                        <a href="#" data-toggle="modal"
                           data-target={`#reading${object.unique_id}${object.interface}`}>
                        <div className="row">

                            <div className="col">

                                    <div className={`spinner-grow spinner-grow-sm text-${object.notifier}`} role="status">
                                        <span className="sr-only">Loading...</span>
                                    </div>

                            </div>
                        </div>
                        </a>
                        <div className="row">
                            <div className="col-sm">
                              { object.datapoint }<br />
                                <span className={`badge badge-${object.notifier}`}>{ object.message }</span> &nbsp;
                                <a href="#" data-toggle="modal"
                                   data-target={`#comment${object.unique_id}`}>
                                    <span className={`${ object.comment == 1 ? 'badge badge-info' : '' }`}>
                                        <i className={`fas ${ object.comment == 1 ? 'fa-comments' : '' }`}></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-sm">
                                <p align="center">Reading: { object.val }</p>
                            </div>
                        </div>
                        <DeviceReadings readingId={`reading${object.unique_id}${object.interface}`} datapoint={object.interface} params={object} />
                    </div>);
            })
        }
    }

    render() {
        return (
            <div className="col-sm-4">
                <div className="card bottom_margin light_panel">
                    <div className="card-body">
                        <h5 align="center">{ this.props.obj.name } &nbsp;
                        <a href="#" data-toggle="modal" data-target={`#edit${this.props.obj.device_id}`}>
                            <i className="fas fa-cog text-info"></i>
                        </a></h5>


                        <EditDevice editId={`edit${this.props.obj.device_id}`}
                                    params={this.props.obj}
                                    datapoints={this.props.obj.dpoints}
                        />

                        <div className="row text-center">
                            { this.datapointStatus() }
                        </div>



                        <CorrectiveComment commentId={`comment${this.props.obj.unique_id}`} params={this.props.obj} />

                    </div>
                </div>
            </div>
        );
    }
}

export default DeviceStatus;
