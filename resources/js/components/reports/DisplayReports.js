import React, {Component} from 'react';
import { polyfill } from 'es6-promise'; polyfill();
import axios from 'axios';
import TableRow from './TableRow';
import Loader from '../Loader';
import DatePicker from "react-datepicker";

import "react-datepicker/dist/react-datepicker.css";

class DisplayReports extends Component {
    constructor(props) {
        super(props);
        const url ='http://localhost/RTO3_Users-Mongo/public';
        this.state = {
            device: '',
            interface: '',
            showloader: 'd-none',
            showDownloadLink: 'd-none',
            devices: '',
            interfaces: '',
            from: '',
            to: '',
            reportType: '',
            readings: '',
            configuration: '',
            count_device: '',
            dates: '',
            points: '',
        };
        this.fetchDevices = this.fetchDevices.bind(this);
        this.handleFromChange = this.handleFromChange.bind(this);
        this.handleToChange = this.handleToChange.bind(this);
        this.handleReportTypeChange = this.handleReportTypeChange.bind(this);
        this.handleDeviceChange = this.handleDeviceChange.bind(this);
        this.handleInterfaceChange = this.handleInterfaceChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.isValid = this.isValid.bind(this);
        //this.colSpanVal = this.colSpanVal.bind(this);
        this.configLength = this.configLength.bind(this);
        this.downloadExcel = this.downloadExcel.bind(this);
        this.convertDate = this.convertDate.bind(this);


    }

    componentDidMount(){

        this.fetchDevices();
    }

    /**
     * Handles change to From field
     * @param e
     */
    handleFromChange(e){
        this.setState({
            from: e,
            readings: ''
        })
    }

    /**
     * Handles change to To field
     * @param e
     */
    handleToChange(e){
        this.setState({
            to: e,
            readings: ''
        })
    }

    /**
     * Handles change to ReportType field
     * @param e
     */
    handleReportTypeChange(e){
        this.setState({
            reportType: e.target.value,
            readings: ''
        })
    }

    /**
     * Handles change to Device field
     * @param e
     */
    handleDeviceChange(e){
        this.setState({
            device: e.target.value,
            //interfaces: this.state.devices.filter(dev => dev.unique_id == e.target.value)[0].data_points,
            readings: ''
        })
        //console.log(this.state.interfaces);
    }

    /**
     * Handles change to Interface field
     * @param e
     */
    handleInterfaceChange(e){
        this.setState({
            interface: e.target.value,
            readings: ''
        })
    }

    /**
     * check if all fields have values
     */
    isValid(){
        if(this.state.from == "" || this.state.to == "" || this.state.reportType == "" || this.state.device == "" ){
            return false;
        }
        else{
            return true;
        }
    }

    /**
     * Handles form submission
     * @param e
     */
    handleSubmit(e){
        this.setState({showloader: ''});
        e.preventDefault();

        if(this.isValid()){


            let from = this.convertDate(this.state.from);
            let to = this.convertDate(this.state.to);
            let uri = 'newreport/'+from+'/'+to+'/'+this.state.reportType+'/'+this.state.device;
            axios.get(uri)
                .then((response) => {

                    //alert(response.data['readings'][0].dataSamples[0].temp1);

                    //e.preventDefault();
                    this.setState({
                        readings: response.data['readings'],
                        configuration: response.data['configuration'],
                        count_device: response.data['count_device'],
                        dates: response.data['dates'],
                        showloader: 'd-none',
                        showDownloadLink: '',

                    });
                    var maxcount = 0;
                    this.state.count_device.map(function(count, key){
                        //alert(object);
                        if(count > maxcount){
                            maxcount = count;
                        }
                    });


                })
                .catch((response)=>{
                    alert(JSON.stringify(response));
                });
        }
        else{

            alert("Please all fields are required");
            this.setState({

                showloader: 'd-none',
            });
        }

    }


    tabRow = () => {
        if(this.state.readings instanceof Array){
            const intf = this.state.interface;
            const colSpanVal = () => {
                var maxcount = 0;
                this.state.count_device.map(function(count, key){
                    if(count > maxcount){
                        maxcount = count;
                    }
                });

                return maxcount;
            }

            const sensorId = (object) => {

                return object[0].sensor_name + " (" + object[0].sensor_id + ") ";
            }

            const tabrows = (object) => {
                return object.map(function(objectx, k) {

                    return objectx.dataSamples.map(function (object2, k) {

                        let className = '';

                        return objectx.points.map(function (object3, k) {

                            if (object2[object3 + "-minV"] == 0 && object2[object3 + "-maxV"] == 0) {
                                className = "bg-success";
                            } else if (object2[object3 + "-minV"] == -1 || object2[object3 + "-maxV"] == -1 || !object2[object3]) {
                                if (!object2[object3])
                                    className = "bg-light";
                                else {
                                    className = "bg-warning";
                                }
                            } else {
                                className = "bg-danger";
                            }
                            console.log(intf);
                            return <td className={className} colSpan={ colSpanVal()/objectx.points.length } >
                                <small> {object2[object3] ? object2[object3].toFixed(2) : " "}</small>
                            </td>;

                        })




                    })


                })
            }


            return this.state.readings.map(function(object, j) {

                    return <tr>
                        <td className="text-black-50"><small>{ sensorId(object) }</small></td>


                        { tabrows(object) }

                    </tr>


                    //return <TableRow obj={object} key={i} />;

            })




        }

    }



    configLength = () => {

        return this.state.configuration.length;
    }

    colSpanVal = () => {
        var maxcount = 0;
        this.state.count_device.map(function(count, key){
            if(count > maxcount){
                maxcount = count;
            }
        });

        return maxcount;
    }
    tdMainHeader =() => {
        if(this.state.dates instanceof Array){
            const configLength = () => {

                return this.state.configuration.length;
            }

            const colSpanVal = () => {
                var maxcount = 0;
                this.state.count_device.map(function(count, key){
                    if(count > maxcount){
                        maxcount = count;
                    }
                });

                return maxcount;
            }


            return this.state.dates.map(function(object, i){

                return <th align="center" className="text-black-50" colSpan={ colSpanVal() * configLength() }><small><strong>{ object }</strong></small></th>

            })
        }
    }

    tdHeader =() => {
        if(this.state.configuration instanceof Array){
            let cnf = this.state.configuration;
            const colSpanVal = () => {
                var maxcount = 0;
                this.state.count_device.map(function(count, key){
                    if(count > maxcount){
                        maxcount = count;
                    }
                });

                return maxcount;
            }
            return this.state.dates.map(function(obj, j) {

                return cnf.map(function(object, j){
                    return <td align="center" className="text-black-50" colSpan={ colSpanVal() }><small>{ object }:00</small></td>
                })
            })

        }


    }

    formOptions(){
        if(this.state.devices instanceof Array){
            return this.state.devices.map(function(object, i){

                return <option value={object.unique_id} key={i}>{object.name}-{object.unique_id}</option>;
            })
        }
    }

    interfaceOptions(){
        if(this.state.interfaces instanceof Array){
            return this.state.interfaces.map(function(object2, j){


                return <option value={object2.interface} key={j}>{object2.default_name}</option>;
            })
        }
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        return true;
    }

    fetchDevices(){
        this.setState({showloader: ''});
        axios.get('devices')
            .then(response => {
                this.setState({ devices: response.data, showloader: 'd-none' });

            })
            .catch(function (error) {
                if (error.response) {
                    console.log(error.response.data);
                }

            })
    }

    /**
     * convert date
     */
    convertDate(str) {
        var date = new Date(str),
            mnth = ("0" + (date.getMonth() + 1)).slice(-2),
            day = ("0" + date.getDate()).slice(-2);
        return [date.getFullYear(), mnth, day].join("-");
    }

    /**
     * Handles downloadExcel button
     * @param e
     */
    downloadExcel(){
        this.setState({showloader: ''});
        //preventDefault();

        if(this.isValid()){

            let from = this.convertDate(this.state.from);
            let to = this.convertDate(this.state.to);

            let uri = 'exportreport/'+from+'/'+to+'/'+this.state.reportType+'/'+this.state.device+'/'+this.state.interface;
            axios.get(uri)
                .then((response) => {

                    alert("Downloaded");

                    //e.preventDefault();
                    this.setState({

                        showloader: 'd-none',
                        showDownloadLink: '',

                    });


                })
                .catch((response)=>{
                    alert(JSON.stringify(response));
                });


        }
        else{
            alert("Please all fields are required");
            this.setState({

                showloader: 'd-none',
            });
        }
    }

    render(){
        return (
            <div className="container-fluid">

                <div className="card card-body">

                    <div className="container">

                        <div className="row">
                            <div className="col">
                                <h3 align="center">Enter dates to generate Report</h3>

                                <form onSubmit={this.handleSubmit}>
                                    <div className="form-row">
                                        <div className="col">
                                            <DatePicker
                                                className="form-control"
                                                selected={this.state.from}
                                                onChange={this.handleFromChange}
                                                dateFormat="yyyy-MM-dd"
                                                placeholderText="From e.g 2019-10-12"

                                            />

                                        </div>
                                        <div className="col">
                                            <DatePicker
                                                className="form-control"
                                                selected={this.state.to}
                                                onChange={this.handleToChange}
                                                dateFormat="yyyy-MM-dd"
                                                placeholderText="To e.g 2019-10-12"
                                            />

                                        </div>
                                        <div className="col">

                                            <select className="form-control"
                                                    value={this.state.reportType}
                                                    id="report_type"
                                                    onChange={this.handleReportTypeChange}>
                                                <option>--Choose Report Type--</option>
                                                <option value="1">HACCP</option>

                                            </select>

                                        </div>
                                        <div className="col">
                                            <select className="form-control"
                                                value={this.state.device}
                                                    id="device"
                                                    onChange={this.handleDeviceChange}>
                                                <option>--Choose Device--</option>
                                                <option value="*">All Devices</option>
                                                { this.formOptions() }

                                            </select>



                                        </div>
                                    </div>
                                    <br/>
                                    <div className="form-row text-center">
                                        <div className="col">
                                            <button type="submit" className="btn btn-primary">Generate Report</button>
                                        </div>

                                    </div>
                                </form>
                                <br />

                                <Loader display={this.state.showloader} />

                            </div>
                        </div>

                    </div>

                    <br/>

                    <div className="container-fluid overflow-auto">
                        <div className="row">
                            <div className="col" id="hacp">

                                <table align="center" className="table small text-white table-sm table-bordered text-sm-center">
                                    <thead>
                                        <tr>
                                            <th>
                                                &nbsp;
                                            </th>
                                            { this.tdMainHeader() }

                                        </tr>
                                        <tr>
                                            <td>
                                                &nbsp;
                                            </td>
                                            { this.tdHeader() }
                                        </tr>

                                    </thead>
                                    <tbody>
                                            { this.tabRow() }

                                    </tbody>

                                </table>
                                <br />

                                <p align="center" className={ this.state.showDownloadLink }>

                                    <a onClick={this.downloadExcel} href={`./exportreport/${this.convertDate(this.state.from)}/${this.convertDate(this.state.to)}/${this.state.reportType}/${this.state.device}`} className="btn btn-primary">
                                        Download Report </a>

                                </p>
                            </div>

                        </div>
                    </div>

                </div>


            </div>
        )
    }
}
export default DisplayReports;
