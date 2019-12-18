import React, { Component } from 'react';

class TableRow extends Component {
    constructor(props){
        super(props);
        this.state = {params: props.obj};
        //this.editPanel = this.editPanel.bind(this);
    }


    render() {
        return (
            <tr>

                <td>
                    {this.props.obj.reading}
                </td>
                <td>
                    {this.props.obj.dateTime}
                </td>

                <td>
                    <span className={`btn btn-sm btn-${this.props.obj.status}`}>&nbsp;&nbsp;</span>
                </td>

            </tr>
        );
    }
}

export default TableRow;
