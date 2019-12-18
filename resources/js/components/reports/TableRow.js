import React, { Component } from 'react';

class TableRow extends Component {
    constructor(props){
        super(props);
        this.state = {params: props.obj, points: props.points};
        this.splitDate = this.splitDate.bind(this);
        this.tableBg = this.tableBg.bind(this);
    }

    /*static getDerivedStateFromProps(props, state) {
        return {
            params: props.obj,
        }
    }*/

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        return true;
    }

    splitDate(datetime){
        return datetime.split("T");

    }

    tableBg(minV, maxV){
        if(minV == 0 && maxV == 0){
            return "bg-success";
        }
        else if(minV == -1 || maxV == -1){
            return "bg-warning";
        }
        else{
            return "bg-danger";
        }
    }

    tabData = () => {
        if(this.state.params.dataSamples instanceof Array){


            return this.state.params.dataSamples.map(function(object, i) {

                let className = '';
                //const className = tableBg(object[this.props.points[0]+'minV'], object[this.props.points[0]+'maxV']);
                //if(object['temp1'] > object['temp1-minT'] && object['temp1'] < object['temp1-maxT']){

                if(object.temp1-minV == 0 && object.temp1-maxV == 0){
                    className = "bg-success";
                }
                else if(object.temp1-minV == -1 || object.temp1-maxV == -1){
                    className = "bg-warning";
                }
                else{
                    className = "bg-danger";
                }
                return <td className={className}><small> {object.temp1.toFixed(2)}</small></td>;



            })
        }
    }

    render() {
        return (

            <tr>
                <td className="text-sm-center text-black-50">
                    <b>Start Date</b>
                </td>
                { this.tabData.bind(this)}
                <td className="text-sm-center text-black-50">
                    <b>Date</b>
                </td>

            </tr>

        );
    }
}

export default TableRow;
