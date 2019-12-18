import React, {Component} from 'react';
import { polyfill } from 'es6-promise'; polyfill();
import axios from 'axios';
import { render } from 'react-dom';
import Loader from "../Loader";
import Alert from "../Alert";
import DisplayDevices from './DisplayUsers';

class CreateUser extends Component {
    /**
     * Constructor
     * @param props
     */
    constructor(props){
        super(props);
        this.state = {
            name: '',
            email: '',
            user_type: 1,
            isValid: false,
            icon_name:'',
            icon_name_flag:'',
            icon_email:'',
            icon_email_flag:'',
            submitStatus: 'disabled',
            emailStatus: 'disabled',
            showloader:'d-none',
            alert:'',
            message:'',
            display:'d-none'};

        this.handleNameChange = this.handleNameChange.bind(this);
        this.handleEmailChange = this.handleEmailChange.bind(this);
        this.handleUserTypeChange = this.handleUserTypeChange.bind(this);
        this.handleIsValid = this.handleIsValid.bind(this);
        this.handleIsNameDataPresent = this.handleIsNameDataPresent.bind(true);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    /**
     * Handles change to name field
     * @param e
     */
    handleNameChange(e){
        this.setState({
            name: e.target.value,
            emailStatus: e.target.value == '' ? 'disabled' : '',
            icon_name: e.target.value == '' ? 'times' : 'check',
            icon_name_flag: e.target.value == '' ? 'danger' : 'success',

        });
        //this.handleIsNameDataPresent(e);
    }

    /**
     * Handles change to email field
     * @param e
     */
    handleEmailChange(e){
        this.setState({
            email: e.target.value
        });
        this.handleIsValid(e);
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
     * Checks that actual value is entered for name string
     */
    handleIsNameDataPresent(e){
        /*if(e.target.value !== ''){
            this.setState({
                emailStatus: '',
                icon_name:'check',
                icon_name_flag:'success',
            });

        }
        else{
            this.setState({emailStatus: 'disabled',
                icon_name:'times',
                icon_name_flag:'danger'});
        }*/
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
                    isValid: response.data,
                    icon_email: response.data == true ? 'check' : 'times',
                    icon_email_flag: response.data == true ? 'success' : 'danger',
                    submitStatus: response.data == true ? '' : 'disabled',
                });




            })
            .catch((response)=>{
                //alert(JSON.stringify(response));
                this.setState({
                    isValid: false,
                    icon_email: 'times',
                    icon_email_flag: 'danger',
                    submitStatus: 'disabled',
                });
            });
    }

    /**
     * Handles form submission
     * @param e
     */
    handleSubmit(e){
        this.setState({showloader: ''});
        e.preventDefault();

        if(this.state.isValid === true){

            const users = {
                name: this.state.name,
                email: this.state.email,
                user_type: this.state.user_type,
            }

            let uri = 'users';
            axios.post(uri, users)
                .then((response) => {

                    //alert(response.data);

                    //e.preventDefault();
                    this.setState({

                        name: '',
                        email: '',
                        user_type: 1,
                        isValid: false,
                        icon_name:'',
                        icon_name_flag:'',
                        icon_email:'',
                        icon_email_flag:'',
                        submitStatus: 'disabled',
                        emailStatus: 'disabled',
                        showloader: 'd-none',
                        alert: response.data === 'Successfully added' ? 'success' : 'danger',
                        message: response.data,
                        display:''
                    });


                })
                .catch((response)=>{
                    this.handleSubmit()
                });
        }
        else{

            this.setState({

                showloader: 'd-none',
                alert: 'danger',
                message: "Invalid or already existing email",
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
            email: '',
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
                    <a className="btn contrast_component2" data-toggle="collapse" href="#createDevicePanel"
                       role="button"
                       aria-expanded="false" aria-controls="createDevicePanel">
                        <i className="fas fa-plus-square"></i>&nbsp;Add User
                    </a>
                </p>

                <div className="clearfix">&nbsp;</div>
                <div className="collapse" id="createDevicePanel">
                    <div className="card card-body">
                        <Alert alert={this.state.alert} display={this.state.display} message={this.state.message} />
                        <h4>Create New User</h4>
                        <form onSubmit={this.handleSubmit}>


                            <div>

                                <div className="form-group">
                                    <label htmlFor="userType"><i className="fas fa-cog"></i>&nbsp;User Type (select
                                        one)</label>
                                    <select className="form-control" id="userType"
                                            value={this.state.user_type} onChange={this.handleUserTypeChange}>
                                        <option value="0">Super (Has all permissions)</option>
                                        <option value="1">Regular (Limited permissions)</option>
                                    </select>


                                </div>

                                <div className="form-group">
                                    <label htmlFor="userName"><i className="fas fa-user"></i>&nbsp;User
                                        Name</label>
                                    <div className="row">
                                        <div className="col-sm-10">
                                            <input type="text" className="form-control" placeholder="Ashley Wright"
                                                   id="userName" value={this.state.name} onChange={this.handleNameChange} />

                                        </div>
                                        <div className="col-sm-2">
                                            <i className={`fas fa-${this.state.icon_name}-circle text-${this.state.icon_name_flag}`}></i>
                                        </div>
                                    </div>


                                </div>

                                <div className="form-group">
                                    <label htmlFor="email"><i className="fas fa-envelope"></i>&nbsp;Email</label>
                                    <div className="row">
                                        <div className="col-sm-10">
                                            <input type="email" className="form-control" placeholder="ashley@yahoo.com"
                                                   id="email" value={this.state.email} onChange={this.handleEmailChange}
                                                   disabled={this.state.emailStatus} />
                                        </div>
                                        <div className="col-sm-2">
                                            <i className={`fas fa-${this.state.icon_email}-circle text-${this.state.icon_email_flag}`}></i>
                                        </div>
                                    </div>

                                </div>


                                <button type="submit" className="btn btn-primary"  disabled={this.state.submitStatus}>Add</button>

                            </div>


                        </form>

                    </div>
                </div>

                <div className="clearfix">&nbsp;</div>



            </div>
        )
    }
}
export default CreateUser;
