import React, {Component} from 'react';
import { polyfill } from 'es6-promise'; polyfill();
import axios from 'axios';
import Loader from '../Loader';
import Device from './Device';
import AddedDevice from './AddedDevice';
import Alert from "../Alert";

class UserDetails extends Component {
    /**
     * Constructor
     * @param props
     */
    constructor(props){
        super(props);
        this.state = {user: this.props.params,
            showloader: 'd-none',
            devices: '',
            addedDevices: '',
            name: this.props.params.name,
            email: this.props.params.email,
            phone: this.props.params.phone,
            user_type: this.props.params.user_type,
            alert:'',
            message:'',
            display:'d-none'

        };
        this.handleNameChange = this.handleNameChange.bind(this);
        this.handlePhoneChange = this.handlePhoneChange.bind(this);
        this.handleEmailChange = this.handleEmailChange.bind(this);
        this.handleUserTypeChange = this.handleUserTypeChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        //this.handleIsValid = this.handleIsValid(this);
    }

    componentDidMount(){
        axios.get('fetchAssoc/'+this.props.params._id)
            .then(response => {
                this.setState({

                    devices: response.data.unadded_devices,
                    addedDevices: response.data.added_devices,
                    showloader: 'd-none',
                    user: this.props.params });

            })
            .catch(function (error) {
                if (error.response) {
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                }

            })
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        return true;
    }

    componentDidUpdate(){
        axios.get('fetchAssoc/'+this.props.params._id)
            .then(response => {
                this.setState({

                    devices: response.data.unadded_devices,
                    addedDevices: response.data.added_devices,
                    showloader: 'd-none',
                    user: this.props.params });

            })
            .catch(function (error) {
                if (error.response) {
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                }

            })
    }

    devicesList(){
        if(this.state.devices instanceof Array){
            let user = this.props.params;
            return this.state.devices.map(function(object, i) {
                return <Device obj={object} key={i} user={ user } />;
            })
        }
    }

    addedDevicesList(){
        if(this.state.addedDevices instanceof Array){
            let user = this.props.params;
            return this.state.addedDevices.map(function(object, i) {
                return <AddedDevice obj={object} key={i} user={ user } />;
            })
        }
    }



    /**
     * Handles change to name field
     * @param e
     */
    handleNameChange(e){
        this.setState({
            name: e.target.value,

        });
    }

    /**
     * Handles change to email field
     * @param e
     */
    handleEmailChange(e){
        this.setState({
            email: e.target.value
        });
        //this.handleIsValid(e);
    }

    /**
     * Handles change to phone field
     * @param e
     */
    handlePhoneChange(e){
        this.setState({
            phone: e.target.value
        });
    }

    /**
     * Handles change to UserType
     * @param e
     */
    handleUserTypeChange(e){
        this.setState({
            user_type: e.target.value
        })
    }



    /**
     * Handles checking of existing Email or Invalid Email format
     */
    handleIsValid(e){
        //let db_api_uri = 'http://localhost/RT2_Reader/public/sensorExists/' + this.state.unique_id;
        let db_api_uri = 'emailcheck/' + e.target.value;
        //Check if SensorID exists

        axios.get(db_api_uri)
            .then((response) => {

                this.setState({
                    /*isValid: response.data,
                    icon_email: response.data == true ? 'check' : 'times',
                    icon_email_flag: response.data == true ? 'success' : 'danger',
                    submitStatus: response.data == true ? '' : 'disabled',*/
                });




            })
            .catch((response)=>{
                //alert(JSON.stringify(response));
                /*this.setState({
                    isValid: false,
                    icon_email: 'times',
                    icon_email_flag: 'danger',
                    submitStatus: 'disabled',
                });*/
            });
    }

    /**
     * Handles form submission
     * @param e
     */
    handleSubmit(e){
        this.setState({showloader: ''});
        e.preventDefault();



            const users = {
                name: this.state.name,
                phone: this.state.phone,
                user_type: this.state.user_type,
            }

            let uri = 'users/'+this.props.params._id;
            axios.put(uri, users)
                .then((response) => {

                    //alert(response.data);

                    //e.preventDefault();
                    this.setState({


                        showloader: 'd-none',
                        alert: response.data === 'Successfully updated record' ? 'success' : 'danger',
                        message: response.data,
                        display:''
                    });


                })
                .catch((response)=>{
                    this.handleSubmit()
                });


    }





    render(){

        return(
            <div>

                <div className="modal fade" id={this.props.userId} tabIndex="-1" role="dialog"
                     aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div className="modal-dialog modal-lg modal-full">
                        <div className="modal-content">
                            <div className="card card-body">

                                <h5 align="center"><i className="fas fa-user"></i>&nbsp;Users</h5>
                                <Alert alert={this.state.alert} display={this.state.display} message={this.state.message} />

                                <form>
                                    <div className="form-row">
                                        <div className="col">
                                            <input type="text" className="form-control"
                                                   placeholder="full name"
                                                   value={ this.state.name }
                                                   onChange={this.handleNameChange} />
                                        </div>
                                        <div className="col">
                                            <input type="text" className="form-control"
                                                   placeholder="email"
                                                   value={ this.state.email }
                                                    onChange={this.handleEmailChange} disabled="true"/>
                                        </div>
                                    </div>

                                    <br />

                                    <div className="form-row">
                                        <div className="col">
                                            <input type="text" className="form-control"
                                                   placeholder="phone"
                                                   value={ this.state.phone }
                                                    onChange={ this.handlePhoneChange }/>
                                        </div>
                                        <div className="col">
                                            <select className="form-control"
                                                    value={ this.state.user_type }
                                                    onChange={ this.handleUserTypeChange }>
                                                <option value="0">Super Admin</option>
                                                <option value="1">Regular Admin</option>
                                            </select>
                                        </div>
                                    </div>

                                    <br />

                                    <div className="form-row">
                                        <div className="col">
                                            <button type="submit" className="btn btn-primary" onClick={ this.handleSubmit }>
                                                <span className={`spinner-border spinner-border-sm ${this.state.showloader}`} role="status" aria-hidden="true">&nbsp;&nbsp;</span>
                                                Update Record
                                            </button>
                                        </div>

                                    </div>


                                    <br />
                                    <br />
                                    <div className="form-row">
                                        <div className="col text-center">
                                            <h4>Systems</h4>
                                            <table className="table table-sm table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td align="center">Fridge</td>

                                                    </tr>
                                                    <tr>
                                                        <td align="center">Home</td>

                                                    </tr>
                                                </tbody>
                                            </table>


                                        </div>

                                    </div>

                                    <div className="container">
                                        <h5>User Access List</h5>
                                        <div className="row">
                                            { this.addedDevicesList() }
                                        </div>

                                    </div>

                                    <hr />

                                    <div className="container">
                                        <h5>Add these devices to User access list</h5>
                                        <div className="row">
                                            { this.devicesList() }
                                        </div>

                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        );

    }
}

export default UserDetails;


