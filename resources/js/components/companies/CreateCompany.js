import React, {Component} from 'react';
import axios from 'axios/index';
import { render } from 'react-dom';
import Loader from "../Loader";
import Alert from "../Alert";

class CreateCompany extends Component {
    /**
     * Constructor
     * @param props
     */
    constructor(props){
        super(props);
        this.state = {name: '', description: '', showloader:'d-none', alert:'', message:'', display:'d-none'};

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
            name: this.state.name,
            description: this.state.description,
        }
        let uri = 'http://localhost/rto3_demo1.0/public/companies';
        axios.post(uri, companies)
        .then((response) => {

            alert(response.data);

            //e.preventDefault();
            this.setState({description: '', name: '', showloader: 'd-none', alert:'success', message: response.data, display:''});


        })
        .catch((response)=>{
            alert(JSON.stringify(response));
            this.setState({alert: 'danger', message: response});
        });
    }

    /**
     * The componentDidMount() method is called after the component is rendered.
     */
    componentDidMount() {

        setTimeout(() => {
                //this.setState({description: '', name: ''})
                this.state = {name: '', description: '', showloader:'d-none', alert:'', message:'', display:'d-none'};
            }
            , 5000)
    }


    render() {
        return (
            <div>
                <p className="float-right">
                    <a className="btn contrast_component2" data-toggle="collapse" href="#createCompanyPanel" role="button"
                       aria-expanded="false" aria-controls="createCompanyPanel">
                        <i className="fas fa-plus-square"></i>&nbsp;Add Company
                    </a>
                </p>

                <div className="clearfix">&nbsp;</div>
                <div className="collapse" id="createCompanyPanel">
                    <div className="card card-body">
                        <Alert alert={this.state.alert} display={this.state.display} message={this.state.message} />
                        <h4>Create Company</h4>
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


                                </textarea>
                            </div>

                            <button type="submit" className="btn btn-primary">Create</button>

                            <Loader display={this.state.showloader} />


                        </form>

                    </div>
                </div>

                <div className="clearfix">&nbsp;</div>



            </div>
        )
    }
}
export default CreateCompany;
