import React, { Component } from 'react';
import EditCompany from './EditCompany';
import DeleteCompany from './DeleteCompany';
import AddDevice from '../devices/AddDevice';

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
    render() {
        return (
            <tr>
                <td>
                    {this.props.obj.name}
                </td>
                <td>
                    {this.props.obj.created_by}
                </td>
                <td>
                    <a href="#" data-toggle="modal"
                       data-target={`#add${this.props.obj.id}`}><i className="fas fa-plus text-success"></i>&nbsp;</a>
                    <AddDevice addId={`add${this.props.obj.id}`} params={this.props.obj} />
                </td>
                <td>
                    <a href="#" data-toggle="modal"
                       data-target={`#edit${this.state.params.id}`}><i className="fas fa-edit text-primary"></i></a>
                    <EditCompany editId={`edit${this.state.params.id}`} params={this.state.params} />
                </td>
                <td>
                    <a href="#" data-toggle="modal"
                       data-target={`#delete${this.props.obj.id}`}><i className="fas fa-trash-alt text-danger"></i></a>
                    <DeleteCompany deleteId={`delete${this.props.obj.id}`} params={this.props.obj} />
                </td>
            </tr>
        );
    }
}

export default TableRow;
