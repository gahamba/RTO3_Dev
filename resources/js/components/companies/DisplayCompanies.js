import React, {Component} from 'react';
import axios from 'axios/index';
import TableRow from './TableRow';
import Loader from '../Loader';

class DisplayCompanies extends Component {
    constructor(props) {
        super(props);
        this.state = {companies: '', showloader: ''};
    }

    componentDidMount(){
        axios.get('http://localhost/rto3_demo1.0/public/companies')
            .then(response => {
                this.setState({ companies: response.data, showloader: 'd-none' });

            })
            .catch(function (error) {
                console.log(error);
            })
    }
    tabRow(){
        if(this.state.companies instanceof Array){
            return this.state.companies.map(function(object, i){
                return <TableRow obj={object} key={i} />;
            })
        }
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        return true;
    }

    componentDidUpdate(){
        //this.setState({showloader: this.state.showloader == 'd-none' ? '' : ''  });
        axios.get('http://localhost/rto3_demo1.0/public/companies')
            .then(response => {
                this.setState({ companies: response.data, showloader: 'd-none' });

            })
            .catch(function (error) {
                console.log(error);
            })
    }

    render(){
        return (
            <div>
                <div className="card card-body">
                    <Loader display={this.state.showloader} />
                    <h4>Companies</h4>
                    <table className="table table-striped w-100" align="center">
                        <thead>
                        <tr>
                            <td scope="col">Company Name</td>
                            <td scope="col">Created By</td>
                            <td scope="col">Add Device</td>
                            <td scope="col"></td>
                            <td scope="col"></td>
                        </tr>
                        </thead>

                        <tbody>

                        {this.tabRow()}

                        </tbody>

                    </table>


                </div>


            </div>
        )
    }
}
export default DisplayCompanies;
