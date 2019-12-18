import React, { Component } from 'react';

class TableCorrectionRow extends Component {
    constructor(props){
        super(props);
        this.state = {params: props.obj};
        //this.editPanel = this.editPanel.bind(this);
    }


    render() {
        return (
            <tr>

                <td>
                    {this.props.obj.user_name}
                </td>
                <td>
                    {this.props.obj.correction}
                </td>
                <td>
                    {this.props.obj.date+" "+this.props.obj.time}
                </td>


                <td>

                </td>

            </tr>
        );
    }
}

export default TableCorrectionRow;
