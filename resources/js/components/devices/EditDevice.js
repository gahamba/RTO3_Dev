import React, {Component} from 'react';
import { polyfill } from 'es6-promise'; polyfill();
import axios from 'axios';
import Loader from '../Loader';
import Alert from '../Alert';

class EditDevice extends Component {
    /**
     * Constructor
     * @param props
     */
    constructor(props){
        super(props);
        this.state = {
            id: this.props.params.id,
            name: this.props.params.name,
            unique_id: this.props.params.unique_id,
            min_threshold: this.props.params.min_threshold,
            max_threshold: this.props.params.max_threshold,
            description: this.props.params.description,
            panel_id: this.props.editId,
            showloader: 'd-none',
            alert:'',
            message: '',
            display:'d-none',
            /*The new states were added here*/
            datapoints:  this.props.datapoints,
            datapoint: '',
            device: '',
            removed_datapoints: this.props.params.removed_datapoints,
            added_datapoints:this.props.params.added_datapoints,
            datapoint_detail: '',
            units: '',
            unit: '',
            min_range: 0,
            max_range: 1,
            isValid: false,
            icon:'',
            icon_flag:'',
        };
        const url ='http://localhost/RTO3_Users/public/';
        this.handleNameChange = this.handleNameChange.bind(this);
        //this.handleUniqueIdChange = this.handleUniqueIdChange.bind(this);
        this.handleDatapointChange = this.handleDatapointChange.bind(this);
        this.handleUnitsChange = this.handleUnitsChange.bind(this);
        this.handleMinThresholdChange = this.handleMinThresholdChange.bind(this);
        this.handleMaxThresholdChange = this.handleMaxThresholdChange.bind(this);
        this.handleDescriptionChange = this.handleDescriptionChange.bind(this);
        this.dataPointDetails = this.dataPointDetails.bind(this);
        this.handleAddDataPoint = this.handleAddDataPoint.bind(this);
        this.dataPointsRows = this.dataPointsRows.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);

    }


    /**
     * Handles change to name field
     * @param e
     */
    handleNameChange(e){

        this.setState({
            name: e.target.value
        })
    }

    /**
     * Handles change to uniqueId field
     * @param e
     */
    handleUniqueIdChange(e){
        this.setState({
            unique_id: e.target.value
        })
    }

    /**
     * Handles change to datapoints field
     * @param e
     */
    handleDatapointChange(e){
        this.setState({
            datapoint: '',
            units: '',
            unit: '',
            min_threshold: '0',
            max_threshold: '1',
            min_range: '',
            max_range: '',
        })
        let datapointdetail = this.dataPointDetails(e.target.value);
        console.log(datapointdetail);
        this.setState({
            datapoint: e.target.value,
            units: datapointdetail['units'],
            unit: datapointdetail['units'][0],
            min_threshold: '0',
            max_threshold: '1',
            min_range: datapointdetail['min_range'],
            max_range: datapointdetail['max_range'],
        })


    }

    /**
     * Handles change to units field
     * @param e
     */
    handleUnitsChange(e){
        this.setState({
            unit: e.target.value
        })
    }

    /**
     * Handles change to min threshold
     * @param e
     */
    handleMinThresholdChange(e){
        this.setState({
            min_threshold: e.target.value
        })
    }

    /**
     * Handles change to max threshold
     * @param e
     */
    handleMaxThresholdChange(e){
        this.setState({
            max_threshold: e.target.value
        })
    }

    /**
     * Fetch datapoint details
     *
     */
    dataPointDetails(datapoint){
        /*this.state.datapoints.find((element) => {
            return element.interface == datapoint;
        })*/
        let matching_datapoint = this.state.datapoints.filter(datap => datap.interface == datapoint)[0];
        this.setState({
            datapoint_detail: matching_datapoint
        })

        return matching_datapoint;

    }


    /**
     * Handles change to description field
     * @param e
     */
    handleDescriptionChange(e){
        this.setState({
            description: e.target.value
        })
    }

    /*
    *populate drop down menu with datapoints
    *
    */
    options(){
        if(this.state.datapoints instanceof Array){

            return this.state.datapoints.map(function(object, i){
                return <option value={object.interface} key={i}>{ object.default_name }</option>;
            })
        }
    }

    /*
    *populate drop down menu with datapoint units
    *
    */
    unitoptions(){
        if(this.state.units instanceof Array){
            return this.state.units.map(function(object, i){
                return <option value={object} key={i}>{ object }</option>;
            })
        }
    }

    /*
    *Added datapoints
    *
    */
    dataPointsRows(){
        if(this.state.added_datapoints instanceof Array){
            //console.log(this.state.added_datapoints);

            /**
             * Remove Datapoint onclick
             *
             */
            const handleRemove = (datapoint) => {

                //let matching_datapoint = this.state.datapoints.filter(datap => datap.interface != datapoint)[0];
                let this_datapoint = this.state.removed_datapoints.filter(datap => datap.interface == datapoint)[0];
                this.setState({
                    datapoint_detail: this_datapoint
                })

                console.log("this_datapoint");
                console.log(this_datapoint);
                console.log("this.state.datapoints");
                console.log(this.state.datapoints);

                //this.state.datapoints.pop(this.state.datapoint_detail)
                //this.state.added_datapoints.push(this.state.datapoint_detail)
                this.setState({
                    min_threshold: '0',
                    max_threshold: '1',
                    min_range: 0,
                    max_range: 1,
                    unit: '',
                    datapoint: '',
                    datapoints: this.state.datapoints.concat(this_datapoint),
                    //added_datapoints: this.state.added_datapoints.concat(this_datapoint),
                    added_datapoints: this.state.added_datapoints.filter(datap => datap.point != datapoint),
                    removed_datapoints: this.state.removed_datapoints.filter(datap => datap.interface != datapoint),
                })

            }
            return this.state.added_datapoints.map(function(object, i){

                return <tr>
                    <td><span className="badge badge-info">Interface</span>&nbsp;{ object.lable }</td>
                    <td><span className="badge badge-warning">Min Threshold</span>&nbsp;{ object.minT }</td>
                    <td><span className="badge badge-warning">Max Threshold</span>&nbsp;{ object.maxT }</td>
                    <td><span className="badge badge-info">Unit</span>&nbsp;{ object.unit }</td>
                    <td><a href="#" onClick={ () => handleRemove(object.point) }> <i className="fas fa-times-circle text-danger"></i></a></td>
                </tr>;
            })
        }
    }

    /**
     * Add Datapoint onclick
     *
     */
    handleAddDataPoint(){

        if(this.state.datapoint != ''){
            //let matching_datapoint = this.state.datapoints.filter(datap => datap.interface != datapoint)[0];
            this.setState({
                datapoint_detail: this.state.datapoints.filter(datap => datap.interface == this.state.datapoint)[0]
            })

            let this_datapoint = [{
                lable: this.state.datapoint_detail['default_name'],
                point: this.state.datapoint_detail['interface'],
                unit: this.state.unit,
                minT: parseFloat(this.state.min_threshold),
                maxT: parseFloat(this.state.max_threshold),
                threshold_active_date: new Date().toISOString(),
                start_delay: new Date().toISOString(),
                end_delay: new Date().toISOString(),

            }];

            //this.state.datapoints.pop(this.state.datapoint_detail)
            //this.state.added_datapoints.push(this.state.datapoint_detail)
            this.setState({
                min_threshold: '0',
                max_threshold: '0',
                min_range: 0,
                max_range: 1,
                datapoint: '',
                added_datapoints: this.state.added_datapoints.concat(this_datapoint),
                removed_datapoints: this.state.removed_datapoints.concat(this.state.datapoint_detail),
                datapoints: this.state.datapoints.filter(datap => datap.interface != this.state.datapoint_detail['interface']),
            })

            this.setState({
                datapoint_detail: ''
            })
            console.log(this.state.added_datapoints);
        }
    }






    /**
     * Handles form submission
     * @param e
     */
    handleSubmit(e){
        this.setState({showloader: ''});
        e.preventDefault();
        const devices = {
            name: this.state.name,
            unique_id: this.state.unique_id,
            data_points: this.state.added_datapoints,
            description: this.state.description,
            system_id: 0,
            system_name: 'nil',
        }
        let uri = 'devices/'+this.state.id;
        axios.patch(uri, devices)
            .then((response) => {

                alert(response.data);
                this.setState({
                    showloader: 'd-none',
                    alert: response.data === 'Successfully Updated' ? 'success' : 'warning',
                    message: response.data,
                    display:'',

                });
                //$('#edit'+this.props.params.id).modal('hide');
                //e.preventDefault();


            })
            .catch((response)=>{
                alert(JSON.stringify(response));
            });

        /*this.setState({showloader: ''});
        e.preventDefault();


            const devices = {
                name: this.state.name,
                unique_id: this.state.unique_id,
                data_points: this.state.added_datapoints,
                description: this.state.description,
                system_id: 0,
                system_name: 'nil',
            }



            let uri = 'devices';
            axios.post(uri, devices)
                .then((response) => {

                    //alert(response.data);

                    //e.preventDefault();
                    this.setState({
                        description: '',
                        name: '',
                        unique_id: '',
                        datapoints: '',
                        datapoint: '',
                        device: '',
                        removed_datapoints: [],
                        added_datapoints:[],
                        datapoint_detail: '',
                        units: '',
                        unit: '',
                        min_threshold: '0',
                        max_threshold: '1',
                        min_range: 0,
                        max_range: 1,
                        showloader: 'd-none',
                        alert: response.data === 'Successfully added' ? 'success' : 'warning',
                        message: response.data,
                        display:''
                    });


                })
                .catch((response)=>{
                    alert(JSON.stringify(response));
                    this.setState({alert: 'danger', message: response});
                });*/

    }

    render(){
        return(
            <div>

                <div className="modal fade" id={this.state.panel_id} tabIndex="-1" role="dialog"
                     aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div className="modal-dialog modal-lg">
                        <div className="modal-content">
                            <div className="card card-body">
                                <Alert alert={this.state.alert} display={this.state.display} message={this.state.message} />
                                <h4>Edit Device</h4>
                                <form onSubmit={this.handleSubmit}>

                                    <div className="form-group">
                                        <label htmlFor="deviceName"><i className="fas fa-mobile"></i>&nbsp;Device
                                            Name</label>
                                        <input type="text"
                                               className="form-control"
                                               id="deviceName"
                                               aria-describedby="deviceNameHelp"
                                               placeholder="Enter device name"
                                               value={this.state.name}
                                               onChange={this.handleNameChange} />

                                    </div>

                                    <div className="form-group">
                                        <label htmlFor="deviceUniqueId"><i className="fas fa-fingerprint"></i>&nbsp;
                                            Unique ID</label>
                                        <input className="form-control" id="uniqueId"
                                               aria-describedby="uniqueIdHelp"
                                               placeholder="Enter device unique id"
                                               value={this.state.unique_id} onChange={this.handleUniqueIdChange}
                                        readOnly />

                                    </div>

                                    <h5 align="center">Datapoints</h5>
                                    <div className="form-group">
                                        <table className="table table-hover">
                                            <tbody>
                                            { this.dataPointsRows() }
                                            </tbody>

                                        </table>



                                    </div>


                                    <div className="form-group">
                                        <label htmlFor="datapointName"><i className="fas fa-mobile"></i>&nbsp;New Data Point</label>

                                        <select className="form-control" id="datapointName"
                                                aria-describedby="datapointNameHelp" placeholder="Select Datapoint"
                                                value={this.state.datapoint} onChange={this.handleDatapointChange}
                                                disabled={this.state.submitStatus}>
                                            <option>--Choose Datapoint--</option>
                                            { this.options() }

                                        </select>



                                    </div>

                                    <div className="form-group">
                                        <label htmlFor="unit"><i className="fas fa-mobile"></i>&nbsp;Unit</label>

                                        <select className="form-control" id="unit"
                                                aria-describedby="unitHelp" placeholder="Select Unit"
                                                value={this.state.unit} onChange={this.handleUnitsChange}
                                                disabled={this.state.submitStatus}>
                                            { this.unitoptions() }

                                        </select>



                                    </div>

                                    <div className="row">

                                        <div className="form-group col-sm-10">
                                            <label htmlFor="minThreshold"><i className="fas fa-exchange-alt"></i>&nbsp;
                                                Min Threshold</label>

                                            <input type="range"
                                                   className="custom-range"
                                                   min={this.state.min_range} max={this.state.max_range}
                                                   step="1"
                                                   id="minThreshold"
                                                   value={this.state.min_threshold}
                                                   onChange={this.handleMinThresholdChange}
                                                   disabled={this.state.submitStatus} />

                                        </div>

                                        <div className="col-sm-2">

                                            <input type="text" className="form-control" value={this.state.min_threshold} readOnly="true" />
                                        </div>

                                    </div>

                                    <div className="row">

                                        <div className="form-group col-sm-10">
                                            <label htmlFor="maxThreshold"><i className="fas fa-exchange-alt"></i>&nbsp;
                                                Max Threshold</label>
                                            <input type="range"
                                                   className="custom-range"
                                                   min={this.state.min_range} max={this.state.max_range}
                                                   id="maxThreshold"
                                                   value={this.state.max_threshold}
                                                   onChange={this.handleMaxThresholdChange}
                                                   disabled={this.state.submitStatus} />

                                        </div>

                                        <div className="col-sm-2">

                                            <input type="text" className="form-control" value={this.state.max_threshold} readOnly="true" />
                                        </div>


                                    </div>

                                    <div className="form-group">
                                        <p align="center" className={`${ this.state.datapoint == '' ? 'd-none' : '' }`}>
                                            <a href="#" onClick={this.handleAddDataPoint} className="btn btn-sm btn-primary">Add</a>
                                        </p>
                                    </div>

                                    <div className="form-group">
                                        <label htmlFor="deviceDescription"><i className="fas fa-info"></i>&nbsp;Device
                                            Description</label>
                                        <textarea className="form-control" id="deviceDescription"
                                                  aria-describedby="deviceDescriptionHelp"
                                                  placeholder="Enter device description" value={this.state.description || ''}
                                                  onChange={this.handleDescriptionChange}>


                                        </textarea>
                                    </div>

                                    <button type="submit" className="btn btn-primary">Update</button>



                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        );

    }
}

export default EditDevice;


