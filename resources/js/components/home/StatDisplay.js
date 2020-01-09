import React, {Component} from 'react';
import { polyfill } from 'es6-promise'; polyfill();
import axios from 'axios';
import Loader from '../Loader';
import DoughnutChart from './DoughnutChart';
import DeviceStatus from "./DeviceStatus";
import Modal from 'react-bootstrap/Modal';
import Button from 'react-bootstrap/Button';
import ModalDialog from 'react-bootstrap/ModalDialog';
import ModalHeader from 'react-bootstrap/ModalHeader';
import ModalTitle from 'react-bootstrap/ModalTitle';
import ModalBody from 'react-bootstrap/ModalBody';
import ModalFooter from 'react-bootstrap/ModalFooter';


class StatDisplay extends Component {

    constructor(props){
        super(props);
        this.state = { devices: '', counts: '', showloader: '', showModal: ''};
        this.countDevices = this.countDevices.bind(this);
    }

    /*static getDerivedStateFromProps(props, state){
        alert("This is from StatDisplay" +props.counts);
        return {counts: props.counts}
    }*/

    componentDidMount(){

        this.countDevices();

    }

    deviceStatus(){
        if(this.state.devices instanceof Array){
            return this.state.devices.map(function(object, i){
                return <DeviceStatus obj={object} key={i} />;
            })
        }
    }

    /*shouldComponentUpdate(nextProps, nextState, nextContext) {

        return this.state.devices != nextState.devices || this.state.counts != nextState.counts;
    }*/

    componentDidUpdate(){

        this.countDevices();

    }

    compareArray = (newData) => {
        var objectsAreSame = true;
        if(this.state.counts.length != newData.length){
            objectsAreSame = false;
        }
        else{
            for(var propertyName in this.state.counts) {

                //alert(propertyName);

                if(this.state.counts[propertyName] !== newData[propertyName]) {
                    objectsAreSame = false;
                    break;
                }

            }
        }

        return objectsAreSame;
    }
    compareArrayNest = (newData) => {
        var objectsAreSame = true;
        if(this.state.devices.length != newData.length){
            objectsAreSame = false;
        }
        else{

            for(var propertyName in this.state.devices) {
                //alert(propertyName);
                for(var propName in this.state.devices[propertyName]){

                    if(this.state.devices[propertyName][propName] !== newData[propertyName][propName] && !this.state.devices[propertyName][propName] instanceof Array) {
                        objectsAreSame = false;
                        break;
                    }
                    else{
                        if(this.state.devices[propertyName][propName] instanceof Array && this.state.devices[propertyName][propName].length != newData[propertyName][propName].length){
                            objectsAreSame = false;
                            break;
                        }
                        else {
                            for (var point in this.state.devices[propertyName][propName]) {


                                if (this.state.devices[propertyName][propName][point] !== newData[propertyName][propName][point] && !this.state.devices[propertyName][propName] instanceof Array) {
                                    objectsAreSame = false;
                                    break;
                                }
                                else{
                                    for (var point2 in this.state.devices[propertyName][propName][point]) {

                                        if (this.state.devices[propertyName][propName][point][point2] !== newData[propertyName][propName][point][point2] && !this.state.devices[propertyName][propName][point] instanceof Array){
                                            objectsAreSame = false;
                                            break;
                                        }
                                        else{
                                            for (var point3 in this.state.devices[propertyName][propName][point][point2]) {

                                                if (this.state.devices[propertyName][propName][point][point2][point3] !== newData[propertyName][propName][point][point2][point3] && !this.state.devices[propertyName][propName][point][point2] instanceof Array){
                                                    objectsAreSame = false;
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }


                    }
                }


            }

        }
        return objectsAreSame;
    }
    countDevices(){

        console.log("Count Device running");

        axios.get('devicestats')
            .then(response => {


                if(this.compareArrayNest(response.data.dev_stats) == false || this.compareArray(response.data.counts) == false){

                    this.setState(
                        {
                            devices: response.data.dev_stats,
                            counts: response.data.counts,
                            showloader: 'd-none',
                            showModal: response.data.counts.total == 0 ? true : false
                        });

                }
                else{
                    //this.componentDidUpdate();
                    this.countDevices();
                }

            })
            .catch(function (error) {
                console.log(error);
            })

    }



    render(){
        //this.countDevices();
        //const conditions = {'bad': this.state.counts.bad, 'attention': this.state.counts.attention, 'perfect': this.state.counts.perfect};
        const handleClose = () => {
            this.setState({ showModal: false }) };
        const handleShow = () => setShow(true);
        return(
            <div>

                <Modal size="lg" show={this.state.showModal} onHide={handleClose}>
                    <Modal.Header closeButton>
                        <Modal.Title>New to RealTimeOnline</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        Hello! Welcome to RealTimeOnline3 (Beta) Dashboard. You can get started by adding <strong>Devices/Sensors</strong> right away.
                        <p align="center">
                        <div className="btn btn-info"><a href="./device">
                            <i className="fas fa-plus-circle"></i>Add New Device</a></div>
                        </p>
                        <br />After adding devices, you can come back to monitor your devices by navigating back to Dashboard.
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="danger" onClick={handleClose}>
                            Close
                        </Button>

                    </Modal.Footer>
                </Modal>

                <div className="container">

                    <div className="row w-100 m-0">
                        <div className="col-sm-6 d-flex">
                            <div className="row w-100 m-0">
                                <div className="col-sm-6">
                                    <div className="card w-100 bottom_margin" data-toggle="tooltip" data-placement="right"
                                         title="Total number of Sensors installed by Invisible Systems">
                                        <div className="card-body">
                                            <h5>Total <mark>sensors</mark></h5>
                                            <Loader display={this.state.showloader} />
                                            <h3 className="display-3 text_contrast2" align="center">

                                                { this.state.counts.total }

                                            </h3>
                                            <p align="center"><i className="fas fa-tachometer-alt"></i></p>

                                        </div>
                                    </div>
                                </div>

                                <div className="col-sm-6">
                                    <div className="card w-100 bottom_margin" data-toggle="tooltip" data-placement="right"
                                         title="Total number of sensors in perfect condition">
                                        <div className="card-body">
                                            <h5>
                                                <mark>Good</mark>
                                            </h5>
                                            <Loader display={this.state.showloader} />
                                            <h3 className="display-3 text-success" align="center">

                                                { this.state.counts.perfect }
                                            </h3>
                                            <p align="center"><i className="fas fa-tachometer-alt"></i></p>

                                        </div>
                                    </div>
                                </div>

                                <div className="col-sm-6">
                                    <div className="card w-100 bottom_margin" data-toggle="tooltip" data-placement="right"
                                         title="Total number of sensors requiring attention">
                                        <div className="card-body">
                                            <h5>
                                                <mark>Attention</mark>
                                            </h5>
                                            <Loader display={this.state.showloader} />
                                            <h3 className="display-3 text-warning" align="center">

                                                { this.state.counts.attention }
                                            </h3>
                                            <p align="center"><i className="fas fa-tachometer-alt"></i></p>


                                        </div>
                                    </div>
                                </div>

                                <div className="col-sm-6">
                                    <div className="card w-100 bottom_margin" data-toggle="tooltip" data-placement="right"
                                         title="Total number of sensors in bad condition">
                                        <div className="card-body">
                                            <h5>
                                                <mark>Critical</mark>
                                            </h5>
                                            <Loader display={this.state.showloader} />
                                            <h3 className="display-3 text-danger" align="center">

                                                { this.state.counts.bad }
                                            </h3>
                                            <p align="center"><i className="fas fa-tachometer-alt"></i></p>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="col-sm-6 d-flex">
                            <div className="row w-100 m-0">
                                <div className="col-sm card bottom_margin">
                                    <div className="card-body h-100 d-flex justify-content-center align-items-center">
                                        <DoughnutChart conditions={this.state.counts} />

                                    </div>
                                </div>

                            </div>



                        </div>

                    </div>
                </div>


                <div className="container-fluid">

                    <div className="card w-100 d-flex">
                        <div className="clearfix">&nbsp;</div>
                        <h3 align="center">Overview of Devices </h3>
                        <p className="text-center"> <span className="badge badge-info"><a href="./device">
                            <i className="fas fa-plus-circle"></i>Add New Device</a></span> </p>
                        <p className="text-center">
                            {(this.state.devices.length > 0) ? '':<span className="badge badge-danger">You can click <a href="./device">here to add Devices/Sensors</a></span>}
                        </p>
                        <div className="col-sm-12 card-body">

                            <div className="row text-center" id="overview_panel">

                                {this.deviceStatus()}


                            </div>


                        </div>
                    </div>

                </div>
            </div>




        );
    }
}

export default StatDisplay;
