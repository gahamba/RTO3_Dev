import React, {Component} from 'react';
import { polyfill } from 'es6-promise'; polyfill();
import axios from 'axios';
import TableRow from './TableRow';
import Loader from '../Loader';

class DisplayDevices extends Component {
    constructor(props) {
        super(props);
        const url ='http://localhost/RTO3_Users/public';
        this.state = {devices: '', showloader: ''};
        this.fetchDevices = this.fetchDevices.bind(this);
    }

    componentDidMount(){
        this.fetchDevices();
    }

    tabRow(){
        if(this.state.devices instanceof Array){
            return this.state.devices.map(function(object, i){
                return <TableRow obj={object} key={i} />;
            })
        }
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        return true;
    }
    componentDidUpdate(){
        //this.setState({showloader: this.state.showloader == 'd-none' ? '' : ''  });
        this.fetchDevices();
    }

    fetchDevices(){
        axios.get('devices')
            .then(response => {
                this.setState({ devices: response.data, showloader: 'd-none' });

            })
            .catch(function (error) {
                if (error.response) {
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                }

            })
    }

    render(){
        return (
            <div>
                <div className="card card-body">
                    <Loader display={this.state.showloader} />
                    <h4>Devices</h4>
                    <table className="table table-striped table-hover w-100" align="center">
                        <thead>
                        <tr>
                            <td scope="col">Device</td>
                            <td scope="col">Unique Id</td>
                            <td scope="col">Created By</td>
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
export default DisplayDevices;
