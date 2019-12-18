import React, { Component } from 'react';

class Loader extends Component{
    constructor(props) {
        super(props);
        this.state = {display: ''};
    }
    static getDerivedStateFromProps(props, state){
        return {display: props.display };
    }
    render(){

        return (
            <div className={`text-center text-success ${this.props.display}`}>
                <div className="spinner-border" role="status">
                    <span className="sr-only">Loading...</span>
                </div>
                <p align="center"> Please wait... </p>
            </div>
        );
    }
}

export default Loader;
