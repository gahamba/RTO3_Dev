import React, {Component} from 'react';
import { polyfill } from 'es6-promise'; polyfill();
import axios from 'axios';
import Loader from '../Loader';

class DeleteDevice extends Component {
    /**
     * Constructor
     * @param props
     */
    constructor(props){
        super(props);
        const url ='http://localhost/RTO3_Users/public/';
        this.handleSubmit = this.handleSubmit.bind(this);
    }


    /**
     * Handles form submission
     * @param e
     */
    handleSubmit(e){
        e.preventDefault();
        const devices = {
            id : this.props.params.id,
            name: this.props.params.name,
            unique_id: this.props.params.unique_id,
            description: this.props.params.description,
        }
        let uri = 'devices/'+this.props.params.id;
        axios.delete(uri, devices)
            .then((response) => {

                $('#delete'+this.props.params.id).modal('hide');
                alert(response.data);

                //e.preventDefault();
            })
            .catch((response)=>{
                alert(JSON.stringify(response));
            });
    }

    render(){

        return(
            <div>

                <div className="modal fade" id={this.props.deleteId} tabIndex="-1" role="dialog"
                     aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div className="modal-dialog modal-lg">
                        <div className="modal-content">
                            <div className="card card-body">
                                <h4>Are you sure you want to delete { this.props.params.name }?</h4>
                                <form onSubmit={this.handleSubmit}>
                                    <input type="hidden" id="deviceId" value={this.props.params.id} />


                                    <button type="submit" className="btn btn-danger float-right">Delete</button>



                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        );

    }
}

export default DeleteDevice;


