import React, { Component } from 'react';
import EditDevice from './EditDevice';
import DeleteDevice from './DeleteDevice';

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
                    <a href="#" data-toggle="modal"
                       data-target={`#edit${this.state.params.id}`}><i className="fas fa-edit text-primary"></i></a>
                    <EditDevice editId={`edit${this.state.params.id}`}
                                params={this.state.params}
                                datapoints={this.state.params.datapoints}
                    />
                </td>
                <td>
                    <a href="#" data-toggle="modal"
                       data-target={`#delete${this.props.obj.id}`}><i className="fas fa-trash-alt text-danger"></i></a>
                    <DeleteDevice deleteId={`delete${this.props.obj.id}`} params={this.props.obj} />
                </td>
            </tr>
        );
    }
}

export default TableRow;
