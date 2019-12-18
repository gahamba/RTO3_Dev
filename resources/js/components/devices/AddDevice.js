import React, {Component} from 'react';
import { polyfill } from 'es6-promise'; polyfill();
import axios from 'axios/index';
import Loader from '../Loader';
import Alert from '../Alert';
import TableRow from "./TableRow";
import DisplayDevices from "./DisplayDevices";

class AddDevice extends Component {
    /**
     * Constructor
     * @param props
     */
    constructor(props){
        super(props);
        this.state = {
            unique_id: '',
            device: '',
            showloader: 'd-none',
            alert:'',
            message: '',
            display:'d-none',
            panel_display:'d-none',
            panel_message: '',
            panel_show_button: 'd-none',
            panel_response_color:'',
        };
        const url ='http://localhost/RTO3_Users/public/';
        this.handleUniqueIdChange = this.handleUniqueIdChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleUpdateSubmit = this.handleUpdateSubmit.bind(this);
    }



    /**
     * Handles change to name field
     * @param e
     */
    handleUniqueIdChange(e){
        this.setState({
            unique_id: e.target.value,

            panel_display: 'd-none',
            panel_message: '',
            panel_show_button: 'd-none',
            panel_response_color: '',
            showloader: 'd-none',

        })
    }

    /**
     * Handles form submission to search for devices
     * @param e
     */
    handleSubmit(e){
        this.setState({showloader: ''});
        e.preventDefault();
        axios.get('devicefromuniqueid/'+this.state.unique_id)
            .then(response => {
                this.setState({
                    panel_display: '',
                    panel_message: response.data.msg,
                    panel_show_button: response.data.isFree == 1 ? '' : 'd-none',
                    panel_response_color: response.data.isFree == 1 ? 'success' : 'danger',
                    device: response.data.device,
                    showloader: 'd-none',

                });

            })


    }

    handleUpdateSubmit(e){
        this.setState({showloader: ''});
        e.preventDefault();
        const device = {
            id: this.state.device.id,
            company_id : this.props.params.id,
            unique_id: this.state.unique_id,
        }
        let uri = 'devices/'+this.state.device.id;
        axios.patch(uri, device)
            .then((response) => {

                this.setState({

                    showloader: 'd-none',
                    panel_display: 'd-none',
                    panel_message: '',
                    panel_show_button: 'd-none',
                    panel_response_color: '',
                    alert: response.data == "Successfully Updated" ? 'success' : 'danger',
                    message: response.data,
                    display:'',

                });

            })
            .catch((response)=>{
                alert(JSON.stringify(response));
            });
        //alert(device.unique_id);
    }



    render(){

        return(
            <div>

            <div className="modal fade" id={this.props.addId} tabIndex="-1" role="dialog"
                 aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div className="modal-dialog modal-lg">
                    <div className="modal-content">
                        <div className="card card-body">
                            <Alert alert={this.state.alert} display={this.state.display} message={this.state.message} />
                            <h4>Add Device</h4>
                            <form onSubmit={this.handleSubmit}>
                                <div className="form-group">
                                    <label htmlFor="deviceUniqueId"><i className="fas fa-fingerprint"></i>&nbsp;
                                        Unique ID</label>
                                    <input type="text" className="form-control" id="uniqueId"
                                           aria-describedby="uniqueIdHelp" placeholder="Enter device unique id" value={this.state.unique_id} onChange={this.handleUniqueIdChange} />

                                </div>

                                <button type="submit" className="btn btn-primary">Search</button>

                            </form>

                            <br /><br />

                            <Loader display={this.state.showloader} />

                            <div className={`${ this.state.panel_display }`}>

                                <form onSubmit={this.handleUpdateSubmit}>
                                    <div className="form-group">
                                        <h4 className={`text-${this.state.panel_response_color}`} align="center">{ this.state.panel_message }</h4>

                                    </div>

                                    <button type="submit" className={`btn btn-success float-right ${this.state.panel_show_button}`}>Update</button>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        );

    }
}

export default AddDevice;


