import React, {Component} from 'react';
import { polyfill } from 'es6-promise'; polyfill();
import axios from 'axios';
import Loader from '../Loader';
import EachUser from "./EachUser";

class DisplayUsers extends Component{

    constructor(props) {
        super(props);
        const url ='http://localhost/RTO3_Users/public';
        this.state = {users: '', showloader: ''};
    }

    componentDidMount(){
        axios.get('users')
            .then(response => {
                this.setState({ users: response.data, showloader: 'd-none' });

            })
            .catch(function (error) {
                console.log(error);
            })
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        return true;
    }

    componentDidUpdate(){
        axios.get('users')
            .then(response => {
                this.setState({ users: response.data, showloader: 'd-none' });

            })
            .catch(function (error) {
                console.log(error);
            })
    }

    eachUser(){
        if(this.state.users instanceof Array){
            return this.state.users.map(function(object, i){
                return <EachUser obj={object} key={i} />;
            })
        }
    }

    render() {
        return (
            <div>

                <div className="card card-body">

                    <h4>Users</h4>

                    <div className="container-fluid">
                        <div className="row">

                            {this.eachUser()}


                        </div>


                    </div>

                </div>


            </div>

        );
    }

}

export default DisplayUsers
