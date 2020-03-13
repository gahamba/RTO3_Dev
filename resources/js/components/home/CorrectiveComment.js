import React, {Component} from 'react';
import { polyfill } from 'es6-promise'; polyfill();
import axios from 'axios';
import Loader from '../Loader';
import TableCorrectionRow from "./TableCorrectionRow";
import ErrorLineChart from './ErrorLineChart';
import Alert from "../Alert";

class CorrectiveComment extends Component {
    /**
     * Constructor
     * @param props
     */
    constructor(props){
        super(props);
        this.state = {
            corrections: '',
            actions: '',
            showloader: 'd-none',
            showtextarea: '',
            correction: '',
            alert: '',
            message: '',
            last_updated: '',
            display: 'd-none'};
        this.handleCorrectionChange = this.handleCorrectionChange.bind(this);
        this.handleActionChange = this.handleActionChange.bind(this);
        //this.fetchCorrections = this.fetchCorrections.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    componentDidMount(){
        this.fetchCorrections();
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        return true;
    }


    tabCorrectionRow(){
        if(this.state.corrections instanceof Array){
            return this.state.corrections.map(function(object, i){
                return <TableCorrectionRow obj={object} key={i} />;
            })
        }
    }


    fetchCorrections(){
        axios.get('fetchCorrections/'+this.props.params.device_id)
            .then(response => {
                this.setState({
                    corrections: response.data.corrections,
                    actions: response.data.actions,
                    showtextarea: response.data.textarea == true ? '':'d-none',
                    last_updated: response.data.last_updated,
                    showloader: 'd-none'
                });
                console.log(this.state.corrections);

            })
            .catch(function (error) {
                if (error.response) {
                    console.log(error.response.data);
                }

            })
    }

    /**
     * Handles change to correction dropdown
     * @param e
     */
    handleActionChange(e){
        this.setState({
            correction: e.target.value
        })
    }

    /**
     * Handles change to correction field
     * @param e
     */
    handleCorrectionChange(e){
        this.setState({
            correction: e.target.value
        })
    }

    /**
     * Handles form submission
     * @param e
     */
    handleSubmit(e){
        this.setState({showloader: ''});
        e.preventDefault();

        if(this.state.correction === ''){
            alert("You must select an action or enter one");
        }
        else{
            const corrections = {
                correction: this.state.correction,
                device_id: this.props.params.device_id,
                min: this.props.params.min_threshold,
                max: this.props.params.max_threshold,
                val: this.props.params.val

            }

            let uri = 'corrections';
            axios.post(uri, corrections)
                .then((response) => {

                    //alert(response.data);

                    //e.preventDefault();
                    this.setState({
                        correction: '',
                        showtextarea: 'd-none',
                        showloader: 'd-none',
                        last_updated: response.data.last_updated,
                        corrections: response.data.corrections,
                        alert: response.data.status === 0 ? 'success' : 'danger',
                        message: response.data.msg,
                        display:''
                    });



                })
                .catch((response)=>{
                    alert(JSON.stringify(response));
                    this.setState({alert: 'danger', message: response});
                });


        }

    }

    /*
    *Corrective actions dropdown
    */
    formOptions(){
        if(this.state.actions instanceof Array){
            return this.state.actions.map(function(object, i){

                return <option value={object.action} key={i}>{object.action}</option>;
            })
        }
    }

    render(){

        return(
            <div>

                <div className="modal fade" id={this.props.commentId} tabIndex="-1" role="dialog"
                     aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div className="modal-dialog modal-lg modal-full">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title"></h5>
                                <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" className="btn btn-danger">&times;</span>
                                </button>
                            </div>
                            <div className="card card-body">
                                <h4>Device: {this.props.params.name} ({this.props.params.unique_id})</h4>

                                <div className="container-fluid">

                                    <div className="row">

                                        <div className="container-fluid">
                                            <Alert alert={this.state.alert} display={this.state.display} message={this.state.message} />
                                            <h4>Corrective Action</h4>
                                            <form onSubmit={this.handleSubmit}>

                                                <div className="form-group">
                                                    <label htmlFor="deviceUniqueId"><i className="fas fa-clock"></i>&nbsp;
                                                        Last Update</label>

                                                    <div className="row">
                                                        <div className="col-sm">
                                                            { this.state.last_updated }
                                                        </div>



                                                    </div>

                                                </div>

                                                <div className={this.state.showtextarea}>



                                                    <div className="form-group">
                                                        <label htmlFor="correctiveactiondrop"><i className="fas fa-info"></i>&nbsp; Corrective Action Dropdown</label>
                                                        <select className="form-control"
                                                                id="correctiveactiondrop"
                                                                onChange={this.handleActionChange}>
                                                            <option>--Select Action from the dropdown below--</option>
                                                            { this.formOptions() }

                                                        </select>



                                                    </div>

                                                    <div className="form-group">
                                                        <h5 align="center" className="text-info">-OR-</h5>
                                                    </div>


                                                    <div className="form-group">
                                                        <label htmlFor="correctiveActionText">Please enter corrective action if none of the options above match the action carried out.</label>
                                                        <textarea className="form-control"
                                                                  aria-describedby="correctiveActionHelp"
                                                                  placeholder="Enter device description" value={this.state.correction || ''}
                                                                  onChange={this.handleCorrectionChange}>


                                                        </textarea>
                                                    </div>

                                                    <button type="submit" className="btn btn-primary" disabled={this.state.submitStatus}>Add</button>

                                                </div>


                                                <Loader display={this.state.showloader} />


                                            </form>

                                        </div>


                                    </div>



                                </div>

                                <br />
                                <br />


                                <div className="container-fluid">

                                    <div className="row">

                                        <div className="col-sm overflow-auto h-25">
                                            <Loader display={this.state.showloader} />
                                            <h6>Corrections</h6>
                                            <table className="table table-sm table-striped table-hover w-100" align="center">
                                                <thead>
                                                <tr>
                                                    <td scope="col">Actioned By</td>
                                                    <td scope="col">Correction</td>
                                                    <td scope="col">Date Time</td>
                                                    <td scope="col"></td>
                                                </tr>
                                                </thead>

                                                <tbody>

                                                {this.tabCorrectionRow()}

                                                </tbody>

                                            </table>

                                        </div>

                                    </div>
                                </div>

























                            </div>
                        </div>
                    </div>
                </div>

            </div>
        );

    }
}

export default CorrectiveComment;


