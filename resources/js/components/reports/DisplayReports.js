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
            from: e
        })
    }

    /**
     * Handles change to To field
     * @param e
     */
    handleToChange(e){
        this.setState({
            to: e
        })
    }

    /**
     * Handles change to ReportType field
     * @param e
     */
    handleReportTypeChange(e){
        this.setState({
            reportType: e.target.value
        })
    }

    /**
     * Handles change to Device field
     * @param e
     */
    handleDeviceChange(e){
        this.setState({
            device: e.target.value,
            interfaces: this.state.devices.filter(dev => dev.unique_id == e.target.value)[0].data_points
        })
        //console.log(this.state.interfaces);
    }

    /**
     * Handles change to Interface field
     * @param e
     */
    handleInterfaceChange(e){
        this.setState({
            interface: e.target.value
        })
    }

    /**
     * check if all fields have values
     */
    isValid(){
        if(this.state.from == "" || this.state.to == "" || this.state.reportType == "" || this.state.device == "" || this.state.interface == ""){
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


    tabRow = () => {
        if(this.state.readings instanceof Array){
            const intf = this.state.interface;
            return this.state.readings.map(function(object, i){

                const tabrows = () => {
                    if(object.dataSamples instanceof Array){


                        return object.dataSamples.map(function(object2, j) {

                            let className = '';
                            //const className = tableBg(object[this.props.points[0]+'minV'], object[this.props.points[0]+'maxV']);
                            //if(object['temp1'] > object['temp1-minT'] && object['temp1'] < object['temp1-maxT']){

                            if(object2[intf+"-minV"] == 0 && object2[intf+"-maxV"] == 0){
                                className = "bg-success";
                            }
                            else if(object2[intf+"-minV"] == -1 || object2[intf+"-maxV"] == -1 || !object2[intf]){
                                className = "bg-warning";
                            }
                            else{
                                className = "bg-danger";
                            }
                            console.log(intf);
                            return <td className={className}><small> { object2[intf] ? object2[intf].toFixed(2) : "NaN"}</small></td>;



                        })
                    }
                }

                return <tr>
                            <td className="text-black-50">{ object.recordDay }</td>


                            { tabrows() }


                            <td className="text-black-50">{ object.recordDay }</td>
                       </tr>
                //return <TableRow obj={object} key={i} />;
            })
        }
    }

    tdHeader(){
        if(this.state.configuration instanceof Array){
            return this.state.configuration.map(function(object, i){

                return <td align="center" className="text-black-50"><strong>{ object }:00</strong></td>
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
            <div>

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
                                                { this.formOptions() }

                                            </select>



                                        </div>
                                        <div className="col">
                                            <select className="form-control"
                                                    value={this.state.interface}
                                                    id="interface"
                                                    onChange={this.handleInterfaceChange}>
                                                <option>--Choose Interface--</option>
                                                { this.interfaceOptions() }

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

                                <table className="table text-white text-sm-center">
                                    <thead>
                                        <tr>
                                            <td>
                                                &nbsp;
                                            </td>
                                            { this.tdHeader() }
                                            <td>
                                                &nbsp;
                                            </td>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        { this.tabRow()}

                                    </tbody>

                                </table>

                                <p align="center" className={ this.state.showDownloadLink }>

                                    <a onClick={this.downloadExcel} href={`http://10.1.0.173/RTO3_Users-Mongo/public/exportreport/${this.convertDate(this.state.from)}/${this.convertDate(this.state.to)}/${this.state.reportType}/${this.state.device}/${this.state.interface}`} className="btn btn-primary">
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
