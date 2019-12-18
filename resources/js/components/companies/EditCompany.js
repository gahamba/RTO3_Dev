import React, {Component} from 'react';
import axios from 'axios/index';
import Loader from '../Loader';
import Alert from "../Alert";

class EditCompany extends Component {
    /**
     * Constructor
     * @param props
     */
    constructor(props){
        super(props);
        this.state = {
            name: this.props.params.name,
            description: this.props.params.description,
            panel_id: this.props.editId,
            showloader: 'd-none',
            alert:'',
            message: '',
            display:'d-none'
        };

        this.handleNameChange = this.handleNameChange.bind(this);
        this.handleDescriptionChange = this.handleDescriptionChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }
    /**
     * Handles change to name field
     * @param e
     */
    handleNameChange(e){
        this.setState({
            name: e.target.value
        })
    }

    /**
     * Handles change to description field
     * @param e
     */
    handleDescriptionChange(e){
        this.setState({
            description: e.target.value
        })
    }

    /**
     * Handles form submission
     * @param e
     */
    handleSubmit(e){
        this.setState({showloader: ''});
        e.preventDefault();
        const companies = {
            id : this.props.params.id,
            name: this.state.name,
            description: this.state.description,
        }
        let uri = 'http://localhost/rto3_demo1.0/public/companies/'+this.props.params.id;
        axios.patch(uri, companies)
            .then((response) => {

                alert(response.data);
                this.setState({showloader: 'd-none', alert:'success', message: response.data, display:''});
                //$('#edit'+this.props.params.id).modal('hide');
                //e.preventDefault();


            })
            .catch((response)=>{
                alert(JSON.stringify(response));
            });
    }

    render(){

        return(
            <div>

            <div className="modal fade" id={this.state.panel_id} tabIndex="-1" role="dialog"
                 aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div className="modal-dialog modal-lg">
                    <div className="modal-content">
                        <div className="card card-body">
                            <Alert alert={this.state.alert} display={this.state.display} message={this.state.message} />
                            <h4>Edit Company</h4>
                            <form onSubmit={this.handleSubmit}>
                                <div className="form-group">
                                    <label htmlFor="companyName"><i className="fas fa-building"></i>&nbsp;Company
                                        Name</label>
                                    <input type="text" className="form-control" id="companyName"
                                           aria-describedby="companyNameHelp" placeholder="Enter company name" value={this.state.name} onChange={this.handleNameChange} />

                                </div>

                                <div className="form-group">
                                    <label htmlFor="companyDescription"><i className="fas fa-info"></i>&nbsp;Company
                                        Description</label>
                                    <textarea className="form-control" id="companyDescription"
                                              aria-describedby="companyDescriptionHelp"
                                              placeholder="Enter company description" value={this.state.description || ''} onChange={this.handleDescriptionChange}>

                                        { this.state.description || '' }
                                    </textarea>
                                </div>

                                <button type="submit" className="btn btn-primary">Update</button>



                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        );

    }
}

export default EditCompany;


