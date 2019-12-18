import React, {Component} from 'react';
import axios from 'axios/index';
import Loader from '../Loader';

class DeleteCompany extends Component {
    /**
     * Constructor
     * @param props
     */
    constructor(props){
        super(props);
        this.handleSubmit = this.handleSubmit.bind(this);
    }


    /**
     * Handles form submission
     * @param e
     */
    handleSubmit(e){
        e.preventDefault();
        const companies = {
            id : this.props.params.id,
            name: this.props.params.name,
            description: this.props.params.description,
        }
        let uri = 'http://localhost/rto3_demo1.0/public/companies/'+this.props.params.id;
        axios.delete(uri, companies)
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
                                    <input type="hidden" id="companyId" value={this.props.params.id} />


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

export default DeleteCompany;


