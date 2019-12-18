import React, {Component} from 'react';
import axios from 'axios/index';

class MessageCount extends Component {

    constructor(props) {
        super(props);
        this.state = {messagecount: ''};
        this.countMessages = this.countMessages.bind(this);
    }

    componentDidMount(){
        this.countMessages()
    }

    componentDidUpdate(){
        this.countMessages()
    }

    countMessages(){
        axios.get('messages')
            .then(response => {
                this.setState({ messagecount: response.data });

            })
            .catch(function (error) {
                console.log(error);
            })
    }
    render(){
        return(
            <small>{this.state.messagecount}</small>
        );
    }
}

export default MessageCount;
