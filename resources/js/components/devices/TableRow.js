import React, { Component } from 'react';
import EditDevice from './EditDevice';
import DeleteDevice from './DeleteDevice';
import AlarmDelay from './AlarmDelay';

class TableRow extends Component {
    constructor(props){
        super(props);
        this.state = {params: props.obj};
        //this.editPanel = this.editPanel.bind(this);
    }

    static getDerivedStateFromProps(props, state) {
        return {
            params: props.obj,
        }
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        return true;
    }

    alarmActive(){
        if(this.state.params.delay_active === "1"){
            return <span className="badge badge-success m-1"><i className="fas fa-check-circle text-white"></i></span>
        }
        else{
            return <span className="badge badge-warning m-1"><i className="fas fa-pause-circle text-white"></i></span>
        }
    }
    render() {
        return (
            <tr>
                <td>
                    {this.props.obj.name}
                </td>
                <td>
                    {this.props.obj.unique_id}
                </td>
                <td>
                    {this.props.obj.created_by}
                </td>
                <td>
                    <span className="row">

                        <span className="col">
                            <a href="#" data-toggle="modal"
                               data-target={`#alarm${this.props.obj.id}`}>
                                <div className="btn btn-sm btn-light">
                                <i className="fas fa-clock"></i> alarm delay
                                    { this.alarmActive() }
                               </div>
                            </a>
                            <AlarmDelay alarmId={`alarm${this.props.obj.id}`} params={this.props.obj} />
                        </span>

                        <span className="col">
                            <a href="#" data-toggle="modal"
                               data-target={`#edit${this.state.params.id}`}><i className="fas fa-edit text-primary"></i></a>
                            <EditDevice editId={`edit${this.state.params.id}`}
                                        params={this.state.params}
                                        datapoints={this.state.params.datapoints}
                            />
                        </span>

                        <span className="col">
                            <a href="#" data-toggle="modal"
                               data-target={`#delete${this.props.obj.id}`}><i className="fas fa-trash-alt text-danger"></i></a>
                            <DeleteDevice deleteId={`delete${this.props.obj.id}`} params={this.props.obj} />
                        </span>

                    </span>
                </td>

            </tr>
        );
    }
}

export default TableRow;
