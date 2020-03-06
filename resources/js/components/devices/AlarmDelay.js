import React, {Component} from 'react';
import { polyfill } from 'es6-promise'; polyfill();
import axios from 'axios';
import Loader from '../Loader';
import Alert from '../Alert';
import DatePicker from 'react-datepicker';
import TimePicker from 'react-time-picker';
import "react-datepicker/dist/react-datepicker.css";

class AlarmDelay extends Component {
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
            panel_id: this.props.alarmId,
            delay: this.props.params.delay_active,
            delay_minutes: this.props.params.delay_minutes,
            showloader: 'd-none',
            alert:'',
            message: '',
            display: 'd-none',
            display_hold:'d-none',
            display_delay: this.props.params.delay_active === "0" ? 'd-none':'',

        };

        this.handleAlarmDelayChange = this.handleAlarmDelayChange.bind(this);
        this.handleAlarmDelayMinutesChange = this.handleAlarmDelayMinutesChange.bind(this);
        this.handleHoldToggle = this.handleHoldToggle.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);


    }


    /**
     * Handles change to AlarmDelay activation field
     * @param e
     */
    handleAlarmDelayChange(e){

        this.setState({
            delay: e.target.value,
            display_delay: e.target.value == "1" ? '' : 'd-none',
        })

    }

    /**
     * Handles change to number of minutes for active delay field
     * @param e
     */
    handleAlarmDelayMinutesChange(e){

        this.setState({
            delay_minutes: e.target.value,

        })

    }

    /**
     * Handles toggling Alar Holding
     * @param e
     */
    handleHoldToggle(e){
        var hold = this.state.display_hold;
        this.setState({
            display_hold: hold == 'd-none' ? '' : 'd-none',
        })
    }


    /**
     * Handles form submission
     * @param e
     */
    handleSubmit(e){
        this.setState({showloader: ''});
        e.preventDefault();

        //const device_array = [this.state.id, this.state.delay, this.state.delay_minutes];


        axios.get('alarmdelay/'+this.state.id+'/'+this.state.delay+'/'+this.state.delay_minutes)
            .then((response) => {

                this.setState({

                    showloader: 'd-none',
                    alert: response.data === 'Successful' ? 'success' : 'warning',
                    message: response.data,
                    display:''
                });


            })
            .catch((response)=>{
                alert(JSON.stringify(response));
                this.setState({alert: 'danger', message: response});
            });

    }

    render(){

        return(
            <div>

                <div className="modal fade" id={this.props.alarmId} tabIndex="-1" role="dialog"
                     aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div className="modal-dialog modal-lg">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title"></h5>
                                <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" className="btn btn-danger">&times;</span>
                                </button>
                            </div>
                            <div className="card card-body">
                                <Alert alert={this.state.alert} display={this.state.display} message={this.state.message} />
                                <form onSubmit={this.handleSubmit}>

                                    <div className="form-group">
                                        <h5 align="center">Activate Alarm Delay</h5>

                                        <div className="switch switch-blue">
                                            <input type="radio" className="switch-input" value="1"
                                                   id={ 'on' + this.props.params.unique_id}
                                                   checked={ this.state.delay === "1" }
                                                   onChange={this.handleAlarmDelayChange} />
                                            <label htmlFor={ 'on' + this.props.params.unique_id}
                                                   className="switch-label switch-label-off">ON</label>
                                            <input type="radio" className="switch-input" value="0"
                                                   id={ 'off' + this.props.params.unique_id}
                                                   checked={ this.state.delay === "0" }
                                                   onChange={this.handleAlarmDelayChange} />
                                            <label htmlFor={ 'off' + this.props.params.unique_id}
                                                   className="switch-label switch-label-on">OFF</label>
                                            <span className="switch-selection"></span>
                                        </div>

                                        <div className={ this.state.display_delay }>
                                            <label htmlFor="delayMinutes"><b>Set Delay</b></label>
                                            <div className="form-row">
                                                <input type="text"
                                                       className="form-control"
                                                       id="delayMinutes"
                                                       aria-describedby="emailHelp"
                                                       value={ this.state.delay_minutes }
                                                       placeholder="Enter time (minutes)"
                                                       onChange={ this.handleAlarmDelayMinutesChange }
                                                />
                                                <small id="emailHelp" className="form-text text-muted">Set how long you want the delay for (in minutes).
                                                </small>
                                            </div>


                                        </div>

                                    </div>

                                    <div className="row">
                                        <div className="col text-center">
                                            <span className="badge badge-info" onClick={ this.handleHoldToggle }><a href="#">Activate hold on this Sensor</a></span>
                                        </div>
                                    </div>

                                    <br />

                                    <div className={this.state.display_hold}>

                                        <h6 align="center">Hold alarm for period below</h6>

                                        <div className="form-group">
                                            <label htmlFor="startDelay">Start Delay</label>
                                            <div className="form-row">
                                                <DatePicker
                                                    id="startDelay"
                                                    className="form-control"
                                                    selected={this.state.from}
                                                    onChange={this.handleFromChange}
                                                    placeholderText="From e.g 2019-10-12"
                                                    showTimeSelect
                                                    timeFormat="HH:mm"
                                                    timeIntervals={15}
                                                    timeCaption="time"
                                                    dateFormat="yyyy-MM-dd h:mm aa"

                                                />
                                            </div>


                                        </div>
                                        <div className="form-group">
                                            <label htmlFor="endDelay">End Delay</label>
                                            <div className="form-row">
                                                <DatePicker
                                                    id="endDelay"
                                                    className="form-control"
                                                    selected={this.state.from}
                                                    onChange={this.handleFromChange}
                                                    placeholderText="From e.g 2019-10-12"
                                                    showTimeSelect
                                                    timeFormat="HH:mm"
                                                    timeIntervals={15}
                                                    timeCaption="time"
                                                    dateFormat="yyyy-MM-dd h:mm aa"

                                                />
                                            </div>
                                        </div>


                                    </div>



                                    <br/>
                                    <div className="form-row text-center">
                                        <div className="col">
                                            <button type="submit" onClick={ this.handleSubmit } className="btn btn-primary">Set Delay</button>
                                        </div>

                                    </div>

                                    <Loader display={this.state.showloader} />

                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        );

    }
}

export default AlarmDelay;


