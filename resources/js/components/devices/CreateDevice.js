import React, {Component} from 'react';
import { polyfill } from 'es6-promise'; polyfill();
import axios from 'axios';
import { render } from 'react-dom';
import Loader from "../Loader";
import Alert from "../Alert";
import DisplayDevices from './DisplayDevices';
import TableRow from "./TableRow";

class CreateDevice extends Component {
    /**
     * Constructor
     * @param props
     */
    constructor(props){
        super(props);
        this.state = {
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
            description: '',
            isValid: false,
            icon:'',
            icon_flag:'',
            submitStatus: 'disabled',
            showloader:'d-none',
            alert:'',
            message:'',
            display:'d-none'
        };

        this.handleNameChange = this.handleNameChange.bind(this);
        this.dataPointDetails = this.dataPointDetails.bind(this);
        this.handleDatapointChange = this.handleDatapointChange.bind(this);
        this.handleUniqueIdChange = this.handleUniqueIdChange.bind(this);
        this.handleUnitsChange = this.handleUnitsChange.bind(this);
        this.handleMinThresholdChange = this.handleMinThresholdChange.bind(this);
        this.handleMaxThresholdChange = this.handleMaxThresholdChange.bind(this);
        this.handleDescriptionChange = this.handleDescriptionChange.bind(this);
        this.handleAddDataPoint = this.handleAddDataPoint.bind(this);
        this.dataPointsRows = this.dataPointsRows.bind(this);
        this.handleIsValid = this.handleIsValid.bind(this);
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
     * Handles change to uniqueId field
     * @param e
     */
    handleUniqueIdChange(e){
        this.setState({
            unique_id: e.target.value
        });
        this.handleIsValid(e);
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
     * Handles change to description field
     * @param e
     */
    handleDescriptionChange(e){
        this.setState({
            description: e.target.value
        })
    }

    /**
     * Handles checking of Valid Sensor ID
     */
    handleIsValid(e){
        //let db_api_uri = 'http://localhost/RT2_Reader/public/sensorExists/' + this.state.unique_id;
        let db_api_uri = 'sensorExists/' + e.target.value;
        //Check if SensorID exists

        axios.get(db_api_uri)
            .then((response) => {
                //alert(response.data.result);
                console.log(response.data.device);
                this.setState({
                    isValid: response.data.result,
                    datapoints: response.data.datapoints,
                    device: response.data.device,
                    datapoint: '',
                    removed_datapoints: [],
                    added_datapoints:[],
                    datapoint_detail: '',
                    units: '',
                    unit: '',
                    min_threshold: '0',
                    max_threshold: '1',
                    min_range: 0,
                    max_range: 1,
                    description: '',
                    icon: response.data.result == true ? 'check' : 'times',
                    icon_flag: response.data.result == true ? 'success' : 'danger',
                    submitStatus: response.data.device.activated == 0 ? '' : 'disabled',
                });




            })
            .catch((response)=>{
                //alert(JSON.stringify(response));
                this.setState({
                    isValid: false,
                    icon: 'times',
                    icon_flag: 'danger',
                    submitStatus: 'disabled',
                });
            });
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
            /**
             * Remove Datapoint onclick
             *
             */
            const handleRemove = (datapoint) => {

                //let matching_datapoint = this.state.datapoints.filter(datap => datap.interface != datapoint)[0];
                this.setState({
                    datapoint_detail: this.state.removed_datapoints.filter(datap => datap.interface == datapoint)[0]
                })


                //this.state.datapoints.pop(this.state.datapoint_detail)
                //this.state.added_datapoints.push(this.state.datapoint_detail)
                this.setState({
                    min_threshold: '0',
                    max_threshold: '1',
                    min_range: 0,
                    max_range: 1,
                    unit: '',
                    datapoint: '',
                    datapoints: this.state.datapoints.concat(this.state.removed_datapoints.filter(datap => datap.interface == datapoint)[0]),
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

        if(this.state.isValid === true){

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
                });
        }
        else{

            this.setState({

                showloader: 'd-none',
                alert: 'danger',
                message: "Invalid Sensor Unique ID",
                display:''
            });
        }

    }

    /**
     * The componentDidMount() method is called after the component is rendered.
     */
    componentDidMount() {

        this.state = {
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
            description: '',
            isValid: false,
            icon:'',
            icon_flag:'',
            submitStatus: 'disabled',
            showloader:'d-none',
            alert:'',
            message:'',
            display:'d-none'
        };
    }


    render() {
        return (
            <div>
                <p className="float-right">
                    <a className="btn contrast_component2" data-toggle="collapse" href="#createDevicePanel" role="button"
                       aria-expanded="false" aria-controls="createDevicePanel">
                        <i className="fas fa-plus-square"></i>&nbsp;Add Device
                    </a>
                </p>

                <div className="clearfix">&nbsp;</div>
                <div className="collapse" id="createDevicePanel">
                    <div className="card card-body">
                        <Alert alert={this.state.alert} display={this.state.display} message={this.state.message} />
                        <h4>Create Device</h4>
                        <form onSubmit={this.handleSubmit}>

                            <div className="form-group">
                                <label htmlFor="deviceUniqueId"><i className="fas fa-fingerprint"></i>&nbsp;
                                    Sensor ID</label>

                                <div className="row">
                                    <div className="col-sm-10">
                                        <input type="text" className="form-control" id="uniqueId"
                                               aria-describedby="uniqueIdHelp"
                                               placeholder="Enter device unique id"
                                               required="required"
                                               name="uniqueId"
                                               value={this.state.unique_id} onChange={this.handleUniqueIdChange} />
                                    </div>
                                    <div className="col-sm-2">

                                        <i className={`fas fa-${this.state.icon}-circle text-${this.state.icon_flag}`}></i>
                                    </div>


                                </div>

                            </div>

                            <div className={this.state.isValid ? '' : 'd-none'}>
                                <h5 align="center"><span  className="badge badge-info">Sensor Type: { this.state.isValid ? this.state.device.category : '' }</span></h5>

                                <div className="form-group">
                                    <label htmlFor="deviceName"><i className="fas fa-mobile"></i>&nbsp;Device
                                        Name</label>
                                    <input type="text" className="form-control" id="deviceName"
                                           aria-describedby="deviceNameHelp"
                                           placeholder="Enter device name"
                                           required="required"
                                           name="deviceName"
                                           value={this.state.name} onChange={this.handleNameChange}
                                           disabled={this.state.submitStatus} />

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
                                <p align="center" className={`${ this.state.isValid && this.state.device.activated != 0 ? 'd-none' : '' }`}>
                                    <a href="#" className="btn contrast_component2" data-toggle="modal" data-target="#datapoint">Add DataPoint</a>
                                </p>
                                </div>

                                <div className="modal fade" id="datapoint" tabIndex="-1" role="dialog"
                                     aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div className="modal-dialog modal-lg">
                                        <div className="modal-content">

                                            <div className="card card-body">
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

                                            </div>


                                        </div>
                                    </div>
                                </div>




                                <div className="form-group">
                                    <label htmlFor="deviceDescription"><i className="fas fa-info"></i>&nbsp;Device
                                        Description</label>
                                    <textarea className="form-control" id="deviceDescription"
                                              aria-describedby="deviceDescriptionHelp"
                                              placeholder="Enter device description"
                                              value={this.state.description}
                                              onChange={this.handleDescriptionChange}
                                              name="description"
                                              disabled={ this.state.submitStatus }>

                                    </textarea>
                                </div>

                                <p align="center" className={`${ this.state.isValid && this.state.device.activated != 0 ? 'd-none' : '' }`}>
                                    <button type="submit" className="btn btn-primary" disabled={this.state.submitStatus}>Add</button>
                                </p>

                                <span className="badge badge-danger">
                                    { this.state.isValid && this.state.device.activated != 0 ? 'Sensor already assigned to someone else' : ''  }
                                </span>

                            </div>


                            <Loader display={this.state.showloader} />


                        </form>

                    </div>
                </div>

                <div className="clearfix">&nbsp;</div>



            </div>
        )
    }
}
export default CreateDevice;
